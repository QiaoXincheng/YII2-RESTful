<?php
namespace api\modules\v1\controllers;

use api\rest\ActiveController;


/**
 * Post controller
 */
class PostController extends ActiveController
{
    /**
     * @var string the source model
     */
    public $modelClass = 'common\models\Post';

}