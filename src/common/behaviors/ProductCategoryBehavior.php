<?php

namespace yiicom\catalog\common\behaviors;

use yii\base\Behavior;
use yii\base\Exception;
use yii\db\ActiveQuery;
use yiicom\common\models\ActiveRecord;
use yiicom\catalog\common\models\Product;
use yiicom\catalog\common\models\ProductCategory;
use yiicom\catalog\common\models\Category;

class ProductCategoryBehavior extends Behavior
{
    /**
     * @var string
     */
    public $attribute = 'productCategories';

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
	public function getProductCategories()
    {
        /* @var Product $owner */
        $owner = $this->owner;

        return $owner->hasMany(ProductCategory::class, ['productId' => 'id']);
    }

    /**
     * @param array $value
     */
    public function setProductCategories($value)
    {
        $this->owner->{$this->attribute} = $value;
    }

    /**
     * @return ActiveQuery
     */
	public function getCategories()
	{
        /* @var Product $owner */
        $owner = $this->owner;
        
        return $owner->hasMany(Category::class, ['id' => 'categoryId'])
            ->via('productCategories');
	}

    /**
     * Returns main category
     * @return ActiveQuery
     */
	public function getCategory()
    {
        /* @var Product $owner */
        $owner = $this->owner;

        return $owner->hasOne(Category::class, ['id' => 'categoryId'])
            ->via('productCategories', function (ActiveQuery $query) {
                $query->andWhere(['isMain' => true]);
            });
    }

    /**
     * @return bool
     * @throws Exception
     */
	public function afterSave()
	{
        /* @var Product $owner */
        /* @var ProductCategory[] $productCategories */

        $owner = $this->owner;
        $productCategories = $owner->{$this->attribute};
        $models = [];

        ProductCategory::deleteAll('productId = :productId', [':productId' => $owner->id]);

		if (empty($productCategories)) {
			return false;
		}

		foreach ($productCategories as $productCategory) {
		    // TODO: there is a problem with existing model and their removal
		    $model = new ProductCategory;
            $model->load($productCategory->attributes, '');
            $model->productId = $owner->id;

            if (! $model->save()) {
                throw new Exception("Can't save ProductCategory model: " . implode(', ', $model->getFirstErrors()));
            }

            $models[] = $model;
		}
		
        // Reindexes the array with a 0 key to remove keys from JSON result
        $owner->{$this->attribute} = array_values($models);

		return true;
	}

    /**
     * @return bool
     */
	public function beforeDelete()
	{
        $result = true;

		foreach($this->getProductCategories()->each() as $productCategory) {
		    /* @var ProductCategory $productCategory */
            $result = $productCategory->delete() && $result;
		}

		return $result;
	}

}