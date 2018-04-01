<?php

namespace backend\controllers;

use Yii;
use app\models\Author;
use app\models\Book;
use app\models\AuthorBook;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AuthorController implements the CRUD actions for Author model.
 */
class AuthorController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Author models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Author::find()
                ->select([
                    '{{authors}}.*',
                    'COUNT({{author_book}}.book_id) AS booksCount'
                ])
                ->joinWith('authorBooks')
                ->groupBy('{{authors}}.id'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Author model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Author model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Author();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            /*
             * Link new Author with books
             * Solution found on https://www.yiiframework.com/forum/index.php/topic/56041-many-to-many-relation-in-a-form/
             * TODO - find solutions for mass assign by ID
             * $model->link('authorBooks', Yii::$app->request->post('Author')['authorBooks']);
             */
            $books = Yii::$app->request->post('authorBooks');
            foreach ($books as $book_id){
                //$book = Book::findOne($book_id);
                //$model->link('authorBooks', $book);
                $authorBook = new AuthorBook();
                $authorBook->author_id = $model->id;
                $authorBook->book_id = $book_id;
                // TODO - clarify if framework can write timestamp by himself
                $authorBook->created_at = time();
                $authorBook->updated_at = time();
                $authorBook->save();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        $books = Book::find()->select(['id', 'name'])->all();

        //Create array for Selectize
        foreach ($books as $book){
            $arr_books[$book->id] = $book->name;
        }


        return $this->render('create', [
            'model' => $model,
            'books' => $arr_books,
        ]);
    }

    /**
     * Updates an existing Author model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            AuthorBook::deleteAll(['author_id'=> $model->id]);

            $books = Yii::$app->request->post('authorBooks');
            foreach ($books as $book_id){
                $authorBook = new AuthorBook();
                $authorBook->author_id = $model->id;
                $authorBook->book_id = $book_id;
                $authorBook->created_at = time();
                $authorBook->updated_at = time();
                $authorBook->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $books = Book::find()->select(['id', 'name'])->all();

        //Create array for Selectize
        foreach ($books as $book){
            $arr_books[$book->id] = $book->name;
        }

        foreach($model->authorBooks as $book){
            $selected_books[$book->book_id] = $book->book_id;
        }



        return $this->render('update', [
            'model' => $model,
            'books' => $arr_books,
            'selected_books' => $selected_books,
        ]);
    }

    /**
     * Deletes an existing Author model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Author model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Author the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Author::find($id)->with('authorBooks')->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
