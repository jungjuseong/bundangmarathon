<?php
	//set_time_limit(0); 
    
    $del_que1 = $del_que2 = null;

/***************************************************************************
 * 공통 파일 include
 **************************************************************************/
	include "_head_m.php";

/***************************************************************************
 * 게시판 설정 체크
 **************************************************************************/

	$getData = iconv_CP949All($HTTP_POST_VARS);

	if(!eregi($HTTP_HOST,$HTTP_REFERER)){
		echo(iconv_UTF("정상적으로 글을 작성하여 주시기 바랍니다."));
		exit;
	}

	if(getenv("REQUEST_METHOD") == 'GET' ){
		echo(iconv_UTF("정상적으로 글을 쓰시기 바랍니다"));
		exit;
	}
	if(!$getData[mode]) $mode = "write";
	else $mode = $getData[mode];

// 사용권한 체크
	if($mode=="reply"&&$setup[grant_reply]<$member[level]&&!$is_admin){
		echo(iconv_UTF("사용권한이 없습니다"));
		exit;
	}	elseif($setup[grant_write]<$member[level]&&!$is_admin){
		echo(iconv_UTF("사용권한이 없습니다"));
		exit;
	}

	if(!$is_admin&&$setup[grant_notice]<$member[level]) $notice = 0;

// 각종 변수 검사;;
	if(!$member[no]) {
		if(isblank($getData[name])) {
			echo(iconv_UTF("이름을 입력하셔야 합니다"));
			exit;
		}
		if(isblank($getData[password])) {
			echo(iconv_UTF("비밀번호를 입력하셔야 합니다"));
			exit;
		}
	} else {
		$password = $member[password];
	}

	$subject = str_replace("ㅤ","",$getData[subject]);
	$memo  = str_replace("ㅤ","",$getData[memo]);
	$name   = str_replace("ㅤ","",$getData[name]);

	if(isblank($subject)){
		echo(iconv_UTF("제목을 입력하셔야 합니다"));
		exit;
	}
	if(isblank($memo)){
		echo(iconv_UTF("내용을 입력하셔야 합니다"));
		exit;
	}
	if($setup['use_category'] == "1" && !$category){
		echo(iconv_UTF("카테고리를 선택하셔야 합니다."));
		exit;
	}
	if(!$category) {
		$cate_temp=mysql_fetch_array(mysql_query("select min(no) from $t_category"."_$id",$connect));
		$category=$cate_temp[0];
	}


// 필터링;; 관리자가 아닐때;;
	if(!$is_admin&&$setup[use_filter]) {
		$filter			= explode(",",$setup[filter]);
		$f_memo		= eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($memo));
		$f_name		= eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($name));
		$f_subject	= eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($subject));
		$f_email		= eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($getData[email]));
		$f_homepage= eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($getData[homepage]));
		for($i=0;$i<count($filter);$i++) {
			if(!isblank($filter[$i])) {
				if(eregi($filter[$i],$f_memo)){
					echo(iconv_UTF("<b>$filter[$i]</b> 은(는) 등록하기에 적합한 단어가 아닙니다"));
					exit;
				}
				if(eregi($filter[$i],$f_name)){ 
					echo(iconv_UTF("<b>$filter[$i]</b> 은(는) 등록하기에 적합한 단어가 아닙니다"));
					exit;
				}
				if(eregi($filter[$i],$f_subject)){ 
					echo(iconv_UTF("<b>$filter[$i]</b> 은(는) 등록하기에 적합한 단어가 아닙니다"));
					exit;
				}
				if(eregi($filter[$i],$f_email)){ 
					echo(iconv_UTF("<b>$filter[$i]</b> 은(는) 등록하기에 적합한 단어가 아닙니다"));
					exit;
				}
				if(eregi($filter[$i],$f_homepage)){ 
					echo(iconv_UTF("<b>$filter[$i]</b> 은(는) 등록하기에 적합한 단어가 아닙니다"));
					exit;
				}
			}
		}
	}

//패스워드를 암호화
	if(strlen($getData[password])) {
		$temp=mysql_fetch_array(mysql_query("select password('$password')"));
		$password=$temp[0];   
	}

	// 모바일에서는 내용의 HTML 금지
	$memo=del_html($memo);

	// 원본글을 가져옴
	unset($s_data);
	$s_data=mysql_fetch_array(mysql_query("select * from $t_board"."_$id where no='$no'"));

