<?php

use yii\db\Migration;

class m180225_051915_catalog_categories_create_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%catalog_categories}}', [
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

        $this->addForeignKey('{{%fk-catalog_categories-catalog_categories}}',
            '{{%catalog_categories}}', 'parentId',
            '{{%catalog_categories}}', 'id',
            'RESTRICT', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-catalog_categories-catalog_categories}}', '{{%catalog_categories}}');

        $this->dropTable('{{%catalog_categories}}');
    }
}
