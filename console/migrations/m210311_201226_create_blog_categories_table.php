<?php

use Ramsey\Uuid\Uuid;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_categories}}`.
 */
class m210311_201226_create_blog_categories_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%blog_categories}}', [
            'id' => $this->char(36)->notNull(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'title' => $this->string(),
            'description' => $this->text(),
            'meta_json' => 'JSON NOT NULL',
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-blog_categories}}', '{{%blog_categories}}', 'id');
        $this->createIndex('{{%idx-blog_categories-slug}}', '{{%blog_categories}}', 'slug', true);

        $this->insert('{{%blog_categories}}', [
            'id' => Uuid::uuid4()->toString(),
            'name' => '',
            'slug' => 'root',
            'title' => null,
            'description' => null,
            'meta_json' => '{}',
            'lft' => 1,
            'rgt' => 2,
            'depth' => 0,
            'created_at'=>time(),
            'updated_at'=>time()
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%blog_categories}}');
    }
}
