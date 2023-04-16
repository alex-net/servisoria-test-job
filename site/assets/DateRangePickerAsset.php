<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;

class DateRangePickerAsset extends AssetBundle
{
    public $sourcePath = '@npm/daterangepicker';

    public $js = ['moment.min.js', 'daterangepicker.js' ];

    public $css = ['daterangepicker.css'];

    public $depends = [YiiAsset::class];
}