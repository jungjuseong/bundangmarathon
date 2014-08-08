<?
if(!file_exists(getcwd().'/zboard.php')) die('정상적인 접근이 아닙니다.');

// 공통파일 include
	include "lib.php";
	if(!eregi($HTTP_HOST,$HTTP_REFERER)) Error("정상적으로 글을 작성하여 주시기 바랍니다.");

// DB 연결
	if(!$connect) $connect=dbConn();  

//게시판 설정 읽어오기
	$setup = get_table_attrib($id); 

//스킨 환경설정 읽어오기
	include "skin/$setup[skinname]/get_config.php";
	$dir = "skin/$setup[skinname]";

// 엔진 가져오기
	$_inclib_01 = $dir."/include/dq_thumb_engine2.";
	if(file_exists($_inclib_01.'php') && filesize($_inclib_01.'php')) include_once $_inclib_01.'php';
	else include_once $_inclib_01.'zend';

//회원정보 읽어오기
	$member = member_info();

// 해당글이 있는 지를 검사
	$check = mysql_fetch_array(mysql_query("select count(*) from $t_board"."_$id where no = '$no'", $connect));
	if(!$check[0]) Error("원본 글이 존재하지 않습니다.");

/* spam 댓글 금지 yhkim/san2run */
if($id=="photo" && ($no==18 || $no==18)){
	Error("댓글달기 금지입니다.");
	exit;
}
	include $dir.'/include/vote_ex_run.php';
?>
