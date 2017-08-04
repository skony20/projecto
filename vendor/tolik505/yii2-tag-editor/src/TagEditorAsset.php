<?php
/**
 * Uses jQuery tagEditor.
 * @link http://goodies.pixabay.com/jquery/tag-editor/demo.html
 */

namespace tolik505\tagEditor;

use yii\web\AssetBundle;

/**
 * Class TagEditorAsset
 *
 * @package tolik505\tagEditor
 */
class TagEditorAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-tag-editor';
    public $css = [
        'jquery.tag-editor.css'
    ];
    public $js = [
        'jquery.caret.min.js'
    ];
    public $depends = [
        'yii\jui\JuiAsset',
    ];
    public $publishOptions = [
        'except' => [ '*.html', '*.md', '*.json' ]
    ];


    public function init()
    {
        parent::init();

        $this->js[] = YII_DEBUG ? 'jquery.tag-editor.js' : 'jquery.tag-editor.min.js';
    }
}
