<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['password']) && isset($_POST['new_password']) &&  isset($_POST['confirm_password'])):

    $password = $_POST['password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $update = ['password'=>Hash::make($new_password),'domain'=>$_SERVER['SERVER_NAME']];

    $users = $DB->query_one('users',['username'=>Auth::user()->username,'domain'=>$_SERVER['SERVER_NAME']]);

    if (!Auth::user()):
        echo send('error', 'Đm đăng nhập ngay! cho cái dép giờ');
    elseif(empty($password)):
        echo send('error','Mật khẩu không được bỏ trống');
    elseif(strlen($password) < 4):
        echo send('error','Mật khẩu phải có 4 ký tự trở lên');
    elseif(strlen($password) > 20):
        echo send('error','Mật khẩu không được quá 32 ký tự trở lên');
    elseif(!Hash::check($password,$users['password'])):
        echo send('error','Ăn gì ngu thế mỗi mật khẩu cũng quên');
    elseif(empty($new_password)):
        echo send('error','Mật khẩu mới không được bỏ trống');
    elseif(strlen($new_password) < 4):
        echo send('error','Mật khẩu mới phải có 4 ký tự trở lên');
    elseif(strlen($new_password) > 20):
        echo send('error','Mật khẩu mới không được quá 32 ký tự trở lên');
    elseif($password == $new_password):
        echo send('error','Bày đặt mật khẩu mới trùng rồi kìa');
    elseif(empty($confirm_password)):
        echo send('error','Mật khẩu xác thực không được bỏ trống');
    elseif(strlen($confirm_password) < 4):
        echo send('error','Mật khẩu xác thực phải có 4 ký tự trở lên');
    elseif(strlen($confirm_password) > 20):
        echo send('error','Mật khẩu xác thực không được quá 32 ký tự trở lên');
    elseif($confirm_password != $new_password):
        echo send('error','Mật khẩu xác thực sai rồi kìa');
    elseif ($DB->update('users', $update, ['username' => Auth::user()->username,'domain'=>$_SERVER['SERVER_NAME']]) ) :
        echo send('success', 'Đổi mật khẩu thành công đúng con trai của ta');
    else :
        echo send('error', 'Đổi mật khẩu cũng ngu');
    endif;
else :
    echo send('error', 'dữ liệu gửi lên không hợp lệ');
endif;
