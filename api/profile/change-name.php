<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['name'])):

    $name = $_POST['name'];
    $update = ['name'=>$name,'domain'=>$_SERVER['SERVER_NAME']];
    
    if (!Auth::user()):
        echo send('error', 'Đm đăng nhập ngay! cho cái dép giờ');
    elseif (empty($name)) :
        echo send('error', 'Ơ thằng kia tên mày đâu');
    elseif(strlen($name) < 6):
        echo send('error','Họ và tên phải có 6 ký tự trở lên');
    elseif(strlen($name) > 50):
        echo send('error','Họ và tên không được quá 50 ký tự trở lên');
    elseif ($DB->update('users', $update, ['username' => Auth::user()->username,'domain'=>$_SERVER['SERVER_NAME']]) ) :
        echo send('success', 'Ô chào thằng '.$name.' tên hay đấy',['name'=>$name]);
    else :
        echo send('error', 'Tên như cc chả trách lỗi');
    endif;
else :
    echo send('error', 'dữ liệu gửi lên không hợp lệ');
endif;
