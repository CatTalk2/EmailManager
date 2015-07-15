<?php
namespace app\models;
use yii\base\Model;
use yii\db\ActiveRecord;
class Email_user_rs extends ActiveRecord{
	public static function tablename(){
		return 'email_user_rs';
	}
}