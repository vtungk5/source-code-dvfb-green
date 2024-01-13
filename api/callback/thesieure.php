<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server.php';  
    $body = file_get_contents('php://input');    
    $content = json_decode($body,true);

    if (isset($content['callback_sign'])):
        $myfile = fopen("log.txt", "w") or die("Unable to open file!");
        $txt = $body."\n";
        fwrite($myfile, $txt);
        fclose($myfile);

        /// status = 1 ==> thẻ đúng
        /// status = 2 ==> thẻ sai
        /// status = 3 ==> thẻ ko dùng đc
        /// status = 99 ==> thẻ chờ xử lý
       
        //// Kết quả trả về sẽ có các trường như sau:
        $partner_key = Site::get('partner_key');

        $callback_sign = md5($partner_key . $content['code'] . $content['serial']);
        if ($content['callback_sign'] == $callback_sign):
            $getdata = [];
            $getdata['status'] = $content['status'];
            $getdata['message'] = $content['message'];
            $getdata['request_id'] = $content['request_id'];   /// Mã giao dịch của bạn
            $getdata['trans_id'] = $content['trans_id'];   /// Mã giao dịch của website thesieure.com
            $getdata['declared_value'] = $content['declared_value'];  /// Mệnh giá mà bạn khai báo lên
            $getdata['value'] = $content['value'];  /// Mệnh giá thực tế của thẻ
            $getdata['amount'] = $content['amount'];   /// Số tiền bạn nhận về (VND)
            $getdata['code'] = $content['code'];   /// Mã nạp
            $getdata['serial'] = $content['serial'];  /// Serial thẻ
            $getdata['telco'] = $content['telco'];   /// Nhà mạng

            $check = $DB->query_one('napthe',['serial'=>$getdata['serial'],'tranid'=>$getdata['request_id'],'domain'=>$_SERVER['SERVER_NAME']]);
            if(isset($check['tranid'])):
                if($check['status'] == 99):
                   $user = $DB->query_one('users',['username'=>$check['username'],'domain'=>$_SERVER['SERVER_NAME']]);
                   $coin =$user['coin'] +  $getdata['amount'];
                   $DB->update('napthe',['status'=>$getdata['status'],'note'=>$getdata['message']],['tranid'=>$getdata['request_id'],'domain'=>$_SERVER['SERVER_NAME']]);
                   $DB->update('users',['coin'=>$coin],['username'=>$check['username'],'domain'=>$_SERVER['SERVER_NAME']]);

                   $tugmmo2 = $DB->query('bank',['username'=>$check['username'],'domain'=>$_SERVER['SERVER_NAME']]);
                   $tugmmo = $DB->query('napthe',['username'=>$check['username'],'domain'=>$_SERVER['SERVER_NAME']]);
           
                   foreach($tungmmo as $tungcoder => $tungdev):
                       $money += $tungdev['amount'];
                   endforeach;
                   foreach($tungmmo2 as $tungcoder2 => $tungdev2):
                       $money += $tungdev2['amount'];
                   endforeach;
                       $money +=$amount;
                   if($money > Site::get('coin_ctv')):
                      $DB->update('users', ['level'=>1],['username'=>$check['username'], 'domain' => $_SERVER['SERVER_NAME']]);
                   elseif($money > Site::get('coin_daily')):
                      $DB->update('users', ['level'=>2],['username'=>$check['username'], 'domain' => $_SERVER['SERVER_NAME']]);
                   endif;
                   
                endif;
            endif;
        endif;
    endif;
