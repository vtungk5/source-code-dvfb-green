<?php 
   include '../layout/head.php';
   include '../layout/navbar.php';
   include '../layout/sidebar.php';
   $list = $DB->query('napthe',['username'=>Auth::user()->username,'domain'=>$_SERVER['SERVER_NAME']]);
?>
<div class="col-md-6 col-12 pr-0" id="feed">
    <div class="p-20">

        <div class="card  mb-4">
            <!-- Body -->
            <div class="card-body mt-2">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="media-mb ">
                            <h5 class="card-title fs-30 mb-3">Nạp thẻ cào</h5>
                        </div>
                    </div>
                </div>

                <div class="alert text-pre-wrap alert-success-light">
                    <p>- Vui lòng nhập đúng mệnh giá tránh bị mất chiết khấu cao ! </p>
                    <p> -Vui lòng nhập đúng mã thẻ và seri ! </p>
                    <p>- Không spam nhiều tránh tài khoản bị khóa!</p>
                </div>
                
                <ul role="tablist" class="nav nav-pills nav-justified flex-column flex-sm-row mb-3">
                    <li class="nav-item tab-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#card" role="tab" aria-selected="true"> 
                        <i class="fa fa-plus-circle"></i>Nạp tiền 
                         </a>
                    </li>
                    <li class="nav-item tab-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#bank" role="tab" aria-selected="true"> 
                            <i  class="fa fa-list"></i> 
                            Lịch sử nạp 
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="card" role="tabpanel" aria-labelledby="card">
                        <!-- Body -->
                        <div class="card-body">
                            <!-- Form -->
                            <form method="POST" action="/api/nap-tien/nap-the-cao" oninput="tungmmo()" >
                                <div class="mb-3">
                                    <label>Nhà mạng :</label>
                                    <select name="telco" class="form-control">
                                        <option value="VIETTEL">Thẻ VIETTEL</option>
                                        <option value="VINAPHONE">Thẻ VINAPHONE</option>
                                        <option value="MOBIFONE">Thẻ MOBIFONE</option>
                                        <option value="GATE">Thẻ GAT</option>
                                        <option value="ZING">Thẻ ZING</option>
                                        <option value="VNMOBI">Thẻ VNMOBI </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Mệnh giá :</label>
                                    <select name="amount" class="form-control">
                                        <option value="10000">10,000 VND</option>
                                        <option value="20000">20,000 VND</option>
                                        <option value="30000">30,000 VND</option>
                                        <option value="50000">50,000 VND</option>
                                        <option value="100000">100,000 VND</option>
                                        <option value="200000">200,000 VND</option>
                                        <option value="300000">300,000 VND</option>
                                        <option value="500000">500,000 VND</option>
                                        <option value="1000000">1,000,000 VND</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Mã Serial :</label>
                                    <input type="text" name="serial"
                                        placeholder="Nhập mã Serial ở hàng đầu tiên của thẻ cào" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Mã Thẻ :</label>
                                    <input type="text" name="pin" placeholder="Nhập mã thẻ cào sau lớp bạc mỏng"
                                        class="form-control">
                                </div>

                                <button type="submit" class="btn btn-buy w-100 ">Gửi thẻ cào</button>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="bank" role="tabpanel" aria-labelledby="bank">
                        <div class="card-box" style="padding-top: 0px;">
                            <div class="mb-3">
                                <table class="table table-cen" id="table-mua">
                                    <thead>
                                        <tr>
                                            <th scope="col"><a href="#">Mã giao dịch</a> </th>
                                            <th scope="col">Mã thẻ</th>
                                            <th scope="col">Serial thẻ</th>
                                            <th scope="col">Mệnh giá</th>
                                            <th scope="col">trạng thái</th>
                                            <th scope="col">thời gian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 1;
                                    foreach($list as $key => $value):
                                    ?>
                                    <tr>
                                        <td><a href="#">#<?=$value['tranid'];?></a></td>
                                        <td><?=$value['pin']; ?></td>
                                        <td><?=$value['serial']; ?></td>
                                        <td><?=format_money($value['amount']); ?></td>
                                        <td><?=status_card($value['status']); ?></td>
                                        <td><?=timeago($value['date']);?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- End Body -->
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><?php include 'item/napthe.js'; ?></script>
<?php include '../layout/footer.php';?>