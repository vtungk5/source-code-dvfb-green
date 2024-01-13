<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['domain']) && isset($_POST['status'])) :

    $uid = $_POST['uid'];
    $status = $_POST['status'];
    $domain = $_POST['domain'];

    $sitecon = $DB->query_one("sitecon", ['domain' => $domain]);
    $sitecon2 = $DB->query_one("sitecon", ['id' => $uid]);

    if (!Auth::user()) :
        echo send('error', 'Đm đăng nhập ngay! cho cái dép giờ');
    elseif (empty($domain)) :
        echo send('error', 'Tên miền không được bỏ trống');
    elseif (empty($status)) :
        echo send('error', 'Trạng thái không được bỏ trống');
    elseif (isset($sitecon['id'])) :
        if ($sitecon['domain'] != $sitecon2['domain']) :
            echo send('error', 'Tên miền đã tồn tại');
        elseif (Auth::admin_main_site() && $SITEMAIN == $_SERVER['SERVER_NAME']) :
            $save = [];
            $save['domain'] =$domain;
            $save['status'] =$status;
            if($DB->update('sitecon',$save,['id'=>$uid])):
                echo send('success', 'Cập nhập tên miền đại lý thành công');
            else:
                echo send('error', 'Cập nhập tên miền đại lý thất bại');
            endif;
        else :
            echo send('error', 'Tài khoản bạn không phải quản trị viên');
        endif;
    elseif (Auth::admin_main_site() && $SITEMAIN == $_SERVER['SERVER_NAME']) :
        $save = [];
        $save['domain'] =$domain;
        $save['status'] =$status;
        if($DB->update('sitecon',$save,['id'=>$uid])):
            echo send('success', 'Cập nhập tên miền đại lý thành công');
        else:
            echo send('error', 'Cập nhập tên miền đại lý thất bại');
        endif;
    else :
        echo send('error', 'Tài khoản bạn không phải quản trị viên');
    endif;
endif;
