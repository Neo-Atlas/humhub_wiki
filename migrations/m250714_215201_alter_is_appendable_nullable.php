<?php

use yii\db\Migration;

/**
 * Class m250714_215201_alter_is_appendable_nullable
 */
class m250714_215201_alter_is_appendable_nullable extends Migration
{   
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('wiki_page', 'is_appendable', $this->boolean()->null()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('wiki_page', 'is_appendable', $this->boolean()->notNull()->defaultValue(false));
    }
}
