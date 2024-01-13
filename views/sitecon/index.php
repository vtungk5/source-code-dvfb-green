<?php
include '../layout/head.php';
include '../layout/navbar.php';
include '../layout/sidebar.php';
$list = $DB->query('sitecon', ['username' => Auth::user()->username]);
?>

<div class="col-md-6 col-12 pr-0" id="feed">
    <div class="p-20">
        <div class="card  mb-4">
            <div class="card-body mt-2">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="media-mb ">
                            <h5 class="card-title fs-30 mb-3">Quản lý đại lý</h5>
                        </div>
                    </div>
                </div>

                <div class="alert text-pre-wrap alert-success-light">
                    <p>- Vui lòng trỏ đúng nameserver rồi mới thêm miền! </p>
                    <p>- Không được sử dụng miền vi phạm bản quyền , liên quan các bên pháp lý khác ! </p>
                    <p>- Nếu không thể trỏ miền hãy liên hệ admin để được hỗ trợ!</p>
                </div>


                <!-- Form -->
                <form method="POST" id="change_info" action="/api/dai-ly/them-ten-mien" href="/tao-dai-ly">

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="">Tên miền</label>
                            <input type="text" class="form-control" name="domain">
                        </div>
                        <div class="mb-3 col-md-6 ">
                            <label class="form-label" for="">Mật khẩu</label>
                            <div class="input-group">
                                <input class="form-control" type="password" name="password" value="">
                                <button type="submit" class="btn btn-signup" id="changeToken">Thêm</button>
                            </div>
                        </div>
                </form>
                <div class="mb-3 col-md-12 mb-2">
                    <label class="form-label" for="">Api Token</label>
                    <div class="input-group">
                        <input class="form-control" type="text" value="<?= Auth::user()->apikey; ?>" id="api_token" readonly="">
                        <button type="button" onclick="copy('api_token')" class="btn btn-signup" id="changeToken"> sao chép</button>
                    </div>
                </div>

            </div>


            <div class="mb-3 ">
                <div class="media-mb ">
                    <h5 class="card-title fs-30 mb-3">IP trỏ miền</h5>
                </div>
                <div class="alert text-white bg-success text-center" role="alert">
                    <h6>Nameserver1: <span class="namesv"><?= $_NS1; ?></span></h6>
                    <h6 class="mt-3">Nameserver2: <span class="namesv"><?= $_NS2; ?></span></h6>
                    <p>Lưu ý: Vui lòng trỏ đúng nameserver rồi mới thêm miền</p>
                </div>
            </div>
        </div>
    </div>
    <style>
        .namesv {
            background-color: #ffc000;
            margin-bottom: 9rem;
            align-items: center;
            padding-top: 1px;
            padding-right: 7px;
            padding-bottom: 4px;
            padding-left: 6px;
            border-radius: 6px;
        }
    </style>

</div>
</div>

<script type="text/javascript">
    <?php include 'item/app.js'; ?>
</script>
<?php
include '../layout/footer.php';
?>