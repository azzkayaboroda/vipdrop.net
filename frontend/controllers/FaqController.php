<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FaqController implements the CRUD actions for FaqController model.
 */
class FaqController extends Controller
{
    public function actionIndex()
    {
        return $this->renderpartial('index');
    }
}
