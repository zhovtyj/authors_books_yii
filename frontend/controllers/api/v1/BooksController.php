<?php

namespace frontend\controllers\api\v1;

use common\models\Book;

class BooksController extends \yii\web\Controller
{
    public function actions()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }

    public function actionIndex($id = null)
    {
        $books = Book::find()->with('authorBooks')->asArray()->all();

        return $books;
    }

    public function actionView($id)
    {
        $books = Book::find($id)->with('authorBooks')->asArray()->one();

        return $books;
    }

}
