<?php

namespace yiicom\catalog\common\models;

use yii\db\ActiveQuery;
use creocoder\nestedsets\NestedSetsQueryBehavior;

/**
 * @method ActiveQuery roots()
 * @method ActiveQuery leaves()
 */
class CategoryQuery extends ActiveQuery
{
	public function behaviors()
	{
		return [
			NestedSetsQueryBehavior::class,
		];
	}

    /**
     * @return CategoryQuery
     */
    public function withUrl()
    {
        $this->joinWith(['url']);

        return $this;
    }

}