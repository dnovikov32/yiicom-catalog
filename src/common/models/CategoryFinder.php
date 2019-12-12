<?php

namespace yiicom\catalog\common\models;

class CategoryFinder extends Category
{
    private $query;

    /**
     * Return root category
     * @return Category|null
     */
    public function findRoot()
    {
        return Category::find()->roots()->one();
    }


    public function findChildrenIds(Category $category, bool $withCurrent = false)
    {
        $children = $category->children()->all();

        if (! $children) {
            return [];
        }

        $ids[$category->id] = $category->id;

        foreach ($this->childrens as $child) {
            $ids[$child->id] = $child->id;
        }

        return $ids;
    }

    public function findChildren(Category $category, bool $withCurrent = false)
    {
        $this->query = $category->children();

        return $this;

//        if (! $children) {
//            return [];
//        }
//
//        $ids[$category->id] = $category->id;
//
//        foreach ($this->childrens as $child) {
//            $ids[$child->id] = $child->id;
//        }
//
//        return $ids;
    }


    public function all()
    {
        return $this->query
            ? $this->query->all()
            : $this->all();
    }

    public function ids()
    {
        return $this->query
            ->select('id')
            ->column();
    }

}