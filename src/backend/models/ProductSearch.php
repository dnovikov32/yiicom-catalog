<?php

namespace yiicom\catalog\backend\models;

use Yii;
use yii\db\ActiveQuery;
use yii\data\ActiveDataProvider;
use yiicom\backend\search\SearchModelInterface;
use yiicom\backend\search\SearchModelTrait;
use yiicom\catalog\common\models\Product;
use yiicom\content\common\models\PageUrl;

class ProductSearch extends Product implements SearchModelInterface
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
        return Product::class;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'price'], 'integer'],

            [['name', 'title', 'alias'], 'safe'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'alias' => Yii::t('yiicom', 'Alias'),
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

//    /**
//     * @param ActiveQuery $query
//     * @return ActiveDataProvider
//     */
//    protected function prepareDataProvider($query)
//    {
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//            'sort' => [
//                'defaultOrder' => [
//                    'left' => SORT_ASC
//                ],
//            ],
//            'pagination'=> [
//                'pageSize' => 100
//            ]
//        ]);
//
//        return $dataProvider;
//    }

    /**
     * @param ActiveQuery $query
     */
    protected function prepareFilters($query)
    {
        $catalogProduct = Product::tableName();
        $contentUrl = PageUrl::tableName();

        $query->andFilterWhere([
            "$catalogProduct.id" => $this->id
        ]);

        $query->andFilterWhere(['LIKE', "$catalogProduct.name", $this->name]);
        $query->andFilterWhere(['LIKE', "$catalogProduct.title", $this->title]);
        $query->andFilterWhere(['LIKE', "$contentUrl.alias", $this->alias]);
    }
}
