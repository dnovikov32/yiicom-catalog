<?php

namespace yiicom\catalog\common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yiicom\common\interfaces\ModelStatus;
use yiicom\common\interfaces\ModelList;
use yiicom\common\interfaces\ModelRelations;
use yiicom\common\traits\ModelStatusTrait;
use yiicom\common\traits\ModelListTrait;
use yiicom\common\traits\ModelRelationsTrait;
use yiicom\common\helpers\BooleanHelper;
use yiicom\catalog\common\models\ProductQuery;
use yiicom\catalog\common\models\ProductCategory;
use yiicom\catalog\common\behaviors\ProductCategoryBehavior;
use yiicom\content\common\behaviors\PageUrlBehavior;
use yiicom\content\common\interfaces\ModelPageUrl;
use yiicom\content\common\models\PageUrl;
use yiicom\content\common\traits\ModelPageUrlTrait;
use yiicom\files\common\behaviors\FilesBehavior;
use yiicom\files\common\models\File;

/**
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $teaser
 * @property string $body
 * @property integer $price
 * @property bool $isShowPrice
 * @property bool $status
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property ProductCategory[] $productCategories
 * @property Category[] $categoies
 * @property Category $category Main category
 * @property File[] $files
 */
class Product extends ActiveRecord implements ModelStatus, ModelList, ModelRelations, ModelPageUrl
{
    use ModelStatusTrait, ModelListTrait, ModelRelationsTrait, ModelPageUrlTrait;

    /**
     * @inheritDoc
     */
	public static function tableName()
	{
		return '{{%catalog_products}}';
	}

    /**
     * @return ProductQuery
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
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

            ['title', 'filter', 'filter' => 'trim'],
            ['title', 'string', 'max' => 255],

            ['teaser', 'safe'],

            ['body', 'safe'],
            
			['price', 'filter', 'filter' => 'trim'],
			['price', 'number'],
			['price', 'default', 'value' => 0],
            
			['isShowPrice', 'in', 'range' => (new BooleanHelper())->statusesOptions()],
			['isShowPrice', 'default', 'value' => BooleanHelper::STATUS_YES],

            ['status', 'in', 'range' => $this->statusesOptions()],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            
            [['createdAt', 'updatedAt'], 'safe'],
		];
	}

	public function attributeLabels() {
		return [
            'id' => Yii::t('yiicom', 'ID'),
            'name' => Yii::t('yiicom', 'Name'),
            'title' => Yii::t('yiicom', 'Title'),
            'teaser' => Yii::t('yiicom', 'Teaser'),
            'body' => Yii::t('yiicom', 'Content'),
            'price' => Yii::t('yiicom', 'Price'),
            'isShowPrice' => Yii::t('yiicom', 'Show price'),
            'status' => Yii::t('yiicom', 'Status'),
            'createdAt' => Yii::t('yiicom', 'Created At'),
            'updatedAt' => Yii::t('yiicom', 'Updated At'),
		];
	}

    /**
     * @inheritDoc
     */
    public function route()
    {
        return 'catalog/product/view';
    }

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'Timestamp' => [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => 'updatedAt',
            ],
            'PageUrlBehavior' => [
                'class' => PageUrlBehavior::class,
            ],
            'FilesBehavior' => [
                'class' => FilesBehavior::class,
            ],
            'ProductCategoryBehavior' => [
                'class' => ProductCategoryBehavior::class,
            ],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function relations()
    {
        return [
            'ProductCategories' => [
                'class' => ProductCategory::class,
                'attribute' => 'productCategories',
                'multiple' => true,
            ],
            'PageUrl' => [
                'class' => PageUrl::class,
                'attribute' => 'url',
            ],
            'Files' => [
                'class' => File::class,
                'attribute' => 'files',
                'multiple' => true,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id',
            'name',
            'title',
            'teaser',
            'body',
            'price',
            'isShowPrice',
            'status',
            'productCategories',
            'url',
            'files',
        ];
    }
}
