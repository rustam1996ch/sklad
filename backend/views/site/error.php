<?php

use backend\assets\frest\LoginAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use Yii;


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
                <div class="card bg-transparent shadow-none">
                    <div class="card-content">
                        <div class="card-body text-center">

                            <?php if($exception->statusCode == '404') :?>

                                <h1 class='error-title'>Страница не найдена :(</h1>
                                <p class='pb-3'>
                                мы не смогли найти страницу, которую вы ищете</p>
                                <img class='img-fluid' src="<?= bu('themes/frest/app-assets/images/pages/404.png')?>" alt='404 error'>
                                <div>
                                    <a href="<?php echo Url::to(['site/index'])?>" class='btn btn-primary round glow mt-3'>НАЗАД К ГЛАВНЫЙ </a></div>

                                    <?php elseif($exception->statusCode == '403') :?>
                                    <img src="<?= bu('themes/frest/app-assets/images/pages/not-authorized.png')?>" class="img-fluid" alt="not authorized" width="400">
                                    <h1 class="my-2 error-title">Вы не авторизованы!</h1>
                                    <p>
                                      У вас нет разрешения на просмотр этого каталога или страницы с помощью
                                                     учетные данные, которые вы предоставили.
                                  </p><div>
                                      <a href="<?=Url::to(['site/index'])?>" class="btn btn-primary round glow mt-2">НАЗАД К ГЛАВНЫЙ </a></div>

                                      <?php else :?>
                                      <img src="<?= bu('themes/frest/app-assets/images/pages/500.png')?>" class="img-fluid my-3" alt="branding logo">
          <h1 class="error-title mt-1">Внутренняя Ошибка Сервера!</h1>
          <p class="p-2">
            Перезапустите браузер после очистки кэша и удаления файлов cookie. <br> Проблемы, вызванные неправильным файлом
             и каталог разрешений.
          </p><div>
          <a href="<?=Url::to(['site/index'])?>" class="btn btn-primary round glow">НАЗАД К ГЛАВНЫЙ </a></div>

                                  <?php endif ?>

                              </div>
                          </div>
                      </div>

                  </div>

              </div>

          </div>


          <?php $this->endBody() ?>
      </body>
      </html>
      <?php $this->endPage() ?>
