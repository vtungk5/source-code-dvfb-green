<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['uid']) &&isset($_POST['name']) && isset($_POST['path'])) :

    $name        = $_POST['name'];
    $path        = $_POST['path'];
    $uid         = $_POST['uid'];

    $lienhe = $DB->query_one("lienhe", ['id' => $uid]);

    if (!Auth::user()) :
        echo send('error', 'Đm đăng nhập ngay! cho cái dép giờ');
    elseif (empty($uid)) :
        echo send('error', 'Mã định danh liên hệ không được bỏ trống');
    elseif (empty($name)) :
        echo send('error', 'Tên liên hệ không được bỏ trống');
    elseif (empty($path)) :
        echo send('error', 'Đường dẫn không được bỏ trống');
    elseif(!isset($lienhe['id'])):
        echo send('error', 'Liên hệ này không tồn tại');
    elseif (Auth::admin()) :
        $save = [];
        $save['name']         = $name;     
        $save['path']         = $path;
        $save['domain']       = $_SERVER['SERVER_NAME'];

        if ($DB->update('lienhe', $save,['id' => $uid])) :
            echo send('success', 'Cập nhập liên hệ thành công');
        else :
            echo send('error', 'Cập nhập liên hệ thất bại');
        endif;
    else :
        echo send('error', 'Tài khoản bạn không phải quản trị viên');
    endif;
else :
    echo send('error', 'dữ liệu gửi lên không hợp lệ');
endif;
