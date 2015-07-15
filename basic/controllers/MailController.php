<?php
/**
 * Created by PhpStorm.
 * User: 李洋
 * Date: 2015/6/29
 * Time: 15:05
 */
namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\Mail;
use sendmail;
use app\models\SentEmail;
use app\models\Check;
use app\models\Users;
use yii\web\UploadedFile;//上传文件需要的
use app\models\Setting;//获取数据库信息

class MailController extends Controller
{
    public function actionIndex($subject,$receiver)
    {
        $model = new Mail();
        $message=true;
        $check_users=Users::find()->where(['permission'=>2])->asArray()->all();
       // print_r($check_users);
        if ($model->load(Yii::$app->request->post()))
        {
        	//粘贴部分
        	$mailaccount = Setting::find()->one();
            $sendhost = $mailaccount->sendhost;
            $username = $mailaccount->username;
            $user = $mailaccount->user;
            $password = $mailaccount->password;
            error_reporting(E_ALL^E_WARNING);
            $request = Yii::$app->request;
            $body = $request->post();
            $to=$model->receiver;
            $subject=$model->subject;
            $model->file =UploadedFile::getInstance($model, 'file');

            //error_reporting(E_ALL^E_WARNING);
           // $request = Yii::$app->request;
            //$body = $request->post();

            //$to=$model->receiver;
//            $text=$model->text;
           // $subject=$model->subject;
//            $body = $model->body;
            //print_r($model);
            //粘贴部分
            if($model->file!=null)
            {
                $filename=$model -> file -> name;
                $encode = mb_detect_encoding($filename,array("ASCII","UTF-8","GBK","GB2312"));
                if($encode=="EUC-CN")
                    $encode="GB2312";
                if($encode!="GBK")
                    $filename = iconv($encode,"GBK//IGNORE",$filename);
                //echo $filename."before save"."</br>";
                if($model->file->saveAs('../attachment/sendattachment/' .$filename))
                {
                    $mail = new sendmail();//新建发送
                    $mail->setServer($sendhost, $user, $password);
                    $mail->setFrom($username);
                    $mail->setReceiver("$to");
                    $mail->setMailInfo($subject,$body['body'],'../attachment/sendattachment/'.$filename);
                    $message=true;
                    
                    //判断部分
                   

                    
        				//


                    
                    


        			//插入check表
        			$check_user=$_POST['check_user'];
        			if($check_user!=NULL){

        				//$time=date("Y-m-d H:i:s",time());
            			$session=Yii::$app->session;
            			$sent_email = new SentEmail();
        				$sent_email->subject=$subject;
        				$sent_email->receiver=$to;
        				$sent_email->text=$body['body'];
        				$sent_email->attachment='../attachment/sendattachment/'.$filename.';';
        				$sent_email->sender=$username;
						$sent_email->user_id=$session['user_id'];
        				$sent_email->save();

        				$tmp=Users::find()->where(['username'=>$check_user])->one();
        				$check=new Check();
        				$check->email_id=$sent_email->id;
        				$check->check_user_id=$tmp->id;
        				$check->user_id=$session['user_id'];
        				$check->check_status=0;
        				$check->save();

        				

        			return $this->redirect('?r=site/checkself&user_id='.$session['user_id'].'&check_status=0');

        			}else {
        		
        			if(!$mail->sendMail()){
        					$message=false;
        				return $this->render('index', ['model' => $model,'check_users'=>$check_users,'subject'=>$subject,'receiver'=>$receiver]);
        				
        			}
                    	
        				//$time=date("Y-m-d H:i:s",time());
            			$session=Yii::$app->session;
            			$sent_email = new SentEmail();
        				$sent_email->subject=$subject;
        				$sent_email->receiver=$to;
        				$sent_email->text=$body['body'];
        				$sent_email->attachment='../attachment/sendattachment/'.$filename.';';
        				$sent_email->sender=$username;
						$sent_email->user_id=$session['user_id'];
        				$sent_email->save();


                    	return $this->redirect('?r=site/sent&user_id='.$session['user_id']);
        			}

              }
            	
        	}
            else
            {
                $mail = new sendmail();//新建发送
                $mail->setServer($sendhost, $user, $password);
                $mail->setFrom($username);
                $mail->setReceiver("$to");
                $mail->setMailInfo($subject,$body['body'],"");

              	//插入已发送列表
            		
            	

        	//插入check表
        		$check_user=$_POST['check_user'];
        		if($check_user!=NULL){

        			//$time=date("Y-m-d H:i:s",time());
            			$session=Yii::$app->session;
            			$sent_email = new SentEmail();
        				$sent_email->subject=$subject;
        				$sent_email->receiver=$to;
        				$sent_email->text=$body['body'];
        				//$sent_email->attachment='../attachment/sendattachment/'.$filename.';';
        				$sent_email->sender=$username;
						$sent_email->user_id=$session['user_id'];
        				$sent_email->save();

        			$tmp=Users::find()->where(['username'=>$check_user])->one();
        			$check=new Check();
        			$check->email_id=$sent_email->id;
        			$check->check_user_id=$tmp->id;
        			$check->user_id=$session['user_id'];
        			$check->check_status=0;
        			$check->save();

        			


        			return $this->redirect('?r=site/checkself&user_id='.$session['user_id'].'&check_status=0');

        		}else {
        			

        			if(!$mail->sendMail()){
        				$message=false;
        				return $this->render('index', ['model' => $model,'check_users'=>$check_users,'subject'=>$subject,'receiver'=>$receiver]);
       
        			}

        			//$time=date("Y-m-d H:i:s",time());
            			$session=Yii::$app->session;
            			$sent_email = new SentEmail();
        				$sent_email->subject=$subject;
        				$sent_email->receiver=$to;
        				$sent_email->text=$body['body'];
        				//$sent_email->attachment='../attachment/sendattachment/'.$filename.';';
        				$sent_email->sender=$username;
						$sent_email->user_id=$session['user_id'];
        				$sent_email->save();
                    	

                    return $this->redirect('?r=site/sent&user_id='.$session['user_id']);
        		}

             
            }
        }
        else
            return $this->render('index', ['model' => $model,'check_users'=>$check_users,'subject'=>$subject,'receiver'=>$receiver]);
    }


