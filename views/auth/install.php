<?php
include '../layout/head.php';
?>
<style type="text/css">
    <?php include 'item/app.css'; ?>
</style>
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
                <h3>Kích hoạt website</h3>
            </div>
            <div class="flex-group welcome__buttons">
                <form method="POST" action="/api/auth/install" href="/home">
                    <div class="mb-3">
                        <label class="form-label">Họ và tên ( Admin )</label>
                        <input type="text" name="name" class="form-control">
                    </div>  
                    <div class="mb-3">
                        <label class="form-label">Tài khoản ( Admin )</label>
                        <input type="text" name="username" class="form-control">
                    </div>  
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu( Admin )</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <?php if($SITEMAIN != $_SERVER['SERVER_NAME']): ?>
                    <div class="mb-3">
                        <label class="form-label">Apikey</label>
                        <input type="text" name="apikey" class="form-control">
                    </div>
                    <?php endif; ?>
                    <button type="submit" class="ant-btn btn-primary w-100 mb-3">Kích hoạt website</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    <?php include 'item/app.js'; ?>
</script>
<?php require '../layout/footer.php'; ?>