<?php

use yii\db\Migration;

class m191211_072114_catalog_products_create_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%catalog_products}}', [
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

        $this->createTable('{{%catalog_products_categories}}', [
            'id' => $this->primaryKey(),
            'productId' => $this->integer(),
            'categoryId' => $this->integer(),
            'isMain' => $this->boolean()->defaultValue(false),
        ], 'ENGINE=InnoDB CHARSET=utf8');

        $this->addForeignKey('{{%fk-catalog_products_categories-catalog_products}}',
            '{{%catalog_products_categories}}', 'productId',
            '{{%catalog_products}}', 'id',
            'RESTRICT', 'CASCADE');

        $this->addForeignKey('{{%fk-catalog_products_categories-catalog_categories}}',
            '{{%catalog_products_categories}}', 'categoryId',
            '{{%catalog_categories}}', 'id',
            'RESTRICT', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-catalog_products_categories-catalog_products}}', '{{%catalog_products_categories}}');
        $this->dropForeignKey('{{%fk-catalog_products_categories-catalog_categories}}', '{{%catalog_products_categories}}');

        $this->dropTable('{{%catalog_products_categories}}');

        $this->dropTable('{{%catalog_products}}');
    }

}