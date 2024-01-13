<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['name']) && isset($_POST['rate']) && isset($_POST['id_theloai']) && isset($_POST['id_dv']) && isset($_POST['server']) && isset($_POST['id_sv']) && isset($_POST['status'])) :


    $name        = $_POST['name'];
    $id_dv       = $_POST['id_dv'];
    $id_theloai  = $_POST['id_theloai'];
    $rate        = $_POST['rate'];
    $sv      = $_POST['server'];
    $id_sv       = $_POST['id_sv'];
    $note        = $_POST['note'];
    $status      = $_POST['status'];

    $theloai = $DB->query_one("theloai", ['id_theloai' => $id_theloai]);
    $service = $DB->query_one("service", ['id_dv'      => $id_dv,'id_theloai' => $id_theloai]);
    $server = $DB->query_one("server", ['id_sv'      => $id_sv,'id_dv'      => $id_dv,'id_theloai' => $id_theloai]);
    $server2 = $DB->query_one("server", ['server'      => $sv,'id_dv'      => $id_dv,'id_theloai' => $id_theloai]);

    if (!Auth::user()) :
        echo send('error', 'Đm đăng nhập ngay! cho cái dép giờ');
    elseif (empty($name)) :
        echo send('error', 'Tên server không được bỏ trống');
    elseif (empty($rate)) :
        echo send('error', 'Giá tiền không được bỏ trống');
    elseif(empty($id_dv)):
        echo send('error','ID server không được bỏ trống');
    elseif(empty($id_theloai)):
        echo send('error','ID thể loại không được bỏ trống');
    elseif(empty($sv)):
        echo send('error','Server không được bỏ trống ');
    elseif(empty($id_sv)):
        echo send('error','ID server không được bỏ trống');
    elseif(empty($note)):
        echo send('error','Lưu ý không được bỏ trống');
    elseif(empty($status)):    
        echo send('error','Trạng thái không được bỏ trống');
    elseif (!isset($theloai['id'])) :
        echo send('error', 'Thể loại này không tồn tại');
    elseif (!isset($service['id'])) :
        echo send('error', 'Dịch vụ này không tồn tại');
    elseif (isset($server['id'])) :
        echo send('error', 'ID server này đã tồn tại');
    elseif (isset($server2['id'])) :
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
        $save['domain']       = $_SERVER['SERVER_NAME'];

        if ($DB->save('server', $save)) :
            $sitecon = $DB->query("sitecon");
            foreach($sitecon as $key => $value):
                $DB->save('server', [
                    'name'       => $name, 
                    'rate'       => $rate,
                    'server'     => $sv,
                    'id_theloai' => $id_theloai,
                    'id_dv'      => $id_dv,
                    'id_sv'      => $id_sv,
                    'note'       => $note,
                    'status'     => $status,
                    'domain'     => $value['domain']
                ]);
            endforeach;

            echo send('success', 'Tạo server thành công');
        else :
            echo send('error', 'Tạo server thất bại');
        endif;
    else :
        echo send('error', 'Tài khoản bạn không phải quản trị viên');
    endif;
else :
    echo send('error', 'dữ liệu gửi lên không hợp lệ');
endif;
