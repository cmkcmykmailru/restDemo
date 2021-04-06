<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_tags}}`.
 */
class m210310_202645_create_blog_tags_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%blog_tags}}', [
            'id' => $this->char(36)->notNull(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);
        $this->addPrimaryKey('{{%pk-blog_tags}}', '{{%blog_tags}}', 'id');
        $this->createIndex('{{%idx-blog_tags-slug}}', '{{%blog_tags}}', 'slug', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%blog_tags}}');
    }
}
