<?php

namespace yiicom\catalog\backend\models;

use yii\db\ActiveQuery;
use yii\data\ActiveDataProvider;
use yiicom\backend\search\SearchModelInterface;
use yiicom\backend\search\SearchModelTrait;
use yiicom\content\common\models\PageUrl;
use yiicom\catalog\common\models\Category;

class CategorySearch extends Category implements SearchModelInterface
{
    use SearchModelTrait;

    /**
     * @var string
     */
    public $alias;

    /**
     * @return string
     */
    public function getModelClass()
    {
        return Category::class;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],

            [['name', 'title', 'alias'], 'safe'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'alias' => 'Адрес страницы'
        ]);
    }

    /**
     * @return ActiveQuery
     */
    protected function prepareQuery()
    {
        $query = static::find();

        $query->joinWith(['url']);

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
                'defaultOrder' => [
                    'left' => SORT_ASC
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
        $catalogCategory = Category::tableName();
        $contentUrl = PageUrl::tableName();
        
        $query->andFilterWhere([
            "$catalogCategory.id" => $this->id
        ]);

        $query->andFilterWhere(['LIKE', "$catalogCategory.name", $this->name]);
        $query->andFilterWhere(['LIKE', "$catalogCategory.title", $this->title]);
        $query->andFilterWhere(['LIKE', "$contentUrl.alias", $this->alias]);
    }
}
