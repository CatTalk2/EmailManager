<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\Mail;
use sendmail;
use app\models\VerifyMessage;
use app\models\SentEmail;
use app\models\Check;
use app\models\Users;
use yii\web\UploadedFile;//上传文件需要的
use app\models\Setting;//获取数据库信息



class VerifierController extends Controller{
    public function actionDetail($id=null,$check_status=null,$dealername=null,$foreignid=null,$email_id){
        $model = new VerifyMessage();
        $session=Yii::$app->session;
        //得到这份邮件


        if(isset($_POST['message'])){
            $message=$_POST['message'];
            $check_status=$_POST['check_status'];
//            $foreignid=$_POST['foreignid'];
            $check=new Check();
            $check=Check::find()->where(['id'=>$foreignid])->one();
            $check->check_status=$check_status;
            $check->check_advise=$message;
            $check->save();
            $session['count']=$session['count']-1;
            $email=SentEmail::find()->where(['id'=>$id])->asArray()->one();

            
            
            if($check_status==1&&$email_id!=NULL&&$email_id!=0){
            	$email_d=SentEmail::find()->where(['id'=>$email_id])->asArray()->one();
            	$model=new Mail();
        	$mailaccount = Setting::find()->one();
            $sendhost = $mailaccount->sendhost;
            $username = $mailaccount->username;
            $user = $mailaccount->user;
            $password = $mailaccount->password;
            error_reporting(E_ALL^E_WARNING);
            //$email=SentEmail::find()->where(['id'=>$id])->asArray()->one();
            
            $body = $email_d['text'];
            $to=$email_d['receiver'];
            $subject=$email_d['subject'];
            
            
           

            $mail = new sendmail();//新建发送
            if($email['attachment']!=null){
            	$filename=basename($email['attachment']);
                $encode = mb_detect_encoding($filename,array("ASCII","UTF-8","GBK","GB2312"));
                if($encode=="EUC-CN")
                    $encode="GB2312";
                if($encode!="GBK")
                    $filename = iconv($encode,"GBK//IGNORE",$filename);
                //echo $filename."before save"."</br>";
                
                    
                    $mail->setServer($sendhost, $user, $password);
                    $mail->setFrom($username);
                    $mail->setReceiver("$to");
                    $mail->setMailInfo($subject,$body['body'],'../attachment/sendattachment/'.$filename);
                    
                    
                    //判断部分
                   
           
            		    
            
           		
           	}else{

           		
                $mail->setServer($sendhost, $user, $password);
                $mail->setFrom($username);
                $mail->setReceiver("$to");
                $mail->setMailInfo($subject,$body,"");
                
           	}
           	$mail->sendMail();
            }

            return $this->redirect('?r=site/login');

        }else {
            $email=SentEmail::find()->where(['id'=>$id])->asArray()->one();
            $email['check_status']=$check_status;
            //var_dump($email);
            //审核通过，邮件发送出去
            


            $email['dealername']=$dealername;
            $email['foreignid']=$foreignid;

            if($check_status==1&&$email_id!=NULL&&$email_id!=0){
            	$model=new Mail();
            	$email_d=SentEmail::find()->where(['id'=>$email_id])->asArray()->one();
        	$mailaccount = Setting::find()->one();
            $sendhost = $mailaccount->sendhost;
            $username = $mailaccount->username;
            $user = $mailaccount->user;
            $password = $mailaccount->password;
            error_reporting(E_ALL^E_WARNING);
            //$email=SentEmail::find()->where(['id'=>$id])->asArray()->one();
            
            $body = $email_d['text'];
            $to=$email_d['receiver'];
            $subject=$email_d['subject'];
            
            

            $mail = new sendmail();//新建发送
            if($email['attachment']!=null){
            	$filename=basename($email['attachment']);
                $encode = mb_detect_encoding($filename,array("ASCII","UTF-8","GBK","GB2312"));
                if($encode=="EUC-CN")
                    $encode="GB2312";
                if($encode!="GBK")
                    $filename = iconv($encode,"GBK//IGNORE",$filename);
                //echo $filename."before save"."</br>";
                
                    
                    $mail->setServer($sendhost, $user, $password);
                    $mail->setFrom($username);
                    $mail->setReceiver("$to");
                    $mail->setMailInfo($subject,$body,'../attachment/sendattachment/'.$filename);
                    
                    
                    //判断部分
                   
           
            		    
            
           		
           	}else{

           		
                $mail->setServer($sendhost, $user, $password);
                $mail->setFrom($username);
                $mail->setReceiver("$to");
                $mail->setMailInfo($subject,$body,"");
                
           	}
           	$mail->sendMail();
	
            	           
            }
         return $this->render('detail',['model'=>$model,'email'=>$email]);
        }

    }

    
}
