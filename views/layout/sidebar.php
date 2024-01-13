<?php
    $theloai = $DB->query('theloai');
    $lienhe = $DB->query('lienhe',['domain' => $_SERVER['SERVER_NAME']]);
    // require_once $_SERVER['DOCUMENT_ROOT'].'/api/cron/mbbank.php';
    // require_once $_SERVER['DOCUMENT_ROOT'].'/api/cron/momo.php';
?>    
<div class="main">
    <div class="flex-grow-1 container-p-y">
        <div class="row">

            <div class="col-md-3 col-12 pr-0 " id="sidebar">
                <div class="h-100 mb-3">
                    <ul class="h-100 mt-4">
                        <li class="mb-2 ">
                            <a href="/profile/info" class="nav-link d-flex align-items-center p-item-menu info-side">
                                <img class="mr-05rem rounded-circle mr-0-5" width="40" src="/assets/img/icon/7893923.png">
                                <div>
                                    <h6 class="mb-0 fs-17 h-1-2 name-sidebar">
                                    <?php if (!Auth::user()) : ?> Vương Thanh Tùng <?php else : echo Auth::user()->name;  endif; ?>
                                    </h6>
                                    <span>
                                        <span class="badge text-bg-success">Số dư
                                            <span class="text-white">                   
                                            <?php if (!Auth::user()) : ?> 0<?php else : echo format_money(Auth::user()->coin);  endif; ?>
                                            </span>
                                            coin
                                        </span>
                                    </span>
                                </div>
                            </a>
                        </li>
                        <li class="mb-2 ">
                        <li class="type-menu">MENU</li>
                        <ul class="pl-0 mt-1" id="menu-oven">
                            <li class="mb-2">
                                <a href="/home" class="nav-link">
                                    <img width="30" src="/assets/img/icon/7135166.png">
                                    Trang chủ
                                </a>
                            </li>
                            <?php if(Auth::user() == true && Auth::user()->level > 2): ?>
                            <li class="mb-2">
                                <a href="/admin/" class="nav-link">
                                    <img width="30" src="/assets/img/icon/6214229.png">
                                     Quản trị viên
                                </a>
                            </li>
                            <?php endif; ?>
                           <!-- 
                            <li class="mb-2">
                                <a href="/add/domain" class="nav-link">
                                    <img width="30" src="/assets/img/icon/6742595.png">
                                    Mua tên miền
                                </a>
                            </li> -->
                            <li class="mb-2">
                                <a href="/tao-dai-ly" class="nav-link">
                                    <img width="30" src="/assets/img/icon/6742696.png">
                                    Tạo website CTV
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="/profile/info" class="nav-link">
                                    <img width="30" src="/assets/img/icon/6069737.png">
                                    Thông tin tài khoản
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="nav-link dropdown dropdown-sidebar" path="/nap-tien/" role="button"data-bs-toggle="dropdown" aria-expanded="false">
                                    <img width="30" src="/assets/img/icon/5203973.png">
                                    Nạp tiền tài khoản
                                </a>
                                <ul class="dropdown-menu dropdown-type " aria-labelledby="dichvu">
                                    <li>
                                        <a href="/nap-tien/chuyen-khoan" class="nav-item">
                                            Chuyển khoản
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/nap-tien/nap-the-cao" class="nav-item">
                                            Nạp thẻ cào
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="nav-link dropdown dropdown-sidebar" role="button"data-bs-toggle="dropdown" aria-expanded="false">
                                    <img width="30" src="/assets/img/icon/870175.png">
                                    Liên hệ hỗ trợ
                                </a>
                                <ul class="dropdown-menu dropdown-type " aria-labelledby="dichvu">
                                   <?php foreach($lienhe as $keyy => $valuey): ?>
                                    <li>
                                        <a href="<?=$valuey['path']; ?>" class="nav-item">
                                           <?=$valuey['name']; ?>
                                        </a>
                                    </li>
                                    <?php endforeach;?>
                                </ul>
                            </li>
                            <li class="type-menu mb-2">DỊCH VỤ</li>
                            <?php foreach($theloai as $key=> $value): ?>
                            <li class="mb-2">
                                <a class="nav-link dropdown dropdown-sidebar" path="/service/<?=$value['path']; ?>/" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img width="24" src="<?=$value['logo']; ?>">
                                    <?=$value['name']; ?>
                                </a>
                                <ul class="dropdown-menu dropdown-type " aria-labelledby="dichvu">
                                    <?php     
                                        $service = $DB->query('service',['status'=>'ON','id_theloai'=>$value['id_theloai']]);
                                        foreach($service as $key2 => $value2):
                                    ?>
                                    <li>
                                        <a href="/service/<?=$value['path']; ?>/<?=$value2['path']; ?>" class="nav-item">
                                            <?=$value2['name'];?>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>   
                           <?php endforeach; ?>
                        </ul>
                        </li>
                    </ul>
                </div>
            </div>