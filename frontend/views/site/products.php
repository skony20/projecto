<br><br>Projekty wszystkie: <br><Br>

<?php
if (!$dataProvider->models)
{
    echo 'Brak projektów spełniajacych kryteria';
}
foreach ($dataProvider->models as $aProducts)
{
    echo $aProducts->id .'  -  '. $aProducts->productsDescriptons->name .'  '. $aProducts->productsDescriptons->name_model .'<br>';
}


echo \yii\widgets\LinkPager::widget([
    'pagination'=>$dataProvider->pagination,
]);
?>