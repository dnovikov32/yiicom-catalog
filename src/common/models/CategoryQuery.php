<?php

namespace yiicom\catalog\common\models;

use yii\db\ActiveQuery;
use creocoder\nestedsets\NestedSetsQueryBehavior;
use yiicom\catalog\common\models\Category;

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
     * @param int $id
     * @return $this
     */
    public function id(int $id)
    {
        $this->andWhere([Category::tableName().".id" => $id]);

        return $this;
    }
    
    /**
     * @return $this
     */
    public function withUrl()
    {
        $this->joinWith(['url']);

        return $this;
    }

}