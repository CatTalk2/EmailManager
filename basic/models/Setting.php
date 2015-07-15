<?php
/**
 * Created by PhpStorm.
 * User: 李洋
 * Date: 2015/7/4
 * Time: 15:39
 */
namespace app\models;

use yii\db\ActiveRecord;
class Setting extends ActiveRecord
{
//    public $sendhost;
//    public $sendport;
//    public $user;
//    public $password;
//      public $username;
//    public $receivehost;
//    public $receiveport;
    public static function tableName()
    {
        return "mailsetting";
    }

    public function rules()
    {
        return [
            [['sendport','sendhost', 'user','password','username','receivehost','receiveport',], 'safe'],
            ['username', 'email'],
        ];
    }
}