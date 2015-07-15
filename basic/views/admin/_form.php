<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-form" xmlns="http://www.w3.org/1999/html">
<div>
    <?php $form = ActiveForm::begin(['options'=>['id'=>'createform']]); ?>

    <?= $form->field($model, 'username',['labelOptions'=>[]])->textInput(['maxlength' => true])->label('用户名') ?>

    <?= $form->field($model, 'password')->textInput(['maxlength' => true])->label('密码') ?>

    <?= $form->field($model, 'permission')->textInput()->label('权限（0,1,2,3分别代表超管、分发人员、审核人员、处理人员）') ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('昵称') ?>

    <?= $form->field($model, 'sex')->textInput(['maxlength' => true])->label('性别（1为男2为女）') ?>

    <?= $form->field($model, 'age')->textInput()->label('年龄') ?>

    <?= $form->field($model, 'pmail')->textInput(['maxlength' => true])->label('个人邮箱') ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true])->label('电话') ?>

    <div class="form-group">

        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    </div>

    <?php ActiveForm::end(); ?>
</div>

</div>
