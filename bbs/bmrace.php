<?php

require("./bmauth.php");
require("./bmconfig.php");
require("./bmfunction.php");

top("");

if($mode == "race-input"){
	heading("��ȸ ���� �ű� ���");
	echo "��� �� �����ڳ� �ű� ����ڸ� ���� �� ������û�� ������ �� �ֽ��ϴ�.<p>";
	race_display("race-insert","","","","","","","","","","","",$logid);
}else if($mode == "race-change"){
	heading("��ȸ ���� ����");

//	if($logid != $admin_id)
//		$userid = $logid;
	$dbquery="select raceid, name, nickname, raceday, racetime, organizer, homehref, place, typenfee, etc, inviting, userid from race where raceid=$raceid";
	$result = mysql_query($dbquery) or die("mysql_query error");
	if($row=mysql_fetch_array($result)){
		race_display("race-update",  $row[0], $row[1], $row[2], $row[3],
		 $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]);
	}else{
		echo "<tr><td>'$name' ��ȸ�� ã�� ���� �����ϴ�.</td></tr>";
	}
	mysql_free_result($result);
	mysql_close() or die("mysql_close error");
}else if($mode == "race-insert"){
	heading("��ȸ ���� �ű� ���");

	$dbquery="select raceid, name, nickname, raceday from race where raceday='$raceday' and replace(nickname,' ', '')='".str_replace(" ", "", $nickname)."'";
//echo $dbquery;
	$result = mysql_query($dbquery) or die("mysql_query error");

	$rows = mysql_num_rows($result);
	if($rows > 0){
		echo "��ȸ ��Ī�� �ֽ��ϴ�.";
		return;
	}


	$query_name="";
	$query_value="";

	$query_name.="name,";
	$query_value.="'".$name."',";
	$query_name.="nickname,";
	$query_value.="'".$nickname."',";

	if(!($raceday=daycheck($raceday))) return;

	$query_name.="raceday,";
	$query_value.="'".$raceday."',";
	$query_name.="racetime,";
	$query_value.="'".$racetime."',";

	$query_name.="organizer,";
	$query_value.="'".$organizer."',";
	$query_name.="homehref,";
	$query_value.="'".$homehref."',";

	$query_name.="place,";
	$query_value.="'".$place."',";

	$query_name.="typenfee,";
	$query_value.="'".$typenfee."',";
	$query_name.="etc,";
	$query_value.="'".$etc."',";
	$query_name.="inviting,";
	$query_value.="'".$inviting."',";

	$query_name.="userid";
	$query_value.="'".$logid."'";

//echo "query_name=".$query_name;
//echo "query_value=".$query_value;
	$dbquery="insert into race ($query_name) values($query_value)";

	$result = mysql_query($dbquery);

	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "�̹� ����Ͻ� ��ȸ�Դϴ�.<br>";
		echo "��ȸ ��Ī�� Ȯ�� �ٶ��ϴ�.";
		die("");
	}else{
		echo "��ȸ ��� ó�� �Ϸ�.<br>";
		echo "
<script language=JavaScript>
	parent.framerace.location = 'bmrace.php?mode=race-framelist';
</script>";

	}

}else if($mode == "race-delete"){
	heading("��ȸ ���� ����");
	$dbquery="select count(*) from record where raceid=$raceid";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$row=mysql_fetch_array($result);

	if($row[0] == "0"){
		$dbquery="delete from race where raceid=$raceid";
		if(privcheck($logid) < 2){
			$dbquery .= " and userid='$logid'";
		}
		$result = mysql_query($dbquery) or die("mysql_query error");

		if($result=="1"){
			echo "$nickname ���� �Ϸ�";
		echo "
<script language=JavaScript>
	parent.framerace.location = 'bmrace.php?mode=race-framelist';
</script>";

		}else{
			echo "<font color=red>$nickname ���� ����</font>";
		}
	}else{
		echo "����� �ֱ� ������ ������ �� �����ϴ�.<br>�����ڿ��� ���� �ٶ��ϴ�.";
	}
}else if($mode == "race-update"){
	heading("��ȸ ���� ���� �Ϸ�");

	if(!($raceday=daycheck($raceday))) return;

	$dbquery="select raceid, name, nickname, raceday from race where raceid!=$raceid and replace(nickname,' ', '')='".str_replace(" ", "", $nickname)."'";
//echo $dbquery;
	$result = mysql_query($dbquery) or die("mysql_query error");

	$rows = mysql_num_rows($result);
	if($rows > 0){
		echo "��ȸ ��Ī�� �ֽ��ϴ�.";
		return;
	}
	$dbquery="update race set name='".$name."',nickname='".$nickname.
		"',organizer='".$organizer."',homehref='".$homehref.
		"',raceday='".$raceday."',racetime='".$racetime.
		"',place='".$place."',typenfee='".$typenfee.
		"',etc='".$etc."',inviting='".$inviting.
		"',modifier='".$logid."'";
	$dbquery.=" where raceid=".$raceid;
//echo "dbquery=".$dbquery;
	$result = mysql_query($dbquery) or die("mysql_query error");

	if($result=="1"){
		if($oldnickname != "" && $nickname != $oldnickname){
			$dbquery="update record set nickname='".$nickname."'";
			$dbquery.=" where raceid=".$raceid;
			$result = mysql_query($dbquery) or die("mysql_query2 error");
			if($result>="1"){
				echo "\"$name\" ���� �Ϸ�";
			}else{
				echo "<font color=red>$name ���� ����(record nickname update error)</font>";
				return;
			}
		}else{
			echo "\"$name\" ���� �Ϸ�";
		}
		echo "
<script language=JavaScript>
	parent.framerace.location = 'bmrace.php?mode=race-framelist';
</script>";

	}else{
		echo "<font color=red>$name ���� ����(race update error)</font>";
	}
}else if($mode == "race-list"){
	heading("������ ��ȸ ���");

	$dbquery="select raceid, name, nickname, raceday, racetime, organizer, homehref, place, typenfee, etc, inviting from race order by raceday desc";
	$result = mysql_query($dbquery) or die("mysql_query error");

	echo "<table border=1><tr><th>��ȸ��<th>��Ī<th>�Ͻ�<th>����/Ȩ������<th>���<th>����/������<th>�������</tr>";
	while($row=mysql_fetch_array($result)){
		echo "<tr><td><a href='bminviting.php?mode=record-list2&raceid=$row[0]'>$row[1]</a>\n";
		echo "<td>$row[2] <td>$row[3] $row[4]";
		if($row[6] != ""){
			echo "<td><a href='$row[6]' target=_new>$row[5]</a>";
		}else{
			echo "<td>$row[5]";
		}
		echo "<td>$row[7] <td>$row[8] <td>$row[9]\n";
	}
	echo "</tr></table>";
	mysql_free_result($result);
}else if($mode == "race-select"){
	heading("��ȸ ���� ����");

	echo "<form name=form1 method=post action='$PHP_SELF'>\n";
	echo "<input type=hidden name='mode' value='race-change'>\n";
	echo "<input type=hidden name='raceid'>\n";
	echo "<input type=text name=racename size=50 value='�Ʒ����� ��ȸ�� ������ ������ �����ʽÿ�.'>";
	echo "<p><input type=submit onClick=\"if(this.form.raceid.value==''){ alert('�Ʒ����� ��ȸ�� �����Ͻʽÿ�.'); return false;}\" value='�ڷ���� �Ǵ� ��û���� ó��'>";
	echo "</form>";
}else if($mode == "race-framelist"){
	$dbquery="select raceid, name, nickname, raceday from race order by raceday desc";
//echo $dbquery;
	$result = mysql_query($dbquery) or die("mysql_query error");

	$rows = mysql_num_rows($result);
	if($rows == 0){
		echo "��ȸ�� �����ϴ�.";
	}else{
		echo "<form name=racelistform method=post>\n";
		echo "<select id='raceid' name='raceid' size='1' style='background-color: white; color: blue; font:10pt'>\n";

		while($row=mysql_fetch_array($result)){
			echo "<option value='$row[0]'>$row[3] : $row[2] : $row[1]</option>\n";
		}
		echo "</select>";
		echo "<input type=button value='����' onClick=\"parent.framecont.form1.racename.value=racelistform.raceid.options[racelistform.raceid.selectedIndex].text;parent.framecont.form1.raceid.value=racelistform.raceid.options[racelistform.raceid.selectedIndex].value\"\">";
//		echo "<input type=button value='����' onClick=\"parent.document.getElementById('racename').value=getElementById('raceid').options[getElementById('raceid').selectedIndex].text;parent.document.getElementById('raceid').value=getElementById('raceid').options[getElementById('raceid').selectedIndex].value\"\">";
//alert(this.form.raceid.options[this.form.raceid.selectedIndex].value);
		echo "</form>";
	}
	mysql_free_result($result);
	mysql_close() or die("mysql_close error");
}else if($mode == "submenu"){
	heading("��ȸ���� �޴�");
	echo "
	<a href='bmrace.php?mode=race-input'>��ȸ�����űԵ��</a><br>
	<a href='bmrace.php?mode=race-select'>��ȸ��������/��û����</a><br>
	<a href='bmrace.php?mode=race-list'>�Էµȴ�ȸ���</a><br>";
}

