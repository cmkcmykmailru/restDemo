<?php

use yii\db\Migration;

class m130524_201441_auth_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        $tableName = $this->db->tablePrefix . 'user';

        if ($this->db->getTableSchema($tableName, true) === null) {
            if ($this->db->driverName === 'mysql') {
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }

            $this->createTable('{{%user}}', [
                'id' =>  $this->char(36)->notNull()->unique(),
                'username' => $this->string()->notNull()->unique(),
                'auth_key' =>  $this->char(36)->notNull(),
                'password_hash' => $this->string()->notNull(),
                'status' => $this->smallInteger()->notNull()->defaultValue(10),
                'created_at' => $this->integer()->unsigned()->notNull(),
                'updated_at' => $this->integer()->unsigned()->notNull(),
            ], $tableOptions);

            $this->addPrimaryKey('{{%pk-user}}', '{{%user}}', ['id']);
        }

    }

    public function down()
    {

    }
}
