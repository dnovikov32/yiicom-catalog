<?php

namespace yiicom\catalog\backend\forms;

use yiicom\catalog\common\models\Category;

class CategoryForm extends Category
{
    /**
     * @return string
     */
    public function getModelClass()
    {
        return Category::class;
    }

    /**
     * @return bool
     */
    public function process()
    {
        $root = Category::find()->roots()->one();

        if (! $root) {
            return $this->makeRoot();
        }

        $parent = $this->parent;

        if ($parent) {
            return $this->appendTo($parent);
        } else {
            return $this->save();
        }
    }

}