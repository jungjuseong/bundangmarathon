<?php

require("./bmauth.php");
require("./bmconfig.php");
require("./bmfunction.php");

top("");
if(privcheck($logid) != 2){
	heading("������ ���");
	die("�����ڸ� ��� ������ ����Դϴ�.");
}

if($mode == "menu"){
	echo "<a href='bmmem.php?mode=member-input'>ȸ�����</a>\n";
	echo "<p><a href='bmmem.php?mode=member-select'>ȸ����������</a>\n";
	echo "<p><a href='$PHP_SELF?mode=notify'>���� �˸� ������</a>\n";
//	echo "<p><a href='$PHP_SELF?mode=mailinglist-input'>Maillig-List ���� �߼�</a>\n";
//	echo "<p><a href='bmmailinglist.php'>Maillig-List �߰�/����</a>\n";
//	echo "<p><a href='/race/2002/prog/reg_admin2.php?mode=logon&uid=bundang0505'>��ȸ ���� ������ �޴�</a>\n";
	echo "<p><a href='bmmem.php?mode=photo-upload-set&type=manager'>�� ���� ���ε�</a>\n";
	echo "<p><a href='bmmem.php?mode=racephoto-upload-set&type=manager'>��ȸ ���� ���ε�</a>\n";
	echo "<p><a href='bmrec-in.php'>��� Batch ���(���κ�)</a>\n";
	echo "<p><a href='bmrec-in.php?mode=batch-input-race'>��� Batch ���(��ȸ��)</a>\n";
	echo "<p><a href='bmrecordinput.php'>��� File ���(��ȸ��)</a>\n";
	echo "<p><a href='$PHP_SELF?mode=file-upload-get'>���� ���ε�</a>\n";
	echo "<p><a href='$PHP_SELF?mode=hotnews-upload-get'>HotNews �׸� ���� ���ε�</a>\n";
	echo "<p><a href='bmclubtraining.php'>Ŭ���Ʒ����α׷��Է�</a>\n";
	echo "<p><a href='$PHP_SELF?mode=login_daytime'>ȸ���α��� �ð�</a>\n";
	echo "<p><a href='$PHP_SELF?mode=batchprocessing'>Batch ó��</a>\n";
	echo "<p><a href='$PHP_SELF?mode=poll_delete'>��ǥ�������</a>\n";
	echo "<p><a href='/_asalog/'>Ʈ���Ⱥм�</a>\n";
	if($member[user_id] == 'run4joy'){
		echo "<p><a href='$PHP_SELF?mode=execget'>��ɽ���/���ϴٿ�ε�</a>\n";
		echo "<p><form action='$PHP_SELF'><input type=hidden name=mode value=menu><input type=text name=url value=".base64_encode($url)."><input type=submit value='URL encoding'></form>\n";
		echo "<pre>\n";
		include("bmtodo.txt");
		echo "</pre>";
		echo urlencode(" % / ? ");
	}
}else if($mode == "login_daytime"){
		heading("ȸ���α��� �ð�");

		if(privcheck($logid) != 2){
			die("�����ڸ� ��� ������ ����Դϴ�.");
		}
		$dbquery="select name, user_id, login_daytime from  zetyx_member_table order by login_daytime desc, name";
		$result = mysql_query($dbquery) or die("mysql_query error");

		echo "<table><tr><th>�̸�<th>user_id<th>�ð�";
		while($row=mysql_fetch_array($result)){
			echo "<tr><td>$row[0]<td>$row[1]<td>$row[2]\n";
		}
		echo "</table>";
		mysql_free_result($result);
		mysql_close() or die("mysql_close error");
}else if($mode == "batchprocessing"){
	// �ӽÿ�
		heading("�ֹι�ȣ ��ȣȭ Batch ó��(�ѹ���)");

		if(privcheck($logid) != 2){
			die("�����ڸ� ��� ������ ����Դϴ�.");
		}
//		$dbquery="select name, juminno from member where juminno < '999999' order by name";
		$dbquery="select name, juminno, gumpuno, userid from member order by name";
		$result = mysql_query($dbquery) or die("mysql_query error");

		while($row=mysql_fetch_array($result)){
			$userid = $row[3];
//if($userid != 'run4joy') continue;

//	$gumpuno = '0';
//$gumpuno = $row[2];
//echo "$row[0] $gumpuno $row[1] $row[3]<br>";
			$str = jmchange(1, $row[1]);

	$dbquery = "update member set juminno='".$str."' where userid = '".$userid."'";
//echo "dbquery=$dbquery";
	$result2 = mysql_query($dbquery) or die("mysql_query error");

	if($result2=="1"){
	}else{
		echo "<font color=red>$row[0] ���� ����</font>";
	}

			$str = jmchange(2, $str);
if($str != $row[1]){
	echo "Mismatch YYY<br>";
}
		}
		mysql_free_result($result);
		mysql_close() or die("mysql_close error");
}else if($mode == "poll_delete"){
		heading("��ǥ�������");
	
		if(privcheck($logid) != 2){
			die("�����ڸ� ��� ������ ����Դϴ�.");
		}
	if($pollid != "" && $deleteuserid != ""){
		$dbquery="delete from poll where pollid='$pollid' and userid like '$deleteuserid%'";
		$result = mysql_query($dbquery) or die("mysql_query error");
		if($result=="1"){
			echo "'$pollid' '$deleteuserid' ".mysql_affected_rows()."�� ���� �Ϸ�";
		}else{
			echo "<font color=red>'$pollid' '$deleteuserid' ���� ����</font>";
		}
		mysql_close() or die("mysql_close error");
	}else{
			echo "�Ʒ� �� ĭ�� �Է��Ͻʽÿ�.";
	}

		echo "<p><form action='$PHP_SELF'><input type=hidden name=mode value='poll_delete'>pollid: <input type=text name='pollid' value='$pollid'><br>userid: <input type=text name='deleteuserid' value=''><br><input type=submit value='����'></form>\n";
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
		fwrite($fp, "From: \"�д縶�����ȸ ���\"<$managerEmail>\n");
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
		fwrite($fp, "From: \"Mailing-list �߼����α׷�\"<$managerEmail>\n");
		fwrite($fp, "To: \"������\"<$managerEmail>\n");
		fwrite($fp, "Subject: ���� �߼� �Ϸ�\n");
		fwrite($fp, "\n");
		fwrite($fp, "Mailing-list���� ���� �߼��� �Ϸ�Ǿ����ϴ�.");
		fwrite($fp, "\n");
		fclose($fp);

		$execret = exec("mail $managerEmail < $mailcont_file");
	chmod($mailcont_file, 0777);

	ob_end_flush();

	mysql_free_result($result);
	mysql_close() or die("mysql_close error");

	echo "<p align=center>ó�� �Ϸ�ƽ��ϴ�.";
	echo "������ '���� �߼� �Ϸ�'�� �� ������ ������ ��ٷ��� �����ڿ��� �߼۵��� ������ ~gumpu/html/member/prog/email/emailaccount-sended.dat ������ Ȯ���� �߰� �߼��Ͻʽÿ�.\n";

}else {
	top("");
    ////
if($mode == "execget"){
		heading("��� ����");
		if(privcheck($logid) != 2){
			echo "�����ڸ� ��� ������ ����Դϴ�.";
		}else{
			echo "
<form action='$PHP_SELF' method=post>
<input type=hidden name=mode value=execset>
<table>
<tr>
  <td>���</td>
  <td><input type=input name=command size=40 maxlength=80 value=''></td>
<td rowspan=2><input type=submit value='����'>[download filename]</td>
</tr>
</table>
		</form>
		";
		}
}else if($mode == "execset"){
		heading("��� ����");
		if(privcheck($logid) == 2){
		    if(strpos($command, "rm ") >= 1){
			echo "rm ��� ���� �Ұ�";
		    }else{
			    if(($pos = strpos($command, ":")) != 0){	// 
				echo "����� �ݵ�� :�� �����ؾ� ��";
			    }else{
				    $command = substr($command, $pos+1);
				    if(substr($command, 0, 8)=="download"){
					echo "<a href='".substr($command, 9)."'>".substr($command, 9)."</a>";
				    }else{
					    echo "<pre>";
					    passthru($command);
					    echo "</pre><br><br>$command ����Ϸ�";
				    }
			    }
		    }
	    }
	    
}else if($mode == "file-upload-get"){
	heading("���� ���ε�");

	if(privcheck($logid) == 2){
		echo "
<FORM ENCTYPE='multipart/form-data' ACTION='$PHP_SELF' METHOD=POST>
<INPUT TYPE='hidden' name='MAX_FILE_SIZE' value='10000000'>
<INPUT TYPE='hidden' name='mode' value='file-upload-set'>
���� ����: <INPUT NAME='userfile' TYPE='file'><br><br>
���丮: <INPUT NAME='directory' TYPE='input'>(default : /bbs/upload)<br><br>";
		echo "<INPUT TYPE='submit' VALUE='���� ���ε� �ϱ�'>
</FORM>
* 10M���� ���ε� ����; \"'\"�� ������ �̸� ���� �ȵ�";
	}
}else if($mode == "file-upload-set"){
	heading("���� ���ε�");

	if($userfile_size>(1024*1024*10)){
		echo "������ �ʹ� Ů�ϴ�.";
		exit;
	}
	if(privcheck($logid) == 2){
		if($directory==""){
			$dir = "upload/";
		}else if(substr($directory, 0, 1) == "/"){
			$dir = $home.$directory;
		}else{
			$dir = $directory;
		}
		if(substr($dir, strlen($dir)-1, 1) != "/"){
			$dir .= "/";
		}
//echo "userfile=$userfile photofile=$photofile dir=$dir";
//		$file = basename ($userfile);
		$file = $userfile_name;
		if(!move_uploaded_file($userfile, "$dir$file")){
			echo "move_uploaded_file() error\n";
		}else{
			chmod("$dir$file", 0777);
			echo "����($userfile_name -> $dir$file) ���ε� �Ϸ�";
		}
	}
}else if($mode == "hotnews-upload-get"){
	heading("HotNews �׸� ���� ���ε�");

	if(privcheck($logid) == 2){
		echo "
<FORM ENCTYPE='multipart/form-data' ACTION='$PHP_SELF' METHOD=POST>
<INPUT TYPE='hidden' name='MAX_FILE_SIZE' value='1000000'>
<INPUT TYPE='hidden' name='mode' value='hotnews-upload-set'>
���� ����: <INPUT NAME='userfile' TYPE='file'><br>
�Խù� ��ȣ:<input type=input name=bbsno size=6 maxlength=10><br>
(HotNews �Խ����� �Խù� ��ȣ)<br><br>";
		echo "<INPUT TYPE='submit' VALUE='���ε�'>
</FORM>";
	}
}else if($mode == "hotnews-upload-set"){
	heading("HotNews �׸� ���� ���ε�");

	if($userfile_size>(1024*1024*1)){
		echo "������ �ʹ� Ů�ϴ�.";
		exit;
	}
	if(privcheck($logid) == 2){
//echo "userfile=$userfile photofile=$photofile ";
//		$file = basename ($userfile);
		$file = $userfile_name;
		$filebase = basename($file);
		$fileextpos = strpos($filebase, ".");
//echo "filebase=$filebase fileextpos=$fileextpos ";
		if ($fileextpos === false) {
			echo "���� Ȯ���ڰ� �����ϴ�.";
			exit;
		}
		$fileext = substr($filebase, $fileextpos+1);
		$file = $bbsno.".".$fileext;

		if(!move_uploaded_file($userfile, "hotnews/$file")){
			echo "move_uploaded_file() error\n";
		}else{
			chmod("hotnews/$file", 0777);
			if(is_file("hotnews/hotnews.txt") == TRUE)
				unlink("hotnews/hotnews.txt");
			if(($fp = fopen("hotnews/hotnews.txt", "w")) == FALSE){
				echo "hotnews/hotnews.txt file�� �� �� �����ϴ�.";
				echo "HotNews ����($userfile_name -> hotnews/$file) ���ε� ����!!!";
				exit;
			}
			fwrite($fp, "$file\n$bbsno\n");
			fclose($fp);
			echo "HotNews ����($userfile_name -> hotnews/$file) ���ε� �Ϸ�";
		}
	}

}else if($mode == "member-input"){
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
//		$dbquery="select userid, passwd, name, nickname, sex, juminno, org, orghref, email, postno, postaddr, photo, telhome, teloffice, telhand, size, membertype, grade, disporder, gumpuno, etc, hanmirid, hanmirpwd, boston from member where userid='$userid'";
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
	$query_value.="'". jmchange(1, $juminno) ."',";

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
	$result = mysql_query($dbquery);

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

	$dbquery.="name='".$name."',nickname='".$nickname."',sex='".$sex."',juminno='". jmchange(1, $juminno) .
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
}else if($mode == "notify"){
		heading("���� �˸� ������");

		if(privcheck($logid) != 2){
			die("�����ڸ� ��� ������ ����Դϴ�.");
		}
		echo "<p align=center>* �α����ϸ� Ȩ������ ������ ������ ���� <br>�˸� ������ ��Ÿ���ϴ�.<br>�ѹ��� ��Ÿ���� �ٷ� �����˴ϴ�.";
		$dbquery="select userid, name, nickname, sex, membertype from member order by name";
		$result = mysql_query($dbquery) or die("mysql_query error");

		echo "<form name=pollform method=post action='$PHP_SELF'>\n";
		echo "<input type=hidden name='mode' value='notify-exec'>\n";
		echo "<table><tr><td>����� ���� : <br>(CtrlŰ ����<br>���߼���)<td><select MULTIPLE name='userid[]' size='10'  style='background-color: white; color: blue; font:10pt'>\n";

		while($row=mysql_fetch_array($result)){
			echo "<option value='$row[0]'>$row[1]($row[2]):$row[membertype]</option>\n";
		}
		echo "</select>";
		echo "<tr><td align=right>�޽��� : <br>(����40�ڱ���)<td><input type=text name='notifymsg' size=40 maxlength=40>\n";
		echo "<tr><td colspan=2 align=center><input type=submit value='������'>";
		echo "</form>";
		mysql_free_result($result);
		mysql_close() or die("mysql_close error");
}else if($mode == "notify-exec"){
		heading("���� �˸� ������ ó��");

		if(privcheck($logid) != 2){
			die("�����ڸ� ��� ������ ����Դϴ�.");
		}
		$cnt = count($userid);
		echo $cnt."��<br>";
		for($i = 0; $i < $cnt; $i++){
			echo $userid[$i]." ";
			$dbquery="insert into etc (type, userid, msgstr) values('notify', '$userid[$i]', '$notifymsg')";
			$result = mysql_query($dbquery);
		}
		echo "<br><br>���� �˸� ������ ó�� �Ϸ�";

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
<title>�д縶����Ŭ��</title>
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
