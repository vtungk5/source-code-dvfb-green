<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['uid'])) :

    $uid         = $_POST['uid'];
    $lienhe = $DB->query_one("lienhe", ['id' => $uid]);

    if (!Auth::user()) :
        echo send('error', 'Đm đăng nhập ngay! cho cái dép giờ');
    elseif (empty($uid)) :
        echo send('error', 'Mã định danh liên hệ không được bỏ trống');
    elseif(!isset($lienhe['id'])):
        echo send('error', 'Liên hệ này không tồn tại');
    elseif (Auth::admin()) :
        if ($DB->delete('lienhe',['id' => $uid])) :
            echo send('success', 'Xóa liên hệ thành công');
        else :
            echo send('error', 'Xóa liên hệ thất bại');
        endif;
    else :
        echo send('error', 'Tài khoản bạn không phải quản trị viên');
    endif;
else :
    echo send('error', 'dữ liệu gửi lên không hợp lệ');
endif;
