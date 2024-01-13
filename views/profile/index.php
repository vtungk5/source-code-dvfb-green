<?php
include '../layout/head.php';

Auth::guest();
$list = $DB->query('history',['username'=>Auth::user()->username,'domain'=>$_SERVER['SERVER_NAME']]);

include '../layout/navbar.php';
include '../layout/sidebar.php';
?>
<div class="col-md-6 col-12 pr-0" id="feed">
    <div class="p-20">
        <div class="row">
            <div class="col-md-6 col-12">

                <div class="card mb-4">
                    <!-- Body -->
                    <div class="card-body">
                        <div class="card-box">
                            <h2 class="card-title h4 title-pages">
                                <div class="fs-20">Thông tin cá nhân</div>
                            </h2>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label" for="">Họ và tên</label>
                                <div class="input-group" id="demo">
                                    <input class="form-control" type="text" id="name" value="<?=Auth::user()->name; ?>" readonly="">
                                    <button type="button" class="btn btn-signup" id="edit-name"><i class="fa-regular fa-pen-to-square"></i></button>
                                </div>
                                <div id="edit-v" class="d-none">
                                    <div class="input-group">
                                        <input class="form-control" type="text" value="" id="hovaten" placeholder="Điền họ và tên">
                                        <button type="button" class="btn bg-danger text-white" id="edit-name2"><i class="fa-regular fa-circle-xmark"></i></button>
                                    </div>
                                    <button type="button" class="btn btn-signup w-100 mt-2" id="changeName"><i class="fa-regular fa-pen-to-square"></i> Lưu thông tin</button>
                                </div>
                            </div>
                            <div class="form-group col-md-6 ">
                                <label class="form-label" for="">Tài khoản</label>
                                <input type="text" class="form-control" value="<?=Auth::user()->username; ?>" readonly="">
                            </div>
                            <div class="form-group col-md-6 ">
                                <label class="form-label" for="">Số dư</label>
                                <input type="text" class="form-control" value="<?= format_money(Auth::user()->coin); ?> coin" readonly="">
                            </div>
                            <div class="form-group col-md-6 ">
                                <label class="form-label" for="">Cấp độ</label>
                                <input type="text" class="form-control" value="Thành viên" readonly="">
                            </div>
                            <div class="form-group col-md-6 ">
                                <label class="form-label" for="">IP đăng ký</label>
                                <input type="text" class="form-control" value="<?=Auth::user()->ip; ?>" readonly="">
                            </div>
                            <div class="form-group col-md-6 ">
                                <label class="form-label" for="">Thời gian tham gia</label>
                                <input type="text" class="form-control" value="<?=Auth::user()->date; ?>" readonly="">
                            </div>
                            <div class="form-group col-md-12 mb-2">
                                <label class="form-label" for="">Api Token</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" value="<?=Auth::user()->apikey; ?>" id="apikey" readonly="">
                                    <button type="button" class="btn btn-signup" id="changeApiKey"><i class="fa fa-exchange"></i> Thay đổi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">


                <div class="card mb-4">
                    <!-- Body -->
                    <div class="card-body">
                        <div class="card-box">
                            <h2 class="card-title h4 title-pages">
                                <div class="fs-20">Thay đổi mật khẩu</div>
                            </h2>
                        </div>

                        <!-- Form -->
                        <form id="change_password" method="POST" action="/api/profile/thay-doi-mat-khau">
                            <div class="form-group">
                                <label>Mật khẩu cũ:</label>
                                <input type="password" name="password" placeholder="Nhập mật khẩu cũ" value="" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Mật khẩu mới :</label>
                                <input type="password" name="new_password" placeholder="Nhập mật khẩu mới" value="" name="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nhập lại mật khẩu mới :</label>
                                <input type="password" name="confirm_password" placeholder="Nhập lại mật khẩu mới " value="" name="email" class="form-control">
                            </div>
                            <button class="btn btn-signup  button-ck w-100 mt-4 mb-4" type="submit">Cập nhật thông tin</button>
                        </form>
                    </div>
                </div>
            </div>
            <div>
                <div class="card mb-4">
                    <!-- Body -->
                    <div class="card-body">
                        <div class="card-box">
                            <h4 class="card-title h4 title-pages">
                                <div class="fs-20">Lịch sử đăng nhập</div>
                            </h4>
                        </div>

                        <table class="table table-cen mt-3">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">nội dung</th>
                                    <th scope="col">thời gian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i =1;
                                foreach($list as $key => $value):
                                ?>
                                    <tr>
                                        <td><a href="#">#<?=$i++;?></a></td>
                                        <td><?=$value['note']; ?></td>
                                        <td><?=timeago($value['date']);?></td>
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
<script type="text/javascript"><?php include 'item/app.js'; ?></script>
<?php include '../layout/footer.php'; ?>



