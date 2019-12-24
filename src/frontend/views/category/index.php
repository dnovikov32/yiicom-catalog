<?php

use yii\web\View;
use yii\helpers\Html;
use yiicom\catalog\common\models\Category;

/**
 * @var View $this
 * @var Category $category
 */

$this->params['breadcrumbs'][] = Html::encode($category->title ?: $category->name);

// TODO: change to dynamic menu
$catalogMenu = Yii::$app->params['menuMain'][0]['items'] ?? null;
?>

<h1><?= Html::encode($category->title ?: $category->name) ?></h1>

<?php if ($category->teaser) : ?>
    <div class="category__teaser">
        <?= $category->teaser ?>
    </div>
<?php endif; ?>

<?php if ($catalogMenu) : ?>
    <div class="row">
        <?php foreach ($catalogMenu as $cat) : ?>
            <div class="col-md-6 col-sm-12 catalog__block">
                <h3 class="catalog__title"><a href="/<?= $cat['link'] ?>"><?= $cat['text'] ?></a></h3>

                <?php if (isset($cat['items'])) : ?>
                    <ul class="catalog__list">
                        <?php foreach ($cat['items'] as $item) : ?>
                            <li class="catalog__item">
                                <a class="catalog__link" href="/<?= $item['link'] ?>"><?= $item['text'] ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if ($category->body) : ?>
    <div class="category__body">
        <?= $category->body ?>
    </div>
<?php endif; ?>