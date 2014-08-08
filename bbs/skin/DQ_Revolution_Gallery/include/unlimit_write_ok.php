<?
if(!file_exists(getcwd().'/zboard.php')) die('정상적인 접근이 아닙니다.');

/***************************************************************************
 * 공통 파일 include
 **************************************************************************/
	include "_head.php";

/***************************************************************************
 * 스킨 환경설정 파일 include
 **************************************************************************/
	$_put_css = '1';
	include "skin/$setup[skinname]/get_config".".php";


// 설정
	if(!$skin_setup[using_preview_img]) $use_thumbimg = '';

// 편법을 이용한 글쓰기 방지
	$mode = $HTTP_POST_VARS[mode];
	if(!eregi($HTTP_HOST,$HTTP_REFERER)) Error("정상적으로 글을 작성하여 주시기 바랍니다.");
	if(getenv("REQUEST_METHOD") == 'GET' ) Error("정상적으로 글을 쓰시기 바랍니다","");
	if(!$mode) $mode = "write";

// 사용권한 체크
	if($mode=="reply"&&$setup[grant_reply]<$member[level]&&!$is_admin) Error("사용권한이 없습니다","login.php?id=$id&page=$page&page_num=$page_num&category=$category&sn=$sn&ss=$ss&sc=$sc&su=$su&keyword=$keyword&no=$no&file=zboard.php");
	elseif($setup[grant_write]<$member[level]&&!$is_admin) Error("사용권한이 없습니다","login.php?id=$id&page=$page&page_num=$page_num&category=$category&sn=$sn&ss=$ss&sc=$sc&su=$su&keyword=$keyword&no=$no&file=zboard.php");

	if(!$is_admin&&$setup[grant_notice]<$member[level]) $notice = 0;

// 원본글을 가져옴
	unset($s_data);
	$s_data=mysql_fetch_array(mysql_query("select * from $t_board"."_$id where no='$no'"));
	unset($m_data);
	$m_data=mysql_fetch_array(mysql_query("select * from dq_revolution where zb_id='$id' and zb_no='$no'"));

// 장터기능 사용시
	if($skin_setup['using_market'] && $mode == 'modify') {
		$memo = $s_data[memo];
		$subject = $s_data[subject];
		$sitelink1 = $s_data[sitelink1];
		$sitelink2 = $s_data[sitelink2];
		$name = $s_data[name];
		$email = $s_data[email];
		$homepage = $s_data[homepage];

		if($s_data[category] == $category && isblank($memo2)) Error("추가내용을 입력하셔야 합니다");
	}

// 각종 변수 검사;;
	if(!$member[no]) {
		if(isblank($name)) Error("이름을 입력하셔야 합니다");
		if(isblank($password)) Error("비밀번호를 입력하셔야 합니다");
	} else {
		$password = $member[password];
	}

	$subject = str_replace("ㅤ","",$subject);
	$memo = str_replace("ㅤ","",$memo);
	$name = str_replace("ㅤ","",$name);

	if($skin_setup['using_market'] && $mode == 'modify') $skin_setup['using_emptyArticle'] = '1';

	if(!$skin_setup[using_emptyArticle]) {
		if(isblank($subject)) Error("제목을 입력하셔야 합니다");
		if(isblank($memo)) Error("내용을 입력하셔야 합니다");
	}

	if(!$category) {
		$cate_temp=mysql_fetch_array(mysql_query("select min(no) from $t_category"."_$id",$connect));
		$category=$cate_temp[0];
	}

// 필터링;; 관리자가 아닐때;;
	if(!$is_admin&&$setup[use_filter]) {
		$filter=explode(",",$setup[filter]);
		$f_memo=eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($memo));
		$f_name=eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($name));
		$f_subject=eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($subject));
		$f_email=eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($email));
		$f_homepage=eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($homepage));
		for($i=0;$i<count($filter);$i++) {
			if(!isblank($filter[$i])) {
				if(eregi($filter[$i],$f_memo)) Error("<b>$filter[$i]</b> 은(는) 등록하기에 적합한 단어가 아닙니다");
				if(eregi($filter[$i],$f_name)) Error("<b>$filter[$i]</b> 은(는) 등록하기에 적합한 단어가 아닙니다");
				if(eregi($filter[$i],$f_subject)) Error("<b>$filter[$i]</b> 은(는) 등록하기에 적합한 단어가 아닙니다");
				if(eregi($filter[$i],$f_email)) Error("<b>$filter[$i]</b> 은(는) 등록하기에 적합한 단어가 아닙니다");
				if(eregi($filter[$i],$f_homepage)) Error("<b>$filter[$i]</b> 은(는) 등록하기에 적합한 단어가 아닙니다");
			}
		}
	}

