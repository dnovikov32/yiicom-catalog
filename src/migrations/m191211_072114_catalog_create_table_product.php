<?php

use yii\db\Migration;

class m191211_072114_catalog_create_table_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%catalog_product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'title' => $this->string(),
            'teaser' => $this->text(),
            'body' => $this->text(),
            'price' => $this->integer(),
            'isShowPrice' => $this->boolean()->defaultValue(true),
            'status' => $this->tinyInteger(1)->defaultValue(1),
            'createdAt' => $this->dateTime(),
            'updatedAt' => $this->dateTime(),
        ], 'ENGINE=InnoDB CHARSET=utf8');

        $this->createTable('{{%catalog_product_category}}', [
            'id' => $this->primaryKey(),
            'productId' => $this->integer(),
            'categoryId' => $this->integer(),
            'isMain' => $this->boolean()->defaultValue(false),
        ], 'ENGINE=InnoDB CHARSET=utf8');

        $this->addForeignKey('{{%fk-catalog_product_category-catalog_product}}',
            '{{%catalog_product_category}}', 'productId',
            '{{%catalog_product}}', 'id',
            'RESTRICT', 'CASCADE');

        $this->addForeignKey('{{%fk-catalog_product_category-catalog_category}}',
            '{{%catalog_product_category}}', 'categoryId',
            '{{%catalog_category}}', 'id',
            'RESTRICT', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-catalog_product_category-catalog_product}}', '{{%catalog_product_category}}');
        $this->dropForeignKey('{{%fk-catalog_product_category-catalog_category}}', '{{%catalog_product_category}}');

        $this->dropTable('{{%catalog_product_category}}');

        $this->dropTable('{{%catalog_product}}');
    }

}