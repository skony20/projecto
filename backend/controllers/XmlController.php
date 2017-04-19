<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\httpclient\XmlParser;
use yii\httpclient\Response;
use app\models\Products;
use app\models\ProductsDescripton;
use app\models\ProductsAttributes;
use app\models\ProductsFilters;
use app\models\ProductsImages;
use yii\imagine\Image;
/**
 * Site controller
 */
class XmlController extends Controller
{
    /**
     * @inheritdoc
    */
    public $iImageThumb = 80;
    public $iImageInfo = 300;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['horyzont'],
                        'allow' => true,
                    ],
                    
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    private function zamiana($string)
    {
         $polskie = array(',', ' - ',' ','ę', 'Ę', 'ó', 'Ó', 'Ą', 'ą', 'Ś', 'ś', 'ł', 'Ł', 'ż', 'Ż', 'Ź', 'ź', 'ć', 'Ć', 'ń', 'Ń','-',"'","/","?", '"', ":", '!','.', '&', '&amp;', '#', ';', '[',']', '(', ')', '`', '%', '”', '„', '…');
         $miedzyn = array('-','-','-','e', 'e', 'o', 'o', 'a', 'a', 's', 's', 'l', 'l', 'z', 'z', 'z', 'z', 'c', 'c', 'n', 'n','-',"","","","","",'','', '', '', '', '', '', '', '', '', '', '', '');
         $string = str_replace($polskie, $miedzyn, $string);
         $string = strtolower($string);
         // usuń wszytko co jest niedozwolonym znakiem
         $string = preg_replace('/[^0-9a-z\-]+/', '', $string);
         // zredukuj liczbę myślników do jednego obok siebie
         $string = preg_replace('/[\-]+/', '-', $string);
         // usuwamy możliwe myślniki na początku i końcu
         $string = trim($string, '-');
         $string = stripslashes($string);
         // na wszelki wypadek
         $string = urlencode($string);

         return $string;
    }
    
    
    /* Funcje zapisująsa atrybuty*/
    private function addAttr($p_PrdId, $p_AttrId, $p_Value)
    {
        $iPrdId = ((int)($p_PrdId));
        $iAttrId = ((int)($p_AttrId));
        $sValue = $p_Value;
        $oAttr = new ProductsAttributes();
        $oAttrExist = $oAttr->findOne(['products_id'=>$iPrdId, 'attributes_id'=>$iAttrId]);
        if (!$oAttrExist)
        {
            $oAttr->products_id = $iPrdId;
            $oAttr->attributes_id = $iAttrId;
            $oAttr->value = $sValue;
            $oAttr->save(false);
        }

        
    }
    /* Funcje zapisująsa filtry*/
    private function addFilter($p_PrdId, $p_FltId)
    {
        $iPrdId = ((int)($p_PrdId));
        $iFltId = ((int)($p_FltId));
        $oFltr = new ProductsFilters();
        $aFltrExist = $oFltr->findOne(['products_id'=> $iPrdId,  'filters_id'=>$iFltId]);
        if (!$aFltrExist)
        {
            $oFltr->products_id = $iPrdId;
            $oFltr->filters_id = $iFltId;
            $oFltr->save(false);
        }
        
    }
    private function addImage ($p_iPrdId, $p_sName, $p_sDesc, $p_iType)
    {
        $iPrdId = ((int)($p_iPrdId));
        $sName = $p_sName;
        $sDesc = $p_sDesc;
        $iType = ((int)($p_iType));
        $oPrdImage = new ProductsImages();
        $oPrdImage->products_id = $iPrdId;
        $oPrdImage->name = $sName;
        $oPrdImage->description = $sDesc;
        $oPrdImage->image_type_id = $iType;
        $oPrdImage->save();
    }
    
    private function saveImage($p_sOrginal, $p_iPrdId, $p_sName)
    {
        $sOrginal = $p_sOrginal;
        $iPrdId = $p_iPrdId;
        $sName = $p_sName;
        $sPatch = Yii::getAlias('@images');
        
        $oImage = new Image();
        
        $sBigPatch = $sPatch.'/'.$iPrdId.'/big/';
        $sInfoPatch = $sPatch.'/'.$iPrdId.'/info/';
        $sThumbPatch = $sPatch.'/'.$iPrdId.'/thumbs/';
        
        if (!file_exists($sPatch.'/'.$iPrdId))
        {
            mkdir($sPatch.'/'.$iPrdId, 0777);
            mkdir($sPatch.'/'.$iPrdId.'/thumbs', 0777);    
            mkdir($sPatch.'/'.$iPrdId.'/big', 0777);
            mkdir($sPatch.'/'.$iPrdId.'/info', 0777);
        }
        
        copy($sOrginal, $sBigPatch.$sName);
        $aImageSixe =getimagesize($sBigPatch.$sName); 
        if ($aImageSixe[0] >= $aImageSixe[1])
        {
            $iWidthThumbSize = $aImageSixe[0]/($aImageSixe[0]/$this->iImageThumb);
            $iHeightThumbSize = ceil($aImageSixe[1]/($aImageSixe[0]/$this->iImageThumb));
            $iWidthInfoSize = $aImageSixe[0]/($aImageSixe[0]/$this->iImageInfo);
            $iHeightInfoSize = ceil($aImageSixe[1]/($aImageSixe[0]/$this->iImageInfo));
        }
        else 
        {   
            $iWidthThumbSize = $aImageSixe[0]/($aImageSixe[1]/$this->iImageThumb);
            $iHeightThumbSize = ceil($aImageSixe[1]/($aImageSixe[1]/$this->iImageThumb));
            $iWidthInfoSize = $aImageSixe[0]/($aImageSixe[1]/$this->iImageInfo);
            $iHeightInfoSize = ceil($aImageSixe[1]/($aImageSixe[1]/$this->iImageInfo));
        }
        
        $oImage->thumbnail($sBigPatch.$sName, $iWidthThumbSize, $iHeightThumbSize)->save($sThumbPatch.$sName);
        $oImage->thumbnail($sBigPatch.$sName, $iWidthInfoSize, $iHeightInfoSize)->save($sInfoPatch.$sName);
        
    }
    public function actionHoryzont()
    {
        
        $oDocument = new Response();
        $sXmlFile  = 'https://www.horyzont.com/baza-plikow/horyzont_03_2017.xml';
        $sXmlContent = file_get_contents($sXmlFile);
        $sXml = $oDocument->setContent($sXmlContent);
        $oParser = new XmlParser();
        $aHoryzont = $oParser->parse($sXml);
        
        foreach ($aHoryzont['product'] as $aProject)
        {
            
            if (substr_count(strtolower($aProject->name), 'kosztorys') <1)
            {
            if(substr_count(strtolower($aProject->name), 'pompa ciepła') <1)
            {
            if(substr_count(strtolower($aProject->name), 'instalacja solarna') <1)
            {
                $oProjekt = new Products();
                //echo '<pre>'. print_r($aProject, TRUE); die();
                $oExist = $oProjekt->findOne(['ean' => 'horyzont-'.$aProject->id_product]);
                //echo print_r($oExist, TRUE); die();
                if (!$oExist)
                {
                /*Dodanie produktu*/
                    $sSymbol = $this->zamiana($aProject->name);
                    $oProjekt->is_active = 0;
                    $oProjekt->producers_id = 8;
                    $oProjekt->vats_id = 3;
                    $oProjekt->price_brutto_source = $aProject->price;
                    $oProjekt->price_brutto = $aProject->price;
                    $oProjekt->stock = 99;
                    $oProjekt->creation_date=time();
                    $oProjekt->symbol = 'horyzont-'.$aProject->id_product;
                    $oProjekt->ean = 'horyzont-'.$aProject->id_product;
                    $oProjekt->save(false);
                /*Dodanie opisów do produkty*/
                    $iActualProductId = Yii::$app->db->getLastInsertID();
                    echo  $sSymbol . ' -- '.$iActualProductId .'<br>'; 
                    $oProductsDesriptions = new ProductsDescripton();
                    $oProductsDesriptions->products_id = $iActualProductId;
                    $oProductsDesriptions->languages_id = 1;
                    $oProductsDesriptions->name = $aProject->name;
                    $oProductsDesriptions->nicename_link = $sSymbol;
                    $oProductsDesriptions->html_description = $aProject->description;
                    $oProductsDesriptions->save(false);

                /*Dane techniczne i filtry*/    


                    foreach ($aProject->features->feature as $aFeatured)
                    {
                        switch ($aFeatured->name)
                        {
                            case 'Pow. użytkowa':
                                $this->addAttr($iActualProductId, 4, $aFeatured->value);
                                break;
                            case 'Typ domu';
                                switch ($aFeatured->value)
                                {
                                    case 'z poddaszem':
                                        $iPietroFltr = 18;
                                        $iIloscPieter = 2;
                                        break;
                                    case 'z poddaszem do adaptacji':
                                        $iPietroFltr = 18;
                                        $iIloscPieter = 2;
                                        break;
                                    case 'parterowy':
                                        $iPietroFltr = 17;
                                        $iIloscPieter = 1;
                                        break;
                                    case 'piętrowy':
                                        $iPietroFltr = 19;
                                        $iIloscPieter = 2;
                                        break;
                                    default:
                                        $iPietroFltr = 0;
                                        $iIloscPieter = 0;
                                }
                                if ($iPietroFltr != 0 )
                                {
                                    $this->addFilter($iActualProductId, $iPietroFltr);
                                    $this->addAttr($iActualProductId, 20, $iIloscPieter);
                                }
                                break;
                            case 'Typ dachu':
                                switch ($aFeatured->value)
                                {
                                    case 'dwuspadowy':
                                        $iDachFltr = 22;
                                        break;
                                    case 'wielospadowy':
                                        $iDachFltr = 23;
                                        break;
                                    case 'płaski':
                                        $iDachFltr = 44;
                                        break;
                                    default:
                                        $iDachFltr = 0;
                                }
                                if ($iDachFltr != 0 )
                                {
                                    $this->addFilter($iActualProductId, $iDachFltr);
                                }
                                break;
                            case 'Nachylenie dachu':
                                $this->addAttr($iActualProductId, 8, $aFeatured->value);
                                break;
                            case 'Garaż':  
                                switch ($aFeatured->value)
                                {
                                    case '1 auto':
                                        $iGarazFltr = 24;
                                        break;
                                    case '2 auta':
                                    case '3 auta i więcej':
                                        $iGarazFltr = 25;
                                        break;
                                    case 'brak':
                                        $iGarazFltr = 40;
                                        break;
                                    case 'wiata':
                                    case '1 auto + wiata':
                                        $iGarazFltr = 45;
                                        break;
                                    default:
                                        $iGarazFltr = 0;
                                }
                                if ($iGarazFltr != 0 )
                                {
                                    $this->addFilter($iActualProductId, $iGarazFltr);
                                }
                                break;
                            case 'Min. szerokość działki':
                                $this->addAttr($iActualProductId, 6, $aFeatured->value);
                                break;
                            case 'Wysokość budynku';
                                $this->addAttr($iActualProductId, 1, $aFeatured->value);
                                break;
                            case 'Pow. zabudowy':
                                $this->addAttr($iActualProductId, 11, $aFeatured->value);
                                break;
                            case 'Ilość pokoi z salonem':
                                $this->addAttr($iActualProductId, 9, $aFeatured->value);
                                break;
                            case 'Powierzchnia dachu':
                                $this->addAttr($iActualProductId, 16, $aFeatured->value);
                                break;
                            case 'Rodzaj kotłowni':
                                switch ($aFeatured->value)
                                {
                                    case 'gazowa':
                                        $iOgrzewanieFltr = 31;
                                        break;
                                    case 'na paliwo stałe':
                                        $iOgrzewanieFltr = 30;
                                        break;
                                    default:
                                        $iOgrzewanieFltr = 0;
                                }
                                if ($iOgrzewanieFltr != 0 )
                                {
                                    $this->addFilter($iActualProductId, $iOgrzewanieFltr);
                                }
                                break;
                            case 'Autor projektu':
                                $oAuthor = new \app\models\Author();
                                $aAuthortExist = $oAuthor->findOne(['products_id'=> $iActualProductId]);
                                    if (!$aAuthortExist)
                                    {
                                        $oAuthor->products_id = $iActualProductId;
                                        $oAuthor->name = $aFeatured->value;
                                        $oAuthor->save(false);
                                    }

                                break;
                            case 'Podpiwniczenie':

                                switch ($aFeatured->value)
                                {
                                    case 'Nie':
                                        $iPiwnicaFltr = 39;
                                        break;
                                    case 'Tak':
                                        $iPiwnicaFltr = 20;
                                        break;
                                    default:
                                        $iPiwnicaFltr = 0;
                                }
                                if ($iPiwnicaFltr != 0 )
                                {
                                    $this->addFilter($iActualProductId, $iPiwnicaFltr);
                                }
                                break;
                        }
                    }
            /*OBRAZKI*/
                $a = 0;

                if (isset($aProject->attributes->attribute))
                {
                    foreach ($aProject->attributes->attribute as $aAtributes)
                    {

                        switch ($aAtributes->name)
                        {
                            case 'Wersja podstawowa':
                                $iImgType = 1;
                                $sDescPart3 = '';
                                break;
                            case 'Lustro':
                                $iImgType = 1;
                                $sDescPart3 = 'Odbicie lustrzane - ';
                                break;
                        }
                        foreach ($aAtributes->images->image as $aImage)
                        {

                            switch ($aImage->type)
                            {
                                case 'wizualizacje':
                                    $iImgType = 1;
                                    $sDescPart1 = 'Wizualizacja';
                                    break;
                                case 'elewacje':
                                    $iImgType = 2;
                                    $sDescPart1 = 'Elewacja';
                                    break;
                                case 'rzuty':
                                    $iImgType =3;
                                    $sDescPart1 = 'Rzut';
                                    break;
                                case 'przekroje':
                                    $iImgType =3;
                                    $sDescPart1 = 'Przekrój';
                                    break;
                                case 'sytuacja':
                                    $iImgType = 5;
                                    $sDescPart1 = 'Usytuowanie na działce';
                                    break;
                                case 'realizacje':
                                    $iImgType = 4;
                                    $sDescPart1 = 'Realizacja';
                                    break;
                                case 'wnetrza':
                                    $iImgType = 6;
                                    $sDescPart1 = 'Wnetrze';
                                    break;
                            }
                                $extension = strtolower(strrchr($aImage->url, '.'));;
                                $sName = $sSymbol.'_'.$a.''.$extension;
                                $sDesc = $sDescPart3 .$sDescPart1;
                                $this->addImage($iActualProductId, $sName, $sDesc, $iImgType);
                                /*Zapisywanie obrazków*/
                                $this->saveImage($aImage->url, $iActualProductId, $sName);
                                $a++;
                            }

                        }
                    }
                    else
                    {
                        foreach ($aProject->images->image as $aImage)
                        {

                            switch ($aImage->type)
                            {
                                case 'wizualizacje':
                                    $iImgType = 1;
                                    $sDescPart1 = 'Wizualizacja';
                                    break;
                                case 'elewacje':
                                    $iImgType = 2;
                                    $sDescPart1 = 'Elewacja';
                                    break;
                                case 'rzuty':
                                    $iImgType =3;
                                    $sDescPart1 = 'Rzut';
                                    break;
                                case 'przekroje':
                                    $iImgType =3;
                                    $sDescPart1 = 'Przekrój';
                                    break;
                                case 'sytuacja':
                                    $iImgType = 5;
                                    $sDescPart1 = 'Usytuowanie na działce';
                                    break;
                                case 'realizacje':
                                    $iImgType = 4;
                                    $sDescPart1 = 'Realizacja';
                                    break;
                                case 'wnetrza':
                                    $iImgType = 6;
                                    $sDescPart1 = 'Wnetrze';
                                    break;
                            }
                                $extension = strtolower(strrchr($aImage->url, '.'));;
                                $sName = $sSymbol.'_'.$a.''.$extension;
                                $sDesc = $sDescPart3 .$sDescPart1;
                                $this->addImage($iActualProductId, $sName, $sDesc, $iImgType);
                                /*Zapisywanie obrazków*/
                                $this->saveImage($aImage->url, $iActualProductId, $sName);
                                $a++;
                            }
                    }
                }
            }
            }
            }
        }

    }
}