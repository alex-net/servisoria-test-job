<?php

namespace app\assets;

use yii\web\AssetBundle;

use yii\web\YiiAsset;

class GraphWidgetAsset extends AssetBundle
{
    public $sourcePath = '@app/front';

    public $js = ['graph-widget.js'];

    public $depends = [YiiAsset::class, ChartJsAsset::class];
}