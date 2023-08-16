<?php

use yii\helpers\Html;

?>

<!-- NAVBAR -->
<nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto"><a
                                    class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                        class="ficon bx bx-menu"></i></a></li>
                    </ul>
                    <ul class="nav navbar-nav bookmark-icons">
<!--                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link" href="#" data-toggle="tooltip" data-placement="top" title="Email"><i
                                        class="ficon bx bx-envelope"></i></a>
                        </li>
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link" href="#" data-toggle="tooltip" data-placement="top" title="Chat"><i
                                        class="ficon bx bx-chat"></i></a></li>
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link" href="#" data-toggle="tooltip" data-placement="top" title="Todo"><i
                                        class="ficon bx bx-check-circle"></i></a>
                        </li>
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link" href="#" data-toggle="tooltip" data-placement="top" title="Calendar"><i
                                        class="ficon bx bx-calendar-alt"></i></a>
                        </li>-->
                        <!--                         <li class="nav-item d-none d-lg-block">
                                                    <a class="nav-link" href="#" data-toggle="tooltip" data-placement="top" title="Calendar">
                                                    <div class="radio">
                                                        <input type="radio" name="layoutOptions" value="false" id="radio-dark" class="layout-name"
                                                          data-layout="dark-layout">
                                                        <label for="radio-dark">Dark</label>
                                                    </div>
                                                  </a>
                                                </li> -->
                        <li class="nav-item nav-toggle">
                            <a class="nav-link" href="#" data-toggle="tooltip" data-placement="top">
                                <div class="custom-control custom-switch custom-switch-secondary mr-2 mb-1">
                                    <input type="checkbox" class="custom-control-input layout-name" name="layoutOptions"
                                           value="true" id="customSwitch15">
                                    <label class="custom-control-label" for="customSwitch15">
                                        <span class="switch-icon-left"><i class="bx bx-bulb"></i></span>
                                        <span class="switch-icon-right"><i class="bx bx-bulb"></i></span>
                                    </label>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <ul class="nav navbar-nav float-right">
                    <!--                    <li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link"-->
                    <!--                                                                       id="dropdown-flag" href="#"-->
                    <!--                                                                       data-toggle="dropdown" aria-haspopup="true"-->
                    <!--                                                                       aria-expanded="false"><i-->
                    <!--                                    class="flag-icon flag-icon-uz"></i><span-->
                    <!--                                    class="selected-language">Uzbek</span></a>-->
                    <!--                        <div class="dropdown-menu" aria-labelledby="dropdown-flag">-->
                    <!--                            <a class="dropdown-item" href="#" data-language="en"><i class="flag-icon flag-icon-uz mr-50"></i> Uzbek</a>-->
                    <!--                            <a class="dropdown-item" href="#" data-language="fr"><i class="flag-icon flag-icon-us mr-50"></i> English</a>-->
                    <!--                            <a class="dropdown-item" href="#" data-language="de"><i class="flag-icon flag-icon-ru mr-50"></i> Russian</a>-->
                    <!--                        </div>-->
                    <!--                    </li>-->
                    <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i
                                    class="ficon bx bx-fullscreen"></i></a></li>


                    <li class="dropdown dropdown-notification nav-item">
                        <?php echo \app\widgets\Notification::widget() ?>
                    </li>

                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link"
                                                                   href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none"><span
                                        class="user-name"><?= app()->user->identity->username ?></span>
                                <!--                                <span class="user-status text-muted">Available</span>-->
                            </div>
                            <span><img class="round"
                                       src="<?= bu('themes/frest/app-assets/images/portrait/small/avatar-i-7.png') ?>"
                                       alt="avatar" height="40" width="40"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right pb-0">
                            <!--                            <a class="dropdown-item" href="#"><i class="bx bx-user mr-50"></i> Edit Profile</a>-->
                            <!--                            <a class="dropdown-item" href="#"><i class="bx bx-envelope mr-50"></i> My Inbox</a>-->
                            <!--                            <a class="dropdown-item" href="#"><i class="bx bx-check-square mr-50"></i> Task</a>-->
                            <!--                            <a class="dropdown-item" href="#"><i class="bx bx-message mr-50"></i> Chats</a>-->
                            <div class="dropdown-divider mb-0"></div>
                            <!-- logout -->
                            <?= Html::a('<i class="bx bx-power-off mr-50"></i> Выход', ['/site/logout'], ['class' => 'dropdown-item', 'data' => ['method' => 'post']]) ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<?php
$this->registerJs(<<<JS
        $("#customSwitch15").click(function(e){
            let menu_dark = 1;
            if (menu_dark){
                $.ajax({
                    url:window.baseUrl+'site/dark',
                    type: 'POST',
                    data:{
                      menu_dark: menu_dark
                    },
                    success: function(response) {
                        if(response == 1){
                        $( "body" ).addClass( "dark-layout" );     
                        }else{
                            
                        }

                    }
                })    
            }else{
                
            }
            
        });

JS
);
?>
