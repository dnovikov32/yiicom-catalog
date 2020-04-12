<?php

use yii\db\Migration;

class m191227_131853_catalog_create_table_attribute_value extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%catalog_attribute_value}}', [
            'id' => $this->primaryKey(),
            'productId' => $this->integer(),
            'value' => $this->json(),
        ], 'ENGINE=InnoDB CHARSET=utf8');

        $this->addForeignKey('{{%fk-catalog_attribute_value-catalog_product}}',
            '{{%catalog_attribute_value}}', 'productId',
            '{{%catalog_product}}', 'id',
            'RESTRICT', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-catalog_attribute_value-catalog_product}}', '{{%catalog_attribute_value}}');
        
        $this->dropTable('{{%catalog_attribute_value}}');
    }
}
