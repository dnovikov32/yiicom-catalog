<?php

namespace yiicom\catalog\common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yiicom\common\helpers\BooleanHelper;

/**
 * @property integer $id
 * @property integer $productId
 * @property integer $categoryId
 * @property integer $isMain
 */
class ProductCategory extends ActiveRecord
{
    /**
     * @inheritDoc
     */
	public static function tableName()
	{
		return '{{%catalog_product_category}}';
	}
    
    /**
     * @inheritDoc
     */
	public function rules()
	{
		return [
            ['productId', 'required'],
			['productId', 'integer'],

            ['categoryId', 'required'],
            ['categoryId', 'integer'],
            
			['isMain', 'in', 'range' => (new BooleanHelper())->statusesOptions()],
			['isMain', 'default', 'value' => BooleanHelper::STATUS_NO],
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
            'categoryId',
            'isMain',
        ];
    }
}
