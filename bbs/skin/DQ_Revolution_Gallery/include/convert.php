<?
	set_time_limit(0);

	echo "
	<br><font size=3><b>&nbsp;�Խù� �� ����:</b> $board_setup[total_article]��</font>
	<br><font size=3><b>&nbsp;�Խ��� ID:</b> $id</font><br><br>
	<font size=2><b>&nbsp;��õ ������ ��ȯ����</b></font><br><br>\n";

	$result = mysql_query("SELECT * FROM zetyx_board_$id ORDER BY no ASC");
	$del_comment = 0;
	while($dbData[$i]=@mysql_fetch_array($result)){

		$s_data=$dbData[$i];

		//������ ����� ����Ÿ�� �������;;
		$view_comment_result=mysql_query("select * from zetyx_board_comment"."_$id where parent='$s_data[no]' order by no asc");
		
		$vote_users = "";
		while($c_data=mysql_fetch_array($view_comment_result)) {
			if($c_data[vote]) $vote_users .= "<".$c_data[ismember].">".stripslashes($c_data[name]);
			if(trim($c_data[memo])=="") {
				//�ڸ�Ʈ ����
				mysql_query("delete from zetyx_board_comment"."_$id where no='$c_data[no]'") or error(mysql_error());
				//�ڸ�Ʈ ���� ����
				$total=mysql_fetch_array(mysql_query("select count(*) from zetyx_board_comment"."_$id where parent='$s_data[no]'"));
				mysql_query("update $t_board"."_$id set total_comment='$total[0]' where no='$s_data[no]'")  or error(mysql_error()); 

				$del_comment++;
			}
		}

		echo "&nbsp;<b>$s_data[no]</b>";

		$m_data=mysql_fetch_array(mysql_query("select * from dq_revolution where zb_id='$id' and zb_no='$s_data[no]'"));

		if($vote_users) {			
			if($m_data[no])	{
				if(strlen($vote_users) >= strlen($m_data[vote_users])) {
					@mysql_query("update dq_revolution set vote_users='$vote_users' where zb_id='$id' and zb_no='$s_data[no]'") or error(mysql_error());
					echo "(����)";
				} else echo "(�н�)";
			} else {
				@mysql_query("insert into dq_revolution (zb_id,zb_no,vote_users) values ('$id','$s_data[no]','$vote_users')") or error(mysql_error());
				echo "(�Է�)";
			}
		} else echo "(�н�)";

		echo ".";
		$count++; 
		if($count>=10) {echo "<br>"; $count=0;}
		flush();
	}

?>
<br><br>
<font size=2><b>&nbsp;��õ ������ ��ȯ�Ϸ�</b> / ������ �ڸ�Ʈ ����: <?=$del_comment?>��</font><br><br>

<?
	if(@mysql_field_name(mysql_query("SELECT file_names3 from zetyx_board"."_$id"),0)) {
		$more_upload = '1';
		$more_limit = 20;
	}
	
	echo "<br><br><br><font size=2><b>&nbsp;���ε� ������ ��ȯ����</b></font><br><br>";

	$result = mysql_query("SELECT * FROM zetyx_board_$id ORDER BY no ASC");

	while($dbData[$i]=@mysql_fetch_array($result)){
		$que="";		
		$s_data=$dbData[$i];
		if(eregi("data",$s_data[file_names])) $que="file_names='$s_data[file_names]',s_file_names='$s_data[s_file_names]'";
		
		echo "&nbsp;<b>$s_data[no]</b>";

		$m_data=mysql_fetch_array(mysql_query("select * from dq_revolution where zb_id='$id' and zb_no='$s_data[no]'"));

		if($que) {			
			if($m_data[no])	{
				if(strlen($s_data[s_file_names]) >= strlen($m_data[s_file_names])) {
					@mysql_query("update dq_revolution set $que where zb_id='$id' and zb_no='$s_data[no]'") or error(mysql_error());
					echo "(����)";
				} else echo "(�н�)";
			} else {
				@mysql_query("insert into dq_revolution (zb_id,zb_no,file_names,s_file_names) values ('$id','$s_data[no]','$s_data[file_names]','$s_data[s_file_names]')") or error(mysql_error());
				echo "(�Է�)";
			}
		} else echo "(�н�)";

		echo ".";
		$count++; 
		if($count>=10) {echo "<br>"; $count=0;}
		flush();
	}
?>

<br><br>
<font size=2><b>&nbsp;�Խù� ��ȯ�Ϸ�</b></font><br><br>

<div align=center><font size=2><b>&nbsp;<a href=<?=$PHP_SELF?>?id=<?=$id?>&mode=modify>[ȯ�漳������ ���ư���]</a></b></font></center><br>
