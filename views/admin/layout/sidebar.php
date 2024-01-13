<div class="main ">
    <div class="flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-3 col-12 pr-0 admin-sidebar" id="sidebar">
                <div class="h-100 mb-3">
                    <ul class="h-100 mt-4">
                        <li class="mb-2 ">
                            <ul class="pl-0 mt-1" id="menu-oven">
                                <li class="mb-2">
                                    <a href="/admin/" class="nav-link">
                                        <i class="fa-regular fa-gauge-circle-bolt"></i>
                                        Trang thống kê
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="/admin/thanh-vien/list" class="nav-link">
                                        <i class="fa-sharp fa-solid fa-users"></i>
                                        Quản lý thành viên
                                    </a>
                                </li>
                                <?php if (Auth::admin_main_site()) : ?>
                                    <li class="mb-2">
                                        <a href="/admin/the-loai/list" class="nav-link">
                                            <i class="fa-solid fa-shop"></i>
                                            Quản lý thể loại
                                        </a>
                                    </li>
                                    <li class="mb-2">
                                        <a href="/admin/dich-vu/list" class="nav-link">
                                            <i class="fa-solid fa-bars-progress"></i>
                                            Quản lý dịch vụ
                                        </a>
                                    </li>
                                    <li class="mb-2">
                                        <a href="/admin/daily/list" class="nav-link">
                                            <i class="fa-solid fa-browser"></i>
                                            Quản lý site con
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li class="mb-2">
                                        <a href="/admin/lienhe/list" class="nav-link">
                                        <i class="fa-regular fa-headset"></i>
                                            Quản lý liên hệ
                                        </a>
                                    </li>
                                <li class="mb-2">
                                    <a href="/admin/server/list" class="nav-link">
                                        <i class="fa-light fa-server"></i>
                                        Quản lý server
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="/admin/order/list" class="nav-link">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                        Quản lý đơn
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="/admin/naptien/thecao" class="nav-link">
                                        <i class="fa-regular fa-file-invoice"></i>
                                        Quản lý thẻ cào
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="/admin/naptien/chuyenkhoan" class="nav-link">
                                        <i class="fa-solid fa-credit-card"></i>
                                        Quản lý chuyển khoản
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="/admin/setting" class="nav-link">
                                        <i class="fa-solid fa-hammer"></i>
                                        Cấu hình website
                                    </a>
                                </li>
                            </ul>
                </div>
            </div>