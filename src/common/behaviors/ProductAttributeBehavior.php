<?php

namespace yiicom\catalog\common\behaviors;

use yii\base\Behavior;
use yii\base\Exception;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yiicom\catalog\common\models\Product;
use yiicom\catalog\common\models\AttributeValue;

class ProductAttributeBehavior extends Behavior
{
    /**
     * @var string
     */
    public $attribute = 'attributeValue';

    /**
     * @inheritdoc
     */
	public function events()
	{
		return [
			ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
			ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
		];
	}

    /**
     * @return ActiveQuery
     */
	public function getAttributeValue()
	{
	    /** @var Product $owner */
	    $owner = $this->owner;

		return $this->owner->hasOne(AttributeValue::class, ['productId' => 'id']);
	}

	public function afterSave()
	{
        /** @var Product $owner */
        $owner = $this->owner;
        $values = array_filter($this->owner->{$this->attribute}->value);

        AttributeValue::deleteAll('productId = :productId', [':productId' => $owner->id]);

        if (! $values) {
            return;
        }

        $model = new AttributeValue();
        $model->productId = $owner->id;
        $model->value = $values;

        if (! $model->save()) {
            throw new Exception("Can't save AttributeValue model: " . implode(', ', $model->getFirstErrors()));
        }
	}

    /**
     * @return false|int
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function beforeDelete()
    {
        $attributeValue = $this->getAttributeValue()->one();

        return $attributeValue ? $attributeValue->delete() : true;
    }
}
