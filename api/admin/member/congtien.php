<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['username']) && isset($_POST['coin'])) :

    $username      = str($_POST['username']);
    $coin          = $_POST['coin'];
    
    $users = $DB->query_one("users", ['username' => $username, 'domain' => $_SERVER['SERVER_NAME']]);

    if (!Auth::user()) :
        echo send('error', 'Đm đăng nhập ngay! cho cái dép giờ');
    elseif (empty($username)) :
        echo send('error', 'Định danh tài khoản không được bỏ trống');
    elseif (!isset($users['id'])) :
        echo send('error', 'Tài khoản không tồn tại');
    elseif (Auth::admin_main_site() && $SITEMAIN == $_SERVER['SERVER_NAME']) :
        $thucnhan = $users['coin'] + $coin;
        if ($DB->update('users',['coin'=> $thucnhan], ['username' => $username, 'domain' => $_SERVER['SERVER_NAME']])) :
            echo send('success', 'Cộng tiền thành công');
        else :
            echo send('error', 'Cộng tiềnthất bại');
        endif;
    elseif ($users['domain'] != $_SERVER['SERVER_NAME']) :
        echo send('error', 'Tài khoản không tồn tại');
    elseif (Auth::admin()) :
        $thucnhan = $users['coin'] + $coin;
        if ($DB->update('users',['coin'=> $thucnhan], ['username' => $username, 'domain' => $_SERVER['SERVER_NAME']])) :
            echo send('success', 'Cộng tiền thành công');
        else :
            echo send('error', 'Cộng tiền thất bại');
        endif;
    else :
        echo send('error', 'Tài khoản bạn không phải quản trị viên');
    endif;
else :
    echo send('error', 'dữ liệu gửi lên không hợp lệ');
endif;
