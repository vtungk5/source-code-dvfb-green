<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['logo']) && isset($_POST['title']) && isset($_POST['description']) &&  isset($_POST['keyword'])&&  isset($_POST['partner_id'])&&  isset($_POST['partner_key'])&&  isset($_POST['rate_ctv'])&&  isset($_POST['rate_daily'])&& isset($_POST['apikey_momo'])&& isset($_POST['username_mb'])&& isset($_POST['stk_mb'])&& isset($_POST['password_mb'])&& isset($_POST['stk_momo']) && isset($_POST['coin_ctv'])&&  isset($_POST['coin_daily'])&& isset($_POST['notify'])&& isset($_POST['name_momo'])&& isset($_POST['name_mb'])) :

    $logo        = $_POST['logo'];
    $title       = $_POST['title'];
    $description = $_POST['description'];
    $keyword     = $_POST['keyword'];
    $partner_id  = $_POST['partner_id'];
    $partner_key = $_POST['partner_key'];
    $rate_ctv    = $_POST['rate_ctv'];
    $rate_daily  = $_POST['rate_daily'];
    $coin_ctv    = $_POST['coin_ctv'];
    $coin_daily  = $_POST['coin_daily'];
    $notify      = $_POST['notify'];
    $stk_momo    = $_POST['stk_momo'];
    $name_momo   = $_POST['name_momo'];
    $apikey_momo = $_POST['apikey_momo'];
    $username_mb = $_POST['username_mb'];
    $stk_mb      = $_POST['stk_mb'];
    $name_mb     = $_POST['name_mb'];
    $password_mb = $_POST['password_mb'];


    $site = $DB->query_one("site", ['domain' => $_SERVER['SERVER_NAME'],'status'=>'ON']);


    if (!Auth::user()) :
        echo send('error', 'Đm đăng nhập ngay! cho cái dép giờ');
    elseif(empty($logo)):
        echo send('error','Logo không được bỏ trống');
    elseif(empty($title)):
        echo send('error','Tiêu đề không được bỏ trống');
    elseif(empty($description)):
        echo send('error','Mô tả không được bỏ trống');
    elseif(empty($keyword)):
        echo send('error','Từ khóa không được bỏ trống');
    elseif(empty($rate_ctv)):
        echo send('error','Giảm giá cộng tác viên không được bỏ trống');
    elseif(empty($rate_daily)):
        echo send('error','Giảm giá đại lý  không được bỏ trống');
    elseif(empty($coin_ctv)):
        echo send('error','Mức nạp lên cộng tác viên không được bỏ trống');
    elseif(empty($coin_daily)):
        echo send('error','Mức nạp lên đại lý  không được bỏ trống');
    elseif (!isset($site['stt'])) :
        echo send('error', 'Website chưa được kích hoạt');
    elseif (Auth::admin()) :
        $save = [];
        $save['logo']         = $logo ;     
        $save['title']        = $title ;     
        $save['description']  = $description;
        $save['keyword']      = $keyword;
        $save['partner_id']   = $partner_id;
        $save['partner_key']  = $partner_key;
        $save['rate_ctv']     = $rate_ctv;
        $save['rate_daily']   = $rate_daily;
        $save['coin_ctv']     = $coin_ctv;
        $save['coin_daily']   = $coin_daily;
        $save['apikey_momo']  = $apikey_momo;
        $save['stk_momo']     = $stk_momo;
        $save['name_momo']    = $name_momo;
        $save['username_mb']  = $username_mb;
        $save['password_mb']  = $password_mb;
        $save['name_mb']      = $name_mb;
        $save['stk_mb']       = $stk_mb;
        $save['notify']       = $notify;
        
        if ($DB->update('site', $save,['domain'=>$_SERVER['SERVER_NAME']])) :
            echo send('success', 'Cập nhập cài đặt thành công');
        else :
            echo send('error', 'Cập nhập cài đặt thất bại');
        endif;
    else :
        echo send('error', 'Tài khoản bạn không phải quản trị viên');
    endif;
else :
    echo send('error', 'dữ liệu gửi lên không hợp lệ');
endif;
