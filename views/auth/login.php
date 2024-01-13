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
                <h3>Đăng nhập tài khoản</h3>
            </div>
            <div class="flex-group welcome__buttons">
                <form method="POST" action="/api/auth/login" href="/home">
                    <div class="mb-3">
                        <label for="username" class="form-label">Tài khoản</label>
                        <input type="text" name="username" class="form-control" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" name="password"  class="form-control" >
                    </div>

                    <button type="submit" name="submit" class="ant-btn btn-primary w-100 mb-3">Đăng nhập tài khoản</button>
                    <p class="mt-2 fs-14 text-center">Chưa có tài khoản? <a href="/auth/register">Tạo tài khoản mới</a></p>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><?php include 'item/app.js'; ?></script>
<?php require '../layout/footer.php'; ?>