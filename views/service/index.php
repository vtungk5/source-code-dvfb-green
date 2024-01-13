<?php
include '../layout/head.php';
if (Auth::user()) :
    if (isset($_GET['theloai']) && isset($_GET['dichvu'])) :
        $theloai_x = $DB->query_one('theloai', ['path' => $_GET['theloai']]);
        $dichvu_x = $DB->query_one('service', ['path' => $_GET['dichvu'], 'id_theloai' => $theloai_x['id_theloai']]);
        if (!isset($theloai_x['id'])) :
            header('location: /home');
        elseif (!isset($dichvu_x['id'])) :
            header('location: /home');
        endif;
    endif;
else :
    header('location: /home');
endif;
include '../layout/navbar.php';
include '../layout/sidebar.php';
$lichsu = $DB->query('order', ['username' => Auth::user()->username, 'domain' => $_SERVER['SERVER_NAME']]);
$site = $DB->query_one('site', ['domain' => $_SERVER['SERVER_NAME']]);

?>
<div class="col-md-6 col-12 pr-0" id="feed">
    <div class="p-20">

        <div class="card  mb-4">
            <!-- Body -->
            <div class="card-body mt-2">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="media-mb ">
                            <h5 class="card-title fs-30 mb-3"><?= $dichvu_x['name']; ?> <?= $theloai_x['name']; ?></h5>
                        </div>
                    </div>
                </div>

                <div class="alert text-pre-wrap alert-success-light">
                    <?= $dichvu_x['note']; ?>
                </div>
                <ul role="tablist" class="nav nav-pills nav-justified flex-column flex-sm-row mb-3">
                    <li class="nav-item tab-item" role="presentation">

                        <a class="nav-link active" data-bs-toggle="tab" href="#card" role="tab" aria-selected="true"> <i class="fa fa-plus-circle"></i> Mua dịch vụ </a>
                    </li>
                    <li class="nav-item tab-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#bank" role="tab" aria-selected="true"> <i class="fa fa-list"></i> Lịch sử mua </a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="card" role="tabpanel" aria-labelledby="card">
                        <div class="alert alert-warning br-10 text-pre-wrap ">Nạp thêm tiền để nâng cấp bậc nhận nhiều ưu đãi giảm giá hơn <a href="/nap-tien/chuyen-khoan" class="au">tại đây</a> </div>
                        <!-- Body -->
                        <div class="card-body">
                            <!-- Form -->
                            <form method="POST" action="/api/service/<?= $theloai_x['path']; ?>/<?= $dichvu_x['path']; ?>" oninput="tungmmo()" id="muadichvu">
                                <div class="mb-3">
                                    <label class="mb-2">ID hoặc Link:</label>
                                    <input type="text" placeholder="Nhập ID hoặc đường dẫn " name="uid" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="mb-2">Chọn Server <i class="fa fa-sort"></i> :</label>
                                    <?php
                                    $sv_check = $DB->query('server', ['id_dv' => $dichvu_x['id_dv'], 'domain' => $_SERVER['SERVER_NAME']]);
                                    $i = 1;
                                    foreach ($sv_check as $keyx => $valuex) :
                                    ?>
                                        <div class="form-check mb-2">

                                            <input type="radio" value="sv<?= $valuex['server']; ?>" name="server" class="form-check-input mr-11" <?php if ($i++ === 1) : echo 'checked=""';
                                                                                                                                                    endif; ?>>
                                            <label class="form-check-label m-0">[sv<?= $valuex['server']; ?>] <?= $valuex['name']; ?>
                                                <span class="badge bg-success-light"><?= $valuex['rate']; ?> coin</span>
                                                <?= trang_thai($valuex['status']); ?>
                                            </label>
                                        </div>
                                    <?php
                                    endforeach; ?>

                                </div>

                                <div class="mb-3">
                                    <label class="mb-2">Số lượng cần tăng ( 100 ~ 1,000 ) :</label>
                                    <input placeholder="Nhập số lượng cần tăng" value="100" name="amount" type="number" class="form-control">
                                </div>
                                <?php if ($dichvu_x['speed'] == 'ON') :   ?>
                                    <div class="mb-3">
                                        <label class="mb-2">Chọn tốc độ <i class="fa fa-sort"></i> :</label>
                                        <div class="form-check mb-2">
                                            <input type="radio" value="nhanh" name="speed" class="form-check-input mr-11">
                                            <label class="form-check-label m-0">nhanh</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input type="radio" value="cham" name="speed" class="form-check-input mr-11">
                                            <label class="form-check-label m-0">chậm</label>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if ($dichvu_x['reaction'] == 'ON') :   ?>
                                    <div class="mb-3">
                                        <label class="mb-3">Cảm xúc:</label>
                                        <div class="col-sm-8 mb-3">

                                            <div class="input-group mb-3">
                                                <div class="form-check form-check-inline mb-1">
                                                    <label class="form-check-label" for="reaction0">
                                                        <input class="form-check-input checkbox checkbox-like d-none" type="radio" coin='101' id="reaction0" name="reaction" value="like">
                                                        <img src="/assets/img/bot/UkjJoEQ.png" alt="image" class="d-block ml-2 rounded-circle" width="35">
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline mb-1">
                                                    <label class="form-check-label" for="reaction1">
                                                        <input class="form-check-input checkbox checkbox-love d-none" type="radio" coin='100' id="reaction1" name="reaction" value="love">
                                                        <img src="/assets/img/bot/TTglM7B.png" alt="image" class="d-block ml-2 rounded-circle" width="35">
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline mb-1">
                                                    <label class="form-check-label" for="reaction3">
                                                        <input class="form-check-input checkbox-yl checkbox d-none" type="radio" coin='100' id="reaction3" name="reaction" value="haha">
                                                        <img src="/assets/img/bot/pQRrnEa.png" alt="image" class="d-block ml-2 rounded-circle" width="35">
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline mb-1">
                                                    <label class="form-check-label" for="reaction4">
                                                        <input class="form-check-input checkbox-yl checkbox d-none" type="radio" coin='100' id="reaction4" name="reaction" value="wow">
                                                        <img src="/assets/img/bot/OXPEvs4.png" alt="image" class="d-block ml-2 rounded-circle" width="35">
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline mb-1">
                                                    <label class="form-check-label" for="reaction6">
                                                        <input class="form-check-input checkbox checkbox-yl d-none" type="radio" coin='100' id="reaction6" name="reaction" value="sad">
                                                        <img src="/assets/img/bot/NwPi9oF.png" alt="image" class="d-block ml-2 rounded-circle" width="35">
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline mb-1">
                                                    <label class="form-check-label" for="reaction7">
                                                        <input class="form-check-input checkbox checkbox-angry d-none" type="radio" coin='100' id="reaction7" name="reaction" value="angry">
                                                        <img src="/assets/img/bot/sZe0vDn.png" alt="image" class="d-block ml-2 rounded-circle" width="35">
                                                    </label>
                                                </div>

                                                <div class="form-check form-check-inline mb-1">
                                                    <label class="form-check-label" for="reaction8">
                                                        <input class="form-check-input checkbox checkbox-yl d-none" type="radio" id="reaction8" name="reaction" value="Care">
                                                        <img src="/assets/img/bot/care-2387662-1991058.png" alt="image" class="d-block ml-2 rounded-circle" width="35">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if ($dichvu_x['comment'] == 'ON') :   ?>
                                    <div class="mb-3">
                                        <label class="mb-2">Bình luận :</label>
                                        <textarea rows="5" name="comment" placeholder="Nhập ghi chú hoặc bỏ trống" class="form-control"></textarea>
                                    </div>
                                <?php endif; ?>
                                <div class="mb-3">
                                    <label class="mb-2">Ghi chú :</label>
                                    <textarea rows="5" name="note" placeholder="Nhập ghi chú hoặc bỏ trống" class="form-control"></textarea>
                                </div>
                                <div class="mb-3">
                                    <div class="alert alert-success" id="notiserver">

                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="box-price">
                                        <div class="text">Tổng thanh toán:</div>
                                        <div class="total-money"><span>
                                                <span id="total">0</span> COIN
                                            </span></div>
                                        <div>Bạn sẽ tăng <span class="note-service" id="slmua">50,000</span> với giá là
                                            <span class="note-service" id="total2">0</span> COIN
                                        </div>
                                    </div>
                                </div>

                                <button id="send" type="submit" class="btn btn-buy w-100 ">Thanh toán dịch
                                    vụ</button>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="bank" role="tabpanel" aria-labelledby="bank">
                        <div class="card-box" style="padding-top: 0px;">
                            <div class="form-group">
                                <table class="table table-cen" id="table-mua">
                                    <thead>
                                        <tr>
                                            <th scope="col"><a href="#">#</a> </th>
                                            <th scope="col">uid</th>
                                            <th scope="col">số lượng</th>
                                            <th scope="col">giá thành</th>
                                            <th scope="col">trạng thái</th>
                                            <th scope="col">thời gian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($lichsu as $keyx => $valuex) :
                                        ?>
                                            <tr>
                                                <td><a href="#">#<?= $valuex['MGD']; ?></a></td>
                                                <td><?= $valuex['uid']; ?></td>
                                                <td><?= $valuex['amount']; ?></td>
                                                <td><?= format_money($valuex['money']); ?></td>
                                                <td><?= buy_status2($valuex['status']); ?></td>
                                                <td><?= timeago($valuex['date']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- End Body -->
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if (Auth::user()->level == 2) :
    $ratex = $site['rate_ctv'];
elseif (Auth::user()->level == 3) :
    $ratex = $site['rate_daily'];
elseif (Auth::user()->level == 4) :
    $ratex = $site['rate_daily'];
endif;
?>

<script type="text/javascript">
    function tungmmo() {

        let sl = document.querySelector('input[name="amount"]').value;
        let sv = document.querySelector('input[name="server"]:checked').value;
        <?php if ($dichvu_x['reaction'] == 'ON') :   ?>
            let reaction = $('input[name="reaction"]:checked').attr('coin');
        <?php endif; ?>
        let idus = document.querySelector('input[name="uid"]').value;
        <?php foreach ($sv_check as $ss => $sv) : ?>
            if (sv == 'sv<?= $sv['server']; ?>') {
                var gia = <?= $sv['rate']; ?>;
                $('#notiserver').html(`<?= $sv['note']; ?>`);
            }
        <?php endforeach; ?>

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        var tien = sl * gia - <?= $ratex; ?>;
        <?php if ($dichvu_x['reaction'] == 'ON') : ?>
            if (!reaction) {
                var tien2 = tien;
            } else {
                var tien2 = tien <?php if ($dichvu_x['reaction'] == 'ON') :   ?> + Number(reaction) <?php endif; ?>;
            }
        <?php else : ?>
            var tien2 = tien <?php if ($dichvu_x['reaction'] == 'ON') :   ?> + Number(reaction) <?php endif; ?>;
        <?php endif; ?>
        var tung = tien2.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        var dz = sl.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");

        if (sl == '') {
            Toast.fire({
                icon: 'error',
                title: 'Số lượng không được bỏ trống'
            });
        }
        if (sl < 100) {
            Toast.fire({
                icon: 'error',
                title: 'Số lượng không được nhỏ hơn 100'
            });
            document.getElementById("total").innerHTML = 0;
        } else {
            document.getElementById("total").innerHTML = tung;
        }



        document.getElementById("slmua").innerHTML = dz;
        document.getElementById("total2").innerHTML = tung;

    }
</script>
<script type="text/javascript">
    <?php include 'item/buy.js'; ?>
</script>
<?php
include '../layout/footer.php';
?>