<div class="navbar">
    <button class="btn-v" data-sidebar="on">
        <i class="fa-solid fa-bars"></i>
    </button>
    <div class="logo-nav">
        <a href="/">
            <span class="logo-x1">GO</span>Z <span class="text-danger">Panel</span> 
        </a>
    </div>
    <div class="info-v">
        <?php if(!Auth::user()): ?>
        <a href="/auth/login" class="btn-v btn-signin">
            Đăng nhập
        </a>
        <a href="/auth/register" class="btn-v btn-signup">
            Đăng ký
        </a>
  
        <a class="btn-v dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
            aria-expanded="false" data-mobile="on">
            <img width="35" src="/assets/img/icon/7622533.png">
        </a>
        <ul class="dropdown-menu dropdown-info" aria-labelledby="navbarDropdown">
            <li><a href="/auth/login" class="dropdown-item">Đăng nhập</a></li>
            <li><a href="/auth/register" class="dropdown-item" >Đăng ký</a></li>
        </ul>
       <?php else: ?>
        <a class="btn-v dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
            aria-expanded="false" >
            <img width="35" src="/assets/img/icon/7622533.png">
        </a>
        <ul class="dropdown-menu users-menu dropdown-info" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="/account/info">Cài đặt tài khoản</a></li>
            <li><a class="dropdown-item" href="/tao-dai-ly">Tạo website ctv</a></li>
            <li><a class="dropdown-item" href="/nap-tien/chuyen-khoan">Nạp tiền tài khoản</a></li>
            <li><hr class="dropdown-divider" /></li>
            <li><a class="dropdown-item" href="/auth/logout">Đăng xuất</a></li>
        </ul>
        <?php endif; ?>
    </div>
</div>
<style type="text/css" ><?php include 'item/styles.css'; ?></style>
