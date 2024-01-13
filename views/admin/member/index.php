<?php
include '../../layout/head.php';
Auth::admin();
include '../layout/navbar.php';
include '../layout/sidebar.php';
if (!Auth::admin_main_site()) :
    $list = $DB->query('users', ['domain' => $_SERVER['SERVER_NAME']]);
else :
    $list = $DB->query('users');
endif;
?>

<div class="col-md-6 col-12 pr-0" id="feed">
    <div class="p-20">

        <div class="card  mb-4">
            <!-- Body -->
            <div class="card-body mt-2">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="media-mb ">
                            <h5 class="card-title fs-30 mb-3">Quản lý thành viên</h5>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12">

                        <div class="card mb-0">
                            <!-- Body -->
                            <div class="card-body">

                                <!-- Form -->
                                <form method="POST" action="/api/admin/member/congtien" href="/admin/thanh-vien/list">
                                    <div class="form-group">
                                        <label>Tên đăng nhập:</label>
                                        <input type="text" name="username" placeholder="Nhập Tên đăng nhập" value="" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Số tiền cộng:</label>
                                        <input type="number" name="coin" placeholder="Nhập số tiền cộng" value="" class="form-control">
                                    </div>
                                    <button class="btn btn-signup  button-ck w-100 mt-4 mb-4" type="submit">Cộng tiền</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="card mb-0">
                            <!-- Body -->
                            <div class="card-body">


                                <!-- Form -->
                                <form  method="POST" action="/api/admin/member/trutien" href="/admin/thanh-vien/list">
                                    <div class="form-group">
                                        <label>Tên đăng nhập:</label>
                                        <input type="text" name="username" placeholder="Nhập Tên đăng nhập" value="" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Số tiền trừ:</label>
                                        <input type="text" name="coin" placeholder="Nhập số tiền trừ" value="" class="form-control">
                                    </div>
                                    <button class="btn btn-danger  button-ck w-100 mt-4 mb-4" type="submit">Trừ tiền</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <div class="card-box" style="padding-top: 0px;">
                        <div class="mb-3">
                            <table class="table green-bg table-cen">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">họ và tên</th>
                                        <th scope="col">username</th>
                                        <th scope="col">số dư (coin)</th>
                                        <th scope="col">cấp bậc</th>
                                        <th scope="col">thời gian</th>
                                        <th scope="col">địa chỉ IP</th>
                                        <th scope="col">trạng thái</th>
                                        <?php if (Auth::admin_main_site()) : ?>
                                            <th scope="col">Tên miền</th>
                                        <?php endif;                  ?>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($list as $key => $value) :
                                    ?>
                                        <tr>
                                            <td><img width="32" src="https://joeschmoe.io/api/v1/random"></td>
                                            <td><?= $value['name']; ?></td>
                                            <td><?= $value['username']; ?></td>
                                            <td><?= format_money($value['coin']); ?></td>
                                            <td><?= $value['level']; ?></td>
                                            <td><?= $value['date']; ?></td>
                                            <td><?= $value['ip']; ?></td>
                                            <td><?= status_users($value['status']); ?></td>
                                            <?php if (Auth::admin_main_site()) : ?>
                                                <td><?= $value['domain']; ?></td>
                                            <?php endif;                  ?>
                                            <td><button type="button" data-bs-toggle="modal" data-bs-target="#edit_<?= $value['id']; ?>" class="btn btn-success">Chỉnh sửa</button>
                                                <div class="modal fade" id="edit_<?= $value['id']; ?>" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form method="POST" action="/api/admin/member/edit" href="/admin/thanh-vien/list">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"><?=$value['name'];?></h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="card-body">
                                                                        <div class="mb-3">
                                                                            <label>Họ và tên:</label>
                                                                            <input type="text" name="name" value="<?= $value['name']; ?>" placeholder="Điền họ và tên" class="form-control">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label>Tên đăng nhập:</label>
                                                                            <input type="text" name="username" value="<?= $value['username']; ?>" placeholder="Điền tên đăng nhập" class="form-control">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label>Số dư:</label>
                                                                            <input type="number" name="coin" value="<?= $value['coin']; ?>" placeholder="Điền số dư tài khoản" class="form-control">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label>Mật khẩu:</label>
                                                                            <input type="password" name="password" value="" placeholder="Điền mật khẩu mới" class="form-control">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label>Cấp bậc :</label>
                                                                            <select name="level" class="form-control">
                                                                                <option value="<?= $value['level']; ?>">Vui lòng chọn</option>
                                                                                <option value="0">Thành viên</option>
                                                                                <option value="1">Cộng tác viên</option>
                                                                                <option value="2">Đại lý</option>
                                                                                <option value="3">Quản trị viên ( đại lý) </option>
                                                                                <option value="4">Quản trị viên</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label>Trạng thái :</label>
                                                                            <select name="status" class="form-control">
                                                                                <option value="<?= $value['status']; ?>">Vui lòng chọn</option>
                                                                                <option value="ON">Hoạt động</option>
                                                                                <option value="OFF">Bị khóa</option>
                                                                            </select>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">


                                                                    <button type="button" id="delete_<?= $value['id']; ?>" class="btn btn-danger">Xóa người dùng</button>
                                                                    <script>
                                                                        $("#delete_<?= $value['id']; ?>").click(function() {
                                                                            submitForm(
                                                                                '/api/admin/member/delete',
                                                                                'POST', {
                                                                                    uid: $('#delete_<?= $value['id']; ?> ~ input[name="uid"]').val()
                                                                                },
                                                                                null,
                                                                                '/admin/thanh-vien/list'
                                                                            );
                                                                        });
                                                                    </script>
                                                                    <input type="hidden" name="uid" value="<?= $value['id']; ?>" />
                                                                    <button type="submit" class="btn btn-success">Lưu thông tin</button>
                                                                </div>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
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