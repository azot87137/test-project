<?php

namespace app\assets;


use yii\web\AssetBundle;

class ListAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = ['/js/list.js'];

    public $depends = [
        'app\assets\AppAsset'
    ];
}