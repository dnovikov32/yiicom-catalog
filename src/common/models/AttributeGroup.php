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
 * @property integer $position
 */
class AttributeGroup extends ActiveRecord implements ModelStatus, ModelList
{
    use ModelStatusTrait, ModelListTrait;

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
            'position',
        ];
    }

}
