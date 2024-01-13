<?php
include '../layout/head.php';
include '../layout/navbar.php';
include '../layout/sidebar.php';

$post = $DB->query('post', ['domain' => $_SERVER['SERVER_NAME']]);

$order = $DB->num_rows('order', ['username' => Auth::user()->username, 'domain' => $_SERVER['SERVER_NAME']]);
$tungmmo2 = $DB->query('bank', ['username' => Auth::user()->username, 'domain' => $_SERVER['SERVER_NAME']]);
$tungmmo = $DB->query('napthe', ['username' => Auth::user()->username, 'domain' => $_SERVER['SERVER_NAME']]);
$money = 0;
foreach ($tungmmo as $tungcoder => $tungdev) :
    $money += $tungdev['amount'];
endforeach;
foreach ($tungmmo2 as $tungcoder2 => $tungdev2) :
    $money += $tungdev2['amount'];
endforeach;

?>
<div class="col-md-6 col-12 pr-0" id="feed">
    <div class="p-20">

        <div class="row">
            <div class="col-md-4 col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p class="card-text">Số dư</p>
                                <div class="d-flex align-items-end mb-2">
                                    <h4 class="card-title mb-0 me-2 money-text">
                                        <b class="text-danger">
                                            <?php if (!Auth::user()) : ?>
                                                0
                                            <?php else : echo format_money(Auth::user()->coin);
                                            endif; ?>
                                        </b> coin
                                    </h4>
                                </div>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-success rounded p-2">
                                    <!-- <img src="/public/img/icon/5002912.png" width="57" /> -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="56" viewBox="0 0 128 128" fill="none">
                                        <path d="M94.9213 54.9178C94.9213 67.9003 84.4076 78.4247 71.4382 78.4247C58.4688 78.4247 47.955 67.9003 47.955 54.9178C47.955 41.9353 58.4688 31.411 71.4382 31.411C84.4076 31.411 94.9213 41.9353 94.9213 54.9178Z" fill="#01C246" stroke="#3C3C3C" stroke-width="4" />
                                        <ellipse cx="56.4944" cy="74.1507" rx="23.4831" ry="23.5068" fill="white" stroke="#3C3C3C" stroke-width="4" />
                                        <path d="M56.5609 89.1096C55.9674 89.1096 55.466 88.9003 55.0567 88.4817C54.6473 88.0631 54.4427 87.5399 54.4427 86.9121V84.589L55.3636 85.4366C53.9924 85.3738 52.8054 85.1959 51.8026 84.9029C50.7998 84.6099 49.9812 84.3169 49.3467 84.0239C48.8146 83.7727 48.436 83.4169 48.2109 82.9565C48.0062 82.4961 47.9243 82.0252 47.9653 81.5438C48.0267 81.0624 48.2006 80.6229 48.4872 80.2253C48.7737 79.8276 49.1421 79.566 49.5923 79.4405C50.063 79.294 50.6054 79.3567 51.2193 79.6288C51.6286 79.859 52.2426 80.0997 53.0612 80.3509C53.9003 80.5811 54.9339 80.6962 56.1618 80.6962C57.0214 80.6962 57.6967 80.6125 58.1879 80.445C58.6996 80.2776 59.0577 80.0579 59.2624 79.7858C59.4875 79.4928 59.6 79.1788 59.6 78.844C59.6 78.53 59.5182 78.2684 59.3545 78.0591C59.2112 77.8289 58.9656 77.6301 58.6177 77.4627C58.2698 77.2743 57.7888 77.1069 57.1749 76.9604L53.7059 76.2069C51.8026 75.7674 50.3802 75.0349 49.4388 74.0094C48.5179 72.963 48.0574 71.6131 48.0574 69.9597C48.0574 68.7039 48.3541 67.5843 48.9476 66.6006C49.5616 65.596 50.4109 64.7798 51.4956 64.1519C52.6008 63.5241 53.8901 63.1264 55.3636 62.959L54.4427 63.4927V61.3893C54.4427 60.7614 54.6473 60.2382 55.0567 59.8196C55.466 59.4011 55.9674 59.1918 56.5609 59.1918C57.1749 59.1918 57.6865 59.4011 58.0958 59.8196C58.5051 60.2382 58.7098 60.7614 58.7098 61.3893V63.4927L57.7888 62.8962C58.5665 62.9171 59.4056 63.0532 60.3061 63.3043C61.2066 63.5345 61.9945 63.8589 62.6699 64.2775C63.1406 64.5286 63.4681 64.874 63.6523 65.3135C63.8569 65.753 63.9286 66.2029 63.8672 66.6634C63.8262 67.1029 63.6625 67.5005 63.376 67.8563C63.1099 68.2121 62.7415 68.4528 62.2708 68.5784C61.8206 68.683 61.2782 68.5993 60.6438 68.3272C60.1731 68.1179 59.641 67.9505 59.0475 67.8249C58.4744 67.6784 57.7377 67.6052 56.8372 67.6052C55.7525 67.6052 54.9134 67.804 54.3199 68.2017C53.7468 68.5993 53.4603 69.1121 53.4603 69.7399C53.4603 70.1585 53.6241 70.5143 53.9515 70.8073C54.2994 71.0794 54.9236 71.3201 55.8241 71.5293L59.3238 72.3142C61.268 72.7537 62.7006 73.4862 63.6216 74.5117C64.563 75.5163 65.0337 76.8243 65.0337 78.4359C65.0337 79.6916 64.7369 80.8008 64.1434 81.7636C63.5499 82.7263 62.7211 83.5111 61.6569 84.1181C60.6131 84.725 59.3954 85.1226 58.0037 85.311L58.7098 84.5576V86.9121C58.7098 87.5399 58.5051 88.0631 58.0958 88.4817C57.707 88.9003 57.1953 89.1096 56.5609 89.1096Z" fill="#3C3C3C" />
                                        <path d="M39.7618 28.5519C40.5425 27.7705 40.5425 26.5035 39.7618 25.7221C38.9811 24.9406 37.7155 24.9406 36.9348 25.7221L39.7618 28.5519ZM17.1358 46.3699C17.1358 47.475 18.0308 48.3709 19.1348 48.3709L37.1257 48.3709C38.2297 48.3709 39.1247 47.475 39.1247 46.3699C39.1247 45.2647 38.2297 44.3689 37.1257 44.3689L21.1338 44.3689L21.1338 28.3608C21.1338 27.2557 20.2388 26.3598 19.1348 26.3598C18.0308 26.3598 17.1358 27.2557 17.1358 28.3608L17.1358 46.3699ZM36.9348 25.7221L17.7213 44.9549L20.5483 47.7848L39.7618 28.5519L36.9348 25.7221Z" fill="#3C3C3C" />
                                        <path d="M89.2382 99.4481C88.4575 100.23 88.4575 101.496 89.2382 102.278C90.0188 103.059 91.2845 103.059 92.0652 102.278L89.2382 99.4481ZM111.864 81.6301C111.864 80.525 110.969 79.6291 109.865 79.6291L91.8742 79.6291C90.7702 79.6291 89.8752 80.525 89.8752 81.6301C89.8752 82.7353 90.7702 83.6311 91.8742 83.6311L107.866 83.6311L107.866 99.6392C107.866 100.744 108.761 101.64 109.865 101.64C110.969 101.64 111.864 100.744 111.864 99.6392L111.864 81.6301ZM92.0652 102.278L111.279 83.0451L108.452 80.2152L89.2382 99.4481L92.0652 102.278Z" fill="#3C3C3C" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p class="card-text">Đã nạp</p>
                                <div class="d-flex align-items-end mb-2">
                                    <h4 class="card-title mb-0 me-2 money-text">
                                        <b class="text-danger">
                                            <?php if (!Auth::user()) : ?>
                                                0
                                            <?php else : echo format_money($money);
                                            endif; ?>
                                        </b> coin
                                    </h4>
                                </div>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-primary rounded p-2">
                                    <!-- <img src="/public/img/icon/3153510.png" width="56" /> -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="56" viewBox="0 0 128 128" fill="none">
                                        <rect x="66" y="67" width="28" height="28" fill="#01C246" />
                                        <rect x="32" y="32" width="64" height="64" rx="6" stroke="#3C3C3C" stroke-width="4" />
                                        <line x1="32" y1="65" x2="96" y2="65" stroke="#3C3C3C" stroke-width="4" />
                                        <line x1="65" y1="32" x2="65" y2="96" stroke="#3C3C3C" stroke-width="4" />
                                        <path d="M48.5055 56.104C47.6468 56.104 47.2175 55.6653 47.2175 54.788V50.196H42.7095C41.8695 50.196 41.4495 49.7853 41.4495 48.964C41.4495 48.1427 41.8695 47.732 42.7095 47.732H47.2175V43.28C47.2175 42.4213 47.6468 41.992 48.5055 41.992C49.3641 41.992 49.7935 42.4213 49.7935 43.28V47.732H54.3015C55.1415 47.732 55.5615 48.1427 55.5615 48.964C55.5615 49.7853 55.1415 50.196 54.3015 50.196H49.7935V54.788C49.7935 55.6653 49.3641 56.104 48.5055 56.104Z" fill="#3C3C3C" />
                                        <path d="M77.0087 51.806C76.5247 51.806 76.1177 51.652 75.7877 51.344C75.4797 51.014 75.3257 50.618 75.3257 50.156C75.3257 49.672 75.4797 49.276 75.7877 48.968C76.1177 48.66 76.5247 48.506 77.0087 48.506H84.0377C84.4997 48.506 84.8847 48.66 85.1927 48.968C85.5227 49.276 85.6877 49.672 85.6877 50.156C85.6877 50.618 85.5227 51.014 85.1927 51.344C84.8847 51.652 84.4997 51.806 84.0377 51.806H77.0087Z" fill="#3C3C3C" />
                                        <path d="M43.9773 88.13C43.596 88.13 43.2753 88.026 43.0153 87.818C42.7726 87.5927 42.6426 87.3067 42.6253 86.96C42.6253 86.6133 42.7726 86.2493 43.0673 85.868L46.6553 81.448L43.3273 77.34C43.0153 76.9587 42.868 76.5947 42.8853 76.248C42.9026 75.9013 43.0326 75.624 43.2753 75.416C43.5353 75.1907 43.856 75.078 44.2373 75.078C44.636 75.078 44.9653 75.1473 45.2253 75.286C45.5026 75.4247 45.754 75.6413 45.9793 75.936L48.5273 79.212L51.1013 75.936C51.344 75.6413 51.5953 75.4247 51.8553 75.286C52.1153 75.1473 52.436 75.078 52.8173 75.078C53.216 75.078 53.5366 75.1907 53.7793 75.416C54.022 75.6413 54.1433 75.9273 54.1433 76.274C54.1606 76.6207 54.0133 76.9847 53.7013 77.366L50.3733 81.448L53.9873 85.868C54.2993 86.232 54.4466 86.5873 54.4293 86.934C54.412 87.2807 54.2733 87.5667 54.0133 87.792C53.7706 88.0173 53.45 88.13 53.0513 88.13C52.358 88.13 51.786 87.844 51.3353 87.272L48.5013 83.71L45.6933 87.272C45.468 87.5493 45.2253 87.766 44.9653 87.922C44.7053 88.0607 44.376 88.13 43.9773 88.13Z" fill="#3C3C3C" />
                                        <path d="M75.6231 79.082C74.8431 79.082 74.4531 78.7007 74.4531 77.938C74.4531 77.1753 74.8431 76.794 75.6231 76.794H86.3871C87.1671 76.794 87.5571 77.1753 87.5571 77.938C87.5571 78.7007 87.1671 79.082 86.3871 79.082H75.6231ZM75.6231 84.256C74.8431 84.256 74.4531 83.8747 74.4531 83.112C74.4531 82.3667 74.8431 81.994 75.6231 81.994H86.3871C87.1671 81.994 87.5571 82.3667 87.5571 83.112C87.5571 83.8747 87.1671 84.256 86.3871 84.256H75.6231Z" fill="white" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p class="card-text">Đã mua</p>
                                <div class="d-flex align-items-end mb-2">
                                    <h4 class="card-title mb-0 me-2 money-text">
                                        <b class="text-danger"><?php if (!Auth::user()) : ?>
                                                0
                                            <?php else : echo format_money($order);
                                                                endif; ?>
                                        </b> đơn
                                    </h4>
                                </div>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-primary rounded p-2">
                                    <!-- <img src="/public/img/icon/3083638.png" width="56" /> -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="56" viewBox="0 0 128 128" fill="none">
                                        <path d="M59.9978 32.3951C53.0759 32.4732 46.3326 34.6022 40.6207 38.5128C34.9087 42.4234 30.4847 47.9399 27.908 54.3649C25.3313 60.7898 24.7177 67.8345 26.1447 74.6081C27.5718 81.3818 30.9754 87.5802 35.9252 92.4194C40.8749 97.2587 47.1486 100.522 53.9527 101.795C60.7569 103.069 67.7859 102.296 74.151 99.5754C80.5161 96.8543 85.9314 92.3068 89.712 86.5081C93.4927 80.7093 95.4688 73.9196 95.3907 66.9977L60.3929 67.3929L59.9978 32.3951Z" fill="white" stroke="#3C3C3C" stroke-width="4" />
                                        <path d="M67.9978 25.3951C72.5938 25.3432 77.155 26.1971 81.4209 27.9079C85.6869 29.6188 89.5742 32.1532 92.8607 35.3663C96.1472 38.5795 98.7687 42.4085 100.575 46.6348C102.382 50.861 103.339 55.4018 103.391 59.9977L68.3929 60.3929L67.9978 25.3951Z" fill="#01C246" stroke="#3C3C3C" stroke-width="4" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="mb-3 row ">

            <div class="col-lg-9 col-xlg-9 col-md-7">
                <?php if (Auth::admin_main()) : ?>
                    <form class="d-flex flex-column comment-section mb-1 " method="POST" href="home" action="api/bai-viet/create">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="d-flex align-items-center">
                                        <h6>Đăng bài viết mới</h6>
                                    </div>
                                </div>
                                <textarea name="note" id="note" rows="10" cols="80" class="form-control"></textarea>
                                <script>
                                    CKEDITOR.replace('note');
                                </script>
                                <div class="d-flex gap-1 mt-4">
                                    <div class="ms-auto">
                                        <button type="submit" class="btn btn-success2">Đăng bài</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
                <?php foreach ($post as $key => $value) : ?>
                    <div class="d-flex flex-column comment-section mb-1 ">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-3">
                                            <img width="35" src="/assets/img/icon/7893923.png" alt="Avatar" class="rounded-circle">
                                        </div>
                                        <div class="me-2">
                                            <h6 class="mb-0 h1-rem name-sidebar"><?= $value['name']; ?>
                                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="tài khoản đã xác minh">
                                                    <i class="fa-duotone fa-badge-check verify"></i>
                                                </span>
                                            </h6>
                                            <small class="text-muted"><?= $value['date']; ?></small>
                                        </div>
                                    </div>
                                </div>
                                <?= $value['note']; ?>
                                <div class="d-flex gap-1 mt-4">
                                    <a href="#" class="btn btn-label-secondary" title="" data-bs-toggle="tooltip" data-bs-original-title="Like">
                                        <i class="fa-solid fa-heart"></i>&nbsp;1000
                                    </a>
                                    <a href="#" class="btn btn-label-secondary" title="" data-bs-toggle="tooltip" data-bs-original-title="Comments">
                                        <i class="fa-solid fa-comment"></i>&nbsp;1000
                                    </a>
                                    <a href="#" class="btn btn-label-secondary" title="" data-bs-toggle="tooltip" data-bs-original-title="Share">
                                        <i class="fa-solid fa-share"></i>&nbsp;1000
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;  ?>



            </div>

            <div class="col-lg-3 col-xlg-3 col-md-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="ribbon-title ribbon-primary">Nâng VIP</div>
                                <div class="mt-4">
                                    <center class="mb-2">
                                        <img src="/assets/img/icon/6650064.png" alt="" width="80" height="80">
                                    </center>
                                    <div class="text-center mb-3">
                                        <h5>
                                            Nâng cấp bậc!
                                        </h5>
                                        <p class="text-soft">Vui lòng nạp tiền để nâng cấp bậc để nhận nhiều ưu đãi , giảm giá hơn</p>
                                    </div>
                                    <div class="d-grid gap-2 col-12 mx-auto">
                                        <a href="/nap-tien/chuyen-khoan" class="btn btn-success2">Nâng
                                            ngay nào</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
</div>
<script type="text/javascript">
    <?php if(!empty(Site::get('notify'))): ?>
    
  Swal.fire({
    text: '<?=Site::get('notify'); ?>',
    icon: 'info',
    confirmButtonText: 'Đồng ý',
  });
    <?php endif; ?>
    <?php include 'item/app.js'; ?>
</script>
<?php include '../layout/footer.php'; ?>