<?php

use yii\web\View;
use yii\helpers\Html;
use yiicom\catalog\common\models\Product;
use yiicom\catalog\common\models\Category;
use yiicom\files\common\models\File;
use yiicom\files\common\widgets\ImageWidget;

/**
 * @var View $this
 * @var Product $product
 * @var File[] $images
 * @var Category $category
 * @var Category[] $categoryParents
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

<h1><?php echo Html::encode($product->title ?: $product->name); ?></h1>

<div class="row">
    <div class="col-md-6">

        <div class="product__image">
            <?php if (isset($images[0])) : ?>
                <?php echo ImageWidget::widget([
                    'images' => $images[0],
                    'preset' => '560x360',
                    'linkPreset' => '1200x900',
                    'linkOptions' => ['data-toggle' => 'lightbox', 'data-gallery' => 'product']
                ]); ?>
            <?php endif; ?>
        </div>

        <?php if(count($images) > 1) : ?>
            <div class="product__images js-slider" data-name="product">
                <?php echo ImageWidget::widget([
                    'images' => $images,
                    'from' => 1,
                    'preset' => '100x100',
                    'dataPreset' => '560x360',
                    'linkPreset' => '1200x900',
                    'linkOptions' => [
                        'class' => 'product__img-link',
                        'data-toggle' => 'lightbox',
                        'data-gallery' => 'product'
                    ],
                    'options' => ['class' => 'product__img']
                ]); ?>
            </div>
        <?php endif; ?>
        
        
    </div>
</div>


<?php if ($product->teaser) : ?>
    <div class="product__teaser">
        <?= $product->teaser ?>
    </div>
<?php endif; ?>



<?php if ($product->body) : ?>
    <div class="product__body">
        <?= $product->body ?>
    </div>
<?php endif; ?>









