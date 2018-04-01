<?php

use yii\db\Migration;

/**
 * Class m180401_122229_author_book
 */
class m180401_122229_author_book extends Migration
{
    public function up()
    {
        $this->createTable('{{%author_book}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer(),
            'book_id' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // add foreign key for table `author`
        $this->addForeignKey(
            'fk-author_book-author_id',
            'author_book',
            'author_id',
            'authors',
            'id',
            'CASCADE'
        );

        // add foreign key for table `book`
        $this->addForeignKey(
            'fk-author_book-book_id',
            'author_book',
            'book_id',
            'books',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%author_book}}');
    }
}
