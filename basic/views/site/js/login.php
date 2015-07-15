<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../views/site/favicon.ico">
    <title>企业邮件管理系统登录界面</title>
    <!-- Bootstrap core CSS -->
    <link href="../views/site/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../views/site/css/signin.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" id="logo" href="#">
                        <img alt="Brand" src="../views/site/logo.png">
                    </a>
                </div>
                <a class="navbar-brand" href="#">EmailOS</a>
            </div>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-5 col-md-offset-1 col-lg-5 col-lg-offset-1">
           <img src="../views/site/email.png">
        </div>
        <div class="col-md-4 col-md-offset-1 col-lg-4 col-lg-offset-1">
			<?php 
				use yii\helpers\Html;
            	use yii\widgets\ActiveForm;
            ?>
            <div class="form-signin">

            	<h3 class="form-signin-heading">
                	<i class="glyphicon glyphicon-user"></i>&nbsp;用户登录
            	</h3>
				<?php $form = ActiveForm::begin(); ?>
               		<?= $form->field($model, 'name')->label('用户名') ?>
               		<?= $form->field($model, 'password') ->label('密码')->passwordInput()?>
            		<div class="form-group">
                		<?= Html::submitButton('登&nbsp;录', ['class' => 'btn btn-primary']) ?>
            		</div>
            	<?php ActiveForm::end(); ?>
            	<span style="color: red">
                	<?php if(!empty($message)) echo $message;?>
            	</span>
            </div>
        </div>
    </div>

</div>


<footer class="footer">
    <div class="container">
        <p class="text-muted" align="center">企业邮件管理系统</br></p>
    </div>
</footer>


<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
