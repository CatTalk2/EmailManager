<?php
/**
 * Created by PhpStorm.
 * User: 李洋
 * Date: 2015/7/3
 * Time: 14:46
 */
namespace app\controllers;
use app\models\Receive;
use Yii;
use yii\web\Controller;
use app\models\mail;
use app\models\Email;
use receiveMail;
header("Content-type;text/html;charset=UTF-8");
class ReceiveController extends Controller
{
    public function actionIndex()
    {
        $model = new Receive;
        error_reporting(E_ALL^E_WARNING);
        $obj = new receiveMail('tclrg','Luanruitest','tclrg@126.com','imap.126.com','imap','993','ture');
        $obj->connect();
        $tot = $obj->getTotalMails();

        //查看邮箱是否有新邮件
        $old_email_count=Email::find()->count();
     
        for ($i = $tot; $i > $old_email_count; $i--) {
        	
            $model = new Receive;
            $head = $obj->getHeaders($i);
            $head['subject'] = imap_mime_header_decode($head['subject'])[0]->text;
            $head['from'] = imap_mime_header_decode($head['from'])[0]->text;
            $head['fromName'] = imap_mime_header_decode($head['fromName'])[0]->text;
            $model->subject=$head['subject'];
            $model->sender=$head['from'];
//            echo $i.$head['date']."</br>";
//            echo $i.strtotime($head['date'])."</br>";
//            echo $i.date("Y-m-d H:i:s",strtotime($head['date']))."</br>";
            $model->sendtime=date("Y-m-d H:i:s",strtotime($head['date']));
            $model->text=$obj->getBody($i);
//            $model->sendtime=$head['date'];
            $model->save();
//            echo $i.$head['date'];
        }
        $obj->close_mailbox();
        
    }
}

