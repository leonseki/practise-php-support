<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * 后台资源注册
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'static/layui/css/layui.css',
    ];
    public $js = [
        'static/layui/layui.js',
        'static/js/site.js',
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
