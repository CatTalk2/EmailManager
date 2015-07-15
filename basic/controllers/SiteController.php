<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\db\Query;
use app\models\Receive;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EntryForm;
use app\models\Users;
use app\models\Email;
use app\models\Email_user_rs;
use app\models\mail;
use app\models\SentEmail;
use receiveMail;
use app\controllers\MailController;
use app\models\Check;
use app\models\VerifyMessage;
use app\models\EmergentEmail;
use app\models\setting;


class SiteController extends Controller
{

	public function actionList($permission)
    {
        $query = Users::find();
        $totaluser = Users::find()->asArray()->all();
        $pagination = new Pagination([
            'defaultPageSize' => 14,
            'totalCount' => $query->count(),
        ]);
        //print_r($permission);
        return $this->render('list', [
            'pagination' => $pagination,
            'totaluser' =>$totaluser,
            'permission'=>$permission
        ]);
    }


	public function actionWrite(){
		return $this->render('/Mail\index');
	}
    public function actionDistributing($emailId){

    	$dealers=$_POST['allName1'];
    	$readers=$_POST['allName2'];
    	$deadtime=$_POST['dead_time'];

    	
    	$read_users=explode(';', $readers);
    	$deal_users=explode(';', $dealers);
    	
    	//处理者权限逻辑
    	foreach ($deal_users as $username) {
    		if(!empty($username)){
    			$user=Users::find()->where(['username'=>$username])->asArray()->one();
        			
        		$userId=$user['id'];
        	
        	//更新handle_status字段
       		$update_email=new Email();
        	$email = Email::findOne($emailId);
			$email->handle_status=1;
			$email->save();

			//插入Email User映射表

        	$email_user = new Email_user_rs();
        	$email_user->permission=1;
        	$email_user->user_id=$userId;
        	$email_user->handle_status=0;
        	$email_user->check_status=0;
        	$email_user->dead_time=$deadtime;
        	$email_user->email_id=$emailId;
        	$email_user->save();
    		}
    	}

    	foreach ($read_users as $username) {
    		if(!empty($username)){
    			$user=Users::find()->where(['username'=>$username])->asArray()->one();
        			
        		$userId=$user['id'];
        	
        	//更新handle_status字段
       		$update_email=new Email();
        	$email = Email::findOne($emailId);
			$email->handle_status=1;
			$email->save();

			//插入Email User映射表

        	$email_user = new Email_user_rs();
        	$email_user->permission=0;
        	$email_user->user_id=$user['id'];
        	$email_user->handle_status=0;
        	$email_user->check_status=0;
        	$email_user->email_id=$emailId;
        	$email_user->save();
    		}
    		
    	}
       	
        return SiteController::actionUndistribute(0);
    }

    public function actionEmaildetail($id){
        $email=Email::find()->where(['id'=>$id])->asArray()->one();
        $users=Users::find()->asArray()->all();

        return $this->render('/Users\distributer\detail', [ 'email' => $email,'users'=>$users]);
    }

    public function actionSentdetail($id){
        $email=SentEmail::find()->where(['id'=>$id])->asArray()->one();
        $users=Users::find()->asArray()->all();

        return $this->render('/Users\dealer\sentdetail', [ 'email' => $email,'users'=>$users]);
    }

    public function actionDealeremaildetail($id){
        $email=Email::find()->where(['id'=>$id])->asArray()->one();
        $users=Users::find()->asArray()->all();
        $session=Yii::$app->session;
        $email_user=Email_user_rs::find()->where(['email_id'=>$email['id'],'user_id'=>$session['user']['id']])->asArray()->one();
        SiteController::actionEmaildeal($id,0);
        return $this->render('/Users\dealer\detail', [ 'email' => $email,'users'=>$users,'email_user'=>$email_user]);
    }

    public function actionDistributed($handle_status){

        $pagination = new Pagination(['defaultPageSize' => 8, 'totalCount' => Email::find()->where(['handle_status'=>1])->count()]);
        $email = Email::find()->where(['handle_status'=>$handle_status])->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
        return $this->render('/Users\distributer\index', [ 'email' => $email, 'pagination' => $pagination]);
    }


    public function actionUndistribute($handle_status){
        $session=Yii::$app->session;
        $user= Users::getUserByUserName($session['user']['username']);
        $session['user']=$user;
        $pagination = new Pagination(['defaultPageSize' => 8, 'totalCount' => Email::find()->where(['handle_status'=>0])->count()]);
        $email = Email::find()->where(['handle_status'=>$handle_status])->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
        return $this->render('/Users\distributer\index', [ 'email' => $email, 'pagination' => $pagination]);
    }




