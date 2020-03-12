<?php

use yii\db\Migration;

class m191227_113753_catalog_create_table_attribute extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%catalog_attribute}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'title' => $this->string(),
            'type' => $this->tinyInteger(2)->defaultValue(0),
            'groupId' => $this->integer(),
            'position' => $this->tinyInteger(3)->defaultValue(0),
            'isShowInCard' => $this->boolean()->defaultValue(false),
            'isShowInProduct' => $this->boolean()->defaultValue(false),
        ], 'ENGINE=InnoDB CHARSET=utf8');

        $this->addForeignKey('{{%fk-catalog_attribute-catalog_attribute_group}}',
            '{{%catalog_attribute}}', 'groupId',
            '{{%catalog_attribute_group}}', 'id',
            'RESTRICT', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-catalog_attribute-catalog_attribute_group}}', '{{%catalog_attribute}}');

        $this->dropTable('{{%catalog_attribute}}');
    }
}
