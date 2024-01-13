<?php
include '../../layout/head.php';
Auth::admin();
include '../layout/navbar.php';
include '../layout/sidebar.php';
$list = $DB->query_one('site', ['domain' => $_SERVER['SERVER_NAME']]);

?>
<div class="col-md-6 col-12 pr-0" id="feed">
    <div class="p-20">

        <div class="card  mb-4">
            <!-- Body -->
            <div class="card-body mt-2">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="media-mb ">
                            <h5>Cài đặt website</h5>
                        </div>
                    </div>
                </div>
                <!-- Body -->
                <div class="card-body">
                    <!-- Form -->
                    <form method="POST" action="/api/admin/setting/edit">
                        <div class="mb-3">
                            <label class="mb-2">LOGO website :</label>
                            <textarea name="logo"  rows="1"  cols="1" class="form-control"><?=$list['logo'];?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="mb-2">Tên website :</label>
                            <input type="text" placeholder="Nhập tiêu đề " value="<?=$list['title'];?>" name="title" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="mb-2">Mô tả :</label>
                            <textarea name="description" rows="5" class="form-control"><?=$list['description'];?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="mb-2">Từ khóa :</label>
                            <textarea name="keyword" rows="5" placeholder="Nhập từ khóa" class="form-control"><?=$list['keyword'];?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="mb-2">Partner ID (thesieure.com) :</label>
                            <input type="text" placeholder="Nhập partner id "  value="<?=$list['partner_id'];?>" name="partner_id" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="mb-2">Partner KEY (thesieure.com) :</label>
                            <input type="text" placeholder="Nhập partner key " value="<?=$list['partner_key'];?>" name="partner_key" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="mb-2">Chủ tài khoản ( MOMO ) - (api.dailysieure.com):</label>
                            <input type="text" placeholder="Nhập tên chủ tài khoản" value="<?=$list['name_momo'];?>"  name="name_momo" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="mb-2">Số tài khoản ( MOMO ) - (api.dailysieure.com):</label>
                            <input type="text" placeholder="Nhập số tài khoản" value="<?=$list['stk_momo'];?>"  name="stk_momo" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="mb-2">APIKEY ( MOMO ) - (api.dailysieure.com):</label>
                            <input type="text" placeholder="Nhập Apikey momo" value="<?=$list['apikey_momo'];?>" name="apikey_momo" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="mb-2">Số tài khoản ( MB BANK) - (api.dailysieure.com):</label>
                            <input type="text" placeholder="Nhập số tài khoản" value="<?=$list['stk_mb'];?>"  name="stk_mb" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="mb-2">Chủ tài khoản ( MB BANK ) - (api.dailysieure.com):</label>
                            <input type="text" placeholder="Nhập tên chủ tài khoản" value="<?=$list['name_mb'];?>"  name="name_mb" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="mb-2">Tên đăng nhập (MB BANK) - (api.dailysieure.com):</label>
                            <input type="text" placeholder="Nhập tên đăng nhập" value="<?=$list['username_mb'];?>" name="username_mb" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="mb-2">Mật khẩu đăng nhập ( MB BANK )- (api.dailysieure.com):</label>
                            <input type="text" placeholder="Nhập mật khẩu đăng nhập" value="<?=$list['password_mb'];?>" name="password_mb" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="mb-2">Giảm giá ctv:</label>
                            <input type="text" placeholder="Nhập giảm giá ctv" value="<?=$list['rate_ctv'];?>" name="rate_ctv" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="mb-2">Giảm giá đại lý :</label>
                            <input type="text" placeholder="Nhập giảm giá đại lý " value="<?=$list['rate_daily'];?>"  name="rate_daily" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="mb-2">Min ctv:</label>
                            <input type="text" placeholder="Nhập min ctv" value="<?=$list['coin_ctv'];?>" name="coin_ctv" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="mb-2">Min đại lý :</label>
                            <input type="text" placeholder="Nhập min đại lý" value="<?=$list['coin_daily'];?>"  name="coin_daily" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="mb-2">Thông báo:</label>
                            <textarea name="notify"  rows="10"  cols="80" class="form-control"><?=$list['notify'];?></textarea>
                        </div>
                        <button id="send" type="submit" class="btn btn-buy w-100 ">Cập nhập</button>
                    </form>
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