<?php

namespace yiicom\catalog\common\behaviors;

use yii\base\Behavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yiicom\catalog\common\models\AttributeValue;

class ProductAttributeBehavior extends Behavior
{
    /**
     * @var string
     */
    public $attribute = 'attributeValues';

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
	public function getAttributeValues()
	{
	    /** @var Product $owner */
	    $owner = $this->owner;

		return $this->owner->hasOne(AttributeValue::className(), ['productId' => 'id']);
	}

    /**
     * @param $value
     */
	public function setAttributeValues($value)
	{
		$this->owner->{$this->attribute} = $value;
	}
//
//
//	public function getAttrsList()
//	{
//		return ArrayHelper::index($this->owner->attrs, 'attributeId');
//	}

	public function afterSave()
	{
	    echo '<pre>attribute'; print_r($this->owner->{$this->attribute});echo '</pre>';
	    exit;

		$attrs = [
		    1 => 12,
            2 => 1,
            3 => 'ололол'
        ];
//
		foreach($this->owner->{$this->attribute} as $id => $attr) {
			$attrs[$attr->attributeId] = (int)$attr->value;
		}

        /** @var Product $owner */
	    $owner = $this->owner;

		if ($attrs) {
            AttributeValue::updateAll(['value' => json_encode($attrs, JSON_UNESCAPED_UNICODE)], ['productId' => $owner->id]);
		}

	}

    /**
     * @return false|int
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function beforeDelete()
    {
        $attributeValue = $this->getAttributeValues()->one();

        return $attributeValue->delete();
    }
}
