<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';

if (isset($_POST['note'])):

    $note = $_POST['note'];
    $save = [];
    $save['name'] = Auth::user()->name;
    $save['note'] = $note;
    $save['date'] = getTime();
    $save['domain'] = $_SERVER['SERVER_NAME'];

    if (!Auth::user()):
        echo send('error', 'Đm đăng nhập ngay! cho cái dép giờ');
    elseif (empty($note)) :
        echo send('error', 'Nội dung bài đăng không được bỏ trống');
    elseif(Auth::user()->level < 3):
        echo send('error', 'Bạn không phải quản trị viên');
    elseif ($DB->save('post', $save)) :
        echo send('success', 'Đăng bài thành công');
    else :
        echo send('error', 'Đăng bài thất bại');
    endif;
else :
    echo send('error', 'dữ liệu gửi lên không hợp lệ');
endif;

