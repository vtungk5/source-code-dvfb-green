<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['name']) && isset($_POST['nguon']) && isset($_POST['path']) && isset($_POST['id_dv']) && isset($_POST['id_theloai']) && isset($_POST['apikey']) && isset($_POST['comment']) && isset($_POST['reaction'])&& isset($_POST['speed'])&& isset($_POST['note'])&& isset($_POST['status'])) :

    $name        = $_POST['name'];
    $path        = $_POST['path'];
    $id_dv       = $_POST['id_dv'];
    $id_theloai  = $_POST['id_theloai'];
    $apikey      = $_POST['apikey'];
    $comment     = $_POST['comment'];
    $reaction    = $_POST['reaction'];
    $speed       = $_POST['speed'];
    $nguon       = $_POST['nguon'];
    $note        = $_POST['note'];
    $status      = $_POST['status'];

    $theloai = $DB->query_one("theloai", ['id_theloai' => $id_theloai]);
    $service = $DB->query_one("service", ['id_dv'      => $id_dv,'id_theloai' => $id_theloai]);
    $service2 = $DB->query_one("service", ['path'      => $path,'id_theloai' => $id_theloai]);
    
    if (!Auth::user()) :
        echo send('error', 'Đm đăng nhập ngay! cho cái dép giờ');
    elseif (empty($name)) :
        echo send('error', 'Tên dịch vụ không được bỏ trống');
    elseif (empty($path)) :
        echo send('error', 'Đường dẫn không được bỏ trống');
    elseif(empty($id_dv)):
        echo send('error','ID dịch vụ không được bỏ trống');
    elseif(empty($id_theloai)):
        echo send('error','ID thể loại không được bỏ trống');
    elseif(empty($apikey)):
        echo send('error','Apikey không được bỏ trống');
    elseif(empty($comment)):
        echo send('error','Bình luận không được bỏ trống');
    elseif(empty($reaction)):
        echo send('error','Bot cảm xúc không được bỏ trống');
    elseif(empty($speed)):
        echo send('error','Tốc độ không được bỏ trống');
    elseif(empty($note)):
        echo send('error','Lưu ý không được bỏ trống');
    elseif(empty($nguon)):
        echo send('error','Lưu ý Nhà cung cấp bỏ trống');
    elseif(empty($status)):    
        echo send('error','Trạng thái không được bỏ trống');
    elseif (!isset($theloai['id'])) :
        echo send('error', 'Thể loại này không tồn tại');
    elseif (isset($service['id'])) :
        echo send('error', 'Dịch vụ này đã tồn tại');
    elseif (isset($service2['id'])) :
        echo send('error', 'Đường dẫn này đã tồn tại');
    elseif (Auth::admin_main_site() && $SITEMAIN == $_SERVER['SERVER_NAME']) :
        $save = [];
        $save['name']         = $name;     
        $save['note']         = $note;
        $save['path']         = $path;
        $save['nguon']        = $nguon;
        $save['apikey']       = $apikey;
        $save['id_dv']        = $id_dv;
        $save['id_theloai']   = $id_theloai;
        $save['comment']      = $comment;
        $save['reaction']     = $reaction;
        $save['speed']        = $speed;
        $save['status']       = $status;

        if ($DB->save('service', $save)) :
            echo send('success', 'Tạo dịch vụ thành công');
        else :
            echo send('error', 'Tạo dịch vụ thất bại');
        endif;
    else :
        echo send('error', 'Tài khoản bạn không phải quản trị viên');
    endif;
else :
    echo send('error', 'dữ liệu gửi lên không hợp lệ');
endif;
