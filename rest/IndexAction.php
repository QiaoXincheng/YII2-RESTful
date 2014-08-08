<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace api\rest;

use Yii;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class IndexAction extends Action
{


    /**
     * @return ActiveDataProvider
     */
    public function run()
    {
        $modelClass = new $this->modelClass();
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        return new LU_DataProvider($modelClass->getList(Yii::$app->request->get()));
    }


}
