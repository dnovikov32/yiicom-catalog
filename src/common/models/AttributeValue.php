<?php

namespace yiicom\catalog\common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $productId
 * @property string $value
 */
class AttributeValue extends ActiveRecord
{
    /**
     * @inheritDoc
     */
	public static function tableName()
	{
		return '{{%catalog_products_categories}}';
	}
    
    /**
     * @inheritDoc
     */
	public function rules()
	{
		return [
            ['productId', 'required'],
			['productId', 'integer'],

            ['value', 'string'],
		];
	}

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id' => Yii::t('yiicom', 'ID'),
            'productId' => Yii::t('yiicom', 'Product ID'),
            'value' => Yii::t('yiicom', 'Value'),
        ];
    }
}
