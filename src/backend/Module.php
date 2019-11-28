<?php

namespace yiicom\catalog\backend;

class Module extends \yiicom\catalog\common\Module
{
    /**
     * @inheritDoc
     */
    public function settings()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function adminMenu()
    {
        return [
            'label' => 'Каталог',
            'url' => '/catalog/category/index',
            'icon' => 'fa fa-sitemap',
            'items' => [
                [
                    'label' => 'Категории',
                    'url' => '/catalog/category/index',
                    'icon' => 'fa fa-list',
                ]
            ]
        ];
    }
}