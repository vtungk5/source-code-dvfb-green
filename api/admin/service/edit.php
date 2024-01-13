<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['uid']) && isset($_POST['name']) && isset($_POST['nguon']) && isset($_POST['path']) && isset($_POST['id_dv']) && isset($_POST['id_theloai']) && isset($_POST['apikey']) && isset($_POST['comment']) && isset($_POST['reaction'])&& isset($_POST['speed'])&& isset($_POST['note'])&& isset($_POST['status'])) :

    $uid         = $_POST['uid'];
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
    $service3 = $DB->query_one("service", ['id'        => $uid]);

    if (!Auth::user()) :
        echo send('error', 'Đm đăng nhập ngay! cho cái dép giờ');
    elseif (empty($uid)) :
        echo send('error', 'Định danh dịch vụ không được bỏ trống');
    elseif (empty($name)) :
        echo send('error', 'Tên dịch vụ không được bỏ trống');
    elseif (empty($path)) :
        echo send('error', 'Đường dẫn không được bỏ trống');
    elseif (empty($id_dv)) :
        echo send('error', 'ID dịch vụ không được bỏ trống');
    elseif (empty($id_theloai)) :
        echo send('error', 'ID thể loại không được bỏ trống');
    elseif (empty($apikey)) :
        echo send('error', 'Apikey không được bỏ trống');
    elseif (empty($comment)) :
        echo send('error', 'Bình luận không được bỏ trống');
    elseif (empty($reaction)) :
        echo send('error', 'Bot cảm xúc không được bỏ trống');
    elseif (empty($speed)) :
        echo send('error', 'Tốc độ không được bỏ trống');
    elseif (empty($note)) :
        echo send('error', 'Lưu ý không được bỏ trống');
    elseif (empty($nguon)) :
        echo send('error', 'Lưu ý Nhà cung cấp bỏ trống');
    elseif (empty($status)) :
        echo send('error', 'Trạng thái không được bỏ trống');
    elseif (!isset($service3['id'])) :
        echo send('error', 'Dịch vụ không tồn tại');
    elseif (!isset($theloai['id'])) :
        echo send('error', 'Thể loại này không tồn tại');
    elseif (isset($service['id'])) :
        if ($service['id_dv'] != $service3['id_dv']) :
            echo send('error', 'Dịch vụ này đã tồn tại');
        elseif (isset($service2['id'])):
            if ($service2['path'] != $service3['path']) :
                echo send('error', 'Đường dẫn này đã tồn tại');
            elseif (Auth::admin_main_site() && $SITEMAIN == $_SERVER['SERVER_NAME']) :
                $save = [];
                $save['name']         = $name;     
                $save['note']         = $note;
                $save['path']         = $path;
                $save['nguon']        = $nguon;
                $save['apikey']       = $apikey;
                $save['id_theloai']   = $id_theloai;
                $save['id_dv']        = $id_dv;
                $save['comment']      = $comment;
                $save['reaction']     = $reaction;
                $save['speed']        = $speed;
                $save['status']       = $status;

                if ($DB->update('service', $save, ['id' => $uid])) :
                    echo send('success', 'Cập nhập dịch vụ thành công');
                else :
                    echo send('error', 'Cập nhập dịch vụ thất bại');
                endif;
            else :
                echo send('error', 'Tài khoản bạn không phải quản trị viên');
            endif;
        elseif (Auth::admin_main_site() && $SITEMAIN == $_SERVER['SERVER_NAME']) :
            $save = [];
            $save['name']         = $name;
            $save['path']         = $path;
            $save['id_theloai']   = $id_theloai;
            $save['id_dv']        = $id_dv;
            $save['nguon']        = $nguon;
            $save['apikey']       = $apikey;
            $save['comment']      = $comment;
            $save['reaction']     = $reaction;
            $save['speed']        = $speed;
            $save['note']         = $note;
            $save['status']       = $status;

            if ($DB->update('service', $save, ['id' => $uid])) :
                echo send('success', 'Cập nhập dịch vụ thành công');
            else :
                echo send('error', 'Cập nhập dịch vụ thất bại');
            endif;
        else :
            echo send('error', 'Tài khoản bạn không phải quản trị viên');
        endif;
    elseif (isset($service2['id'])) :
        if ($service2['path'] != $service3['path']) :
            echo send('error', 'Đường dẫn này đã tồn tại');
        elseif (Auth::admin_main_site() && $SITEMAIN == $_SERVER['SERVER_NAME']) :
            $save = [];
            $save['name']         = $name;
            $save['path']         = $path;
            $save['id_theloai']   = $id_theloai;
            $save['id_dv']        = $id_dv;
            $save['nguon']        = $nguon;
            $save['apikey']       = $apikey;
            $save['comment']      = $comment;
            $save['reaction']     = $reaction;
            $save['speed']        = $speed;
            $save['note']         = $note;
            $save['status']       = $status;

            if ($DB->update('service', $save, ['id' => $uid])) :
                echo send('success', 'Cập nhập dịch vụ thành công');
            else :
                echo send('error', 'Cập nhập dịch vụ thất bại');
            endif;
        else :
            echo send('error', 'Tài khoản bạn không phải quản trị viên');
        endif;
    elseif (Auth::admin_main_site() && $SITEMAIN == $_SERVER['SERVER_NAME']) :
        $save = [];
        $save['name']         = $name;
        $save['path']         = $path;
        $save['id_theloai']   = $id_theloai;
        $save['id_dv']        = $id_dv;
        $save['nguon']        = $nguon;
        $save['apikey']       = $apikey;
        $save['comment']      = $comment;
        $save['reaction']     = $reaction;
        $save['speed']        = $speed;
        $save['note']         = $note;
        $save['status']       = $status;

        if ($DB->update('service', $save, ['id' => $uid])) :
            echo send('success', 'Cập nhập dịch vụ thành công');
        else :
            echo send('error', 'Cập nhập dịch vụ thất bại');
        endif;
    else :
        echo send('error', 'Tài khoản bạn không phải quản trị viên');
    endif;
else :
    echo send('error', 'dữ liệu gửi lên không hợp lệ');
endif;
