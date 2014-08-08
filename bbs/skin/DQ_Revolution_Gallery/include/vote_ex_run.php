<?
if(!file_exists(getcwd().'/zboard.php')) die('정상적인 접근이 아닙니다.');

// 대상 파일 이름 정리
	if(!$setup[use_alllist]) $view_file_link="view.php"; else $view_file_link="zboard.php";

// 사용권한 체크
	if($setup[grant_comment]<$member[level]&&!$is_admin) Error("사용권한이 없습니다","login.php?id=$id&page=$page&page_num=$page_num&category=$category&sn=$sn&ss=$ss&sc=$sc&su=$su&keyword=$keyword&no=$no&file=$view_file_link");

// 각종 변수 검사;;
	$memo = str_replace("ㅤ","",$memo);
	if(isblank($memo) && $ment_type!="vote" && $ment_type!="del") Error("내용을 입력하셔야 합니다");
	if(!$member[no]) {
		if(isblank($name)) Error("이름을 입력하셔야 합니다");
		if(isblank($password)) Error("비밀번호를 입력하셔야 합니다");
	}

// 필터링;; 관리자가 아닐때;;
	if(!$is_admin&&$setup[use_filter]) {
		$filter=explode(",",$setup[filter]);

		$f_memo=eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($memo));
		$f_name=eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($name));
		$f_subject=eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($subject));
		$f_email=eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($email));
		$f_homepage=eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($homepage));
		for($i=0;$i<count($filter);$i++) 
		if(!isblank($filter[$i])) {
			if(eregi($filter[$i],$f_memo)) Error("<b>$filter[$i]</b> 은(는) 등록하기에 적합한 단어가 아닙니다");
			if(eregi($filter[$i],$f_name)) Error("<b>$filter[$i]</b> 은(는) 등록하기에 적합한 단어가 아닙니다");
		}
	}

// 회원등록이 되어 있을때 이름등을 가져옴;;
	if($member[no]) {
		if($mode=="modify"&&$member[no]!=$s_data[ismember]) {
			$name=$s_data[name];
		} else {
			$name=$member[name];
		}
	}

// 패스워드를 암호화
	if($password) {
		$temp=mysql_fetch_array(mysql_query("select password('$password')"));
		$password=$temp[0];   
	}

// 관리자이거나 HTML허용레벨이 낮을때 태그의 금지유무를 체크
	if(!$is_admin&&$setup[grant_html]<$member[level]) {
		$memo=del_html($memo);// 내용의 HTML 금지;;
	}

// 각종 변수의 addslashes 시킴
	$name=addslashes(del_html($name));
	$memo=autolink($memo);
	$memo=addslashes($memo);

// 코멘트의 최고 Number 값을 구함 (중복 체크를 위해서)
	$max_no=mysql_fetch_array(mysql_query("select max(no) from $t_comment"."_$id where parent='$no'"));

// 같은 내용이 있는지 검사;;
	$ment_check=false;
	if($ment_type!="vote" && $ment_type!="del") $ment_check=true;
	if($is_admin) $ment_check=false;
	if($ment_check) {
		$temp=mysql_fetch_array(mysql_query("select count(*) from $t_comment"."_$id where memo='$memo' and no='$max_no[0]'"));
		if($temp[0]>0) Error("같은 내용의 글은 등록할수가 없습니다");
	}

// 각종 변수 설정
	$reg_date=time(); // 현재의 시간구함;;
	$parent=$no;

// 코멘트 삭제
	if ($ment_type=="del") {
		$m_data=@mysql_fetch_array(mysql_query("select * from dq_revolution where zb_id='$id' and zb_no='$no'"));

		if(!eregi($member[no],$m_data[vote_users])) error("정상적인 접근이 아닙니다.");

	// 추천 게시물 목록에서 현재 게시물 삭제
		$vote_article=str_replace(",".$id." $no","",$member[vote_article]);
		mysql_query("update zetyx_member_table set vote_article='$vote_article' where no='$member[no]'") or error(mysql_error());

	// 추천인 목록에서 현재회원을 삭제
		$vote_users=str_replace("<".$member[no].">".$member[name],"",$m_data[vote_users]);
		mysql_query("update dq_revolution set vote_users='$vote_users' where zb_id='$id' and zb_no='$no'") or error(mysql_error());

	// 현재글의 Vote수 내림;;
		mysql_query("update $t_board"."_$id set vote=vote-1 where no='$no'");
	}

