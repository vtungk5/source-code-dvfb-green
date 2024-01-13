<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['uid']) && isset($_POST['server']) && isset($_POST['amount']) && isset($_GET['theloai']) & isset($_GET['dichvu'])) :
    $uid = $_POST['uid'];
    $server = $_POST['server'];
    $amount = $_POST['amount'];
    $reaction = $_POST['reaction'];
    $note = $_POST['note'];
    $id_dv = $_GET['dichvu'];
    $id_theloai = $_GET['theloai'];
    $theloai = $DB->query_one('theloai', ['path' => $id_theloai]);
    $dichvu = $DB->query_one('service', ['path' => $id_dv, 'id_theloai' => $theloai['id_theloai'], 'status' => 'ON']);
    $check_rate = $DB->query_one('site', ['domain' => $_SERVER['SERVER_NAME']]);
    $sv = $DB->query_one('server', ['id_dv' => $dichvu['id_dv'], 'id_theloai' => $dichvu['id_theloai'], 'server' => trim($server, 'sv'), 'status' => 'ON', 'domain' => $_SERVER['SERVER_NAME']]);
    $rate = $sv['rate'] * $amount;


    $Buffme = new Buffme;
    $Buffme->domain($dichvu['nguon']);
    $Buffme->apikey($dichvu['apikey']);

    $save = [];
    $save['MGD'] = rand(342345, 23423438);
    $save['uid'] = $uid;
    $save['id_theloai'] = $theloai['id_theloai'];
    $save['id_dv'] = $dichvu['id_dv'];
    $save['server'] = $sv['server'];
    $save['amount'] = $amount;
    $save['money'] =  $rate;
    $save['note'] =  $note;
    $save['start'] =  0;
    $save['dachay'] =  0;
    $save['status'] =  'true';
    $save['date'] =  getTime();
    $save['domain'] = $_SERVER['SERVER_NAME'];

    $http['uid'] = $uid;
    $http['server'] = $sv['id_sv'];
    $http['amount'] = $amount;
    $http['note'] = $note;

    if ($dichvu['reaction'] == 'ON') :
        $reaction = $_POST['reaction'];
        if (empty($reaction)) :
            die(send('error', 'bot cảm xúc không được bỏ trống'));
        else :
            $rate += rate_reaction($reaction);
            $http['reaction'] = $reaction;
            $save['reaction'] = $reaction;
        endif;
    endif;

    if ($dichvu['speed'] == 'ON') :
        $speed = $_POST['speed'];
        if (empty($speed)) :
            die(send('error', 'Tốc độ không được bỏ trống'));
        else :
            $http['speed'] = $speed;
            $save['speed'] = $speed;
        endif;
    endif;

    if ($dichvu['comment'] == 'ON') :
        $comment = $_POST['comment'];
        if (empty($comment)) :
            die(send('error', 'Bình luận không được bỏ trống'));
        else :
            $http['comment'] = $comment;
            $save['comment'] = $comment;
        endif;
    endif;


    if (!Auth::user()) :
        $users = $DB->query_one('users', ['apikey' => $_SERVER['HTTP_AUTHORIZATION'], 'domain' => $_SERVER['SERVER_NAME']]);
        $save['username'] =  $users['username'];

        if (isset($users['id'])) :
            if (empty($uid)) :
                echo send('error', 'uid không được bỏ trống');
            elseif (empty($server)) :
                echo send('error', 'server không được bỏ trống');
            elseif (empty($amount)) :
                echo send('error', 'số lượng không được bỏ trống');
            elseif ($amount < 100) :
                echo send('error', 'số lượng không được nhỏ hơn 100');
            elseif (!isset($theloai['id'])) :
                echo send('error', 'thể loại không tồn tại');
            elseif (!isset($dichvu['id'])) :
                echo send('error', 'dịch vụ không tồn tại');
            elseif (!isset($sv['id'])) :
                echo send('error', 'server không tồn tại');
            elseif ($users['coin'] <  $rate) :
                echo send('error', 'Tài khoản hệ thống của bạn không đủ số dư');
            else :
                $site = $DB->query_one('site', ['domain' => $_SERVER['SERVER_NAME']]);
                if ($users['level'] == 2) :
                    if (preg_match('/%/', $site['rate_ctv'])) :
                        $tru = $rate * ((100 - trim($site['rate_ctv'], '%')) / 100);
                        $rate -= $tru;
                    else :
                        $rate -= $site['rate_ctv'];
                    endif;
                elseif ($users['level'] == 3) :
                    if (preg_match('/%/', $site['rate_daily'])) :
                        $tru = $rate * ((100 - trim($site['rate_daily'], '%')) / 100);
                        $rate -= $tru;
                    else :
                        $rate -= $site['rate_daily'];
                    endif;
                elseif ($users['level'] == 4) :
                    if (preg_match('/%/', $site['rate_daily'])) :
                        $tru = $rate * ((100 - trim($site['rate_daily'], '%')) / 100);
                        $rate -= $tru;
                    else :
                        $rate -= $site['rate_daily'];
                    endif;
                endif;

                $curd = Buffme::run($sv['id_theloai'], $sv['id_dv'], $http);
                if ($curd == false) :
                    $save['status'] =  'false';
                    $thanhtien = $users['coin'] - $rate;
                    $trutien = $DB->update('users', ['coin' => $thanhtien], ['username' => $users['username'], 'domain' => $_SERVER['SERVER_NAME']]);
                    if ($trutien) :
                        if ($DB->save('order', $save)) :
                            echo send('success', 'Mua dịch vụ thành công');
                        else :
                            echo send('error', 'Hệ thống đã xảy ra lỗi');
                        endif;
                    else :
                        echo send('error', 'Hệ thống đã xảy ra lỗi');
                    endif;
                else :
                    $buff = json_decode($curd);
                    if ($buff->status == true) :
                        $thanhtien = $users['coin'] - $rate;
                        $trutien = $DB->update('users', ['coin' => $thanhtien], ['username' => $users['username'], 'domain' => $_SERVER['SERVER_NAME']]);
                        if ($trutien) :
                            if ($DB->save('order', $save)) :
                                echo send('success', 'Mua dịch vụ thành công');
                            else :
                                echo send('error', 'Hệ thống đã xảy ra lỗi');
                            endif;
                        else :
                            echo send('error', 'Hệ thống đã xảy ra lỗi');
                        endif;
                    else :
                        echo send('error', $buff->message);
                    endif;
                endif;
            endif;
        else :
            echo send('error', 'api key không chính xác');
        endif;
    elseif ($_SERVER['SERVER_NAME'] != $SITEMAIN) :

        $apikey = $DB->query_one('site', ['domain' => $_SERVER['SERVER_NAME']])['apikey'];
        $users = $DB->query_one('users', ['apikey' => $apikey]);

        $save['username'] =  Auth::user()->username;

        $site = $DB->query_one('site', ['domain' => $_SERVER['SERVER_NAME']]);

        if (Auth::user()->level == 2) :
            if (preg_match('/%/', $site['rate_ctv'])) :
                $tru = $rate * ((100 - trim($site['rate_ctv'], '%')) / 100);
                $rate -= $tru;
            else :
                $rate -= $site['rate_ctv'];
            endif;
        elseif (Auth::user()->level == 3) :
            if (preg_match('/%/', $site['rate_daily'])) :
                $tru = $rate * ((100 - trim($site['rate_daily'], '%')) / 100);
                $rate -= $tru;
            else :
                $rate -= $site['rate_daily'];
            endif;
        elseif (Auth::user()->level == 4) :
            if (preg_match('/%/', $site['rate_daily'])) :
                $tru = $rate * ((100 - trim($site['rate_daily'], '%')) / 100);
                $rate -= $tru;
            else :
                $rate -= $site['rate_daily'];
            endif;
        endif;

        if (isset($users['id'])) :
            if (empty($uid)) :
                echo send('error', 'uid không được bỏ trống');
            elseif (empty($server)) :
                echo send('error', 'server không được bỏ trống');
            elseif (empty($amount)) :
                echo send('error', 'số lượng không được bỏ trống');
            elseif ($amount < 100) :
                echo send('error', 'số lượng không được nhỏ hơn 100');
            elseif (!isset($theloai['id'])) :
                echo send('error', 'thể loại không tồn tại');
            elseif (!isset($dichvu['id'])) :
                echo send('error', 'dịch vụ không tồn tại');
            elseif (!isset($sv['id'])) :
                echo send('error', 'server không tồn tại');
            elseif ($users['coin'] <  $rate) :
                echo send('error', 'Tài khoản hệ thống của bạn không đủ số dư');
            elseif (Auth::user()->coin <  $rate) :
                echo send('error', 'Tài khoản của bạn không đủ số dư');
            else :
                $curd = Buffme::run($sv['id_theloai'], $sv['id_dv'], $http);
                if ($curd == false) :
                    $site = $DB->query_one('site', ['domain' => $_SERVER['SERVER_NAME']]);
                    $save['status'] =  'false';
                    $thanhtien = Auth::user()->coin - $rate;
                    $trutien = $DB->update('users', ['coin' => $thanhtien], ['username' => Auth::user()->username, 'domain' => $_SERVER['SERVER_NAME']]);
                    if ($trutien) :
                        if ($DB->save('order', $save)) :
                            echo send('success', 'Mua dịch vụ thành công');
                        else :
                            echo send('error', 'Hệ thống đã xảy ra lỗi');
                        endif;
                    else :
                        echo send('error', 'Hệ thống đã xảy ra lỗi');
                    endif;
                else :
                    $buff = json_decode($curd);
                    if ($buff->status == true) :
                        $site = $DB->query_one('site', ['domain' => $_SERVER['SERVER_NAME']]);
                        $thanhtien = Auth::user()->coin - $rate;
                        $trutien = $DB->update('users', ['coin' => $thanhtien], ['username' => Auth::user()->username, 'domain' => $_SERVER['SERVER_NAME']]);
                        if ($trutien) :
                            if ($DB->save('order', $save)) :
                                echo send('success', 'Mua dịch vụ thành công');
                            else :
                                echo send('error', 'Hệ thống đã xảy ra lỗi');
                            endif;
                        else :
                            echo send('error', 'Hệ thống đã xảy ra lỗi');
                        endif;
                    else :
                        echo send('error', $buff->message . $rate);
                    endif;
                endif;
            endif;
        else :
            echo send('error', 'Tài khoản hệ thống không tồn tại');
        endif;
    elseif ($_SERVER['SERVER_NAME'] == $SITEMAIN) :
        if (empty($uid)) :
            echo send('error', 'uid không được bỏ trống');
        elseif (empty($server)) :
            echo send('error', 'server không được bỏ trống');
        elseif (empty($amount)) :
            echo send('error', 'số lượng không được bỏ trống');
        elseif ($amount < 100) :
            echo send('error', 'số lượng không được nhỏ hơn 100');
        elseif (!isset($theloai['id'])) :
            echo send('error', 'thể loại không tồn tại');
        elseif (!isset($dichvu['id'])) :
            echo send('error', 'dịch vụ không tồn tại');
        elseif (!isset($sv['id'])) :
            echo send('error', 'server không tồn tại');
        elseif (Auth::user()->coin <  $rate) :
            echo send('error', 'Tài khoản của bạn không đủ số dư');
        else :
            $save['username'] =  Auth::user()->username;
            $curd = Buffme::run($sv['id_theloai'], $sv['id_dv'], $http);
            if ($curd == false) :
                $save['status'] =  'false';
                $thanhtien = Auth::user()->coin - $rate;
                $trutien = $DB->update('users', ['coin' => $thanhtien], ['username' => Auth::user()->username, 'domain' => $_SERVER['SERVER_NAME']]);
                if ($trutien) :
                    if ($DB->save('order', $save)) :
                        echo send('success', 'Mua dịch vụ thành công');
                    else :
                        echo send('error', 'Hệ thống đã xảy ra lỗi');
                    endif;
                else :
                    echo send('error', 'Hệ thống đã xảy ra lỗi');
                endif;
            else :
                $buff = json_decode($curd);
                if ($buff->status == true) :
                    $thanhtien = Auth::user()->coin - $rate;
                    $trutien = $DB->update('users', ['coin' => $thanhtien], ['username' => Auth::user()->username, 'domain' => $_SERVER['SERVER_NAME']]);
                    if ($trutien) :
                        if ($DB->save('order', $save)) :
                            echo send('success', 'Mua dịch vụ thành công');
                        else :
                            echo send('error', 'Hệ thống đã xảy ra lỗi');
                        endif;
                    else :
                        echo send('error', 'Hệ thống đã xảy ra lỗi');
                    endif;
                else :
                    echo send('error', $buff->message . "dd");
                endif;
            endif;
        endif;
    else :
        echo send('error', 'Có lỗi gì đó đã xảy ra');
    endif;
else :
    echo send('error', 'Thiếu thông tin quan trọng');
endif;
