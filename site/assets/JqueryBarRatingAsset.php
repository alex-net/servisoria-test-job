<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;


class JqueryBarRatingAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-bar-rating/dist';

    public $js = ['jquery.barrating.min.js'];

    public $css = ['themes/css-stars.css'];

    public $depends = [YiiAsset::class];
}