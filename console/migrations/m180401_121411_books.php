<?php

use yii\db\Migration;

/**
 * Class m180401_121411_books
 */
class m180401_121411_books extends Migration
{
    public function up()
    {
        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%books}}');
    }
}
