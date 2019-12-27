<?php

namespace yiicom\catalog\backend\models;

use yii\db\ActiveQuery;
use yii\data\ActiveDataProvider;
use yiicom\backend\search\SearchModelInterface;
use yiicom\backend\search\SearchModelTrait;
use yiicom\catalog\common\models\Attribute;

class AttributeSearch extends Attribute implements SearchModelInterface
{
    use SearchModelTrait;
    
    /**
     * @return string
     */
    public function getModelClass()
    {
        return Attribute::class;
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [['id', 'groupId', 'type', 'position', 'isShowInCategory', 'isShowInProduct'], 'integer'],

            [['name', 'title'], 'safe'],
        ];
    }

    /**
     * @param ActiveQuery $query
     * @return ActiveDataProvider
     */
    protected function prepareDataProvider($query)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'position' => SORT_ASC
                ],
            ],
            'pagination'=> [
                'pageSize' => 100
            ]
        ]);

        return $dataProvider;
    }

    /**
     * @param ActiveQuery $query
     */
    protected function prepareFilters($query)
    {
        $query->andFilterWhere([
            '{{%catalog_attribute}}.id' => $this->id,
            '{{%catalog_attribute}}.position' => $this->position,
            '{{%catalog_attribute}}.groupId' => $this->groupId,
            '{{%catalog_attribute}}.type' => $this->type,
            '{{%catalog_attribute}}.isShowInCategory' => $this->isShowInCategory,
            '{{%catalog_attribute}}.isShowInProduct' => $this->isShowInProduct,
        ]);

        $query->andFilterWhere(['LIKE', '{{%catalog_attribute}}.name', $this->name]);
        $query->andFilterWhere(['LIKE', '{{%catalog_attribute}}.title', $this->title]);
    }
}
