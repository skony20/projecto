<?php
use piotrmus\chartjs2\ChartJs2;
?>
<?php
$a=0;
foreach ($aFiltersData as $key => $value)
{
    $aLabels =[];
    $aData =[];
    foreach ($value as $sAnswerKey=>$iAnswerValue)
    {
        $aLabels[] .=$sAnswerKey;
        $aData[] .= $iAnswerValue;
    }
    echo '<div class="col-md-6">';
    echo '<div class="col-md-12 filter-center">' .$key .'</div>';
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
            'height' => 50,

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