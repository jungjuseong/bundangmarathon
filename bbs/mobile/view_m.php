<?

/***************************************************************************
 * 공통 파일 include
 **************************************************************************/
 	if(!$_view_included) {include "_head_m.php";}

/***************************************************************************
 * 게시판 설정 체크
 **************************************************************************/

// 사용권한 체크
	if($setup[grant_view]<$member[level]&&!$is_admin) error_m("사용권한이 없습니다");


// 현재 선택된 데이타가 있을때, 즉 $no 가 있을때 데이타 가져옴
	unset($data);
	$data=mysql_fetch_array(mysql_query("select * from  $t_board"."_$id  where no='$no'"));

	if(!$data[no]) error_m("선택하신 게시물이 존재하지 않습니다");

// 이전글과 이후글의 데이타를 구함;
	if(!$setup[use_alllist]) {	
		if($data[prev_no]) $prev_data=mysql_fetch_array(mysql_query("select * from  $t_board"."_$id  where no='$data[prev_no]'"));
		if($data[next_no]) $next_data=mysql_fetch_array(mysql_query("select * from  $t_board"."_$id  where no='$data[next_no]'"));
	}

// 모든 목록 보기가 아닐때 관련글을 모두 읽어옴;;
	if(!$setup[use_alllist]) {	
		$check_ref=mysql_fetch_array(mysql_query("select count(*) from $t_board"."_$id where division='$data[division]' and headnum='$data[headnum]'"));
		if($check_ref[0]>1) 
			$view_result=mysql_query("select * from $t_board"."_$id  where division='$data[division]' and headnum='$data[headnum]' order by headnum desc,arrangenum");
	}

// 간단한 답글의 데이타를 가지고옴;;
	$view_comment_result=mysql_query("select * from $t_comment"."_$id where parent='$no' order by no asc");

// zboard.php에서 인크루드시 대상 위치를 zboard.php로 설정
	if(!$_view_included) $target="view_m.php";
	else $target="zboard_m.php";

// 비밀글이고 패스워드가 틀리고 관리자가 아니면 에러 표시
	if($data[is_secret]&&!$is_admin&&$data[ismember]!=$member[no]&&$member[level]>$setup[grant_view_secret]) {
		if($member[no]) {
			$secret_check=mysql_fetch_array(mysql_query("select count(*) from $t_board"."_$id where headnum='$data[headnum]' and ismember='$member[no]'"));
			if(!$secret_check[0]) error_m("비밀글을 열람할 권한이 없습니다");
		} else {
			$secret_check=mysql_fetch_array(mysql_query("select count(*) from $t_board"."_$id where headnum='$data[headnum]' and password=password('$password')"));
			if(!$secret_check[0]) {
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
				$title="이 글은 비밀글입니다.<br>비밀번호를 입력하여 주십시요";
				$input_password="<input type=password name=password id='password' size=20 maxlength=20 value=''>";
				include "./skin/ask_password_m.php";
				exit;
			} else {
				$secret_str = $setup[no]."_".$no;
        $HTTP_SESSION_VARS['zb_s_check'] = $secret_str;
			}
		}
	}

// 현재글의 HIT수를 올림;;
	if(!eregi($setup[no]."_".$no,$HTTP_SESSION_VARS["zb_hit"])) {
		mysql_query("update $t_board"."_$id set hit=hit+1 where no='$no'");
		$hitStr=",".$setup[no]."_".$no;
		
		// 4.0x 용 세션 처리
		$zb_hit=$HTTP_SESSION_VARS["zb_hit"].$hitStr;
		session_register("zb_hit");
	}

// 이전글 정리
	if($data[prev_no]&&!$setup[use_alllist]) {
		$prev_comment_num="[".$prev_data[total_comment]."]"; // 간단한 답글 수
		if($prev_data[total_comment]==0) $prev_comment_num="";
		$a_prev="<a onfocus=blur() href='".$target."?".$href.$sort."&no=$data[prev_no]'>";
		$prev_subject=$prev_data[subject]=stripslashes($prev_data[subject])." ".$prev_comment_num;
		$prev_name=$prev_data[name]=stripslashes($prev_data[name]);
		$prev_data[email]=stripslashes($prev_data[email]);

		$temp_name = get_private_icon($prev_data[ismember], "2");
		if($temp_name) $prev_name="<img src='$temp_name' border=0 align=absmiddle>";

		if($setup[use_formmail]&&check_zbLayer($prev_data)) {
			$prev_name = "<span $show_ip onMousedown=\"ZB_layerAction('zbLayer$_zbCheckNum','visible')\" style=cursor:hand>$prev_name</span>";
		} else {
			if($prev_data[ismember]) 
				$prev_name="<a onfocus=blur() href=\"javascript:void(window.open('view_info.php?id=$id&member_no=$prev_data[ismember]','mailform','width=400,height=510,statusbar=no,scrollbars=yes,toolbar=no'))\" $show_ip>$prev_name</a>";
			else 
				$prev_name="<div $show_ip>$prev_name</div>";
		}

		$prev_hit=stripslashes($prev_data[hit]);
		$prev_reg_date="<span title='".date("Y/m/d H:i:d",$prev_data[reg_date])."'>".date("Y/m/d",$prev_data[reg_date])."</span>";

	} else {
		$hide_prev_start="<!--";
		$hide_prev_end="-->";
	}

