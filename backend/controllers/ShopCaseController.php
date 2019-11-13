<?php

namespace backend\controllers;

use Yii;
use common\models\ShopCase;
use common\models\search\ShopCaseSearch;
use common\models\search\ShopProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/**
 * ShopCaseController implements the CRUD actions for ShopCase model.
 */
class ShopCaseController extends Controller
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
     * Lists all ShopCase models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShopCaseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ShopCase model.
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
     * Creates a new ShopCase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShopCase();

        $searchModel = new ShopProductSearch();
        //$searchModel->owner_id = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'file');
                    if ($file && $file->tempName) {
                        $model->file = $file;
                        if ($model->validate(['file'])) {
                            $dir = Yii::getAlias('@frontend').'/web/images/cases/';
                            $fileName = time(). '.' . $model->file->extension;
                            $model->file->saveAs($dir . $fileName);
                            $model->file = $fileName;
                            $model->image = $fileName;
                        }
                    } 
            if ($_POST['products_case'])        
                $model->products_id = json_encode($_POST['products_case']);
                    
            if ($model->save()) 
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Updates an existing ShopCase model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $current_image = $model->image;

        $searchModel = new ShopProductSearch();
       // $searchModel->owner_id = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'file');
            if ($file && $file->tempName) {
                if ($current_image) {
                    if(file_exists(Yii::getAlias('@frontend').'/web/images/cases/'.$current_image))
                                {
                                    //удаляем файл
                                    unlink(Yii::getAlias('@frontend').'/web/images/cases/'.$current_image);
                                    $model->image = '';
                                }
                }
                $model->file = $file;
                if ($model->validate(['file'])) {
                    $dir = Yii::getAlias('@frontend').'/web/images/cases/';
                    $fileName = time(). '.' . $model->file->extension;
                    $model->file->saveAs($dir . $fileName);
                    $model->file = $fileName;
                    $model->image = $fileName;
                }
            }

            if ($_POST['products_case'])        
                $model->products_id = json_encode($_POST['products_case']);
            
            if ($model->save()) 
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Deletes an existing ShopCase model.
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
     * Finds the ShopCase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShopCase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShopCase::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}