<?php
/**
 * Project: yii2-blog for internal using
 * Author: diazoxide
 * Copyright (c) 2018.
 */

namespace diazoxide\yii2monetization\assets;

use yii\web\AssetBundle;

class ChartistAsset extends AssetBundle
{
    public $sourcePath = '@bower/chartist/dist';


    public $css = [
        'chartist.min.css'

    ];

    public $js = [
        'chartist.min.js'
    ];

    public $depends = [

    ];
}
