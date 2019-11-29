<?php

namespace yiicom\catalog\console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\ExitCode;
use yii\console\Controller;
use yii\base\InvalidConfigException;
use yiicom\content\common\models\PageUrl;
use yiicom\content\common\models\Page;

use yiicom\catalog\backend\forms\CategoryForm;

class CreateController extends Controller
{
    /**
     * Creates default catalog pages (catalog, etc)
     * @return int
     * @throws InvalidConfigException
     */
    public function actionDefaults()
    {
        $catalog = new CategoryForm;
        $catalog->left = 1;
        $catalog->right = 2;
        $catalog->level = 0;
        $catalog->name = Yii::t('yiicom/catalog', 'Catalog');
        $catalog->title = Yii::t('yiicom/catalog', 'Catalog');

        $catalog->url = Yii::createObject(PageUrl::class);
        $catalog->url->alias = 'catalog';
        $catalog->url->route = 'catalog/category/index';

        if (! $catalog->process()) {
            Console::output(
                Console::ansiFormat(
                    "Failed to create catalog page: "  . implode(', ', $catalog->getFirstErrors()),
                    [Console::FG_RED]
                )
            );

            return ExitCode::UNSPECIFIED_ERROR;
        };

        Console::output(Console::ansiFormat("Default catalog pages created successfully", [Console::FG_GREEN]));

        return ExitCode::OK;
    }
}
