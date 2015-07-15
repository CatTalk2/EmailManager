<html>
<head>
    <title>mailonline</title>
    <meta http-equiv="content-type" content="text/html" charset="utf-8" />
    <link rel="icon" href="../views/layouts/img/favicon.ico">
    <script src="../views/layouts/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../views/layouts/js/jquery.js"></script>
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
                        <i class="glyphicon glyphicon-th-list"></i>
                        <span class="title">&nbsp;&nbsp;邮件列表</span>
                        <span class="sr-only">(current)</span>
                        
                        	<?php
                        	use app\models\Email_user_rs;
                        	$count=Email_user_rs::find()->where(['handle_status' => 0,'user_id'=>$session['user_id']])->count();
                        	if($count>0){
                        		echo '<span class="badge pull-right">'.$count.'</span>';
                        	}
                        ?>
                        
                    </a>
                </li>
                <li>
                    <a href="<?=\yii\helpers\Url::toRoute(['mail/index','subject'=>'','receiver'=>'']);?>">
                        <i class="glyphicon glyphicon-edit"></i>
                        <span class="title">&nbsp;&nbsp;写邮件</span>
                    </a>
                </li>


                <li>
                    <a href="<?=\yii\helpers\Url::toRoute(['site/sent','user_id'=>$session['user']['id']]);?>">
                        <i class="glyphicon glyphicon-ok-circle"></i>
                        <span class="title">&nbsp;&nbsp;已发送</span>
                    </a>
                </li>
                <li>
                    <a href="<?=\yii\helpers\Url::toRoute(['site/emergentemail','user_id'=>$session['user']['id']]);?>">
                        <i class="glyphicon glyphicon-time"></i>
                        <span class="title">&nbsp;&nbsp;紧急邮件提醒</span>
                        <span class="sr-only">(current)</span>
                        
                        	<?php
                        	$emergent_cont=0;
                        	$dealEmail=Email_user_rs::find()->where(['user_id'=>$session['user']['id']])->asArray()->all();
        					foreach ($dealEmail as $demail) {
        						if($demail['dead_time']!=NULL&&$demail['handle_status']!=3){
        							$emergent_cont++;
        						}		
        					}
                        	
                        	if($emergent_cont>0){
                        		echo '<i class="glyphicon glyphicon-send" style="margin-left:20px;color:red"></i>';
                        	}
                        ?>
                    </a>
                </li>

                <li>
                    <a href="#" id="pull">
                        <i class="glyphicon glyphicon-eye-open"></i>
                        <span class="title">&nbsp;&nbsp;审核邮件</span>
                        <span class="sr-only">(current)</span>
                         <i  id="pullico" class="glyphicon glyphicon-chevron-down pull-right" style="margin-left:20px"></i>
                        <?php
                        use app\models\Check;
                        $wait_count=Check::find()->where(['check_status' => 0,'user_id'=>$session['user_id']])->count();
                        $fail_count=Check::find()->where(['check_status' => 2,'user_id'=>$session['user_id']])->count();
                        if(($wait_count+$fail_count)>0){
                        	echo '<i class="pull-right glyphicon glyphicon-flash" style="color:red"></i>';
                            //echo '<span class="badge pull-right">'.$count.'</span>';
                        }
                        ?>
                        

                    </a>
                     <ul class="submenu">

                        <li>
                            <a href="<?=\yii\helpers\Url::toRoute(['site/checkself','user_id'=>$session['user']['id'],'check_status'=>0]);?>">
                                <span class="title">&nbsp;&nbsp;待审核</span>
                                <?php
                                	if($wait_count>0){
                        			//echo '<i class="pull-right glyphicon glyphicon-flash" style="color:red"></i>';
                            			echo '<span class="badge pull-right" style="">'.$wait_count.'</span>';
                        			}
                                ?>
                            </a>
                        </li>
                        <li >
                            <a href="<?=\yii\helpers\Url::toRoute(['site/checkself','user_id'=>$session['user']['id'],'check_status'=>1]);?>">
                                <span class="title">&nbsp;&nbsp;已通过</span>
                            </a>
                        </li>
                         <li>
                             <a href="<?=\yii\helpers\Url::toRoute(['site/checkself','user_id'=>$session['user']['id'],'check_status'=>2]);?>">
                                 <span class="title">&nbsp;&nbsp;未通过</span>
                                 <?php
                                	if($fail_count>0){
                        			//echo '<i class="pull-right glyphicon glyphicon-flash" style="color:red"></i>';
                            			echo '<span class="badge pull-right" style="background-color:red">'.$fail_count.'</span>';
                        			}
                                ?>
                             </a>
                         </li>

                    </ul>

                </li>

                </li>
                <li>
                    <a href="<?=\yii\helpers\Url::toRoute(['site/list','permission'=>3]);?>">
                        <i class="glyphicon glyphicon-user"></i>
                        <span class="title">&nbsp;&nbsp;通讯录</span>


                    </a>
                </li>

            </ul>
        </div>

        <!-- table-->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" >

            <?=$content?>

        </div>
    </div>
</div>

</body>
</html>