<?
/**********************************************************************************
 * ���� ���� include
 *********************************************************************************/
	include "_head.php";

/**********************************************************************************
 * ���� üũ
 *********************************************************************************/
	// �׷� ���� ���ؿ���
	$setup=get_table_attrib($id);

	// ������ üũ
	if($exec=="view_all"&&$setup[grant_view]<$member[level]&&!$is_admin) Error("�������� �����ϴ�","login.php?id=$id&page=$page&page_num=$page_num&category=$category&keykind=$keykind&keyword=$keyword&no=$no&file=zboard.php");

	if($exec!="view_all") unset($setup);

	if(!$is_admin&&$exec!="view_all") Error("�������� �����ϴ�","login.php?id=$id&page=$page&page_num=$page_num&category=$category&keykind=$keykind&keyword=$keyword&no=$no&file=zboard.php");

	$select_list=$selected;
	$selected=explode(";",$selected);

	if($exec=="copy_all") $_kind = "����";
	elseif($exec=="move_all") $_kind = "�̵�";
	elseif($exec=="delete_all") $_kind = "����";

/**********************************************************************************
 * ���� ������ �Լ� �����ϰ� ����Ҽ� �ִ� ��
 *********************************************************************************/
	function _send_message($to, $from, $subject, $memo) {

		global $get_memo_table, $send_memo_table, $member_table;

		$reg_date = time();

		mysql_query("insert into $get_memo_table (member_no,member_from,subject,memo,readed,reg_date)
					values ('$to','$from','$subject','$memo',1,'$reg_date')") or error(mysql_error());

		mysql_query("insert into $send_memo_table (member_to,member_no,subject,memo,readed,reg_date)
					values ('$to','$from','$subject','$memo',1,'$reg_date')") or error(mysql_error());

		mysql_query("update $member_table set new_memo=1 where no='$to'") or error(mysql_error());
	}


/**********************************************************************************
 * View_All �϶� (���õ� �Խù� ����)
 *********************************************************************************/

	if($exec=="view_all") {

		$_view_included = true;
		$_view_included2 = true;
		$href.="&selected=$select_list";

		head();

		// ��� ��Ȳ �κ� ���
		include "$dir/setup.php";

		for($i=count($selected)-2;$i>=0;$i--) {
			$no = $selected[$i];
			include "view.php";
		}

		// layer ���
		if($zbLayer) {
			echo "\n<script>".$zbLayer."\n</script>";
			unset($zbLayer);
		}

		foot();

	}


/**********************************************************************************
 * Delete_All �϶� (���õ� �Խù� ����)
 *********************************************************************************/

	elseif($exec=="delete_all") {

		for ($i=0;$i<count($selected)-1;$i++) {

			$temp=mysql_fetch_array(mysql_query("select * from $t_board"."_$id where no='$selected[$i]'"));

			// ����� ������
			if(!$temp[child]) {

				// �ۻ���
				mysql_query("delete from $t_board"."_$id where no='$selected[$i]'") or Error(mysql_error());

				// ī�װ������� ���� �ϳ� ��
				mysql_query("update $t_category"."_$id set num=num-1 where no='$temp[category]'",$connect);

				// ���ϻ���
				@z_unlink("./".$temp[file_name1]);
				@z_unlink("./".$temp[file_name2]);

				// Divison ����
				minus_division($temp[division]);

				// ����, �����ۿ� ���� ����
				if($temp[depth]==0) {
					// �������� ������ ���ڸ� �޲�;;;
					if($temp[prev_no]) mysql_query("update $t_board"."_$id set next_no='$temp[next_no]' where next_no='$temp[no]'");
					// �������� ������ ���ڸ� �޲�;;;
					if($temp[next_no]) mysql_query("update $t_board"."_$id set prev_no='$temp[prev_no]' where prev_no='$temp[no]'");
				} else {
					$temp2=mysql_fetch_array(mysql_query("select count(*) from $t_board"."_$id where father='$temp[father]'"));
					// �������� ������ �������� �ڽ� ���� ����;;;
					if(!$temp2[0]) mysql_query("update $t_board"."_$id set child='0' where no='$temp[father]'");
				}
				mysql_query("delete from $t_comment"."_$id where parent='$selected[$i]'") or Error(mysql_error()); // �ڸ�Ʈ����

				// �޽��� ������ �κ�
				if($notice_user) {
					if($temp[ismember]) {
						$_to = $temp[ismember];
						$_from = $member[no];
						$_subject = stripslashes($temp[name])." ���� �Խù��� ".$_kind."�Ǿ����ϴ�";
						$_memo = stripslashes($temp[name])." �Բ��� ���� \"".stripslashes($temp[subject])."\" ���� $member[name]�Կ� ���ؼ� �Խ��� ���ݿ� �������� �ʾƼ� ".$_kind." �Ǿ����ϴ�\n";
						_send_message($_to,$_from,$_subject,$_memo);
					}
				}

			}
		}
		$temp=mysql_fetch_array(mysql_query("select count(*) from  $t_board"."_$id",$connect));
		@mysql_query("update $admin_table set total_article='$temp[0]' where name='$id'") or Error(mysql_error());
		echo"<script>opener.window.history.go(0);window.close();</script>";
	}

/**********************************************************************************
 * Copy All �϶� (���õ� �Խù� �̵�)
 *********************************************************************************/

	elseif($exec=="copy_all"||$exec=="move_all") {

		for($i=0;$i<count($selected)-1;$i++) {
			$s_data=mysql_fetch_array(mysql_query("select * from $t_board"."_$id where no='$selected[$i]'"));


			// ����� ������;;
			if($s_data[arrangenum]==0) {

				// �������� ��� ����
				$result=mysql_query("select * from $t_board"."_$id where headnum='$s_data[headnum]' order by arrangenum",$connect) or error(mysql_error());

				$temp=mysql_fetch_array(mysql_query("select max(division) from $t_division"."_$board_name",$connect));
				$max_division=$temp[0];
				$temp=mysql_fetch_array(mysql_query("select max(division) from $t_division"."_$board_name where num>0 and division!='$max_division'",$connect));
				if(!$temp[0]) $second_division=0; else $second_division=$temp[0];

     			// �̵��� �Խ����� �ְ� headnum�� ����
				$max_headnum=mysql_fetch_array(mysql_query("select min(headnum) from $t_board"."_$board_name where (division='$max_division' or division='$second_division') and headnum>-2000000000",$connect));
				if(!$max_headnum[0]) $max_headnum[0]=0;
				$headnum=$max_headnum[0]-1;

				// �̵��� �Խ����� ����, ���ı��� ����
				$next_data=mysql_fetch_array(mysql_query("select division,headnum,arrangenum from $t_board"."_$board_name where (division='$max_division' or division='$second_division') and headnum>-2000000000 order by headnum limit 1"));
				if(!$next_data[0]) $next_data[0]="0";
				else $next_data=mysql_fetch_array(mysql_query("select no,headnum,division from $t_board"."_$board_name where division='$next_data[division]' and headnum='$next_data[headnum]' and arrangenum='$next_data[arrangenum]'"));

/* yhkim : min --> max */
				$a_category=mysql_fetch_array(mysql_query("select max(no) from $t_category"."_$board_name",$connect));
				$category=$a_category[0];

				$next_no=$next_data[no];
				$father=0;
				$term_father=0;
				$root_no=0;

				// looping �ϸ鼭 ����Ÿ �Է�
				while($data=mysql_fetch_array($result)) {

					if(!is_dir("./data/$board_name")) {
						@mkdir("./data/$board_name",0777);
					}

					// ���ε�� ������ ������� ó�� #1
					if($data[s_file_name1]) {
						$temp_ext=time();
						@mkdir("./data/$board_name/".$temp_ext,0777);
						@copy($data[file_name1] , "./data/$board_name/".$temp_ext."/".$data[s_file_name1]);
						$data[file_name1]="data/$board_name/".$temp_ext."/".$data[s_file_name1];
						@chmod("./".$data[file_name1],0706);
						@chmod("./data/$board_name/".$temp_ext,0707);
					}
					// ���ε�� ������ ������� ó�� #2
					if($data[s_file_name2]) {
						$temp_ext=time();
						@mkdir("./data/$board_name/".$temp_ext,0777);
						@copy($data[file_name2] , "./data/$board_name/".$temp_ext."/".$data[s_file_name2]);
						$data[file_name2]="data/$board_name/".$temp_ext."/".$data[s_file_name2];
						@chmod("./".$data[file_name2],0706);
						@chmod("./data/$board_name/".$temp_ext,0707);
					}

					$data[name]=addslashes($data[name]);
					$data[subject]=addslashes($data[subject]);
					$data[memo]=addslashes($data[memo]);
					$sitelink1=addslashes($sitelink1);
					$sitelink2=addslashes($sitelink2);
					$email=addslashes($email);
					$homepage=addslashes($homepage);
					$division=add_division($board_name);
					$data[headnum]=$headnum;
					$data[division]=$division;
					$data[next_no]=$next_no;
					$data[prev_no]=0;
					$data[category]=$category;
					$data[father]=$data[father]+$term_father;
					$data[child]=$data[child]+$term_child;

					// �Խù� ������ ��� ���� ���
					if($notice_bbs) {
						$data[memo] .= "\n* $member[name]�Կ� ���ؼ� �Խù� ".$_kind."�Ǿ����ϴ� (".date("Y-m-d H:i").")";
					}

					mysql_query("insert into $t_board"."_$board_name (division,headnum,arrangenum,depth,prev_no,next_no,father,child,ismember,memo,ip,password,name,homepage,email,subject,use_html,reply_mail,category,is_secret,sitelink1,sitelink2,file_name1,file_name2,s_file_name1,s_file_name2,x,y,reg_date,islevel,hit,vote,download1,download2,total_comment) values ('$data[division]','$data[headnum]','$data[arrangenum]','$data[depth]','$data[prev_no]','$data[next_no]','$data[father]','$data[child]','$data[ismember]','$data[memo]','$data[ip]','$data[password]','$data[name]','$data[homepage]','$data[email]','$data[subject]','$data[use_html]','$data[reply_mail]','$data[category]','$data[is_secret]','$data[sitelink1]','$data[sitelink2]','$data[file_name1]','$data[file_name2]','$data[s_file_name1]','$data[s_file_name2]','$data[x]','$data[y]','$data[reg_date]','$data[islevel]','$data[hit]','$data[vote]','$data[download1]','$data[download2]','$data[total_comment]')") or error(mysql_error());

					$no=mysql_insert_id();
					if(!$father) {
						$root_no=$no;
						$father=$no;
						$term_father=$data[no]-$no;
					}

					// Comment ����
					$comment_result=mysql_query("select * from $t_comment"."_$id where parent='$data[no]' order by reg_date",$connect) or error(mysql_error());
					while($comment_data=mysql_fetch_array($comment_result)) {
						$comment_data[memo]=addslashes($comment_data[memo]);
						$comment_data[name]=addslashes($comment_data[name]);
						mysql_query("insert into $t_comment"."_$board_name (parent,ismember,name,password,memo,reg_date,ip) values ('$no','$comment_data[ismember]','$comment_data[name]','$comment_data[password]','$comment_data[memo]','$comment_data[reg_date]','$comment_data[ip]')") or error(mysql_error());
					}

					mysql_query("update $t_category"."_$board_name set num=num+1 where no='$category'",$connect);
				}
				$prev_data=mysql_fetch_array(mysql_query("select headnum from $t_board"."_$board_name where headnum>'$headnum' order by headnum limit 1"));
				mysql_query("update $t_board"."_$board_name set prev_no='$root_no' where headnum='$prev_data[0]'",$connect) or Error(mysql_error());


				// �޽��� ������ �κ�
				if($notice_user) {
					if($s_data[ismember]) {
						$_to = $s_data[ismember];
						$_from = $member[no];
						$_subject = stripslashes($s_data[name])." ���� �Խù��� ".$_kind."�Ǿ����ϴ�";
						$_memo = stripslashes($s_data[name])." �Բ��� ���� \"".stripslashes($s_data[subject])."\" ���� $member[name]�Կ� ���ؼ� ".$_kind." �Ǿ����ϴ�\n";
						$_memo .= " �Ű��� ��ġ : zboard.php?id=".$board_name."&no=".$no;
						_send_message($_to,$_from,$_subject,$_memo);
					}
				}
			}
		}
		$total=mysql_fetch_array(mysql_query("select count(*) from $t_board"."_$board_name",$connect));
		mysql_query("update $admin_table set total_article='$total[0]' where name='$board_name'");


		if($exec=="copy_all") {
			echo"<script> opener.window.history.go(0); window.close(); </script>";
		} elseif($exec=="move_all") {
			echo" <script> location.href='list_all.php?id=$id&exec=delete_all&selected=$select_list'; </script>";
			exit;
		}
	}

	//MySQL ���� /////////////////////////////////////
	if($connect) mysql_close($connect); $connect="";
?>