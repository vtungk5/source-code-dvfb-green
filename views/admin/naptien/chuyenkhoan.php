<?php
include '../../layout/head.php';
Auth::admin();
include '../layout/navbar.php';
include '../layout/sidebar.php';
$list = $DB->query('bank', ['domain' => $_SERVER['SERVER_NAME']]);

?>
<div class="col-md-6 col-12 pr-0" id="feed">
    <div class="p-20">

        <div class="card  mb-4">
            <!-- Body -->
            <div class="card-body mt-2">

                <div class="row">
                    <div class="col-lg-6 w-100">
                        <div class="media-mb d-flex">
                            <h5 class="card-title fs-30 mb-3">Quản lý chuyển khoản</h5>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <div class="card-box" style="padding-top: 0px;">
                        <div class="mb-3">
                        <table class="table table-cen" id="table-mua">
                            <thead>
                                <tr>
                                    <th scope="col"><a href="#">#</a> </th>
                                    <th scope="col">username</th>
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
                                        <td><?= $value['username']; ?></td>
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