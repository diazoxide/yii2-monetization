<?php

use yii\db\Schema;
use yii\db\Migration;

class m190226_104744_monetization_types extends Migration
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
            '{{%monetization_types}}',
            [
                'id'=> $this->primaryKey(1),
                'name'=> $this->string(255)->notNull(),
                'price'=> $this->decimal(16, 6)->notNull(),
                'icon_class'=> $this->string(255)->notNull(),
                'limit'=> $this->integer(11)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%monetization_types}}');
    }
}
