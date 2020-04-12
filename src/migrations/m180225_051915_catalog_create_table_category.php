<?php

use yii\db\Migration;

class m180225_051915_catalog_create_table_category extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%catalog_category}}', [
            'id' => $this->primaryKey(),
            'left' => $this->integer(),
            'right' => $this->integer(),
            'level' => $this->integer(),
            'parentId' => $this->integer(),
            'name' => $this->string(),
            'title' => $this->string(),
            'teaser' => $this->text(),
            'body' => $this->text(),
            'isShowPrice' => $this->boolean()->defaultValue(true),
            'status' => $this->tinyInteger(1)->defaultValue(1),
            'createdAt' => $this->dateTime(),
            'updatedAt' => $this->dateTime(),
        ], 'ENGINE=InnoDB CHARSET=utf8');

        $this->addForeignKey('{{%fk-catalog_category-catalog_category}}',
            '{{%catalog_category}}', 'parentId',
            '{{%catalog_category}}', 'id',
            'RESTRICT', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-catalog_category-catalog_category}}', '{{%catalog_category}}');

        $this->dropTable('{{%catalog_category}}');
    }
}
