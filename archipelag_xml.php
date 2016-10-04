<?php

//$url="https://www.archipelag.pl/files/ProjectExport/t26d6ch0bqdeu6/project_export.zip";
//$plik = file_get_contents($url);
//$strona=fopen("xml/project_export.zip","w+");
//fwrite($strona,"$plik");
//fclose($strona);
//
//
//$zip = new ZipArchive;
//$res = $zip->open('xml/project_export.zip');
//if ($res === TRUE) {
//  $zip->extractTo('xml/');
//  $zip->close();
//
//} else {
//  echo 'bleeeeeeeee cos sie zesralo z importowanym plikiem';
//}
//


$connection = @mysql_connect('127.0.0.1', 'mariuszs_prj', 'pr0j3ct0')
or die('11111Brak połaczenia z serwerem MySQL.<br />Blad: '.'2');
mysql_query("SET NAMES 'utf8'");
$db = @mysql_select_db('mariuszs_projecto', $connection)
or die('2222Nie moge polaczyc sie z baza danych<br />Blad: '.'2');
// polaczenie nawiazane ;-)

$sArchipelag = str_replace(array("&amp;", "&"), array("&", "&amp;"), file_get_contents('xml/files/temp/~g4bn3al0eq6alu/projekty.xml'));
$oArchipelag= simplexml_load_string($sArchipelag);


//$fArchipelag = file_get_contents('xml/files/temp/~g4bn3al0eq6alu/projekty.xml');
//// replace '&' followed by a bunch of letters, numbers
//// and underscores and an equal sign with &amp;
//$fArchipelag = preg_replace('#&(?=[a-z_0-9]+=)#', '&amp;', $fArchipelag);
//$oArchipelag = simplexml_load_string($fArchipelag);

//echo '<pre>ddd'. print_r($oArchipelag, TRUE);
?>

<?php

