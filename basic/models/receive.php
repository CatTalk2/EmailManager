<?php
/**
 * Created by PhpStorm.
 * User: 李洋
 * Date: 2015/7/3
 * Time: 14:50
 */
namespace app\models;
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
require_once(__DIR__).'/../vendor/receivemail.php';
use yii\db\ActiveRecord;

class Receive extends ActiveRecord
{
    public static function tableName(){
        return "email";
    }
}