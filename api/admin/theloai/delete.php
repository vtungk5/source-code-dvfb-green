<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['id_theloai'])) :

    $uid       = $_POST['id_theloai'];
    $theloai = $DB->query_one("theloai", ['id_theloai' => $uid]);

    if (!Auth::user()) :
        echo send('error', 'Đm đăng nhập ngay! cho cái dép giờ');
    elseif(empty($uid)):
        echo send('error','Định danh thể loại không được bỏ trống');
    elseif (!isset($theloai['id'])) :
        echo send('error', 'Thể loại này không tồn tại');
    elseif (Auth::admin_main_site() && $SITEMAIN == $_SERVER['SERVER_NAME']) :
        if ($DB->delete('theloai', ['id_theloai'=>$uid])) :
            echo send('success', 'Xóa thể loại thành công');
        else :
            echo send('error', 'Xóa thể loại thất bại');
        endif;
    else :
        echo send('error', 'Tài khoản bạn không phải quản trị viên');
    endif;
else :
    echo send('error', 'dữ liệu gửi lên không hợp lệ');
endif;
