<?php

namespace app\controllers;

use Yii;
use app\models\Admin;
use app\models\AdminSearch;
use app\models\Receive;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Setting;
use receiveMail;
error_reporting(E_ALL||~E_WARNING||~E_NOTICE);
/**
 * AdminController implements the CRUD actions for Admin model.
 */
class AdminController extends Controller
{
	public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Admin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session = Yii::$app->session;
        if (!$session->isActive)
            $session->open();
        if($session['user']==null||$session['user']['permission']!=0)
        {
            return $this->redirect('?r=login');
        }
        $searchModel = new AdminSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionSetmail()
    {
        $model = new Setting;
        $message = true;
        $query = Setting::find()->one();
        if (Yii::$app->request->post())
        {
            $request = Yii::$app->request;
            $password = $request->post('Setting')['password'];
            $username = $request->post('Setting')['username'];
            $sendhost = $request->post('Setting')['sendhost'];
            $sendport = $request->post('Setting')['sendport'];
            $user = $request->post('Setting')['user'];
            $receivehost = $request->post('Setting')['receivehost'];
            $receiveport = $request->post('Setting')['receiveport'];
            $model1 = new Receive;
            $obj = new receiveMail($user,$password,$username,$receivehost,'imap','993','ture');

            if($obj->connect())
            {
                $query = Setting::find()->one();
                $query -> sendhost = $sendhost;
                $query -> sendport = $sendport;
                $query -> user = $user;
                $query -> password = $password;
                $query -> username = $username;
                $query -> receivehost = $receivehost;
                $query -> receiveport = $receiveport;
                $query->save();
                return $this->render('setting', ['model' => $model,'settingMessage' => $query,'message' =>$message]);
            }
            else
            {
                $message = false;
                return $this->render('setting',['model'=> $model,'settingMessage' => $query,'message' =>$message]);
            }
        }
        else
        {
            return $this->render('setting',['model' => $model,'settingMessage' => $query,'message'=>$message]);
        }
    }
    /**
     * Displays a single Admin model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Admin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Admin();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Admin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Admin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

       return $this->redirect(['index']);
    }

    /**
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



}
