<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['uid']) && isset($_POST['name']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['coin']) && isset($_POST['level']) && isset($_POST['status'])) :

    $uid      = str($_POST['uid']);
    $name     = str($_POST['name']);
    $username = str($_POST['username']);
    $password = $_POST['password'];
    $coin     = str($_POST['coin']);
    $level    = str($_POST['level']);
    $status   = str($_POST['status']);

    $users2 = $DB->query_one("users", ['id' => $uid]);

    if (Auth::user()->level == 4) :
        $users = $DB->query_one("users", ['username' => $username, 'domain' => $_SERVER['SERVER_NAME']]);
    else :
        $users = $DB->query_one("users", ['username' => $username, 'domain' => $users2['domain']]);
    endif;
    

    if (!Auth::user()) :
        echo send('error', 'Đm đăng nhập ngay! cho cái dép giờ');
    elseif (empty($uid)) :
        echo send('error', 'Định danh tài khoản không được bỏ trống');
    elseif (empty($name)) :
        echo send('error', 'Họ và tên không được bỏ trống');
    elseif (strlen($name) < 6) :
        echo send('error', 'Họ và tên phải có 6 ký tự trở lên');
    elseif (strlen($name) > 32) :
        echo send('error', 'Họ và tên không được quá 32 ký tự trở lên');
    elseif (empty($username)) :
        echo send('error', 'Tên đăng nhập không được bỏ trống');
    elseif (strlen($username) < 4) :
        echo send('error', 'Tên đăng nhập phải có 4 ký tự trở lên');
    elseif (strlen($username) > 15) :
    elseif ($coin == null) :
        echo send('error', 'Số dư không được bỏ trống');
    elseif ($level == null) :
        echo send('error', 'Cấp bậc không được bỏ trống');
    elseif (empty($status)) :
        echo send('error', 'Trạng thái không được bỏ trống');
    elseif (!isset($users2['id'])) :
        echo send('error', 'Tài khoản không tồn tại');
    elseif (isset($users['username'])) :
        if ($users['username'] !=  $username) :
            echo send('error', 'Tên đăng nhập đã tồn tại');
        else :
            if (Auth::admin_main_site() && $SITEMAIN == $_SERVER['SERVER_NAME']) :
                if ($password == null) :
                    $save = [];
                    $save['name']     = $name;
                    $save['username'] = $username;
                    $save['coin']     = $coin;
                    $save['level']    = $level;
                    $save['status']   = $status;

                    if ($DB->update('users', $save, ['id' => $uid])) :
                        echo send('success', 'lưu tài khoản thành công');
                    else :
                        echo send('error', 'Lưu thông tin thất bại');
                    endif;
                elseif (empty($password)) :
                    echo send('error', 'Mật khẩu không được bỏ trống');
                elseif (strlen($password) < 4) :
                    echo send('error', 'Mật khẩu phải có 4 ký tự trở lên');
                elseif (strlen($password) > 20) :
                    echo send('error', 'Mật khẩu không được quá 32 ký tự trở lên');
                else :

                    $save = [];
                    $save['name']     = $name;
                    $save['username'] = $username;
                    $save['password'] = Hash::make($password);
                    $save['coin']     = $coin;
                    $save['level']    = $level;
                    $save['status']   = $status;

                    if ($DB->update('users', $save, ['id' => $uid])) :
                        echo send('success', 'lưu tài khoản thành công');
                    else :
                        echo send('error', 'Lưu thông tin thất bại');
                    endif;

                endif;
            elseif ($users2['domain'] != $_SERVER['SERVER_NAME']) :
                echo send('error', 'Tài khoản không tồn tại');
            elseif (Auth::admin()) :
                if ($password == null) :
                    $save = [];
                    $save['name']     = $name;
                    $save['username'] = $username;
                    $save['coin']     = $coin;
                    $save['level']    = $level;
                    $save['status']   = $status;

                    if ($DB->update('users', $save, ['id' => $uid])) :
                        echo send('success', 'lưu tài khoản thành công');
                    else :
                        echo send('error', 'Lưu thông tin thất bại');
                    endif;
                elseif (empty($password)) :
                    echo send('error', 'Mật khẩu không được bỏ trống');
                elseif (strlen($password) < 4) :
                    echo send('error', 'Mật khẩu phải có 4 ký tự trở lên');
                elseif (strlen($password) > 20) :
                    echo send('error', 'Mật khẩu không được quá 32 ký tự trở lên');
                else :
                    $save = [];
                    $save['name']     = $name;
                    $save['username'] = $username;
                    $save['password'] = Hash::make($password);
                    $save['coin']     = $coin;
                    $save['level']    = $level;
                    $save['status']   = $status;

                    if ($DB->update('users', $save, ['id' => $uid])) :
                        echo send('success', 'lưu tài khoản thành công');
                    else :
                        echo send('error', 'Lưu thông tin thất bại');
                    endif;
                endif;
            else :
                echo send('error', 'Tài khoản bạn không phải quản trị viên');
            endif;
        endif;
    elseif (Auth::admin_main_site() && $SITEMAIN == $_SERVER['SERVER_NAME']) :
        if ($password == null) :
            $save = [];
            $save['name']     = $name;
            $save['username'] = $username;
            $save['coin']     = $coin;
            $save['level']    = $level;
            $save['status']   = $status;

            if ($DB->update('users', $save, ['id' => $uid])) :
                echo send('success', 'lưu tài khoản thành công');
            else :
                echo send('error', 'Lưu thông tin thất bại');
            endif;
        elseif (empty($password)) :
            echo send('error', 'Mật khẩu không được bỏ trống');
        elseif (strlen($password) < 4) :
            echo send('error', 'Mật khẩu phải có 4 ký tự trở lên');
        elseif (strlen($password) > 20) :
            echo send('error', 'Mật khẩu không được quá 32 ký tự trở lên');
        else :

            $save = [];
            $save['name']     = $name;
            $save['username'] = $username;
            $save['password'] = Hash::make($password);
            $save['coin']     = $coin;
            $save['level']    = $level;
            $save['status']   = $status;

            if ($DB->update('users', $save, ['id' => $uid])) :
                echo send('success', 'lưu tài khoản thành công');
            else :
                echo send('error', 'Lưu thông tin thất bại');
            endif;

        endif;
    elseif ($users2['domain'] != $_SERVER['SERVER_NAME']) :
        echo send('error', 'Tài khoản không tồn tại');
    elseif (Auth::admin()) :
        if ($password == null) :
            $save = [];
            $save['name']     = $name;
            $save['username'] = $username;
            $save['coin']     = $coin;
            $save['level']    = $level;
            $save['status']   = $status;

            if ($DB->update('users', $save, ['id' => $uid])) :
                echo send('success', 'lưu tài khoản thành công');
            else :
                echo send('error', 'Lưu thông tin thất bại');
            endif;
        elseif (empty($password)) :
            echo send('error', 'Mật khẩu không được bỏ trống');
        elseif (strlen($password) < 4) :
            echo send('error', 'Mật khẩu phải có 4 ký tự trở lên');
        elseif (strlen($password) > 20) :
            echo send('error', 'Mật khẩu không được quá 32 ký tự trở lên');
        else :
            $save = [];
            $save['name']     = $name;
            $save['username'] = $username;
            $save['password'] = Hash::make($password);
            $save['coin']     = $coin;
            $save['level']    = $level;
            $save['status']   = $status;

            if ($DB->update('users', $save, ['id' => $uid])) :
                echo send('success', 'lưu tài khoản thành công');
            else :
                echo send('error', 'Lưu thông tin thất bại');
            endif;

        endif;
    else :
        echo send('error', 'Tài khoản bạn không phải quản trị viên');
    endif;
else :
    echo send('error', 'dữ liệu gửi lên không hợp lệ');
endif;
