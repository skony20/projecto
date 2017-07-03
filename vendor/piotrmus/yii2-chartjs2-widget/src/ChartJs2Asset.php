<?php
/**
 * @link https://github.com/piotrmus/yii2-chartjs2-widget
 * @copyright Copyright (c) 2016 Piotr Musiał
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
namespace piotrmus\chartjs2;

use yii\web\AssetBundle;

/**
 *
 * ChartPluginAsset
 *
 * @author Piotr Musiał <piotr.mus@gmail.com>
 * @link http://www.codehat.pl/
 */
class ChartJs2Asset extends AssetBundle
{
    public $sourcePath = '@bower/chartjs';

    public function init()
    {
        $this->js = (YII_DEBUG ? ['dist/Chart.js'] : ['dist/Chart.min.js']);
    }
}