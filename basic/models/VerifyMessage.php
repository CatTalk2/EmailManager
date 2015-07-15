<?php
namespace app\models;
use yii\base\Model;
use app\models\users;
class VerifyMessage extends Model
{
    public $message;
    public $check_status;
    public $foreignid;

    public function rules()
    {
        return [
            [['message'], 'required']
        ];
    }
}