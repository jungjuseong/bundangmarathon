<?php

require("./auth.php");
require("./config.php");
require("./function.php");

top("");
if(privcheck($logid) != 2){
	heading("������ ���");
	die("�����ڸ� ��� ������ ����Դϴ�.");
}

if($mode == "menu"){
	echo "<a href='mem.php?mode=member-input'>ȸ�����</a>\n";
	echo "<p><a href='mem.php?mode=member-select'>ȸ����������</a>\n";
	echo "<p><a href='$PHP_SELF?mode=mailinglist-input'>Maillig-List ���� �߼�</a>\n";
	echo "<p><a href='mailinglist.php'>Maillig-List �߰�/����</a>\n";
	echo "<p><a href='/race/2002/prog/reg_admin2.php?mode=logon&uid=bundang0505'>��ȸ ���� ������ �޴�</a>\n";
	echo "<p><a href='mem.php?mode=photo-upload-set&type=manager'>�� ���� ���ε�</a>\n";
	echo "<p><a href='rec-in.php'>��� Batch ���(���κ�)</a>\n";
	echo "<p><a href='recordinput.php'>��� Batch ���(��ȸ��)</a>\n";
	echo "<p><a href='training.php'>����������(������)</a>\n";
}else if($mode == "mailinglist-input"){
	emailcont();
}else if($mode == "mailinglist-send"){

	heading("Mailing-List ���� �߼�");

	ob_start();

	if($subject == "" || $cont == ""){
		echo "����� ������ �Է��� �ֽʽÿ�";
		die("");
	}

	$dbquery="select name,email from mailinglist ";
	if($emailaccount != '') 
		$dbquery .= "where email > '$emailaccount' ";
	$dbquery .= "order by email";
	$dbquery="select name,email from mailinglist order by email";
//	$dbquery="select bibno,name,email,juminno,org,record,postno,postaddr from reg2001 where email!='' and record is not null order by bibno";
//	$dbquery="select bibno, name, email, juminno, org,record ,postno,postaddr from reg2001 where name='�迵��' and record is not null order by bibno";

	$result = mysql_query($dbquery) or die("mysql_query error");

	$mailcont_file = "./email/emailcont.dat";
	$mailaccount_file = "./email/emailaccount-sended.dat";
	$fpsended = fopen($mailaccount_file, "w");
	$no=0;
	while($row=mysql_fetch_array($result)){
//		if($row[0] == "������")
//			continue;
		$fp = fopen($mailcont_file, "w");
		fwrite($fp, "From: \"�д縶�����ȸ ���\"<gumpu@gumpu.pe.kr>\n");
		fwrite($fp, "To: \"$row[0]�� ����\"<$row[1]>\n");
		fwrite($fp, "Subject: $subject\n");
		fwrite($fp, "\n");
		if($greetingmsg!=""){
			fwrite($fp, $row[0]."��, ".$greetingmsg."\n");
			fwrite($fp, "\n");
		}

		fwrite($fp, $cont);
		fwrite($fp, "\n");
		fclose($fp);

		$execret = exec("mail ".$row[1]."  < $mailcont_file");

		$no++;
		echo $no." ";
		if(($no % 10) == 0){
			echo "\n";
		}
//sleep(60);
		if(($no % 100) == 0){
			ob_end_flush();
//			sleep(5);
			ob_start();
		}
		fwrite($fpsended, "$row[1] $row[0]\n");
		fflush($fpsended);
	}
	fclose($fpsended);

		$fp = fopen($mailcont_file, "w");
		fwrite($fp, "From: \"Mailing-list �߼����α׷�\"<gumpu@gumpu.pe.kr>\n");
		fwrite($fp, "To: \"��Ǫ������\"<gumpu@gumpu.pe.kr>\n");
		fwrite($fp, "Subject: ���� �߼� �Ϸ�\n");
		fwrite($fp, "\n");
		fwrite($fp, "Mailing-list���� ���� �߼��� �Ϸ�Ǿ����ϴ�.");
		fwrite($fp, "\n");
		fclose($fp);

		$execret = exec("mail gumpu@gumpu.pe.kr < $mailcont_file");
	chmod($mailcont_file, 0777);

	ob_end_flush();

	mysql_free_result($result);
	mysql_close() or die("mysql_close error");

	echo "<p align=center>ó�� �Ϸ�ƽ��ϴ�.";
	echo "������ '���� �߼� �Ϸ�'�� �� ������ ������ ��ٷ��� ��Ǫ�����ڿ��� �߼۵��� ������ ~gumpu/html/member/prog/email/emailaccount-sended.dat ������ Ȯ���� �߰� �߼��Ͻʽÿ�.\n";

}else {
	top("");
    ////
    if($mode == "member-input"){
	heading("ȸ�� ���� ���");
	if(privcheck($logid) != 2){
		echo "�����ڸ� ��� ������ ����Դϴ�.";
	}else{
		member_display("member-insert","","","","","","","","","","","","","","","","","","","","","","","","");
	}
    }else if($mode == "member-select"){
	heading("ȸ�� ���� ����");

	if(privcheck($logid) != 2){
		die("�����ڸ� ��� ������ ����Դϴ�.");
	}
	$dbquery="select userid, name, nickname, sex from member order by name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	echo "<form name=pollform method=post action='$PHP_SELF'>\n";
	echo "<input type=hidden name='mode' value='member-change'>\n";
	echo "<select name='userid' size='1'  style='background-color: white; color: blue; font:10pt'>\n";

	while($row=mysql_fetch_array($result)){
		echo "<option value='$row[0]'>$row[1]($row[2])</option>\n";
	}
	echo "</select>";
	echo "<p><input type=submit value='����'>";
	echo "</form>";
	mysql_free_result($result);
	mysql_close() or die("mysql_close error");
    }else if($mode == "member-change"){
	heading("ȸ�� ���� ����");

	if($userid == "")
		$userid = $logid;
//	$dbquery="select userid, passwd, name, nickname, sex, juminno, org, orghref, email, postno, postaddr, photo, telhome, teloffice, telhand, size, membertype, grade, disporder, gumpuno, etc, hanmirid, hanmirpwd, boston from member where userid='$userid'";
	$dbquery="select userid, passwd, name, nickname, sex, juminno, org, orghref, email, postno, postaddr, photo, telhome, teloffice, telhand, size, membertype, grade, disporder, gumpuno, etc, boston from member where userid='$userid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	if($row=mysql_fetch_array($result)){
		member_display("member-update",  $row[0], $row[1], $row[2], $row[3], $row[4], $row[5],
		 $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $row[12],
		 $row[13], $row[14], $row[15], $row[16], $row[17], $row[18], $row[19], $row[20], $row[21], $row[22], $row[23]);
	}else{
		echo "<tr><td>'$name' ȸ���� ã�� ���� �����ϴ�.</td></tr>";
	}
	mysql_free_result($result);
	mysql_close() or die("mysql_close error");
    }else if($mode == "member-insert"){
	heading("ȸ�� ���� ���");

	if($userid == ""){
		echo "userid�� �Է� �ٶ��ϴ�.<br><br>";
		echo "<a href='javascript:history.back();'>�ڷ�</a>";
		die("");
	}
	$dbquery="select userid, name from member where userid='$userid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$rows = mysql_num_rows($result);
	if($rows == 1){
		$row=mysql_fetch_array($result);
		echo "ID�� �ٸ� ȸ��($row[1])�� �ߺ��Դϴ�.<br><br>";
		echo "<a href='javascript:history.back();'>�ڷ�</a>";
		die("");
	}
	$dbquery="select userid, name from member where photo='$photo'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$rows = mysql_num_rows($result);
	if($rows == 1){
		$row=mysql_fetch_array($result);
		echo "���� ���ϸ��� �ٸ� ȸ��($row[1])�� �ߺ��Դϴ�.<br><br>";
		echo "<a href='javascript:history.back();'>�ڷ�</a>";
		die("");
	}

	$query_name="";
	$query_value="";

	$query_name.="userid,";
	$query_value.="'".$userid."',";

	$query_name.="passwd,";
	$query_value.="'".$passwd."',";

	$query_name.="name,";
	$query_value.="'".$name."',";
	$query_name.="nickname,";
	$query_value.="'".$nickname."',";

	$query_name.="sex,";
	$query_value.="'".$sex."',";

	$query_name.="juminno,";
	$query_value.="'".$juminno."',";

	$query_name.="org,";
	$query_value.="'".$org."',";
	$query_name.="orghref,";
	$query_value.="'".$orghref."',";

	$query_name.="email,";
	$query_value.="'".$email."',";

	$query_name.="postno,";
	$query_value.="'".$postno."',";

	$query_name.="postaddr,";
	$query_value.="'".$postaddr."',";

	$query_name.="photo,";
	$query_value.="'".$photo."',";

	if($telhome!=""){
		$query_name.="telhome,";
		$query_value.="'".$telhome."',";
	}

	if($teloffice!=""){
		$query_name.="teloffice,";
		$query_value.="'".$teloffice."',";
	}

	if($telhand!=""){
		$query_name.="telhand,";
		$query_value.="'".$telhand."',";
	}

	$query_name.="size,";
	$query_value.="'".$size."',";
	$query_name.="membertype,";
	$query_value.="'".$membertype."',";

	$query_name.="grade,";
	$query_value.="'".$grade."',";

	if($disporder == "")
		$disporder = "99";
	$query_name.="disporder,";
	$query_value.="'".$disporder."',";

	if($gumpuno != ""){
		$query_name.="gumpuno,";
		$query_value.=$gumpuno.",";
	}

	$query_name.="etc,";
	$query_value.="'".$etc."',";

	$query_name.="boston";
	$query_value.="'".$boston."'";

	$dbquery="insert into member ($query_name) values($query_value)";
//echo "qbquery=$dbquery";
	$result = mysql_db_query("gumpu",$dbquery);

	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "��� �����Դϴ�.<br>";
		echo "<a href='javascript:history.back();'>�ڷ�</a>";
		die("");
	}else{
		echo "��� ó�� �Ϸ�.<br>";
	}

    }else if($mode == "member-delete"){
	heading("ȸ�� ���� ����");
	if(privcheck($logid) != 2)
		$userid = '';
	$dbquery="delete from member where userid = '".$userid."'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$dbquery="delete from record where userid = '".$userid."'";
	$result = mysql_query($dbquery) or die("mysql_query error");

	if($result=="1"){
		echo "$name ���� �Ϸ�";
	}else{
		echo "<font color=red>$name ���� ����</font>";
	}
    }else if($mode == "member-update"){
	heading("ȸ�� ���� ���� �Ϸ�");

	if($photo != $photoorg){
		$dbquery2="select userid, name from member where photo='$photo' and userid != '$userid'";
		$result2 = mysql_query($dbquery2) or die("mysql_query error");
		$rows = mysql_num_rows($result2);
		if($rows >= 1){
			$row=mysql_fetch_array($result2);
			echo "���� ���ϸ��� �ٸ� ȸ��($row[1])�� �ߺ��Դϴ�.<br><br>";
			echo "<a href='javascript:history.back();'>�ڷ�</a>";
			die("");
		}
	}

	$dbquery="update member set ";
	if($passwd != ""){
		$dbquery.="passwd='".$passwd."',";
	}

	$dbquery.="name='".$name."',nickname='".$nickname."',sex='".$sex."',juminno='".$juminno.
		"',org='".$org."',orghref='".$orghref."',email='".$email."',postno='".$postno.
		"',postaddr='".$postaddr."',telhome='".$telhome.
		"',teloffice='".$teloffice."',telhand='".$telhand.
//		"',hanmirid='".$hanmirid."',hanmirpwd='".$hanmirpwd.
		"',size='".$size."',etc='".$etc."'";
	if(privcheck($logid) == 2){
		$dbquery.=",membertype='".$membertype."',photo='".$photo."',boston='".$boston.
			"',grade='".$grade."',disporder='".$disporder.  "'";
		if($gumpuno != "")
			$dbquery.=",gumpuno=".$gumpuno;
	}
	$dbquery.=" where userid = '".$userid."'";
//echo "dbquery=$dbquery";
	$result = mysql_query($dbquery) or die("mysql_query error");

	if($result=="1"){
		echo "$name ���� �Ϸ�";
	}else{
		echo "<font color=red>$name ���� ����</font>";
	}
    }else if($mode == "idpasswd-change"){
	heading("��ȣ ���� ����");
	echo "
		<form action='$PHP_SELF' method=post>
		<input type=hidden name=mode value=idpasswd-update>
<table>
<tr>
  <td>���ο� ��ȣ</td>
  <td><input type=password name=passwd size=12></td>
<td rowspan=2><input type=submit value='����'></td>
</tr>
<tr>
  <td>�ѹ��� �Է�</td>
  <td><input type=password name=passwd2 size=12></td>
</tr>
</table>
		</form>
		";
    }else if($mode == "idpasswd-update"){
	if($passwd == "" || $passwd != $passwd2){
		heading("��ȣ ���� ���� ����");
		die("�Է��� ��ȣ�� �̻��մϴ�.");
	}
	heading("��ȣ ���� ����");
	$dbquery="update member set passwd='".$passwd."' where userid = '".$userid."'";
	$result = mysql_query($dbquery) or die("mysql_query error");

	if($result=="1"){
		echo "��ȣ ���� �Ϸ�";
	}else{
		echo "<font color=red>��ȣ ���� ����</font>";
	}
    }else if($mode == "menu-admin"){
	heading("������ �޴�");
	menu_admin();
    }else if($mode == "menu-self"){
	heading("���� ����");
    }else if($mode == "menu-race"){
	heading("��ȸ ����");
    }else if($mode == "menu-inviting"){
	heading("��ȸ ����");
    }else if($mode == "menu-record"){
	heading("��� ����");
    }else if($mode == "menu-etc"){
	heading("��Ÿ");
    }else if($mode == "submenu"){
	heading("�޴� ���� ����");
	echo "���� �޴��� �����Ͻʽÿ�.";
    }else if($mode == "frame"){
	echo "
<html>
<head>
<title>�д� źõ��Ǫ ������Ŭ��</title>
</head>

<frameset rows='59, 1*' border='0' frameborder='NO' framespacing='0'>
    <frame src='logon.php?mode=framemenu' name='framemenu' noresize scrolling='no' marginwidth='0'
    <frame src='logon.php?mode=framecont' name='framecont' noresize scrolling='auto' marginwidth='10' marginheight='0' scrollbar='no' frameborder='NO'>
</frameset>
<noframes>
  <body bgcolor='white' text='black' link='blue' vlink='purple' alink='red'>
    <p>�� �������� ������, �������� �� �� �ִ� �������� �ʿ��մϴ�.</p>
  </body>
</noframes>
</html>";

    }else if($mode == "menu-framemenu"){
    }else if($mode == "menu-framecont"){
	heading("ȸ������ ����");
	connectstatus($logid);
	echo "D-day ǥ�� �κ�<p>";
	echo "���� ǥ�� �κ�<p>";
    }else{
	heading("�ش� ����� �����ϴ�.");
	exit;
    }
}

function emailcont(){
	global $PHP_SELF;

	heading("Mailing-List ���� �ۼ�");
	echo "
<form method=post action=$PHP_SELF>
<input type=hidden name=mode value='mailinglist-send'>
<table border=1>
<tr><td>���ϰ���</td>
<td><input type=text name=mailaccount size=20 maxlength=30>�߰��߼۽� ���� ���� �߼��ּ��Է�(�űԹ߼۽� ��ĭ)</td>
<tr>
<td align=center>����</td>
<td><input type=text name=subject size=40 maxlength=60></td>
</tr><tr>
<td align=center>�λ縻</td>
<td><input type=text name=greetingmsg size=40 maxlength=60><br>�λ縻 �տ� \"XXX��, \"�� �ڵ����� �߰��˴ϴ�.</td>
</tr><tr>
<td align=center>���� ����</td>
<td><textarea wrap=auto name='cont' rows=12 cols=60></textarea></td>
</tr>
<tr>
<td colspan=2 align=center>
<input type=submit value='���� ������'>
</td>
</tr>
</table>
</center>";
}

?>
</center>
</body>
</html>
