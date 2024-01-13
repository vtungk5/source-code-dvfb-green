<?php

function getTime()
{
  return date('Y-m-d H:i:s', time());
}

function get_ip()
{
  $ipaddress = '';
  if (getenv('HTTP_CLIENT_IP'))  $ipaddress = getenv('HTTP_CLIENT_IP');
  elseif (getenv('HTTP_X_FORWARDED_FOR')) $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
  elseif (getenv('HTTP_X_FORWARDED')) $ipaddress = getenv('HTTP_X_FORWARDED');
  elseif (getenv('HTTP_FORWARDED_FOR'))  $ipaddress = getenv('HTTP_FORWARDED_FOR');
  elseif (getenv('HTTP_FORWARDED'))  $ipaddress = getenv('HTTP_FORWARDED');
  elseif (getenv('REMOTE_ADDR'))  $ipaddress = getenv('REMOTE_ADDR');
  else   $ipaddress = 'UNKNOWN';
  return $ipaddress;
}

function str($data)
{
  return str_replace(array('<', "'", '>', '?', '/', "\\", '--', 'eval(', '<php'), array('', '', '', '', '', '', '', '', ''), htmlspecialchars(addslashes(strip_tags($data))));
}

function send($status, $msg, $data = null)
{
  header("content-type: application/json; charset=UTF-8");
  if ($status != 'success') : http_response_code(405);
  endif;
  if ($data != null) :  foreach ($data as $key => $value) : $arr = ['status' => $status, 'msg' => $msg, $key => $value];
    endforeach;
  else : $arr = ['status' => $status, 'msg' => $msg];
  endif;
  return json_encode($arr, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

function format_money($price)
{
  return str_replace(",", ".", number_format($price));
}


function timeago($date)
{
  $timestamp = strtotime($date);

  $strTime = ["giây", "phút", "giờ", "ngày", "tháng", "năm"];
  $length = ["60", "60", "24", "30", "12", "10"];

  $currentTime = time();
  if ($currentTime >= $timestamp) :
    $diff     = time() - $timestamp;
    for ($i = 0; $diff >= $length[$i] && $i < count($length) - 1; $i++) {
      $diff = $diff / $length[$i];
    }

    $diff = round($diff);
    return $diff . " " . $strTime[$i] . " trước";
  endif;
}


function getBrowser()
{
  $u_agent = $_SERVER['HTTP_USER_AGENT'];
  $bname = 'Unknown';
  $platform = 'Unknown';
  $version = "";

  //First get the platform?
  if (preg_match('/linux/i', $u_agent)) {
    $platform = 'linux';
  } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
    $platform = 'mac';
  } elseif (preg_match('/windows|win32/i', $u_agent)) {
    $platform = 'windows';
  }

  // Next get the name of the useragent yes seperately and for good reason
  if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
    $bname = 'Internet Explorer';
    $ub = "MSIE";
  } elseif (preg_match('/Firefox/i', $u_agent)) {
    $bname = 'Mozilla Firefox';
    $ub = "Firefox";
  } elseif (preg_match('/Chrome/i', $u_agent)) {
    $bname = 'Google Chrome';
    $ub = "Chrome";
  } elseif (preg_match('/Safari/i', $u_agent)) {
    $bname = 'Apple Safari';
    $ub = "Safari";
  } elseif (preg_match('/Opera/i', $u_agent)) {
    $bname = 'Opera';
    $ub = "Opera";
  } elseif (preg_match('/Netscape/i', $u_agent)) {
    $bname = 'Netscape';
    $ub = "Netscape";
  }

  // finally get the correct version number
  $known = array('Version', $ub, 'other');
  $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
  if (!preg_match_all($pattern, $u_agent, $matches)) {
    // we have no matching number just continue
  }

  // see how many we have
  $i = count($matches['browser']);
  if ($i != 1) {
    //we will have two since we are not using 'other' argument yet
    //see if version is before or after the name
    if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
      $version = $matches['version'][0];
    } else {
      $version = $matches['version'][1];
    }
  } else {
    $version = $matches['version'][0];
  }

  // check if we have a number
  if ($version == null || $version == "") {
    $version = "?";
  }

  return array(
    'userAgent' => $u_agent,
    'name'      => $bname,
    'version'   => $version,
    'platform'  => $platform,
    'pattern'    => $pattern
  );
}

function crypto_rand_secure($min, $max)
{
  $range = $max - $min;
  if ($range < 1) return $min; // not so random...
  $log = ceil(log($range, 2));
  $bytes = (int) ($log / 8) + 1; // length in bytes
  $bits = (int) $log + 1; // length in bits
  $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
  do {
    $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
    $rnd = $rnd & $filter; // discard irrelevant bits
  } while ($rnd > $range);
  return $min + $rnd;
}

function getToken($length = 13)
{
  $token = "";
  $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
  $codeAlphabet .= "0123456789";
  $max = strlen($codeAlphabet); // edited

  for ($i = 0; $i < $length; $i++) {
    $token .= $codeAlphabet[crypto_rand_secure(0, $max - 1)];
  }

  return $token;
}
function rate_reaction($data)
{
  switch ($data):

    case 'like':
      return 101;
      break;

    default:
      return 100;
      break;
  endswitch;
}

function post($url, $data, $header = [])
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  $result = curl_exec($ch);
  curl_close($ch);
  return $result;
}

function status_card($data)
{
  switch ($data):
    case '1':
      return '<span class="badge bg-success">Thẻ đúng</span>';
    break;
    case '3':
      return '<span class="badge bg-danger">Thẻ ko dùng đc</span>';
    break;
    case '99':
      return '<span class="badge bg-warning">Thẻ chờ xử lý</span>';
    break;
    default:
      return '<span class="badge bg-danger">Thẻ sai</span>';
    break;
  endswitch;
}

function status_users($data)
{
  if($data == 'ON'):
      return '<span class="badge bg-success">Hoạt động</span>';
  else:
      return '<span class="badge bg-danger">Bị khóa</span>';
  endif;
}

function getDns($domain)
{
    $dns = dns_get_record($domain, DNS_NS);
    $nameservers = [];
    foreach ($dns as $current)
        $nameservers[] = $current['target'];
    return $nameservers;
}

function tinh_trang($data)
{
  if($data == 'ON'):
      return '<span class="badge bg-success">Đã bật</span>';
  else:
      return '<span class="badge bg-danger">Đã tắt</span>';
  endif;
}

function trang_thai($data)
{
  if($data == 'ON'):
      return '<span class="badge bg-success">Hoạt động</span>';
  else:
      return '<span class="badge bg-danger">Bảo trì</span>';
  endif;
}

function buy_status($data)
{
  if($data == true):
      return '<span class="badge bg-success">Thành công</span>';
  else:
      return '<span class="badge bg-danger">Thất bại</span>';
  endif;
}
function buy_status2($data)
{
  if($data == 'true'):
      return '<span class="badge bg-success">Thành công</span>';
  else:
      return '<span class="badge bg-warning">Chờ duyệt</span>';
  endif;
}

function curl_get_api_dailysieure($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}