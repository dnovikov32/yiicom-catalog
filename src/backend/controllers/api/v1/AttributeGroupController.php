<?php

namespace yiicom\catalog\backend\controllers\api\v1;

use Yii;
use yii\helpers\Html;
use yii\web\ServerErrorHttpException;
use yiicom\backend\base\ApiController;
use yiicom\common\traits\ModelTrait;
use yiicom\catalog\common\models\AttributeGroup;
use yiicom\catalog\backend\models\AttributeGroupSearch;

class AttributeGroupController extends ApiController
{
    use ModelTrait;

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AttributeGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->route = '#/catalog/attribute-group/index';

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
                'attribute' => 'title',
            ],
            [
                'attribute' => 'name',
                'format' => 'html',
                'value' => function (AttributeGroupSearch $model) {
                    return Html::a($model->name, ['/#/catalog/attribute-group/update', 'id' => $model->id], [
                        'title' => 'Редактировать'
                    ]);
                }
            ],
            [
                'attribute' => 'position',
            ],
        ];
    }

    public function actionFind(int $id = null)
    {
        try {
            /* @var AttributeGroup $model */
            return $this->findOrNewModel(AttributeGroup::class, $id);

        } catch (\Throwable $e) {
            throw new ServerErrorHttpException(Yii::t("yiicom", "Server error: ") . $e->getMessage());
        }
    }

    public function actionSave()
    {
        try {
            /* @var AttributeGroup $model */
            $id = Yii::$app->request->post('id');
            $model = $this->findOrNewModel(AttributeGroup::class, $id);

            if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
                if (! $model->save()) {
                    throw new ServerErrorHttpException(Yii::t("yiicom", "Can't save model"));
                }
            }

            return $model;

        } catch (\Throwable $e) {
            throw new ServerErrorHttpException(Yii::t("yiicom", "Server error: ") . $e->getMessage());
        }
    }

    /**
     * @return array
     * @throws ServerErrorHttpException
     */
    public function actionDelete()
    {
        try {
            /* @var AttributeGroup $model */
            $id = Yii::$app->request->post('id');
            $model = $this->findModel(AttributeGroup::class, $id);

            if ($model->delete()) {
                // TODO: delete attributes?
                return ['status' => 'success'];
            }

            throw new ServerErrorHttpException(Yii::t("yiicom", "Can't delete model"));
            
        } catch (\Throwable $e) {
            throw new ServerErrorHttpException(Yii::t("yiicom", "Server error: ") . $e->getMessage());
        }
    }

    public function actionList()
    {
        return (new AttributeGroup)->getList();
    }

}
