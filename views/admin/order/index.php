<?php
include '../../layout/head.php';
Auth::admin();
include '../layout/navbar.php';
include '../layout/sidebar.php';
if (!Auth::admin_main_site()) :
    $list = $DB->query('order', ['domain' => $_SERVER['SERVER_NAME']]);
else :
    $list = $DB->query('order');
endif;

?>
<div class="col-md-6 col-12 pr-0" id="feed">
    <div class="p-20">

        <div class="card  mb-4">
            <!-- Body -->
            <div class="card-body mt-2">

                <div class="row">
                    <div class="col-lg-6 w-100">
                        <div class="media-mb d-flex">
                            <h5 class="card-title fs-30 mb-3">Quản lý đơn</h5>
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
                                        <th scope="col">UID</th>
                                        <th scope="col">Thể loại</th>
                                        <th scope="col">Dịch vụ</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col">Thành tiền</th>
                                        <th scope="col">trạng thái</th>
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
                                            <td><?= $value['MGD']; ?></td>
                                            <td><?= $value['username']; ?></td>
                                            <td><?= $value['uid']; ?></td>
                                            <td><?= $DB->query_one('theloai', ['id_theloai' => $value['id_theloai']])['name']; ?></td>
                                            <td><?= $DB->query_one('service', ['id_dv' => $value['id_dv']])['name']; ?></td>
                                            <td><?= $value['amount']; ?></td>
                                            <td><?= format_money($value['money']); ?></td>
                                            <td><?= buy_status2($value['status']); ?></td>
                                            <td><?= $value['date']; ?></td>

                                            <td><button type="button" data-bs-toggle="modal" data-bs-target="#edit_<?= $value['id']; ?>" class="btn btn-success">Chi tiết</button>
                                                <div class="modal fade" id="edit_<?= $value['id']; ?>" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form method="POST" action="/api/admin/order/duyet" >
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">#<?=$value['MGD'];?> - <?=$value['username'];?></h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="card-body">
                                                                        <div class="mb-3">
                                                                            <label>UID/LINK:</label>
                                                                            <input type="text"  value="<?= $value['uid']; ?>" class="form-control" disabled>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label>Thể loại</label>
                                                                            <input type="text" value="<?= $DB->query_one('theloai', ['id_theloai' => $value['id_theloai']])['name'];  ?>" class="form-control" disabled>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label>Dịch vụ:</label>
                                                                            <input type="text" value="<?= $DB->query_one('service', ['id_dv' => $value['id_dv']])['name'];?>" class="form-control" disabled>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label>Số lượng:</label>
                                                                            <input type="text" value="<?= $value['amount']; ?>" class="form-control" disabled>
                                                                        </div>    
                                                                        <div class="mb-3">
                                                                            <label>Tốc độ ( nếu có ):</label>
                                                                            <input type="text" value="<?= $value['speed']; ?>" class="form-control" disabled>
                                                                        </div> 
                                                                        <div class="mb-3">
                                                                            <label>Bình luận ( nếu có ):</label>
                                                                            <input type="text" value="<?= $value['comment']; ?>" class="form-control" disabled>
                                                                        </div> 
                                                                        <div class="mb-3">
                                                                            <label>Bot cảm xúc ( nếu có ):</label>
                                                                            <input type="text" value="<?= $value['reaction']; ?>" class="form-control" disabled>
                                                                        </div> 
                                                                       <div class="mb-3">
                                                                            <label>Thành tiền:</label>
                                                                            <input type="text"  value="<?= $value['id_dv']; ?>" class="form-control" disabled>
                                                                        </div>    
                                                                        <div class="mb-3">
                                                                            <label>Trạng thái :</label>
                                                                            <select name="status" class="form-control">
                                                                                <option value="<?= $value['status']; ?>">Chọn trạng thái</option>
                                                                                <option value="true">Thành công</option>
                                                                                <option value="false">Chờ duyệt</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="uid" value="<?= $value['id']; ?>" />

                                                                <div class="modal-footer"> 
                                                                    <?php if($value['status'] == 'false' && Auth::admin_main_site()): ?>
                                                                        <button type="submit" class="btn btn-success">Duyệt</button>
                                                                    <?php endif; ?>
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