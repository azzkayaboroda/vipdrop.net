<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\search\UserSearch;
use common\models\search\HistorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $current_image = $model->avatar;
        $user_products = null;
        $id_array = null;
        if (isset($model->user_products)) {
            $user_items_array = json_decode($model->user_products);
            foreach ($user_items_array as $items) $id_array[] = $items->id;
        }
        if ($id_array == null) $id_array = "null";
      //  print_r($id_array);
        $searchModel = new HistorySearch();
        $searchModel->type = 2;
        $searchModel->user_id = $id;
        $searchModel->product_id = $id_array;
        
        if (isset($_GET['fromDate']) && isset($_GET['toDate'])) {
            $searchModel->start_date = strtotime($_GET['fromDate']);
            $searchModel->end_date = strtotime($_GET['toDate']);
            //echo strtotime($_GET['fromDate']);
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       
        if (isset($_GET['page_count'])) $dataProvider->pagination->pageSize = $_GET['page_count'];

         if ($model->load(Yii::$app->request->post())) { 
            $file = UploadedFile::getInstance($model, 'file');
            if ($file && $file->tempName) {
                $model->file = $file;
                if ($model->validate(['file'])) {
                    if ($model->avatar) {
                        if (file_exists(Yii::getAlias('@frontend').'/web/avatars/'.$current_image)) {
                            //удаляем файл
                            unlink(Yii::getAlias('@frontend').'/web/avatars/'.$current_image);
                            $model->avatar = '';
                        }
                    }
                    $dir = Yii::getAlias('@frontend').'/web/avatars/';
                    $fileName = time(). '.' . $model->file->extension;
                    $model->file->saveAs($dir . $fileName);
                    $model->file = $fileName;
                    $model->avatar = $fileName;
                }
            }
            
            $model->save();
                //return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->id == Yii::$app->user->identity->id)
        {
            if (isset($_GET['new_name'])) {
                $new_username = $_GET['new_name'];
                $model->username = $new_username;
            }

            if (isset($_GET['t_url'])) {
                $new_trade_url = $_GET['t_url'];
                $model->trade_url = $new_trade_url;
            }

            
            if ($model->save()) {
                echo "good";
            }
        }

      

        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);*/
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}