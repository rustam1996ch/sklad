<?php

use yii\helpers\Html;
use backend\assets\frest\LoginAsset;
use  yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

LoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loaded">
<!-- BEGIN: Head-->
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Muhammad Samadov">
    <?= Html::csrfMetaTags() ?>

    <link rel="apple-touch-icon" href="<?= bu('themes/frest/app-assets/images/ico/favicon.ico') ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?= bu('themes/frest/app-assets/images/ico/favicon.ico') ?>">

    <title><?= Html::encode($this->title) ?></title>
    
</head>


<body class="vertical-layout vertical-menu-modern 1-column  navbar-sticky footer-static bg-full-screen-image  blank-page blank-page  pace-done"
    data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

<?php $this->beginBody() ?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
<!-- <section class="row" > -->
        <div class="content-body">
           <!-- not authorized start -->
<!-- <section class="row flexbox-container"> -->
  <!-- <div class="col-xl-7 col-md-8 col-12"> -->
    <div class="card bg-transparent shadow-none">
      <div class="card-content">
        <div class="card-body text-center">
          <img src="<?= bu('themes/frest/app-assets/images/pages/not-authorized.png')?>" class="img-fluid" alt="not authorized" width="400">
          <h1 class="my-2 error-title">Вы не авторизованы!</h1>
          <p>
              У вас нет разрешения на просмотр этого каталога или страницы с помощью
               учетные данные, которые вы предоставили.
          </p><div>
          <a href="<?=Url::to(['site/index'])?>" class="btn btn-primary round glow mt-2">НАЗАД К ГЛАВНЫЙ </a></div>
        </div>
      </div>
    </div>
  <!-- </div> -->
<!-- </section> -->
<!-- not authorized end -->
  </div>




    </div>

</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

