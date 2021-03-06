<?php
use piotrmus\chartjs2\ChartJs2;
$this->title = 'Odpowiedzi na pytania';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php

$a=0;
$b=0;
?>
<ul class="nav nav-pills nav-justified">
  
<li class="active"><a data-toggle="pill" href="#pill-all">Dane ogólne</a></li>
<?php
foreach ($aFilterDataText as $key2 => $value2)
{
?>
    <li><a data-toggle="pill" href="#pill<?=$b?>"><?=$key2?></a></li>

<?php
$b++;
}

?>
</ul>
<div class="tab-content">
    <div id="pill-all" class="tab-pane fade in active">
    <div class="col-md-12 search-filter-center">Dane ogólne</div>
    Wszystkich wyszukiwań: <?=$aFiltersData['all'] ?> <br>
    <br>
    Ostatnie wyszukiwanie: <?= date('d-m-Y H:m:s', $aFiltersData['last']) ?> <br>
    <br>
    Najczęściej zaznaczane odpowiedzi:<br>
    <?php
    foreach ($aMaxAnswer as $aMaxAnswerKey => $aMaxAnswerValue)
    {
        echo $aMaxAnswerKey .': '.$aMaxAnswerValue .'<br>';
    }
    
    ?>
    </div>
    
<?php
foreach ($aFilterDataText as $key => $value)
{
    $aLabels =[];
    $aData =[];
    foreach ($value as $sAnswerKey=>$iAnswerValue)
    {
        $aLabels[] .=$sAnswerKey;
        $aData[] .= $iAnswerValue;
    }
    echo '<div id="pill'.$a.'" class="tab-pane fade ">';
    echo '<div class="col-md-12 search-filter-center">' .$key .'</div>';
    echo  ChartJs2::widget([
        'type' => 'bar',
        'data' => [
            'labels' => $aLabels,
            'datasets' => [
                [
                    'label' => $key,
                    'data' => $aData,
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                    ],
                    'borderColor' => [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                    ],
                    'borderWidth' => 1,
                ]
            ]
        ],
        'options' => [
            'id' => $a,
            'width' => 100,
            'height' => 20,

        ],
        'chartOptions' => [
            'legend'=>[
                'display'=>false,
                ],
            'scales' => [
                'yAxes' => [
                    [
                        'ticks' => [
                            'beginAtZero' => true
                        ]
                    ]]
            ]
        ],
    ]);
    echo '</div>';
    $a++;
}
?>
</div>