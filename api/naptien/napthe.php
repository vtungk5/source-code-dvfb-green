<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['telco']) && isset($_POST['pin']) && isset($_POST['serial']) && isset($_POST['amount'])) :
    $telco   = str($_POST['telco']); // nhà mạng
    $pin     = $_POST['pin']; // mã thẻ
    $serial  = $_POST['serial']; // serial thẻ
    $amount  = $_POST['amount']; // mệnh giá
    $tran_id = rand(10000000, 140000000);
    $date    = getTime();
    $command = "charging";
    $sign = md5(Site::get('partner_key') . $pin . $command . Site::get('partner_id') . $tran_id . $serial . $telco);

    if (!Auth::user()) :
        echo send('error', 'Đm đăng nhập ngay! cho cái dép giờ');
    elseif (empty($pin)) :
        echo send('error', 'Mã thẻ không được bỏ trống');
    elseif (empty($serial)) :
        echo send('error', 'Serial thẻ không được bỏ trống');
    elseif (empty($telco)) :
        echo send('error', 'Nhà mạng không được bỏ trống');
    elseif (empty($amount)) :
        echo send('error', 'Mệnh giá thẻ không được bỏ trống');
    elseif (strlen($amount) < 5) :
        echo send('error', 'Mệnh giá thẻ quá nhỏ');
    elseif (strlen($amount) > 7) :
        echo send('error', 'Mệnh giá thẻ quá lớn');
    elseif (strlen($pin) < 13) :
        echo send('error', 'Mã thẻ phải có 13 ký tự trở lên');
    elseif (strlen($pin) > 15) :
        echo send('error', 'Mã thẻ không được vượt quá 15 ký tự');
    elseif (strlen($serial) < 11) :
        echo send('error', 'Serial thẻ phải có 11 ký tự trở lên');
    elseif (strlen($serial) > 14) :
        echo send('error', 'Serial thẻ không được vượt quá 14 ký tự');
    else :

        $data = [
            'telco'      => $telco,
            'code'       => $pin,
            'serial'     => $serial,
            'amount'     => $amount,
            'request_id' => $tran_id,
            'partner_id' => Site::get('partner_id'),
            'sign'       => $sign,
            'command'    => $command
        ];

        $response = json_decode(post('https://thesieure.com/chargingws/v2', http_build_query($data)));

        $save = [];
        $save['username'] = Auth::user()->username;
        $save['tranid']   = $tran_id;
        $save['pin']      = $pin;
        $save['serial']   = $serial;
        $save['telco']    = $telco;
        $save['amount']   = $amount;
        $save['note']     = $response->message;
        $save['status']   = $response->status;
        $save['date']     = getTime();
        $save['ip']       = get_ip();
        $save['domain']   = $_SERVER['SERVER_NAME'];


        if ($response->status == 99) :
            if ($DB->save('napthe', $save)) :
                echo send('success',  'Gửi thẻ lên hệ thống thành công');
            else :
                echo send('error', 'Gửi thẻ thất bại vui lòng liên hệ admin');
            endif;
        elseif ($response->status == 1) :
            if ($DB->save('napthe', $save)) :
                $thucnhan = Auth::user()->coin + $response->amount;
                if ($DB->update('users', ['coin' => $thucnhan], ['username' => Auth::user()->username, 'domain' => $_SERVER['SERVER_NAME']])) :
                    echo send('success',  'Gửi thẻ lên hệ thống thành công');
                    $tungmmo2 = $DB->query('bank', ['username' => Auth::user()->username, 'domain' => $_SERVER['SERVER_NAME']]);
                    $tungmmo = $DB->query('napthe', ['username' => Auth::user()->username, 'domain' => $_SERVER['SERVER_NAME']]);

                    foreach ($tungmmo as $tungcoder => $tungdev) :
                        $money += $tungdev['amount'];
                    endforeach;
                    foreach ($tungmmo2 as $tungcoder2 => $tungdev2) :
                        $money += $tungdev2['amount'];
                    endforeach;
                    $money += $amount;
                    if ($money > Site::get('coin_ctv')) :
                        $DB->update('users', ['level' => 1], ['username' => Auth::user()->username, 'domain' => $_SERVER['SERVER_NAME']]);
                    elseif ($money > Site::get('coin_daily')) :
                        $DB->update('users', ['level' => 2], ['username' => Auth::user()->username, 'domain' => $_SERVER['SERVER_NAME']]);
                    endif;
                else :
                    echo send('success',  'Cộng tiền thất bại vui lòng liên hệ admin');
                endif;
            else :
                echo send('error', 'Gửi thẻ thất bại vui lòng liên hệ admin');
            endif;
        elseif ($response->status == 2) :
            if ($DB->save('napthe', $save)) :
                $thucnhan = Auth::user()->coin + $response->amount;
                if ($DB->update('users', ['coin' => $thucnhan], ['username' => Auth::user()->username, 'domain' => $_SERVER['SERVER_NAME']])) :
                    echo send('success',  'Gửi thẻ lên hệ thống thành công');
                    $tugmmo2 = $DB->query('bank', ['username' => Auth::user()->username, 'domain' => $_SERVER['SERVER_NAME']]);
                    $tugmmo = $DB->query('napthe', ['username' => Auth::user()->username, 'domain' => $_SERVER['SERVER_NAME']]);

                    foreach ($tungmmo as $tungcoder => $tungdev) :
                        $money += $tungdev['amount'];
                    endforeach;
                    foreach ($tungmmo2 as $tungcoder2 => $tungdev2) :
                        $money += $tungdev2['amount'];
                    endforeach;
                    $money += $amount;
                    if ($money > Site::get('coin_ctv')) :
                        $DB->update('users', ['level' => 1], ['username' => Auth::user()->username, 'domain' => $_SERVER['SERVER_NAME']]);
                    elseif ($money > Site::get('coin_daily')) :
                        $DB->update('users', ['level' => 2], ['username' => Auth::user()->username, 'domain' => $_SERVER['SERVER_NAME']]);
                    endif;
                else :
                    echo send('success',  'Cộng tiền thất bại vui lòng liên hệ admin');
                endif;
            else :
                echo send('error', 'Gửi thẻ thất bại vui lòng liên hệ admin');
            endif;
        elseif ($response->status == 3) :
            echo send('success',  'Mã thẻ sai hoặc thẻ đã được sử dụng');
        else :
            echo send('error', $response->message);
        endif;

    endif;
endif;
