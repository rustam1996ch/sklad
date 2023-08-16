<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\widgets\Breadcrumbs; ?>
<!-- CONTENT -->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">

        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">

                        <h5 class="content-header-title float-left pr-1 mb-0"><?=(empty($this->params['breadcrumbs'])) ? '' : end($this->params['breadcrumbs'])?></h5>
                        <div class="breadcrumb-wrapper col-12">
                            <?php
                            echo Breadcrumbs::widget([
                                'options' => ['class' => 'breadcrumb p-0 mb-0'],
                                'homeLink' => [
                                    'label' => '<i class="bx bx-home-alt"></i></a></li>',
                                    'url' => Yii::$app->homeUrl,
                                    'encode' => false,
                                ],
                                'itemTemplate' => "<li class='breadcrumb-item'><a>{link}</a></li>\n", // template for all links
                                'activeItemTemplate' => "<li class='active'><a>{link}</a></li>\n",
                                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            <?= $content ?>
        </div>

    </div>

</div>
<!--/ CONTENT -->
