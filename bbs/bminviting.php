<?php

require("./bmauth.php");
require("./bmconfig.php");
require("./bmfunction.php");

top("");

if($mode == "inviting-all"){

	if(privcheck($logid) == 0 || $userid == ""){
		$userid = $logid;
	}
	$dbquery="select raceid, item, size, transport, fellows, groupyn from record where userid='$userid' and raceid=$raceid";
	$result = mysql_query($dbquery) or die("mysql_query error");
	if(mysql_num_rows($result) == 1){
		$mode = "inviting-change2";
	}else{
		$mode = "inviting-input2";
	}
	mysql_free_result($result);
}

if($mode == "inviting-input2"){
	heading("��ȸ ���� ��û");
	race_disp($raceid);
	echo "<p>";
	$dbquery2 = "select userid from record where raceid=$raceid and userid='$logid'";
	$result2 = mysql_query($dbquery2) or die("mysql_query error");
	$row2 = mysql_fetch_array($result2);
	mysql_free_result($result2);
	if($row2){
		echo "<font color='red'>�̹� ��û�ϼ̽��ϴ�.</font>";
	}else{
		inviting_display("inviting-insert",$raceid,"","","","", $logid,"");
	}
	if(privcheck($logid) == 2){
		echo "<p><font size='+2'>�����ڿ� ȸ�� ���� ��û</font><p>\n";
		inviting_display("inviting-insert",$raceid,"","","","", "","");
	}
}else if($mode == "inviting-input"){
	heading("��ȸ ���� ��û");

	$dbquery="select juminno from member where userid = '$logid'";
	$result2 = mysql_query($dbquery) or die("mysql_query error");
	$row=mysql_fetch_array($result2);
	if(!is_numeric(substr($row[0],0,6))){
		echo "<a href=\"bmmem.php?mode=member-change&userid=$logid\">�ֹε�Ϲ�ȣ�� �̻��մϴ�.<br>���� ���⿡�� ���� ������ �Է��Ͻʽÿ�.</a>";
		die("");
	}

	echo "��ü ���� ��û�� �ƴϴ��� ���� ��û�Ͻ� �е��� �Է� �ٶ��ϴ�.<p>\n";
	$dbquery="select raceid, name, nickname, userid from race where raceday >= replace(substring(now(),1,10),'-','/') and inviting='Y' order by raceday";
	$result = mysql_query($dbquery) or die("mysql_query error");
	while($row=mysql_fetch_array($result)){
		if(privcheck($logid) != 2){
			$dbquery2 = "select userid from record where raceid=$row[0] and userid='$logid'";
			$result2 = mysql_query($dbquery2) or die("mysql_query error 2");
			$row2 = mysql_fetch_array($result2);
			mysql_free_result($result2);
			if($row2){
				continue;
			}
		}
		echo "<a href='$PHP_SELF?mode=inviting-input2";
		if($row[3] == $logid)
			echo "&maker=Y";
		echo "&raceid=$row[0]'>$row[2] : $row[1]</a><p>\n";
	}
}else if($mode == "inviting-insert"){
	heading("��ȸ ���� ��û");

	if($item == "etc"){
		if($itemetc == ""){
			die("������ �Է��Ͻʽÿ�.<p><a href='javascript:history.back()'>
�ڷ�</a>");
		}
		$item = $itemetc;
	}else if($item == ""){
		die("������ �Է��Ͻʽÿ�.<p><a href='javascript:history.back()'>�ڷ�</a>");
	}
	$query_name="";
	$query_value="";

	$strs = explode(":", $raceid);
	$raceid = $strs[0];
	$nickname = $strs[1];

	$query_name.="raceid,";
	$query_value.=$raceid.",";

	$query_name.="nickname,";
	$query_value.="'".$nickname."',";

	$query_name.="item,";
	$query_value.="'".$item."',";
	$query_name.="size,";
	$query_value.="'".$size."',";

	$query_name.="transport,";
	$query_value.="'".$transport."',";

	$query_name.="groupyn,";
	$query_value.="'".$groupyn."',";

	$query_name.="userid,";
	$query_value.="'".$userid."',";

	$date = getdate();
	$yyyymmdd = $date['year']."-".$date['mon']."-".$date['mday'];
	$query_name.="makedate";
	$query_value.="'".$yyyymmdd."'";

	$dbquery="insert into record ($query_name) values($query_value)";

	$result = mysql_query($dbquery);
//echo "dbquery=".$dbquery . " result=". $result;

	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "<font color=red>�̹� ���� ��û�Ͻ� ��ȸ�Դϴ�.</font><br>";
		echo "Ȯ�� �ٶ��ϴ�.";
		die("");
	}else{
		echo "���� ��û ��� ó�� �Ϸ�.<br>";
	}
}else if($mode == "inviting-change"){
	heading("���� ��û ���� ����");
	$userid = $logid;
	$dbquery="select raceid from race where inviting='Y' and raceday >= replace(substring(now(),1,10),'-','/') order by raceday";
	$result = mysql_query($dbquery) or die("mysql_query error");
	for($raceids = ""; $row=mysql_fetch_array($result); $raceids.=$row[0]){
		if($raceids != "")
			$raceids.=",";
	}
	mysql_free_result($result);
	if($raceids == ""){
		echo "<font color=red>��ȸ�� ã�� ���� �����ϴ�.</font>";
	}else{
		$dbquery="select raceid, record.nickname, member.name, record.userid from member, record where record.raceid in ($raceids)";
		if(privcheck($userid) != 2){	// not admin
			$dbquery.=" and record.userid='$userid'";
		}
		$dbquery.= " and record.userid=member.userid order by record.nickname, member.name";
		$result2 = mysql_query($dbquery) or die("mysql_query error");
		while($row=mysql_fetch_array($result2)){
			echo "<br><a href='$PHP_SELF?mode=inviting-change2&userid=$row[3]&raceid=$row[0]'>$row[2] : $row[1]</a>";
		}
		mysql_free_result($result2);
	}
	mysql_close() or die("mysql_close error");

}else if($mode == "inviting-change2"){
	heading("���� ���� ��û ���� ����");

	if(privcheck($logid) != 2 || $userid == ""){
		$userid = $logid;
	}
	$dbquery="select raceid, item, size, transport, fellows, groupyn from record where userid='$userid' and raceid=$raceid";
	$result = mysql_query($dbquery) or die("mysql_query error");
	if($row=mysql_fetch_array($result)){
		inviting_display("inviting-update",  $row[0], $row[1], $row[2],
		 $row[3], $row[4], $userid, $row[groupyn]);
	}else{
		echo "<tr><td><font color=red>'$name' ��ȸ ��û������ ã�� ���� �����ϴ�.</font></td></tr>";
	}
	mysql_free_result($result);
	mysql_close() or die("mysql_close error");

}else if($mode == "inviting-delete"){
	heading("���� ��û ���� ����");
	if(privcheck($userid) == 1)
		$userid = $logid;
	$dbquery="delete from record where userid='$userid' and raceid=$raceid";
	$result = mysql_query($dbquery) or die("mysql_query error");

	if($result=="1"){
		echo "������û ���� �Ϸ�";
	}else{
		echo "<font color=red>������û ���� ����</font>";
	}
}else if($mode == "inviting-update"){
	heading("���� ��û ���� ���� �Ϸ�");
	if($item == "etc")
		$item = $itemetc;
	$dbquery="update record set item='".$item."'"
		.",size='".$size."'"
		.",transport='".$transport."'"
		.",fellows='".$fellows."'"
		.",groupyn='".$groupyn."'";
	$dbquery.=" where userid='$userid' and raceid=".$raceid;
//echo "dbquery=".$dbquery;
	$result = mysql_query($dbquery) or die("mysql_query error");

	if($result=="1"){
		echo "���� �Ϸ�";
	}else{
		echo "<font color=red>���� ����</font>";
	}
}else if($mode == "inviting-list"){
	heading("��ȸ ���� ��û�� ���");

	$dbquery="select raceid, name, nickname, userid from race where raceday >= replace(substring(now(),1,10),'-','/') order by raceday";
	$result = mysql_query($dbquery) or die("mysql_query error");
	while($row=mysql_fetch_array($result)){
		echo "<a href='$PHP_SELF?mode=inviting-list2";
		if($row[3] == $logid)
			echo "&maker=Y";
		echo "&raceid=$row[0]&racenickname=".urlencode($row[2])."'>$row[2] : $row[1]</a><p>\n";
	}
	echo "<p>
<form name=form1 method=post action='$PHP_SELF'>
<input type=hidden name='mode' value='inviting-list2'>
<input type=hidden name='raceid'>
<input type=text name=racename size=50 value='�Ʒ����� ��ȸ�� ������ ������ �����ʽÿ�.'>
<p><input type=submit onClick=\"if(this.form.raceid.value==''){ alert('�Ʒ����� ��ȸ�� �����Ͻʽÿ�.'); return false;}\" value='��ȸ ������ ��� ��ȸ'>
</form>\n";

}else if($mode == "inviting-list2"){
	heading("��ȸ ���� ��û�� ���");
	race_disp($raceid);
	echo "<p>��ü ���� ��û�� �Ʒ� ������ Copy�� �������� Paste�� �� ���ļ� ����Ͻʽÿ�.<br>\n";
	if(privcheck($logid) == 2){
		echo "(�ֹε�Ϲ�ȣ�� ���������׸� ��Ÿ���ϴ�.)<p>\n";
	}
	if($raceid=="438"){ // ���Ƹ�����
		$recorddisplay = 1;
		$validracedays = "race.raceday >='2004/12/01' and race.raceday <= '2006/11/30'";
	}
	$dbquery="select record.userid, record.raceid, member.name, record.item, record.transport, record.size, member.sex, member.juminno, record.fellows, member.email, member.telhome, member.telhand, record.groupyn, member.bloodtype, member.postaddr, record.makedate ";// 0~15

	$dbquery.="from record, member where record.raceid=$raceid and record.userid=member.userid order by record.groupyn, record.item desc, member.name";

	$result = mysql_query($dbquery) or die("mysql_query error");
	
	if($logid == "tongky" && $raceid == "589")
		$maker = "Y";
	else
		$maker = "N";
		
		

	echo "<table border=1><tr><th>�̸�<th>����<th>����";
	if(privcheck($logid) == 2 || $maker == "Y")
		echo "<th>�ֹε�Ϲ�ȣ";
	else
		echo "<th>�������";
	echo "<th>����<th>Size<th>����ȭ<th>����ȭ<th>������<th>������<th>��������<th>����<th>�ּ�<th>����<th>��û�����";
	if($recorddisplay)	echo "<th colspan=2>2�Ⱓ�ְ���/��ȸ";
	echo "</tr>";

	$no=0;
	$total=0;
	$date = getdate();
	$year = $date['year'];
	while($row=mysql_fetch_array($result)){
		$age=$year - 1900 - substr($row[7], 0, 2);
		if(privcheck($logid) == 2 || $maker == "Y")
			$birthdate=$row[7];
		else
			$birthdate = substr($row[7], 0, 6);
		echo "<tr><td>";
		echo "$row[2]";
		if($row[groupyn]=="Y")
			$groupreg = "��ü��û";
		else if($row[groupyn]=="N")
			$groupreg = "���ν�û";
		else if($row[groupyn]=="C")
			$groupreg = "��ü��ȯ";
		else
			$groupreg = "";
		if($row[8]=="")
			$persons = 1;
		else
			$persons = $row[8];
		if($row[13]=="UK")
			$bloodtype = "��";
		else
			$bloodtype = $row[13];
			
		echo "<td>$row[6]<td>$age<td>$birthdate<td>$row[3]<td>$row[5]<td>$row[10]<td>$row[11]<td>$bloodtype<td>$row[4]<td>$persons<td>$row[9]<td>$row[postaddr]<td>$groupreg<td>$row[makedate]";
		if($recorddisplay){
			$dbquery2="select record.record, race.nickname from record, race ";
			$dbquery2.="where record.userid='$row[0]' and record.item = 'Ǯ' and record.raceid=race.raceid and record.record > '0:00:00' and $validracedays ";
			$dbquery2.="order by record.record ";

			$result2 = mysql_query($dbquery2) or die("mysql_query error. dbquery=$dbquery2");
			$row2 = mysql_fetch_array($result2);
			echo "<td>$row2[0]<td>$row2[1]";

			mysql_free_result($result2);
		}
		echo "</tr>\n";
		$no++;
		$total = $total + $persons;
	}
	echo "<tr><td colspan=9>$no ��<td>�� $total ��";
	echo "</table>\n";
	if($no > 0){
		$dbquery="select nickname from race where raceid = '$raceid'";
		$result = mysql_query($dbquery) or die("mysql_query error");
		$row=mysql_fetch_array($result);
		$racenickname = $row[0];
		echo "<a href='$PHP_SELF?mode=inviting-memosend&raceid=$raceid&racenickname=".urlencode($racenickname)."'>'$racenickname' ��ȸ ������ ��ü���� ���� �߼�</a>";
	}
	mysql_free_result($result);
}else if($mode == "record-list"){
	heading("��ȸ ������ ���");
	echo "
<form name=form1 method=post action='$PHP_SELF'>
<input type=hidden name='mode' value='record-list2'>
<input type=hidden name='raceid'>
<input type=text name=racename size=50 value='�Ʒ����� ��ȸ�� ������ ������ �����ʽÿ�.'>
<p><input type=submit onClick=\"if(this.form.raceid.value==''){ alert('�Ʒ����� ��ȸ�� �����Ͻʽÿ�.'); return false;}\" value='��ȸ ������ ��� ��ȸ'>
</form>\n";

}else if($mode == "record-list2"){
	heading("��ȸ ������ ���");
	$racenickname = race_disp($raceid);
	$dbquery="select record.userid, record.raceid, member.name, record.item, member.sex, member.juminno, record.record ";
	$dbquery.=",IF( record.item='Ǯ', 1, IF( record.item='����', 2, IF( record.item='10Km', 3, IF( record.item='5Km', 4, 5)))) as racetype ";
	$dbquery .= ",record.openrecord ";
//	$dbquery.="from record, member where record.raceid=$raceid and record.userid=member.userid and record.dispyn='Y' and record.record!='' order by record.item desc, ";
	$dbquery.="from record, member where record.raceid=$raceid and record.userid=member.userid and record.dispyn!='N'  order by racetype, ";
	if($order == "name")
		$dbquery .= "member.name";
	elseif($order == "record" || $order == "")
		$dbquery .= "record.record";
	elseif($order == "openrecord")
		$dbquery .= "record.openrecord";

//echo "$dbquery";
	$result = mysql_query($dbquery) or die("mysql_query error");

	echo "<table border=1><tr><th>��ȣ";
	if($order == "name")
		echo "<th>�̸�";
	else
		echo "<th><a href='$PHP_SELF?mode=record-list2&raceid=$raceid&order=name'>�̸�</a>";
	echo "<th>����<th>�������<th>����";
	if($order == "record" || $order == "")
		echo "<th>���\n";
	else
		echo "<th><a href='$PHP_SELF?mode=record-list2&raceid=$raceid&order=record'>���</a>\n";

	if($order == "openrecord")
		echo "<th>Openȯ����\n";
	else
		echo "<th><a href='$PHP_SELF?mode=record-list2&raceid=$raceid&order=openrecord'>Openȯ����</a>\n";
	echo "<br><a href='bmrecord.php?mode=record-openrecord&raceid=$raceid&racenickname=".urlencode($racenickname)."'>(ȯ��ó��)</a></tr>\n";


	$no=0;
	$raceno=0;
	$hh=$mm=$ss=0;
	$racetype="";
	$opennull=0;
	while($row=mysql_fetch_array($result)){
		$no++;
		$birthdate=substr($row[5], 0, 6);
		$name = "<a href='/bbs/bmrecord.php?mode=record-change&raceid=$raceid&userid=$row[0]'>".$row[2]."</a>";
		echo "<tr><td>$no<td>$name<td>$row[4]<td>$birthdate<td>$row[3]<td>$row[6]";
		echo "<td>$row[8]\n";
		if($racetype=="") $racetype = $row[3];
		if($row[3] == $racetype && $row[6] > "00"){
			$rec = str_replace ( ";", ":", $row[6]);
			$hhmmss = explode(":", $rec);
			$hh += $hhmmss[0];
			$mm += $hhmmss[1];
			$ss += $hhmmss[2];
			$raceno++;
		}
	}
	if($raceno != 0){
		$avgsecs = round(($ss + $mm * 60 + $hh * 3600) / $raceno);
		$hh = floor($avgsecs / 3600);
		$temp = ($avgsecs - $hh * 3600);
		$mm = floor($temp / 60);
		$ss = $temp - $mm * 60;
		if(strlen($mm) == 1) $mm = "0".$mm;
		if(strlen($ss) == 1) $ss = "0".$ss;
	//echo "avgsecs=$avgsecs,hh=$hh,mm=$mm,ss=$ss,temp=$temp";
		echo "<tr><td colspan=4 align=center>$racetype $raceno �� ���<td>$hh:$mm:$ss\n";
	}
	echo "</table>\n";
	if($no > 0){
		echo "<a href='$PHP_SELF?mode=inviting-memosend&raceid=$raceid&racenickname=".urlencode($racenickname)."'>'$racenickname' ��ȸ ������ ��ü���� ���� �߼�</a>";
	}
	mysql_free_result($result);
}else if($mode == "inviting-mailsend"){
	heading("��ȸ ������ ��ü���� �߼��� ���� �ۼ�");
	echo "
<form method=post action='$PHP_SELF'>
<input type=hidden name=mode value=inviting-mailsend2>
<input type=hidden name=raceid value=$raceid>
<input type=hidden name=racenickname value='$racenickname'>
<table border=1><tr>
<td align=center>���� ����</td>
<td><input type=text name=subject size=60 maxlength=60></td>
</tr><tr>
<td align=center>�޴���</td>
<td>'$racenickname' ��ȸ ������ ����</td>
</tr><tr>
<td align=center>���� ����</td>
<td><textarea wrap=auto name=cont rows=12 cols=60></textarea></td>
</tr>
<tr>
<td colspan=2 align=center>
<input type=submit value='���� ������'>
</td>
</tr>
</table>
</form>";

}else if($mode == "inviting-mailsend2"){
	heading("��ȸ ������ ��ü���� ���� �߼�");
	if($subject == "" || $cont == ""){
		echo "����� ������ �Է��� �ֽʽÿ�.";
		die("");
	}

	$dbquery="select name,nickname,email from member where userid = '$logid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$row=mysql_fetch_array($result);
	$sender = "\"$row[0]($row[1])\"<$row[2]>";
	mysql_free_result($result);

	$url = "<a href='$PHP_SELF?mode=inviting-mailsend&raceid=$raceid&racenickname=".urlencode($racenickname)."'>'$racenickname' ��ȸ ������ ��ο��� ���� ������</a>\n";
	$dbquery="select record.userid, member.name, member.email ";
	$dbquery.="from record, member where record.raceid=$raceid and record.userid=member.userid order by record.item desc, member.name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	$no=0;
	$mailcont_file = "/tmp/emailconttmp.dat";
	while($row=mysql_fetch_array($result)){

		$fp = fopen($mailcont_file, "w");
		fwrite($fp, "From: $sender\n");
		fwrite($fp, "To: \"$row[1]�� ����\"<$row[2]>\n");
		fwrite($fp, "Subject: $subject\n");
		fwrite($fp, "\n");

		fwrite($fp, $cont);
		fwrite($fp, "\n");

//		fwrite($fp, "$url");
//		fwrite($fp, "\n");
		fclose($fp);
		$execret = exec("mail ".$row[2]."  < $mailcont_file");

		$no++;
		echo $row[1]." ";
		if(($no % 5) == 0){
			echo "<br>\n";
		}
		if(($no % 100) == 0){
//			sleep(5);
		}
	}
	chmod($mailcont_file, 0777);

	mysql_free_result($result);
	mysql_close() or die("mysql_close error");
	echo "<br>$no �� ���� �߼� �Ϸ�.\n";
	unlink($mailcont_file);

}else if($mode == "inviting-memosend"){
	heading("��ȸ ������ ��ü���� �߼��� ���� �ۼ�");
	echo "
<form method=post action='$PHP_SELF'>
<input type=hidden name=mode value=inviting-memosend2>
<input type=hidden name=raceid value=$raceid>
<input type=hidden name=racenickname value='$racenickname'>
<table border=1><tr>
<td align=center>���� ����</td>
<td><input type=text name=subject size=60 maxlength=60></td>
</tr><tr>
<td align=center>�޴���</td>
<td>'$racenickname' ��ȸ ������ ����</td>
</tr><tr>
<td align=center>���� ����</td>
<td><textarea wrap=auto name=cont rows=12 cols=60></textarea></td>
</tr>
<tr>
<td colspan=2 align=center>
<input type=submit value='���� ������'>
</td>
</tr>
</table>
</form>";

}else if($mode == "inviting-memosend2"){
	heading("��ȸ ������ ��ü���� ���� �߼�");
	if($subject == "" || $cont == ""){
		error( "����� ������ �Է��� �ֽʽÿ�.");
		die("");
	}
	$dbquery="select no from $member_table where user_id='$logid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$row=mysql_fetch_array($result);
	$member_from = $row[0];
	mysql_free_result($result);

	$url = "'$racenickname' ��ȸ ������ ��ο��� ���� ������\n";
	$dbquery="select record.userid, member.name, member.email ";
	$dbquery.="from record, member where record.raceid=$raceid and record.userid=member.userid order by record.item desc, member.name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	$no=0;
	$reg_date = time();
	while($row=mysql_fetch_array($result)){


		db_memo_send($get_memo_table, $send_memo_table, $member_table, $member_from, $row[0], $subject, $cont, $reg_date);
		$no++;
		echo $row[1]." ";
		if(($no % 5) == 0){
			echo "<br>\n";
		}
	}
	mysql_free_result($result);
	mysql_close() or die("mysql_close error");
	echo "<br>$no �� ���� �߼� �Ϸ�.\n";

}else if($mode == "submenu"){
	heading("��ȸ���� �޴�");
	echo "
	<a href='bminviting.php?mode=inviting-input'>������û</a><br>
	<a href='bminviting.php?mode=inviting-change'>������û����</a><br>
	<a href='bminviting.php?mode=inviting-list'>�����ڸ��</a><br>
	<a href='bminviting.php?mode=record-list'>�����ڱ��</a><br>";

}

