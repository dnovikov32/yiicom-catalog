<?php

use yii\web\View;
use yii\helpers\Html;
use yiicom\catalog\common\models\Product;

/**
 * @var View $this
 * @var Product $product
 */

?>

<h1><?php echo Html::encode($product->title ? $product->title : $product->name); ?></h1>

<div>Default yiicom/catalog/product view page template</div>

<?php echo '<pre>'; print_r($product);echo '</pre>'; ?>








