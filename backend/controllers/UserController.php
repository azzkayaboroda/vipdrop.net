<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\search\UserSearch;
use common\models\search\ShopProductSearch;
use common\models\ShopProduct;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['superuser'],
                    ],
                ],
            ],
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
        return $this->render('view', [
            'model' => $this->findModel($id),
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

        $searchModel = new ShopProductSearch();
        //$searchModel->owner_id = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $products_id = null;
        $user_products = null;
        
    
        if (isset($model->user_products)) {
            $user_items_array = json_decode($model->user_products);
            foreach ($user_items_array as $items) $id_array[] = $items->id;
            $user_products = ShopProduct::find()->where(['id' => $id_array])->all();
            $i = 0;
            foreach ($user_products as $product)
            {
                $product->count = $user_items_array[$i]->count;
                $i++;
            }
        }
        if ($model->load(Yii::$app->request->post())){
            
            if (isset($_POST['user_products_id'])) {
                $products_id = $_POST['user_products_id'];
                $products_count = $_POST['user_products_count'];
                $i = 0;
                $user_items = array();
                foreach ($products_id as $product) {
                    $items_array['id'] = $product;
                    $items_array['count'] = $products_count[$i];
                    $i++;
                    $user_items[] = $items_array;
                }
                $model->user_products = json_encode($user_items);
            }
            if( $model->save()) {
                /*$products = ShopProduct::find()->where(['id' => $products_id])->all();
                foreach ($products as $product) {
                    $product->change_owner($model->id);
                }

                $shop_products_id = $_POST['shop_products'];
                if ($shop_products_id) {
                    $products = ShopProduct::find()->where(['id' => $shop_products_id])->all();
                    foreach ($products as $product) {
                        $product->owner_id = 0;
                        $product->save();
                    }
                }*/
                return $this->redirect(['view', 'id' => $model->id]);
            }
                
        }

        return $this->render('update', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'user_products' => $user_products
        ]);
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