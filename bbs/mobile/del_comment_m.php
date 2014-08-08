<?
/***************************************************************************
 * 공통 파일 include
 **************************************************************************/
	include "_head_m.php";

	if(!eregi($HTTP_HOST,$HTTP_REFERER)) error_m("정상적으로 글을 삭제하여 주시기 바랍니다.");

/***************************************************************************
 * 코멘트 삭제 페이지 처리
 **************************************************************************/

// 원본글을 가져옴
	$s_data=mysql_fetch_assoc(mysql_query("select * from $t_comment"."_$id where no='$c_no'"));

	if($s_data[ismember]||$is_admin||$member[level]<=$setup[grant_delete]) {
		if(!$is_admin&&$s_data[ismember]!=$member[no]) error_m("삭제할 권한이 없습니다");
		$title="글을 삭제하시겠습니까?";
	} else {
		$title="글을 삭제합니다.<br>비밀번호를 입력하여 주십시요";
		$input_password="<input type=password name=password id='password' size=20 maxlength=20 value=''>";
	}

	$target="del_comment_ok_m.php";

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

	include "./skin/ask_password_m.php";
	include "_foot_m.php";
?>
