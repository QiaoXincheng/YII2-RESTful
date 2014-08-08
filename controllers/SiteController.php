<?php
namespace api\controllers;

use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\HttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
   public function actionError(){
       \api\rest\LU_Response::getInstance()->exception(['message' => 'Please check the URL', 'status' => 403]);
   }
}
