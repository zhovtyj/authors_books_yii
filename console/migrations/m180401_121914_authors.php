<?php

use yii\db\Migration;

/**
 * Class m180401_121914_authors
 */
class m180401_121914_authors extends Migration
{
    public function up()
    {
        $this->createTable('{{%authors}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%authors}}');
    }
}