function zamiana($string)
   {
       $string = strtolower($string);
	$polskie = array(',', ' - ',' ','ę', 'Ę', 'ó', 'Ó', 'Ą', 'ą', 'Ś', 's', 'ł', 'Ł', 'ż', 'Ż', 'Ź', 'ź', 'ć', 'Ć', 'ń', 'Ń','-',"'","/","?", '"', ":", 'ś', '!','.', '&', '&amp;', '#', ';', '[',']', '(', ')', '`', '%', '”', '„', '…');
	$miedzyn = array('-','-','-','e', 'e', 'o', 'o', 'a', 'a', 's', 's', 'l', 'l', 'z', 'z', 'z', 'z', 'c', 'c', 'n', 'n','-',"","","","","",'s','','', '', '', '', '', '', '', '', '', '', '', '');
	$string = str_replace($polskie, $miedzyn, $string);
	
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

//echo '<pre>'.print_r($oArchipelag, TRUE); die();
$id=1;
foreach ($oArchipelag->Project as $aArchipelag)
{
    //echo $aArchipelag->attributes()->Id .'<br>';
    $sName = $aArchipelag->Name;
    $sSymbol = zamiana($sName);
    
    
    

    
    if ($aArchipelag->InfoKind == 1 or $aArchipelag->InfoKind == 1)
    {
        //$sSymbol = mysql_fetch_array(mysql_query('SELECT id FROM products WHERE symbol = "'.$aProArte->Symbol.'"'));
        $id++;
        $iVat = (100+($aArchipelag->PriceNetto))/100;
        
        switch ($aArchipelag->PriceVAT)
        {
            case 23.00:
                $iVatId = 1;
                break;
            case 8.00:
                $iVatId = 2;
                break;
            case 5.00:
                $iVatId = 3;
                break;
            case 0.00:
                $iVatId = 4;
                break;
        }
        if (!isset($sSymbol['id']))
        {
            $sQuery ='INSERT INTO products ('
                . 'is_active, '
                . 'producers_id, '
                . 'vats_id, '
                . 'price_brutto, '
                . 'price_brutto_source, '
                . 'stock, '
                . 'creation_date, '
                . 'symbol, '
                . 'ean) '
                . 'VALUES ('
                . '0, '
                . ''.$iVatId.', '
                . '3, '
                . '"'.ceil(($aArchipelag->PriceNetto)*((100+($aArchipelag->PriceVAT))/100)).'", '
                . '"'.ceil(($aArchipelag->PriceNetto)*((100+($aArchipelag->PriceVAT))/100)).'", '
                . '99, '
                . ''.time().', '
                . '"'.$sSymbol.'", '
                . '"'.$aArchipelag->attributes()->Id.'");';

            $oUpdate = mysql_query($sQuery) or die('2');
            $iProductId =  mysql_insert_id();
            $sQueryDesc = "INSERT INTO products_descripton ("
                . "products_id, "
                . "languages_id, "
                . "nicename_link, "
                . "name, "
                . "name_model, "
                . "html_description, "
                . "meta_title) "
                . "VALUES ("
                . $iProductId .", "
                . "1, "
                . "'".$sSymbol."', "
                . "'".$aArchipelag->Name ."', "
                . "'', "
                . "'".$aArchipelag->BodyDescription. "<br>Technologia:<br>".$aArchipelag->BodyTechnology. "<br>Wykończenie:<br>".$aArchipelag->BodyFinish. "', "
                . "'".$aArchipelag->Name."')";

        $oUpdateDesc = mysql_query($sQueryDesc) or die('2');
        
        
        mysql_query('INSERT INTO products_attributes (products_id, attributes_id, value) VALUE('.$iProductId.', 1, '.$aArchipelag->Height.')') or die('1');
        mysql_query('INSERT INTO products_attributes (products_id, attributes_id, value) VALUE('.$iProductId.', 2, '.$aArchipelag->Width.')') or die('2');
        mysql_query('INSERT INTO products_attributes (products_id, attributes_id, value) VALUE('.$iProductId.', 3, '.$aArchipelag->Length.')') or die('3');
        mysql_query('INSERT INTO products_attributes (products_id, attributes_id, value) VALUE('.$iProductId.', 4, '.$aArchipelag->AreaUse.')') or die('4');
        mysql_query('INSERT INTO products_attributes (products_id, attributes_id, value) VALUE('.$iProductId.', 5, '.$aArchipelag->AreaGarage.')') or die('5');
        mysql_query('INSERT INTO products_attributes (products_id, attributes_id, value) VALUE('.$iProductId.', 6, '.$aArchipelag->LandLength.')') or die('6');
        mysql_query('INSERT INTO products_attributes (products_id, attributes_id, value) VALUE('.$iProductId.', 7, '.$aArchipelag->LandWidth.')') or die('7');
        mysql_query('INSERT INTO products_attributes (products_id, attributes_id, value) VALUE('.$iProductId.', 8, '.$aArchipelag->RoofAngle.')') or die('8');
        mysql_query('INSERT INTO products_attributes (products_id, attributes_id, value) VALUE('.$iProductId.', 9, '.$aArchipelag->CountRoom.')') or die('9');
        mysql_query('INSERT INTO products_attributes (products_id, attributes_id, value) VALUE('.$iProductId.', 10, '.$aArchipelag->AreaNetto.')') or die('10');
        mysql_query('INSERT INTO products_attributes (products_id, attributes_id, value) VALUE('.$iProductId.', 11, '.$aArchipelag->AreaBuilding.')') or die('11');
        mysql_query('INSERT INTO products_attributes (products_id, attributes_id, value) VALUE('.$iProductId.', 13, '.$aArchipelag->AreaBasement.')') or die('12');
        mysql_query('INSERT INTO products_attributes (products_id, attributes_id, value) VALUE('.$iProductId.', 14, '.$aArchipelag->AreaAttic.')') or die('13');
        mysql_query('INSERT INTO products_attributes (products_id, attributes_id, value) VALUE('.$iProductId.', 15, '.$aArchipelag->Cubature.')') or die('14');
        mysql_query('INSERT INTO products_attributes (products_id, attributes_id, value) VALUE('.$iProductId.', 16, '.$aArchipelag->RoofArea.')') or die('15');
        mysql_query('INSERT INTO products_attributes (products_id, attributes_id, value) VALUE('.$iProductId.', 17, '.$aArchipelag->CountBedroom.')') or die('16');
        mysql_query('INSERT INTO products_attributes (products_id, attributes_id, value) VALUE('.$iProductId.', 18, '.$aArchipelag->CountBathroom.')') or die('18');
        mysql_query('INSERT INTO products_attributes (products_id, attributes_id, value) VALUE('.$iProductId.', 19, '.$aArchipelag->CountToilet.')') or die('19');
        
        /*Ilość kondygnacji*/
        $iType = '';
        switch ($aArchipelag->InfoType)
        {
            case 1:
                $iType = 17;
                break;
            case 2:
                $iType = 18;
                break;
            case 3:
                $iType = 19;
                break;
        }
        mysql_query('INSERT INTO products_filters (products_id, filters_id) VALUE('.$iProductId.', '.$iType.')') or die('30'.mysql_error());
        
        /*Piwnica*/
        $iBasement = '';
        switch ($aArchipelag->InfoBasement)
        {
            case 0:
                $iBasement = 39;
                break;
            case 1:
                $iBasement = 20;
                break;
            
        }
        mysql_query('INSERT INTO products_filters (products_id, filters_id) VALUE('.$iProductId.', '.$iBasement.')') or die('40'.mysql_error());
        /*Dach*/
        $iRoof = '';
        switch ($aArchipelag->RoofType)
        {
            case 'dwuspadowy':
                $iRoof = 22;
                break;
            case 'czterospadowy':
                $iRoof = 23;
                break;
            case 'kopertowy':
                $iRoof = 41;
                break;
            case 'wielospadowy':
                $iRoof = 42;
                break;
            case 'mansardowy':
                $iRoof = 43;
                break;
            case 'płaski':
                $iRoof = 44;
                break;
        }
        mysql_query('INSERT INTO products_filters (products_id, filters_id) VALUE('.$iProductId.', '.$iRoof.')') or die('50'.mysql_error());
        
        /*Garaż*/
        $iGarage = '';
        switch ($aArchipelag->InfoGarage)
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
        }
        mysql_query('INSERT INTO products_filters (products_id, filters_id) VALUE('.$iProductId.', '.$iGarage.')') or die('60'.mysql_error());
        
        
        /*Kominek*/
        $iFireplace = '';
        switch ($aArchipelag->InfoFireplace)
        {
            case 0:
                $iFireplace = 29;
                break;
            case 1:
                $iFireplace = 28;
                break;
            
        }
        mysql_query('INSERT INTO products_filters (products_id, filters_id) VALUE('.$iProductId.', '.$iFireplace.')') or die('70'.mysql_error());
        
        mkdir('images/'.$iProductId, 0777);
        mkdir('images/'.$iProductId.'/big', 0777);
        mkdir('images/'.$iProductId.'/info', 0777);
        mkdir('images/'.$iProductId.'/thumbs', 0777);    
            
            
            
        }

//        foreach ($aProArte->Wizualizacje->Wiz as $aWizualizacje)
//        {
//
//            $sWizLink = str_replace(['x=500&', 'maxy=367&'], ['',''], $aWizualizacje->Url[0]);
//            $WizTitle = (isset($aWizualizacje->Tytul) ? $aWizualizacje->Tytul : '');
//            $sImgBigName = $sNiceName.'_'.$a.'.jpg';
//            $sImgBig = 'images/'.$iProductId.'/big/'.$sImgBigName;
////            $sImginfo = 'images/'.$iProductId.'/big/'.$sNiceName.'_'.$a.'.jpg';
////            $sImgThumbs = 'images/'.$iProductId.'/big/'.$sNiceName.'_'.$a.'.jpg';
//            file_put_contents($sImgBig, file_get_contents($sWizLink));
//            mysql_query('INSERT INTO products_images (products_id, name, description) VALUE('.$iProductId.', "'.$sImgBigName.'", "'.$WizTitle.'")') or die('2');
//            $a++;
//        }
        /*Imgages
        foreach ($aProArte->Images->Img as $aImages)
        {
            $sImgLink = str_replace(['x=500&', 'maxy=367&'], ['',''], $aImages->Url[0]);
            $ImagesTitle = (isset($aImages->Tytul) ? $aImages->Tytul : '');
            $sImgBigName = $sNiceName.'_'.$a.'.jpg';
            $sImgBig = 'images/'.$iProductId.'/big/'.$sImgBigName;
            file_put_contents($sImgBig, file_get_contents($sImgLink));
            mysql_query('INSERT INTO products_images (products_id, name, description) VALUE('.$iProductId.', "'.$sImgBigName.'", "'.$ImagesTitle.'")') or die('2');
            $a++;
        }

        /*Elewacje
        foreach ($aProArte->Elewacje->Elewacja as $aElewacje)
        {
            $sElewacjeLink = str_replace(['x=500&', 'maxy=367&'], ['',''], $aElewacje->Url[0]);
            $ElewacjeTitle = (isset($aElewacje->Tytul) ? $aElewacje->Tytul : '');
            $sImgBigName = $sNiceName.'_'.$a.'.jpg';
            $sImgBig = 'images/'.$iProductId.'/big/'.$sImgBigName;
            mysql_query('INSERT INTO products_images (products_id, name, description) VALUE('.$iProductId.', "'.$sImgBigName.'", "'.$ElewacjeTitle.'")') or die('2');
            file_put_contents($sImgBig, file_get_contents($sElewacjeLink));
            $a++;
        }

*/
    }
    die();
}
?>