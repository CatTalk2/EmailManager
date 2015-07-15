<?php 
	namespace app\controllers;

	use yii\web\Controller;
	use yii\data\Pagination;
	use app\models\Users;

	class UsersController extends Controller{

		//




		public function actionLogin(){
			$users=Users::find()->asArray()->all();
			//echo $query;

//			$pagination=new Pagination([
//				'defaultPageSize'=>5,
//				'totalCount'=>$query->count(),
//				]);
//
//			$users=$query->orderBy('id')
//				->offset($pagination->offset)
//				->limit($pagination->limit)
//				->all();

			return $this->render('index',['users'=>$users]);
//            $results=Users::find()->asArray()->all();
//            print_r($results);
		}

	}
?>