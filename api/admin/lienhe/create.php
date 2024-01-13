<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['name']) && isset($_POST['path'])) :

    $name        = $_POST['name'];
    $path        = $_POST['path'];
  
    if (!Auth::user()) :
        echo send('error', 'Đm đăng nhập ngay! cho cái dép giờ');
    elseif (empty($name)) :
        echo send('error', 'Tên liên hệ không được bỏ trống');
    elseif (empty($path)) :
        echo send('error', 'Đường dẫn không được bỏ trống');
    elseif (Auth::admin()) :
        $save = [];
        $save['name']         = $name;     
        $save['path']         = $path;
        $save['domain']       = $_SERVER['SERVER_NAME'];

        if ($DB->save('lienhe', $save)) :
            echo send('success', 'Tạo liên hệ thành công');
        else :
            echo send('error', 'Tạo liên hệ thất bại');
        endif;
    else :
        echo send('error', 'Tài khoản bạn không phải quản trị viên');
    endif;
else :
    echo send('error', 'dữ liệu gửi lên không hợp lệ');
endif;
