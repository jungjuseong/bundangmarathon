<?
if(!file_exists(getcwd().'/zboard.php')) die('�������� ������ �ƴմϴ�.');

// ��� ���� �̸� ����
	if(!$setup[use_alllist]) $view_file_link="view.php"; else $view_file_link="zboard.php";

// ������ üũ
	if($setup[grant_comment]<$member[level]&&!$is_admin) Error("�������� �����ϴ�","login.php?id=$id&page=$page&page_num=$page_num&category=$category&sn=$sn&ss=$ss&sc=$sc&su=$su&keyword=$keyword&no=$no&file=$view_file_link");

// ���� ���� �˻�;;
	$memo = str_replace("��","",$memo);
	if(isblank($memo) && $ment_type!="vote" && $ment_type!="del") Error("������ �Է��ϼž� �մϴ�");
	if(!$member[no]) {
		if(isblank($name)) Error("�̸��� �Է��ϼž� �մϴ�");
		if(isblank($password)) Error("��й�ȣ�� �Է��ϼž� �մϴ�");
	}

// ���͸�;; �����ڰ� �ƴҶ�;;
	if(!$is_admin&&$setup[use_filter]) {
		$filter=explode(",",$setup[filter]);

		$f_memo=eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($memo));
		$f_name=eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($name));
		$f_subject=eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($subject));
		$f_email=eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($email));
		$f_homepage=eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($homepage));
		for($i=0;$i<count($filter);$i++) 
		if(!isblank($filter[$i])) {
			if(eregi($filter[$i],$f_memo)) Error("<b>$filter[$i]</b> ��(��) ����ϱ⿡ ������ �ܾ �ƴմϴ�");
			if(eregi($filter[$i],$f_name)) Error("<b>$filter[$i]</b> ��(��) ����ϱ⿡ ������ �ܾ �ƴմϴ�");
		}
	}

// ȸ������� �Ǿ� ������ �̸����� ������;;
	if($member[no]) {
		if($mode=="modify"&&$member[no]!=$s_data[ismember]) {
			$name=$s_data[name];
		} else {
			$name=$member[name];
		}
	}

// �н����带 ��ȣȭ
	if($password) {
		$temp=mysql_fetch_array(mysql_query("select password('$password')"));
		$password=$temp[0];   
	}

// �������̰ų� HTML��뷹���� ������ �±��� ���������� üũ
	if(!$is_admin&&$setup[grant_html]<$member[level]) {
		$memo=del_html($memo);// ������ HTML ����;;
	}

// ���� ������ addslashes ��Ŵ
	$name=addslashes(del_html($name));
	$memo=autolink($memo);
	$memo=addslashes($memo);

// �ڸ�Ʈ�� �ְ� Number ���� ���� (�ߺ� üũ�� ���ؼ�)
	$max_no=mysql_fetch_array(mysql_query("select max(no) from $t_comment"."_$id where parent='$no'"));

// ���� ������ �ִ��� �˻�;;
	$ment_check=false;
	if($ment_type!="vote" && $ment_type!="del") $ment_check=true;
	if($is_admin) $ment_check=false;
	if($ment_check) {
		$temp=mysql_fetch_array(mysql_query("select count(*) from $t_comment"."_$id where memo='$memo' and no='$max_no[0]'"));
		if($temp[0]>0) Error("���� ������ ���� ����Ҽ��� �����ϴ�");
	}

// ���� ���� ����
	$reg_date=time(); // ������ �ð�����;;
	$parent=$no;

// �ڸ�Ʈ ����
	if ($ment_type=="del") {
		$m_data=@mysql_fetch_array(mysql_query("select * from dq_revolution where zb_id='$id' and zb_no='$no'"));

		if(!eregi($member[no],$m_data[vote_users])) error("�������� ������ �ƴմϴ�.");

	// ��õ �Խù� ��Ͽ��� ���� �Խù� ����
		$vote_article=str_replace(",".$id." $no","",$member[vote_article]);
		mysql_query("update zetyx_member_table set vote_article='$vote_article' where no='$member[no]'") or error(mysql_error());

	// ��õ�� ��Ͽ��� ����ȸ���� ����
		$vote_users=str_replace("<".$member[no].">".$member[name],"",$m_data[vote_users]);
		mysql_query("update dq_revolution set vote_users='$vote_users' where zb_id='$id' and zb_no='$no'") or error(mysql_error());

	// ������� Vote�� ����;;
		mysql_query("update $t_board"."_$id set vote=vote-1 where no='$no'");
	}