// 다음글 정리
	if($data[next_no]&&!$setup[use_alllist]) {
		$a_next="<a onfocus=blur() href='".$target."?".$href.$sort."&no=$data[next_no]'>";
		$next_comment_num="[".$next_data[total_comment]."]"; // 간단한 답글 수
		if($next_data[total_comment]==0) $next_comment_num="";
		$next_subject=$next_data[subject]=stripslashes($next_data[subject])." ".$next_comment_num;
		$next_name=$next_data[name]=stripslashes($next_data[name]);
		$next_data[email]=stripslashes($next_data[email]);

		$temp_name = get_private_icon($next_data[ismember], "2");
		if($temp_name) $next_name="<img src='$temp_name' border=0 align=absmiddle>";

		if($setup[use_formmail]&&check_zbLayer($next_data)) {
			$next_name = "<span $show_ip onMousedown=\"ZB_layerAction('zbLayer$_zbCheckNum','visible')\" style=cursor:hand>$next_name</span>";
		} else {
			if($next_data[ismember]) $next_name="<a onfocus=blur() href=\"javascript:void(window.open('view_info.php?id=$id&member_no=$next_data[ismember]','mailform','width=400,height=510,statusbar=no,scrollbars=yes,toolbar=no'))\" $show_ip>$next_name</a>";
			else $next_name="<div $show_ip>$next_name</div>";
		}
		
		$next_hit=stripslashes($next_data[hit]);

	} else {
		$hide_next_start="<!--";
		$hide_next_end="-->";
	}


// 현재 선택된 글을 정리함
	list_check($data,1);

/****************************************************************************************
 * 변수 설정
 ***************************************************************************************/

// 글보기에서 쓰는 변수 수정
	$subject=$data[subject];

/****************************************************************************************
 * 버튼 정리
 ***************************************************************************************/

// 글쓰기버튼
	if($is_admin||$member[level]<=$setup[grant_write]) $a_write="<a onfocus=blur() href='write.php?$href$sort&no=$no&mode=write&sn1=$sn1'>글쓰기</a>"; else $a_write="";

// 목록 버튼
	if($is_admin||$member[level]<=$setup[grant_list]) $a_list="<a onfocus=blur() href='zboard_m.php?id=$id&page=$page&page_num=$page_num&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&prev_no=$no&sn1=$sn1&divpage=$divpage&select_arrange=$select_arrange&desc=$desc' rel='external' data-icon='refresh' data-role='button'>목록</a> "; else $a_list="";

// 취소버튼
	$a_cancel="<a onfocus=blur() href='$PHP_SELF?id=$id'>";

// 삭제버튼
	if(($is_admin||$member[level]<=$setup[grant_delete]||$data[ismember]==$member[no]||!$data[ismember])&&!$data[child]){
		$a_delete="<a onfocus=blur() href='delete_m.php?$href$sort&no=$no' rel='external' data-role='button'>삭제</a>"; 
	}else $a_delete="";

// 파일 다운로드를 나타나게 하는 변수;;
	if(!$file_name1) {
			$hide_download1_start="<!--";
			$hide_download1_end="-->";
	}
	if(!$file_name2) {
			$hide_download2_start="<!--";
			$hide_download2_end="-->";
	}
 
// 회원로그인이 되어 있으면 코멘트 비밀번호를 안 나타나게;;
	if($member[no]) {
		$c_name=$member[name]; $hide_c_password_start="<!--"; $hide_c_password_end="-->"; 
		$temp_name = get_private_icon($member[no], "2");
		if($temp_name) $c_name="<img src='$temp_name' border=0 align=absmiddle>";
		$temp_name = get_private_icon($member[no], "1");
		if($temp_name) $c_name="<img src='$temp_name' border=0 align=absmiddle>".$c_name;
	} else $c_name="<input type=text name='name' id='name' size=8 maxlength=10 class='required' value=\"".$HTTP_SESSION_VARS["zb_writer_name"]."\">";

/****************************************************************************************
 * 실제 출력 부분
 ***************************************************************************************/
// 헤더 출력
	if(!$_view_included){
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
  }
// 상단 현황 부분 출력 
	if(!$_view_included) {
		include "./skin/setup_m.php";
	}


// 내용보기 출력
	include "./skin/view_m.php";
// 코멘트 출력;;
	if($setup[use_comment]) {
		while($c_data=mysql_fetch_array($view_comment_result)) {
			$comment_name=stripslashes($c_data[name]);
			$temp_name = get_private_icon($c_data[ismember], "2");
			if($temp_name) $comment_name="<img src='$temp_name' border=0 align=absmiddle>";
			$c_memo=trim(stripslashes($c_data[memo]));
			$c_reg_date="<span title='".date("Y년 m월 d일 H시 i분 s초",$c_data[reg_date])."'>".date("Y/m/d",$c_data[reg_date])."</span>";
			if($c_data[ismember]) {
				if($c_data[ismember]==$member[no]||$is_admin||$member[level]<=$setup[grant_delete]) $a_del="<a onfocus=blur() href='del_comment_m.php?$href$sort&no=$no&c_no=$c_data[no]' rel='external' data-role='button' data-icon='delete'>삭제</a>";
				else $a_del=" ";
			} else $a_del="<a onfocus=blur() href='del_comment_m.php?$href$sort&no=$no&c_no=$c_data[no]' rel='external' data-role='button' data-icon='delete'>삭제</a>";

			if($is_admin) $show_ip=" title='$c_data[ip]' "; else $show_ip="";    
			include "./skin/view_comment_m.php";
			flush();
		}

		if($member[level]<=$setup[grant_comment]) {
			include "./skin/view_write_comment_m.php";
		}
	}

/***************************************************************************
 * 마무리 부분 include
 **************************************************************************/
	if(!$_view_included) { 
		include "_foot_m.php"; 
	}

?>
