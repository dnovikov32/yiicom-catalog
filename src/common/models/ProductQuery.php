<?php

namespace yiicom\catalog\common\models;

use yii\db\ActiveQuery;
use yiicom\common\interfaces\ModelStatus;
use yiicom\catalog\common\models\Product;
use yiicom\catalog\common\models\ProductCategory;

class ProductQuery extends ActiveQuery
{
    /**
     * @return self
     */
    public function withUrl()
    {
        $this->joinWith(['url']);

        return $this;
    }

    /**
     * @return self
     */
    public function withFiles()
    {
        $this->joinWith(['files']);

        return $this;
    }

    /**
     * @return self
     */
    public function withAttributeValue()
    {
        $this->joinWith(['attributeValue']);

        return $this;
    }

    /**
     * @return self
     */
    public function active()
    {
        $catalogProduct = Product::tableName();

        $this->andWhere(["$catalogProduct.status" => ModelStatus::STATUS_ACTIVE]);

        return $this;
    }

    /**
     * @return self
     */
    public function category($ids = [])
    {
        $ids = (array) $ids;
        $catalogProductCategory = ProductCategory::tableName();

        $this->joinWith(['categories'])
            ->andWhere(['IN', "$catalogProductCategory.categoryId", $ids]);

        return $this;
    }


}