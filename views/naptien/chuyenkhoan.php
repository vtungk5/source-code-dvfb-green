<?php
include '../layout/head.php';
include '../layout/navbar.php';
include '../layout/sidebar.php';
$list = $DB->query('bank', ['username' => Auth::user()->username, 'domain' => $_SERVER['SERVER_NAME']]);
?>
<div class="col-md-6 col-12 pr-0" id="feed">
    <div class="p-20">

        <div class="card  mb-4">
            <!-- Body -->
            <div class="card-body mt-2">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="media-mb ">
                            <h5 class="card-title fs-30 mb-3">Chuyển khoản</h5>
                        </div>
                    </div>
                </div>

                <div class="alert text-pre-wrap alert-success-light">
                    <p>- Bạn vui lòng chuyển khoản chính xác nội dung để được cộng tiền nhanh nhất.</p>
                    <p>- Nếu sau 10 phút từ khi tiền trong tài khoản của bạn bị trừ mà vẫn chưa được cộng tiền vui liên hệ Admin để được hỗ trợ.</p>
                    <p>- Vui lòng không nạp từ bank khác qua bank này (tránh lỗi).</p>
                </div>

                <div class="row">
                    <div class="mb-3 col-sm-6">
                        <h5 class="text-info text-center"><img src="/assets/img/logo/momo.png" height="45px"></h5>
                        <div class="alert text-white bg-success " role="alert">
                            <div>
                                Số tài khoản: <b class="text-stk"><?= Site::get('stk_momo'); ?></b>
                            </div>
                            <div>
                                Chủ tài khoản: <b class="text-right"><?= Site::get('name_momo'); ?></b>
                            </div>
                            <div>
                               Nội dung: <b class="text-stk"><?= Auth::user()->id; ?> nap</b>
                            </div>
                            <div>
                                Nạp tối thiểu: <b class="text-right">10,000 VNĐ</b>
                            </div>
                            <div>
                                Chú ý: <b class="text-right">Nạp tốc độ 5s -&gt; 30s, khung giờ 22h -&gt; 24h có thể
                                    delay.</b>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-sm-6">
                        <h5 class="text-info text-center"><img src="/assets/img/logo/mb.png" height="45px"></h5>
                        <div class="alert text-white bg-success " role="alert">
                            <div>
                                Số tài khoản: <b class="text-stk"><?= Site::get('stk_mb'); ?></b>
                            </div>
                            <div>
                                Chủ tài khoản: <b class="text-right"><?= Site::get('name_mb'); ?></b>
                            </div>
                            <div>
                               Nội dung: <b class="text-stk"><?= Auth::user()->id; ?> nap</b>
                            </div>
                            <div>
                                Nạp tối thiểu: <b class="text-right">10,000 VNĐ</b>
                            </div>
                            <div>
                                Chú ý: <b class="text-right">Nạp tốc độ 5s -&gt; 30s, khung giờ 22h -&gt; 24h có thể
                                    delay.</b>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-box" style="padding-top: 0px;">
                    <div class="mb-3">
                        <table class="table table-cen" id="table-mua">
                            <thead>
                                <tr>
                                    <th scope="col"><a href="#">#</a> </th>
                                    <th scope="col">số tiền</th>
                                    <th scope="col">nội dung</th>
                                    <th scope="col">phương thức</th>
                                    <th scope="col">trạng thái</th>
                                    <th scope="col">thời gian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($list as $key => $value) :
                                ?>
                                    <tr>
                                        <td><a href="#">#<?= $value['tranid']; ?></a></td>
                                        <td><?= format_money($value['amount']); ?></td>
                                        <td><?= $value['note']; ?></td>
                                        <td><?= $value['type']; ?></td>
                                        <td><?= buy_status($value['status']); ?></td>
                                        <td><?= timeago($value['date']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Body -->
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    <?php include 'item/napthe.js'; ?>
</script>
<?php include '../layout/footer.php'; ?>