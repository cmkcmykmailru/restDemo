<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_posts}}`.
 */
class m210311_201904_create_blog_posts_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%blog_posts}}', [
            'id' => $this->char(36)->notNull(),
            'category_id' => $this->char(36)->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'content' => 'MEDIUMTEXT NOT NULL',
            'status' => $this->integer()->notNull(),
            'meta_json' => 'TEXT NOT NULL',
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);
        $this->addPrimaryKey('{{%pk-blog_posts}}', '{{%blog_posts}}', 'id');
        $this->createIndex('{{%idx-blog_posts-category_id}}', '{{%blog_posts}}', 'category_id');

        $this->addForeignKey('{{%fk-blog_posts-category_id}}', '{{%blog_posts}}', 'category_id', '{{%blog_categories}}', 'id');
    }

    public function down()
    {
        $this->dropTable('{{%blog_posts}}');
    }
}
