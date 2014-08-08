<?
	include "../lib.php";
	include $_zb_path."lib_m.php";  //추가 라이브러리[모바일용]
	$connect=dbconn_m();

	$user_id = trim($_POST[user_id]);
	$password = trim($_POST[password]);

  if(!get_magic_quotes_gpc()) {
    $user_id = addslashes($user_id);
    $password = addslashes($password);
  }

	if(!$user_id) error_m("아이디를 입력하여 주십시요");
	if(!$password) error_m("비밀번호를 입력하여 주십시요");

// 회원 로그인 체크
	$result = mysql_query("select * from $member_table where user_id='$user_id' and password=password('$password')") or error_m(mysql_error());
	$member_data = mysql_fetch_array($result);

// 회원로그인이 성공하였을 경우 세션을 생성하고 페이지를 이동함
	if($member_data[no]) {

		// 4.0x 용 세션 처리
		$zb_logged_no = $member_data[no];
		$zb_logged_time = time();
		$zb_logged_ip = $_SERVER[REMOTE_ADDR];
		$zb_last_connect_check = '0';

		session_register("zb_logged_no");
		session_register("zb_logged_time");
		session_register("zb_logged_ip");
		session_register("zb_last_connect_check");


		// 로그인 후 페이지 이동
		echo("SUCCESS");
// 회원로그인이 실패하였을 경우 에러 표시
	} else {
		echo("FOBIDDEN");
	}

	@mysql_close($connect);
?>
