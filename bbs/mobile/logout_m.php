<?
  include $_zb_path."_head_m.php";  //추가 라이브러리[모바일용]

// DB 연결
	if(!$connect) $connect=dbconn_m();

// 멤버 정보 구해오기
	$member=member_info();

	if(!$member[no]) error_m("로그인 상태가 아닙니다");

	if(!$group_no) $group_no=$member[group_no];

	if($id) $setup=get_table_attrib($id);
  
	if($setup[group_no]&&!$group_no) $group_no=$setup[group_no];
  
	mysql_close($connect);

	destroyZBSessionID($member[no]);
	
	// 4.0x 용 세션 처리
	$zb_logged_no='';
	$zb_logged_time='';
	$zb_logged_ip='';
	$zb_secret='';
	$zb_last_connect_check = '0';
	session_register("zb_logged_no");
	session_register("zb_logged_time");
	session_register("zb_logged_ip");
	session_register("zb_secret");
	session_register("zb_last_connect_check");
	session_destroy(); 
?>
<html>
<head>
<title>분당마라톤클럽 모바일</title>
<meta name="description" content="제로보드, 모바일, 분당마라톤클럽">
<meta name="keywords" content="제로보드, 모바일, 분당마라톤클럽">
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<script type="text/javascript">
alert("로그아웃 하셨습니다.");
window.location.href = '/bbs/mobile/';
</script>
</head>
