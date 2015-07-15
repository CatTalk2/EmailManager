<!DOCTYPE html>
<html>
<head>
    <title>mailonline</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <script src="../views/layouts/js/jquery.js"></script>
    <script src="../views/layouts/js/bootstrap.min.js"></script>
    <script src="../views/layouts/js/settingmail.js"></script>
    <link rel="icon" href="../views/layouts/img/favicon.ico">
    <link rel="stylesheet" type="text/css" href="../views/layouts/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../views/layouts/css/index.css">
    <link rel="stylesheet" type="text/css" href="../views/layouts/css/admin.css">
    
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top" id="nav">
    <div class="container">
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

                <a class="navbar-brand" href="?r=admin" style="margin-left:0px;">EmailOS</a>

            </div>

        </div>


        <div id="navbar" class="navbar-collapse collapse ">
            <ul class="nav navbar-nav navbar-left">
                <li><a id="nav-close" href="?r=admin">用户管理</a></li>
                <li><a href="?r=admin/setmail">邮箱设置</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="javascript:void(0)"><?php if(!isset($_SESSION)) session_start(); echo$_SESSION['user']['name'];?></a></li>
                <li><a id="nav-close" href="?r=site/cancel">注销</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
<?=$content?>
