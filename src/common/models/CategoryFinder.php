<?php

namespace yiicom\catalog\common\models;

class CategoryFinder extends Category
{
    /**
     * Return root category
     * @return Category|null
     */
    public function findRoot()
    {
        return Category::find()->roots()->one();
    }

}