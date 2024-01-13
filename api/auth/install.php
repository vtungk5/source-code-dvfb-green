<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['name']) && isset($_POST['username']) && isset($_POST['password'])) :
    $token = getToken(13);

    $name     = str($_POST['name']);
    $username = str($_POST['username']);
    $password = $_POST['password'];

    $token   = getToken(13);
    $apikey  = getToken(32);
    $ip      = get_ip();
    $browser = getBrowser()['name'];
    $device  = getBrowser()['platform'];
    $date    = getTime();

    $create_account = [
        'name'     => $name,
        'username' => $username,
        'password' => Hash::make($password),
        'apikey'   => $apikey,
        'token'    => $token,
        'date'     => $date,
        'ip'       => $ip,
        'domain' => $_SERVER['SERVER_NAME']
    ];
    $site_create = [];
    $site_create['logo'] = '<span class="logo-x1">TUNG</span>MMO';
    $site_create['title'] = "Hệ thống dịch vụ mạng xã hội Facebook | Instagram | Youtube | Tiktok";
    $site_create['description'] = "Hệ thống dịch vụ mạng xã hội Facebook | Instagram | Youtube | Tiktok";
    $site_create['keyword'] = "like, sub, share, vip like, buff mắt, tăng follow, mua like, mua sub, sub rẻ, hack like, hack sub, hack follow, tăng like, tăng follow, cách hack tăng like,share code auto like, xin code auto like, web auto like";

    $site_create['rate_ctv'] = 5;
    $site_create['rate_daily'] = 10;
    $site_create['coin_ctv'] = 500000;
    $site_create['coin_daily'] = 10000000;

    $site_create['domain'] = $_SERVER['SERVER_NAME'];

    $list_history = [
        'username' => $username,
        'device'   => getBrowser()['platform'],
        'browser'  => getBrowser()['name'],
        'note'     => "Bạn đã Kích hoạt website đặc quyền admin trên ip $ip vào lúc $date",
        'ip'       => $ip,
        'date'     => $date,
        'domain' => $_SERVER['SERVER_NAME']
    ];

    if (empty($name)) :
        echo send('error', 'Họ và tên không được bỏ trống');
    elseif (strlen($name) < 6) :
        echo send('error', 'Họ và tên phải có 6 ký tự trở lên');
    elseif (strlen($name) > 32) :
        echo send('error', 'Họ và tên không được quá 32 ký tự trở lên');
    elseif (isset($users['username'])) :
        echo send('error', 'Tên đăng nhập này đã tồn tại');
    elseif (empty($username)) :
        echo send('error', 'Tên đăng nhập không được bỏ trống');
    elseif (strlen($username) < 4) :
        echo send('error', 'Tên đăng nhập phải có 4 ký tự trở lên');
    elseif (strlen($username) > 15) :
        echo send('error', 'Tên đăng nhập không được quá 32 ký tự trở lên');
    elseif (empty($password)) :
        echo send('error', 'Mật khẩu không được bỏ trống');
    elseif (strlen($password) < 4) :
        echo send('error', 'Mật khẩu phải có 4 ký tự trở lên');
    elseif (strlen($password) > 20) :
        echo send('error', 'Mật khẩu không được quá 32 ký tự trở lên');
    elseif ($_SERVER['SERVER_NAME'] == $SITEMAIN) :
        $site = $DB->query_one('site', ['domain' => $_SERVER['SERVER_NAME']]);
        if (!isset($site['id'])) :
            $create_account['level'] = 4;
            if ($DB->save('users', $create_account) && $DB->save('history', $list_history) && $DB->save('site', $site_create)) :
                $_SESSION['users'] = $token;
                echo send('success', 'Kích hoạt website thành công rồi thằng em');
            else :
                echo send('error', 'Kích hoạt website thất bại ngu như lợn');
            endif;
        else :
            echo send('error', 'Trang website ' . $_SERVER['SERVER_NAME'] . ' đã được kích hoạt');
        endif;
    elseif (isset($_POST['apikey'])) :
        $site = $DB->query_one('site', ['domain' => $_SERVER['SERVER_NAME']]);
        $check = $DB->query_one('sitecon', ['apikey' => $_POST['apikey'], 'domain' => $_SERVER['SERVER_NAME']]);
        if (empty($_POST['apikey'])) :
            echo send('error', 'API key không được bỏ trống');
        elseif (!isset($site['id'])) :
            if (!isset($check['id'])) :
                echo send('error', 'Apikey không chính xác');
            else :
                $create_account['level'] = 3;
                $site_create['apikey'] = $_POST['apikey'];
                $list = $DB->query("server", ['domain' => $SITEMAIN]);
                $sitex = $DB->query_one("server", ['domain' => $SITEMAIN]);

                if (isset($sitex['id'])) :
                    foreach ($list as $key => $site_me) :
                        $DB->save('server', [
                            'name'       => $site_me['name'],
                            'rate'       => $site_me['rate'],
                            'server'     => $site_me['server'],
                            'id_theloai' => $site_me['id_theloai'],
                            'id_dv'      => $site_me['id_dv'],
                            'id_sv'      => $site_me['id_sv'],
                            'note'       => $site_me['note'],
                            'status'     => $site_me['status'],
                            'domain'     => $_SERVER['SERVER_NAME']
                        ]);
                    endforeach;
                endif;

                if ($DB->save('users', $create_account) && $DB->save('history', $list_history) && $DB->save('site', $site_create)) :
                    $_SESSION['users'] = $token;
                    echo send('success', 'Kích hoạt website thành công rồi thằng em');
                else :
                    echo send('error', 'Kích hoạt website thất bại ngu như lợn');
                endif;
            endif;
        else :
            echo send('error', 'Trang website ' . $_SERVER['SERVER_NAME'] . ' đã được kích hoạt');
        endif;
    else :
        echo send('error', 'dữ liệu gửi lên không hợp lệ');
    endif;
else :
    echo send('error', 'dữ liệu gửi lên không hợp lệ');
endif;
