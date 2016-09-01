<?php
$connection = @mysql_connect('127.0.0.1', 'mariuszs_prj', 'pr0j3ct0')
or die('11111Brak połaczenia z serwerem MySQL.<br />Blad: '.mysql_error());
mysql_query("SET NAMES 'utf8'");
$db = @mysql_select_db('mariuszs_projecto', $connection)
or die('2222Nie moge polaczyc sie z baza danych<br />Blad: '.mysql_error());
// polaczenie nawiazane ;-)


$oProArte = simplexml_load_file('proarte.xml');

?>

<?php
//echo print_r($oProArte, TRUE); die();
$id=1;
foreach ($oProArte->Projekt as $aProArte)
{

    if ($aProArte->Rodzaj == 1)
    {
        $sSymbol = mysql_fetch_array(mysql_query('SELECT id FROM products WHERE symbol = "'.$aProArte->Symbol.'"'));


        if (!isset($sSymbol['id']))
        {

        $a=0;
        //echo '<pre>'.print_r($aProArte, TRUE) .'</pre>';

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
                . '3, '
                . '1, '
                . '"'.$aProArte->Cena.'", '
                . '"'.$aProArte->Cena.'", '
                . '99, '
                . ''.time().', '
                . '"'.$aProArte->Symbol.'", '
                . '"'.$aProArte->Symbol.'");';
        $oUpdate = mysql_query($sQuery);
        $iProductId =  mysql_insert_id();
        $sNiceNamePL = $aProArte->Nazwa. ' ' .$aProArte->Symbol;
        $sNiceNamePL = strtr($sNiceNamePL, 'ĘÓĄŚŁŻŹĆŃęóąśłżźćń', 'EOASLZZCNeoaslzzcn');
        $sNiceName =  str_replace([' ', '#', '(', ')'], ['_', '_','',''] , $sNiceNamePL);
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
                . "'".$sNiceName."', "
                . "'".$aProArte->Nazwa ."', "
                . "'".$aProArte->Symbol ."', "
                . "'<xmp>".$aProArte->Opis_projektu[0] ."<br>Technologia<br><br>".$aProArte->Technologia_opis. "</xmp>', "
                . "'".$aProArte->Nazwa.' '.$aProArte->Symbol."')";
        $oUpdateDesc = mysql_query($sQueryDesc) or die(mysql_error());

        mkdir('images/'.$iProductId, 0777);
        mkdir('images/'.$iProductId.'/big', 0777);
        mkdir('images/'.$iProductId.'/info', 0777);
        mkdir('images/'.$iProductId.'/thumbs', 0777);
        foreach ($aProArte->Wizualizacje->Wiz as $aWizualizacje)
        {

            $sWizLink = str_replace(['x=500&', 'maxy=367&'], ['',''], $aWizualizacje->Url[0]);
            $WizTitle = (isset($aWizualizacje->Tytul) ? $aWizualizacje->Tytul : '');
            $sImgBigName = $sNiceName.'_'.$a.'.jpg';
            $sImgBig = 'images/'.$iProductId.'/big/'.$sImgBigName;
//            $sImginfo = 'images/'.$iProductId.'/big/'.$sNiceName.'_'.$a.'.jpg';
//            $sImgThumbs = 'images/'.$iProductId.'/big/'.$sNiceName.'_'.$a.'.jpg';
            file_put_contents($sImgBig, file_get_contents($sWizLink));
            mysql_query('INSERT INTO products_images (products_id, name, description) VALUE('.$iProductId.', "'.$sImgBigName.'", "'.$WizTitle.'")') or die(mysql_error());
            $a++;
        }
        /*Imgages*/
        foreach ($aProArte->Images->Img as $aImages)
        {
            $sImgLink = str_replace(['x=500&', 'maxy=367&'], ['',''], $aImages->Url[0]);
            $ImagesTitle = (isset($aImages->Tytul) ? $aImages->Tytul : '');
            $sImgBigName = $sNiceName.'_'.$a.'.jpg';
            $sImgBig = 'images/'.$iProductId.'/big/'.$sImgBigName;
            file_put_contents($sImgBig, file_get_contents($sImgLink));
            mysql_query('INSERT INTO products_images (products_id, name, description) VALUE('.$iProductId.', "'.$sImgBigName.'", "'.$ImagesTitle.'")') or die(mysql_error());
            $a++;
        }

        /*Elewacje*/
        foreach ($aProArte->Elewacje->Elewacja as $aElewacje)
        {
            $sElewacjeLink = str_replace(['x=500&', 'maxy=367&'], ['',''], $aElewacje->Url[0]);
            $ElewacjeTitle = (isset($aElewacje->Tytul) ? $aElewacje->Tytul : '');
            $sImgBigName = $sNiceName.'_'.$a.'.jpg';
            $sImgBig = 'images/'.$iProductId.'/big/'.$sImgBigName;
            mysql_query('INSERT INTO products_images (products_id, name, description) VALUE('.$iProductId.', "'.$sImgBigName.'", "'.$ElewacjeTitle.'")') or die(mysql_error());
            file_put_contents($sImgBig, file_get_contents($sElewacjeLink));
            $a++;
        }


        mysql_query('INSERT INTO products_attributes (products_id, attributes_id, value) VALUE('.$iProductId.', 4, '.$aProArte->Pow_uzytkowa.')') or die(mysql_error());
        mysql_query('INSERT INTO products_attributes (products_id, attributes_id, value) VALUE('.$iProductId.', 8, '.$aProArte->Kat_dachu1.')') or die(mysql_error());
        mysql_query('INSERT INTO products_attributes (products_id, attributes_id, value) VALUE('.$iProductId.', 1, '.$aProArte->Wysokosc_budynku.')') or die(mysql_error());
        mysql_query('INSERT INTO products_attributes (products_id, attributes_id, value) VALUE('.$iProductId.', 7, '.$aProArte->Dzialka_min_dlugosc.')') or die(mysql_error());
        mysql_query('INSERT INTO products_attributes (products_id, attributes_id, value) VALUE('.$iProductId.', 6, '.$aProArte->Dzialka_min_szerokosc.')') or die(mysql_error());
        mysql_query('INSERT INTO products_attributes (products_id, attributes_id, value) VALUE('.$iProductId.', 9, '.$aProArte->Liczba_pokoi.')') or die(mysql_error());
        mysql_query('INSERT INTO products_attributes (products_id, attributes_id, value) VALUE('.$iProductId.', 4, '.$aProArte->Pow_uzytkowa.')') or die(mysql_error());

        //die();
       $id++;
}
    }

}
?>