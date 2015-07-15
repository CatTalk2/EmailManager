<?php $this->beginContent('@app/views/layouts/dealer.php');?>
            <!--panel-->
            <div id="content">
                <div class="panel panel-default">

                    <div class="panel-body">
                        <?php
                        use yii\helpers\Html;
                        use yii\widgets\ActiveForm;
                        Use app\models\Users;
                        $session=Yii::$app->session;
                        
                        ?>
                        <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
                        <?php $js=<<<JS
                       	var editor;
                        KindEditor.ready(function(K) {
                              editor = K.create('textarea[name="body"]', {
                                        allowFileManager : true,
                                        afterBlur: function(){this.sync();}
                              });
                        });
JS;
                        $this->registerJs($js);
                        $this->registerCssFile('libs/kindeditor/themes/default/default.css');
                        $this->registerJsFile('libs/kindeditor/kindeditor-min.js');
                        $this->registerJsFile('libs/kindeditor/lang/zh_CN.js');
                        ?>
                        <div class="form-group">
                            <?php  if(!isset($receiver)) $receiver="";
                            if(!isset($subject)) $subject="";
                            if(!isset($text)) $text="";
                            ?>

                        <?= $form->field($model, 'subject')->textInput(['maxlength' => 30,'value'=>$subject, 'class' => 'form-control'])->label("主题：") ?>
                        </div>
                        <div class="form-group">
                        <?= $form->field($model, 'receiver')->textInput(['maxlength' => 30,'value'=>$receiver, 'class' => 'form-control'])->label("收件人：")  ?>
                        </div>
                        
                        <div class="form-group">
                    		
                   			 <?= $form->field($model, 'file')->fileInput()->label("添加附件") ?>
                   			 <?php if(isset($message)&&$message==true) echo"<p style='color: green'>发送成功</p>";else if(isset($message)&&$message==false) echo"<p style='color:red' >发送失败</p>"?>
               			 </div>

                        <div class="form-group">
                        <?= $form->field($model, 'body')->textArea(['name'=>'body', 'class' => 'form-control','innerHtml'=>$text])->label("内容:") ?>
                        </div>

                        <div class="row" style="margin-left:0px;">

                <div class="form-group"><label>审核人: </label>
                	<?php

                		$checker=Users::find()->where(['username'=>$check_user])->one();
                		echo $checker['name'];
                	?>
                </div>
                </div>

                        <br/>

                        <?= Html::submitButton('发 送', ['class' => 'btn btn-primary','style'=>'width:100px']) ?>
                        <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>

<?php $this->endContent();?>