//패스워드를 암호화
	if($password) {
		$temp=mysql_fetch_array(mysql_query("select password('$password')"));
		$password=$temp[0];   
	}

// 관리자이거나 HTML허용레벨이 낮을때 태그의 금지유무를 체크
	if(!$is_admin&&$setup[grant_html]<$member[level]) {

		// 내용의 HTML 금지;;
		if(!$use_html||$setup[use_html]==0) $memo=del_html($memo);

		// HTML의 부분허용일때;;
		if($use_html&&$setup[use_html]==1) {
			$memo=str_replace("<","&lt;",$memo);
			$tag=explode(",",$setup[avoid_tag]);
			for($i=0;$i<count($tag);$i++) {
				$tag[$i] = trim($tag[$i]);
				if(!isblank($tag[$i])) { 
					$memo=eregi_replace("&lt;".$tag[$i]." ","<".$tag[$i]." ",$memo); 
					$memo=eregi_replace("&lt;".$tag[$i].">","<".$tag[$i].">",$memo); 
					$memo=eregi_replace("&lt;/".$tag[$i],"</".$tag[$i],$memo); 
				}
			}  
		}
	} else {
		if(!$use_html) {
			$memo=del_html($memo);
		}
	}


// 원본글을 이용한 비교
	if($mode=="modify"||$mode=="reply") {
		if(!$s_data[no]) Error("원본글이 존재하지 않습니다");
	}

// 공지글에는 답글이 안 달리게 처리
	if($mode=="reply"&&$s_data[headnum]<=-2000000000) Error("공지글에는 답글을 달수 없습니다");


// 회원등록이 되어 있을때 이름등을 가져옴;;
	if($member[no]) {
		if($mode=="modify"&&$member[no]!=$s_data[ismember]) {
			$name=$s_data[name];
			$email=$s_data[email];
			$homepage=$s_data[homepage];
		} else {
			$name=$member[name];
			$email=$member[email];
			$homepage=$member[homepage];
		}
	}

// 각종 변수를 addslashes 시킴;;
	$name=addslashes(del_html($name));
	if(($is_admin||$member[level]<=$setup[use_html])&&$use_html) $subject=addslashes($subject);
	else $subject=addslashes(del_html($subject));
	$memo=addslashes($memo);
	if($use_html<2) {
		$memo=str_replace("  ","&nbsp;&nbsp;",$memo);
		$memo=str_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$memo);
	}	
	$sitelink1=addslashes(del_html($sitelink1));
	$sitelink2=addslashes(del_html($sitelink2));
	$email=addslashes(del_html($email));
	$homepage=addslashes(del_html($homepage));

// 파일설명을 분해하고 addslashes 시킴;;
	unset($file_descript);
	if($use_descript_z1) $file_descript = "[use]";
	if($descript_z1) $file_descript .= addslashes(del_html($descript_z1));
	$file_descript .= "||";
	if($use_descript_z2) $file_descript .= "[use]";
	if($descript_z2) $file_descript .= addslashes(del_html($descript_z2));

	for($i=0; $i<99; $i++) {
		$chk_use = "use_descript_$i";
		$file_descript .= "||";
		$tmp = "descript_$i";
		if($$chk_use && $$tmp) {
			$file_descript .= "[use]";
			$file_descript .= addslashes(strip_tags($$tmp));
		}
	}
	if(strlen($file_descript) <= 200) $file_descript = "";

// 홈페이지 주소의 경우 http:// 가 없으면 붙임
	if((!eregi("http://",$homepage))&&$homepage) $homepage="http://".$homepage;

// 각종 변수 설정
	$ip=$REMOTE_ADDR; // 아이피값 구함;;
	$reg_date=time(); // 현재의 시간구함;;

	$x = $zx;
	$y = $zy;

//스킨 설정을 가져옴
	include "skin/".$setup[skinname]."/get_config.php";

//게시물 등록 제한
	include "skin/".$setup[skinname]."/include/write_limit.php";

