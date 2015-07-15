<?php $this->beginContent('@app/views/layouts/head.php');?>
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Admin */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Admins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-4 col-md-offset-4">
<div class="admin-view">
<div id="detailform">
    <h1 style="text-align: center"><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'password',
            'permission',
            'name',
            'sex',
            'age',
            'pmail',
            'phone',
        ],
    ]) ?>
    <p style="text-align: center">
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>&nbsp;&nbsp;
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',

            'data' => [
                'confirm' => '确定删除该用户?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
</div>
</div>
<?php $this->endContent();?>
</div>
</div>