// 원본글을 이용한 비교
	if($mode=="modify"||$mode=="reply") {
		if(!$s_data[no]) {
			echo(iconv_UTF("원본글이 존재하지 않습니다"));
			exit;
		}
	}

// 공지글에는 답글이 안 달리게 처리
	if($mode=="reply"&&$s_data[headnum]<=-2000000000) {
		echo(iconv_UTF("공지글에는 답글을 달수 없습니다"));
		exit;
	}


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

// 각종 변수의 addslashes 시킴;;
	$name = addslashes(del_html($name));
	$subject = addslashes(del_html($subject));
	$memo = addslashes($memo);
	if($use_html<2) {
		$memo = str_replace("  ","&nbsp;&nbsp;",$memo);
		$memo = str_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$memo);
	}	
	$email = addslashes(del_html($getData[email]));
	$homepage = addslashes(del_html($getData[homepage]));

// 각종 변수 설정
	$ip = $REMOTE_ADDR; // 아이피값 구함;;
	$reg_date = time(); // 현재의 시간구함;;

	$x = $zx;
	$y = $zy;

// 도배인지 아닌지 검사;; 우선 같은 아이피대에 30초이내의 글은 도배로 간주;;
	if(!$is_admin&&$mode!="modify") {
		$max_no=mysql_fetch_array(mysql_query("select max(no) from $t_board"."_$id"));
		$temp=mysql_fetch_array(mysql_query("select count(*) from $t_board"."_$id where ip='$ip' and $reg_date - reg_date <30 and no='$max_no[0]'"));
		if($temp[0]>0) {echo(iconv_UTF("글등록은 30초이상이 지나야 가능합니다")); exit;}
	}

// 같은 내용이 있는지 검사;;
	if(!$is_admin&&$mode!="modify") {
		$max_no=mysql_fetch_array(mysql_query("select max(no) from $t_board"."_$id"));
		$temp=mysql_fetch_array(mysql_query("select count(*) from $t_board"."_$id where memo='$memo' and no='$max_no[0]'"));
		if($temp[0]>0) {echo(iconv_UTF("같은 내용의 글은 등록할수가 없습니다")); exit; }
	}


// 쿠키 설정;;
	if($mode!="modify") {

		// 4.0x 용 세션 처리
		if($name) {
			$zb_writer_name = $name;
			session_register("zb_writer_name");
		}
		if($email) {
			$zb_writer_email = $email;
			session_register("zb_writer_email");
		}
		if($homepage) {
			$zb_writer_homepage = $homepage;
			session_register("zb_writer_homepage");
		}
	}

