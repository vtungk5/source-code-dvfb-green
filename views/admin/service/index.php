<?php
include '../../layout/head.php';
Auth::admin_main_site();
include '../layout/navbar.php';
include '../layout/sidebar.php';
$list = $DB->query('service');
$theloai = $DB->query('theloai');
?>
<div class="col-md-6 col-12 pr-0" id="feed">
    <div class="p-20">

        <div class="card  mb-4">
            <!-- Body -->
            <div class="card-body mt-2">

                <div class="row">
                    <div class="col-lg-6 w-100">
                        <div class="media-mb d-flex">
                            <h5 class="card-title fs-30 mb-3">Quản lý dịch vụ</h5>
                            <div class="ms-auto"><button type="submit" data-bs-toggle="modal"
                                    data-bs-target="#add_dich_vu" class="btn btn-success">Thêm dịch vụ</button></div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="add_dich_vu" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="/api/admin/service/create" href="/admin/dich-vu/list">
                                <div class="modal-header">
                                    <h5 class="modal-title">Thêm dịch vụ</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Tên dịch vụ:</label>
                                            <input type="text" name="name" value="" placeholder="Điền tên dịch vụ"
                                                class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>đường dẫn:</label>
                                            <input type="text" name="path" value="" placeholder="Điền đường dẫn dịch vụ"
                                                class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>ID dịch vụ (vd: sub-vip):</label>
                                            <input type="text" name="id_dv" value="" placeholder="Điền id dịch vụ"
                                                class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>Thể loại :</label>
                                            <select name="id_theloai" class="form-control">
                                                <?php if ($DB->num_rows('theloai') == 0) : ?>
                                                <option value="">Chưa tạo thể loại</option>
                                                <?php
                                                else :
                                                    foreach ($theloai as $value => $key) : ?>
                                                <option value="<?= $key['id_theloai']; ?>"><?= $key['name']; ?></option>
                                                <?php
                                                    endforeach;
                                                endif;
                                                ?>

                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Nhà cung cấp:</label>
                                            <select name="nguon" class="form-control">
                                                <option value="subgiare.vn">subgiare</option>
                                                <option value="submeta.vn">submeta.vn</option>
                                                <option value="trum24h.pro">trum24h.pro</option>
                                                <option value="fbvn.me">fbvn.me</option>
                                                <option value="ORDER">Đơn tay</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Apikey:</label>
                                            <input type="text" name="apikey" value="" placeholder="Điền mã Apikey"
                                                class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>Bình luận :</label>
                                            <select name="comment" class="form-control">
                                                <option value="OFF">Tắt</option>
                                                <option value="ON">Bật</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Bot cảm xúc :</label>
                                            <select name="reaction" class="form-control">
                                                <option value="OFF">Tắt</option>
                                                <option value="ON">Bật</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Tốc độ :</label>
                                            <select name="speed" class="form-control">
                                                <option value="OFF">Tắt</option>
                                                <option value="ON">Bật</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label>lưu ý:</label>
                                            <textarea name="note" id="note" rows="10" cols="80"
                                                class="form-control"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Trạng thái :</label>
                                            <select name="status" class="form-control">
                                                <option value="ON">Hoạt động</option>
                                                <option value="OFF">Bị khóa</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Tạo dịch vụ</button>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <div class="card-box" style="padding-top: 0px;">
                        <div class="mb-3">
                            <table class="table green-bg table-cen">
                                <thead>
                                    <tr>
                                        <th scope="col">icon</th>
                                        <th scope="col">Tên dịch vụ</th>
                                        <th scope="col">Nhà cung cấp</th>
                                        <th scope="col">Thể loại</th>
                                        <th scope="col">Bình luận</th>
                                        <th scope="col">Bot cảm xúc</th>
                                        <th scope="col">Tốc độ</th>
                                        <th scope="col">trạng thái</th>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($list as $key => $value) :
                                    ?>
                                    <tr>
                                        <td><img width="32"
                                                src="<?= $DB->query_one('theloai', ['id_theloai' => $value['id_theloai']])['logo']; ?>">
                                        </td>
                                        <td><?= $value['name']; ?></td>
                                        <td><?= $value['nguon']; ?></td>
                                        <td><?= $DB->query_one('theloai', ['id_theloai' => $value['id_theloai']])['name']; ?>
                                        </td>
                                        <td><?= tinh_trang($value['comment']); ?></td>
                                        <td><?= tinh_trang($value['reaction']); ?></td>
                                        <td><?= tinh_trang($value['speed']); ?></td>
                                        <td><?= trang_thai($value['status']); ?></td>
                                        <td><button type="button" data-bs-toggle="modal"
                                                data-bs-target="#edit_<?= $value['id']; ?>"
                                                class="btn btn-success">Chỉnh sửa</button>
                                            <div class="modal fade" id="edit_<?= $value['id']; ?>" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="POST" action="/api/admin/service/edit" href="/admin/dich-vu/list">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"><?=$value['name'];?></h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="card-body">
                                                                    <div class="mb-3">
                                                                        <label>Tên dịch vụ:</label>
                                                                        <input type="text" name="name"
                                                                            value="<?= $value['name']; ?>"
                                                                            placeholder="Điền tên dịch vụ"
                                                                            class="form-control">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>đường dẫn:</label>
                                                                        <input type="text" name="path"
                                                                            value="<?= $value['path']; ?>"
                                                                            placeholder="Điền đường dẫn dịch vụ"
                                                                            class="form-control">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>ID dịch vụ (vd: sub-vip):</label>
                                                                        <input type="text" name="id_dv"
                                                                            value="<?= $value['id_dv']; ?>"
                                                                            placeholder="Điền id dịch vụ"
                                                                            class="form-control">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>Thể loại:</label>
                                                                        <select name="id_theloai" class="form-control">
                                                                            <?php if ($DB->num_rows('theloai') == 0) : ?>
                                                                            <option value="">Chưa tạo thể loại</option>
                                                                            <?php else : ?>
                                                                            <option
                                                                                value="<?= $value['id_theloai']; ?>">
                                                                                Chọn thể loại</option>
                                                                            <?php foreach ($theloai as $value2 => $key2) : ?>
                                                                            <option value="<?= $key2['id_theloai']; ?>">
                                                                                <?= $key2['name']; ?></option>
                                                                            <?php
                                                                                    endforeach;
                                                                                endif;
                                                                                ?>

                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>Nhà cung cấp:</label>
                                                                        <select name="nguon" class="form-control">
                                                                            <option value="<?= $value['nguon']; ?>">Chọn
                                                                                nhà cung cấp</option>
                                                                            <option value="subgiare.vn">subgiare
                                                                            </option>
                                                                            <option value="submeta.vn">submeta.vn
                                                                            </option>
                                                                            <option value="trum24h.pro">trum24h.pro
                                                                            </option>
                                                                            <option value="fbvn.me">fbvn.me
                                                                            </option>
                                                                            <option value="ORDER">Đơn tay</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>Apikey:</label>
                                                                        <input type="text" name="apikey"
                                                                            value="<?= $value['apikey']; ?>"
                                                                            placeholder="Điền mã Apikey"
                                                                            class="form-control">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>Bình luận :</label>
                                                                        <select name="comment" class="form-control">
                                                                            <option value="<?= $value['comment']; ?>">
                                                                                Chọn trạng thái</option>
                                                                            <option value="OFF">Tắt</option>
                                                                            <option value="ON">Bật</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>Bot cảm xúc :</label>
                                                                        <select name="reaction" class="form-control">
                                                                            <option value="<?= $value['reaction']; ?>">
                                                                                Chọn trạng thái</option>
                                                                            <option value="OFF">Tắt</option>
                                                                            <option value="ON">Bật</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>Tốc độ :</label>
                                                                        <select name="speed" class="form-control">
                                                                            <option value="<?= $value['speed']; ?>">Chọn
                                                                                trạng thái</option>
                                                                            <option value="OFF">Tắt</option>
                                                                            <option value="ON">Bật</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label>lưu ý:</label>
                                                                        <textarea name="note"
                                                                             rows="10"
                                                                            cols="80" class="form-control">
                                                                            <?= $value['note']; ?>
                                                                            </textarea>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label>Trạng thái :</label>
                                                                        <select name="status" class="form-control">
                                                                            <option value="<?= $value['status']; ?>">
                                                                                Chọn trạng thái</option>
                                                                            <option value="ON">Hoạt động</option>
                                                                            <option value="OFF">Bị khóa</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">

                                                                <button type="button" id="delete_<?= $value['id']; ?>"
                                                                    class="btn btn-danger">Xóa dịch vụ</button>
                                                                <script>
                                                                $("#delete_<?= $value['id']; ?>").click(function() {
                                                                    submitForm(
                                                                        '/api/admin/service/delete',
                                                                        'POST', {
                                                                            id_dv: $(
                                                                                '#delete_<?= $value['id']; ?> ~ input[name="id_dv_x"]'
                                                                                ).val()
                                                                        },
                                                                        null,
                                                                        '/admin/dich-vu/list'
                                                                    );
                                                                });
                                                                </script>
                                                                <input type="hidden" name="id_dv_x"
                                                                    value="<?=$value['id_dv']; ?>" />
                                                                <input type="hidden" name="uid"
                                                                    value="<?=$value['id']; ?>" />
                                                                <button type="submit" class="btn btn-success">Lưu thông
                                                                    tin</button>
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
<style>
#add_dich_vu {
    overflow: auto !important;
}
</style>
<?php
include '../../layout/footer.php';
?>