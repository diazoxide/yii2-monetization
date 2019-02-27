<?php

use yii\db\Schema;
use yii\db\Migration;

class m190226_104741_monetization extends Migration
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
            '{{%monetization}}',
            [
                'id'=> $this->primaryKey(11),
                'user_id'=> $this->integer(11)->notNull(),
                'name'=> $this->string(255)->notNull(),
                'enabled'=> $this->tinyInteger(1)->notNull(),
                'note'=> $this->string(255)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%monetization}}');
    }
}
