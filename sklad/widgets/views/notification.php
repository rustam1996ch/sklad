<?php

use sklad\models\Receipt;
use sklad\models\Sell;

$list = [];

if (user()->identity->role_id == 2) {
    $role = 'bugalter';


    $list = Sell::find()->where(['status' => 0])->all();

} elseif (user()->identity->role_id == 4) {
    $role = 'buffer';

    $list = Receipt::find()
        ->where(['status' => 0])
        ->andWhere(['move_who' => 1])
        ->all();

} elseif (user()->identity->role_id == 3) {
    $role = 'sklad';

    $list = Receipt::find()
        ->where(['status' => 0])
        ->andWhere(['move_who' => 0])
        ->all();

} elseif (user()->identity->role_id == 6) {
    $role = 'oxrana';


    $list = [];

}

$count_notif = count($list);
?>

<?php if ($count_notif > 0): ?>
    <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i
                class="ficon bx bx-bell bx-tada bx-flip-horizontal"></i>
        <span class="badge badge-pill badge-danger badge-up"><?= $count_notif ?></span>
    </a>
<?php endif; ?>

<ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
    <!--        <li class="dropdown-menu-header">-->
    <!--            <div class="dropdown-header px-1 py-75 d-flex justify-content-between"><span-->
    <!--                    class="notification-title">7 new Notification</span><span-->
    <!--                    class="text-bold-400 cursor-pointer">Mark all as read</span></div>-->
    <!--        </li>-->
    <li class="scrollable-container media-list">

        <?php foreach ($list as $item): ?>

            <?php if ($role == 'bugalter'): ?>

                <a class="d-flex justify-content-between"
                   href="<?= \yii\helpers\Url::to(['sell/not-confirmed', 'type' => 0, 'id' => $item->id]) ?>">
                    <div class="media d-flex align-items-center">
                        <div class="media-body">
                            <h6 class="media-heading">
                                <span class="text-bold-500"><?= $item->client->name ?> &mdash;  <?= $item->car_number ?></span>
                                &mdash; <?= $item->getRasxodAmount() ?> шт &mdash; <?= $item->getRasxodSumma() ?> сум
                            </h6>
                            <small class="notification-text"><?= app()->formatter->asDatetime($item->shipped_time) ?></small>
                        </div>
                    </div>
                </a>

            <?php elseif ($role == 'sklad'): ?>

                <a class="d-flex justify-content-between"
                   href="<?= \yii\helpers\Url::to(['receipt/not-confirmed', 'id' => $item->id]) ?>">
                    <div class="media d-flex align-items-center">
                        <div class="media-body">
                            <h6 class="media-heading">
                                <span class="text-bold-500">№ <?= $item->id ?> &mdash; <?= $item->product->vendor_code ?> &mdash;  <?= $item->amount ?>шт</span>
                                &mdash; <?= $item->packet->user->full_name ?>
                                &mdash; <?= app()->formatter->asDatetime($item->date) ?>
                            </h6>
                            <small class="notification-text"><?= $item->product->name ?></small>
                        </div>
                    </div>
                </a>

            <?php elseif ($role == 'buffer'): ?>

                <a class="d-flex justify-content-between"
                   href="<?= \yii\helpers\Url::to(['receipt/not-confirmed', 'id' => $item->id]) ?>">
                    <div class="media d-flex align-items-center">
                        <div class="media-body">
                            <h6 class="media-heading">
                                <span class="text-bold-500">№ <?= $item->id ?> &mdash; <?= $item->product->vendor_code ?> &mdash;  <?= $item->amount ?>шт</span>
                                &mdash; <?= $item->packet->user->full_name ?>
                                &mdash; <?= app()->formatter->asDatetime($item->date) ?>
                            </h6>
                            <small class="notification-text"><?= $item->product->name ?></small>
                        </div>
                    </div>
                </a>

            <?php endif; ?>

        <?php endforeach; ?>

        <!--            <div class="d-flex justify-content-between read-notification cursor-pointer">-->
        <!--                <div class="media d-flex align-items-center">-->
        <!--                    <div class="media-left pr-0">-->
        <!--                        <div class="avatar mr-1 m-0"><img-->
        <!--                                src="-->
        <? //= bu('themes/frest/app-assets/images/portrait/small/avatar-s-16.jpg') ?><!--"-->
        <!--                                alt="avatar" height="39" width="39"></div>-->
        <!--                    </div>-->
        <!--                    <div class="media-body">-->
        <!--                        <h6 class="media-heading"><span class="text-bold-500">New Message</span>-->
        <!--                            received</h6><small class="notification-text">You have 18 unread-->
        <!--                            messages</small>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <div class="d-flex justify-content-between cursor-pointer">-->
        <!--                <div class="media d-flex align-items-center py-0">-->
        <!--                    <div class="media-left pr-0"><img class="mr-1"-->
        <!--                                                      src="-->
        <? //= bu('themes/frest/app-assets/images/icon/sketch-mac-icon.png') ?><!--"-->
        <!--                                                      alt="avatar" height="39" width="39"></div>-->
        <!--                    <div class="media-body">-->
        <!--                        <h6 class="media-heading"><span-->
        <!--                                class="text-bold-500">Updates Available</span></h6><small-->
        <!--                            class="notification-text">Sketch 50.2 is currently newly-->
        <!--                            added</small>-->
        <!--                    </div>-->
        <!--                    <div class="media-right pl-0">-->
        <!--                        <div class="row border-left text-center">-->
        <!--                            <div class="col-12 px-50 py-75 border-bottom">-->
        <!--                                <h6 class="media-heading text-bold-500 mb-0">Update</h6>-->
        <!--                            </div>-->
        <!--                            <div class="col-12 px-50 py-75">-->
        <!--                                <h6 class="media-heading mb-0">Close</h6>-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <div class="d-flex justify-content-between cursor-pointer">-->
        <!--                <div class="media d-flex align-items-center">-->
        <!--                    <div class="media-left pr-0">-->
        <!--                        <div class="avatar bg-primary bg-lighten-5 mr-1 m-0 p-25"><span-->
        <!--                                class="avatar-content text-primary font-medium-2">LD</span>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                    <div class="media-body">-->
        <!--                        <h6 class="media-heading"><span class="text-bold-500">New customer</span> is-->
        <!--                            registered</h6><small class="notification-text">1 hrs ago</small>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <div class="cursor-pointer">-->
        <!--                <div class="media d-flex align-items-center justify-content-between">-->
        <!--                    <div class="media-left pr-0">-->
        <!--                        <div class="media-body">-->
        <!--                            <h6 class="media-heading">New Offers</h6>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                    <div class="media-right">-->
        <!--                        <div class="custom-control custom-switch">-->
        <!--                            <input class="custom-control-input" type="checkbox" checked-->
        <!--                                   id="notificationSwtich">-->
        <!--                            <label class="custom-control-label" for="notificationSwtich"></label>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <div class="d-flex justify-content-between cursor-pointer">-->
        <!--                <div class="media d-flex align-items-center">-->
        <!--                    <div class="media-left pr-0">-->
        <!--                        <div class="avatar bg-danger bg-lighten-5 mr-1 m-0 p-25"><span-->
        <!--                                class="avatar-content"><i class="bx bxs-heart text-danger"></i></span>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                    <div class="media-body">-->
        <!--                        <h6 class="media-heading"><span class="text-bold-500">Application</span> has-->
        <!--                            been approved</h6><small class="notification-text">6 hrs ago</small>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <div class="d-flex justify-content-between read-notification cursor-pointer">-->
        <!--                <div class="media d-flex align-items-center">-->
        <!--                    <div class="media-left pr-0">-->
        <!--                        <div class="avatar mr-1 m-0"><img-->
        <!--                                src="-->
        <? //= bu('themes/frest/app-assets/images/portrait/small/avatar-i-7.png') ?><!--"-->
        <!--                                alt="avatar" height="39" width="39"></div>-->
        <!--                    </div>-->
        <!--                    <div class="media-body">-->
        <!--                        <h6 class="media-heading"><span class="text-bold-500">New file</span> has-->
        <!--                            been uploaded</h6><small class="notification-text">4 hrs ago</small>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <div class="d-flex justify-content-between cursor-pointer">-->
        <!--                <div class="media d-flex align-items-center">-->
        <!--                    <div class="media-left pr-0">-->
        <!--                        <div class="avatar bg-rgba-danger m-0 mr-1 p-25">-->
        <!--                            <div class="avatar-content"><i class="bx bx-detail text-danger"></i>-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                    <div class="media-body">-->
        <!--                        <h6 class="media-heading"><span class="text-bold-500">Finance report</span>-->
        <!--                            has been generated</h6><small class="notification-text">25 hrs-->
        <!--                            ago</small>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <div class="d-flex justify-content-between cursor-pointer">-->
        <!--                <div class="media d-flex align-items-center border-0">-->
        <!--                    <div class="media-left pr-0">-->
        <!--                        <div class="avatar mr-1 m-0"><img-->
        <!--                                src="-->
        <? //= bu('themes/frest/app-assets/images/portrait/small/avatar-i-7.png') ?><!--"-->
        <!--                                alt="avatar" height="39" width="39"></div>-->
        <!--                    </div>-->
        <!--                    <div class="media-body">-->
        <!--                        <h6 class="media-heading"><span class="text-bold-500">New customer</span>-->
        <!--                            comment recieved</h6><small class="notification-text">2 days ago</small>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
    </li>

    <!--        <li class="dropdown-menu-footer"><a-->
    <!--                class="dropdown-item p-50 text-primary justify-content-center"-->
    <!--                href="javascript:void(0)">Read all notifications</a></li>-->
</ul>
