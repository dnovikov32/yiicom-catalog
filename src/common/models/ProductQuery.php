<?php

namespace yiicom\catalog\common\models;

use yii\db\ActiveQuery;
use yiicom\common\interfaces\ModelStatus;

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
    public function active()
    {
        $this->andWhere(['{{%catalog_products}}.status' => ModelStatus::STATUS_ACTIVE]);

        return $this;
    }

    /**
     * @return self
     */
    public function category($ids = [])
    {
        $ids = (array) $ids;

        $this->joinWith(['categories'])
            ->andWhere(['IN', '{{%catalog_products_categories}}.categoryId', $ids]);

        return $this;
    }


}