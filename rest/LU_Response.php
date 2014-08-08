<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace api\rest;

use yii\web\Response;
use yii;
use yii\helpers\Json;
/**
 * NotFoundHttpException represents a "Not Found" HTTP exception with status code 404.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LU_Response
{
    private static $_obj;
    public $version;
    public $charset;
    public $contentType;
    public $message;
    public $status;

    public function __construct(){
        if($this->version === null)
            if (isset($_SERVER['SERVER_PROTOCOL']) && $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.0')
                $this->version = '1.0';
            else
                $this->version = '1.1';
        $this->charset === null && $this->charset = Yii::$app->charset;
        $this->contentType === null && $this->contentType = $this->getContentType();
    }

    public static function getInstance(){
        if(self::$_obj === null)
            self::$_obj = new self();
        return self::$_obj;
    }

    public function init(){

    }

    public function getHeaders()
    {
        header("HTTP/{$this->version} {$this->status} {$this->message}");
        header("Content-Type: {$this->contentType};charset={$this->charset}", false);
    }

    public function getContentType()
    {
        return $_SERVER['HTTP_ACCEPT'];
    }

    public function getMessage()
    {
        return isset(Response::$httpStatuses[$this->status]) ? Response::$httpStatuses[$this->status] : '';
    }

    public function response($receiver = [])
    {
        $this->dataProvider($receiver);
    }

    public function exception($receiver = [])
    {
        $this->dataProvider($receiver, true);
    }

    public function dataProvider($receiver = [], $type = false)
    {
        $response = [];
        isset($receiver['data']) && $response = $receiver['data'];
        $this->status = isset($receiver['status']) ? $receiver['status'] : 404;
        $this->message = isset($receiver['message']) ? $receiver['message'] : $this->getMessage();
        $type && $response = array_merge($response, ['status' => $this->status, 'message' => $this->message]);
        $this->getHeaders();
        $response = Json::encode($response);
        echo isset($_GET['callback']) ? trim($_GET['callback']) . '(' . $response . ')' : $response;
        exit;
    }

    static public $_type =
    [
        '*/*' => Response::FORMAT_JSONP,
        'application/json' => Response::FORMAT_JSON,
        'application/xml' => Response::FORMAT_XML,
    ];

}