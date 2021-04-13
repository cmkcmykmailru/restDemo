<?php

use yii\db\Migration;

class m130524_201443_signup_init extends Migration
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
                'id' => $this->char(36)->notNull(),
                'username' => $this->string()->notNull()->unique(),
                'auth_key' => $this->char(36)->notNull(),
                'password_hash' => $this->string()->notNull(),
                'status' => $this->smallInteger()->notNull()->defaultValue(10),
                'created_at' => $this->integer()->unsigned()->notNull(),
                'updated_at' => $this->integer()->unsigned()->notNull(),
            ], $tableOptions);

            $this->addPrimaryKey('{{%pk-user}}', '{{%user}}', ['id']);
        }

        $table = $this->db->schema->getTableSchema('{{%user}}');

        if(!isset($table->columns['email'])) {
            $this->addColumn('{{%user}}', 'email', $this->string()->notNull()->unique());
        }

        if(!isset($table->columns['email_confirm_token'])) {
            $this->addColumn('{{%user}}', 'email_confirm_token', $this->string()->unique());
        }

        if ($this->db->getTableSchema('{{%auth_item}}', true) !== null
            && $this->db->getTableSchema('{{%auth_item_child}}', true) !== null
            && $this->db->getTableSchema('{{%auth_assignment}}', true) !== null
        ) {
            try {
                $this->batchInsert('{{%auth_item}}', ['type', 'name', 'description'], [
                    [1, 'user', 'User'],
                    [1, 'admin', 'Admin'],
                ]);

                $this->batchInsert('{{%auth_item_child}}', ['parent', 'child'], [
                    ['admin', 'user'],
                ]);
                $this->execute('INSERT INTO {{%auth_assignment}} (item_name, user_id) SELECT \'user\', u.id FROM {{%user}} u ORDER BY u.id');

            } catch (\yii\db\Exception $e) {

            }
        }

    }

    public function down()
    {

    }
}
