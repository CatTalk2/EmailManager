<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $permission
 * @property string $name
 * @property string $sex
 * @property integer $age
 * @property string $pmail
 * @property string $phone
 */
class Admin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['permission', 'age'], 'integer'],
            [['username', 'password', 'pmail', 'phone'], 'string', 'max' => 30],
            [['name'], 'string', 'max' => 20],
            [['sex'], 'string', 'max' => 1],
            [['pmail'],'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'password' => '密码',
            'permission' => '权限',
            'name' => '昵称',
            'sex' => '性别',
            'age' => '年龄',
            'pmail' => '个人邮箱',
            'phone' => '电话',
        ];
    }
}
