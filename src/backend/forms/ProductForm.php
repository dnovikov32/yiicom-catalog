<?php

namespace yiicom\catalog\backend\forms;

use yiicom\catalog\common\models\Product;

class ProductForm extends Product
{
    /**
     * @return string
     */
    public function getModelClass()
    {
        return Product::class;
    }

    /**
     * @return bool
     */
    public function process()
    {
        return $this->save(false);
    }

}