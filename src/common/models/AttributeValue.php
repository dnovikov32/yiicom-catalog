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
		return '{{%catalog_attribute_value}}';
	}
    
    /**
     * @inheritDoc
     */
	public function rules()
	{
		return [
			['productId', 'integer'],

            ['value', 'safe'],
		];
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yiicom', 'ID'),
            'productId' => Yii::t('yiicom', 'Product ID'),
            'value' => Yii::t('yiicom', 'Value'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id',
            'productId',
            'value' => function ($model) {
                // TODO: (shame) an empty property (['' => null]) is added so that when converting to json,
                // an object is returned rather than an array
                return $model->value ? $model->value : ['' => null];
            },
        ];
    }
}
