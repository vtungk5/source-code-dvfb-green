<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['name']) && isset($_POST['logo']) && isset($_POST['path']) && isset($_POST['id_theloai'])) :

    $name       = $_POST['name'];
    $logo       = $_POST['logo'];
    $path       = $_POST['path'];
    $id_theloai = $_POST['id_theloai'];

    $theloai = $DB->query_one("theloai", ['id_theloai' => $id_theloai]);

    if (!Auth::user()) :
        echo send('error', 'Đm đăng nhập ngay! cho cái dép giờ');
    elseif (empty($name)) :
        echo send('error', 'Tên thể loại không được bỏ trống');
    elseif(empty($logo)):
        echo send('error','Biểu tượng thể loại không được bỏ trống');
    elseif(empty($path)):
        echo send('error','Đường dẫn thể loại không được bỏ trống');
    elseif(empty($id_theloai)):
        echo send('error','ID thể loại không được bỏ trống');
    elseif (isset($theloai['id'])) :
        echo send('error', 'Thể loại này đã tồn tại');
    elseif (Auth::admin_main_site() && $SITEMAIN == $_SERVER['SERVER_NAME']) :
        $save = [];
        $save['logo']       = $logo;
        $save['name']       = $name;
        $save['path']       = $path;
        $save['id_theloai'] = $id_theloai;

        if ($DB->save('theloai', $save)) :
            echo send('success', 'Tạo thể loại thành công');
        else :
            echo send('error', 'Tạo thể loại thất bại');
        endif;
    else :
        echo send('error', 'Tài khoản bạn không phải quản trị viên');
    endif;
else :
    echo send('error', 'dữ liệu gửi lên không hợp lệ');
endif;
