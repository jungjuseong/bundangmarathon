<?

  // 라이브러리 함수 파일 인크루드
	include "_head_m.php";

	$getData = iconv_CP949All($HTTP_POST_VARS);
	$page = $getData[page];
	$id = $getData[id];
	$no = $getData[no];
	$select_arrange = $getData[select_arrange];
	$desc = $getData[desc];
	$page_num = $getData[page_num];
	$keyword = $getData[keyword];
	$category = $getData[category];
	$sn = $getData[sn];
	$ss = $getData[ss];
	$sc = $getData[sc];
	$mode = $getData[mode];
	$c_no = $getData[c_no];

	if(!eregi($HTTP_HOST,$HTTP_REFERER)){
		echo(iconv_UTF("정상적으로 글을 삭제하여 주시기 바랍니다."));
		exit;
	}
/***************************************************************************
* 코멘트 삭제 진행
**************************************************************************/
  // DB 연결
  if(!$connect) $connect=dbconn_m();

// 패스워드를 암호화
	if($password) {
		$temp=mysql_fetch_assoc(mysql_query("select password('$password') AS pass"));
		$password=$temp['pass'];   
	}

// 원본글을 가져옴
	$s_data=mysql_fetch_assoc(mysql_query("select * from $t_comment"."_$id where no='$c_no'"));

// 회원일때를 확인;;
	if(!$is_admin&&$member[level]>$setup[grant_delete]) {
		if(!$s_data[ismember]) {
			if($s_data[password]!=$password){
				echo(iconv_UTF("비밀번호가 올바르지 않습니다"));
				exit;
			}
		} else {
			if($s_data[ismember]!=$member[no]){
				echo(iconv_UTF("비밀번호를 입력하여 주십시요"));
				exit;
			}
		}
	}

// 코멘트 삭제
	mysql_query("delete from $t_comment"."_$id where no='$c_no'");

// 코멘트 갯수 정리
	$total=mysql_fetch_assoc(mysql_query("select count(*) AS cmt from $t_comment"."_$id where parent='$no'"));
	mysql_query("update $t_board"."_$id set total_comment='".$total['cmt']."' where no='".$no."'"); 

// 회원일 경우 해당 해원의 점수 주기
	if($member[no]==$s_data[ismember]) @mysql_query("update $member_table set point2=point2-1 where no='$member[no]'",$connect);

	@mysql_close($connect);

// 성공시 데이터 전송
	if($setup[use_alllist]){
		echo("SUCCESS@zboard_m.php?id=$id&page=$page&page_num=$page_num&select_arrange=$select_arrange&desc=$des&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&no=$no");
		exit;
	}else{
		echo("SUCCESS@view_m.php?id=$id&page=$page&page_num=$page_num&select_arrange=$select_arrange&desc=$des&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&no=$no");
		exit;
	}
?>
