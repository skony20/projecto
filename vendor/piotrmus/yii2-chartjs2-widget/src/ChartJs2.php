<?php
/**
 * @link https://github.com/piotrmus/yii2-chartjs2-widget
 * @copyright Copyright (c) 2016 Piotr Musiał
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
namespace piotrmus\chartjs2;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\VarDumper;

/**
 *
 * Chart renders a canvas ChartJs2 plugin widget.
 *
 * @author Piotr Musiał <piotr.mus@gmail.com>
 * @link http://www.codehat.pl/
 */
class ChartJs2 extends Widget
{
    public $type;
    public $options;
    public $chartOptions;
    public $data;

    public function init()
    {
        parent::init();
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }

    }

    public function run()
    {
        echo Html::tag('canvas', '', $this->options);
        $this->registerAsset();
    }

    public function registerAsset()
    {
        $id = $this->options['id'];
        $type = $this->type;
        $view = $this->getView();
        $data = !empty($this->data) ? Json::encode($this->data) : '{}';
        $options = !empty($this->chartOptions) ? Json::encode($this->chartOptions) : '{}';
        ChartJs2Asset::register($view);


        $js = ";var chartJS_{$id} = new Chart(document.getElementById('{$id}').getContext('2d'), {'type': '{$type}', 'data': {$data}, 'options': {$options}});";
        $view->registerJs($js);
    }
}