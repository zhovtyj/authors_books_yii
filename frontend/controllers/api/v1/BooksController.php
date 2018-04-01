<?php

namespace frontend\controllers\api\v1;

use common\models\Book;

class BooksController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $books = Book::find()->with('authorBooks')->all();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $books;
    }

}
