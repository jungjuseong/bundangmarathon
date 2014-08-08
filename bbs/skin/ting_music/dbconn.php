<?
$host_name="localhost";
$user_name="coretek";  //디비접속시 사용하는 유저 아이디 ※사용법을 모시면 설치설명서를 읽어주십시오.
$db_name="coretek";  // db이름 ※사용법을 모시면 설치설명서를 읽어주십시오.
$db_password="qnsekddkwk9"; // db 비번 ※사용법을 모시면 설치설명서를 읽어주십시오.
$zero_path="http://www.bundangmarathon.com/bbs/"; // 절대경로아님!제로보드 URL 끝에 /꼭 붙이세요. ※사용법을 모시면 설치설명서를 읽어주십시오.
$connect=mysql_connect($host_name,$user_name,$db_password);
mysql_select_db($db_name, $connect);
?>
