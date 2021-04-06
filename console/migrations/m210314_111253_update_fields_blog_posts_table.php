<?php

use yii\db\Migration;

/**
 * Class m210314_111253_update_fields_blog_posts_table
 */
class m210314_111253_update_fields_blog_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%blog_posts}}',
            'trash',
            $this->integer(2)->notNull()->defaultValue(0)->after('meta_json'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%blog_posts}}', 'trash');
    }

}
