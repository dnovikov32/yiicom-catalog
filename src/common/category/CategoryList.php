<?php

namespace yiicom\catalog\common\category;

use yii\db\ActiveQuery;
use yiicom\catalog\common\models\Category;

class CategoryList
{
    /**
     * @var ActiveQuery
     */
    private $_query;

    /**
     * @var array
     */
    private $_disabledIds;

    /**
     * @var array
     */
    private $_items;

    /**
     * @param bool $root Add root category to results. The default value is `false`.
     * @param array $disabledIds Category IDs to disable. The default value id `[]`
     */
    public function __construct(bool $root = false, $disabledIds = [])
    {
        $this->_query = Category::find()->orderBy('left');
        $this->root($root);
        $this->disable($disabledIds);
    }

    /**
     * Add root category to results
     * @param bool $value
     * @return $this
     */
    public function root(bool $value)
    {
        if ($value) {
            $this->_query->where('1 = 1');
        } else {
            $this->_query->where('level != 0');
        }

        return $this;
    }

    /**
     * Adds the property `disabled` to the specified categories
     * @param array|int $disabledIds Category IDs to disable
     * @return $this
     */
    public function disable($disabledIds)
    {
        $this->_disabledIds = (array) $disabledIds;

        return $this;
    }

    /**
     * Returns items list
     *
     * ```php
     * [
     *      [
     *          'value' => 5,
     *          'text' => 'Catalog name',
     *      ],
     *      [
     *          'value' => 7,
     *          'text' => 'Category example',
     *          'disabled' => true
     *      ]
     * ]
     * ```
     *
     * @return array
     */
    public function get()
    {
        $disabledIndex = null;
        $disabledLevel = null;

        foreach ($this->_query->all() as $index => $category) {
            /* @var Category $category */
            $item = [
                'value' => $category->id,
                'text' => str_repeat('...', $category->level) . ' '  . $category->name
            ];

            // Adds a disabled label to the current element
            if ( $this->_disabledIds && in_array($category->id,  $this->_disabledIds) ) {
                $item['disabled'] = true;
                $disabledIndex = $index;
                $disabledLevel = $category->level;
            }

            // Adds a disabled label to children elements
            if ( ($index - 1 === $disabledIndex) && ($category->level > $disabledLevel) ) {
                $item['disabled'] = true;
                $disabledIndex = $index;
            }

            $this->_items[] = $item;
        }

        return $this->_items;
    }

}