    //重新编辑
     public function actionRewrite($email_id,$subject,$receiver,$text,$check_user)
    {
        $model = new Mail();
        $message=true;
        $session=Yii::$app->session;
        //$check_users=Users::find()->where(['permission'=>2])->asArray()->all();
       // print_r($check_users);
        if ($model->load(Yii::$app->request->post()))
        {
        	//粘贴部分
        	$mailaccount = Setting::find()->one();
            $sendhost = $mailaccount->sendhost;
            $username = $mailaccount->username;
            $user = $mailaccount->user;
            $password = $mailaccount->password;
            error_reporting(E_ALL^E_WARNING);
            $request = Yii::$app->request;
            $body = $request->post();
            $to=$model->receiver;
            $subject=$model->subject;
            $model->file =UploadedFile::getInstance($model, 'file');

            //error_reporting(E_ALL^E_WARNING);
           // $request = Yii::$app->request;
            //$body = $request->post();

            //$to=$model->receiver;
//            $text=$model->text;
           // $subject=$model->subject;
//            $body = $model->body;
            //print_r($model);
            //粘贴部分
            if($model->file!=null)
            {
                $filename=$model -> file -> name;
                $encode = mb_detect_encoding($filename,array("ASCII","UTF-8","GBK","GB2312"));
                if($encode=="EUC-CN")
                    $encode="GB2312";
                if($encode!="GBK")
                    $filename = iconv($encode,"GBK//IGNORE",$filename);
                //echo $filename."before save"."</br>";
                if($model->file->saveAs('../attachment/sendattachment/' .$filename))
                {
                    $mail = new sendmail();//新建发送
                    $mail->setServer($sendhost, $user, $password);
                    $mail->setFrom($username);
                    $mail->setReceiver("$to");
                    $mail->setMailInfo($subject,$body['body'],'../attachment/sendattachment/'.$filename);
                    $message=true;
                    


        			//插入check表
        			//$check_user=$_POST['check_user'];
        			if($check_user!=NULL){
        				
        				//更新sent邮件列表
        			$sent_email = SentEmail::findOne($email_id);
					$sent_email->subject=$subject;
        			$sent_email->receiver=$to;
        			$sent_email->text=$body['body'];
        			$sent_email->attachment='../attachment/sendattachment/'.$filename.';';
        			//$sent_email->sender=$username;
					//$sent_email->user_id=$session['user_id'];
        			$sent_email->save();

        				
        				$ck= Check::find()->where(['email_id'=>$email_id])->one();
        				
        				//$check->user_id=$session['user_id'];
        				$ck->check_status=0;
        				$ck->save();

        				

        			return $this->redirect('?r=site/checkself&user_id='.$session['user_id'].'&check_status=0');

        			}else {
        		
        			if(!$mail->sendMail()){
        					$message=false;
        				return $this->render('rewrite', ['model' => $model,'subject'=>$subject,'receiver'=>$receiver,'text'=>$text,'check_users'=>$check_users]);
        				
        			}
                    	
        				//$time=date("Y-m-d H:i:s",time());
            			$session=Yii::$app->session;
            			$sent_email = new SentEmail();
        				$sent_email->subject=$subject;
        				$sent_email->receiver=$to;
        				$sent_email->text=$body['body'];
        				$sent_email->attachment='../attachment/sendattachment/'.$filename.';';
        				$sent_email->sender=$username;
						$sent_email->user_id=$session['user_id'];
        				$sent_email->save();


                    	return $this->redirect('?r=site/sent&user_id='.$session['user_id']);
        			}

              }
            	
        	}
            else
            {
                $mail = new sendmail();//新建发送
                $mail->setServer($sendhost, $user, $password);
                $mail->setFrom($username);
                $mail->setReceiver("$to");
                $mail->setMailInfo($subject,$body['body'],"");

              	//插入已发送列表
            		
            	

        	//插入check表
        		//$check_user=$_POST['check_user'];
        		if($check_user!=NULL){

        			//$time=date("Y-m-d H:i:s",time());
            			$sent_email = SentEmail::findOne($email_id);
					$sent_email->subject=$subject;
        			$sent_email->receiver=$to;
        			$sent_email->text=$body['body'];
        			//$sent_email->attachment='../attachment/sendattachment/'.$filename.';';
        			//$sent_email->sender=$username;
					//$sent_email->user_id=$session['user_id'];
        			$sent_email->save();

        				$ck= Check::find()->where(['email_id'=>$email_id])->one();
        				
        				//$check->user_id=$session['user_id'];
        				$ck->check_status=0;
        				$ck->save();

        			//print_r($check['user_id']);


        			return $this->redirect('?r=site/checkself&user_id='.$session['user_id'].'&check_status=0');

        		}else {
        			

        			if(!$mail->sendMail()){
        				$message=false;
        				return $this->render('rewrite', ['model' => $model,'subject'=>$subject,'receiver'=>$receiver,'text'=>$text,'check_user'=>$check_user]);
       
        			}

        			//$time=date("Y-m-d H:i:s",time());
            			$session=Yii::$app->session;
            			$sent_email = new SentEmail();
        				$sent_email->subject=$subject;
        				$sent_email->receiver=$to;
        				$sent_email->text=$body['body'];
        				//$sent_email->attachment='../attachment/sendattachment/'.$filename.';';
        				$sent_email->sender=$username;
						$sent_email->user_id=$session['user_id'];
        				$sent_email->save();
                    	

                    return $this->redirect('?r=site/sent&user_id='.$session['user_id']);
        		}

             
            }
        }
        else
            return $this->render('rewrite', ['model' => $model,'subject'=>$subject,'receiver'=>$receiver,'text'=>$text,'check_user'=>$check_user]);
    }




    public function actionDownload($file){
    	$file=iconv("UTF-8","GBK",$file);
    	$file_name=basename($file);
	//用以解决中文不能显示出来的问题
	
	$file_path=$file;
	//首先要判断给定的文件存在与否
	if(!file_exists($file_path)){
    	return ;
	}
	$fp=fopen($file_path,"r");
	$file_size=filesize($file_path);
	//下载文件需要用到的头
	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=".$file_name);
	$buffer=1024;
	$file_count=0;
	//向浏览器返回数据
	while(!feof($fp) && $file_count<$file_size){
    	$file_con=fread($fp,$buffer);
    	$file_count+=$buffer;
    	echo $file_con;
	}
		fclose($fp);	
	}

}