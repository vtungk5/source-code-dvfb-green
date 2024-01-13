<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['id_sv'])) :

    $uid       = $_POST['id_sv'];
    $service = $DB->query_one("server", ['id_sv' => $uid]);

    if (!Auth::user()) :
        echo send('error', 'Đm đăng nhập ngay! cho cái dép giờ');
    elseif(empty($uid)):
        echo send('error','Định danh server không được bỏ trống');
    elseif (!isset($service['id'])) :
        echo send('error', 'server này không tồn tại');
    elseif (Auth::admin_main_site() && $SITEMAIN == $_SERVER['SERVER_NAME']) :
        if ($DB->delete('server', ['id_sv'=>$uid])) :
            echo send('success', 'Xóa server thành công');
        else :
            echo send('error', 'Xóa server thất bại');
        endif;
    else :
        echo send('error', 'Tài khoản bạn không phải quản trị viên');
    endif;
else :
    echo send('error', 'dữ liệu gửi lên không hợp lệ');
endif;
