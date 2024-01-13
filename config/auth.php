<?php
class Auth
{
    static public function user()
    {
        global $DB;

        if (isset($_SESSION['users'])) :
            $token = $_SESSION['users'];
            $users = $DB->query_one('users', ['token' => $token, 'domain' => $_SERVER['SERVER_NAME']]);
            if (isset($users['id'])) :
                if ($users['status'] === "OFF") :
                    static::logout();
                    return false;
                else :
                    $data = [];
                    $data['id']       = $users['id'];
                    $data['name']     = $users['name'];
                    $data['username'] = $users['username'];
                    $data['apikey']   = $users['apikey'];
                    $data['coin']     = $users['coin'];
                    $data['level']    = $users['level'];
                    $data['status']   = $users['status'];
                    $data['ip']       = $users['ip'];
                    $data['date']     = $users['date'];
                    return json_decode(json_encode($data));
                endif;
            else :
                static::logout();
                return false;
            endif;
        else :
            return false;
        endif;
    }

    static public function guest()
    {
        if (!static::user()) :
            header('location: /auth/login');
        endif;
    }

    static public function next()
    {
        if (static::user()) :
            header('location: /home');
        endif;
    }

    static public function logout()
    {
        unset($_SESSION['users']);
    }

    static public function admin()
    {
        global $DB;

        if (!static::user()) :
            header('location: /auth/login');
        else :
            if (static::user()->level < 3) :
                if ($DB->update('users', ['status' => 'OFF'], ['username' => static::user()->username, 'domain' => $_SERVER['SERVER_NAME']])) :
                    header('location: /home');
                else :
                    header('location: /home');
                endif;
            else :
                return true;
            endif;
        endif;
    }

    static public function admin_api()
    {
        global $DB;

        if (!static::user()) :
            return false;
        else :
            if (static::user()->level < 3) :
                if ($DB->update('users', ['status' => 'OFF'], ['username' => static::user()->username, 'domain' => $_SERVER['SERVER_NAME']])) :
                    return true;
                else :
                    return true;
                endif;
            else :
                return true;
            endif;
        endif;
    }
    static public function admin_main_site()
    {
        if (!static::user()) :
            header('location: /home');
        else :
            if (static::user()->level == 3):
                return false;
           elseif (static::user()->level != 4):
                header('location: /home');
            else :
                return true;
            endif;
        endif;
    }

    static public function admin_main2()
    {
        if (!static::user()) :
            return false;
        elseif (static::user()->level == 4) :
            return true;
        elseif (static::user()->level == 3) :
            return false;
        else :
            return false;
        endif;
    }
    static public function admin_main()
    {
        if (!static::user()) :
            return false;
        elseif (static::user()->level == 4) :
            return true;
        elseif (static::user()->level == 3) :
            return true;
        else :
            return false;
        endif;
    }
    static public function site_check()
    {
        global $DB;
        $site = $DB->query_one('site', ['domain' => $_SERVER['SERVER_NAME']]);
        if (!isset($site['domain'])) :
            if ($_SERVER['REQUEST_URI'] != '/auth/install') :
                header('location: /auth/install');
            endif;
        elseif ($_SERVER['REQUEST_URI'] == '/auth/install') :
            die(header('location: /home'));
        endif;
    }
    static public function site_check_live()
    {
        global $DB;
        $site = $DB->query_one('site', ['domain' => $_SERVER['SERVER_NAME']]);
        if (!isset($site['domain'])) :
           
        elseif ($site['status'] == 'OFF') :
            die(header('location: /baotri.html'));
        endif;
    }
}
