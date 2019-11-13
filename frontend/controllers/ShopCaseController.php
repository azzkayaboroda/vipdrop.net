<?php

namespace frontend\controllers;

use Yii;
use common\models\ShopCase;
use common\models\search\ShopCaseSearch;
use common\models\Params;
use common\models\History;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\filters\AccessControl;

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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['view', 'many_view'],
                'rules' => [
                    [
                        //'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
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

    public function beforeAction($action)
    {
        // ...set `$this->enableCsrfValidation` here based on some conditions...
        // call parent method that will check CSRF if such property is true.
        if ($action->id === 'roll_single' || $action->id === 'calc_price' || $action->id === 'roll_many' || $action->id === 'calc_many_price') {
            # code...
            $this->enableCsrfValidation = false;
            Yii::$app->response->format = Response::FORMAT_JSON;
        }
        return parent::beforeAction($action);
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
        if (Yii::$app->user->isGuest) return $this->redirect(['site/login?service=steam']);

        $bonuses = Params::find()->where('name = "bonuses"')->one();
        $model = $this->findModel($id);
        $first_element = $model->first_product();
        $all_products = $model->case_products();
        return $this->render('view', [
            'model' => $model,
            'first_element' => $first_element,
            'all_products' => $all_products,
            'bonuses' => $bonuses
        ]);
    }

    public function actionMany_view()
    {
        $bonuses = Params::find()->where('name = "bonuses"')->one();

        $case_array = null;
        // print_r($_GET['case1']);
        for ($i = 1; $i < 7; $i++) {
            if (isset($_GET["case$i"])) {
                $case_array[] = $_GET["case$i"];
            }
        }
        if (count($case_array) == 1) return $this->redirect(['/shop-case/view?id=' . $case_array[0]]);
        //print_r($case_array);

        $cases = ShopCase::find()->where(['id' => $case_array])->all();

        $total_summ = 0;
        foreach ($cases as $case) $total_summ += $case->price;

        $count_cases = count($case_array);

        //$count_roll = $_GET['count'];
        switch ($count_cases) {
            case 1:
                $sale_name = "one_case";
                break;
            case 2:
                $sale_name = "two_cases";
                break;
            case 3:
                $sale_name = "three_cases";
            case 4:
                $sale_name = "four_cases";
                break;
            case 5:
                $sale_name = "five_cases";
                break;
            case 6:
                $sale_name = "six_cases";
                break;
        }

        $case_procent = Params::find()->where("name = '$sale_name'")->one();
        $sale_value = $total_summ - ($total_summ / 100 * $case_procent->value);

        return $this->render('many', [
            'cases' => $cases,
            'total_summ' => $total_summ,
            'sale_value' => $sale_value,
            'case_procent' => $case_procent,
            'bonuses' => $bonuses
        ]);
    }

    public function actionRoll_single($id)
    {
        $model = $this->findModel($id);
        $sale_name = null;
        $bonuses = Params::find()->where('name = "bonuses"')->one();

        $count_roll = $_POST['count'];
        //$count_roll = $_GET['count'];
        switch ($count_roll) {
            case 1:
                $sale_name = "one_case";
                break;
            case 2:
                $sale_name = "two_cases";
                break;
            case 3:
                $sale_name = "three_cases";
            case 4:
                $sale_name = "four_cases";
                break;
        }
        $case_procent = Params::find()->where("name = '$sale_name'")->one();
        $total_price = ($model->price * $count_roll) - ($model->price * $count_roll) / 100 * $case_procent->value;
        $total_bonuses = ($model->price / 100 * $bonuses->value) * $count_roll;


        $this->layout = "";

        if ($total_price > Yii::$app->user->identity->balance) {
            $page_info['status'] = "error";
            $page_info['text_info'] = "Недостаточно денег на балансе";
            return $this->asJson($page_info);
        } else {
            $page_info['status'] = "good";
            for ($i = 0; $i < $count_roll; $i++) {

                $all_products = $model->case_products();

                do {
                    $final_array = array();
                    foreach ($all_products as $product) {
                        $rand_number = mt_rand(1, 100);

                        if ($rand_number <= $product->drop_percent) {
                            $final_array[] = $product;
                        }
                    }
                } while (count($final_array) != 1);

                //echo "Вы выйграли ".$final_array[0]->name;
                $page_info['roll_' . $i] = $final_array[0]->id;
                $id_array[] = $final_array[0]->id;
            }


            $user = Yii::$app->user->identity;
            if ($user->user_products)
                $user_items_array = json_decode($user->user_products);
            else $user_items_array = array();
            foreach ($id_array as $new_item) {
                $check = false;
                foreach ($user_items_array as $user_item) {

                    if ($new_item == $user_item->id) {
                        $user_item->count++;
                        $check = true;
                        break;
                    }
                }
                if ($check == false) {
                    $user_items_array[] = (object)array('id' => $new_item, 'count' => 1);;
                }
            }

            $user->user_products = json_encode($user_items_array);

            $user->balance -= $total_price;
            $user->bonuses += $total_bonuses;
            $user->save();

            $new_event = new History;
            $new_event->user_id = $user->id;
            $new_event->type = 1;
            $new_event->case_id = $model->id;
            $new_event->desc = "Пользователь " . $user->username . " крутил кейс №" . $model->id . "<br/>" . "Количество прокруток: " . $count_roll . "<br/>" .
                "Выйграны предметы: ";
            foreach ($id_array as $new_item) $new_event->desc .= $new_item . " ";
            $new_event->desc .= "<br/>Общая стоимость: " . $total_price . "<br/>Начислено бонусов: " . $total_bonuses;
            $new_event->save();

            $i = 0;
            foreach ($id_array as $new_item) {
                $new_event = new History;
                $new_event->user_id = $user->id;
                $new_event->type = 2;
                $new_event->case_id = $model->id;
                $new_event->product_id = $new_item;
                $new_event->save();

                $page_info['history_' . $i . '_id'] = $new_event->id;
                $i++;
            }

            return $this->asJson($page_info);
        }
        //print_r($final_array);
    }

    public function actionRoll_many()
    {
        $count_roll = $_POST['count'];
        $case_array = $_POST['cases'];

        $cases = ShopCase::find()->where(['id' => $case_array])->all();

        $sale_name = null;
        $bonuses = Params::find()->where('name = "bonuses"')->one();

        $summ_price = 0;
        foreach ($cases as $case) $summ_price += $case->price;

        //$count_roll = $_GET['count'];
        switch (count($cases)) {
            case 1:
                $sale_name = "one_case";
                break;
            case 2:
                $sale_name = "two_cases";
                break;
            case 3:
                $sale_name = "three_cases";
            case 4:
                $sale_name = "four_cases";
                break;
            case 5:
                $sale_name = "five_cases";
                break;
            case 6:
                $sale_name = "six_cases";
                break;
        }
        $case_procent = Params::find()->where("name = '$sale_name'")->one();
        $total_price = ($summ_price * $count_roll) - ($summ_price * $count_roll) / 100 * $case_procent->value;
        $total_bonuses = ($summ_price / 100 * $bonuses->value) * $count_roll;


        $this->layout = "";

        if ($total_price > Yii::$app->user->identity->balance) {
            $page_info['status'] = "error";
            $page_info['text_info'] = "Недостаточно денег на балансе";
            return $this->asJson($page_info);
        } else {
            $page_info['status'] = "good";
            $case_string = null;
            foreach ($cases as $case) {
                $case_string .= " " . $case->id;
                for ($i = 0; $i < $count_roll; $i++) {

                    $all_products = $case->case_products();

                    do {
                        $final_array = array();
                        foreach ($all_products as $product) {
                            $rand_number = mt_rand(1, 100);

                            if ($rand_number <= $product->drop_percent) {
                                $final_array[] = $product;
                            }
                        }
                    } while (count($final_array) != 1);

                    //echo "Вы выйграли ".$final_array[0]->name;
                    $page_info['case_id_' . $case->id . '_roll_' . $i] = $final_array[0]->id;
                    $id_array[] = $final_array[0]->id;
                    $case_array[] = $case->id;
                }
            }


            $user = Yii::$app->user->identity;
            if ($user->user_products)
                $user_items_array = json_decode($user->user_products);
            else $user_items_array = array();
            foreach ($id_array as $new_item) {
                $check = false;
                foreach ($user_items_array as $user_item) {

                    if ($new_item == $user_item->id) {
                        $user_item->count++;
                        $check = true;
                        break;
                    }
                }
                if ($check == false) {
                    $user_items_array[] = (object)array('id' => $new_item, 'count' => 1);;
                }
            }

            $user->user_products = json_encode($user_items_array);

            $user->balance -= $total_price;
            $user->bonuses += $total_bonuses;
            $user->save();

            $new_event = new History;
            $new_event->user_id = $user->id;
            $new_event->type = 1;
            //$new_event->case_id = $model->id;

            $new_event->desc = "Пользователь " . $user->username . " крутил кейсы №" . $case_string . "<br/>" . "Количество прокруток: " . $count_roll . "<br/>" .
                "Выйграны предметы: ";
            foreach ($id_array as $new_item) $new_event->desc .= $new_item . " ";
            $new_event->desc .= "<br/>Общая стоимость: " . $total_price . "<br/>Начислено бонусов: " . $total_bonuses;
            $new_event->save();

            $i = 0;
            foreach ($id_array as $new_item) {
                $new_event = new History;
                $new_event->user_id = $user->id;
                $new_event->type = 2;
                $new_event->case_id = $case_array[$i];
                $new_event->product_id = $new_item;
                $new_event->save();

                $page_info['history_' . $i . '_id'] = $new_event->id;
                $i++;
            }

            return $this->asJson($page_info);
        }
    }

    public function actionCalc_price($id)
    {
        $model = $this->findModel($id);
        $sale_name = null;
        $bonuses = Params::find()->where('name = "bonuses"')->one();

        $count_roll = $_POST['count'];
        //$count_roll = $_GET['count'];
        switch ($count_roll) {
            case 1:
                $sale_name = "one_case";
                break;
            case 2:
                $sale_name = "two_cases";
                break;
            case 3:
                $sale_name = "three_cases";
            case 4:
                $sale_name = "four_cases";
                break;
        }
        $case_procent = Params::find()->where("name = '$sale_name'")->one();



        $page_info['total_price'] = ($model->price * $count_roll) - ($model->price * $count_roll) / 100 * $case_procent->value;
        $page_info['total_bonuses'] = ($model->price / 100 * $bonuses->value) * $count_roll;


        if ($model->price * $count_roll > Yii::$app->user->identity->balance) {
            $page_info['status'] = false;
            $page_info['text_info'] = "Недостаточно денег на балансе";
        } else {
            $page_info['status'] = true;
            $page_info['text_info'] = "баланс позволяет";
        }

        return $this->asJson($page_info);
    }

    public function actionCalc_many_price()
    {
        $case_array = $_POST['cases'];
        $cases = ShopCase::find()->where(['id' => $case_array])->all();

        $sale_name = null;
        $bonuses = Params::find()->where('name = "bonuses"')->one();

        $count_roll = $_POST['count'];
        //$count_roll = $_GET['count'];
        switch (count($cases)) {
            case 1:
                $sale_name = "one_case";
                break;
            case 2:
                $sale_name = "two_cases";
                break;
            case 3:
                $sale_name = "three_cases";
            case 4:
                $sale_name = "four_cases";
                break;
            case 5:
                $sale_name = "five_cases";
                break;
            case 6:
                $sale_name = "six_cases";
                break;
        }
        $case_procent = Params::find()->where("name = '$sale_name'")->one();


        $summ_price = 0;
        $total_sale = 0;
        foreach ($cases as $case) $summ_price += $case->price;

        $page_info['total_price'] = ($summ_price * $count_roll) - ($summ_price * $count_roll) / 100 * $case_procent->value;
        $page_info['total_bonuses'] = ($summ_price / 100 * $bonuses->value) * $count_roll;

        $total_sale = $summ_price * $count_roll - ($summ_price * $count_roll / 100 * $case_procent->value);
        $page_info['total_sale'] = $total_sale;
        $page_info['total_price'] = $summ_price * $count_roll;

        if ($summ_price * $count_roll > Yii::$app->user->identity->balance) {
            $page_info['status'] = false;
            $page_info['text_info'] = "Недостаточно денег на балансе";
        } else {
            $page_info['status'] = true;
            $page_info['text_info'] = "баланс позволяет";
        }

        return $this->asJson($page_info);
    }

    /**
     * Creates a new ShopCase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShopCase();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
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