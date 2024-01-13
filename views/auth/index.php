<?php
   include '../layout/head.php';
?>
    <div class="welcome">
        <div class="bg-welcome">
        </div>

        <div class="auth-welcome">
            <div class="welcome__select-wrapper">
                <div class="logo-nav">
                    <a href="/">
                        <?=Site::get('logo');?>
                    </a> 
                </div>

                <div class="welcome__note">
                    <h3>Chưa học xong chưa đi ngủ</h3>
                </div>
                <label class="welcome__action">Tham gia ngay.</label>
                <div class="flex-group welcome__buttons">
                    <a class="btn-link" href="/auth/register">
                        <button type="button" class="ant-btn btn-primary">
                            <span>Đăng ký</span>
                        </button>
                    </a>
                    <a class="btn-link" href="/auth/login">
                        <button type="button" class="ant-btn btn-outline-primary">
                            <span>Đăng nhập</span>
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php require '../layout/footer.php'; ?>