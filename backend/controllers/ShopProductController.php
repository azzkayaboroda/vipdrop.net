<?php

namespace backend\controllers;

use Yii;
use common\models\ShopProduct;
use common\models\search\ShopProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ShopProductController implements the CRUD actions for ShopProduct model.
 */
class ShopProductController extends Controller
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
     * Lists all ShopProduct models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShopProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ShopProduct model.
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
     * Creates a new ShopProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShopProduct();

        if ($model->load(Yii::$app->request->post())){
            $file = UploadedFile::getInstance($model, 'file');
                    if ($file && $file->tempName) {
                        $model->file = $file;
                        if ($model->validate(['file'])) {
                            $dir = Yii::getAlias('@frontend').'/web/images/';
                            $fileName = time(). '.' . $model->file->extension;
                            $model->file->saveAs($dir . $fileName);
                            $model->file = $fileName;
                            $model->photo = $fileName;
                        }
                    }
            
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ShopProduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $current_image = $model->photo;

        if ($model->load(Yii::$app->request->post()))
        {

            $file = UploadedFile::getInstance($model, 'file');
            if ($file && $file->tempName) {
                if ($current_image) {
                    if(file_exists(Yii::getAlias('@frontend').'/web/images/'.$current_image))
                                {
                                    //удаляем файл
                                    unlink(Yii::getAlias('@frontend').'/web/images/'.$current_image);
                                    $model->photo = '';
                                }
                }
                $model->file = $file;
                if ($model->validate(['file'])) {
                    $dir = Yii::getAlias('@frontend').'/web/images/';
                    $fileName = time(). '.' . $model->file->extension;
                    $model->file->saveAs($dir . $fileName);
                    $model->file = $fileName;
                    $model->photo = $fileName;
                }
            }

            if  ($model->save()) 
                return $this->redirect(['view', 'id' => $model->id]);        
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ShopProduct model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $current_image = $model->photo;
        if ($current_image) {
                    if(file_exists(Yii::getAlias('@frontend').'/web/images/'.$current_image))
                                {
                                    //удаляем файл
                                    unlink(Yii::getAlias('@frontend').'/web/images/'.$current_image);
                                    $model->photo = '';
                                }
                }
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ShopProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShopProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShopProduct::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}