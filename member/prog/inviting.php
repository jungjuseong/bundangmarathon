<?php

require("./auth.php");
require("./config.php");
require("./function.php");

top("");

if($mode == "inviting-input2"){
	heading("��ȸ ���� ��û");
	race_disp($raceid);
	echo "<p>";
	$dbquery2 = "select userid from record where raceid=$raceid and userid='$logid'";
	$result2 = mysql_query($dbquery2) or die("mysql_query error");
	$row2 = mysql_fetch_array($result2);
	mysql_free_result($result2);
	if($row2){
	}else{
		inviting_display("inviting-insert",$raceid,"","","","", $logid);
	}
	if(privcheck($logid) == 2){
		echo "<p><font size='+2'>�����ڿ� ȸ�� ���� ��û</font><p>\n";
		inviting_display("inviting-insert",$raceid,"","","","", "");
	}
}else if($mode == "inviting-input"){
	heading("��ȸ ���� ��û");

	$dbquery="select juminno from member where userid = '$logid'";
	$result2 = mysql_query($dbquery) or die("mysql_query error");
	$row=mysql_fetch_array($result2);
	if(!is_numeric(substr($row[0],0,6))){
		echo "<a href=\"mem.php?mode=member-change&userid=$logid\">�ֹε�Ϲ�ȣ�� �̻��մϴ�.<br>���� ���⿡�� ���� ������ �Է��Ͻʽÿ�.</a>";
		die("");
	}

	echo "��ü ���� ��û�� �ƴϴ��� ���� ��û�Ͻ� �е��� �Է� �ٶ��ϴ�.<p>\n";
	$dbquery="select raceid, name, nickname, userid from race where raceday > replace(substring(now(),1,10),'-','/') and inviting='Y' order by raceday";
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

	$query_name.="userid";
	$query_value.="'".$userid."'";

	$dbquery="insert into record ($query_name) values($query_value)";
//echo "dbquery=".$qdbuery;

	$result = mysql_db_query("coretek",$dbquery);

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
	$dbquery="select raceid from race where inviting='Y' order by raceday";
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
	heading("���� ��û ���� ����");

	$dbquery="select raceid, item, size, transport, fellows from record where userid='$userid' and raceid=$raceid";
	$result = mysql_query($dbquery) or die("mysql_query error");
	if($row=mysql_fetch_array($result)){
		inviting_display("inviting-update",  $row[0], $row[1], $row[2],
		 $row[3], $row[4], $userid);
	}else{
		echo "<tr><td><font color=red>'$name' ��ȸ�� ã�� ���� �����ϴ�.</font></td></tr>";
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
	$dbquery="update record set item='".$item."',size='".$size.
		"',transport='".$transport."',fellows='".$fellows."'";
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

	$dbquery="select raceid, name, nickname, userid from race where raceday > replace(substring(now(),1,10),'-','/') order by raceday";
	$result = mysql_query($dbquery) or die("mysql_query error");
	while($row=mysql_fetch_array($result)){
		echo "<a href='$PHP_SELF?mode=inviting-list2";
		if($row[3] == $logid)
			echo "&maker=Y";
		echo "&raceid=$row[0]&racenickname=".urlencode($row[2])."'>$row[2] : $row[1]</a><p>\n";
	}
}else if($mode == "inviting-list2"){
	heading("��ȸ ���� ��û�� ���");
	race_disp($raceid);
	echo "<p>��ü ���� ��û�� �Ʒ� ������ Copy�� �������� Paste�� �� ���ļ� ����Ͻʽÿ�.<br>\n";
	if(privcheck($logid) == 2)
		echo "(�ֹε�Ϲ�ȣ�� ���������׸� ��Ÿ���ϴ�.)<p>\n";
	$dbquery="select record.userid, record.raceid, member.name, record.item, record.transport, record.size, member.sex, member.juminno, record.fellows, member.email  ";

	$dbquery.="from record, member where record.raceid=$raceid and record.userid=member.userid order by record.item desc, member.name";

	$result = mysql_query($dbquery) or die("mysql_query error");

	echo "<table border=1><tr><th>�̸�<th>����<th>����";
	if(privcheck($logid) == 2)
		echo "<th>�ֹε�Ϲ�ȣ";
	else
		echo "<th>�������";
	echo "<th>����<th>Size<td>������<td>�����μ�";
	echo "</tr>";

	$no=0;
	$total=0;
	$date = getdate();
	$year = $date['year'];
	while($row=mysql_fetch_array($result)){
		$age=$year - 1900 - substr($row[7], 0, 2);
//		if(privcheck($logid) == 2 || $maker == "Y")
		if(privcheck($logid) == 2 )
			$birthdate=$row[7];
		else
			$birthdate = substr($row[7], 0, 6);
		echo "<tr><td>";
		if($row[9] == "")
			echo "$row[2]";
		else
			echo "<a href='mailto:$row[9]'>$row[2]</a>";
		echo "<td>$row[6]<td>$age<td>$birthdate<td>$row[3]<td>$row[5]<td>$row[4]<td>$row[8]\n";
		$no++;
		$total = $total + $row[8];
	}
	echo "<tr><td colspan=4>�� $no ���Դϴ�.<td colspan=3><td>�� $total ��";
	echo "</table>\n";
	if($no > 0){
		echo "<a href='$PHP_SELF?mode=inviting-mailsend&raceid=$raceid&racenickname=".urlencode($racenickname)."'>'$racenickname' ��ȸ ������ ��ü���� ���� �߼�</a>";
	}
	mysql_free_result($result);
}else if($mode == "record-list"){
	heading("��ȸ ������ ���");
	echo "
<form name=form1 method=post action='$PHP_SELF'>
<input type=hidden name='mode' value='record-list2'>
<input type=hidden name='raceid'>
<input type=text name=racename size=50 value='�Ʒ����� ��ȸ�� ������ ������ �����Ͻʽÿ�.'>
<p><input type=submit onClick=\"if(this.form.raceid.value==''){ alert('�Ʒ����� ��ȸ�� �����Ͻʽÿ�.'); return false;}\" value='��ȸ ������ ��� ��ȸ'>
</form>\n";

}else if($mode == "record-list2"){
	heading("��ȸ ������ ���");
	$racenickname = race_disp($raceid);
	$dbquery="select record.userid, record.raceid, member.name, record.item, member.sex, member.juminno, record.record ";
	$dbquery.=",IF( record.item='Ǯ', 1, IF( record.item='����', 2, IF( record.item='10Km', 3, IF( record.item='5Km', 4, 5)))) as racetype ";
	$dbquery .= ",record.openrecord ";
//	$dbquery.="from record, member where record.raceid=$raceid and record.userid=member.userid and record.dispyn='Y' and record.record!='' order by record.item desc, ";
	$dbquery.="from record, member where record.raceid=$raceid and record.userid=member.userid and record.dispyn='Y' and record.record!='' order by racetype, ";
	if($order == "name")
		$dbquery .= "member.name";
	elseif($order == "record" || $order == "")
		$dbquery .= "record.record";
	elseif($order == "openrecord")
		$dbquery .= "record.openrecord";

//echo "$dbquery";
	$result = mysql_query($dbquery) or die("mysql_query error");

	echo "<table border=1><tr>";
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
	echo "<br><a href='record.php?mode=record-openrecord&raceid=$raceid&racenickname=".urlencode($racenickname)."'>(ȯ��ó��)</a></tr>\n";

				
	$no=0;
	$raceno=0;
	$hh=$mm=$ss=0;
	$racetype="";
	$opennull=0;
	while($row=mysql_fetch_array($result)){

		$birthdate=substr($row[5], 0, 6);
		echo "<tr><td>$row[2]<td>$row[4]<td>$birthdate<td>$row[3]<td>$row[6]";
		echo "<td>$row[8]\n";
		$no++;
		if($racetype=="") $racetype = $row[3];
		if($row[3] == $racetype){
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
		echo "<a href='$PHP_SELF?mode=inviting-mailsend&raceid=$raceid&racenickname=".urlencode($racenickname)."'>'$racenickname' ��ȸ ������ ��ü���� ���� �߼�</a>";
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

}else if($mode == "submenu"){
	heading("�޴� ���� ����");
	echo "���� �޴��� �����Ͻʽÿ�.";
}

function inviting_display($mode, $raceid, $item, $size, $transport, $fellows, $userid){

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
		}
		if($count == 0)
			echo "<option value='0:0'>!! ���� ������ ��ȸ�� �����ϴ� !!</option>";
		echo "</select>";
	}else{
		$dbquery="select raceid, name, nickname from race where raceid=$raceid";
		$result = mysql_query($dbquery) or die("mysql_query error");
		if($row=mysql_fetch_array($result)){
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
  <input type='radio' name='item' value='Ǯ' $itemf>Ǯ
  <input type='radio' name='item' value='����' $itemh>����
  <input type='radio' name='item' value='10Km' $item10>10Km
  <input type='radio' name='item' value='5Km' $item5>5Km
  <input type='radio' name='item' value='etc' $iteme>��Ÿ
<input type=text name=itemetc value='$itemetc' maxlength=6 size=7 onChange='return checkLength(this.value,6)'>�� : 7.5Km</td></tr>\n
  </td></tr>\n
<tr><td>T-Shirtũ��</td><td><input type=text name=size value='$size' maxlength=4 size=5 onChange='return checkLength(this.value,4)'>�ݵ�� ��ȸ �䰭�� Ȯ�� �� ���� ���</td></tr>\n
<tr><td>������</td><td><input type=text name=transport value='$transport' maxlength=20 size=20 onChange='return checkLength(this.value,20)'>�� : ���ӽ��� ���, �ڰ��� ���� ��</td></tr>\n
<tr><td>��ü�̵��ο�</td><td><input type=text name=fellows value='$fellows' maxlength=2 size=2 onChange='return checkLength(this.value,2)'>������ ������ ��ü�̵� �ο���, ��ü�̵��� �ƴ� ��� 0</td></tr>\n
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
				echo "<p>
</form>
<form action='$PHP_SELF' method=post>\n
<input type=hidden name=mode value='inviting-delete'>\n
<input type=hidden name=raceid value='$raceid'>\n
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