function inviting_display($mode, $raceid, $item, $size, $transport, $fellows, $userid, $groupyn){

	global $logid, $PHP_SELF;

	$itemf=$itemh=$item10=$item5=$iteme="";
	if($item == "Ǯ" || $item == ''){
		$itemf = "checked";
	}else if($item == "����"){
		$itemh = "checked";
	}else if($item == "10Km"){
		$item10 = "checked";
	}else if($item == "5Km"){
		$item5 = "checked";
	}else{
		$iteme = "checked";
		$itemetc = $item;
	}
	$groupyny=$groupynn="";
	if($groupyn == "Y"){
		$groupyny = "checked";
	}else if($groupyn == "N"){
		$groupynn = "checked";
	}else if($groupyn == "C"){
		$groupync = "checked";
	}else{
		$groupyny = "checked";
	}
	if($mode == "inviting-insert" and $userid){
		$dbquery="select size from member where userid='$userid'";
		$result = mysql_query($dbquery) or die("mysql_query error");
		$row=mysql_fetch_array($result);
		$size = $row[0];
		mysql_free_result($result);
	}
	echo "<table border=1>";

	JScheckLength();
	echo "
<form action='$PHP_SELF' method=post>\n
<input type=hidden name=mode value='$mode'>\n";

	$count=0;
	echo "<tr><td>������ȸ</td><td>\n";
	if($mode == "inviting-inserttmp"){
		$dbquery="select raceid, name, nickname from race where inviting='Y'";
		$result = mysql_query($dbquery) or die("mysql_query error");
		echo "<select name='raceid' size='1' style='background-color: white; color: blue; font:10pt'>\n";

		for(; $row=mysql_fetch_array($result); ){
			$dbquery="select count(*) from record where userid='$userid' and raceid=$row[0]";

			$result2 = mysql_query($dbquery) or die("mysql_query error2");
			$row2=mysql_fetch_array($result2);
			if($row2[0] == 0){
				echo "<option value='$row[0]:$row[2]'>$row[2] : $row[1]</option>\n";
				$count++;
			}
			mysql_free_result($result2);
		}
		if($count == 0)
			echo "<option value='0:0'>!! ���� ������ ��ȸ�� �����ϴ� !!</option>";
		echo "</select>";
	}else{
		$dbquery="select raceid, name, nickname, homehref from race where raceid=$raceid";
		$result = mysql_query($dbquery) or die("mysql_query error");
		if($row=mysql_fetch_array($result)){
			if($row[3])
				echo "<a href='$row[3]' target=new>$row[2] : $row[1]</a>\n";
			else
				echo "$row[2] : $row[1]\n";
			if($mode == "inviting-insert" || $mode == "inviting-insertmember")
				echo "<input type=hidden name='raceid' value='$row[0]:$row[2]'>\n";
			else	// inviting-update
				echo "<input type=hidden name='raceid' value='$row[0]'>\n";
			$count=1;
		}
	}
	mysql_free_result($result);

	if($userid){
		echo "<input type=hidden name=userid value='$userid'>\n";
	}else{
		echo "<tr><td>������</td><td>\n";
		$dbquery="select userid, name from member order by name";
		$result = mysql_query($dbquery) or die("mysql_query error");
		echo "<select name='userid' size='1' style='background-color: white; color: blue; font:10pt'>\n";

		for(; $row=mysql_fetch_array($result); ){
			echo "<option value='$row[0]'>$row[1]</option>\n";
		}
		mysql_free_result($result);
	}

	echo "
</td></tr>\n
<tr><td>����</td><td>
  <input type='radio' name='item' value='Ǯ' $itemf>Ǯ&nbsp;&nbsp;
  <input type='radio' name='item' value='����' $itemh>����&nbsp;&nbsp;
  <input type='radio' name='item' value='10Km' $item10>10Km&nbsp;&nbsp;
  <input type='radio' name='item' value='5Km' $item5>5Km&nbsp;&nbsp;
  <input type='radio' name='item' value='etc' $iteme>��Ÿ
<input type=text name=itemetc value='$itemetc' maxlength=6 size=7 onChange='return checkLength(this.value,6)'>�� : 7.5Km</td></tr>\n
  </td></tr>\n
<tr><td>��ü/����</td><td>
  <input type='radio' name='groupyn' value='N' $groupynn>���ν�û����&nbsp;&nbsp;
  <input type='radio' name='groupyn' value='C' $groupync>���ν�û������ ��ü��ȯ ��û&nbsp;&nbsp;&nbsp;
  <input type='radio' name='groupyn' value='Y' $groupyny>Ŭ����ü��û ��û&nbsp;&nbsp;&nbsp;&nbsp;
</td></tr>
<tr><td>���ǰũ��</td><td><input type=text name=size value='$size' maxlength=4 size=5 onChange='return checkLength(this.value,4)'>�ݵ�� ��ȸ �䰭�� Ȯ�� �� ���� ���";
	if($mode == "inviting-insert" and $userid){
		echo "(ù ��Ͻô� �������� Ȱ��)";
	}
	echo "</td></tr>";
	echo "
<tr><td>������</td><td><input type=text name=transport value='$transport' maxlength=20 size=20 onChange='return checkLength(this.value,20)'>�� : ���ӽ��� ���, �ڰ��� ���� ��</td></tr>
<tr><td>��ü�̵��ο�</td><td><input type=text name=fellows value='$fellows' maxlength=2 size=2 onChange='return checkLength(this.value,2)'>������ ������ ��ü�̵� �ο���, ��ü�̵��� �ƴ� ��� 0</td></tr>
<tr><td colspan=2 align=center>";

	if(privcheck($logid)){
		if($count > 0){
			echo "<br><input type=submit value='";
			if($mode == "inviting-insert")
				echo "���";
			else
				echo "����";
			echo " ó��'>";
			if($mode == "inviting-update"){
				echo "<p></form>\n";
				echo "
<form action='$PHP_SELF' method=post>\n
<input type=hidden name=mode value='inviting-delete'>\n
<input type=hidden name=raceid value='$raceid'>\n";
				if(privcheck($logid) == 2){
					echo "<input type=hidden name=userid value='$userid'>\n";
				}
				echo "
<input type=submit value='���� ó��'>";
			}
		}
	}else{
		echo "<br>�����ڳ� ����ڸ� ���� �����մϴ�.";
	}


	echo "</form></td></tr>\n";
	echo "
</table>
";
}

?>
</center>
</body>
</html>
