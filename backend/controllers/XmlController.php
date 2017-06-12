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
use app\models\Upload;
use yii\web\UploadedFile;
use yii\imagine\Image;
use app\models\Storeys;
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
                        'actions' => ['proarte', 'domprojekt', 'horyzont', 'mgprojekt', 'images', 'rzut', 'pietra', 'export', 'import'],
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
         $miedzyn = array('-','-','-','e', 'e', 'o', 'o', 'a', 'a', 's', 's', 'l', 'ly', 'z', 'z', 'z', 'z', 'c', 'c', 'n', 'n','-',"","","","","",'','', '', '', '', '', '', '', '', '', '', '', '');
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
        $oPrdImage->save(false);
    }
    
    private function saveImage($p_sOrginal, $p_iPrdId, $p_sName)
    {
        $sOrginal = $p_sOrginal;
        $iPrdId = $p_iPrdId;
        $sName = $p_sName;
        $sPatch = Yii::getAlias('@images');
        
        $oImage = new Image();
        
        $sPatch = Yii::getAlias('@images');
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
        
        $oImage->thumbnail($sBigPatch.$sName, $iWidthThumbSize, $iHeightThumbSize)->save($sThumbPatch.$sName, ['quality' => 90]);
        $oImage->thumbnail($sBigPatch.$sName, $iWidthInfoSize, $iHeightInfoSize)->save($sInfoPatch.$sName, ['quality' => 90]);
        
    }
    private function checkSymbol($p_sSymbol) 
    {
        $oProduct = new ProductsDescripton();
        $aProduct = $oProduct->findAll(['nicename_link'=>$p_sSymbol]);
        if (count($aProduct) > 0 )
        {
            return TRUE;
        }
        return FALSE;
    }
    private function cut($tekst,$ile)
        {
 
        $tekst = strip_tags($tekst);
           if (strlen($tekst) > $ile) 
           {
                $tekst=substr($tekst, 0, $ile);
                for ($a=strlen($tekst)-1;$a>=0;$a--) 
                {
                   if ($tekst[$a]==" ") 
                    {
                        $tekst=substr($tekst, 0, $a)."...";
                        break;
                    };
                };
           };

        return $tekst;
        }
    /*Import xml-a ProArte*/ 
    public function actionProarte()
    {
        $oDocument = new Response();
        $sXmlFile  = 'http://www.pro-arte.pl/proarte.xml';
        $sXmlContent = file_get_contents($sXmlFile);
        $sXml = $oDocument->setContent($sXmlContent);
        $oParser = new XmlParser();
        $aProarte = $oParser->parse($sXml);
        foreach ($aProarte['Projekt'] as $aProject)
        {
            if ($aProject->Rodzaj == 1)
            {
                $oProjekt = new Products();
                $oExist = $oProjekt->findOne(['ean' => $aProject->Symbol]);
                if (!$oExist)
                {
                    /*Dodanie produktu*/
                    $sSymbol = $this->zamiana($aProject->Nazwa);
                    $sSymbol = ($this->checkSymbol($sSymbol) ? $sSymbol.'-proarte' :$sSymbol);
                    $oProjekt->is_active = 0;
                    $oProjekt->producers_id = 3;
                    $oProjekt->vats_id = 3;
                    $oProjekt->price_brutto_source = $aProject->Cena;
                    $oProjekt->price_brutto = $aProject->Cena;
                    $oProjekt->stock = 99;
                    $oProjekt->creation_date=time();
                    $oProjekt->symbol = $aProject->Symbol;
                    $oProjekt->ean = $aProject->Symbol;
                    $oProjekt->save(false);
                /*Dodanie opisów do produkty*/
                    $iActualProductId = Yii::$app->db->getLastInsertID();
                    $oProductsDesriptions = new ProductsDescripton();
                    $oProductsDesriptions->products_id = $iActualProductId;
                    $oProductsDesriptions->languages_id = 1;
                    $oProductsDesriptions->name = $aProject->Nazwa;
                    $oProductsDesriptions->nicename_link = $sSymbol;
                    $oProductsDesriptions->html_description = strip_tags($aProject->Opis_projektu, '<br />'). "<br>Technologia:<br>".strip_tags($aProject->Technologia_opis, '<br />');
                    $oProductsDesriptions->save(false);
                    

                /*Dane techniczne i filtry*/    
                    (isset($aProject->Wysokosc_budynku) ? $this->addAttr($iActualProductId, 1, $aProject->Wysokosc_budynku) :'');
                    (isset($aProject->Pow_uzytkowa) ? $this->addAttr($iActualProductId, 4, $aProject->Pow_uzytkowa) :'');
                    (isset($aProject->Dzialka_min_szerokosc) ? $this->addAttr($iActualProductId, 6, $aProject->Dzialka_min_szerokosc) :'');
                    (isset($aProject->Dzialka_min_dlugosc ) ? $this->addAttr($iActualProductId, 7, $aProject->Dzialka_min_dlugosc ) :'');
                    (isset($aProject->Kat_dachu1 ) ? $this->addAttr($iActualProductId, 8, $aProject->Kat_dachu1 ) :'');
                    (isset($aProject->Liczba_pokoi ) ? $this->addAttr($iActualProductId, 9, $aProject->Liczba_pokoi ) :'');
                    (isset($aProject->Pow_zabudowy ) ? $this->addAttr($iActualProductId, 11, $aProject->Pow_zabudowy ) :'');
                    (isset($aProject->Kubatura ) ? $this->addAttr($iActualProductId, 15, $aProject->Kubatura ) :'');
                    
                    
                    $iBasement = '';
                    switch ($aProject->Piwnica)
                    {
                        case 0:
                            $iBasement = 39;
                            break;
                        case 1:
                            $iBasement = 20;
                            break;
                    }
                    ($iBasement != '' ? $this->addFilter($iActualProductId, $iBasement) : '');
                    $iGaraz = '';
                    switch ($aProject->Garaz)
                    {
                        case 0:
                            $iGaraz = 40;
                            break;
                        case 1:
                            switch ($aProject->Dom_ile_garaz_stanowisk)
                            {
                                case 1:
                                    $iGaraz = 24;
                                    break;
                                case 2:
                                    $iGaraz = 25;
                                    break;
                            }
                            break;
                    }
                    ($iGaraz != '' ? $this->addFilter($iActualProductId, $iGaraz) : '');
                    $iDach = '';
                    switch ($aProject->Dach_rodzaj)
                    {
                        case 1:
                            $iDach = 44;
                            break;
                        case 3:
                            $iDach = 22;
                            break;
                        case 4:
                        case 5:
                            $iDach = 23;
                            break;       
                    }
                    ($iDach != '' ? $this->addFilter($iActualProductId, $iDach) : '');
                
                    $a=0;
                    /*Wizaulizacje*/
                    foreach ($aProject->Wizualizacje->Wiz as $aWizualizacje)
                    {
                        $sWizLink = str_replace(['x=500&', 'maxy=367&'], ['',''], $aWizualizacje->Url[0]);
                        $WizTitle = (isset($aWizualizacje->Tytul) ? $aWizualizacje->Tytul : '');
                        $sName = $sSymbol.'_'.$a.'.jpg';
                        $sDesc = 'Wizualizacja ';
                        $iImgType = 1;
                        $this->addImage($iActualProductId, $sName, $sDesc, $iImgType);
                        /*Zapisywanie obrazków*/
                        $this->saveImage($sWizLink , $iActualProductId, $sName);
                        $a++;
                    }
                    /*Rzuty*/
                   foreach ($aProject->Images->Img as $aImages)
                   {
                        $sImgLink = str_replace(['x=500&', 'maxy=367&'], ['',''], $aImages->Url[0]);
                        $ImagesTitle = (isset($aImages->Tytul) ? $aImages->Tytul : 'Rzut');
			$sName = $sSymbol.'_'.$a.'.jpg';
                        $a++;
                        $iImgType = 3;
                        $this->addImage($iActualProductId, $sName, $ImagesTitle, $iImgType);
                        $this->saveImage($sImgLink , $iActualProductId, $sName);
                        switch ($aImages->Tytul)
                        {
                            case "Piwnica":
                                    $sStoreyType = 0;
                                    break;
                            case "piwnica":
                                    $sStoreyType = 0;
                                    break;
                            case "rzut piwnicy":
                                    $sStoreyType = 0;
                                    break;
                            case "rzut piwnicy":
                                    $sStoreyType = 0;
                                    break;
                            case "Parter":
                                    $sStoreyType = 1;
                                    break;
                            case "parter":
                                    $sStoreyType = 1;
                                    break;
                            case "Rzut parteru":
                                    $sStoreyType = 1;
                                    break;
                            case "rzut parteru":
                                    $sStoreyType = 1;
                                    break;
                            case "Segment A - parter":
                                    $sStoreyType = 1;
                                    break;
                            case "Poddasze":
                                    $sStoreyType = 2;
                                    break;
                            case "Rzut poddasza":
                                    $sStoreyType = 2;
                                    break;
                            case "rzut poddasza":
                                    $sStoreyType = 2;
                                    break;
                            case "Segment A - poddasze":
                                    $sStoreyType = 2;
                                    break;
                            case "Rzut przyziemia":
                                    $sStoreyType = 1;
                                    break;
                        }
                        if (isset($aImages->Elements->Element))
                        {
                            foreach ($aImages->Elements->Element as $aRooms)
                            {
                                $oStorey = new Storeys();
                                $oStorey->products_id = $iActualProductId;
                                $oStorey->storey_type = $sStoreyType;
                                $oStorey->storey_name = ($aImages->Tytul ? $aImages->Tytul : '');
                                $oStorey->room_name = ($aRooms->Tytul ? $aRooms->Tytul : '');
                                $oStorey->room_area = ($aRooms->Powierzchnia ? $aRooms->Powierzchnia : '');
                                $oStorey->room_number = ($aRooms->Numer != "" ? str_replace('.', '', $aRooms->Numer): '');
                                $oStorey->save(false);
                            }
                        }
                        
                    }
                    foreach ($aProject->Elewacje->Elewacja as $aElewacje)
                    {

                        $sElewacjeLink = str_replace(['x=500&', 'maxy=367&'], ['',''], $aElewacje->Url[0]);
                        $sElewacjeTitle = (isset($aElewacje->Tytul) ? $aElewacje->Tytul : 'Elewacja');
                        $sName = $sSymbol.'_'.$a.'.jpg';
                        $a++;
                        $sDesc = $sElewacjeTitle;
                        $iImgType = 2;
                        $this->addImage($iActualProductId, $sName, $sDesc, $iImgType);
                        $this->saveImage($sElewacjeLink , $iActualProductId, $sName);

                    }
                }
            }
        }
    }
    /*Import xml-a Dom-Projekt*/
    public function actionDomprojekt()
    {
        $oDocument = new Response();
        $sXmlFile  = 'http://dom-projekt.pl/xml/generator.xml.php';
        $sXmlContent = file_get_contents($sXmlFile);
        $sXml = $oDocument->setContent($sXmlContent);
        $oParser = new XmlParser();
        $aDomProjekt = $oParser->parse($sXml);
        
        foreach ($aDomProjekt['projekt'] as $aProject)
        {
            if ($aProject->rodzaj == 0)
            {
                $iVatId = 1;
                switch ($aProject->vat)
                {
                    case 23:
                        $iVatId = 1;
                        break;
                    case 8:
                        $iVatId = 2;
                        break;
                    case 5:
                        $iVatId = 3;
                        break;
                    case 0:
                        $iVatId = 4;
                        break;
                }
                $oProjekt = new Products();
                $oExist = $oProjekt->findOne(['ean' => 'dp'.$aProject->id]);
                if (!$oExist)
                {
                    $oProjekt = new Products();
                    $sSymbol = $this->zamiana($aProject->nazwa);
                    $sSymbol = ($this->checkSymbol($sSymbol) ? $sSymbol.'-dom-projekt' :$sSymbol);
                    $oProjekt->is_active = 0;
                    $oProjekt->producers_id = 6;
                    $oProjekt->vats_id = $iVatId;
                    $oProjekt->price_brutto_source = $aProject->cena;
                    $oProjekt->price_brutto = $aProject->cena;
                    $oProjekt->stock = 99;
                    $oProjekt->creation_date=time();
                    $oProjekt->symbol = $sSymbol;
                    $oProjekt->ean = 'dp'.$aProject->id;
                    $oProjekt->save(false);
                /*Dodanie opisów do produkty*/
                    $iActualProductId = Yii::$app->db->getLastInsertID();
                    $oProductsDesriptions = new ProductsDescripton();
                    $oProductsDesriptions->products_id = $iActualProductId;
                    $oProductsDesriptions->languages_id = 1;
                    $oProductsDesriptions->name = ucfirst($aProject->nazwa);
                    $oProductsDesriptions->nicename_link = $sSymbol;
                    $oProductsDesriptions->html_description = $aProject->opis_pelny;
                    $oProductsDesriptions->html_description_short = $aProject->opis_krotki;
                    $oProductsDesriptions->meta_description = $this->cut($aProject->opis_krotki, 150);
                    $oProductsDesriptions->meta_title = 'Projekt - '. ucfirst($aProject->nazwa);
                    $oProductsDesriptions->save(false);
                
                /*Dane techniczne i filtry*/
                    ($aProject->powierzchnia->uzytkowa !='' ? $this->addAttr($iActualProductId, 4, $aProject->powierzchnia->uzytkowa) : '');
                    ($aProject->powierzchnia->garaz !='' ? $this->addAttr($iActualProductId, 5, $aProject->powierzchnia->garaz) : '');
                    ($aProject->dzialka->min_szerokosc_dzialki !='' ? $this->addAttr($iActualProductId, 6, $aProject->dzialka->min_szerokosc_dzialki) : '');
                    ($aProject->dzialka->min_dlugosc_dzialki !='' ? $this->addAttr($iActualProductId, 7, $aProject->dzialka->min_szerokosc_dzialki) : '');
                    ($aProject->dach->kat !='' ? $this->addAttr($iActualProductId, 8, $aProject->dach->kat) : '');
                    ($aProject->powierzchnia->netto !='' ? $this->addAttr($iActualProductId, 10, $aProject->powierzchnia->netto) : '');
                    ($aProject->kubatura !='' ? $this->addAttr($iActualProductId, 15, $aProject->kubatura) : '');
                    ($aProject->dach->dach_powierzchnia !='' ? $this->addAttr($iActualProductId, 16, $aProject->dach->dach_powierzchnia) : '');
                    /*Ilość kondygnacji*/
                    $iType = '';
                    switch ($aProject->poddasze)
                    {
                        case 0:
                            $iType = 17;
                            break;
                        case 1:
                        case 2:
                            $iType = 18;
                            break;
                    }
                    ($iType !== '' ? $this->addFilter($iActualProductId, $iType) : '');   
                    /*Podpiwniczenie*/
                    $iBasement = '';
                    switch ($aProject->piwnica)
                    {
                        case 0:
                            $iBasement = 39;
                            break;
                        case 1:
                            $iBasement = 21;
                            break;
                        case 2:
                            $iBasement = 20;
                            break;
                    }
                    ($iBasement !== '' ? $this->addFilter($iActualProductId, $iBasement) : '');
                    /*Typ dachu*/
                    $iRoof = 44;
                    switch ($aProject->dach->rodzaj_dachu)
                    {
                        case 0:
                            $iRoof = 45;
                            break;
                        case 1:
                            $iRoof = 22;
                            break;
                        case 2:
                            $iRoof = 23;
                            break;
                        case 3:
                            $iRoof = 42;
                            break;
                        case 4:
                            $iRoof = 44;
                            break;
                    }
                    ($iRoof !== '' ? $this->addFilter($iActualProductId, $iRoof) : '');
                    /*Garaż*/
                    $iGarage = 40;
        
                    switch ($aProject->garaz)
                    {
                        case 0:
                            $iGarage = 40;
                            break;
                        case 1:
                            $iGarage = 24;
                            break;
                        case 2:
                            $iGarage = 25;
                            break;
                        case 4:
                            $iGarage = 45;
                            break;
                    }
                    ($iGarage !== '' ? $this->addFilter($iActualProductId, $iGarage) : '');
                    
                    /*Kominek*/
                    $iFireplace = '';
                    switch ($aProject->kominek)
                    {
                        case 0:
                            $iFireplace = 29;
                            break;
                        case 1:
                            $iFireplace = 28;
                            break;
                    }
                    ($iFireplace !== '' ? $this->addFilter($iActualProductId, $iFireplace) : '');
                    /*Styl*/
		
                    $iStyle = '';
                    $iStyle = ($aProject->styl->nowoczesy ? 16 :'');
                    $iStyle = ($aProject->styl->tradycyjny ? 15 :'');
                    ($iStyle !== '' ? $this->addFilter($iActualProductId, $iStyle) : '');
                    
                    /*Ogrzewanie*/
                    $iPiec = '';
                    switch ($aProject->instalacje->typ_ogrzewania)
                    {
                        case 0:
                            $iPiec = 31;
                            break;
                        case 1:
                            $iPiec = 30;
                            break;
                        case 2:
                            $iPiec = 'Oba';

                    }
                    if ($iPiec != 'Oba' && $iPiec != '')
                    {
                       $this->addFilter($iActualProductId, $iPiec);
                    }
                    else
                    {
                        $this->addFilter($iActualProductId, 30);
                        $this->addFilter($iActualProductId, 31);
                    }
                    /*Energooszczędny*/
                    if ($aProject->instalacje->typ_ogrzewania->energooszczedny == 1)
                    {
                       $this->addFilter($iActualProductId, 32);
                    }
                    
                    
                    /*Zdjęcia */
                    $a=0;
                    /*Wizualizacje*/
                    foreach ($aProject->grafika->wizualizacje->viz as $aViews)
                    {

                        $sViewsLink = $aViews->url_web;
                        $extension = strtolower(strrchr($aViews->url_web, '.'));
                        $sName = $sSymbol.'_'.$a.''.$extension;
                        $sDesc = 'Wizualizacja - '. $sName;
                        $iImgType =1;
                        $this->addImage($iActualProductId, $sName, $sDesc, $iImgType);
                        /*Zapisywanie obrazków*/
                        $this->saveImage($sViewsLink, $iActualProductId, $sName);
                        $a++;
                    }
                     /*Elewacje*/
                    if (isset($aProject->grafika->elewacje))
                    {
                        foreach ($aProject->grafika->elewacje->ele as $aViews)
                        {
                            $sViewsLink = $aViews->url_web;
                            $extension = strtolower(strrchr($aViews->url_web, '.'));
                            $sName = $sSymbol.'_'.$a.''.$extension;
                            $sDesc = 'Elewacja - '. $sName;
                            $iImgType =2;
                            $file_headers = @get_headers($sViewsLink);
                            if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') 
                            {
                                $exists = false;
                            }
                            else 
                            {
                                $this->addImage($iActualProductId, $sName, $sDesc, $iImgType);
                                /*Zapisywanie obrazków*/
                                $this->saveImage($sViewsLink, $iActualProductId, $sName);
                                $a++;    
                            }
                        }
                    }
                     /*rzuty*/
		
                    if (isset($aProject->grafika->rzuty))
                    {

                        foreach ($aProject->grafika->rzuty->rzut as $aViews)
                        {
                            $sDesc= '';
                            switch ($aViews->attributes()->nr)
                            {
                                case 1:
                                $sDesc = 'Parter';
                                break;
                                case 2:
                                $sDesc = 'Poddasze';
                                break;
                                case 3:
                                $sDesc = 'Piwnica';
                                break;
                                case 4:
                                $sDesc = 'Przekrój';
                                break;
                                case 5:
                                $sDesc = 'Piętro';
                                break;
                            }
                        $sViewsLink = $aViews->standard->url_png;
                        $extension = strtolower(strrchr($aViews->standard->url_png, '.'));
                        $sName = $sSymbol.'_'.$a.''.$extension;
                        $iImgType =3;
                        $file_headers = @get_headers($sViewsLink);
                        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') 
                        {
                            $exists = false;
                        }
                        else 
                        {
                            $this->addImage($iActualProductId, $sName, $sDesc, $iImgType);
                            /*Zapisywanie obrazków*/
                            $this->saveImage($sViewsLink, $iActualProductId, $sName);
                            $a++;    
                        }
                        
                        
                        }
                    }
                    if (isset($aProject->realizacje))
                    {
                        foreach ($aProject->realizacje as $aViews)
                        {
                            $sViewsLink = $aViews->url_web;
                            $extension = strtolower(strrchr($aViews->url_web, '.'));
                            $sName = $sSymbol.'_'.$a.''.$extension;
                            $sDesc = 'Realizacja - '. $sName;
                            $iImgType =4;
                            $file_headers = @get_headers($sViewsLink);
                            if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') 
                            {
                                $exists = false;
                            }
                            else 
                            {
                                $this->addImage($iActualProductId, $sName, $sDesc, $iImgType);
                                /*Zapisywanie obrazków*/
                                $this->saveImage($sViewsLink, $iActualProductId, $sName);
                                $a++;    
                            }
                        }
                    }
                    if (isset($aProject->pomieszczenia->kondygnacja))
                    {
                        foreach ($aProject->pomieszczenia->kondygnacja as $aPietra)
                        {
                            switch($aPietra->attributes()->nr)
                            {
                            case 1:
                                $sStoreyName = 'Parter';
                                $sStoreyType = 1;
                                break;
                            case 2:
                            case 3:
                                $sStoreyName = 'Piętro';
                                $sStoreyType = 2;
                                break;
                            
                            }
                            foreach ($aPietra->pom as $aRooms)
                            {
                                $oStorey = new Storeys();
                                $oStorey->products_id = $iActualProductId;
                                $oStorey->storey_type = $sStoreyType;
                                $oStorey->storey_name = $sStoreyName;
                                $oStorey->room_name = ($aRooms->nazwa ? $aRooms->nazwa : '');
                                $oStorey->room_area = ($aRooms->pow ? $aRooms->pow : '');
                                $oStorey->room_number = ($aRooms->nr != "" ? $aRooms->nr: '');
                                $oStorey->save(false);
                            }
                                    
                            
                        }
                    }
                }
            }
        }
    }
    /*Import xml-a HORYZONT*/
    public function actionHoryzont()
    {
        
        $oDocument = new Response();
        $sXmlFile  = 'https://www.horyzont.com/baza-plikow/horyzont_05_2017.xml';
        $sXmlContent = file_get_contents($sXmlFile);
        $sXml = $oDocument->setContent($sXmlContent);
        $oParser = new XmlParser();
        $aHoryzont = $oParser->parse($sXml);
        
        foreach ($aHoryzont['product'] as $aProject)
        {
            
            if (substr_count(strtolower($aProject->name), 'kosztorys') <1)
            {
            if(substr_count(strtolower($aProject->name), 'Pompa ciepła') <1)
            {
            if(substr_count(strtolower($aProject->name), 'instalacja solarna') <1)
            {
            if(substr_count(strtolower($aProject->name), 'garaż') <1)
            {
            if(substr_count(strtolower($aProject->name), 'Dziennik') <1)
            {
                $oProjekt = new Products();
                $oExist = $oProjekt->findOne(['ean' => 'horyzont-'.$aProject->id_product]);
                if (!$oExist)
                {
                    
                /*Dodanie produktu*/
                    $sSymbol = $this->zamiana($aProject->name);
                    $sSymbol = ($this->checkSymbol($sSymbol) ? $sSymbol.'-horyzont' :$sSymbol);
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

    }
    
   
    /*Import xml-a MGProject*/
    public function actionMgprojekt()
    {
        $oDocument = new Response();
        $sXmlFile  = 'http://www.mgprojekt.com.pl/export_xml,index.html';
        
        $sXmlContent = file_get_contents($sXmlFile);
        $sXml = $oDocument->setContent($sXmlContent);
        $oParser = new XmlParser();
        $aMGP = $oParser->parse($sXml);
        //echo '<pre>'. print_r($aMGP, TRUE); die();
        foreach ($aMGP['projekt'] as $aProject)
        {
            $oProjekt = new Products();
            $oExist = $oProjekt->findOne(['ean' => 'mgprojekt-'.$aProject->products_id]);
            if (!$oExist)
            {
            /*Dodanie produktu*/
                $sSymbol = $this->zamiana($aProject->nazwa);
                $sSymbol = ($this->checkSymbol($sSymbol) ? $sSymbol.'-mgprojekt' :$sSymbol);
                $oProjekt->is_active = 0;
                $oProjekt->producers_id = 9;
                $oProjekt->vats_id = 3;
                $oProjekt->price_brutto_source = $aProject->cena_projektu;
                $oProjekt->price_brutto = $aProject->cena_projektu;
                $oProjekt->stock = 99;
                $oProjekt->creation_date=time();
                $oProjekt->symbol = 'mgprojekt-'.$aProject->products_id;
                $oProjekt->ean = 'mgprojekt-'.$aProject->products_id;
                $oProjekt->save(false);
            /*Dodanie opisów do produkty*/
                $iActualProductId = Yii::$app->db->getLastInsertID();
                $oProductsDesriptions = new ProductsDescripton();
                $oProductsDesriptions->products_id = $iActualProductId;
                $oProductsDesriptions->languages_id = 1;
                $oProductsDesriptions->name = $aProject->nazwa;
                $oProductsDesriptions->nicename_link = $sSymbol;
                $oProductsDesriptions->html_description = $aProject->opis. ($aProject->materialy !='' ? '<br> Materiały: <br>'. $aProject->materialy : '');
                $oProductsDesriptions->save(false); 
            
                if ($aProject->autor != '')
                {
                    $oAutor = new \app\models\Author();
                    $oAutor->products_id = $iActualProductId ;
                    $oAutor->name = $aProject->autor;
                    //$oAutor->save(false);
                }
                
                
            /*Dane technicze i filtry */
                
                $iKominek = 29;
                if ($aProject->kominek > 0)
                {
                    $iKominek = 28;
                }
                $this->addFilter($iActualProductId, $iKominek);
                $this->addAttr($iActualProductId, 18, $aProject->ilosc_lazienek);
                $this->addAttr($iActualProductId, 15, $aProject->kubatura);
                $this->addAttr($iActualProductId, 11, $aProject->powierzchnia_zabudowy);
                $this->addAttr($iActualProductId, 10, $aProject->powierzchnia_netto);
                $this->addAttr($iActualProductId, 4, $aProject->powierzchnia_uzytkowa);
                $this->addAttr($iActualProductId, 14, $aProject->powierzchnia_strychu);
                $this->addAttr($iActualProductId, 5, $aProject->powierzchnia_garazu);
                $this->addAttr($iActualProductId, 16, $aProject->powierzchnia_dachu);
                $this->addAttr($iActualProductId, 2, $aProject->szerokosc_budynku);
                $this->addAttr($iActualProductId, 3, $aProject->dlugosc_budynku);
                $this->addAttr($iActualProductId, 6, $aProject->min_szerokosc_dzialki);
                $this->addAttr($iActualProductId, 7, $aProject->min_dlugosc_dzialki);
                $this->addAttr($iActualProductId, 8, str_replace([' stopnie', ' stopni'], ['' , ''], $aProject->nachylenie_dachu));
                $this->addAttr($iActualProductId, 1, str_replace(['m'], [''], $aProject->wysokosc_budynku));
                foreach ($aProject->kategorie as $sKatKey=>$sKatValue)
                {
                    if ($sKatValue == 'Domy z kotłem na paliwo stałe')
                    {
                        $this->addFilter($iActualProductId, 30);
                    }
                    $iDzialka = 3;
                    if ($sKatValue == 'Projekty domów na wąską działkę')
                    {
                        $iDzialka = 1;
                    }
                    if ($sKatValue == 'Budynki na płytką działkę')
                    {
                        $iDzialka = 2;
                    }
                    $this->addFilter($iActualProductId, $iDzialka);
                    $iEnergia = 34;
                    if ($sKatValue == 'Projekty domów energooszczędnych ')
                    {
                        $iEnergia = 32;
                    }
                    $this->addFilter($iActualProductId, $iEnergia);             
                }
                foreach ($aProject->atrybuty as $aAtrybuty)
                {   
                    foreach ($aAtrybuty as $sAttrKey=>$sAttrValue)
                    {
                        $iDach = 0;
                        $iGaraz = 0;
                        $iPietra = 0;
                        $iPiwnica = 0;
                        $iStyl = 0;
                        switch ($sAttrKey)
                        {
                        case 'Dach':
                            switch ($sAttrValue)
                            {
                                case 'dwuspadowy z naczółkami':
                                    $iDach = 22;
                                    break;
                                case 'dwuspadowy':
                                    $iDach = 22;
                                    break;
                                case 'czterospadowy':
                                    $iDach = 23;
                                    break;
                                case 'wielospadowy':
                                    $iDach = 23;
                                    break;
                                case 'płaski':
                                    $iDach = 44;
                                    break;
                            }
                        break;
                        case 'Garaż':
                            switch ($sAttrValue)
                            {
                                case 'nie':
                                    $iGaraz = 40;
                                    break;
                                case 'dwustanowiskowy':
                                    $iGaraz = 25;
                                    break;
                                case 'jednostanowiskowy':
                                    $iGaraz = 24;
                                    break;
                                case 'wiata garażowa':
                                    $iGaraz = 45;
                                    break;
                                case 'garaż wolnostojący':
                                    $iGaraz = 45;
                                    break;
                                case 'trzystanowiskowy':
                                    $iGaraz = 25;
                                    break;   
                            }
                        break;
                        case 'Ilość_kondygnacji':
                            switch ($sAttrValue)
                            {
                                case 'parterowy z poddaszem użytkowym':
                                    $iPietra = 18;
                                    break;
                                case 'parterowy':
                                    $iPietra = 17;
                                    break;
                                case 'parterowy ze strychem':
                                    $iPietra = 18;
                                    break;
                                case 'piętrowy':
                                    $iPietra = 19;
                                    break;
                                
                            }
                        break;
                        case 'Podpiwniczenie':
                            switch ($sAttrValue)
                            {
                                case 'tak':
                                    $iPiwnica = 20;
                                    break;
                                case 'nie':
                                    $iPiwnica = 39;
                                    break;
                                
                            }
                        break;
                        case 'Styl':
                            switch ($sAttrValue)
                            {
                                case 'tradycyjny':
                                    $iStyl = 15;
                                    break;
                                case 'nowoczesny':
                                    $iStyl = 16;
                                    break;
                                
                            }
                        break;
                        }

                        ($iDach != 0 ? $this->addFilter($iActualProductId, $iDach) : '');
                        ($iGaraz != 0 ? $this->addFilter($iActualProductId, $iGaraz) : '');
                        ($iPietra != 0 ? $this->addFilter($iActualProductId, $iPietra) : '');
                        ($iPiwnica != 0 ? $this->addFilter($iActualProductId, $iPiwnica) : ''); 
                        ($iStyl != 0 ? $this->addFilter($iActualProductId, $iStyl) : '');                         
                    }

                    
                }
                /*Obrazki wszystkie*/
                $a = 0;
                foreach ($aProject->zdjecia as $aObrazki)
                {
                    /*Zdjęcia*/
                    foreach ($aObrazki->zdjecia_dodatkowe->zdjecie as $aZdjecia)
                    {
                        $extensionN = strtolower(strrchr($aZdjecia->normalne, '.'));
                        $extensionL = strtolower(strrchr($aZdjecia->lustrzane, '.'));
                        if ($extensionN == '.html?prefix=-1')
                        {
                            $extensionN = '.jpg';
                        }
                        if ($extensionL == '.html?prefix=-1')
                        {
                            $extensionL = '.jpg';
                        }
                        $b=$a+1;
                        $sNameN = $sSymbol.'_'.$a.''.$extensionN;
                        $sNameL = $sSymbol.'_'.$b.''.$extensionL;
                        $sDescN = 'Wizualizacja';
                        $sDescL = 'Odbicie lustrzane - wizualizacja';
                        
                        /*Zapisywanie obrazków*/
                        if (isset($aZdjecia->normalne))
                        {
                            $this->addImage($iActualProductId, $sNameN, $sDescN, 1);
                            $this->saveImage($aZdjecia->normalne, $iActualProductId, $sNameN);
                        }
//                        if (isset($aZdjecia->lustrzane))
//                        {
//                            $this->addImage($iActualProductId, $sNameL, $sDescL, 1);
//                            $this->saveImage($aZdjecia->lustrzane, $iActualProductId, $sNameL);
//                        }
                        //$a=$b;
                        $a++;
                    }
                    /*Rzuty*/
                    foreach ($aObrazki->rzut->zdjecie as $aRzut)
                    {
                        $b=$a+1;
                        $extensionN = strtolower(strrchr($aRzut->normalne, '.'));
                        $extensionL = strtolower(strrchr($aRzut->lustrzane, '.'));
                        
                        if ($extensionN == '.html?prefix=-1')
                        {
                            $extensionN = '.jpg';
                        }
                        if ($extensionL == '.html?prefix=-1')
                        {
                            $extensionL = '.jpg';
                        }
                        $sNameN = $sSymbol.'_'.$a.''.$extensionN;
                        $sNameL = $sSymbol.'_'.$b.''.$extensionL;
                        $sDescN = 'Rzut';
                        $sDescL = 'Odbicie lustrzane - rzut';
                        
                        /*Zapisywanie obrazków*/
                        if (isset($aRzut->normalne) )
                        {
                            $this->addImage($iActualProductId, $sNameN, $sDescN, 3);
                            $this->saveImage($aRzut->normalne, $iActualProductId, $sNameN);
                        }
//                        if (isset($aRzut->lustrzane))
//                        {
//                            //echo $sNameL; die();
//                            $this->addImage($iActualProductId, $sNameL, $sDescL, 3);
//                            $this->saveImage($aRzut->lustrzane, $iActualProductId, $sNameL);
//                        }
                        //$a=$b;
                        $a++;
                    }
                    /*Elewacje*/
                    foreach ($aObrazki->elewacje->zdjecie as $aElewacje)
                    {
                        $b=$a+1;
                        $extensionN = strtolower(strrchr($aElewacje->normalne, '.'));
                        $extensionL = strtolower(strrchr($aElewacje->lustrzane, '.'));
                        
                        if ($extensionN == '.html?prefix=-1')
                        {
                            $extensionN = '.jpg';
                        }
                        if ($extensionL == '.html?prefix=-1')
                        {
                            $extensionL = '.jpg';
                        }
                        $sNameN = $sSymbol.'_'.$a.''.$extensionN;
                        $sNameL = $sSymbol.'_'.$b.''.$extensionL;
                        $sDescN = 'Elewacja';
                        $sDescL = 'Odbicie lustrzane - elewacja';
                        
                        /*Zapisywanie obrazków*/
                        if (isset($aRzut->normalne) )
                        {
                            $this->addImage($iActualProductId, $sNameN, $sDescN, 2);
                            $this->saveImage($aElewacje->normalne, $iActualProductId, $sNameN);
                        }
//                        if (isset($aRzut->lustrzane))
//                        {
//                            //echo $sNameL; die();
//                            $this->addImage($iActualProductId, $sNameL, $sDescL, 2);
//                            $this->saveImage($aElewacje->lustrzane, $iActualProductId, $sNameL);
//                        }
                        //$a=$b;
                        $a++;
                    }
                    /*Usytuowanie na działce*/
                    foreach ($aObrazki->usytuowanie_na_dzialce->zdjecie as $aUsytuowanie)
                    {
                        $b=$a+1;
                        $extensionN = strtolower(strrchr($aUsytuowanie->normalne, '.'));
                        $extensionL = strtolower(strrchr($aUsytuowanie->lustrzane, '.'));
                        
                        if ($extensionN == '.html?prefix=-1')
                        {
                            $extensionN = '.jpg';
                        }
                        if ($extensionL == '.html?prefix=-1')
                        {
                            $extensionL = '.jpg';
                        }
                        $sNameN = $sSymbol.'_'.$a.''.$extensionN;
                        $sNameL = $sSymbol.'_'.$b.''.$extensionL;
                        $sDescN = 'Usytuowanie na działce';
                        $sDescL = 'Odbicie lustrzane - usytuowanie na działce';
                        
                        /*Zapisywanie obrazków*/
                        if (isset($aRzut->normalne) )
                        {
                            $this->addImage($iActualProductId, $sNameN, $sDescN, 5);
                            $this->saveImage($aUsytuowanie->normalne, $iActualProductId, $sNameN);
                        }
//                        if (isset($aRzut->lustrzane))
//                        {
//                            //echo $sNameL; die();
//                            $this->addImage($iActualProductId, $sNameL, $sDescL, 5);
//                            $this->saveImage($aUsytuowanie->lustrzane, $iActualProductId, $sNameL);
//                        }
                        //$a=$b;
                        $a++;
                    }
                }
            }  
        }

    }
    public function actionImages()
    {
        $sPatch = Yii::getAlias('@images');
        //$sPatch = 'E:/images/images/';
        $aFolderList = scandir(Yii::getAlias('@images'));
        
        $oImage = new Image();
        $cdir = scandir($sPatch); 
        foreach ($cdir as $key => $valueDir) 
        { 
           if (!in_array($valueDir,array(".",".."))) 
           { 
               echo $valueDir.'<br>';
                if (is_dir($sPatch  . DIRECTORY_SEPARATOR . $valueDir)) 
                { 
                  $sBigDir = $sPatch.'/'.$valueDir .'/big';
                  $aBigDirScan = scandir($sBigDir);
                  foreach ($aBigDirScan as $key => $value) 
                  { 
                     if (!in_array($value,array(".",".."))) 
                     {
                          $sImage = $sBigDir.'/'.$value;
                          $aImageSixe =getimagesize($sImage); 

                          if ($aImageSixe[0] > 1600 && $aImageSixe[0] > $aImageSixe[1])
                          {
                              $iWidthBigSize = $aImageSixe[0]/($aImageSixe[0]/1600);
                              $iHeightBigSize = ceil($aImageSixe[1]/($aImageSixe[0]/1600));
                              $oImage->thumbnail($sImage, $iWidthBigSize, $iHeightBigSize)->save($sImage, ['quality' => 90]);
                              echo 'Szerokie ' .$sImage.'<br>';
                          }
                          else if ($aImageSixe[0] > 1000 && $aImageSixe[1] > $aImageSixe[0])
                          {
                              $iWidthBigSize = $aImageSixe[0]/($aImageSixe[1]/1000);
                              $iHeightBigSize = ceil($aImageSixe[1]/($aImageSixe[1]/1000));
                              $oImage->thumbnail($sImage, $iWidthBigSize, $iHeightBigSize)->save($sImage, ['quality' => 90]);
                              echo 'Wąskie '. $sImage.'<br>';
                          }
                          else
                          {
                              $oImage->thumbnail($sImage, $aImageSixe[0], $aImageSixe[1])->save($sImage, ['quality' => 90]);
                          }

                     }
                  }
                }

                /*Katalogi info i thumbs*/
                $sInfoDir = $sPatch.'/'.$valueDir .'/info';
                $aInfoDirScan = scandir($sInfoDir);
                $sThumbsDir = $sPatch.'/'.$valueDir .'/thumbs';
                $aThumbsDirScan = scandir($sThumbsDir);
                foreach ($aInfoDirScan as $key => $value) 
                { 
                   if (!in_array($value,array(".",".."))) 
                   {
                       $sImage = $sInfoDir.'/'.$value;
                       $aImageSixe =getimagesize($sImage);
                       $oImage->thumbnail($sImage, $aImageSixe[0], $aImageSixe[1])->save($sImage, ['quality' => 90]);
                   }
                }
                foreach ($aThumbsDirScan as $key => $value) 
                { 
                   if (!in_array($value,array(".",".."))) 
                   {
                       $sImage = $sInfoDir.'/'.$value;
                       $aImageSixe =getimagesize($sImage);
                       $oImage->thumbnail($sImage, $aImageSixe[0], $aImageSixe[1])->save($sImage, ['quality' => 90]);
                   }
                }
              
            } 
        } 
    }
    
    
    
    /*Dodatki do róznych pracowni*/
    /*Rzut działki do sprawdzenia rozmiarów*/
    public function actionRzut() 
    {
        $iProducers = $_GET['producent'];
        $oProjects = new Products();
        $aPrdHoryzont = $oProjects->findAll(['producers_id'=>$iProducers]);
       
        //$oPrdImages = $aPrdHoryzont->producers;
        foreach ($aPrdHoryzont as $aPrd)
        {
            $sPatch = Yii::getAlias('@image');
            $oImages = new ProductsImages();
            $aImages = $oImages->findAll(['products_id'=>$aPrd->id , 'image_type_id'=>5]);
            if (isset($aImages[0]))
            {
                $sInfoPatch = $sPatch.'/' .$aPrd->id .'/big/';
                echo '<span style="font-size:40px;">'.$aPrd->id .' ---- ' .$aPrd->productsDescriptons->name .'</span><br>';
                echo '<img src="'.$sInfoPatch.$aImages[0]->name .'"/><br>';
            }
            
        }
        
    }
    /* Rzuty pięter żeby łatwiej było liczyć ilość pomieszczeń */
    public function actionPietra() 
    {
        $iProducers = $_GET['producent'];
        $oProjects = new Products();
        $aPrdHoryzont = $oProjects->findAll(['producers_id'=>$iProducers]);
       
        //$oPrdImages = $aPrdHoryzont->producers;
        foreach ($aPrdHoryzont as $aPrd)
        {
            $sPatch = Yii::getAlias('@image');
            $oImages = new ProductsImages();
            $aImages = $oImages->findAll(['products_id'=>$aPrd->id , 'image_type_id'=>3]);
            echo '<span style="font-size:40px;">'.$aPrd->id .' ---- ' .$aPrd->productsDescriptons->name .'</span><br>';
            foreach ($aImages as $aImage)
            {
                $sInfoPatch = $sPatch.'/' .$aPrd->id .'/big/';
                
                if (strpos($aImage->description, 'lustrzane') === false) 
                {
                    if (strpos($aImage->description, 'Przekrój') === false) 
                        {
                            echo '<img src="'.$sInfoPatch.$aImage->name .'"/>';
                        }
                }
               
                
            }
            echo '<br>';
        }
        
    }
    
    public function actionExport()
    {
        $iProducers = $_GET['producent'];
        $aProductsFilter = [];
        $aPytanie3 = [1,2,3];
        $aPytanie5 = [15,16];
        $aPytanie6 = [17,18,19];
        $aPytanie7 = [4,5,6,7];
        $aPytanie8 = [22,23,41,42,43,44];
        $aPytanie9 = [24,25,40,45];
        $aPytanie10 = [26,27];
        $aPytanie11 = [28,29];
        $aPytanie12 = [30,31];
        $aPytanie13 = [32,33,34];
        $aPytanie15 = [20,21,39];
        
        
        $oProducts = new Products();
        $oPrdDsc = new ProductsDescripton();
        $aPrdIds = $oProducts->find()->andWhere(['producers_id'=>$iProducers])->asArray()->all();
        $aPrdIds = array_map('current', $aPrdIds);
        /*Odpowiedzi na pytanie */
        $oPrdFltr = new ProductsFilters();
        $aPrdFltrs = $oPrdFltr->find()->andWhere(['IN', 'products_id', $aPrdIds])->all();
        foreach ($aPrdFltrs as $aPrdFltr)
        {
            $aProjectDsc = $oPrdDsc->findOne($aPrdFltr['products_id']);
            $aProductsFilter[$aPrdFltr['products_id']]['id'] = $aPrdFltr['products_id'];
            $aProductsFilter[$aPrdFltr['products_id']]['name'] = $aProjectDsc->name;
            $aProductsFilter[$aPrdFltr['products_id']][3] = '';
            $aProductsFilter[$aPrdFltr['products_id']][5] = '';
            $aProductsFilter[$aPrdFltr['products_id']][6] = '';
            $aProductsFilter[$aPrdFltr['products_id']][7] = '';
            $aProductsFilter[$aPrdFltr['products_id']][8] = '';
            $aProductsFilter[$aPrdFltr['products_id']][9] = '';
            $aProductsFilter[$aPrdFltr['products_id']][10] = '';
            $aProductsFilter[$aPrdFltr['products_id']][11] = '';
            $aProductsFilter[$aPrdFltr['products_id']][12] = '';
            $aProductsFilter[$aPrdFltr['products_id']][13] = '';
            $aProductsFilter[$aPrdFltr['products_id']][15] = '';     
        }
        foreach ($aPrdFltrs as $aPrdFltr)
        {
            if (in_array($aPrdFltr['filters_id'], $aPytanie3 ))
		{
                    $aProductsFilter[$aPrdFltr['products_id']][3] = $aPrdFltr['filters_id'];
		}
            if (in_array ($aPrdFltr['filters_id'] , $aPytanie5 ))
		{
                    $aProductsFilter[$aPrdFltr['products_id']][5] = $aPrdFltr['filters_id'];
		}
            if (in_array ($aPrdFltr['filters_id'] , $aPytanie6 ))
		{
                    $aProductsFilter[$aPrdFltr['products_id']][6] = $aPrdFltr['filters_id'];
		}
            if (in_array ($aPrdFltr['filters_id'] , $aPytanie7 ))
		{
                    $aProductsFilter[$aPrdFltr['products_id']][7] = $aPrdFltr['filters_id'];
		}
            if (in_array ($aPrdFltr['filters_id'] , $aPytanie8 ))
		{
                    $aProductsFilter[$aPrdFltr['products_id']][8] = $aPrdFltr['filters_id'];
		}
            if (in_array ($aPrdFltr['filters_id'] , $aPytanie9 ))
		{
                    $aProductsFilter[$aPrdFltr['products_id']][9] = $aPrdFltr['filters_id'];
		}
            if (in_array ($aPrdFltr['filters_id'] , $aPytanie10 ))
		{
                    $aProductsFilter[$aPrdFltr['products_id']][10] = $aPrdFltr['filters_id'];
		}
            if (in_array ($aPrdFltr['filters_id'] , $aPytanie11 ))
		{
                    $aProductsFilter[$aPrdFltr['products_id']][11] = $aPrdFltr['filters_id'];
		}
            if (in_array ($aPrdFltr['filters_id'] , $aPytanie12 ))
		{
                    $aProductsFilter[$aPrdFltr['products_id']][12] = $aPrdFltr['filters_id'];
		}
            if (in_array ($aPrdFltr['filters_id'] , $aPytanie13 ))
		{
                    $aProductsFilter[$aPrdFltr['products_id']][13] = $aPrdFltr['filters_id'];
		}
            if (in_array ($aPrdFltr['filters_id'] , $aPytanie15 ))
		{
                    $aProductsFilter[$aPrdFltr['products_id']][15] = $aPrdFltr['filters_id'];
		}
        }
        
        
        /*Dane techniczne */
        $oAttributes = new \app\models\Attributes();
        $aAttributes = $oAttributes->find()->all();
        $oPrdAttrs = new ProductsAttributes();
        $aPrdAttrs = $oPrdAttrs->find()->andWhere(['IN', 'products_id', $aPrdIds])->all(); 
        foreach ($aPrdAttrs as $aPrdAttr)
        {
            foreach ($aAttributes  as $aAttribute)
            {
                $aProductsFilter[$aPrdAttr['products_id']]['td-'.$aAttribute->id] = '';
            }
        }
        $PrjsAtributes = [];

        foreach ($aPrdAttrs as $aPrdAttr)
        {
            if ($aPrjAttr = $oPrdAttrs->findOne(['products_id'=>$aPrdAttr->products_id, 'attributes_id'=>$aPrdAttr->attributes_id]))
                {
                    $aProductsFilter[$aPrdAttr->products_id]['td-'.$aPrdAttr->attributes_id] = $aPrjAttr->value;
                }
           
        }
        $file = fopen('../../xml/export-'.$iProducers.'.csv', 'w');
        foreach ($aProductsFilter as $filtersKey=>$filtersValue)
        {
            fputcsv($file, $filtersValue);
        }   
    }
    public function actionImport()
    {
        /*
         * 
         * [0] - id
         * [1] - nazwa
         * Odpowiedzi na pytania
         * [2] - Działka  - 3
         * [3] - Styl - 5
         * [4] - Kondygnacja - 6
         * [5] - Ilośc osób - 7
         * [6] - Dach - 8
         * [7] - Garaż - 9
         * [8] - Kuchnia - 10
         * [9] - Kominek - 11
         * [10] - Ogrzewanie - 12
         * [11] - Efektywność - 13
         * [12] - Piwnica - 15
         * Dane techniczne
         * [13] - Wysokość - 1 
         * [14] - Szerokośc - 2
         * [15] - Długość - 3
         * [16] - Powierzchnia użytkowa - 4
         * [17] - Powierzchnia garażu - 5
         * [18] - Minimalna szerokość działki - 6
         * [19] - Minimalna długość działki - 7
         * [20] - Kąt nachylenia dachu - 8
         * [21] - Ilość pomieszczeń - 9 
         * [22] - Powierzchnia netto - 10
         * [23] - Powierzchnia zabudowy - 11
         * [24] - Powierzchnia piwnicy - 13
         * [25] - Powierzchnia strychu - 14 
         * [26] - Kubatura netto - 15
         * [27] - Powierzchnia dachu - 16
         * [28] - Liczba sypialni - 17
         * [29] - Liczba łazienek - 18
         * [30] - Liczba toalet - 19
         * [31] - Ilość pięter - 20											
        */
        $model = new Upload();
        $oProductsFilters = new ProductsFilters();
        $aTechData = [13=>1, 14=>2, 15=>3, 16=>4, 17=>5, 18=>6, 19=>7, 20=>8, 21=>9, 22=>10, 23=>11, 24=>13, 25=>14, 26=>15, 27=>16, 28=>17, 29=>18, 30=>19, 31=>20];
        if (Yii::$app->request->isPost) 
        {
            $model->importFile = UploadedFile::getInstance($model, 'importFile');
            if ($sFile = $model->upload()) 
            {
                
                if (($oImport = fopen($sFile, "r")) !== FALSE) 
                {
                    while (($aImportRows = fgetcsv($oImport, 1000, ",")) !== FALSE) 
                    {
                        
                        $oProductsFilters->deleteAll(['products_id'=>$aImportRows[0]]);
                        for($a=2; $a<=12; $a++)
                        {
                            if ($aImportRows[$a] != '')
                            {
                                $oProductsFilters = new ProductsFilters();
                                $oProductsFilters->products_id = $aImportRows[0];
                                $oProductsFilters->filters_id = $aImportRows[$a];
                                $oProductsFilters->save();
                            }
                            
                        }
                        for($a=13; $a<=30; $a++)
                        {
                            if (isset($aImportRows[$a]) && $aImportRows[$a] != '')
                            {
                                if ($oExist = $oProductsAttributes->findOne(['products_id'=>$aImportRows[0],'attributes_id'=> $aTechData[$a]]))
                                {
                                    $oExist->products_id = $aImportRows[0];
                                    $oExist->attributes_id = $aTechData[$a];
                                    $oExist->value = $aImportRows[$a];
                                    $oExist->save(false);
                                }
                                else
                                {
                                    $oProductsAttributes = new ProductsAttributes();
                                    $oProductsAttributes->products_id = $aImportRows[0];
                                    $oProductsAttributes->attributes_id = $aTechData[$a];
                                    $oProductsAttributes->value = $aImportRows[$a];
                                    $oProductsAttributes->save();
                                }
                                
                            }
                            
                        }
                        $oProducts = new Products();
                        $oProduct = $oProducts->findOne(['id'=>$aImportRows[0]]);
                        $oProduct->is_active = 1;
                        $oProduct->save(false);
                    }   
                }
            }
        }
        return $this->render('import', ['model' => $model]);
    }
}
