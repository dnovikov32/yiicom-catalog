<?php

namespace yiicom\catalog\common\lists;

use yii\db\ActiveQuery;
use yiicom\catalog\common\models\Attribute;
use yiicom\catalog\common\models\AttributeGroup;

class AttributeList
{
    /**
     * @var ActiveQuery
     */
    private $query;

    /**
     * @var array
     */
    private $items = [];

    public function __construct()
    {
        $catalogAttribute = Attribute::tableName();
        $catalogAttributeGroup = AttributeGroup::tableName();
        
        $this->query = Attribute::find()
            ->joinWith(['group'])
            ->orderBy("$catalogAttributeGroup.position, $catalogAttribute.position");
    }

    /**
     * @param array $params
     * @return $this
     */
    public function filter(array $params)
    {
        $this->query->andWhere($params);

        return $this;
    }

    /**
     * Returns grouped attributes list
     *
     * ```php
     * ```
     *
     * @return array
     */
    public function get()
    {
        $groups = [];
        $attributes = [];

        foreach ($this->query->all() as $index => $attribute) {
            /* @var Attribute $attribute */
            $group = $attribute->group;

            if ($group) {
                if (! isset($this->items[$group->name])) {
                    $this->items[$group->name] = $attribute->group->toArray();
                }

                $this->items[$group->name]['attributes'][] = $attribute->toArray();
            } else {
                $attributes['attributes'][] = $attribute->toArray();
            }
        }

        // Adds attributes without a group to the end of the array
        $this->items[''] = $attributes;

        return $this->items;
    }

}