<?php

namespace yiicom\catalog\backend\models;

use yii\db\ActiveQuery;
use yii\data\ActiveDataProvider;
use yiicom\backend\search\SearchModelInterface;
use yiicom\backend\search\SearchModelTrait;
use yiicom\catalog\common\models\Attribute;
use yiicom\catalog\common\models\AttributeGroup;

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
        $catalogAttribute = Attribute::tableName();
        $catalogAttributeGroup = AttributeGroup::tableName();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'position' => [
                        'asc' => ["$catalogAttributeGroup.position" => SORT_ASC, "$catalogAttribute.position" => SORT_ASC],
                        'desc' => ["$catalogAttributeGroup.position" => SORT_DESC, "$catalogAttribute.position" => SORT_DESC],
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
        $catalogAttribute = Attribute::tableName();

        $query->andFilterWhere([
            "$catalogAttribute.id" => $this->id,
            "$catalogAttribute.position" => $this->position,
            "$catalogAttribute.groupId" => $this->groupId,
            "$catalogAttribute.type" => $this->type,
            "$catalogAttribute.isShowInCard" => $this->isShowInCard,
            "$catalogAttribute.isShowInProduct" => $this->isShowInProduct,
        ]);

        $query->andFilterWhere(['LIKE', "$catalogAttribute.name", $this->name]);
        $query->andFilterWhere(['LIKE', "$catalogAttribute.title", $this->title]);
    }
}
