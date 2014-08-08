<?php
/***************************************************************************
 * 공통 파일 include
 **************************************************************************/
	include "_head_m.php";

/***************************************************************************
 * 게시판 설정 체크
 **************************************************************************/

 	$mode= $HTTP_GET_VARS[mode];
	$refer= $HTTP_GET_VARS[refer];
	if($HTTP_HOST !=$refer) error_m("정상적으로 글을 작성하여 주시기 바랍니다.");
	if(eregi(":\/\/",$dir)) $dir=".";

// 변수 체크
	if(!$mode||$mode=="write") {
		$mode = "write";
		unset($no);
	}

// 사용권한 체크
	if($mode=="reply"&&$setup[grant_reply]<$member[level]&&!$is_admin) error_m("사용권한이 없습니다[1]");
	elseif($setup[grant_write]<$member[level]&&!$is_admin) error_m("사용권한이 없습니다[2]");
	if($mode=="reply"&&$setup[grant_view]<$member[level]&&!$is_admin) error_m("사용권한이 없습니다[3]");

// 답글이나 수정일때 원본글을 가져옴;;
	if(($mode=="reply"||$mode=="modify")&&$no) {
		$result=@mysql_query("select * from $t_board"."_$id where no='$no'") or error_m(mysql_error_m());
		unset($data);
		$data=mysql_fetch_array($result);
		if(!$data[no]) error_m("원본글이 존재하지 않습니다");
	}

// 수정 글일때 권한 체크
	if($mode=="modify"&&$data[ismember]) {
		if($data[ismember]!=$member[no]&&!$is_admin&&$member[level]>$setup[grant_delete]) error_m("사용권한이 없습니다[4]");
	}

// 공지글에는 답글이 안 달리게 처리
	if($mode=="reply"&&$data[headnum]<=-2000000000) error_m("공지글에는 답글을 달수 없습니다");


// 카테고리 데이타 가져옴;;
	$category_result=mysql_query("select * from $t_category"."_$id order by no");

// 카테고리 데이타 갖고 오기;;
	if($setup[use_category]) {
		$category_kind="<select name=category id=category><option value=''>카테고리 선택</option>";

		while($category_data=mysql_fetch_array($category_result)) {
			if($data[category]==$category_data[no]) $category_kind.="<option value=$category_data[no] selected>$category_data[name]</option>";
			else $category_kind.="<option value=$category_data[no]>$category_data[name]</option>";
		}

		$category_kind.="</select>";
	}
  if(!$setup[use_category]) { $hide_category_start="<!--"; $hide_category_end="-->"; }

	if($mode=="modify") { $title = " 글 수정하기 ";}
	elseif($mode=="reply") { $title = " 답글 달기 ";}
	else { $title = " 신규 글쓰기 ";} 

// 쿠키값을 이용;;
	$name = $HTTP_SESSION_VARS["zb_writer_name"];
	$email = $HTTP_SESSION_VARS["zb_writer_email"];
	$homepage = $HTTP_SESSION_VARS["zb_writer_homepage"];

/******************************************************************************************
 * 글쓰기 모드에 따른 내용 체크
 *****************************************************************************************/

	if($mode=="modify") {

		// 비밀글이고 패스워드가 틀리고 관리자가 아니면 리턴
		if($data[is_secret]&&!$is_admin&&$data[ismember]!=$member[no]&&$HTTP_SESSION_VARS[zb_s_check]!=$setup[no]."_".$no) error_m("정상적인 방법으로 수정하세요");

			$name=stripslashes($data[name]); // 이름
			$email=stripslashes($data[email]); // 메일
			$homepage=stripslashes($data[homepage]); // 홈페이지 
			$subject=$data[subject]=stripslashes($data[subject]); // 제목
			$subject=str_replace("\"","&quot;",$subject);
			$homepage=str_replace("\"","&quot;",$homepage);
			$name=str_replace("\"","&quot;",$name);
			$memo=stripslashes($data[memo]); // 내용

			if($data[is_secret]) $secret=" checked ";
			if($data[headnum]<=-2000000000) $notice=" checked ";

		// 답글일때 제목과 내용 수정;;
		} elseif($mode=="reply") {

   			// 비밀글이고 패스워드가 틀리고 관리자가 아니면 리턴
			if($data[is_secret]&&!$is_admin&&$data[ismember]!=$member[no]&&$HTTP_SESSION_VARS[zb_s_check]!=$setup[no]."_".$no) error_m("정상적인 방법으로 답글을 다세요");

			if($data[is_secret]) $secret=" checked ";

			$subject=$data[subject]=stripslashes($data[subject]); // 제목
			$subject=str_replace("\"","&quot;",$subject);
			$memo=stripslashes($data[memo]); // 내용
			if(!eregi("\[re\]",$subject)) $subject="[re] ".$subject; // 답글일때는 앞에 [re] 붙임;;
			$memo=str_replace("\n","\n>",$memo);
			$memo="\n\n>".$memo."\n";
			$title="$name님의 글에 대한 답글쓰기";
		}


// 회원일때는 기본 입력사항 안보이게;;
	if($member[no]) { $hide_start="<!--"; $hide_end="-->"; }

// 비밀글 사용;;
	if(!$setup[use_secret]) { $hide_secret_start="<!--"; $hide_secret_end="-->"; }

// 공지기능 사용하는지 않하는지 표시;;
	if((!$is_admin&&$member[level]>$setup[grant_notice])||$mode=="reply") { $hide_notice_start="<!--";$hide_notice_end="-->"; }


// HTML 출력 
    echo('
    <html>
    <head>
    <title>제로보드 모바일</title>
    <meta name="description" content="제로보드, 모바일, 분당마라톤클럽">
    <meta name="keywords" content="제로보드, 모바일, 분당마라톤클럽">
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
		<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="./css/jquery.mobile.css" />
		<link rel="stylesheet" href="./css/_mobile.css" />
    <script src="./js/jquery-1.5.js"></script>
    <script src="./js/jquery.mobile.js"></script>
    <script src="./js/jquery.validate.js"></script>
    </head>
    <body>
    ');
	include "./skin/write_m.php";
	include "_foot_m.php"; 

?>
