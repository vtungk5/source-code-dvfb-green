<?php
include '../../layout/head.php';
Auth::admin();
include '../layout/navbar.php';
include '../layout/sidebar.php';
$list = $DB->query('server', ['domain' => $_SERVER['SERVER_NAME']]);
$service = $DB->query('service');
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
                            <h5 class="card-title fs-30 mb-3">Quản lý server</h5>
                            <?php if (Auth::admin_main_site()) : ?> <div class="ms-auto"><button type="submit" data-bs-toggle="modal" data-bs-target="#add_server" class="btn btn-success">Thêm server</button></div> <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php if (Auth::admin_main_site()) : ?>
                    <div class="modal fade" id="add_server" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="/api/admin/server/create" href="/admin/server/list">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Thêm server</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label>Tên server:</label>
                                                <input type="text" name="name" value="" placeholder="Điền tên server" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label>rate:</label>
                                                <input type="text" name="rate" value="" placeholder="Điền rate server" class="form-control">
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
                                                <label>Dịch vụ :</label>
                                                <select name="id_dv" class="form-control">
                                                    <?php if ($DB->num_rows('service') == 0) : ?>
                                                        <option value="">Chưa dịch vụ</option>
                                                        <?php
                                                    else :
                                                        foreach ($service as $value => $key) : ?>
                                                            <option value="<?= $key['id_dv']; ?>"><?= $key['name']; ?></option>
                                                    <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label>server: ( vd:1,2,3,4)</label>
                                                <input type="text" name="server" value="" placeholder="Điền thứ tự server" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label>id server: ( vd:sv1)</label>
                                                <input type="text" name="id_sv" value="" placeholder="Điền id server" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label>ghi chú :</label>
                                                <textarea name="note" id="note" rows="10" cols="80" class="form-control"></textarea>
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
                                        <button type="submit" class="btn btn-success">Tạo server</button>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
            </div>
        <?php endif; ?>
        <div class="form-group mt-3">
            <div class="card-box" style="    padding: 24px;">
                <div class="mb-3">
                    <table class="table green-bg table-cen">
                        <thead>
                            <tr>
                                <th scope="col">SV</th>
                                <th scope="col">Tên server</th>
                                <th scope="col">rate server</th>
                                <th scope="col">thể loại</th>
                                <th scope="col">dịch vụ</th>
                                <th scope="col">trạng thái</th>
                                <?php if (Auth::admin_main_site()) : ?><th scope="col">Mã server</th><?php endif;?>
                                <th scope="col">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($list as $key => $value) :
                            ?>
                                <tr>
                                    <td><?= $value['server']; ?></td>
                                    <td><?= $value['name']; ?></td>
                                    <td><?= $value['rate']; ?></td>
                                    <td><?= $DB->query_one('theloai', ['id_theloai' => $value['id_theloai']])['name']; ?></td>
                                    <td><?= $DB->query_one('service', ['id_dv' => $value['id_dv']])['name']; ?></td>
                                    <td><?=trang_thai($value['status']);?></td>
                                    <?php if (Auth::admin_main_site()) : ?><td><?= $value['id_sv']; ?></td><?php endif;?>

                                    <td><button type="button" data-bs-toggle="modal" data-bs-target="#edit_<?= $value['id']; ?>" class="btn btn-success">Chỉnh sửa</button>
                                        <div class="modal fade" id="edit_<?= $value['id']; ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="POST" action="/api/admin/server/edit"  href="/admin/server/list">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><?= $value['name']; ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="card-body">
                                                                <?php if (!Auth::admin_main_site()) : ?>
                                                                    <div class="mb-3">
                                                                        <label>server:</label>
                                                                        <input type="text" name="server" value="<?= $value['server']; ?>" class="form-control" readonly>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <div class="mb-3">
                                                                    <label>Tên server:</label>
                                                                    <input type="text" name="name" value="<?= $value['name']; ?>" placeholder="Điền tên server" class="form-control">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label>rate:</label>
                                                                    <input type="text" name="rate" value="<?= $value['rate']; ?>" placeholder="Điền rate server" class="form-control">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label>Thể loại :</label>
                                                                    <select name="id_theloai" <?php if (Auth::admin_main_site()) : ?>readonly="" <?php endif; ?> class="form-control">
                                                                        <?php if ($DB->num_rows('theloai') == 0) : ?>
                                                                            <option value="">Chưa tạo thể loại</option>
                                                                        <?php else : ?>
                                                                            <?php if (Auth::admin_main_site()) : ?>
                                                                                <option value="<?= $value['id_theloai']; ?>">Chọn thể loại</option>

                                                                                <?php foreach ($theloai as $value2 => $key2) : ?>
                                                                                    <option value="<?= $key2['id_theloai']; ?>"><?= $key2['name']; ?></option>
                                                                                <?php endforeach; ?>
                                                                            <?php else : ?>
                                                                                <option value="<?= $value['id_theloai']; ?>"><?= $DB->query_one('theloai', ['id_theloai' => $value['id_theloai']])['name']; ?></option>
                                                                        <?php endif;
                                                                        endif;
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label>Dịch vụ :</label>
                                                                    <select name="id_dv" <?php if (!Auth::admin_main_site()) : ?> readonly="" <?php endif; ?> class="form-control">
                                                                        <?php if ($DB->num_rows('service') == 0) : ?>
                                                                            <option value="">Chưa dịch vụ</option>
                                                                        <?php else : ?>
                                                                            <?php if (Auth::admin_main_site()) : ?>

                                                                                <option value="<?= $value['id_dv']; ?>">Chọn dịch vụ</option>
                                                                                <?php foreach ($service as $value3 => $key3) : ?>
                                                                                    <option value="<?= $key3['id_dv']; ?>"><?= $key3['name']; ?></option>
                                                                                <?php endforeach; ?>
                                                                            <?php else : ?>
                                                                                <option value="<?= $value['id_dv']; ?>"><?= $DB->query_one('service', ['id_dv' => $value['id_dv']])['name']; ?></option>
                                                                        <?php endif;
                                                                        endif;
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <?php if (Auth::admin_main_site()) : ?>
                                                                    <div class="mb-3">
                                                                        <label>server: ( vd:1,2,3,4)</label>
                                                                        <input type="text" name="server" value="<?= $value['server']; ?>" placeholder="Điền thứ tự server" class="form-control">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>id server: ( vd:sv1)</label>
                                                                        <input type="text" name="id_sv" value="<?= $value['id_sv']; ?>" placeholder="Điền id server" class="form-control">
                                                                    </div>
                                                                <?php endif; ?>
                                                                <div class="mb-3">
                                                                    <label>ghi chú :</label>
                                                                    <textarea name="note" id="note_<?= $value['id']; ?>" rows="10" cols="80" class="form-control">
                                                                            <?= $value['note']; ?>
                                                                            </textarea>
                                                                    <script>
                                                                        CKEDITOR.replace('note_<?= $value['id']; ?>');
                                                                    </script>
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
                                                         
                                                            <?php if (Auth::admin_main_site()) : ?>
                                                                <button type="button" id="delete_<?= $value['id']; ?>" class="btn btn-danger">Xóa server</button>
                                                                <script>
                                                                    $("#delete_<?= $value['id']; ?>").click(function() {
                                                                        submitForm(
                                                                            '/api/admin/server/delete',
                                                                            'POST', {
                                                                                id_sv: $('#delete_<?= $value['id']; ?> ~ input[name="id_sv_x"]').val()
                                                                            },
                                                                            null,
                                                                            '/admin/server/list'
                                                                        );
                                                                    });
                                                                </script>
                                                                <input type="hidden" name="id_sv_x" value="<?= $value['id_sv']; ?>" />
                                                            <?php endif; ?>
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
<style>
    #add_server {
        overflow: auto !important;
    }
</style>
<?php
include '../../layout/footer.php';
?>