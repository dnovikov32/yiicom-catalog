<?php

namespace yiicom\catalog\backend;

use yiicom\catalog\common\models\Attribute;

class Module extends \yiicom\catalog\common\Module
{
    /**
     * @inheritDoc
     */
    public function settings()
    {
        $settings = [
            'catalog' => [
                'attributes' => [
                    'typesList' => (new Attribute)->typesList()
                ],
            ],
        ];

        return $settings;
    }

    /**
     * @inheritDoc
     */
    public function adminMenu()
    {
        return [
            'label' => 'Каталог',
            'url' => '/catalog/product/index',
            'icon' => 'fa fa-sitemap',
            'items' => [
                [
                    'label' => 'Товары',
                    'url' => '/catalog/product/index',
                    'icon' => 'fa fa-list-alt',
                ],
                [
                    'label' => 'Категории',
                    'url' => '/catalog/category/index',
                    'icon' => 'fa fa-list',
                ],
                [
                    'label' => 'Атрибуты',
                    'url' => '/catalog/attribute/index',
                    'icon' => 'fa fa-list',
                ],
                [
                    'label' => 'Группы атрибутов',
                    'url' => '/catalog/attribute-group/index',
                    'icon' => 'fa fa-list',
                ]
            ]
        ];
    }
}