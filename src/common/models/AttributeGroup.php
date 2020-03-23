<?php

namespace yiicom\catalog\common\models;

use Yii;
use yii\db\ActiveRecord;
use yiicom\common\interfaces\ModelList;
use yiicom\common\interfaces\ModelStatus;
use yiicom\common\traits\ModelListTrait;
use yiicom\common\traits\ModelStatusTrait;
use yiicom\catalog\common\models\Attribute;
use yiicom\catalog\common\models\AttributeType;
use yiicom\catalog\common\models\AttributeTypeTrait;

/**
 * @property string $name
 * @property string $title
 * @property integer $type
 * @property integer $position
 */
class AttributeGroup extends ActiveRecord implements ModelStatus, ModelList, AttributeType
{
    use ModelStatusTrait, ModelListTrait, AttributeTypeTrait;

    /**
     * @inheritDoc
     */
	public static function tableName() {
		return '{{%catalog_attribute_group}}';
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
            ['name', 'unique'],

			['title', 'filter', 'filter' => 'trim'],
			['title', 'required'],
			['title', 'string', 'max' => 255],

            ['type', 'required'],
            ['type', 'in', 'range' => array_keys($this->typesList())],

			['position', 'integer'],
			['position', 'default', 'value' => 0]
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
            'position' => Yii::t('yiicom', 'Position'),
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
            'position',
        ];
    }

}
