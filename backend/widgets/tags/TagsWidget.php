<?php

namespace backend\widgets\tags;

use backend\widgets\tags\assets\TagsAsset;
use yii\helpers\Html;

class TagsWidget extends \yii\widgets\InputWidget
{
    public $route = '';
    public $placeholder = '';
    public $tokensAllowCustom = 'true';

    public function run()
    {
        $this->registerClientScript();
        Html::addCssClass($this->options, 'tokenize-remote');
        $this->options['multiple'] = 'multiple';
        if ($this->hasModel()) {
            $arr = array_map(function ($item) {
                return [$item => $item];
            }, $this->model->{$this->attribute});
            echo Html::activeDropDownList($this->model, $this->attribute, $arr, $this->options);
        }
    }

    private function registerClientScript()
    {
        $js = "  $('.tokenize-remote').tokenize2({
                    tokensAllowCustom: {$this->tokensAllowCustom},
                    placeholder: '{$this->placeholder}',
                    dataSource: function (term, object) {
                            $.ajax('{$this->route}', {
                                type: 'POST',
                                data: { search: term, start: 0 },
                                dataType: 'json',
                                success: function (data) {
                                    object.trigger('tokenize:dropdown:fill', [data]);
                                }
                            });
                    }
  });";

        $view = $this->getView();
        TagsAsset::register($view);
        $view->registerJs($js, $view::POS_END);
    }
}