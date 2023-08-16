<?php

/* @var $this yii\web\View */

use yii\web\View;
use yii\helpers\Url;

$this->title = 'Master Pack';
?>

<?php if(app()->user->identity->role_id == 1 || app()->user->identity->role_id == 2 || app()->user->identity->role_id == 5){ ?>
<div class="site-index">
    <div class="">

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <a href="<?= Url::to(['packet/index']) ?>">
                            <div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2">
                                <div class="avatar-content">
                                    <i class="bx bx-cube text-primary font-medium-2"></i>
                                </div>
                            </div>
                            </a>
                            <div class="total-amount">
                                <h5 class="mb-0">Поддон - <?= $bufferCount ?></h5>
                                <!-- <small class="text-muted"> Буфер</small> -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <a href="<?= Url::to(['receipt/index']) ?>">
                            <div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2">
                                <div class="avatar-content">
                                    <i class="bx bx-box text-primary font-medium-2"></i>
                                </div>
                            </div>
                            </a>
                            <div class="total-amount">
                                <h5 class="mb-0">Склад - 1050</h5>
                                <!-- <small class="text-muted"> Поддон</small> -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2">
                                <div class="avatar-content">
                                    <i class="bx bx-dollar text-primary font-medium-2"></i>
                                </div>
                            </div>
                            <div class="total-amount">
                                <h5 class="mb-0">Прыб. янв - <?= '15 800 000' ?></h5>
                                <!-- <small class="text-muted"> Клиенты</small> -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <a href="<?= Url::to(['client/index']) ?>">
                            <div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2">
                                <div class="avatar-content">
                                    <i class="bx bx-user text-primary font-medium-2"></i>
                                </div>
                            </div>
                            </a>
                            <div class="total-amount">
                                <h5 class="mb-0">Клиенты - <?= \sklad\models\Client::find()->count() ?></h5>
                                <!-- <small class="text-muted"> Клиенты</small> -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <a href="<?= Url::to(['product/index']) ?>">
                            <div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2">
                                <div class="avatar-content">
                                    <i class="bx bxl-product-hunt text-primary font-medium-2"></i>
                                </div>
                            </div>
                            </a>
                            <div class="total-amount">
                                <h5 class="mb-0">Продукты - <?= \sklad\models\Product::find()->count() ?></h5>
                                <!-- <small class="text-muted">  Продукт</small> -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2">
                                <div class="avatar-content">
                                    <i class="bx bx-dollar text-primary font-medium-2"></i>
                                </div>
                            </div>
                            <div class="total-amount">
                                <h5 class="mb-0">Прыб. дек - <?= '20 500 000' ?></h5>
                                <!-- <small class="text-muted"> Клиенты</small> -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>
                <!-- Dashboard Ecommerce Starts -->
    <section id="dashboard-ecommerce">
        <div class="row">
            <div class="col-xl-8 col-12 dashboard-order-summary">
                <div class="card">
                    <div class="row">
                        <!-- Order Summary Starts -->
                        <div class="col-md-8 col-12 order-summary border-right pr-md-0">
                            <div class="card mb-0">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title">Order Summary</h4>
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-sm btn-light-primary mr-1">Month</button>
                                        <button type="button" class="btn btn-sm btn-primary glow">Week</button>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body p-0">
                                        <div id="order-summary-chart">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Sales History Starts -->
                        <div class="col-md-4 col-12 pl-md-0">
                            <div class="card mb-0">
                                <div class="card-header pb-50">
                                    <h4 class="card-title">Sales History</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body py-1">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="sales-item-name">
                                                <p class="mb-0">Airpods</p>
                                                <small class="text-muted">30 min ago</small>
                                            </div>
                                            <div class="sales-item-amount">
                                                <h6 class="mb-0"><span class="text-success">+</span> $50</h6>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="sales-item-name">
                                                <p class="mb-0">iPhone</p>
                                                <small class="text-muted">2 hour ago</small>
                                            </div>
                                            <div class="sales-item-amount">
                                                <h6 class="mb-0"><span class="text-danger">-</span> $59</h6>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="sales-item-name">
                                                <p class="mb-0">Macbook</p>
                                                <small class="text-muted">1 day ago</small>
                                            </div>
                                            <div class="sales-item-amount">
                                                <h6 class="mb-0"><span class="text-success">+</span> $12</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer border-top pb-0">
                                        <h5>Total Sales</h5>
                                        <span class="text-primary text-bold-500">$82,950.96</span>
                                        <div class="progress progress-bar-primary progress-sm my-50">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="78" style="width:78%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Latest Update Starts -->
            <div class="col-xl-4 col-md-6 col-12 dashboard-latest-update">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center pb-50">
                        <h4 class="card-title">Latest Update</h4>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButtonSec" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                2019
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSec">
                                <a class="dropdown-item" href="#">2019</a>
                                <a class="dropdown-item" href="#">2018</a>
                                <a class="dropdown-item" href="#">2017</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body p-0 pb-1">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between">
                                    <div class="list-left d-flex">
                                        <div class="list-icon mr-1">
                                            <div class="avatar bg-rgba-primary m-0">
                                                <div class="avatar-content">
                                                    <i class="bx bxs-zap text-primary font-size-base"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-content">
                                            <span class="list-title">Total Products</span>
                                            <small class="text-muted d-block">1.2k New Products</small>
                                        </div>
                                    </div>
                                    <span>10.6k</span>
                                </li>
                                <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between">
                                    <div class="list-left d-flex">
                                        <div class="list-icon mr-1">
                                            <div class="avatar bg-rgba-info m-0">
                                                <div class="avatar-content">
                                                    <i class="bx bx-stats text-info font-size-base"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-content">
                                            <span class="list-title">Total Sales</span>
                                            <small class="text-muted d-block">39.4k New Sales</small>
                                        </div>
                                    </div>
                                    <span>26M</span>
                                </li>
                                <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between">
                                    <div class="list-left d-flex">
                                        <div class="list-icon mr-1">
                                            <div class="avatar bg-rgba-danger m-0">
                                                <div class="avatar-content">
                                                    <i class="bx bx-credit-card text-danger font-size-base"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-content">
                                            <span class="list-title">Total Revenue</span>
                                            <small class="text-muted d-block">43.5k New Revenue</small>
                                        </div>
                                    </div>
                                    <span>15.89M</span>
                                </li>
                                <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between">
                                    <div class="list-left d-flex">
                                        <div class="list-icon mr-1">
                                            <div class="avatar bg-rgba-success m-0">
                                                <div class="avatar-content">
                                                    <i class="bx bx-dollar text-success font-size-base"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-content">
                                            <span class="list-title">Total Cost</span>
                                            <small class="text-muted d-block">Total Expenses</small>
                                        </div>
                                    </div>
                                    <span>1.25B</span>
                                </li>
                                <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between">
                                    <div class="list-left d-flex">
                                        <div class="list-icon mr-1">
                                            <div class="avatar bg-rgba-primary m-0">
                                                <div class="avatar-content">
                                                    <i class="bx bx-user text-primary font-size-base"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-content">
                                            <span class="list-title">Total Users</span>
                                            <small class="text-muted d-block">New Users</small>
                                        </div>
                                    </div>
                                    <span>1.2k</span>
                                </li>
                                <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between">
                                    <div class="list-left d-flex">
                                        <div class="list-icon mr-1">
                                            <div class="avatar bg-rgba-danger m-0">
                                                <div class="avatar-content">
                                                    <i class="bx bx-edit-alt text-danger font-size-base"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-content">
                                            <span class="list-title">Total Visits</span>
                                            <small class="text-muted d-block">New Visits</small>
                                        </div>
                                    </div>
                                    <span>4.6k</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Dashboard Ecommerce ends -->

</div>
<?php }?>

<div class="text-center">
    <img src="<?= bu('logo.png') ?>">
</div>

</div>
