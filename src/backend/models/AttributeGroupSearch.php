<?php

namespace yiicom\catalog\backend\models;

use yii\db\ActiveQuery;
use yii\data\ActiveDataProvider;
use yiicom\backend\search\SearchModelInterface;
use yiicom\backend\search\SearchModelTrait;
use yiicom\catalog\common\models\AttributeGroup;

class AttributeGroupSearch extends AttributeGroup implements SearchModelInterface
{
    use SearchModelTrait;
    
    /**
     * @return string
     */
    public function getModelClass()
    {
        return AttributeGroup::class;
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [['id', 'position'], 'integer'],

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
        $catalogAttributeGroup = AttributeGroup::tableName();

        $query->andFilterWhere([
            "$catalogAttributeGroup.id" => $this->id,
            "$catalogAttributeGroup.position" => $this->position,
        ]);

        $query->andFilterWhere(['LIKE', "$catalogAttributeGroup.name", $this->name]);
        $query->andFilterWhere(['LIKE', "$catalogAttributeGroup.title", $this->title]);
    }
}
