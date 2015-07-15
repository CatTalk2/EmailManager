<?php 
	
	//Users Model 类

	namespace app\models;
	use yii\base\Model;
	use yii\db\ActiveRecord;

	class Users extends ActiveRecord {


		//用户场景
		public function scenarios(){
			return [
				'login'=>['username','password'],//登录场景
			];
		}

		//用户表
		public static function tablename(){
			return 'user';
		}

		//数据库连接
		public static function getdb(){
			return \Yii::$app->db;
		}

		/*
		*封装常见数据库操作
		*/

		//查询用户

		//通过传入SQL语句进行查询
		public function getUserBySQL($sql){
			//对象数组
			return $users=Users::findBySql(Sql)->all();
		}

		public function getUserById($id){
			return $user=Users::find()->where(['id'=>$id])->one();
		}

		public function getUserByDepartment($department){
			return $user=Users::find()->where(['department'=>$department])->orderBy('id')->all();
		}

		public static function getUserByUserName($username) {
			return $user=Users::find()->where(['username'=>$username])->asArray()->one();
		}

		public function getUserByPmail($pmail){
			return $user=Users::find()->where(['pmail'=>$pmail])->one();
		}

		public function getUserByPermisson($permission){
			//对象数组
			return $users=Users::find()->where(['permission'=>$permission])->all();
		}

		public function getUserCount(){
			return $count=Users::find()->count();
		}



		//插入用户
		public function insertUser($insert_user){
			$user = new Users();
			$user->username=$insert_user['username'];
			$user->password=$insert_user['password'];
			$user->permission=$insert_user['permission'];
			$user->name=$insert_user['name'];
			$user->pmail=$insert_user['pmail'];
			$user->save();
		}

		//更新用户
		public function updateUser($update_user){
			$user = Users::findOne($update_user['id']);
			$user->username=$update_user['username'];
			$user->password=$update_user['password'];
			$user->permission=$update_user['permission'];
			$user->name=$update_user['name'];
			$user->pmail=$update_user['pmail'];
			$user->save();
		}

		//删除用户

		public function deleteUser($user){
			$user=Users::findOne($user['id']);
			$user->delete();
		}

		public function deleteAllUser($sql){
			Users::deleteAll($sql);
		}

		//高级查询（关联表）
	}

?>