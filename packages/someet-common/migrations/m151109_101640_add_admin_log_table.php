<?php

use yii\db\Schema;
use yii\db\Migration;

class m151109_101640_add_admin_log_table extends Migration
{

    public function up()
    {
        $tableOptions = null;

        $this->createTable('{{%admin_log}}', [
            //'name'=>Schema::TYPE_STRING.'(200) PRIMARY KEY NOT NULL',
            'id'=>Schema::TYPE_PK,
            'admin_id'=>Schema::TYPE_INTEGER.'(11) UNSIGNED NOT NULL COMMENT "操作用户ID"',
            'admin_name'=>Schema::TYPE_STRING.'(200) NOT NULL COMMENT "操作用户名"',
            'addtime'=>Schema::TYPE_INTEGER.'(11) NOT NULL COMMENT "记录时间"',
            'admin_ip'=>Schema::TYPE_STRING.'(200) NOT NULL COMMENT "操作用户IP"',
            'admin_agent'=>Schema::TYPE_STRING.'(200) NOT NULL COMMENT "操作用户浏览器代理商"',
            'title'=>Schema::TYPE_STRING.'(200) NOT NULL COMMENT "记录描述"',
            'controller'=>Schema::TYPE_STRING.'(200) NOT NULL COMMENT "操作模块（例：文章）"',
            'action'=>Schema::TYPE_STRING.'(200) NOT NULL COMMENT "操作类型（例：添加）"',
            'handle_id'=>Schema::TYPE_INTEGER.'(11) NOT NULL COMMENT "操作对象ID"',
            'result'=>Schema::TYPE_TEXT.' NOT NULL COMMENT "操作结果"',
            'describe'=>Schema::TYPE_TEXT.' COMMENT "备注"',

        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%admin_log}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
