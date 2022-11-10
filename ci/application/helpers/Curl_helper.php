<?
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function curl_exec_post_func($url, $data) // 추후에 editplus에선 라이브러리나 따로 파일에 넣을 예정입니다.
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data, '', '&'));
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
  // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded;charset=utf-8'));
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $result = curl_exec ($ch);
  curl_close($ch);

  $result = json_decode($result, true); //받은 데이터는 json이므로 디코딩
  return $result;
}

function curl_exec_get_func($url, $access_token) // 추후에 editplus에선 라이브러리나 따로 파일에 넣을 예정입니다.
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$access_token));
  
  $result = curl_exec($ch);
  curl_close($ch);

  $result = json_decode($result, true); //받은 데이터는 json이므로 디코딩
  return $result;
}
?>
