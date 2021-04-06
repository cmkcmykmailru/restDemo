<?php
namespace backend\widgets\tags\assets;

class TagsAsset extends \yii\web\AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/tokenize2.min.css'
    ];
    public $js = [
        'js/tokenize2.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}