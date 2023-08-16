<?php

use yii\helpers\Html;
use backend\assets\frest\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
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

    <script type="text/javascript">
        window.baseUrl = '<?= Yii::$app->homeUrl ?>';
    </script>

    <?php $this->head() ?>
</head>
<?php
// if (isset($_COOKIE['menu_left'])) {
    $session = Yii::$app->session;
    $pageSession = $session->get('menu_left');
    $menuSession = $session->get('menu_dark');
    $LightSession = $session->get('menu_light');

    // die();
// } else {
    // $menuLocked = 0;
// }
?>
<body class="vertical-layout vertical-menu-modern 2-columns navbar-sticky footer-static <?=($LightSession==1) ?'pace-done': ''?> <?=($menuSession==1) ?'dark-layout' : 'pace-done' ?> <?= ($pageSession==1) ?'menu-expanded' : 'menu-collapsed'?>"
    data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

<?php $this->beginBody() ?>

<?php
require_once 'navbar.php';
require_once 'menu.php';
require_once 'content.php';
require_once 'footer.php';
?>

<script type="text/javascript">
    function printdiv(printpage) {
        var WindowObject = window.open("", "printWindow", "width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes", '_blank');
        WindowObject.document.writeln(printpage);
        WindowObject.document.close();
        WindowObject.focus();
        WindowObject.print();
        WindowObject.close();

        return false;
    }
</script>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
