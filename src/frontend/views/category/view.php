<?php

use yii\web\View;
use yii\helpers\Html;
use yiicom\catalog\common\models\Category;
use yiicom\catalog\common\models\Product;
use yiicom\catalog\common\models\AttributeType;
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

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 product-card">

                <a class="product-card__title" href="/<?= $product->url->alias ?>"><?= Html::encode($product->name) ?></a>

                <div class="row product-card__desc">

                    <div class="col-md-6 col-xs-6 col-12">
                        <a class="product-card__image" href="/<?= $product->url->alias ?>">
                            <?php if (isset($product->files[0])) : ?>
                                <?php echo ImageWidget::widget([
                                    'images' => $product->files[0],
                                    'options' => ['class' => 'product-card__img'],
                                    'preset' => '265x208',
//                                    'linkPreset' => '1200x900',
//                                    'linkOptions' => [
//                                        'class' => 'product-card__image',
//                                        'data-toggle' => 'lightbox',
//                                        'data-gallery' => 'product'
//                                    ]
                                ]); ?>
                            <?php endif; ?>
                        </a>
                    </div>

                    <div class="col-md-6 col-xs-6 col-12">
                        <ul class="product-card__attrs">
                            <?php foreach ($attributes as $attributeGroup) : ?>
                                <?php  if (isset($attributeGroup['attributes'])) : ?>
                                    <?php foreach ($attributeGroup['attributes'] as $attribute) : ?>
                                        <?php if (isset($product->attributeValue->value[$attribute['id']]) && $attribute['isShowInCard']) : ?>
                                            <li class="product-card__attr">
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

                        <a class="product-card__link" href="/<?= $product->url->alias ?>">Подробнее</a>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 col-xs-12">
                        <?php if ($product->isShowPrice) : ?>
                            <div class="product-card__price">от <span><?= $product->price ?></span> руб/час</div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 col-xs-12">
                        <a class="btn btn-primary btn-lg product-card__btn-rent" href="#">Арендовать</a>
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
