<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

// thay các thông tin của bạn vào đây
$apikey = Site::get('apikey_momo'); // API key của bạn
// Check GD quá 1 lần / phút có thể bị MOMO block check GD 5-15phút
$urlapi = 'https://api.dailysieure.com/api-momo?api=1&apikey=' . $apikey;
$ketquacurl = curl_get_api_dailysieure($urlapi);
$ketqua = json_decode($ketquacurl, true);
$myfile = fopen("log.txt", "w") or die("Unable to open file!");
$txt = $ketqua."\n";
fwrite($myfile, $txt);
fclose($myfile);

if ($ketqua['status'] == '1') :
   echo $ketqua['msg'] ;
else :
    //exit($ketquacurl); 
    $checkGD = @json_decode($ketquacurl)->tranList;
    print_r($checkGD);
    if ($checkGD != null) :
        // lịch sử giao dịch đã xuất hiện
        foreach (array_reverse($checkGD) as $struct) :
            
            $sdt = $struct->partnerId; // SDT 
            $amount = $struct->amount; // số tiền 
            $noidung = $struct->comment; // nội dung gửi tiền
            $magd = $struct->tranId; // mã giao dịch


            $checkx = $DB->query_one('bank', ['tranid' => $magd]);
            if ($amount > 9999) :

                if (Auth::user()) :
                    if (!isset($checkx['tranid'])) :
                        $x = explode(" nap", $noidung);
                        $check = $DB->query('users', ['id' => $x[0]]);

                        if (isset($check['id'])) :
                            $tungmmo2 = $DB->query('bank', ['username' => $check['username'], 'domain' => $check['domain']]);
                            $tungmmo = $DB->query('napthe', ['username' => $check['username'], 'domain' => $check['domain']]);

                            if ($money > Site::get('coin_ctv')) :
                                $DB->update('users', ['level' => 1], ['username' => $check['username'], 'domain' => $check['domain']]);
                            elseif ($money > Site::get('coin_daily')) :
                                $DB->update('users', ['level' => 2], ['username' => $check['username'], 'domain' => $check['domain']]);
                            endif;

                            foreach ($tungmmo as $tungcoder => $tungdev) :
                                $money += $tungdev['amount'];
                            endforeach;
                            foreach ($tungmmo2 as $tungcoder2 => $tungdev2) :
                                $money += $tungdev2['amount'];
                            endforeach;
                            $money += $amount;

                            $tong = $amount + $check['coin'];

                            if ($DB->update('users', ['coin' => $tong], ['username' => $check['username'], 'domain' => $check['domain']])) :
                                $save = [];
                                $save['username'] = $check['username'];
                                $save['tranid'] = $magd;
                                $save['amount'] = $amount;
                                $save['note']   = $noidung;
                                $save['type']   = 'MOMO';
                                $save['status'] = true;
                                $save['domain'] = $check['domain'];
                                $DB->save('bank', $save);
                            endif;
                        endif;
                    endif;
                endif;
            endif;
        endforeach;
    endif;

endif;
