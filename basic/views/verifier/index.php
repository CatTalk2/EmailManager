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
                <li><a herf="#"><?php  $session=Yii::$app->session; echo $session['user']['name'];?></a></li>
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
                        <span class="badge pull-right"><?php  $session=Yii::$app->session; 
                        	if($session['count']>0)
                        		echo $session['count']?></span>

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
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="glyphicon glyphicon-th-list"></i>
                        邮件列表
                    </h3>
                </div>

                <div class="panel-body">
                    <div class="page-header" id="table-divider">
                        <!--checkbox-->
                       
                    </div>

                    <!--information table context-->
                    <div class="form bidform">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr >
                                
                                <th>发件人</th>
                                <th>邮件主题</th>
                                <th>收件人</th>
                                <th>状态</th>

                                <?php
                                if(isset($info)){
                                    if($info!=0)
                                    echo "<th>审核意见</th>";
                                }
                                ?>
                                <th>发送时间</th>

                                
                            </tr>
                            </thead>
                            <tbody>
                          <?php
                          foreach($checkemails as $email){
                              ?>
                              <tr>

                                  <td><?=$email['dealername']?></td>
                                  <td><a  href="<?=\yii\helpers\Url::toRoute(['verifier/detail','id'=>$email['id'],'check_status'=>$email['check_status'],'dealername'=>$email['dealername'],'foreignid'=>$email['foreignid'],'email_id'=>0]);?>"><?=$email['subject']?></a></td>
                                  <td><?=$email['receiver']?></td>
                                  <td>
                                      <?php
                                      if($email['check_status']==0)
                                      echo "<button type='button' class='btn btn-warning btn-xs'>
                                               &nbsp;&nbsp;未审核&nbsp;&nbsp;
                                               </button>";
                                      else if($email['check_status']==1)
                                      echo "<button type='button' class='btn btn-success btn-xs'>
                                               &nbsp;&nbsp;通&nbsp;&nbsp;&nbsp;过&nbsp;&nbsp;
                                               </button>";
                                      else if($email['check_status']==2)
                                          echo "<button type='button' class='btn btn-danger btn-xs'>
                                               &nbsp;&nbsp;未通过&nbsp;&nbsp;
                                               </button>";

                                      ?>


                                  </td>

                                  <?php
                                  if(isset($info)){
                                      if($info!=0)
                                          echo "<td>".$email['check_advise']."</td>";
                                  }

                                  ?>

                                  <td><?=$email['send_time']?></td>

                              </tr>



                              <?php } ?>

                            </tbody>
                        </table>
                        <?php
                        use yii\helpers\Html;
                        use yii\widgets\LinkPager;
                        ?>
                        <!--<nav>
                            <ul class="pagination pull-right">-->
                        <div style="text-align: center">
                            <div  style="display:inline-block;vertical-align:middle;margin:auto">共 <?=$check['count']?> 条</div>

                            <div style="display:inline-block;vertical-align:middle;margin:auto">
                                <?=LinkPager::widget(['pagination'=>$pagination]) ?>

                            </div>

                        </div>




                    </div>
                </div>
            </div>


<?php //$this->endContent();?>
        </div>
    </div>
</div>

</body>
</html>