<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['id_dv'])) :

    $uid       = $_POST['id_dv'];
    $service = $DB->query_one("service", ['id_dv' => $uid]);

    if (!Auth::user()) :
        echo send('error', 'Đm đăng nhập ngay! cho cái dép giờ');
    elseif(empty($uid)):
        echo send('error','Định danh dịch vụ không được bỏ trống');
    elseif (!isset($service['id'])) :
        echo send('error', 'dịch vụ này không tồn tại');
    elseif (Auth::admin_main_site() && $SITEMAIN == $_SERVER['SERVER_NAME']) :
        if ($DB->delete('service', ['id_dv'=>$uid])) :
            echo send('success', 'Xóa dịch vụ thành công');
        else :
            echo send('error', 'Xóa dịch vụ thất bại');
        endif;
    else :
        echo send('error', 'Tài khoản bạn không phải quản trị viên');
    endif;
else :
    echo send('error', 'dữ liệu gửi lên không hợp lệ');
endif;
