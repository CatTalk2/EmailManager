<html>
<head>
    <title>mailonline</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <script src="../views/layouts/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../views/layouts/js/jquery.js"></script>
    <link rel="icon" href="../views/layouts/img/favicon.ico">
    <link rel="stylesheet" type="text/css" href="../views/layouts/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../views/layouts/css/index.css">
    <link rel="stylesheet" type="text/css" href="../views/layouts/css/style.css">
    <script type="text/javascript" src="../views/layouts/js/chuli.js"></script>

</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top" id="nav">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>


            <div class="container-fluid" >
                <div class="navbar-header" style="margin-left:20px;">
                    <a class="navbar-brand" id="logo" href="#">
                        <img alt="Brand" src="../views/layouts/img/logo.png">
                    </a>
                </div>

                <a class="navbar-brand" href="#" style="margin-left:0px;">EmailOS</a>

            </div>

        </div>






        <div id="navbar" class="navbar-collapse collapse ">
            <ul class="nav navbar-nav navbar-right">
                <li><a herf="#"><?php  $session=Yii::$app->session; echo $session['user']['username'];?></a></li>
                <li><a id="nav-close" href="<?=\yii\helpers\Url::toRoute(['site/cancel']);?>">注销</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="rs-dialog" id="myModal1">
    <?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    $session=Yii::$app->session;
    //    use app\models\VerifyMessage;
    //    $model=new VerifyMessage();
    ?>

    <form  method="post" action="<?=\yii\helpers\Url::toRoute(['verifier/detail','id'=>null,'check_status'=>null,'dealername'=>null,'foreignid'=>$email['foreignid'],'email_id'=>$email['id']]);?>">
        <?php $form = ActiveForm::begin(); ?>
        <div class="rs-dialog-box">
            <a class="close" href="#">&times;</a>
            <div class="rs-dialog-header">
                <h3><strong>确认通知</strong></h3>
            </div>
            <div class="rs-dialog-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1" style="font-family:'微软雅黑';font-size:18px;">
                        <p>本封邮件通过了您的审核，你可以在下面留下您的评语！</p>
                        <?= $form->field($model, 'message')->textArea(['name'=>'message', 'class' => 'form-control'])->label("内容:") ?>
                        <?= $form->field($model, 'handle_status')->hiddenInput(['name'=>'check_status','value'=>1])->label("") ?>
                    </div>
                </div>
            </div>
            <div class="rs-dialog-footer">
                <!--                <input type="submit" class="btn btn-success" value="确定" style="float:right">-->
                <input type="submit" value="确定" class="btn btn-success" style="float:right" />
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </form>

</div>
<div class="rs-dialog" id="myModal">
    <form  method="post" action="<?=\yii\helpers\Url::toRoute(['verifier/detail','id'=>null,'check_status'=>null,'dealername'=>null,'foreignid'=>$email['foreignid'],'email_id'=>0]);?>">
    <?php $form = ActiveForm::begin(); ?>
        <div class="rs-dialog-box">
            <a class="close" href="#">&times;</a>
            <div class="rs-dialog-header">
                <h3><strong>确认通知</strong></h3>
            </div>
            <div class="rs-dialog-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1" style="font-family:'微软雅黑';font-size:18px;">
                        <p>本封邮件未通过您的审核，请批评指示!</p>
                        <?= $form->field($model, 'message')->textArea(['name'=>'message', 'class' => 'form-control'])->label("内容:") ?>
                        <?= $form->field($model, 'handle_status')->hiddenInput(['name'=>'check_status','value'=>2])->label("") ?>
                    </div>
                </div>
            </div>
            <div class="rs-dialog-footer">
                <input type="submit" value="确定" class="btn btn-success" style="float:right" />


            </div>
        </div>
    <?php ActiveForm::end(); ?>
    </form>
</div>
<div class="container-fluid">
    <div class="row">
        <!--nav sidebar-->
        <div class="col-sm-3 col-md-2 sidebar">

            <ul class="nav nav-sidebar ">




                <li class="active">
                    <a href="<?=\yii\helpers\Url::toRoute(['site/login'])?>">
                        <i class="glyphicon glyphicon-envelope"></i>
                        <span class="title">&nbsp;&nbsp;收件箱</span>
                    </a>
                </li>

                <li>
                    <a href="<?=\yii\helpers\Url::toRoute(['site/checkinfo','check_status'=>0])?>">
                        <i class="glyphicon glyphicon-time"></i>
                        <span class="title">&nbsp;&nbsp;待审核</span>
                        <span class="sr-only">(current)</span>
                        <span class="badge pull-right"><?=$session['count']?></span>

                    </a>
                </li>
                <li>
                    <a href="<?=\yii\helpers\Url::toRoute(['site/checkinfo','check_status'=>1])?>">
                        <i class="glyphicon glyphicon-ok-circle"></i>
                        <span class="title">&nbsp;&nbsp;已通过</span>

                    </a>
                </li>

                <li>
                    <a href="<?=\yii\helpers\Url::toRoute(['site/checkinfo','check_status'=>2])?>">
                        <i class="glyphicon glyphicon-ok-circle"></i>
                        <span class="title">&nbsp;&nbsp;未通过</span>

                    </a>
                </li>



            </ul>
        </div>
        <!-- table-->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" >
