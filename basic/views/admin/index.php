<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户列表';
$this->params['breadcrumbs'][] = $this->title;
//var_dump($this);
//var_dump($dataProvider);
//var_dump($searchModel);
?>
<?php $this->beginContent('@app/views/layouts/head.php');?>
<div class="col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
<div class="admin-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'password',
            'permission',
            'name',
            // 'sex',
            // 'age',
            // 'pmail',
            // 'phone',

            [
                'header' =>'操作',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' =>[
                    'delete' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'Delete'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            'data-confirm' => Yii::t('yii', '确定删除该用户？'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    },
                ],
            ],

        ],
        
    ]); ?>
    <p>
        <?= Html::a('创建用户', ['create'], ['class' => 'btn btn-success btn-lg']) ?>
    </p>

</div>
</div>
    </div>
</div>
</body>
</html>
<?php $this->endContent();?>

