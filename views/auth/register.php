<?php
   include '../layout/head.php';
   Auth::next();
?>
<style type="text/css"><?php include 'item/app.css';?></style>
<div class="welcome">
    <div class="bg-welcome"></div>
    <div class="auth-welcome">
        <div class="welcome__select-wrapper">
            <div class="logo-nav">
                <a href="/">
                     <?=Site::get('logo');?>
                </a>
            </div>

            <div class="welcome__note mb-3">
                <h3>Đăng ký tài khoản</h3>
            </div>
            <div class="flex-group welcome__buttons">
                <form method="POST" action="/api/auth/register" href="/home">
                    <div class="mb-3">
                        <label class="form-label">Họ và tên</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tài khoản</label>
                        <input type="text" name="username" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" >
                    </div>

                    <button type="submit" class="ant-btn btn-primary w-100 mb-3">Đăng ký tài khoản</button>
                    <p class="mt-2 fs-14 text-center">Đã có tài khoản? <a href="/auth/login">Đăng nhập</a></p>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><?php include 'item/app.js'; ?></script>
<?php require '../layout/footer.php'; ?>