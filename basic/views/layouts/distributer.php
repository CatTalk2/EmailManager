<html>
<head>
    <title>mailonline</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <link rel="icon" href="../views/layouts/img/favicon.ico">
    <script src="../views/layouts/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../views/layouts/js/jquery.js"></script>
    <script type="text/javascript" src="../views/layouts/js/chuli.js"></script>
    <link rel="stylesheet" type="text/css" href="../views/layouts/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../views/layouts/css/index.css">
    <link rel="stylesheet" type="text/css" href="../views/layouts/css/style.css">
    <link href="../views/layouts/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    
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
                    <a class="navbar-brand" id="logo" href="<?=\yii\helpers\Url::toRoute(['site/undistribute','handle_status'=>0]);?>">
                        <img alt="Brand" src="../views/layouts/img/logo.png">
                    </a>
                </div>
               
                <a class="navbar-brand" href="#" style="margin-left:0px;">EmailOS</a>
                
            </div>
        
        </div>

        <div id="navbar" class="navbar-collapse collapse ">
            <ul class="nav navbar-nav navbar-right">
                <li><a herf="#"><?php  $session=Yii::$app->session; echo $session['user']['name']?></a></li>
                <li><a id="nav-close" href="<?=\yii\helpers\Url::toRoute(['site/cancel']);?>">注销</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <!--nav sidebar-->
        <div  class="col-sm-3 col-md-2 sidebar">
       
            <ul class="nav nav-sidebar ">
                <li class="active">
                    <a href="<?=\yii\helpers\Url::toRoute(['site/login']);?>">
                        <i class="glyphicon glyphicon-envelope"></i>
                        <span class="title">&nbsp;&nbsp;收件箱</span>
                        
                        
                    </a>
                </li>
                <li>
                    <a href="<?=\yii\helpers\Url::toRoute(['site/undistribute','handle_status'=>0]);?>">
                        <i class="glyphicon glyphicon-remove-circle"></i>
                        <span class="title">&nbsp;&nbsp;待分发</span>
                        <span class="sr-only">(current)</span>
                        <?php
                        	use app\models\Email;
                        	$count=Email::find()->where(['handle_status' => 0])->count();
                        	if($count>0){
                        		echo '<span class="badge pull-right">'.$count.'</span>';
                        	}
                        ?>
                    </a>
                </li>

                <li>
                    <a href="<?=\yii\helpers\Url::toRoute(['site/distributed','handle_status'=>1]);?>">
                        <i class="glyphicon glyphicon-ok-circle"></i>
                        <span class="title">&nbsp;&nbsp;已分发</span>
                    </a>
                </li>
                <li>
                    <a href="<?=\yii\helpers\Url::toRoute(['site/distributeremergentemail']);?>">
                        <i class="glyphicon glyphicon-time"></i>
                        <span class="title">&nbsp;&nbsp;紧急邮件</span>
                        <span class="sr-only">(current)</span>
                        
                        	<?php
                        	use app\models\Email_user_rs;
                        	$emergent_cont=0;
                        	$dealEmail=Email_user_rs::find()->asArray()->all();
        					foreach ($dealEmail as $demail) {
        						if($demail['dead_time']!=NULL&&$demail['handle_status']!=3){
        							$emergent_cont++;
        						}		
        					}
                        	
                        	if($emergent_cont>0){
                        		echo '<i class="pull-right glyphicon glyphicon-send" style="color:red"></i>';
                        	}
                        ?>
                    </a>
                </li>
                <li>
                    <a href="<?=\yii\helpers\Url::toRoute(['site/list','permission'=>1]);?>">
                        <i class="glyphicon glyphicon-user"></i>
                        <span class="title">&nbsp;&nbsp;通讯录</span>                        
                    </a>
                </li>
            </ul>
        </div>
        <!-- table-->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" >
            <?=$content?>
            <!--panel-->
        </div>
    </div>
</div>
<script type="text/javascript" src="../views/layouts/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script type="text/javascript" src="../views/layouts/js/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
    <script type="text/javascript">
        $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });
        $('.form_date').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('.form_time').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 1,
        minView: 0,
        maxView: 1,
        forceParse: 0
    });
</script>
</body>
</html>