    public function actionLogin()
    {
    	
        $model = new EntryForm();
        $session=Yii::$app->session;
        if (isset($session['user'])){
            $user=$session['user'];
            	if($user['permission']==0){
            		return $this->redirect('?r=admin/index');
            	}

                else if ($user['permission'] == 1) {
                    $count = Email::find()->count();

                    $pagination = new Pagination(['defaultPageSize' => 8, 'totalCount' => Email::find()->count()]);
                    $email = Email::find()->orderBy(['sendtime'=>SORT_DESC])->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
                    return $this->render('/Users\distributer\index', ['user' => $user, 'email' => $email, 'pagination' => $pagination, 'count' => $count]);
                } else if ($user['permission'] == 2) {
                    $count=Check::find()->where(['check_user_id'=>$session['user_id'],'check_status'=>0])->count();
                    $countall=Check::find()->where(['check_user_id'=>$session['user_id']])->count();
                    $pagination=new Pagination(['defaultPageSize'=>8,'totalCount'=>$countall]);
                    $session['count']=$count;
                    $check=Check::find()->where(['check_user_id'=>$session['user_id']])->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
                    $checkemails=array();
                    foreach ($check as $key){
                        $checkemail=SentEmail::find()->where(['id'=>$key['email_id']])->asArray()->one();
                        $emailuser=Users::find()->where(['id'=>$checkemail['user_id']])->asArray()->one();
                        $checkemail['dealername']=$emailuser['username'];
                        $checkemail['check_status']=$key['check_status'];
                        $checkemail['foreignid']=$key['id'];
                        $checkemails[]=$checkemail;
                    }
                    $check['count']=$count;
                    return $this->render('/verifier\index', ['user' => $user,'check'=>$check,'checkemails'=>$checkemails,'pagination'=>$pagination]);
                } else if ($user['permission'] == 3) {
                    $count=Email_user_rs::find()->where(['user_id'=>$user['id']])->count();
                	$pagination=new Pagination(['defaultPageSize'=>8,'totalCount'=>$count]);
                	$session['count']=$count;
                    $dealEmail=Email_user_rs::find()->where(['user_id'=>$user['id']])->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
                    
                    /*$sql='SELECT e.id,e.subject,e.sender,e.receiver,e.text,e.label,e.check_status,e.sendtime,e.attachment,es.* FROM email as e,email_user_rs as es WHERE e.id=es.email_id and es.user_id='.$user['id'];
                    $connection=Yii::$app->db;
                    $command=$connection->createCommand($sql);
                    $result=$command->queryAll();
                    return $this->render('/Users\dealer\index', ['user' => $user,'pagination'=>$pagination]);*/
                    $emails=array();
                    foreach ($dealEmail as $key){
                        $useremail=Email::find()->orderBy(['sendtime'=>SORT_DESC])->where(['id'=>$key['email_id']])->asArray()->one();
                        $emails[]=$useremail;
                    }
                    return $this->render('/Users\dealer\index', ['user' => $user,'emails'=>$emails,'dealEmail'=>$dealEmail,'pagination'=>$pagination]);
                }


        }
        else if ($model->load(Yii::$app->request->post())&& $model->validate()) {


           $user= Users::getUserByUserName($model->name);
            $session['user']=$user;
            $session['user_id']=$user['id'];
            $session['model']=$model;
            if(empty($user)){
                $message="用户名不存在!";
                return $this->render('login', ['message' => $message,'model'=>$model]);
            }else if($user['password']!=$model->password){
                $message="密码输入错误!";
                return $this->render('login', ['message' => $message,'model'=>$model]);
            }else {
            	if($user['permission']==0){
            		return $this->redirect('?r=admin/index');
            	}
                else if ($user['permission']==1){
                    $count=Email::find()->where(['handle_status' => 0])->count();
                    $session['undistributer_count']=$count;

                    $pagination=new Pagination(['defaultPageSize'=>8,'totalCount'=>Email::find()->count()]);
                    $email=Email::find()->orderBy(['sendtime'=>SORT_DESC])->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
                    return $this->render('/Users\distributer\index', ['user' => $user,'email'=>$email,'pagination'=>$pagination,'count'=>$count]);
                }

                else  if ($user['permission']==2){
                    $count=Check::find()->where(['check_user_id'=>$session['user_id'],'check_status'=>0])->count();
                    $countall=Check::find()->where(['check_user_id'=>$session['user_id']])->count();
                    $pagination=new Pagination(['defaultPageSize'=>8,'totalCount'=>$countall]);
                    $session['count']=$count;
                    $check=Check::find()->where(['check_user_id'=>$session['user_id']])->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
                    $checkemails=array();
                    foreach ($check as $key){
                        $checkemail=SentEmail::find()->where(['id'=>$key['email_id']])->asArray()->one();
                        $emailuser=Users::find()->where(['id'=>$checkemail['user_id']])->asArray()->one();
                        $checkemail['dealername']=$emailuser['username'];
                        $checkemail['check_status']=$key['check_status'];
                        $checkemail['foreignid']=$key['id'];
                        $checkemails[]=$checkemail;
                    }
                    $check['count']=$count;
                    return $this->render('/verifier\index', ['user' => $user,'check'=>$check,'checkemails'=>$checkemails,'pagination'=>$pagination]);
                }


                else  if ($user['permission']==3){
$count=Email_user_rs::find()->where(['user_id'=>$user['id']])->count();
                	$pagination=new Pagination(['defaultPageSize'=>8,'totalCount'=>$count]);
                	$session['count']=$count;
                    $dealEmail=Email_user_rs::find()->where(['user_id'=>$user['id']])->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
                    
                    /*$sql='SELECT e.id,e.subject,e.sender,e.receiver,e.text,e.label,e.check_status,e.sendtime,e.attachment,es.* FROM email as e,email_user_rs as es WHERE e.id=es.email_id and es.user_id='.$user['id'];
                    $connection=Yii::$app->db;
                    $command=$connection->createCommand($sql);
                    $result=$command->queryAll();
                    return $this->render('/Users\dealer\index', ['user' => $user,'pagination'=>$pagination]);*/
                    $emails=array();
                    foreach ($dealEmail as $key){
                        $useremail=Email::find()->orderBy(['sendtime'=>SORT_DESC])->where(['id'=>$key['email_id']])->asArray()->one();
                        $emails[]=$useremail;
                    }
                    return $this->render('/Users\dealer\index', ['user' => $user,'emails'=>$emails,'dealEmail'=>$dealEmail,'pagination'=>$pagination]);
                }
            }

        } else {
// 无论是初始化显示还是数据验证错误
            return $this->render('login', ['model' => $model]);
        }
    }

