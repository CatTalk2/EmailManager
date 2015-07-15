
<?php 
		if($permission==1)
			$this->beginContent('@app/views/layouts/distributer.php');
		if($permission==3)
			$this->beginContent('@app/views/layouts/dealer.php');
?>
<?php
	use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\models\Users;
 ?>

    <div class="panel panel-default" >
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="glyphicon glyphicon-th-list"></i>
                联系人列表
            </h3>
        </div>

<div class="form" style="padding:15px">
    <table class="table table-striped table-bordered">
        <thead>
        <tr >
            <th>用户名</th>
            <th>昵称</th>
            <th>性别</th>
            <th>年龄</th>
            <th>个人邮箱</th>
            <th>电话</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($totaluser as $user): ?>
            <tr>
                <td><?= Html::encode("{$user['username']}") ?></td>
                <td><?= Html::encode("{$user['name']}") ?>
                <td><?php echo ($user['sex']==1)?"男":"女"?></td>
                <td><?= Html::encode("{$user['age']}") ?></td>
                <td><?= Html::encode("{$user['pmail']}") ?></td>
                <td><?= Html::encode("{$user['phone']}") ?></span></td>
            </tr>
        <?php endforeach; ?>

        

        </tbody>
    </table>
    

</div>
</div>


<?php $this->endContent();?>