// �ڸ�Ʈ �Է�
	if(!isblank($memo) && $ment_type != 'edit') {
	// �ڸ�Ʈ �Է�
		mysql_query("insert into $t_comment"."_$id (parent,ismember,name,password,memo,reg_date,ip) values ('$parent','$member[no]','$name','$password','$memo','$reg_date','$REMOTE_ADDR')") or error(mysql_error());

	// �����Ⱓ�� ���� �Խù��� �ڸ�Ʈ�� �������� ������ �˸�
		$s_data=mysql_fetch_array(mysql_query("select no,reg_date,ismember,name,subject from $t_board"."_$id where no='$no'")) or error(mysql_error());
		if($skin_setup['using_sendCommentMemo'] && $s_data['ismember'] && $s_data['ismember'] != $member['no']) {
			$limitday = $skin_setup['using_sendCommentMemo2'];
			$time_count = time()-(60*60*24*$limitday);
			if(date('Ymd',$s_data[reg_date]) < date('Ymd',$time_count)) {
				$reg_date = time();
				$s_subj = $s_data[subject];
				$subject = "ª����� �˸�";
				$memo2 = "�� ������ $s_data[name]�Բ��� �ۼ��� �Խù��� <b>".$limitday."��</b> �̻� ����� �Խù��� ª�� ����� ���������� �ڵ����� �뺸�Ǵ� �˸� �޼��� �Դϴ�.<br>�������� �ּҴ� <a href=view.php?id=$id&no=$no target=_blank>zboard.php?id=$id&no=$no</a> �Դϴ�.<br><br>����:$s_subj<br>�۾���: ".$name."<br>-------------������ ����-------------<br><br>".$memo."<br><br><a href=view.php?id=$id&no=$no target=_blank><b>������ �ٷΰ��� (Ŭ��)</b></a>";

				mysql_query("insert into $get_memo_table (member_no,member_from,subject,memo,readed,reg_date) 							values ('$s_data[ismember]','1','$subject','$memo2',1,'$reg_date')") or error(mysql_error());
				mysql_query("insert into $send_memo_table (member_to,member_no,subject,memo,readed,reg_date) 							values ('$s_data[ismember]','1','$subject','$memo2',1,'$reg_date')") or error(mysql_error());
				mysql_query("update $member_table set new_memo=1 where no='$s_data[ismember]'") or error(mysql_error());
			}
		}

	// �ڸ�Ʈ ������ ���ؼ� ����
		$total=mysql_fetch_array(mysql_query("select count(*) from $t_comment"."_$id where parent='$no'"));
		mysql_query("update $t_board"."_$id set total_comment='$total[0]' where no='$no'") or error(mysql_error());


	// ȸ���� ��� �ش� ȸ���� ���� �ֱ�
		if ($member['no'] && strlen($memo)>$skin_setup['comment_nopoint2']) {
			@mysql_query("update $member_table set point2=point2+1 where no='$member[no]'",$connect) or error(mysql_error());
		}

	}

// �ڸ�Ʈ ����
	if(!isblank($memo) && $ment_type == 'edit') update_comment($memo,$c_no);

// ��õ ó�� - �������
	if ($ment_type=="vote") {
	// ȸ�����̺� ��õ�� ����ϱ� ���� �ʵ尡 �����ϴ��� �˻��ϰ� ���ٸ� ����
		@mysql_field_name(mysql_query("SELECT vote_article from zetyx_member_table"),0) or mysql_query("ALTER TABLE `zetyx_member_table` ADD `vote_article` TEXT");

		$m_data=@mysql_fetch_array(mysql_query("select * from dq_revolution where zb_id='$id' and zb_no='$no'")); 

		$temp = mysql_fetch_array(mysql_query("select ismember from $t_board"."_$id where no=$no "));
		if ($temp[ismember] == $member[no]) {Error("�ڽ��� �Խù����� ��õ�Ҽ� �����ϴ�.");} // ���� ����
		elseif(!$member[no]) {Error ("��ȸ���� ��õ�ϽǼ� �����ϴ�.");} // ��ȸ�� ��õ����

	// ������� Vote�� �ø�;;
		if(!ereg("<".$member[no].">",$m_data[vote_users])){
			mysql_query("update $t_board"."_$id set vote=vote+1 where no='$no'");
		}
		else Error("�̹� ��õ�ϼ̽��ϴ�.");

		$vote_article=",".$id." ".$no.$member[vote_article];
		$vote_users="<".$member[no].">".$member[name].$m_data[vote_users];
		mysql_query("update zetyx_member_table set vote_article='$vote_article' where no='$member[no]'") or error(mysql_error());
		if($m_data[no]) 
			mysql_query("update dq_revolution set vote_users='$vote_users' where zb_id='$id' and zb_no='$no'") or error(mysql_error());
		else mysql_query("insert into dq_revolution (zb_id,zb_no,vote_users) values ('$id','$no','$vote_users')") or error(mysql_error());


	// ���� ��õ�� �϶� �Խù� �̵�		
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

// ������ �̵�
	movepage("$view_file_link?id=$id&page=$page&page_num=$page_num&select_arrange=$select_arrange&desc=$des&sn=$sn&ss=$ss&sc=$sc&su=$su&keyword=$keyword&no=$no&category=$category");
?>
