<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['password']) && isset($_POST['domain'])) :

    $password = $_POST['password'];
    $domain = $_POST['domain'];
    $getNS = getDns($domain);

    $users = $DB->query_one('users', ['username' => Auth::user()->username, 'domain' => $_SERVER['SERVER_NAME']]);
    $sitecon = $DB->query_one('sitecon', ['domain' => $domain]);
    $sitecon2 = $DB->num_rows('sitecon', ['username' => Auth::user()->username]);

    $save = [];
    $save['username'] = Auth::user()->username;
    $save['apikey']   = Auth::user()->apikey;
    $save['domain']   = $domain;
    $save['date']     = getTime();

    if (!Auth::user()) :
        echo send('error', 'Đm đăng nhập ngay! cho cái dép giờ');
    elseif (Auth::user()->level < 1) :
        echo send('error', 'Vui lòng nạp thêm để nâng cấp bậc ');
    elseif ($sitecon2 > 3) :
        echo send('error', 'Bạn chỉ được tạo 3 website đại lý');
    elseif (empty($password)) :
        echo send('error', 'Mật khẩu không được bỏ trống');
    elseif (strlen($password) < 4) :
        echo send('error', 'Mật khẩu phải có 4 ký tự trở lên');
    elseif (strlen($password) > 20) :
        echo send('error', 'Mật khẩu không được quá 32 ký tự trở lên');
    elseif (!Hash::check($password, $users['password'])) :
        echo send('error', 'Ăn gì ngu thế mỗi mật khẩu cũng quên');
    elseif (empty($domain)) :
        echo send('error', 'Tên miền không được bỏ trống');
    elseif ($domain == $SITEMAIN) :
        echo send('error', 'Tên miền đã tồn tại');
    elseif (isset($sitecon['domain'])) :
        echo send('error', 'Tên miền đã tồn tại');
    elseif ($getNS[0] != $_NS1) :
        if ($getNS[0] != $_NS2) :
            echo send('error', 'Name server 1:' . $getNS[0] . ' không đúng');
        elseif ($getNS[1] != $_NS1) :
            echo send('error', 'Name server 2:' . $getNS[1] . ' không đúng');
        else :
            if ($DB->save('sitecon', $save)) :

                $url = $cpanel_server . "/cpsess0937896524/json-api/cpanel?cpanel_jsonapi_apiversion=2&cpanel_jsonapi_module=Park&cpanel_jsonapi_func=park&domain=$domain";

                $curl = curl_init();
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_HEADER, 0);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $header[0] = "Authorization: Basic " . base64_encode($username_cpanel . ":" . $password_cpanel) . "\n\r";
                curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
                curl_setopt($curl, CURLOPT_URL, $url);
                $return = curl_exec($curl);
                curl_close($curl);

                if ($return) :
                    echo send('success', 'Thêm miền thành công đúng con trai của ta');
                else :
                    echo send('error', json_decode($return)->cpanelresult->error);
                endif;
            else :
                echo send('error', 'Thêm miền cũng ngu');
            endif;
        endif;
    elseif ($getNS[1] != $_NS2) :
        echo send('error', 'Name server 2:' . $getNS[1] . ' không đúng');
    elseif ($DB->save('sitecon', $save)) :

        $url = $cpanel_server . "/cpsess0937896524/json-api/cpanel?cpanel_jsonapi_apiversion=2&cpanel_jsonapi_module=Park&cpanel_jsonapi_func=park&domain=$domain";

        $curl = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $header[0] = "Authorization: Basic " . base64_encode($username_cpanel . ":" . $password_cpanel) . "\n\r";
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_URL, $url);
        $return = curl_exec($curl);
        curl_close($curl);

        if ($return) :
            echo send('success', 'Thêm miền thành công đúng con trai của ta');
        else :
            echo send('error', json_decode($return)->cpanelresult->error);
        endif;

    else :
        echo send('error', 'Thêm miền cũng ngu');
    endif;
else :
    echo send('error', 'dữ liệu gửi lên không hợp lệ');
endif;
