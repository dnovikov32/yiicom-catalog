<?php

namespace yiicom\catalog\common\lists;

use yii\db\ActiveQuery;
use yiicom\catalog\common\models\Attribute;

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
        $this->query = Attribute::find()
            ->joinWith(['group'])
            ->orderBy('{{%catalog_attribute_group}}.position, {{%catalog_attribute}}.position');
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
     * [
     *      [
     *          'name' => 'groupSystemName',
     *          'title' => 'Group title',
     *          'attributes' => [
     *              [
     *                  'id' => 1,
     *                  'name' => 'attributeSystemName',
     *                  'title' => 'Attribute title',
     *                  'value' => 'Some value',
     *                  'type' => 1,
     *                  'prefix' => '',
     *                  'postfix' => '',
     *                  'isShowInCard' => true,
     *                  'isShowInProduct' => false,
     *              ],
     *              ...
     *          ]
     *      ],
     *      [
     *          'attributes' => [
     *              [
     *                  // Attribute without group
     *              ],
     *              ...
     *          ]
     *      ]
     * ]
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

            if ($attribute->groupId) {
                if (! isset($groups[$attribute->groupId])) {
                    $groups[$attribute->groupId] = $attribute->group->toArray();
                }
                $groups[$attribute->groupId]['attributes'][] = $attribute->toArray();
            } else {
                $attributes[] = $attribute->toArray();
            }
        }

        foreach ($groups as $groupId => $group) {
            $this->items[] = $group;
        }

        $this->items[]['attributes'] = $attributes;

        return $this->items;
    }

}