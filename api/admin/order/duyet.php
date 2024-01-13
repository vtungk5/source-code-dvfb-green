<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['uid']) && isset($_POST['status'])) :


    $uid        = $_POST['uid'];
    $status      = $_POST['status'];

    $order = $DB->query_one("order", ['id' => $uid]);

    if (!Auth::user()) :
        echo send('error', 'Đm đăng nhập ngay! cho cái dép giờ');
    elseif (empty($uid)) :
        echo send('error', 'Định danh đơn hàng không được bỏ trống');
    elseif(empty($status)):    
        echo send('error','Trạng thái không được bỏ trống');
    elseif (!isset($order['id'])) :
        echo send('error', 'Đơn hàng này không tồn tại');
    elseif ($order['status']=='true') :
        echo send('error', 'Đơn hàng này đã được duyệt');
    elseif (Auth::admin_main_site() && $SITEMAIN == $_SERVER['SERVER_NAME']) :
        $save = [];
        $save['status']         = $_POST['status'];
        if ($DB->update('order', $save,['id'=>$uid])) :
            echo send('success', 'Cập nhập đơn hàng thành công');
        else :
            echo send('error', 'Cập nhập đơn hàng thất bại');
        endif;
    else :
        echo send('error', 'Tài khoản bạn không phải quản trị viên');
    endif;
else :
    echo send('error', 'dữ liệu gửi lên không hợp lệ');
endif;
