<?php

use yii\web\View;
use yii\helpers\Html;
use yiicom\catalog\common\models\Category;
use yiicom\catalog\common\models\Product;
use yiicom\files\common\widgets\ImageWidget;

/**
 * @var View $this
 * @var Category $category
 * @var Category $categoryRoot
 * @var Category[] $categoryParents
 * @var Category[] $categoryChildren
 * @var Product[] $products
 * @var array $attributes
 */

foreach ($categoryParents as $parent) {
    $this->params['breadcrumbs'][] = [
        'label' => Html::encode($parent->title ?: $parent->name),
        'url' => "/{$parent->url->alias}"
    ];
}
$this->params['breadcrumbs'][] = Html::encode($category->title ?: $category->name);

?>

<h1><?php echo Html::encode($category->title ?: $category->name); ?></h1>

<?php if ($category->teaser) : ?>
    <div class="category__teaser">
        <?= $category->teaser ?>
    </div>
<?php endif; ?>

<?php if ($categoryChildren) : ?>
    <div class="cat-list category__categories">
        <p>Уточнить категорию:</p>
        <dic class="row">
            <?php foreach ($categoryChildren as $clild) : ?>
                <div class="category__category">
                    <a class="" href="/<?= $clild->url->alias ?>">
                        <?= Html::encode($clild->title ?: $clild->name) ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </dic>
    </div>
<?php endif; ?>

<?php if (! $products) : ?>

    <p class="mb-5">Пока пусто</p>

<?php else : ?>

    <div class="row category__products">

        <?php foreach ($products as $product) : ?>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 product">

                <a class="product__title" href="/<?= $product->url->alias ?>"><?= Html::encode($product->title) ?></a>

                <div class="row product__desc">

                    <div class="col-md-6 col-xs-6 col-12">
                        <a class="product__image" href="/<?= $product->url->alias ?>">
                            <?php if (isset($product->files[0])) : ?>
                                <?php echo ImageWidget::widget([
                                    'images' => $product->files[0],
                                    'options' => ['class' => 'product__img'],
                                    'preset' => '265x208',
//                                    'linkPreset' => '1200x900',
//                                    'linkOptions' => [
//                                        'class' => 'product__image',
//                                        'data-toggle' => 'lightbox',
//                                        'data-gallery' => 'product'
//                                    ]
                                ]); ?>
                            <?php endif; ?>
                        </a>
                    </div>

                    <div class="col-md-6 col-xs-6 col-12">
                        <ul class="product__attrs">
                            <?php foreach ($attributes as $attributeGroup) : ?>
                                <?php foreach ($attributeGroup['attributes'] as $attribute) : ?>
                                    <?php if (isset($product->attributeValue->value[$attribute['id']])) : ?>
                                        <li class="product__attr">
                                            <span><?= $attribute['title'] ?></span>:
                                            <?= $product->attributeValue->value[$attribute['id']] ?? '' ?>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
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


<?php if ($category->body) : ?>
    <div class="category__body">
        <?= $category->body ?>
    </div>
<?php endif; ?>
