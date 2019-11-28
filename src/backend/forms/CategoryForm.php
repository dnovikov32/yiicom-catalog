<?php

namespace yiicom\catalog\backend\forms;

use yiicom\catalog\common\models\Category;
use yiicom\catalog\common\models\CategoryFinder;

class CategoryForm extends Category
{
    /**
     * @return string
     */
    public function modelClass()
    {
        return Category::class;
    }

    /**
     * @return bool
     */
    public function process()
    {
        $root = (new CategoryFinder)->findRoot();
        
        if (! $root) {
            return $this->makeRoot();
        }

        $parent = $this->getParent();

        if ($parent) {
            return $this->appendTo($parent);
        } else {
            return $this->save();
        }
    }

}