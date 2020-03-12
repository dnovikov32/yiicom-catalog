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
            [['id', 'groupId', 'type', 'position', 'isShowInCard', 'isShowInProduct'], 'integer'],

            [['name', 'title'], 'safe'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    protected function prepareQuery()
    {
        $query = static::find();
        $query->joinWith('group');

        return $query;
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
                'attributes' => [
                    'position' => [
                        'asc' => ['{{%catalog_attribute_group}}.position' => SORT_ASC, '{{%catalog_attribute}}.position' => SORT_ASC],
                        'desc' => ['{{%catalog_attribute_group}}.position' => SORT_DESC, '{{%catalog_attribute}}.position' => SORT_DESC],
                    ],
                ],
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
            '{{%catalog_attribute}}.isShowInCard' => $this->isShowInCard,
            '{{%catalog_attribute}}.isShowInProduct' => $this->isShowInProduct,
        ]);

        $query->andFilterWhere(['LIKE', '{{%catalog_attribute}}.name', $this->name]);
        $query->andFilterWhere(['LIKE', '{{%catalog_attribute}}.title', $this->title]);
    }
}
