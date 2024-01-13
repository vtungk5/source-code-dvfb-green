<?php
include '../../layout/head.php';
Auth::admin_main_site();
include '../layout/navbar.php';
include '../layout/sidebar.php';
$list =$DB->query('theloai');
?>

<div class="col-md-6 col-12 pr-0" id="feed">
    <div class="p-20">

        <div class="card  mb-4">
            <!-- Body -->
            <div class="card-body mt-2">

                <div class="row">
                    <div class="col-lg-6 w-100">
                        <div class="media-mb d-flex">
                            <h5 class="card-title fs-30 mb-3">Quản lý thể loại</h5>
                            <div class="ms-auto"><button type="submit" data-bs-toggle="modal" data-bs-target="#add_the_loai" class="btn btn-success">Thêm thể loại</button></div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="add_the_loai" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="/api/admin/theloai/create" href="/admin/the-loai/list">
                                <div class="modal-header">
                                    <h5 class="modal-title">Thêm thể loại</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Tên thể loại:</label>
                                            <input type="text" name="name" value="" placeholder="Điền tên thể loại" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>logo:</label>
                                            <input type="text" name="logo" value="" placeholder="Điền đường dẫn biểu tượng" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>đường dẫn:</label>
                                            <input type="text" name="path" value="" placeholder="Điền đường dẫn thể loại" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>id thể loại:</label>
                                            <input type="text" name="id_theloai" value="" placeholder="Điền id thể loại" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Tạo thể loại</button>
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
                                        <th scope="col">Biểu tượng</th>
                                        <th scope="col">Tên thể loại</th>
                                        <th scope="col">Đường dẫn</th>
                                        <th scope="col">ID thể loại</th>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($list as $key => $value) :
                                    ?>
                                        <tr>
                                            <td><img width="32" src="<?=$value['logo'];?>"></td>
                                            <td><?=$value['name']; ?></td>
                                            <td><?=$value['path']; ?></td>
                                            <td><?=$value['id_theloai']; ?></td>

                                            <td><button type="button" data-bs-toggle="modal" data-bs-target="#edit_<?=$value['id']; ?>" class="btn btn-success">Chỉnh sửa</button>
                                                <div class="modal fade" id="edit_<?=$value['id']; ?>" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form method="POST" action="/api/admin/theloai/edit" href="/admin/the-loai/list">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"><?=$value['name'];?></h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="card-body">
                                                                        <div class="mb-3">
                                                                            <label>Biểu tượng:</label>
                                                                            <input type="text" name="logo" value="<?=$value['logo']; ?>" placeholder="Điền đường dẫn biểu tượng" class="form-control">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label>Tên thể loại:</label>
                                                                            <input type="text" name="name" value="<?=$value['name']; ?>" placeholder="Điền tên thể loại" class="form-control">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label>Đường dẫn:</label>
                                                                            <input type="text" name="path" value="<?=$value['path']; ?>" placeholder="Điền đường dẫn" class="form-control">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label>ID thể loại:</label>
                                                                            <input type="text" name="id_theloai" value="<?=$value['id_theloai']; ?>" placeholder="Điền ID thể loại" class="form-control">
                                                                        </div>
                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" id="delete_<?=$value['id']; ?>" class="btn btn-danger">Xóa Thể loại</button>
                                                                    <script>
                                                                        $("#delete_<?=$value['id']; ?>").click(function() {
                                                                            submitForm(
                                                                                '/api/admin/theloai/delete',
                                                                                'POST', {
                                                                                    id_theloai: $('#delete_<?=$value['id']; ?> ~ input[name="id_theloai_x"]').val()
                                                                                },
                                                                                null,
                                                                                '/admin/the-loai/list'
                                                                            );
                                                                        });
                                                                    </script>
                                                                    <input type="hidden" name="id_theloai_x" value="<?=$value['id_theloai']; ?>" />
                                                                    <input type="hidden" name="uid" value="<?=$value['id']; ?>" />
                                                                    <button type="submit" class="btn btn-success">Lưu thông tin</button>
                                                                </div>
                                                        </div>
                                                        </form>
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