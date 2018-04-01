<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "authors".
 *
 * @property int $id
 * @property string $name
 *
 * @property AuthorBook[] $authorBooks
 */
class Author extends \yii\db\ActiveRecord
{
    public $booksCount;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'authors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'authorBooksCount' => 'Number of books',
            'booksCount' => 'Number of books',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorBooks()
    {
        return $this->hasMany(AuthorBook::className(), ['author_id' => 'id'])->with('book');
    }

    public function getAuthorBooksCount()
    {
        return $this->getAuthorBooks()->count();
    }
}
