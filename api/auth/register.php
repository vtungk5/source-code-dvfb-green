<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['name']) && isset($_POST['username']) && isset($_POST['password'])) :
    
    $name     = str($_POST['name']);
    $username = str($_POST['username']);
    $password = $_POST['password'];
    
    $token   = getToken(13);
    $apikey  = getToken(32);
    $ip      = get_ip();
    $browser = getBrowser()['name'];
    $device  = getBrowser()['platform'];
    $date    = getTime();

    $users = $DB->query_one('users', ['username' => $username,'domain'=>$_SERVER['SERVER_NAME']]);
    $check = $DB->num_rows('users', ['ip' =>  $ip]);

    $create_account = [
        'name'     => $name,
        'username' => $username, 
        'password' => Hash::make($password), 
        'apikey'   => $apikey,
        'token'    => $token,
        'level'    => 0,
        'date'     => $date,
        'ip'       => $ip,
        'domain'=>$_SERVER['SERVER_NAME']
    ];

    $list_history = [
        'username' => $username,
        'device'   => getBrowser()['platform'],
        'browser'  => getBrowser()['name'],
        'note'     => "Bạn đã đăng ký trên ip $ip vào lúc $date",
        'ip'       => $ip,
        'date'     => $date,
        'domain'=>$_SERVER['SERVER_NAME']
    ];
    if (Auth::user()):
        echo send('error', 'Ngu à đăng nhập rồi vào làm gì');
    elseif(empty($name)):
        echo send('error','Họ và tên không được bỏ trống');
    elseif(strlen($name) < 6):
        echo send('error','Họ và tên phải có 6 ký tự trở lên');
    elseif(strlen($name) > 32):
        echo send('error','Họ và tên không được quá 32 ký tự trở lên');
    elseif(isset($users['username'])):
        echo send('error','Tên đăng nhập này đã tồn tại');
    elseif(empty($username)):
        echo send('error','Tên đăng nhập không được bỏ trống');
    elseif(strlen($username) < 4):
        echo send('error','Tên đăng nhập phải có 4 ký tự trở lên');
    elseif(strlen($username) > 15):
        echo send('error','Tên đăng nhập không được quá 32 ký tự trở lên');
    elseif(empty($password)):
        echo send('error','Mật khẩu không được bỏ trống');
    elseif(strlen($password) < 4):
        echo send('error','Mật khẩu phải có 4 ký tự trở lên');
    elseif(strlen($password) > 20):
        echo send('error','Mật khẩu không được quá 32 ký tự trở lên');
    elseif($check > 2):
        echo send('error','Không được đăng ký quá nhiều tài khoản');
    elseif($DB->save('users',$create_account) && $DB->save('history', $list_history)):
        $_SESSION['users'] = $token;
        echo send('success','Đăng ký tài khoản thành công rồi thằng em');
    else:
        echo send('error','Đăng ký thất bại rồi óc chó');
    endif;

else:
    echo send('error', 'dữ liệu gửi lên không hợp lệ');
endif;
