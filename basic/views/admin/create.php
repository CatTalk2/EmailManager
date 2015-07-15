<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Admin */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Admins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginContent('@app/views/layouts/head.php')?>
<div class="col-md-4 col-md-offset-4">
<div class="admin-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
<?php $this->endContent()?>