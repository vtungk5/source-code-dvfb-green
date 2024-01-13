<?php
include '../../layout/head.php';
Auth::admin();
include '../layout/navbar.php';
include '../layout/sidebar.php';
$list = $DB->query('lienhe', ['domain' => $_SERVER['SERVER_NAME']]);

?>
<div class="col-md-6 col-12 pr-0" id="feed">
    <div class="p-20">

        <div class="card  mb-4">
            <!-- Body -->
            <div class="card-body mt-2">

            <div class="row">
                    <div class="col-lg-6 w-100">
                        <div class="media-mb d-flex">
                            <h5 class="card-title fs-30 mb-3">Quản lý liên hệ</h5>
                           <div class="ms-auto"><button type="submit" data-bs-toggle="modal" data-bs-target="#add_lien_he" class="btn btn-success">Thêm liên hệ</button></div> 
                        </div>
               
                    <div class="modal fade" id="add_lien_he" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="/api/admin/lienhe/create" href="/admin/lienhe/list">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Thêm liên hệ</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label>Tên liên hệ:</label>
                                                <input type="text" name="name" value="" placeholder="Điền tên liên hệ" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label>đường dẫn:</label>
                                                <input type="text" name="path" value="" placeholder="Điền đường dẫn liên hệ" class="form-control">
                                            </div>
                                        
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Thêm liên hệ</button>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
            </div>
                <div class="form-group mt-3">
                    <div class="card-box" style="padding-top: 0px;">
                        <div class="mb-3">
                            <table class="table green-bg table-cen">
                                <thead>
                                    <tr>
                                        <th scope="col">Tên liên hệ</th>
                                        <th scope="col">đường dẫn</th>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($list as $key => $value) :
                                    ?>
                                        <tr>
                                            <td><?= $value['name']; ?></td>
                                            <td><?= $value['path']; ?></td>
                                            <td><button type="button" data-bs-toggle="modal" data-bs-target="#edit_<?= $value['id']; ?>" class="btn btn-success">Chỉnh sửa</button>
                                                <div class="modal fade" id="edit_<?= $value['id']; ?>" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form method="POST" action="/api/admin/lienhe/edit" >
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"><?=$value['name'];?></h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="card-body">
                                                                        <div class="mb-3">
                                                                            <label>Tên liên hệ:</label>
                                                                            <input type="text" name="name" value="<?= $value['name']; ?>" placeholder="Điền tên liên hệ" class="form-control">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label>đường dẫn:</label>
                                                                            <input type="text" name="path" value="<?= $value['path']; ?>" placeholder="Điền đường dẫn liên hệ" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">

                                                                    <button type="button" id="delete_<?= $value['id']; ?>" class="btn btn-danger">Xóa liên hệ</button>
                                                                    <script>
                                                                        $("#delete_<?= $value['id']; ?>").click(function() {
                                                                            submitForm(
                                                                                '/api/admin/lienhe/delete',
                                                                                'POST', {
                                                                                    uid: $('#delete_<?= $value['id']; ?> ~ input[name="uid"]').val()
                                                                                },
                                                                                null,
                                                                                '/admin/lienhe/list'
                                                                            );
                                                                        });
                                                                    </script>
                                                                    <input type="hidden" name="uid" value="<?=$value['id']; ?>" />
                                                                    <button type="submit" class="btn btn-success">Lưu thông tin</button>
                                                                </div>
                                                        </div>
                                                        </form>
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