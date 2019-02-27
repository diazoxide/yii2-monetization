<?php

use yii\db\Schema;
use yii\db\Migration;

class m190226_104743_monetization_conversion_actions extends Migration
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
            '{{%monetization_conversion_actions}}',
            [
                'id'=> $this->primaryKey(11),
                'conversion_id'=> $this->integer(11)->notNull(),
                'type_id'=> $this->integer(11)->notNull(),
                'referral'=> $this->string(2083)->null()->defaultValue(null),
                'sign_date'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );
        $this->createIndex('conversion_id','{{%monetization_conversion_actions}}',['conversion_id','type_id'],false);

    }

    public function safeDown()
    {
        $this->dropIndex('conversion_id', '{{%monetization_conversion_actions}}');
        $this->dropTable('{{%monetization_conversion_actions}}');
    }
}
