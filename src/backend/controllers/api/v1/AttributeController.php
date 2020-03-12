<?php

namespace yiicom\catalog\backend\controllers\api\v1;

use Yii;
use yii\helpers\Html;
use yii\web\ServerErrorHttpException;
use yiicom\backend\base\ApiController;
use yiicom\common\traits\ModelTrait;
use yiicom\catalog\common\models\Attribute;
use yiicom\catalog\common\models\AttributeGroup;
use yiicom\catalog\backend\models\AttributeSearch;
use yiicom\catalog\common\lists\AttributeList;

class AttributeController extends ApiController
{
    use ModelTrait;

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AttributeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->route = '#/catalog/attribute/index';

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
        $groups = (new AttributeGroup)->getList();

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
                'value' => function (AttributeSearch $model) {
                    return Html::a($model->name, ['/#/catalog/attribute/update', 'id' => $model->id], [
                        'title' => 'Редактировать'
                    ]);
                }
            ],
            [
                'attribute' => 'type',
                'value' => function (AttributeSearch $model) {
                    return $model->typesList()[$model->type] ?? 'Нет';
                }
            ],
            [
                'attribute' => 'groupId',
                'filter' => $groups,
                'value' => function (AttributeSearch $model) {
                    return $model->group->title ?? 'Нет';
                }
            ],
            [
                'attribute' => 'position',
            ],
            [
                'attribute' => 'isShowInCard',
                'format' => 'boolean'
            ],
            [
                'attribute' => 'isShowInProduct',
                'format' => 'boolean'
            ],
        ];
    }

    public function actionFind(int $id = null)
    {
        try {
            /* @var Attribute $model */
            $model = $this->findOrNewModel(Attribute::class, $id);

            if ($model->isNewRecord) {
                $model->type = Attribute::TYPE_CHECKBOX;
//                $model->groupId = AttributeGroup::find()->orderBy('id')->one()->id;
            }

            return $model;

        } catch (\Throwable $e) {
            throw new ServerErrorHttpException(Yii::t("yiicom", "Server error: ") . $e->getMessage());
        }
    }

    public function actionSave()
    {
        try {
            /* @var Attribute $model */
            $id = Yii::$app->request->post('id');
            $model = $this->findOrNewModel(Attribute::class, $id);

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
            /* @var Attribute $model */
            $id = Yii::$app->request->post('id');
            $model = $this->findModel(Attribute::class, $id);

            if ($model->delete()) {
                return ['status' => 'success'];
            }

            throw new ServerErrorHttpException(Yii::t("yiicom", "Can't delete model"));
            
        } catch (\Throwable $e) {
            throw new ServerErrorHttpException(Yii::t("yiicom", "Server error: ") . $e->getMessage());
        }
    }

    public function actionList(bool $root = false, int $id = null)
    {
        return (new AttributeList())->get();
    }

}
