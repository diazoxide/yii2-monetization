<?php

use yii\db\Schema;
use yii\db\Migration;

class m190226_104742_monetization_conversion extends Migration
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
            '{{%monetization_conversion}}',
            [
                'id'=> $this->primaryKey(11),
                'monetization_id'=> $this->integer(11)->notNull(),
                'ip'=> $this->string(50)->notNull(),
                'os_id'=> $this->integer(11)->notNull(),
                'browser_id'=> $this->integer(11)->notNull(),
                'user_agent'=> $this->string(512)->notNull(),
                'note'=> $this->text()->notNull(),
                'sign_date'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%monetization_conversion}}');
    }
}
