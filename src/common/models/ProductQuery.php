<?php

namespace yiicom\catalog\common\models;

use yii\db\ActiveQuery;
use yiicom\common\interfaces\ModelStatus;
use yiicom\catalog\common\models\Product;
use yiicom\catalog\common\models\ProductCategory;

class ProductQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function withUrl()
    {
        $this->joinWith(['url']);

        return $this;
    }

    /**
     * @return $this
     */
    public function withFiles()
    {
        $this->joinWith(['files']);

        return $this;
    }

    /**
     * @return $this
     */
    public function withAttributeValue()
    {
        $this->joinWith(['attributeValue']);

        return $this;
    }

    /**
     * @return $this
     */
    public function withCategories()
    {
        $this->joinWith(['categories']);

        return $this;
    }

    /**
     * @return $this
     */
    public function withCategory()
    {
        $this->joinWith(['category']);

        return $this;
    }

    /**
     * @return $this
     */
    public function active()
    {
        $catalogProduct = Product::tableName();

        $this->andWhere(["$catalogProduct.status" => ModelStatus::STATUS_ACTIVE]);

        return $this;
    }

    /**
     * @param array $ids
     * @return $this
     */
    public function category($ids = [])
    {
        $ids = (array) $ids;
        $catalogProductCategory = ProductCategory::tableName();

        $this->withCategories()
            ->andWhere(['IN', "$catalogProductCategory.categoryId", $ids]);

        return $this;
    }


}