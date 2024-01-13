<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

// thay các thông tin của bạn vào đây
$tendangnhap = Site::get('username_mb'); // tên đăng nhập trên APP MBBANK
$mkdangnhap =  Site::get('password_mb'); // tên đăng nhập trên APP MBBANK
$sotaikhoan =  Site::get('stk_mb'); // số tài khoản cần check lịch sử giao dịch

// ghi sai thông tin đăng nhập có thể khiến API bị khoá, khi bạn chạy API thì APP sẽ bị văng ra
$urlapi = 'https://api.dailysieure.com/api-mbbank?taikhoan=' . $tendangnhap . '&matkhau=' . $mkdangnhap . '&sotaikhoan=' . $sotaikhoan;
$ketquacurl = curl_get_api_dailysieure($urlapi);
$ketqua = json_decode($ketquacurl, true);
echo $ketquacurl;
if ($ketqua['status'] == '1') {
    echo $ketqua['msg'];
} else {
    //  echo $ketquacurl; 
    $checkGD = @json_decode($ketquacurl)->data;
    echo $checkGD;
    if ($checkGD != null) :
        // lịch sử giao dịch đã xuất hiện
        foreach (array_reverse($checkGD) as $struct) :

            $amount = $struct->creditAmount; // số tiền người ta gửi
            $noidung = $struct->description; // nội dung gửi tiền
            $magd = $struct->refNo; // mã giao dịch

            $checkx = $DB->query_one('bank', ['tranid' => $magd]);
            if ($amount > 9999) :
                if (Auth::user()) :
                    if (!isset($checkx['tranid'])) :
                        if (preg_match('/' . $checkx . '/', $noidung, $matches)) :
                            foreach ($matches as $t) :
                                $x = explode(" nap", $t);

                                $check = $DB->query('users', ['id' => $x[0]]);
                                if (isset($check['id'])) :
                                    $tungmmo2 = $DB->query('bank', ['username' => $check['username'], 'domain' => $check['domain']]);
                                    $tungmmo = $DB->query('napthe', ['username' => $check['username'], 'domain' => $check['domain']]);

                                    foreach ($tungmmo as $tungcoder => $tungdev) :
                                        $money += $tungdev['amount'];
                                    endforeach;
                                    foreach ($tungmmo2 as $tungcoder2 => $tungdev2) :
                                        $money += $tungdev2['amount'];
                                    endforeach;
                                    $money += $amount;

                                    $tong = $amount + $check['coim'];

                                    if ($DB->update('users', ['coin' => $tong], ['username' => $check['username'], 'domain' => $check['domain']])) :
                                        $save = [];
                                        $save['username'] = $check['username'];
                                        $save['tranid'] = $magd;
                                        $save['amount'] = $amount;
                                        $save['note']   = $noidung;
                                        $save['type']   = 'MB BANK';
                                        $save['status'] = true;
                                        $save['domain'] = $check['domain'];
                                        $DB->save('bank', $save);

                                        if ($money > Site::get('coin_ctv')) :
                                            $DB->update('users', ['level' => 1], ['username' => $check['username'], 'domain' => $check['domain']]);
                                        elseif ($money > Site::get('coin_daily')) :
                                            $DB->update('users', ['level' => 2], ['username' => $check['username'], 'domain' => $check['domain']]);
                                        endif;
                                    endif;
                                endif;
                            endforeach;
                        endif;
                    endif;
                endif;
            endif;
        endforeach;
    endif;
}