// 코멘트 입력
	if(!isblank($memo) && $ment_type != 'edit') {
	// 코멘트 입력
		mysql_query("insert into $t_comment"."_$id (parent,ismember,name,password,memo,reg_date,ip) values ('$parent','$member[no]','$name','$password','$memo','$reg_date','$REMOTE_ADDR')") or error(mysql_error());

	// 일정기간이 지난 게시물에 코멘트를 남겼을때 쪽지로 알림
		$s_data=mysql_fetch_array(mysql_query("select no,reg_date,ismember,name,subject from $t_board"."_$id where no='$no'")) or error(mysql_error());
		if($skin_setup['using_sendCommentMemo'] && $s_data['ismember'] && $s_data['ismember'] != $member['no']) {
			$limitday = $skin_setup['using_sendCommentMemo2'];
			$time_count = time()-(60*60*24*$limitday);
			if(date('Ymd',$s_data[reg_date]) < date('Ymd',$time_count)) {
				$reg_date = time();
				$s_subj = $s_data[subject];
				$subject = "짧은답글 알림";
				$memo2 = "이 쪽지는 $s_data[name]님께서 작성한 게시물중 <b>".$limitday."일</b> 이상 경과한 게시물에 짧은 답글이 남겨졌을때 자동으로 통보되는 알림 메세지 입니다.<br>원본글의 주소는 <a href=view.php?id=$id&no=$no target=_blank>zboard.php?id=$id&no=$no</a> 입니다.<br><br>제목:$s_subj<br>글쓴이: ".$name."<br>-------------남겨진 내용-------------<br><br>".$memo."<br><br><a href=view.php?id=$id&no=$no target=_blank><b>원본글 바로가기 (클릭)</b></a>";

				mysql_query("insert into $get_memo_table (member_no,member_from,subject,memo,readed,reg_date) 							values ('$s_data[ismember]','1','$subject','$memo2',1,'$reg_date')") or error(mysql_error());
				mysql_query("insert into $send_memo_table (member_to,member_no,subject,memo,readed,reg_date) 							values ('$s_data[ismember]','1','$subject','$memo2',1,'$reg_date')") or error(mysql_error());
				mysql_query("update $member_table set new_memo=1 where no='$s_data[ismember]'") or error(mysql_error());
			}
		}

	// 코멘트 갯수를 구해서 정리
		$total=mysql_fetch_array(mysql_query("select count(*) from $t_comment"."_$id where parent='$no'"));
		mysql_query("update $t_board"."_$id set total_comment='$total[0]' where no='$no'") or error(mysql_error());


	// 회원일 경우 해당 회원의 점수 주기
		if ($member['no'] && strlen($memo)>$skin_setup['comment_nopoint2']) {
			@mysql_query("update $member_table set point2=point2+1 where no='$member[no]'",$connect) or error(mysql_error());
		}

	}

// 코멘트 수정
	if(!isblank($memo) && $ment_type == 'edit') update_comment($memo,$c_no);

// 추천 처리 - 레볼루션
	if ($ment_type=="vote") {
	// 회원테이블에 추천을 기록하기 위한 필드가 존제하는지 검사하고 없다면 생성
		@mysql_field_name(mysql_query("SELECT vote_article from zetyx_member_table"),0) or mysql_query("ALTER TABLE `zetyx_member_table` ADD `vote_article` TEXT");

		$m_data=@mysql_fetch_array(mysql_query("select * from dq_revolution where zb_id='$id' and zb_no='$no'")); 

		$temp = mysql_fetch_array(mysql_query("select ismember from $t_board"."_$id where no=$no "));
		if ($temp[ismember] == $member[no]) {Error("자신의 게시물에는 추천할수 없습니다.");} // 자추 막기
		elseif(!$member[no]) {Error ("비회원은 추천하실수 없습니다.");} // 비회원 추천막기

	// 현재글의 Vote수 올림;;
		if(!ereg("<".$member[no].">",$m_data[vote_users])){
			mysql_query("update $t_board"."_$id set vote=vote+1 where no='$no'");
		}
		else Error("이미 추천하셨습니다.");

		$vote_article=",".$id." ".$no.$member[vote_article];
		$vote_users="<".$member[no].">".$member[name].$m_data[vote_users];
		mysql_query("update zetyx_member_table set vote_article='$vote_article' where no='$member[no]'") or error(mysql_error());
		if($m_data[no]) 
			mysql_query("update dq_revolution set vote_users='$vote_users' where zb_id='$id' and zb_no='$no'") or error(mysql_error());
		else mysql_query("insert into dq_revolution (zb_id,zb_no,vote_users) values ('$id','$no','$vote_users')") or error(mysql_error());


	// 적정 추천수 일때 게시물 이동		
		$vote_count = mysql_fetch_array(mysql_query("select vote, headnum from $t_board"."_$id where no='$no'"));
		if($skin_setup['move_vote'] && $skin_setup['move_vote2'] == $vote_count[vote]) {
			$exec = $skin_setup['move_vote4'];
			$board_name = $skin_setup['move_vote3'];
			$org_no = $no;
			$tmp_no = move_zbArticle($id,$no,$board_name,$exec);
			if($exec == 'move_all') {
				$no = $tmp_no;
				$id = $board_name;
				@mysql_close($connect);
				movepage("$view_file_link?id=$id&no=$no");
			} else $no = $org_no;
		}
	}

	@mysql_close($connect);

// 페이지 이동
	movepage("$view_file_link?id=$id&page=$page&page_num=$page_num&select_arrange=$select_arrange&desc=$des&sn=$sn&ss=$ss&sc=$sc&su=$su&keyword=$keyword&no=$no&category=$category");
?>
