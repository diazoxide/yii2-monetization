<?php

use yii\db\Schema;
use yii\db\Migration;

class m190226_104745_monetization_types_config extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%monetization_types_config}}',
            [
                'id'=> $this->primaryKey(11),
                'monetization_id'=> $this->integer(11)->notNull(),
                'type_id'=> $this->decimal(11)->notNull(),
                'price'=> $this->decimal(16, 6)->null()->defaultValue(null),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%monetization_types_config}}');
    }
}
