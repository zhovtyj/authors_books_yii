<?php

namespace frontend\controllers\api\v1;

use common\models\Book;
use Yii;

class BooksController extends \yii\web\Controller
{
    public function actions()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->controller->enableCsrfValidation = false;
    }

    public function actionIndex($id = null)
    {
        $books = Book::find()->with('authorBooks')->asArray()->all();

        return $books;
    }

    public function actionView($id)
    {
        if(Yii::$app->request->isPost){

            $book = Book::findOne($id);
            $book->name = Yii::$app->request->post('name');
            if($book->save()){
                return ['success' => 'Book was updated successfully!'];
            }else{
                return ['error' => 'Book was not updated!'];
            }
        }
        if(Yii::$app->request->isDelete){
            $book = Book::findOne($id);
            if($book->delete()){
                return ['success' => 'Book was deleted successfully!'];
            }else{
                return ['error' => 'Book was not deleted!'];
                
            }
        }

        $book = Book::find($id)->with('authorBooks')->asArray()->one();

        return $book;
    }

}
