<?php

namespace yiicom\catalog\common\models;

use yii\db\ActiveQuery;
use creocoder\nestedsets\NestedSetsQueryBehavior;

class CategoryQuery extends ActiveQuery
{
	public function behaviors()
	{
		return [
			NestedSetsQueryBehavior::class,
		];
	}
}