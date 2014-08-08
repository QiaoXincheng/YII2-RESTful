<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace api\rest;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * CreateAction implements the API endpoint for creating a new model from the given data.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CreateAction extends Action
{
    /**
     * @var string the scenario to be assigned to the new model before it is validated and saved.
     */
    public $scenario = 'create';
    /**
     * @var string the name of the view action. This property is need to create the URL when the mode is successfully created.
     */
    public $viewAction = 'view';

    /**
     * Creates a new model.
     * @return \yii\db\ActiveRecordInterface the model newly created
     * @throws \Exception if there is any error when creating the model
     */
    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        /**
         * @var \yii\db\ActiveRecord $model
         */
        $model = new $this->modelClass();
        $model->scenario = 'create';
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save())
            return $model;//LU_Response::getInstance()->response(['status' => 201 , 'data' => ['effect' => $model->id]]);
        LU_Response::getInstance()->exception(['status' => 417]);
    }
}
