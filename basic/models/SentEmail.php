<?php
namespace app\models;
use yii\base\Model;
use yii\db\ActiveRecord;
 class SentEmail extends ActiveRecord{
 	public static function tablename()
 	{
 		return 'send_email';
 	}
 }