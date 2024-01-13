<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['username']) && isset($_POST['password'])) :
    $token = getToken(13);

    $username = str($_POST['username']);
    $password = $_POST['password'];

    $users = $DB->query_one('users', ['username' => $username,'domain'=>$_SERVER['SERVER_NAME']]);
    $update = ['token' => $token,'domain'=>$_SERVER['SERVER_NAME']];

    $ip = get_ip();
    $date = getTime();

    $history = [
        'username' => $username,
        'device'   => getBrowser()['platform'],
        'browser'  => getBrowser()['name'],
        'note'     => "Bạn đã đăng nhập trên ip $ip vào lúc $date",
        'ip'       => $ip,
        'date'     => $date,
        'domain'   =>$_SERVER['SERVER_NAME']
    ];
    
    if (Auth::user()):
        echo send('error', 'Ngu à đăng nhập rồi vào làm gì');
    elseif (empty($username)) :
        echo send('error', 'Tên đăng nhập không được bỏ trống');
    elseif (empty($password)) :
        echo send('error', 'Mật khẩu không được bỏ trống');
    elseif (!isset($users['username'])) :
        echo send('error', 'Tài khoản không tồn tại');
    elseif (!Hash::check($password, $users['password'])) :
        echo send('error', 'Mật khẩu không chính xác');
    elseif($users['status'] == 'OFF'):
        echo send('error','Ngu tài khoản mày đã bị ban');
    elseif ($DB->update('users', $update, ['username' => $username,'domain'=>$_SERVER['SERVER_NAME']]) && $DB->save('history', $history)) :
        $_SESSION['users'] = $token;
        echo send('success', 'Đăng nhập thành công đúng em anh');
    else :
        echo send('error', 'Đăng nhập thất bại ngu như lợn');
    endif;
else :
    echo send('error', 'dữ liệu gửi lên không hợp lệ');
endif;
