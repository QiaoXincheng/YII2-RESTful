<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace api\rest;

use yii\data\ActiveDataProvider;
use yii\db\QueryInterface;

class LU_DataProvider extends ActiveDataProvider
{

    /**
     * @inheritdoc
     */
    protected function prepareModels()
    {
        if (!$this->query instanceof QueryInterface) {
            LU_Response::getInstance()->exception(['message' => 'The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.']);
        }
        $query = clone $this->query;
        if (($pagination = $this->getPagination()) !== false) {
            $pagination->totalCount = $this->getTotalCount();
            $query->limit($pagination->getLimit())->offset($pagination->getOffset());
        }
        if (($sort = $this->getSort()) !== false) {
            $query->addOrderBy($sort->getOrders());
        }

        return $query->all($this->db);
    }


    /**
     * @inheritdoc
     */
    protected function prepareTotalCount()
    {
        if (!$this->query instanceof QueryInterface) {
            LU_Response::getInstance()->exception(['message' => 'The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.']);
        }
        $query = clone $this->query;
        return (int) $query->limit(-1)->offset(-1)->orderBy([])->count('*', $this->db);
    }


}
