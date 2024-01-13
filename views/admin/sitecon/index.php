<?php
include '../../layout/head.php';
Auth::admin_main_site();
include '../layout/navbar.php';
include '../layout/sidebar.php';
$list = $DB->query('sitecon');

?>
<div class="col-md-6 col-12 pr-0" id="feed">
    <div class="p-20">

        <div class="card  mb-4">
            <!-- Body -->
            <div class="card-body mt-2">

                <div class="row">
                    <div class="col-lg-6 w-100">
                        <div class="media-mb d-flex">
                            <h5 class="card-title fs-30 mb-3">Quản lý đại lý</h5>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <div class="card-box" style="padding-top: 0px;">
                        <div class="mb-3">
                            <table class="table green-bg table-cen">
                                <thead>
                                    <tr>
                                        <th scope="col">Tài khoản</th>
                                        <th scope="col">Tên miền</th>
                                        <th scope="col">Apikey</th>
                                        <th scope="col">Trang thái</th>
                                        <th scope="col">Thời gian</th>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($list as $key => $value) :
                                    ?>
                                        <tr>
                                            <td><?= $value['username']; ?></td>
                                            <td><?= $value['domain']; ?></td>
                                            <td><?= $value['apikey']; ?></td>
                                            <td><?= status_users($value['status']); ?></td>
                                            <td><?= $value['date']; ?></td>
                                            <td><button type="button" data-bs-toggle="modal" data-bs-target="#edit_<?= $value['id']; ?>" class="btn btn-success">Chỉnh sửa</button>
                                                <div class="modal fade" id="edit_<?= $value['id']; ?>" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form method="POST" action="/api/admin/daily/edit">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"><?= $value['domain']; ?></h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="card-body">
                                                                        <div class="mb-3">
                                                                            <label>Tên miền:</label>
                                                                            <input type="text" name="domain" value="<?= $value['domain']; ?>" placeholder="Điền tên dịch vụ" class="form-control">
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label>Trạng thái :</label>
                                                                            <select name="status" class="form-control">
                                                                                <option value="<?= $value['status']; ?>">Chọn trạng thái</option>
                                                                                <option value="ON">Hoạt động</option>
                                                                                <option value="OFF">Bị khóa</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <input type="hidden" name="uid" value="<?= $value['id']; ?>" />
                                                                    <button type="submit" class="btn btn-success">Lưu thông tin</button>
                                                                </div>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                        </div>
                        </td>
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