<?php
namespace app\models;
use yii\base\Model;
use app\models\users;
class EntryForm extends Model
{
    public $name;
    public $password;

    public function rules()
    {
        return [
            [['name', 'password'], 'required']
        ];
    }
}