<?php
include '../layout/head.php';
Auth::admin();
include 'layout/navbar.php';
include 'layout/sidebar.php';
$site = $DB->query_one('site', ['domain' => $_SERVER['SERVER_NAME']]);
$userss = $DB->query_one('users', ['apikey'=>$site['apikey']]);

$list = $DB->query('users', ['domain' => $_SERVER['SERVER_NAME']]);
$sitecon = $DB->query('sitecon');

$order = $DB->num_rows('order', ['domain' => $_SERVER['SERVER_NAME']]);
$tungmmo2 = $DB->query('bank', ['domain' => $_SERVER['SERVER_NAME']]);
$tungmmo = $DB->query('napthe', ['domain' => $_SERVER['SERVER_NAME']]);
$money = 0;
$card = 0;
$bank = 0;
foreach ($tungmmo as $tungcoder => $tungdev) :
    $money += $tungdev['amount'];
    $card += $tungdev['amount'];
endforeach;
foreach ($tungmmo2 as $tungcoder2 => $tungdev2) :
    $bank += $tungdev2['amount'];
    $money += $tungdev2['amount'];
endforeach;

?>
<div class="col-md-6 col-12 pr-0" id="feed">
    <div class="p-20">

        <div class="row">
            <div class="col-md-4 col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p class="card-text">Thu nhập thẻ cào</p>
                                <div class="d-flex align-items-end mb-2">
                                    <h4 class="card-title mb-0 me-2 money-text"><b class="text-danger"><?= format_money($card); ?></b> coin
                                    </h4>
                                </div>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-success rounded p-2">
                                    <img src="/assets/img/icon/3655385.png" width="56" />
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p class="card-text">Tổng thu nhập</p>
                                <div class="d-flex align-items-end mb-2">
                                    <h4 class="card-title mb-0 me-2 money-text"><b class="text-danger"><?= format_money($money); ?></b>
                                        coin</h4>
                                </div>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-primary rounded p-2">
                                    <img src="/assets/img/icon/4580163.png" width="56" />
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p class="card-text">Thu nhập ngân hàng</p>
                                <div class="d-flex align-items-end mb-2">
                                    <h4 class="card-title mb-0 me-2 money-text">
                                        <b class="text-danger">
                                            <?= format_money($bank); ?></b>
                                        coin
                                    </h4>
                                </div>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-primary rounded p-2">
                                    <img src="/assets/img/icon/2318501.png" width="56" />
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (Auth::admin_main_site()) : ?>

            <div class="col-md-4 col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p class="card-text">Số site con</p>
                                <div class="d-flex align-items-end mb-2">
                                    <h4 class="card-title mb-0 me-2 money-text">
                                        <b class="text-danger"> <?php
                                                                $x = 0;
                                                                foreach ($sitecon as $keyx) :
                                                                    $x++;
                                                                endforeach;
                                                                echo format_money($x);
                                                                ?></b>
                                        site
                                    </h4>
                                </div>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-primary rounded p-2">
                                    <img src="/assets/img/icon/6742595.png?f" width="56">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
                <div class="col-md-4 col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p class="card-text">Số dư website còn</p>
                                <div class="d-flex align-items-end mb-2">
                                    <h4 class="card-title mb-0 me-2 money-text">
                                        <b class="text-danger"> <?=format_money($userss['coin']);?></b>
                                        coin
                                    </h4>
                                </div>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-primary rounded p-2">
                                    <img src="/assets/img/icon/6742595.png?f" width="56">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?> 
            <div class="col-md-4 col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p class="card-text">Tổng thành viên</p>
                                <div class="d-flex align-items-end mb-2">
                                    <h4 class="card-title mb-0 me-2 money-text">
                                        <b class="text-danger">
                                            <?php
                                            $i = 0;
                                            foreach ($list as $key) :
                                                $i++;
                                            endforeach;
                                            echo format_money($i);
                                            ?>
                                        </b>
                                        Thằng
                                    </h4>
                                </div>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-primary rounded p-2">
                                    <img src="/assets/img/icon/7672058.png" width="56">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-4 col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p class="card-text">Đơn mua</p>
                                <div class="d-flex align-items-end mb-2">
                                    <h4 class="card-title mb-0 me-2 money-text">
                                        <b class="text-danger"><?=format_money($order);?></b>
                                        Đơn
                                    </h4>
                                </div>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-info rounded p-2">
                                    <img src="/assets/img/icon/3474180.png?d" width="56">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
</div>

<?php
include '../layout/footer.php';
?>