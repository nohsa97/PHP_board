<?
$time = date("Y-m-d H-i-s");
echo $time."<br>";
// echo date("Y년 m월 d일 H시 i분 s초", strtotime(7776000));
// echo gmdate("Y년 m월 d일 H시 i분 s초", 7776000);
// $expire = date("Y년 m월 d일 H시 i분 s초", strtotime(7776000));
// echo $expire;
echo gmdate("Y-m-d H:i:s", 7776000);

 $times = time()+7776000;
$timestamp =  date("Y-m-d H-i-s", $times);
echo $timestamp;
// echo gmdate("Y-m-d H:i:s", $time.+7776000);
?>