    //public function checkway($user){

    //}




    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }


     //注销登出
    public function actionCancel()
    {
        //销毁session,注意调用本Controller内方法
		unset(Yii::$app->session['user']);
        return SiteController::actionLogin();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }


    public function actionWriteindex()
    {
        $model = new mail;
        if ($model->load(Yii::$app->request->post())&& $model->validate())
        {
            error_reporting(E_ALL^E_WARNING);
            $request = Yii::$app->request;
            $body = $request->post();

            $to=$model->receiver;
//            $text=$model->text;
            $subject=$model->subject;
//            $body = $model->body;
            print_r($model);
            $mail = new sendmail();//新建发送
            $mail->setServer("smtp.126.com", "tclrg", "Luanruitest");
            $mail->setFrom("tclrg@126.com");
            $mail->setReceiver("$to");
            $mail->setMailInfo($subject,$body['body'],false,NULL);
            $mail->sendMail();
            return $this->render('/Users\dealer\write', ['model' => $model]);
        }
        else
        	//print_r($model);
            return $this->render('/Users\dealer\write', ['model' => $model]);
    }


    //处理人员邮件详细页面阅读 :0、回复 :1、转发:2
    public function actionEmaildeal($emailId,$deal_type){
        $session=Yii::$app->session;
    	switch ($deal_type) {
            case 0:
                //插入Email User映射表
                $email_user = new Email_user_rs();
                $email_user = Email_user_rs::find()->where(['email_id' => $emailId, 'user_id' => $session['user']['id']])->one();
                if($email_user->handle_status!=3 ){
                	$email_user->handle_status = 1;
                	$email_user->save();
                }
                

                break;
            case 1:
                $email = Email::find()->where(['id' => $emailId])->one();
                $email_user = new Email_user_rs();
                $email_user = Email_user_rs::find()->where(['email_id' => $emailId, 'user_id' => $session['user']['id']])->one();
                $email_user->handle_status = 3;
                $email_user->save();
                $model=new Mail();
                //return $this->render('/Mail\index',['model'=>$model,'receiver'=>$email->sender,'subject'=>"RE:".$email->subject]);
                //Yii:$app->runController('mail/index/');
                return $this->redirect(array('mail/index','subject'=>"RE:".$email->subject,'receiver'=>$email->sender));

                break;
            case 2:

            	$email = Email::find()->where(['id' => $emailId])->one();
                $email_user = new Email_user_rs();
                $email_user = Email_user_rs::find()->where(['email_id' => $emailId, 'user_id' => $session['user']['id']])->one();
                $email_user->handle_status = 2;
                $email_user->save();
               
                //return $this->render('/Mail\index',['model'=>$model,'receiver'=>$email->sender,'subject'=>"RE:".$email->subject]);
                //Yii:$app->runController('mail/index/');
                //return SiteController::aclogin();


                break;
        }
    	return SiteController::actionLogin();

    }

    //处理人员已发送邮件列表
    public function actionSent($user_id){

    	$count=SentEmail::find()->where(['user_id'=>$user_id])->count();
    	
    	$pagination = new Pagination(['defaultPageSize' => 8, 'totalCount' => $count]);

        $sent_emails= SentEmail::find()->orderBy(['send_time'=>SORT_DESC])->where(['user_id'=>$user_id])->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
        //print_r($sent_emails);
        return $this->render('/Users\dealer\sent', [ 'sent_emails' => $sent_emails, 'pagination' => $pagination,'count'=>$count]);
        //return SiteController::actionLogin();


    }

    

    //回退邮件
    public function actionBackemail($emailId,$userId){
    	$user=$_POST['workerlist'];
    	
    	//退回给分发人员
    	if($user==NULL){

    		//关系表中删除
    		
    		$email_user = new Email_user_rs();
    		$email_user=Email_user_rs::find()->where(['email_id'=>$emailId,'user_id'=>$userId])->one();
        	$email_user->delete();

        	//Email表中修改分发状态
        	$email=new Email();
        	$email = Email::findOne($emailId);
			$email->handle_status=0;
			$email->is_back=1;
			$email->save();

    	}else{
    		$new_user=Users::find()->where(['username'=>$user])->asArray()->one();
    		$email_user = new Email_user_rs();
    		$email_user=Email_user_rs::find()->where(['email_id'=>$emailId,'user_id'=>$userId])->one();
        	$email_user->user_id=$new_user['id'];
        	$email_user->handle_status=0;
        	$email_user->save();
       	}
        return SiteController::actionLogin();

    }


    //刷新新邮件
    public function actionRefresh(){
    	SiteController::actionReceiver();
    	return SiteController::actionLogin();
    }

    //处理人员紧急邮件列表
    public function actionEmergentemail($user_id){


    	$count=Email_user_rs::find()->where(['user_id'=>$user_id])->count();
        $pagination=new Pagination(['defaultPageSize'=>8,'totalCount'=>$count]);
       $emergent_cont=0;
        $dealEmail=Email_user_rs::find()->where(['user_id'=>$user_id])->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
        foreach ($dealEmail as $demail) {
        	if($demail['dead_time']!=NULL)
        		$emergent_cont++;
        }
        $emails=array();
        foreach ($dealEmail as $key){
            $useremail=Email::find()->orderBy(['sendtime'=>SORT_DESC])->where(['id'=>$key['email_id']])->asArray()->one();
            $emails[]=$useremail;

        }
        return $this->render('/Users\dealer\emergent', ['emails'=>$emails,'dealEmail'=>$dealEmail,'pagination'=>$pagination,'count'=>$count,'emergent_count'=>$emergent_cont]);
    }

    //分发人员紧急邮件列表
    public function actionDistributeremergentemail(){
    	$count=Email_user_rs::find()->count();
    	$emergent_cont=0;
        $Emails=Email_user_rs::find()->asArray()->all();
        foreach ($Emails as $demail) {
        	if($demail['dead_time']!=NULL)
        		$emergent_cont++;
        }
        $pagination=new Pagination(['defaultPageSize'=>8,'totalCount'=>$emergent_cont]);
        $dealEmail=Email_user_rs::find()->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
        //$dealEmail=Email_user_rs::find()->count();
        //print_r($dealEmail);
       	$emails=array();
        foreach ($dealEmail as $key){
            $useremail=Email::find()->orderBy(['sendtime'=>SORT_DESC])->where(['id'=>$key['email_id']])->asArray()->one();
            $emails[]=$useremail;

        }

        return $this->render('/Users\distributer\emergent', ['emails'=>$emails,'dealEmail'=>$dealEmail,'pagination'=>$pagination,'count'=>$count,'emergent_count'=>$emergent_cont]);
        
    }


    //接收邮件
    public function actionReceiver(){
    	$model = new Receive;
       	error_reporting(E_ALL||~E_WARNING||~E_NOTICE);


        $mailaccount = setting::find()->one();
        $user = $mailaccount->user;
        $password = $mailaccount->password;
        $username = $mailaccount->username;
        $receivehost = $mailaccount->receivehost;
        $receiveapply = "imap";
        $receiveport = $mailaccount->receiveport;
        $obj = new receiveMail($user,$password,$username,$receivehost,$receiveapply,$receiveport,'ture');
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
            

            $text=$obj->getBody($i);

            $encode = mb_detect_encoding($text, array("ASCII", "UTF-8", "GB2312", "GBK", "BIG5", "EUC-CN"));
                if ($encode == "EUC-CN")
                    $encode = "GB2312";
                if ($encode != "UTF-8")
                    $text = iconv("$encode", "UTF-8", $text);

            $model->text=$text;

            $attachments = $obj->GetAttach($i,"../attachment/receiveattachment");
            $attach="";
            if($attachments!="") {
            	$attach=$attachments;
                $encode = mb_detect_encoding($attachments, array("ASCII", "UTF-8", "GB2312", "GBK", "BIG5", "EUC-CN"));
                if ($encode == "EUC-CN")
                    $encode = "GB2312";
                if ($encode != "UTF-8")
                    $attach = iconv("$encode", "UTF-8", $attachments);
            }

               $model->subject=$head['subject'];
            $model->sender=$head['from'];

            $model->sendtime=date("Y-m-d H:i:s",strtotime($head['date']));
            
            $model->attachment = $attach;

            $model->save();
        
        }
        $obj->close_mailbox();
    }



    public function actionCheckinfo($check_status){
        $session=Yii::$app->session;
        $count=Check::find()->where(['check_user_id'=>$session['user_id'],'check_status'=>$check_status])->count();
        $pagination=new Pagination(['defaultPageSize'=>8,'totalCount'=>$count]);
        $check=Check::find()->where(['check_user_id'=>$session['user_id'],'check_status'=>$check_status])->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
        $checkemails=array();
        foreach ($check as $key){
            $checkemail=SentEmail::find()->where(['id'=>$key['email_id']])->asArray()->one();
            $emailuser=Users::find()->where(['id'=>$checkemail['user_id']])->asArray()->one();
            $checkemail['dealername']=$emailuser['username'];
            $checkemail['check_status']=$key['check_status'];
            $checkemail['foreignid']=$key['id'];
            $checkemail['check_advise']=$key['check_advise'];
            $checkemails[]=$checkemail;
        }
        $check['count']=$count;
        $info=$check_status;
        return $this->render('/verifier\index', ['check'=>$check,'checkemails'=>$checkemails,'pagination'=>$pagination,'info'=>$info]);
    }

    public function actionCheckself($user_id,$check_status){
        $count=Check::find()->where(['user_id'=>$user_id,'check_status'=>$check_status])->count();
        $user=Users::find()->where(['id'=>$user_id])->asArray()->one();
        $pagination=new Pagination(['defaultPageSize'=>8,'totalCount'=>$count]);
        $check=Check::find()->where(['user_id'=>$user_id,'check_status'=>$check_status])->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
        $emails=array();
        foreach($check as $checkmail){
            $sentmail=SentEmail::find()->orderBy(['send_time'=>SORT_DESC])->where(['id'=>$checkmail['email_id']])->asArray()->one();
            $sentmail['check_status']=$checkmail['check_status'];
            $sentmail['check_advise']=$checkmail['check_advise'];
            $checker=Users::find()->where(['id'=>$checkmail['check_user_id']])->asArray()->one();
            $sentmail['checker']=$checker['username'];
            $emails[]=$sentmail;
        }
        $check['count']=$count;
        $check['username']=$user['username'];


        return $this->render('/Users\dealer\check', ['emails'=>$emails,'pagination'=>$pagination,'check'=>$check]);
    }

    public function actionCheckdetail($id,$username,$check_status,$checker,$check_advise=null){
        $email=SentEmail::find()->where(['id'=>$id])->asArray()->one();
        $email['username']=$username;
        $email['check_status']=$check_status;
        $email['checker']=$checker;
        $email['check_advise']=$check_advise;

        return $this->render('/Users\dealer\checkdetail',['email'=>$email]);
    }
}
