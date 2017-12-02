<?php

namespace rebzden\ajaxform;

use yii\web\AssetBundle;

class AjaxFormAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = __DIR__ . '/assets';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/ajaxform.js'
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset'
    ];
}