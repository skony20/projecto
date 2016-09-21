Projekty wszystkie: <br><Br>

<?php

foreach ($dataProvider->models as $aProducts)
{
    echo $aProducts->id .'  -  '. $aProducts->productsDescriptons->name .'  '. $aProducts->productsDescriptons->name_model .'<br>';
}
?>