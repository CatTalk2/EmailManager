<?php
/**
 * Created by PhpStorm.
 * User: 李洋
 * Date: 2015/7/6
 * Time: 22:22
 */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;


?>

<?php $this->beginContent('@app/views/layouts/head.php');?>
    <div class="col-md-4 col-md-offset-4" xmlns="http://www.w3.org/1999/html">
        <div class="admin-update" id="settingform">
            <h2>更新邮箱信息（邮箱需开启IMAP服务）</h2>
            </br>
            <p style="color: red"><?php if(!$message) echo "账号或密码错误"?></p>
            <div>
                <?php $form = ActiveForm::begin(['options'=>['id'=>'']]); ?>

                <?= $form->field($model, 'username',['labelOptions'=>[]])->textInput(['maxlength' => true,'value'=>$settingMessage->username,'id'=>'username'])->label('邮箱账号') ?>

                <?= $form->field($model, 'password')->textInput(['maxlength' => true,'value'=>$settingMessage->password,'id'=>'password'])->label('密码') ?>

                <?= $form->field($model, 'sendhost',['labelOptions'=>[]])->textInput(['maxlength' => true,'id'=>'sendhost','readonly'=>true,'value'=>$settingMessage->sendhost])->label('发送主机') ?>

                <?= $form->field($model, 'sendport')->textInput(['maxlength' => true,'id'=>'sendport','readonly'=>true,'value'=>$settingMessage->sendport])->label('发送端口') ?>

                <?= $form->field($model, 'user')->textInput(['id'=>'user','readonly'=>true,'value'=>$settingMessage->user])->label('用户名') ?>

                <?= $form->field($model, 'receivehost')->textInput(['value'=>'','id'=>'receivehost','readonly'=>true,'value'=>$settingMessage->receivehost])->label('接收端口') ?>

                <?= $form->field($model, 'receiveport')->textInput(['maxlength' => true,'id'=>'receiveport','readonly'=>true,'value'=>$settingMessage->receivehost])->label('接受主机') ?>
</br>
                <div class="form-group">
                    <?= Html::submitButton('保存', ['class' => 'btn btn-lg btn-primary btn-block myfont']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
</div>
<?php $this->endContent();?>