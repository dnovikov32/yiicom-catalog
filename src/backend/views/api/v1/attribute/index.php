<?php

use yii\web\View;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yiicom\catalog\backend\models\AttributeSearch;
use yiicom\backend\grid\ActionColumn;

/**
 * @var View $this
 * @var AttributeSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 * @var array $columns
 */

?>

<?php echo GridView::widget([
    'id' => 'grid-catalog-attribute',
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'columns' => array_merge(
        $columns, [
        [
			'class' => ActionColumn::class,
			'template' => '{update} {delete}',
			'controller' => '/#/catalog/attribute',
            'headerOptions' => ['class' => 'wpx-75'],
        ]
    ]),
]); ?>
