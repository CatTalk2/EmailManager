<?php
namespace app\models;
use yii\base\Model;
use yii\db\ActiveRecord;
class Check extends ActiveRecord{
	public static function tablename(){
			return 'check';
		}
}