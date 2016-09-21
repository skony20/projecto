<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Products;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Lista projektów');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="full_site">
    <div class="left filter_menu">
    <?php
    Pjax::begin();
    echo Html::beginForm(['site/projekty'], 'POST', ['js-pjax' => '', 'id'=>'set_filters', 'name'=>'set_filers']);
    foreach ($aFilters as $aData) {

        echo $aData['question']->name.'<br>';
        echo '<div class=filter_ansver_row>';
        echo Html::radioList($aData['question']->id, $aChooseFilters ,ArrayHelper::map($aData['answer'], 'id', 'name'), ['class'=>'answer']);
        echo '</div>';
    }
    ?>
    <?= Html::endForm() ?>
    <?= Html::tag('div', 'resetuj filtry', ['class' => 'reset_all_filters']) ?>

    </div>
    </div>
    <div class="another products-items">
        

            <?= $this->render('products', ['dataProvider' => $dataProvider]) ?>

    </div>
</div>
    <?php
        Pjax::end();
    ?>
