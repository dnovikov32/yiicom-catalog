<?php

namespace yiicom\catalog\backend\controllers\api\v1;

use Yii;
use yii\helpers\Html;
use yii\web\ServerErrorHttpException;
use yiicom\backend\base\ApiController;
use yiicom\common\traits\ModelTrait;
use yiicom\content\common\grid\UrlAliasColumn;
use yiicom\catalog\common\models\Product;
use yiicom\catalog\backend\models\ProductSearch;
use yiicom\catalog\backend\forms\ProductForm;

class ProductController extends ApiController
{
    use ModelTrait;

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->route = '#/catalog/product/index';

        return $this->renderPartial('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'columns' => $this->getGridColumns(),
        ]);
    }

    /**
     * @return array
     */
    public function getGridColumns()
    {
        return [
            [
                'attribute' => 'id',
                'headerOptions' => ['class' => 'wpx-70'],
            ],
            [
                'attribute' => 'name',
                'format' => 'html',
                'value' => function (ProductSearch $model) {
                    return Html::a($model->name, ['/#/catalog/product/update', 'id' => $model->id], [
                        'title' => 'Редактировать'
                    ]);
                }
            ],
            [
                'attribute' => 'alias',
                'class' => UrlAliasColumn::class
            ],
            [
                'attribute' => 'title',
            ],
            [
                'attribute' => 'status',
                'filter' => (new Product)->statusesList(),
                'value' => function(ProductSearch $model) {
                    return $model->statusesList()[$model->status];
                }
            ],
        ];
    }

    public function actionFind(int $id = null)
    {
        try {
            /* @var ProductForm $model */
            $model = $this->findOrNewModel(ProductForm::class, $id);

            return $model;

        } catch (\Throwable $e) {
            throw new ServerErrorHttpException(Yii::t("yiicom", "Server error: ") . $e->getMessage());
        }
    }

    public function actionSave()
    {
        try {
            /* @var ProductForm $model */
            $id = Yii::$app->request->post('id');
            $model = $this->findOrNewModel(ProductForm::class, $id);

            if ($model->loadAll(Yii::$app->request->post()) && $model->validateAll()) {
                if (! $model->process()) {
                    throw new ServerErrorHttpException(Yii::t("yiicom", "Can't save model"));
                }
            }

            return $model;

        } catch (\Throwable $e) {
            throw new ServerErrorHttpException(Yii::t("yiicom", "Server error: ") . $e->getMessage() . "\n" .  $e->getTraceAsString());
        }
    }

    /**
     * @return array
     * @throws ServerErrorHttpException
     */
    public function actionDelete()
    {
        try {
            /* @var CategoryForm $model */
            $id = Yii::$app->request->post('id');
            $model = $this->findModel(ProductForm::class, $id);

            if ($model->delete()) {
                // TODO: delete images with presets
                return ['status' => 'success'];
            }

            throw new ServerErrorHttpException(Yii::t("yiicom", "Can't delete model"));

        } catch (\Throwable $e) {
            throw new ServerErrorHttpException(Yii::t("yiicom", "Server error: ") . $e->getMessage());
        }
    }
    

}
