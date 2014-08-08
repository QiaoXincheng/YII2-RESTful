<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "tbl_post".
 *
 * @property string $id
 * @property string $title
 * @property string $content
 * @property integer $created_at
 * @property integer $updated_at
 */
class Post extends \yii\db\ActiveRecord
{
    const CATEGORY_NEWS = 1;
    const CATEGORY_WIKI = 2;
    const CATEGORY_INDUSTRY = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['title', 'content'], 'required', 'on' => ['create', 'update']],
            [['image'], 'required', 'on' => 'create'],
            [['image'], 'image', 'enableClientValidation' => true,   'maxSize' => 1024, 'message' => '您上传的文件过大', 'on' => ['create', 'update']],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => '分类',
            'title' => '标题',
            'content' => '内容',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'image' => '图片',
        ];
    }

    public function scenarios()
    {
        return [
            'create' => ['title', 'image', 'content'],
            'update' => ['title', 'content', 'image'],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($insert)
                $this->created_at = $this->updated_at = time();
            else
                $this->updated_at = time();
            return true;
        } else {
            return false;
        }
    }


    public function getList($param = array())
    {
        $query = $this->find();
        $pagination = ['pageSize' => isset($param['per-page']) ? (int)$param['per-page'] : 10];
        return ['query'=>$query, 'pagination' => $pagination];
    }

}