<?php //$this->beginContent('@app/views/layouts/verifier.php');?>
        <!--panel-->
        <div class="panel panel-default" style="box-shadow: 2px 2px 2px rgba(0,0,0,.05);border: 1px solid #e5e5e5;">
            <div class="panel-heading">
                <h3 class="panel-title" style="font-size:20px;font-weight:bold;">
                    <!-- <span class="label label-default">主题</span>-->
                    邮件详情
                </h3>
            </div>
            <div class="panel-body" style="padding-left: 0;padding-right: 0;padding-top: 0;min-height: 330px;">
              <div id="mailmsgbk">
                <div id="mailmsg">
                    <h3 class="mailtt">

                        <?=$email['subject']?>
                        <?php
                        if($email['check_status']==0){
                        echo "<div class='btn-group pull-right'>
                            <button type='button' rel='rs-dialog' data-target='myModal1' class='btn btn-primary btn-lg confirmbut'>通过</button>
                            <button type='button' rel='rs-dialog' data-target='myModal'class='btn btn-danger btn-lg confirmbut'>否决</button>
                        </div>";}else {
                           echo "<div class='btn-group pull-right'>
                            <button type='button' class='btn btn-success btn-lg confirmbut'>已审核</button>
                        </div>";}

                        ?>


                    </br>
                </h3>

                <div><span class="mailmst">发件人:</span> <?=$email['dealername']?></div>
                <div><span class="mailmst">收件人:</span><?=$email['receiver']?></div>
                <div><span class="mailmst">时　间:</span> <?=$email['send_time']?></div>
                <div><span class="mailmst">附　件:</span> 
                	<?php
                		echo $email['id'];
                    	if($email['attachment']!=NULL){
            			$fujian=explode(';', $email['attachment']);
            			for($i=0;$i<count($fujian)-1;$i++) {
            				echo basename($fujian[$i])."  ";

            				//print_r($email['attachment']);
            			}
            		}
            		
                    ?>
                </div>


            </div>

        </div>

        <!--<div><label class="label-primary">正文：</label></div>-->
        <div id="mailtext">
            <p><?=$email['text']?></p>

        </div>
    </div>

    <div class="panel-footer">
        <div><h4><span class="label label-default">附件信息：</span></h4></div>
        <div class="row">
            		
            		<?php 
            			
            			 	function type($file){

            				if(strstr($file,'.doc')!=NULL){
            					return 1;
            				}
            				if(strstr($file,'.xls')!=NULL){
            					return 2;
            				}
            				if(strstr($file,'.pdf')!=NULL){
            					return 3;
            				}
            				if(strstr($file,'.txt')!=NULL){
            					return 4;
            				}
            				if(strstr($file,'.zip')!=NULL||strstr($file,'.rar')!=NULL){
            					return 5;
            				}
            				if(strstr($file,'.png')!=NULL||strstr($file,'.jpg')!=NULL){
            					return 6;
            				}

            				return 0;
  
            			}
            			


            			$files=explode(';', $email['attachment']);
            			$file_type=array();

            			for($i=0;$i<count($files)-1;$i++) {
            				$file_type[]=type($files[$i]);
            			}
            			
            			//print_r(count($files));
            			
            		?>
                    <input id="filecount" class="hidden" value="<?= count($files)-1;?>" />
                    <input id="filetype" class="hidden" value="<?php
                    	for($i=0;$i<count($files)-1;$i++){
                    		echo $file_type[$i].';';
                    	}
                    ?>" />
                    <input id="filelinkfield" class="hidden" value="<?php
                    	echo $email['attachment'];
                    ?>"/>
                   
                   

                     <input id="filenamefield" class="hidden" value="<?php 
                    	for($i=0;$i<count($files)-1;$i++){
                    		echo basename($files[$i]).';';
                    	}
                    ?>" />

                     <?php 
                    	for($i=0;$i<count($files)-1;$i++){
                    ?>

                    <div class="fileico col-md-2">

                       <a href="<?=\yii\helpers\Url::toRoute(['mail/download','file'=>$files[$i]]);?>" class="filelink"><img class="fileimg" src="" ></a>
                        <a href="<?=\yii\helpers\Url::toRoute(['mail/download','file'=>$files[$i]]);?>" class="filename">doc.png</a>
                    </div>
                    <?php
                    	}
                    
                    ?>
        	


        
    </div>








</div>
<?php //$this->endContent();?>
        </div>
    </div>
</div>


</body>
</html>
