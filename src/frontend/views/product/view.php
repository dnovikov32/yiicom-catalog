<?php

use yii\web\View;
use yii\helpers\Html;
use yiicom\catalog\common\models\Product;
use yiicom\catalog\common\models\Category;
use yiicom\catalog\common\models\AttributeType;
use yiicom\files\common\models\File;
use yiicom\files\common\widgets\ImageWidget;

/**
 * @var View $this
 * @var Product $product
 * @var File[] $images
 * @var Category $category
 * @var Category[] $categoryParents
 * @var array $attributes
 */

foreach ($categoryParents as $parent) {
    $this->params['breadcrumbs'][] = [
        'label' => Html::encode($parent->title ?: $parent->name),
        'url' => "/{$parent->url->alias}"
    ];
}

$this->params['breadcrumbs'][] = [
    'label' => Html::encode($category->title ?: $category->name),
    'url' => "/{$category->url->alias}"
];
$this->params['breadcrumbs'][] = Html::encode($product->title ?: $product->name);

?>

<div class="product">

    <h1><?php echo Html::encode($product->title ?: $product->name); ?></h1>

    <div class="row">
        <div class="col-md-7 mb-5">
            <div class="product__image">
                <?php if (isset($images[0])) : ?>
                    <?php echo ImageWidget::widget([
                        'images' => $images[0],
                        'preset' => '576x426',
                        'linkPreset' => '1200x900',
                        'linkOptions' => [
                            'class' => 'product__image-link',
                            'data-fancybox' => 'gallery',
                        ],
                        'options' => ['class' => 'img-fluid']
                    ]); ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-5 mb-5">

            <?php if ($product->isShowPrice) : ?>
                <div class="product__price">Стоимость аренды: <span><?= $product->price ?></span> руб/час</div>
            <?php endif; ?>

            <ul class="product__attrs">
                <?php foreach ($attributes as $attributeGroup) : ?>
                    <?php  if (isset($attributeGroup['attributes'])) : ?>
                        <?php foreach ($attributeGroup['attributes'] as $attribute) : ?>
                            <?php if (isset($product->attributeValue->value[$attribute['id']]) && $attribute['isShowInProduct']) : ?>
                                <li class="product__attr">
                                    <?php if ($attribute['type'] == AttributeType::TYPE_CHECKBOX) : ?>
                                        <span><?= Html::encode($attribute['title']) ?></span>: есть
                                    <?php elseif ($attributeGroup['type'] == AttributeType::TYPE_SELECT) : ?>
                                        <span><?= Html::encode($attributeGroup['title']) ?></span>: <?= Html::encode($attribute['title']) ?>
                                    <?php else : ?>
                                        <span><?= Html::encode($attribute['title']) ?></span>:
                                        <?= isset($product->attributeValue->value[$attribute['id']]) ? Html::encode($product->attributeValue->value[$attribute['id']]) : '' ?>
                                    <?php endif; ?>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>

            <div class="product__equipment-link">
                <a class="link" href="#" data-scroll-to=".product__equipment">Комплектация</a>
            </div>

            <a class="btn btn-primary btn-lg product__btn-rent" href="#">Заказать автобус</a>

        </div>

    </div>

    <?php if (count($images) > 1) : ?>
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="product__images js-slick-slider" data-name="product">
                    <?php echo ImageWidget::widget([
                        'images' => $images,
                        'preset' => '281x207',
                        'dataPreset' => '576x426',
                        'linkPreset' => '1200x900',
                        'linkOptions' => [
                            'class' => 'product__img-link',
                            'data-fancybox' => 'gallery'
                        ],
                        'options' => ['class' => 'product__img']
                    ]); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($product->teaser) : ?>
        <div class="row">
            <div class="col-md-12 product__teaser">
                <?= $product->teaser ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($product->body) : ?>
        <div class="row">
            <div class="col-md-12 product__body">
                <h2>Описание</h2>
                <?= $product->body ?>
            </div>
        </div>
    <?php endif; ?>


    <?php if (isset($attributes['equipment']['attributes'])) : ?>
        <div class="row">
            <div class="col-md-12 product__equipment">
                <h2>Комплектация</h2>
                <?php foreach ($attributes['equipment']['attributes'] as $attribute) : ?>
                    <?php if (isset($product->attributeValue->value[$attribute['id']])) : ?>
                        <li class="product__attr">
                            <span><?= Html::encode($attribute['title']) ?></span>: есть
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</div><!-- /product -->