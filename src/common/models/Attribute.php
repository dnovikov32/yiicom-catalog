<?php

namespace yiicom\catalog\common\models;

use Yii;
use yii\db\ActiveRecord;
use yiicom\common\interfaces\ModelList;
use yiicom\common\interfaces\ModelStatus;
use yiicom\common\traits\ModelListTrait;
use yiicom\common\traits\ModelStatusTrait;

/**
 * @property string $name
 * @property string $title
 * @property integer $groupId
 * @property integer $type
 * @property integer $position
 * @property boolean $isShowInCategory
 * @property boolean $isShowInProduct
 */
class Attribute extends ActiveRecord implements ModelStatus, ModelList
{
    use ModelStatusTrait, ModelListTrait;

    const TYPE_CHECKBOX = 1;
    const TYPE_INT = 2;
    
    /**
     * @inheritDoc
     */
	public static function tableName() {
		return '{{%catalog_attribute}}';
	}

    /**
     * @return array
     */
    public function typesList()
    {
        return [
            self::TYPE_CHECKBOX => 'Выбор значения',
            self::TYPE_INT => 'Числовое значение'
        ];
    }
	
    /**
     * @inheritDoc
     */
	public function rules()
	{
		return [
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'required'],
            ['name', 'string', 'max' => 255],
            ['name', 'match', 'pattern' => '/^[\w\-\_]+$/', 'message' => '{attribute}: доступны только латинские буквы, символ "-" и "_"'],
            
			['title', 'filter', 'filter' => 'trim'],
			['title', 'required'],
			['title', 'string', 'max' => 255],

            ['groupId', 'exist', 'targetClass' => AttributeGroup::class, 'targetAttribute' => 'id'],

            ['type', 'required'],
            ['type', 'in', 'range' => array_keys($this->typesList())],
            
			['position', 'integer'],
			['position', 'default', 'value' => 0],
            
            ['isShowInCategory', 'boolean'],
            ['isShowInProduct', 'default', 'value' => false],
            
            ['isShowInProduct', 'boolean'],
            ['isShowInProduct', 'default', 'value' => false],
		];
	}

    /**
     * @inheritDoc
     */
	public function attributeLabels()
	{
		return [
            'id' => Yii::t('yiicom', 'ID'),
            'name' => Yii::t('yiicom', 'System name'),
            'title' => Yii::t('yiicom', 'Title'),
            'type' => Yii::t('yiicom', 'Type'),
            'groupId' => Yii::t('yiicom', 'Group'),
            'position' => Yii::t('yiicom', 'Position'),
            'isShowInCategory' => Yii::t('yiicom', 'Show in categories'),
            'isShowInProduct' => Yii::t('yiicom', 'Show in product card'),
		];
	}

    /**
     * @inheritDoc
     */
    public function fields()
    {
        return [
            'id',
            'name',
            'title',
            'type',
            'groupId',
            'position',
            'isShowInCategory',
            'isShowInProduct',
        ];
    }

}
