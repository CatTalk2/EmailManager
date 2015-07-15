<?php
namespace app\models;
use yii\base\Model;
use yii\db\ActiveRecord;
 class EmergentEmail extends ActiveRecord{
 	public static function tablename()
 	{
 		return 'send_email';
 	}
 }