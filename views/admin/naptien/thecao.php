<?php
include '../../layout/head.php';
Auth::admin();
include '../layout/navbar.php';
include '../layout/sidebar.php';
$list = $DB->query('napthe', ['domain' => $_SERVER['SERVER_NAME']]);

?>
<div class="col-md-6 col-12 pr-0" id="feed">
    <div class="p-20">

        <div class="card  mb-4">
            <!-- Body -->
            <div class="card-body mt-2">

                <div class="row">
                    <div class="col-lg-6 w-100">
                        <div class="media-mb d-flex">
                            <h5 class="card-title fs-30 mb-3">Quản lý thẻ cào</h5>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <div class="card-box" style="padding-top: 0px;">
                        <div class="mb-3">
                            <table class="table green-bg table-cen">
                                <thead>
                                    <tr>
                                        <th scope="col">Mã Giao Dịch</th>
                                        <th scope="col">Tài khoản</th>
                                        <th scope="col">Mã thẻ</th>
                                        <th scope="col">Serial thẻ</th>
                                        <th scope="col">Nhà mạng</th>
                                        <th scope="col">Mệnh giá</th>
                                        <th scope="col">trạng thái</th>
                                        <th scope="col">Thời gian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($list as $key => $value) :
                                    ?>
                                        <tr>
                                            <td><?= $value['tranid']; ?></td>
                                            <td><?= $value['username']; ?></td>
                                            <td><?= $value['pin']; ?></td>
                                            <td><?= $value['serial']; ?></td>
                                            <td><?= $value['telco']; ?></td>
                                            <td><?= format_money($value['amount']); ?></td>
                                            <td><?= status_card($value['status']); ?></td>
                                            <td><?= $value['date']; ?></td>
                                    </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    <?php include 'item/app.js'; ?>
</script>
<?php
include '../../layout/footer.php';
?>