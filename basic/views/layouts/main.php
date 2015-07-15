<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<link rel="icon" href="../views/layouts/img/favicon.ico">
<body>

<?php $this->beginBody() ?>
   
            <?= $content ?>
      

    

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
