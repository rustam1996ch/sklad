<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>


<section id="auth-login" class="row flexbox-container">
    <div class="col-xl-8 col-11">
        <div class="card bg-authentication mb-0">
            <div class="row m-0">
                <!-- left section-login -->
                <div class="col-md-6 col-12 px-0">
                    <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                        <div class="card-header pb-1">
                            <div class="card-title">
                                <h4 class="text-center mb-2">Добро пожаловать</h4>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- <div class="d-flex flex-md-row flex-column justify-content-around">
                                    <a href="#"
                                        class="btn btn-social btn-google btn-block font-small-3 mr-md-1 mb-md-0 mb-1">
                                        <i class="bx bxl-google font-medium-3"></i><span
                                            class="pl-50 d-block text-center">Google</span></a>
                                    <a href="#" class="btn btn-social btn-block mt-0 btn-facebook font-small-3">
                                        <i class="bx bxl-facebook-square font-medium-3"></i><span
                                            class="pl-50 d-block text-center">Facebook</span></a>
                                </div> -->
                                <div class="divider">

                                </div>
                                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                                    <div class="form-group mb-50">
                                        <!-- <label class="text-bold-600" for="exampleInputEmail1">Email address</label> -->
                                       <!--  <input type="email" class="form-control" id="exampleInputEmail1"
                                            placeholder="Email address"> -->
                                        <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label("Логин",['class'=>'text-bold-600']) ?>
                                        </div>
                                    <div class="form-group">
                                        <!-- <label class="text-bold-600" for="exampleInputPassword1">Password</label> -->
                                        <!-- <input type="password" class="form-control" id="exampleInputPassword1"
                                            placeholder="Password"> -->
                                            <?= $form->field($model, 'password')->passwordInput()->label("Паролъ",['class'=>'text-bold-600']) ?>

                                    </div>
                                     <div
                                        class="form-group d-flex flex-md-row flex-column justify-content-between align-items-center">
                                        <div class="text-left">

                                              <?= $form->field($model, 'rememberMe', [
                                                  'template' => '<div class="checkbox checkbox-sm">{input}{label}</div>',
                                                  'labelOptions' => [
                                                    'label'=>'Запомни меня',
                                                    'class' => 'checkboxsmall'
                                                ]
                                              ])->checkbox([], false) ?>

                                        </div>
                                    </div>


                                            <div class="form-group">
                                                <?= Html::submitButton('Вход <i
                                            id="icon-arrow" class="bx bx-right-arrow-alt float-right"></i>', ['class' => 'btn btn-primary glow w-100 position-relative', 'name' => 'login-button']) ?>
                                            </div>


                                 <?php ActiveForm::end(); ?>
                                <hr>
                                <div class="text-center"><!-- <small class="mr-25">Don't have an account?</small><a
                                        href="auth-register.html"><small>Sign up</small></a> --></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- right section image -->
                <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                    <div class="card-content">
                        <img class="img-fluid" src="<?= bu('themes/frest/app-assets/images/pages/login.png') ?>" alt="branding logo">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


