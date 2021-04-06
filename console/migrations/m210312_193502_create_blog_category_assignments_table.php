<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_category_assignments}}`.
 */
class m210312_193502_create_blog_category_assignments_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%blog_category_assignments}}', [
            'post_id' => $this->char(36)->notNull(),
            'category_id' => $this->char(36)->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-blog_category_assignments}}', '{{%blog_category_assignments}}', ['post_id', 'category_id']);

        $this->createIndex('{{%idx-blog_category_assignments-post_id}}', '{{%blog_category_assignments}}', 'post_id');
        $this->createIndex('{{%idx-blog_category_assignments-category_id}}', '{{%blog_category_assignments}}', 'category_id');

        $this->addForeignKey('{{%fk-blog_category_assignments-post_id}}', '{{%blog_category_assignments}}', 'post_id', '{{%blog_posts}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-blog_category_assignments-category_id}}', '{{%blog_category_assignments}}', 'category_id', '{{%blog_categories}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%blog_category_assignments}}');
    }
}
