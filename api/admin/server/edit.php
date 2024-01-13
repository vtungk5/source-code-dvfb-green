<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['name']) && isset($_POST['rate']) && isset($_POST['note']) && isset($_POST['status'])) :


    $uid         = $_POST['uid'];
    $name        = $_POST['name'];
    $id_dv       = $_POST['id_dv'];
    $id_theloai  = $_POST['id_theloai'];
    $rate        = $_POST['rate'];
    $sv          = $_POST['server'];
    $id_sv       = $_POST['id_sv'];
    $note        = $_POST['note'];
    $status      = $_POST['status'];

    $theloai = $DB->query_one("theloai", ['id_theloai' => $id_theloai]);
    $service = $DB->query_one("service", ['id_dv' => $id_dv, 'id_theloai' => $id_theloai]);
    $server2 = $DB->query_one("server", ['server' => $sv, 'id_dv' => $id_dv, 'id_theloai' => $id_theloai, 'domain' => $_SERVER['SERVER_NAME']]);
    $server3 = $DB->query_one("server", ['id'  => $uid, 'domain' => $_SERVER['SERVER_NAME']]);

    if (!Auth::user()) :
        echo send('error', 'Đm đăng nhập ngay! cho cái dép giờ');
    elseif (empty($name)) :
        echo send('error', 'Tên server không được bỏ trống');
    elseif (empty($rate)) :
        echo send('error', 'Giá tiền không được bỏ trống');
    elseif (empty($id_dv)) :
        echo send('error', 'ID dịch vụ không được bỏ trống');
    elseif (empty($id_theloai)) :
        echo send('error', 'ID thể loại không được bỏ trống');
    elseif (empty($sv)) :
        echo send('error', 'Server không được bỏ trống');
    elseif (empty($note)) :
        echo send('error', 'Lưu ý không được bỏ trống');
    elseif (empty($status)) :
        echo send('error', 'Trạng thái không được bỏ trống');
    elseif (!isset($server3['id'])) :
        echo send('error', 'Định danh server này không tồn tại');
    elseif (!isset($theloai['id'])) :
        echo send('error', 'Thể loại này không tồn tại');
    elseif (!isset($service['id'])) :
        echo send('error', 'Dịch vụ này không tồn tại');
    elseif (Auth::admin()) :
        $save = [];
        $save['rate']         = $rate;
        $save['note']         = $note;
        $save['status']       = $status;
        if ($DB->update('server', $save, ['id'  => $uid, 'domain' => $_SERVER['SERVER_NAME']])) :
            echo send('success', 'Cập nhập server thành công');
        else :
            echo send('error', 'Cập nhập server thất bại');
        endif;
    elseif (empty($id_sv)) :
        echo send('error', 'ID server không được bỏ trống');
    elseif (isset($server['id'])) :
        if ($server3['id_sv'] != $server['id_sv']) :
            echo send('error', 'ID server này đã tồn tại');
        elseif (isset($server2['id'])) :
            if ($server2['server'] != $server3['server']) :
                echo send('error', 'server này đã tồn tại');
            elseif (Auth::admin_main_site() && $SITEMAIN == $_SERVER['SERVER_NAME']) :
                $save = [];
                $save['name']         = $_POST['name'];
                $save['rate']         = $_POST['rate'];
                $save['server']       = $_POST['server'];
                $save['id_theloai']   = $_POST['id_theloai'];
                $save['id_dv']        = $_POST['id_dv'];
                $save['id_sv']        = $_POST['id_sv'];
                $save['note']         = $_POST['note'];
                $save['status']       = $_POST['status'];

                if ($DB->update('server', $save, ['id'  => $uid, 'domain' => $_SERVER['SERVER_NAME']])) :
                    echo send('success', 'Cập nhập server thành công');
                else :
                    echo send('error', 'Cập nhập server thất bại');
                endif;
            elseif (Auth::admin()) :
                $save = [];
                $save['rate']         = $rate;
                $save['note']         = $note;
                $save['status']       = $status;
                if ($DB->update('server', $save, ['id'  => $uid, 'domain' => $_SERVER['SERVER_NAME']])) :
                    echo send('success', 'Cập nhập server thành công');
                else :
                    echo send('error', 'Cập nhập server thất bại');
                endif;
            else :
                echo send('error', 'Tài khoản bạn không phải quản trị viên');
            endif;
        elseif (Auth::admin() && $server3['domain']  == $_SERVER['SERVER_NAME']) :
            $save = [];
            $save['name']         = $_POST['name'];
            $save['rate']         = $_POST['rate'];
            $save['server']       = $_POST['server'];
            $save['id_theloai']   = $_POST['id_theloai'];
            $save['id_dv']        = $_POST['id_dv'];
            $save['id_sv']        = $_POST['id_sv'];
            $save['note']         = $_POST['note'];
            $save['status']       = $_POST['status'];

            if ($DB->update('server', $save, ['id'  => $uid, 'domain' => $_SERVER['SERVER_NAME']])) :
                echo send('success', 'Cập nhập server thành công');
            else :
                echo send('error', 'Cập nhập server thất bại');
            endif;
        elseif (Auth::admin() && $server3['domain']  == $_SERVER['SERVER_NAME']) :
            $save = [];
            $save['rate']         = $rate;
            $save['note']         = $note;
            $save['status']       = $status;
            if ($DB->update('server', $save, ['id'  => $uid, 'domain' => $_SERVER['SERVER_NAME']])) :
                echo send('success', 'Cập nhập server thành công');
            else :
                echo send('error', 'Cập nhập server thất bại');
            endif;
        else :
            echo send('error', 'Tài khoản bạn không phải quản trị viên');
        endif;
    elseif (isset($server2['id'])) :
        if ($server2['server'] != $server3['server']) :
            echo send('error', 'server này đã tồn tại');
        elseif (Auth::admin_main_site() && $SITEMAIN == $_SERVER['SERVER_NAME']) :
            $save = [];
            $save['name']         = $_POST['name'];
            $save['rate']         = $_POST['rate'];
            $save['server']       = $_POST['server'];
            $save['id_theloai']   = $_POST['id_theloai'];
            $save['id_dv']        = $_POST['id_dv'];
            $save['id_sv']        = $_POST['id_sv'];
            $save['note']         = $_POST['note'];
            $save['status']       = $_POST['status'];

            if ($DB->update('server', $save, ['id'  => $uid, 'domain' => $_SERVER['SERVER_NAME']])) :
                echo send('success', 'Cập nhập server thành công');
            else :
                echo send('error', 'Cập nhập server thất bại');
            endif;
        elseif (Auth::admin() && $server3['domain']  == $_SERVER['SERVER_NAME']) :
            $save = [];
            $save['rate']         = $rate;
            $save['note']         = $note;
            $save['status']       = $status;
            if ($DB->update('server', $save, ['id'  => $uid, 'domain' => $_SERVER['SERVER_NAME']])) :
                echo send('success', 'Cập nhập server thành công');
            else :
                echo send('error', 'Cập nhập server thất bại');
            endif;
        else :
            echo send('error', 'Tài khoản bạn không phải quản trị viên');
        endif;
    elseif (Auth::admin_main_site() && $SITEMAIN == $_SERVER['SERVER_NAME']) :
        $save = [];
        $save['name']         = $_POST['name'];
        $save['rate']         = $_POST['rate'];
        $save['server']       = $_POST['server'];
        $save['id_theloai']   = $_POST['id_theloai'];
        $save['id_dv']        = $_POST['id_dv'];
        $save['id_sv']        = $_POST['id_sv'];
        $save['note']         = $_POST['note'];
        $save['status']       = $_POST['status']; 

        if ($DB->update('server', $save, ['id'  => $uid, 'domain' => $_SERVER['SERVER_NAME']])) :
            echo send('success', 'Cập nhập server thành công');
        else :
            echo send('error', 'Cập nhập server thất bại');
        endif;
    elseif (Auth::admin() && $server3['domain']  == $_SERVER['SERVER_NAME']) :
        $save = [];
        $save['rate']         = $rate;
        $save['note']         = $note;
        $save['status']       = $status;
        if ($DB->update('server', $save, ['id'  => $uid, 'domain' => $_SERVER['SERVER_NAME']])) :
            echo send('success', 'Cập nhập server thành công');
        else :
            echo send('error', 'Cập nhập server thất bại');
        endif;
    else :
        echo send('error', 'Tài khoản bạn không phải quản trị viên');
    endif;
else :
    echo send('error', 'dữ liệu gửi lên không hợp lệ');
endif;
