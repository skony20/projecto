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
/**
 * Site controller
 */
class XmlController extends Controller
{
    /**
     * @inheritdoc
     */
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
    
    
    public function actionHoryzont()
    {
        
        $oDocument = new Response();
        $sXmlFile  = 'https://www.horyzont.com/baza-plikow/horyzont_03_2017.xml';
        $sXmlContent = file_get_contents($sXmlFile);
        $sXml = $oDocument->setContent($sXmlContent);
        $oParser = new XmlParser();
        $aHoryzont = $oParser->parse($sXml);
        $oProjekt = new Products();
        foreach ($aHoryzont['product'] as $aProject)
        {
            //echo '<pre>'. print_r($aProject, TRUE); die();
            $oExist = $oProjekt->findOne(['ean' => 'horyzont-'.$aProject->id_product]);
//            if (!$oExist)
//            {
            /*Dodanie produktu*/
                $sSymbol = $this->zamiana($aProject->name);
                $oProjekt->is_active = 0;
                $oProjekt->producers_id = 8;
                $oProjekt->vats_id = 3;
                $oProjekt->price_brutto_source = $aProject->price;
                $oProjekt->price_brutto = $aProject->price;
                $oProjekt->stock = 0;
                $oProjekt->creation_date=time();
                $oProjekt->symbol = $sSymbol;
                $oProjekt->ean = 'horyzont-'.$aProject->id_product;
                //$oProjekt->save();
            /*Dodanie opisów do produkty*/
                $iLastInsertID = 3172;//Yii::$app->db->getLastInsertID();
                $oProductsDesriptions = new ProductsDescripton();
                $oProductsDesriptions->products_id = $iLastInsertID;
                $oProductsDesriptions->languages_id = 1;
                $oProductsDesriptions->name = $aProject->name;
                $oProductsDesriptions->nicename_link = $sSymbol;
                $oProductsDesriptions->html_description = $aProject->description;
                //$oProductsDesriptions->save();
            
            /*Dane techniczne i filtry*/    
                
                
                foreach ($aProject->features->feature as $aFeatured)
                {
                    echo $aFeatured->name .'<br>'; 
                    switch ($aFeatured->name)
                    {
                        case 'Pow. użytkowa':
                            $this->addAttr($iLastInsertID, 4, $aFeatured->value);
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
                                $this->addFilter($iLastInsertID, $iPietroFltr);
                                $this->addAttr($iLastInsertID, 20, $iIloscPieter);
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
                                $this->addFilter($iLastInsertID, $iDachFltr);
                            }
                            break;
                        case 'Nachylenie dachu':
                            $this->addAttr($iLastInsertID, 8, $aFeatured->value);
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
                                $this->addFilter($iLastInsertID, $iGarazFltr);
                            }
                            break;
                        case 'Min. szerokość działki':
                            $this->addAttr($iLastInsertID, 6, $aFeatured->value);
                            break;
                        case 'Wysokość budynku';
                            $this->addAttr($iLastInsertID, 1, $aFeatured->value);
                            break;
                        case 'Pow. zabudowy':
                            $this->addAttr($iLastInsertID, 11, $aFeatured->value);
                            break;
                        case 'Ilość pokoi z salonem':
                            $this->addAttr($iLastInsertID, 9, $aFeatured->value);
                            break;
                        case 'Powierzchnia dachu':
                            $this->addAttr($iLastInsertID, 16, $aFeatured->value);
                            break;
                    }
                }

                
                
                die(); 
                    

                
             
            //}
        
        }
        
    }


}