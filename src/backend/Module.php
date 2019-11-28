<?php

namespace yiicom\catalog\backend;

class Module extends \yiicom\catalog\common\Module
{
    public function getAdminMenu()
    {
        return [
            'label' => 'Каталог',
            'url' => ['/catalog/category/index'],
            'icon' => 'nav-icon fa fa-sitemap',
            'items' => [
                [
                    'label' => 'Категории',
                    'url' => ['/catalog/category/index'],
                    'icon' => 'nav-icon fa fa-list',
                ]
            ]
        ];
    }
}