<?php

namespace frontend\controllers;

use Yii;
use common\models\ShopProduct;
use common\models\search\ShopProductSearch;
use common\models\History;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use JWT;
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

    public function beforeAction($action)
    {
        // ...set `$this->enableCsrfValidation` here based on some conditions...
        // call parent method that will check CSRF if such property is true.
        if ($action->id === 'sell_product' || $action->id === 'send_product' || $action->id === "buy_weapon") {
            # code...
            $this->enableCsrfValidation = false;
            Yii::$app->response->format = Response::FORMAT_JSON;
        }
        return parent::beforeAction($action);
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
    
    public function actionBuy_weapon()
    {
        $weapon_id =  $_POST['weapon_id'];
        $weapon = $this->findModel($weapon_id);
        $user =  Yii::$app->user->identity;
        if ($weapon) {
            if ($user->bonuses >= $weapon->price) 
            {
            
                if ($user->user_products)
                $user_items_array = json_decode($user->user_products);
                else $user_items_array = array();
                $new_item = $weapon_id;
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
                
    
                $user->user_products = json_encode($user_items_array);   
                $user->bonuses -= $weapon->price;
                $user->save();
                
                $new_event = new History;
                $new_event->user_id = $user->id;
                $new_event->type = 2;
              
                $new_event->product_id = $new_item;
                $new_event->desc = "Предмет приобретен за бонусы";
                $new_event->save();
                $page_info['status'] = true;
                $page_info['bonuses'] = $user->bonuses;
                return $this->asJson($page_info);
            }
            else {
                $page_info['status'] = "error";
                $page_info['text_info'] = "Недостаточно денег на балансе";
                return $this->asJson($page_info);
            }
        } else {
            $page_info['status'] = "error";
            $page_info['text_info'] = "Предмет не найден!";
            return $this->asJson($page_info);
        }
        
    }

    public function actionSell_product($id)
    {
        $user =  Yii::$app->user->identity;
        $history_id = $_POST['history_id'];
        if ($user->user_products == null) {
            $page_info['status'] = false;
            $page_info['text_info'] = "У пользователя нету предметов";
            return $this->asJson($page_info);
        }
        else {
             $user_items_array = json_decode($user->user_products);
             $i = 0;
             $match = false;
             foreach ($user_items_array as $item) {
                 if ($item->id == $id && $item->count > 0)
                 {
                     $match = true;
                     $product = $this->findModel($id);     
                     if ($item->count == 1) {
                        unset($user_items_array[$i]);
                        $user_items_array = array_values($user_items_array);
                     } else {
                         $item->count --;
                     }

                     $user->balance += $product->price;
                     $user->user_products = json_encode($user_items_array);
                     $user->save();

                     $new_event = new History;
                     $new_event->user_id = $user->id;
                     $new_event->type = 3;
                     $new_event->desc = "Пользователь ".$user->username." продал предмет № ".$id;
                     $new_event->desc .= "<br/>Начислено на баланс: ".$product->price;
                     $new_event->save();

                     $history = History::findOne($history_id);
                     $history->delete();

                     $page_info['status'] = true;
                     $page_info['text_info'] = "Предмет успешно продан";
                     $page_info['price'] = $product->price;
                     return $this->asJson($page_info);
                 } 
                 $i++;
             }
            if ($match == false) {
                        $page_info['status'] = false;
                        $page_info['text_info'] = "У пользователя нету данного предмета";
                        return $this->asJson($page_info);
                 }
        }
    }


    public function actionSend_product($id)
    {
        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity;
            $user_items_array = json_decode($user->user_products);
            $send_item = null;
            $history_id = $_POST['history_id'];

            foreach ($user_items_array as $item) if ($item->id == $id && $item->count > 0) {
                $send_item = $id;
            }

            if ($send_item != null && $user->trade_url != null) {
                
                $token = array("host" => "https://vipdrop.net", 
                                "user_id" => $user->id,
                                "iat" => time());

                 $accessJwt = new \Lindelius\JWT\JWT(); // инициализируем
                 $tokenExp = time() + 84600; // время жизни токена
                 $accessJwt->exp = $tokenExp; // пишем в переменную
                 $accessJwt->iat = time(); // время создания
                 $accessJwt->sub = $token; // тут добавляем айди юзера в токен
                 $accessToken = $accessJwt->encode('1kh51783u12il3423j'); // енкодим его ключом

                 /*$accessJwt = new \Lindelius\JWT\JWT(); // инициализируем
                
           
                 $accessToken = $accessJwt->encode($token, '1kh51783u12il3423j'); // енкодим его ключом*/

                 $user->jwt_token = $accessToken;
                 $user->save();

                 $ch = curl_init();
                 curl_setopt($ch, CURLOPT_URL,"http://31.177.78.186/api/trade/".$id);
                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $headers = [
                        'Authorization: Bearer '.$accessToken,
                    ];

                 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                 $server_output = curl_exec ($ch);
                 //print ($server_output);
                 //сurl_close ($ch);
                 $response = json_decode($server_output, true);
                 if ($response['success'] == true && $response['trade_offer'] != null)
                 {
                    $i = 0;
                    $match = false;
                    foreach ($user_items_array as $item) {
                            if ($item->id == $id && $item->count > 0)
                            {
                                $match = true;    
                                if ($item->count == 1) {
                                    unset($user_items_array[$i]);
                                    $user_items_array = array_values($user_items_array);
                                } else {
                                    $item->count --;
                                }

                                $user->user_products = json_encode($user_items_array);
                                $user->save();

                                $new_event = new History;
                                $new_event->user_id = $user->id;
                                $new_event->type = 4;
                                $new_event->desc = "Пользователь ".$user->username." вывел предмет № ".$id." в Steam";
                                $new_event->save();

                                $history = History::findOne($history_id);
                                $history->delete();

                                $page_info['status'] = true;
                                $page_info['text_info'] = "Предмет успешно передан";
                                $page_info['offer_url'] = $response['trade_offer'] ;
                                return $this->asJson($page_info);
                            } 
                            $i++;
                        }
                }
            }
            else return "Предмет не найден или не указан trade_url";
        }
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