if($skin_setup['using_attacguard']) {
	// 도배인지 아닌지 검사;; 우선 같은 아이피대에 30초이내의 글은 도배로 간주;;
		if(!$is_admin&&$mode!="modify") {
			$max_no=mysql_fetch_array(mysql_query("select max(no) from $t_board"."_$id"));
			$temp=mysql_fetch_array(mysql_query("select count(*) from $t_board"."_$id where ip='$ip' and $reg_date - reg_date <30 and no='$max_no[0]'"));
			if($temp[0]>0) {Error("글등록은 30초이상이 지나야 가능합니다"); exit;}
		}

	// 같은 내용이 있는지 검사;;
		if(!$is_admin&&$mode!="modify") {
			$max_no=mysql_fetch_array(mysql_query("select max(no) from $t_board"."_$id"));
			$temp=mysql_fetch_array(mysql_query("select count(*) from $t_board"."_$id where memo='$memo' and no='$max_no[0]'"));
			if($temp[0]>0) {Error("같은 내용의 글은 등록할수가 없습니다"); exit; }
		}
}



// 쿠키 설정;;
	if($mode!="modify") {
		// 기존 세션 처리 (4.0x용 세션 처리로 인하여 주석 처리)
		//if($name) $HTTP_SESSION_VARS["zb_writer_name"] = $name;
		//if($email) $HTTP_SESSION_VARS["zb_writer_email"] = $email;
		//if($homepage) $HTTP_SESSION_VARS["zb_writer_homepage"] = $homepage;

		// 4.0x 용 세션 처리
		if($name) {
			$zb_writer_name = $name;
			$_SESSION['zb_writer_name'] = $zb_writer_name;
		}
		if($email) {
			$zb_writer_email = $email;
			$_SESSION['zb_writer_email'] = $zb_writer_email;
		}
		if($homepage) {
			$zb_writer_homepage = $homepage;
			$_SESSION['zb_writer_homepage'] = $zb_writer_homepage;
		}
	}

//글쓰기 완료 & DB에 데이터 입력
	$_inclib_01 = "skin/".$setup[skinname]."/include/dq_thumb_engine2.";
	$_inclib_02 = "skin/".$setup[skinname]."/include/unlimit_write2.";
	if(file_exists($_inclib_01) && filesize($_inclib_01.'php')) include_once $_inclib_01.'php';
	else include_once $_inclib_01.'zend';
	if(file_exists($_inclib_02.'php') && filesize($_inclib_02.'php')) include_once $_inclib_02.'php';
	else include_once $_inclib_02.'zend';

// 작성된 글을 가져옴
	//unset($s_data);
	//$s_data=mysql_fetch_array(mysql_query("select * from $t_board"."_$id where no='$no'"));

// 섬네일을 생성
	//include "./DQ_LIBS/include/dq_thumb_engine.zend";
	$_dq_tempFile="data/$id/small_".$no.".thumb";
	$_dq_workFile="data/$id/small_".$no.".thumb.work";
	if(file_exists($_dq_tempFile)) unlink ($_dq_tempFile);
	// 최근게시물 썸네일 삭제
	//$latest_thumb = "data/_DQThumb_Latest_Temp/$id_$no.thumb";
	//if(file_exists($latest_thumb)) unlink ($latest_thumb);

	if(file_exists($_dq_workFile)) unlink ($_dq_workFile);
	//$thumb_tag = get_thumbTag($s_data,$skin_setup['thumb_imagex'],$skin_setup['thumb_imagey'],$dir);

// 글의 갯수를 다시 갱신
	$total=mysql_fetch_array(mysql_query("select count(*) from $t_board"."_$id "));
	mysql_query("update $admin_table set total_article='$total[0]' where name='$id'");

// 회원일 경우 해당 해원의 점수 주기
	if(!$skin_setup[write_nopoint] && ($mode=="write"||$mode=="reply")) @mysql_query("update $member_table set point1=point1+1 where no='$member[no]'",$connect) or error(mysql_error());

// MySQL 닫기 
	if($connect) {
		mysql_close($connect); 
		unset($connect);
	}

// 페이지 이동
	//if($setup[use_alllist]) $view_file="zboard.php"; else $view_file="view.php";
	$view_file = "zboard.php";
	movepage($view_file."?id=$id&page=$page&page_num=$page_num&select_arrange=$select_arrange&desc=$des&sn=$sn&ss=$ss&sc=$sc&su=$su&keyword=$keyword&no=$no&category=$category");
?>