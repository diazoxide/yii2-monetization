<?php

use yii\db\Schema;
use yii\db\Migration;

class m190226_104746_monetization_types_map extends Migration
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
            '{{%monetization_types_map}}',
            [
                'monetization_id'=> $this->integer(11)->notNull(),
                'type_id'=> $this->integer(11)->notNull(),
            ],$tableOptions
        );
        $this->createIndex('monetization_id','{{%monetization_types_map}}',['monetization_id'],false);
        $this->createIndex('monetization_id_2','{{%monetization_types_map}}',['monetization_id'],false);

    }

    public function safeDown()
    {
        $this->dropIndex('monetization_id', '{{%monetization_types_map}}');
        $this->dropIndex('monetization_id_2', '{{%monetization_types_map}}');
        $this->dropTable('{{%monetization_types_map}}');
    }
}
