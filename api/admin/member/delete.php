<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['uid'])) :

    $uid      = str($_POST['uid']);
    $users = $DB->query_one("users", ['id' => $uid]);

    if (!Auth::user()) :
        echo send('error', 'Đm đăng nhập ngay! cho cái dép giờ');
    elseif (empty($uid)) :
        echo send('error', 'Định danh tài khoản không được bỏ trống');
    elseif (!isset($users['id'])) :
        echo send('error', 'Tài khoản không tồn tại');
    elseif (Auth::admin_main_site() && $SITEMAIN == $_SERVER['SERVER_NAME']) :
        if ($DB->delete('users', ['id' => $uid])) :
            echo send('success', 'Xóa tài khoản thành công');
        else :
            echo send('error', 'Xóa tài khoản thất bại');
        endif;
    elseif ($users['domain'] != $_SERVER['SERVER_NAME']) :
        echo send('error', 'Tài khoản không tồn tại');
    elseif (Auth::admin()) :
        if ($DB->delete('users', ['id' => $uid])) :
            echo send('success', 'Xóa tài khoản thành công');
        else :
            echo send('error', 'Xóa tài khoản thất bại');
        endif;
    else :
        echo send('error', 'Tài khoản bạn không phải quản trị viên');
    endif;
else :
    echo send('error', 'dữ liệu gửi lên không hợp lệ');
endif;