/***************************************************************************
 * 수정글일때
 **************************************************************************/
	if($mode=="modify"&&$no) {

		if($s_data[ismember]) {
			if(!$is_admin&&$member[level]>$setup[grant_delete]&&$s_data[ismember]!=$member[no]){
				echo(iconv_UTF("정상적인 방법으로 수정하세요"));
				exit;
			}
		}

		// 비밀번호 검사;;
		if($s_data[ismember]!=$member[no]&&!$is_admin) {
			if($getData[password]!=$s_data[password]){
				echo(iconv_UTF("비밀번호가 틀렸습니다"));
				exit;
			}
		}

		// 공지 -> 일반글 
		if(!$notice&&$s_data[headnum]<="-2000000000") {
			$temp=mysql_fetch_array(mysql_query("select max(division) from $t_division"."_$id"));
			$max_division=$temp[0];
			$temp=mysql_fetch_array(mysql_query("select max(division) from $t_division"."_$id where num>0 and division!='$max_division'"));
			if(!$temp[0]) $second_division=0; else $second_division=$temp[0];

			// 헤드넘+1 한값을 가짐;;
			$max_headnum=mysql_fetch_array(mysql_query("select min(headnum) from $t_board"."_$id where (division='$max_division' or division='$second_division') and headnum>-2000000000")); // 공지가 아닌 최소 headnum 구함
			$headnum=$max_headnum[0]-1; 

			$next_data=mysql_fetch_array(mysql_query("select no,headnum,division from $t_board"."_$id where (division='$max_division' or division='$second_division') and headnum='$max_headnum[0]' and arrangenum='0'")); // 다음글을 구함;;
			if(!$next_data[0]) $next_data[0]="0";
			$next_no=$next_data[0];

			if(!$next_data[division]) $division=1; else $division=$next_data[division];

			$prev_data=mysql_fetch_array(mysql_query("select no from $t_board"."_$id where (division='$max_division' or division='$second_division') and headnum<'$headnum' and no!='$no' order by headnum desc limit 1")); // 이전글을 구함;;
			if($prev_data[0]) $prev_no=$prev_data[0]; else $prev_no=0;

			$child="0";
			$depth="0";    
			$arrangenum="0";
			$father="0";
			minus_division($s_data[division]);
			@mysql_query("update $t_board"."_$id set headnum='$headnum',prev_no='$prev_no',next_no='$next_no',child='$child',depth='$depth',arrangenum='$arrangenum',father='$father',name='$name',email='$email',homepage='$homepage',subject='$subject',memo='$memo',sitelink1='$sitelink1',sitelink2='$sitelink2',use_html='$use_html',reply_mail='$reply_mail',is_secret='$is_secret',category='$category' $del_que1 $del_que2 where no='$no'");
			plus_division($division);

			// 다음글의 이전글을 수정
			if($next_no)mysql_query("update $t_board"."_$id set prev_no='$no' where division='$next_data[division]' and headnum='$next_data[headnum]'");  

			// 이전글의 다음글을 수정
			if($prev_no)mysql_query("update $t_board"."_$id set next_no='$no' where no='$prev_no'");                  

			mysql_query("update $t_board"."_$id set prev_no=0 where (division='$max_division' or division='$second_division') and prev_no='$s_data[no]' and headnum!='$next_data[headnum]'");
			mysql_query("update $t_category"."_$id set num=num-1 where no='$s_data[category]'",$connect);
			mysql_query("update $t_category"."_$id set num=num+1 where no='$category'",$connect);
		}

   		// 일반글 -> 공지 
		elseif($notice&&$s_data[headnum]>-2000000000) {
			$temp=mysql_fetch_array(mysql_query("select max(division) from $t_division"."_$id"));
			$max_division=$temp[0];
			$temp=mysql_fetch_array(mysql_query("select max(division) from $t_division"."_$id where num>0 and division!='$max_division'"));
			if(!$temp[0]) $second_division=0; else $second_division=$temp[0];

			$max_headnum=mysql_fetch_array(mysql_query("select min(headnum) from $t_board"."_$id where division='$max_division' or division='$second_division'"));  // 최고글을 구함;;
			$headnum=$max_headnum[0]-1;
			if($headnum>-2000000000) $headnum=-2000000000; // 최고 headnum이 공지가 아니면 현재 글에 공지를 넣음;

			$next_data=mysql_fetch_array(mysql_query("select no,headnum,division from $t_board"."_$id where (division='$max_division' or division='$second_division') and headnum='$max_headnum[0]' and arrangenum='0'"));
			if(!$next_data[0]) $next_data[0]="0";
			$next_no=$next_data[0];
			$prev_no=0;
			$child="0";
			$depth="0";
			$arrangenum="0";
			$father="0";
			minus_division($s_data[division]);
			$division=add_division();
			@mysql_query("update $t_board"."_$id set division='$division',headnum='$headnum',prev_no='$prev_no',next_no='$next_no',child='$child',depth='$depth',arrangenum='$arrangenum',father='$father',name='$name',email='$email',homepage='$homepage',subject='$subject',memo='$memo',sitelink1='$sitelink1',sitelink2='$sitelink2',use_html='$use_html',reply_mail='$reply_mail',is_secret='$is_secret',category='$category' $del_que1 $del_que2 where no='$no'");

			if($s_data[father]) mysql_query("update $t_board"."_$id set child='$s_data[child]' where no='$s_data[father]'"); // 답글이었으면 원본글의 답글을 현재글의 답글로 대체
			if($s_data[child]) mysql_query("update $t_board"."_$id set depth=depth-1,father='$s_data[father]' where no='$s_data[child]'"); // 답글이 있으면 현재글의 위치로;;

			// 원래 다음글로 이글을 가지고 있었던 데이타의 prev_no을 바꿈;
			$temp=mysql_fetch_array(mysql_query("select max(headnum) from $t_board"."_$id where headnum<='$s_data[headnum]'"));
			$temp=mysql_fetch_array(mysql_query("select no from $t_board"."_$id where headnum='$temp[0]' and depth='0'"));
			mysql_query("update $t_board"."_$id set prev_no='$temp[no]' where prev_no='$s_data[no]'");

			mysql_query("update $t_board"."_$id set next_no='$s_data[next_no]' where next_no='$s_data[no]'");

			mysql_query("update $t_board"."_$id set prev_no='$no' where prev_no='0' and no!='$no'"); // 다음글의 이전글을 설정 
			mysql_query("update $t_category"."_$id set num=num-1 where no='$s_data[category]'",$connect);
			mysql_query("update $t_category"."_$id set num=num+1 where no='$category'",$connect);

		// 일반->일반, 공지->공지 일때 
		} else {
			@mysql_query("update $t_board"."_$id set name='$name',subject='$subject',email='$email',homepage='$homepage',memo='$memo',sitelink1='$sitelink1',sitelink2='$sitelink2',use_html='$use_html',reply_mail='$reply_mail',is_secret='$is_secret',category='$category' $del_que1 $del_que2 where no='$no'");
			mysql_query("update $t_category"."_$id set num=num-1 where no='$s_data[category]'",$connect);
			mysql_query("update $t_category"."_$id set num=num+1 where no='$category'",$connect);
		}



/***************************************************************************
 * 답변글일때
 **************************************************************************/
	} elseif($mode=="reply"&&$no) {

		$prev_no=$s_data[prev_no];
		$next_no=$s_data[next_no];
		$father=$s_data[no];
		$child=0;
		$headnum=$s_data[headnum];    
		if($headnum<=-2000000000&&$notice) {
			echo(iconv_UTF("공지사항에는 답글을 달수가 없습니다"));
			exit;
		}
		$depth=$s_data[depth]+1;
		$arrangenum=$s_data[arrangenum]+1;
		$move_result=mysql_query("select no from $t_board"."_$id where division='$s_data[division]' and headnum='$headnum' and arrangenum>='$arrangenum'");
		while($move_data=mysql_fetch_array($move_result)) {
			mysql_query("update $t_board"."_$id set arrangenum=arrangenum+1 where no='$move_data[no]'");
		}

		$division=$s_data[division];
		plus_division($s_data[division]);
   
		// 답글 데이타 입력;;
		mysql_query("insert into $t_board"."_$id (division,headnum,arrangenum,depth,prev_no,next_no,father,child,ismember,memo,ip,password,name,homepage,email,subject,use_html,reply_mail,category,is_secret,sitelink1,sitelink2,file_name1,file_name2,s_file_name1,s_file_name2,x,y,reg_date,islevel) values ('$division','$headnum','$arrangenum','$depth','$prev_no','$next_no','$father','$child','$member[no]','$memo','$ip','$password','$name','$homepage','$email','$subject','$use_html','$reply_mail','$category','$is_secret','$sitelink1','$sitelink2','$file_name1','$file_name2','$s_file_name1','$s_file_name2','$x','$y','$reg_date','$member[is_admin]')");    

		// 원본글과 원본글의 아래글의 속성 변경;;
		$no=mysql_insert_id();
		mysql_query("update $t_board"."_$id set child='$no' where no='$s_data[no]'");
		mysql_query("update $t_category"."_$id set num=num+1 where no='$category'",$connect);

		// 현재글의 조회수를 올릴수 없게 세션 등록
		$hitStr=",".$setup[no]."_".$no;
		$zb_hit=$HTTP_SESSION_VARS["zb_hit"].$hitStr;
		session_register("zb_hit");

		// 현재글의 추천을 할수 없게 세션 등록
		$voteStr=",".$setup[no]."_".$no;
		$zb_vote=$HTTP_SESSION_VARS["zb_vote"].$voteStr;
		session_register("zb_vote");

		// 응답글 보내기일때;;
		if($s_data[reply_mail]&&$s_data[email]) {

			if($use_html<2) $memo=nl2br($memo);
			$memo = stripslashes($memo);

			zb_sendmail($use_html, $s_data[email], $s_data[name], $email, $name, $subject, $memo);
		}

/***************************************************************************
 * 신규 글쓰기일때
 **************************************************************************/
	} elseif($mode=="write") {

		// 공지사항이 아닐때;;
		if(!$notice) {
			$temp=mysql_fetch_array(mysql_query("select max(division) from $t_division"."_$id"));
			$max_division=$temp[0];
			$temp=mysql_fetch_array(mysql_query("select max(division) from $t_division"."_$id where num>0 and division!='$max_division'"));
			if(!$temp[0]) $second_division=0; else $second_division=$temp[0];

			$max_headnum=mysql_fetch_array(mysql_query("select min(headnum) from $t_board"."_$id where (division='$max_division' or division='$second_division') and headnum>-2000000000"));
			if(!$max_headnum[0]) $max_headnum[0]=0;

			$headnum=$max_headnum[0]-1;

			$next_data=mysql_fetch_array(mysql_query("select division,headnum,arrangenum from $t_board"."_$id where (division='$max_division' or division='$second_division') and headnum>-2000000000 order by headnum limit 1"));
			if(!$next_data[0]) $next_data[0]="0";
			else {
				$next_data=mysql_fetch_array(mysql_query("select no,headnum,division from $t_board"."_$id where division='$next_data[division]' and headnum='$next_data[headnum]' and arrangenum='$next_data[arrangenum]'"));
			}
    
			$prev_data=mysql_fetch_array(mysql_query("select no from $t_board"."_$id where (division='$max_division' or division='$second_division') and headnum<=-2000000000 order by headnum desc limit 1"));
			if($prev_data[0]) $prev_no=$prev_data[0]; else $prev_no="0";

		// 공지사항일때;; 
		} else {
			$temp=mysql_fetch_array(mysql_query("select max(division) from $t_division"."_$id"));
			$max_division=$temp[0]+1;
			$temp=mysql_fetch_array(mysql_query("select max(division) from $t_division"."_$id where num>0 and division!='$max_division'"));
			if(!$temp[0]) $second_division=0; else $second_division=$temp[0];

			$max_headnum=mysql_fetch_array(mysql_query("select min(headnum) from $t_board"."_$id where division='$max_division' or division='$second_division'"));
			$headnum=$max_headnum[0]-1;
			if($headnum>-2000000000) $headnum=-2000000000;

			$next_data=mysql_fetch_array(mysql_query("select division,headnum from $t_board"."_$id where division='$max_division' or division='$second_division' order by headnum limit 1"));
			if(!$next_data[0]) $next_data[0]="0";
			else {
				$next_data=mysql_fetch_array(mysql_query("select no,headnum,division from $t_board"."_$id where division='$next_data[division]' and headnum='$next_data[headnum]' and arrangenum='0'"));
			}
			$prev_no=0; 
		}

		$next_no=$next_data[no];
		$child="0";
		$depth="0";
		$arrangenum="0";
		$father="0";
		$division=add_division();

		mysql_query("insert into $t_board"."_$id (division,headnum,arrangenum,depth,prev_no,next_no,father,child,ismember,memo,ip,password,name,homepage,email,subject,use_html,reply_mail,category,is_secret,sitelink1,sitelink2,file_name1,file_name2,s_file_name1,s_file_name2,x,y,reg_date,islevel) values ('$division','$headnum','$arrangenum','$depth','$prev_no','$next_no','$father','$child','$member[no]','$memo','$ip','$password','$name','$homepage','$email','$subject','$use_html','$reply_mail','$category','$is_secret','$sitelink1','$sitelink2','$file_name1','$file_name2','$s_file_name1','$s_file_name2','$x','$y','$reg_date','$member[is_admin]')");
		$no=mysql_insert_id();

		// 현재글의 조회수를 올릴수 없게 세션 등록
		$hitStr=",".$setup[no]."_".$no;
		$zb_hit=$HTTP_SESSION_VARS["zb_hit"].$hitStr;
		session_register("zb_hit");

		// 현재글의 추천을 할수 없게 세션 등록
		$voteStr=",".$setup[no]."_".$no;
		$zb_vote=$HTTP_SESSION_VARS["zb_vote"].$voteStr;
		session_register("zb_vote");

		if($prev_no) mysql_query("update $t_board"."_$id set next_no='$no' where no='$prev_no'");
		if($next_no) mysql_query("update $t_board"."_$id set prev_no='$no' where headnum='$next_data[headnum]' and division='$next_data[division]'");
		mysql_query("update $t_category"."_$id set num=num+1 where no='$category'",$connect);
	}


// 글의 갯수를 다시 갱신
	$total=mysql_fetch_array(mysql_query("select count(*) from $t_board"."_$id "));
	mysql_query("update $admin_table set total_article='$total[0]' where name='$id'");

// 회원일 경우 해당 해원의 점수 주기
	if($mode=="write"||$mode=="reply") @mysql_query("update $member_table set point1=point1+1 where no='$member[no]'",$connect);

// MySQL 닫기 
	if($connect) {
		mysql_close($connect); 
		unset($connect);
	}
	echo("SUCCESS@zboard_m.php?id=$id&page=$page&page_num=$page_num&select_arrange=$select_arrange&desc=$des&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&no=$no&category=$category");
	exit;
?>
