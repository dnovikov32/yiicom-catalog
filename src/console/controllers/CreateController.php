<?php

namespace yiicom\catalog\console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\ExitCode;
use yii\console\Controller;
use yii\base\InvalidConfigException;
use yiicom\content\common\models\PageUrl;
use yiicom\content\common\models\Page;

class CreateController extends Controller
{
    /**
     * Creates default catalog pages (catalog, etc)
     * @return int
     * @throws InvalidConfigException
     */
    public function actionDefaults()
    {
        $catalogPage = new Page;
        $catalogPage->title = Yii::t("yiicom/catalog", "Catalog page");
        $catalogPage->template = 'catalog';

        $catalogPage->url = Yii::createObject(PageUrl::class);
        $catalogPage->url->alias = 'catalog';

        if (! $catalogPage->save()) {
            Console::output(
                Console::ansiFormat(
                    "Failed to create catalog page: "  . implode(', ', $catalogPage->getFirstErrors()),
                    [Console::FG_RED]
                )
            );

            return ExitCode::UNSPECIFIED_ERROR;
        };

        Console::output(Console::ansiFormat("Default catalog pages created successfully", [Console::FG_GREEN]));

        return ExitCode::OK;
    }
}
