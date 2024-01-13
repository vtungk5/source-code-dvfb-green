<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if ($_SERVER['REQUEST_METHOD'] === "PUT"):

    $apikey = getToken(32);
    $update = ['apikey'=>$apikey,'domain'=>$_SERVER['SERVER_NAME']];

    if (!Auth::user()):
        echo send('error', 'Đm đăng nhập ngay! cho cái dép giờ');
    elseif ($DB->update('users', $update, ['username' => Auth::user()->username,'domain'=>$_SERVER['SERVER_NAME']]) ) :
        echo send('success', 'Này đổi xong rồi đấy ',['apikey'=>$apikey]);
    else :
        echo send('error', 'Apikey ngu thế');
    endif;
else :
    echo send('error', 'dữ liệu gửi lên không hợp lệ');
endif;
