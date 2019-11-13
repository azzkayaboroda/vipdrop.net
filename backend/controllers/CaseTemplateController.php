<?php

namespace backend\controllers;

use Yii;
use common\models\CaseTemplate;
use common\models\CaseTemplateSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/**
 * CaseTemplateController implements the CRUD actions for CaseTemplate model.
 */
class CaseTemplateController extends Controller
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
     * Lists all CaseTemplate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CaseTemplateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CaseTemplate model.
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
     * Creates a new CaseTemplate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CaseTemplate();

        if ($model->load(Yii::$app->request->post())) {
             $file = UploadedFile::getInstance($model, 'file1');
                    if ($file && $file->tempName) {
                        $model->file1 = $file;
                        if ($model->validate(['file1'])) {
                            $dir = Yii::getAlias('@frontend').'/web/images/cases/';
                            $fileName = time(). '.' . $model->file1->extension;
                            $model->file1->saveAs($dir . $fileName);
                            $model->file1 = $fileName;
                            $model->shirt = $fileName;
                        }
                    } 
             $file = UploadedFile::getInstance($model, 'file2');
                    if ($file && $file->tempName) {
                        $model->file2 = $file;
                        if ($model->validate(['file2'])) {
                            $dir = Yii::getAlias('@frontend').'/web/images/cases/';
                            $fileName = time(). '2.' . $model->file2->extension;
                            $model->file2->saveAs($dir . $fileName);
                            $model->file2 = $fileName;
                            $model->image = $fileName;
                        }
                    }        
            if ($model->save()) 
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CaseTemplate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $current_shirt = $model->shirt;
        $current_image = $model->image;
        $current_gun_shirt = $model->gun_shirt;

        if ($model->load(Yii::$app->request->post())){
           
            $file = UploadedFile::getInstance($model, 'file1');
            if ($file && $file->tempName) {
                if ($current_shirt) {
                    if(file_exists(Yii::getAlias('@frontend').'/web/images/cases/'.$current_shirt))
                                {
                                    //удаляем файл
                                    unlink(Yii::getAlias('@frontend').'/web/images/cases/'.$current_shirt);
                                    $model->shirt = '';
                                }
                }
                $model->file1 = $file;
                if ($model->validate(['file1'])) {
                    $dir = Yii::getAlias('@frontend').'/web/images/cases/';
                    $fileName = time(). '.' . $model->file1->extension;
                    $model->file1->saveAs($dir . $fileName);
                    $model->file1 = $fileName;
                    $model->shirt = $fileName;
                }
            }

            $file = UploadedFile::getInstance($model, 'file2');
            if ($file && $file->tempName) {
                if ($current_image) {
                    if(file_exists(Yii::getAlias('@frontend').'/web/images/cases/'.$current_image))
                                {
                                    //удаляем файл
                                    unlink(Yii::getAlias('@frontend').'/web/images/cases/'.$current_image);
                                    $model->image = '';
                                }
                }
                $model->file2 = $file;
                if ($model->validate(['file2'])) {
                    $dir = Yii::getAlias('@frontend').'/web/images/cases/';
                    $fileName = time(). '2.' . $model->file2->extension;
                    $model->file2->saveAs($dir . $fileName);
                    $model->file2 = $fileName;
                    $model->image = $fileName;
                }
            }

            $file = UploadedFile::getInstance($model, 'file3');
            if ($file && $file->tempName) {
                if ($current_gun_shirt) {
                    if(file_exists(Yii::getAlias('@frontend').'/web/images/cases/'.$current_gun_shirt))
                                {
                                    //удаляем файл
                                    unlink(Yii::getAlias('@frontend').'/web/images/cases/'.$current_gun_shirt);
                                    $model->gun_shirt = '';
                                }
                }
                $model->file3 = $file;
                if ($model->validate(['file3'])) {
                    $dir = Yii::getAlias('@frontend').'/web/images/cases/';
                    $fileName = time(). '2.' . $model->file3->extension;
                    $model->file3->saveAs($dir . $fileName);
                    $model->file3 = $fileName;
                    $model->gun_shirt = $fileName;
                }
            }
         

            if ($model->save()) 
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CaseTemplate model.
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
     * Finds the CaseTemplate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CaseTemplate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CaseTemplate::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}