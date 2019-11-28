<?php

namespace yiicom\catalog\common;

use Yii;
use yii\i18n\PhpMessageSource;

class Module extends \yiicom\common\Module
{
    public function init()
    {
        parent::init();

        Yii::$app->i18n->translations['yiicom-catalog'] = [
            'class' => PhpMessageSource::class,
            'basePath' => '@yiicom/content/common/messages',
            'sourceLanguage' => 'en-US',
        ];
    }
}