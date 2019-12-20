<?php

namespace yiicom\catalog\common\models;

use yii\db\ActiveQuery;
use yiicom\common\interfaces\ModelStatus;

class ProductQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        $this->andWhere(['{{%catalog_products}}.status' => ModelStatus::STATUS_ACTIVE]);

        return $this;
    }

    /**
     * @return $this
     */
    public function category($ids = [])
    {
        $ids = (array) $ids;

        $this->joinWith(['productCategories'])
            ->andWhere(['IN', '{{%catalog_products_categories}}.categoryId', $ids]);

        return $this;
    }


}