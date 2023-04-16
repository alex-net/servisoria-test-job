<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;

class QuestionsWidgetAsset extends AssetBundle
{
    public $sourcePath = '@app/front';

    public $js = ['questions-widget.js'];

    public $depends = [
        YiiAsset::class,
        JqueryBarRatingAsset::class,
    ];
}