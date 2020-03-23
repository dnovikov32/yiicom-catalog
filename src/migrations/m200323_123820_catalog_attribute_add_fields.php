<?php

use yii\db\Migration;

class m200323_123820_catalog_attribute_add_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%catalog_attribute_group}}', 'type', $this->tinyInteger(2)->defaultValue(0)->after('title'));

        $this->addColumn('{{%catalog_attribute}}', 'prefix', $this->string());
        $this->addColumn('{{%catalog_attribute}}', 'postfix', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%catalog_attribute_group}}', 'type');

        $this->dropColumn('{{%catalog_attribute}}', 'prefix');
        $this->dropColumn('{{%catalog_attribute}}', 'postfix');
    }
}
