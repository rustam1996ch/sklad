<?php

foreach ($list as $item):
    ?>

    <a class="d-flex justify-content-between" href="javascript:void(0)">
        <div class="media d-flex align-items-center">

            <div class="media-body">
                <h6 class="media-heading"><span class="text-bold-500"><?= $item->client->name ?></span>
                    for work anniversaries</h6><small class="notification-text">Mar 15
                    12:32pm</small>
            </div>

        </div>
    </a>

<?php endforeach;
