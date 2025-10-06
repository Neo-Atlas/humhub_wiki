<?php

use yii\db\Migration;

class m250827_091609_revision_counter extends Migration
{
    public function safeUp()
    {
        $this->addColumn('wiki_page_revision', 'revision_label', $this->string(10)->null());
    }

    public function safeDown()
    {
        $this->dropColumn('wiki_page_revision', 'revision_label');
    }

}