function race_display($mode, $raceid, $name, $nickname, $raceday, $racetime,
	 $organizer, $homehref, $place, $typenfee, $etc, $inviting, $userid){
	global $logid, $PHP_SELF;
	$oldnickname = $nickname;



	if($inviting == "Y"){
		$invitingy = "checked";
		$invitingn = "";
	}else{
		$invitingn = "checked";
		$invitingy = "";
	}
	echo "<table border=1>";
	JScheckLength();
echo "
<form action='$PHP_SELF' method=post>\n
<input type=hidden name=raceid value='$raceid'>\n
<input type=hidden name=userid value='$userid'>\n
<input type=hidden name=mode value='$mode'>\n
<input type=hidden name=oldnickname value='$oldnickname'>\n
<tr><td>��ȸ��Ī</td><td><input type=text name=name value='$name' maxlength=60 size=50 onChange='return checkLength(this.value,60)'></td></tr>\n
<tr><td>��ȸ��Ī</td><td><input type=text name=nickname value='$nickname' maxlength=15 size=15 onChange='return checkLength(this.value,15)'>���� 2�ڸ� + ��ĭ + ���(�� : 01 ����, 01 ��ü ��õ)</td></tr>\n
<tr><td>��ȸ��¥</td><td><input type=text name=raceday value='$raceday' maxlength=10 size=10 onChange='return checkLength(this.value,10)'>�� : 2001/07/26</td></tr>\n
<tr><td>��߽ð�</td><td><input type=text name=racetime value='$racetime' maxlength=5 size=6 onChange='return checkLength(this.value,5)'>����Ÿ� ���� ���� (�� : 9:30)</td></tr>\n
<tr><td>����</td><td><input type=text name=organizer value='$organizer' maxlength=30 size=30 onChange='return checkLength(this.value,30)'></td></tr>\n
<tr><td>Ȩ�ּ�</td><td><input type=text name=homehref value='$homehref' maxlength=60 size=50 onChange='return checkLength(this.value,60)'></td></tr>\n
<tr><td>���</td><td><input type=text name=place  value='$place' maxlength=20 size=30 onChange='return checkLength(this.value,30)'></td></tr>\n
<tr><td>�����������</td><td><input type=text name=typenfee value='$typenfee' maxlength=60 size=60 onChange='return checkLength(this.value,60)'></td></tr>\n
<tr><td>��Ÿ�������</td><td><input type=text name=etc value='$etc' maxlength=200 size=50 onChange='return checkLength(this.value,200)'>Ƽ���� ũ�� ��(���� 200��)</td></tr>\n
<tr><td>������û����</td><td>
  <input type='radio' name='inviting' value='Y' $invitingy>ȸ�� ������û ��������
  <input type='radio' name='inviting' value='N' $invitingn>ȸ�� ������û ������
  </td></tr>\n
<tr><td colspan=2 align=center>";

	if($userid == $logid || privcheck($logid) == 2){
		echo "<br><input type=submit value='";
		if($mode == "race-insert")
			echo "���";
		else
			echo "����";
		echo " ó��'>";
		if($mode == "race-update"){
			echo "<p>
</form>

<form action='$PHP_SELF' method=post>\n
<input type=hidden name=mode value='race-delete'>\n
<input type=hidden name=raceid value='$raceid'>\n
<input type=hidden name=nickname value='$nickname'>\n
<input type=submit value='���� ó��'>";
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
