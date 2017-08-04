<?php
/**
 * Input widget for Yii 2.0
 *
 * Widget to enter, delete and interactively sort tags.
 *
 * Uses jQuery tagEditor.
 * @link http://goodies.pixabay.com/jquery/tag-editor/demo.html
 *
 */

namespace tolik505\tagEditor;

use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Class TagEditor
 *
 * @package tolik505\tagEditor
 */
class TagEditor extends InputWidget
{
    /**
     * @var array
     * The Javascript options of the jQuery tagEditor widget.
     */
    public $tagEditorOptions = [];


    public function run()
    {
        $view = $this->getView();
        $asset = new TagEditorAsset();
        $asset->register($view);
        $id = $this->getId();
        $this->options['id'] = $id;
        $teOpts = count($this->tagEditorOptions) ? Json::encode($this->tagEditorOptions) : '';
        $view->registerJs("jQuery('#$id').tagEditor($teOpts);");
        return $this->hasModel() ? Html::activeTextInput($this->model, $this->attribute, $this->options)
            : Html::textInput($this->name, $this->value, $this->options);
    }
}
