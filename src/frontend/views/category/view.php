<?php

use yii\web\View;
use yii\helpers\Html;
use yiicom\catalog\common\models\Category;
use yiicom\catalog\common\models\Product;

/**
 * @var View $this
 * @var Category $category
 * @var Category $categoryRoot
 * @var Category[] $categoryParents
 * @var Category[] $categoryChildren
 * @var Product[] $products
 */

$products = [
    [
        'name' => 'Спринтер',
        'title' => 'Микроавтобус Мерседес Спринтер',
        'teaser' => '',
        'body' => '',
        'price' => 1500,
        'isShowPrice' => '',
        'status' => '',
        'url' => [
            'alias' => 'some/test/alias',
        ],
        'categories' => [
            [
                'name' => 'Туристические автобусы',
                'title' => 'Туристические автобусы',
            ],
        ],
        'attributes' => [
            [
                  'name' => 'type',
                  'title' => 'Тип',
                  'value' => 'Микроавтобус',
                  'type' => 'select',
                  'prefix' => '',
                  'postfix' => '',
                  'isShowInCategory' => true,
            ],
            [
                'name' => 'model',
                'title' => 'Марка',
                'value' => 'Mercedes-Benz',
                'type' => 'select',
                'prefix' => '',
                'postfix' => '',
                'isShowInCategory' => true,
            ],
            [
                'name' => 'year',
                'title' => 'Год выпуска',
                'value' => 2018,
                'type' => 'int',
                'prefix' => '',
                'postfix' => 'г.',
                'isShowInCategory' => true,
            ],
            [
                'name' => 'seats',
                'title' => 'Места',
                'value' => 51,
                'type' => 'int',
                'prefix' => '',
                'postfix' => '',
                'isShowInCategory' => true,
            ],
        ],
        'image' => [
            'src' => '/storage/product/test.jpg',
            'alt' => 'test alt',
            'title' => 'test title',
        ],
        'images' => [
           [
               '' => '',
           ]
        ],
    ],
    [
        'name' => 'Спринтер',
        'title' => 'Микроавтобус Мерседес Спринтер',
        'teaser' => '',
        'body' => '',
        'price' => 1500,
        'isShowPrice' => '',
        'status' => '',
        'url' => [
            'alias' => 'some/test/alias',
        ],
        'categories' => [
            [
                'name' => 'Туристические автобусы',
                'title' => 'Туристические автобусы',
            ],
        ],
        'attributes' => [
            [
                'name' => 'year',
                'title' => 'Год выпуска',
                'value' => 2018,
                'type' => 'int',
                'prefix' => '',
                'postfix' => 'г.',
                'isShowInCategory' => true,
            ],
        ],
        'image' => [
            'src' => '/storage/product/test.jpg',
            'alt' => 'test alt',
            'title' => 'test title',
        ],
        'images' => [
            [
                '' => '',
            ]
        ],
    ],
    [
        'name' => 'Спринтер',
        'title' => 'Микроавтобус Мерседес Спринтер',
        'teaser' => '',
        'body' => '',
        'price' => 1500,
        'isShowPrice' => '',
        'status' => '',
        'url' => [
            'alias' => 'some/test/alias',
        ],
        'categories' => [
            [
                'name' => 'Туристические автобусы',
                'title' => 'Туристические автобусы',
            ],
        ],
        'attributes' => [
            [
                'name' => 'year',
                'title' => 'Год выпуска',
                'value' => 2018,
                'type' => 'int',
                'prefix' => '',
                'postfix' => 'г.',
                'isShowInCategory' => true,
            ],
        ],
        'image' => [
            'src' => '/storage/product/test.jpg',
            'alt' => 'test alt',
            'title' => 'test title',
        ],
        'images' => [
            [
                '' => '',
            ]
        ],
    ],
];

$products = json_decode(json_encode($products, false));

foreach ($categoryParents as $parent) {
    $this->params['breadcrumbs'][] = [
        'label' => Html::encode($parent->title ? $parent->title : $parent->name),
        'url' => "/{$parent->url->alias}"
    ];
}
$this->params['breadcrumbs'][] = Html::encode($category->title ? $category->title : $category->name);

?>

<h1><?php echo Html::encode($category->title ?: $category->name); ?></h1>

<?php if ($categoryChildren) : ?>

<?php endif; ?>

<?php if (! $products) : ?>

    <p>Пока пусто</p>

<?php else : ?>

    <div class="row">

        <?php foreach ($products as $product) : ?>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 product">

                <a class="product__title" href="/<?= $product->url->alias ?>"><?= Html::encode($product->title) ?></a>

                <div class="row product__desc">

                    <div class="col-md-6 col-xs-6 col-12">
                        <a class="product__image" href="/<?= $product->url->alias ?>">
                            <img class="product__img" src="<?= $product->image->src ?>" alt="<?= Html::encode($product->image->alt) ?>" title="<?= Html::encode($product->image->title) ?>">
                        </a>
                    </div>

                    <div class="col-md-6 col-xs-6 col-12">
                        <ul class="product__attrs">
                            <?php foreach ($product->attributes as $attr) : ?>
                                <li class="product__attr">
                                    <span><?= $attr->title ?></span>: <?= $attr->value ?> <?= $attr->postfix ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <a class="product__link" href="/<?= $product->url->alias ?>">Подробнее</a>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 col-xs-12">
                        <div class="product__price">от <span>3000</span> руб/час</div>
                    </div>

                    <div class="col-md-6 col-xs-12">
                        <a class="btn btn-primary btn-lg product__btn-rent" href="#">Арендовать</a>
                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

<?php endif ?>