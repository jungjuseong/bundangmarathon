<?php

require("./auth.php");
require("./config.php");
require("./function.php");

	top("");
if($mode == "meminfo-brief" or $mode == "meminfo-photo"){
	echo "
<style>
A:link { color: blue; text-decoration: none; }
A:visited { color: blue; text-decoration: none;}
A:active { color: blue; text-decoration: none;}
A:hover { color: blue; text-decoration: none}
</style>

<script language='JavaScript'>
function winopen(userid){
    PopUp = window.open ('$PHP_SELF?mode=meminfo-one&userid='+userid, 'popup_answer', 'width=600,height=700, top=100, left=100, resizable=1,scrollbars=yes');
    PopUp.focus();
}
</script>";
}

if($mode == "meminfo-brief"){
	heading("ȸ�� ���� ����");

	echo "<a href=$PHP_SELF?mode=meminfo-photo>�� ȸ�� ���� �ϰ� ����</a><p>";

	$rowmemno = 5;
	$dbquery = "select userid, name, photo, grade, gumpuno, boston from member";
	$dbquery .= " where membertype='��ȸ��' order by disporder, gumpuno";
	$result = mysql_query($dbquery) or die("mysql_query error");

	echo "<table border=1><tr><td colspan=$rowmemno align=center style='font-size:20'>��ȸ��</td></tr>";
	$tmp = "";
	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";

		if($row[3])
			$tmp = "$row[3]";

		echo "<td align=center>";
		echo "<a href='' onClick='winopen(\"$row[0]\"); return false' >";
		echo "$row[1]($row[4])";
		if($row[3])
			echo "<br>$row[3]";
		else if($tmp)
			echo "<br>";
		echo "</a></td>\n";
		if(($i % $rowmemno) == ($rowmemno-1)){
			echo "</tr>";
			$tmp = "";
		}
	}
	echo "<tr><td colspan=$rowmemno align=center>��ȸ�� �� $i ��</td></tr></table><br><br>\n";
	mysql_free_result($result);

	echo "<table border=1><tr><td colspan=$rowmemno align=center style='font-size:20'>��ȸ��</td></tr>";
	$dbquery = "select userid, name, photo, grade, boston from member";
	$dbquery .= " where membertype='��ȸ��' order by disporder, name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";
		if($row[3])
			$tmp = "($row[3])";
		else
			$tmp = "";
		echo "<td align=center>";
		echo "<a href='' onClick='winopen(\"$row[0]\"); return false' >";
		echo "$row[1]$tmp";
		echo "</a></td>\n";
		if(($i % $rowmemno) == ($rowmemno-1))
			echo "</tr>";
	}
	mysql_free_result($result);

	echo "<tr><td colspan=$rowmemno align=center>��ȸ�� �� $i ��</td></tr>\n";
	echo "</table><p>\n";

	echo "<table border=1><tr><td colspan=$rowmemno align=center style='font-size:20'>����ȸ��</td></tr>";
	$dbquery = "select userid, name, photo, grade from member";
	$dbquery .= " where membertype='����ȸ��' order by disporder, name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";
		echo "<td align=center>\n";
		echo "<a href='' onClick='winopen(\"$row[0]\"); return false' >";
		echo "$row[1]</a></td>\n";
		if(($i % $rowmemno) == ($rowmemno-1))
			echo "</tr>";
	}
	mysql_free_result($result);

	echo "<tr><td colspan=$rowmemno align=center style='font-size:20'>�޸�ȸ��</td></tr>";
	$dbquery = "select userid, name, photo, gumpuno from member";
	$dbquery .= " where membertype='�޸�ȸ��' order by disporder, name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";
		if($row[3])
			$tmp = "($row[3])";
		else
			$tmp = "";
		echo "<td align=center>";
		echo "<a href='' onClick='winopen(\"$row[0]\"); return false' >";
		echo "$row[1]$tmp";
		echo "</a>";
		echo "</td>\n";
		if(($i % $rowmemno) == ($rowmemno-1))
			echo "</tr>";
	}
	mysql_free_result($result);

	echo "<tr><td colspan=$rowmemno align=center style='font-size:20'>OBȸ��</td></tr>";
	$dbquery = "select userid, name, photo, gumpuno from member";
	$dbquery .= " where membertype='OBȸ��' order by disporder, name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";
		if($row[3])
			$tmp = "($row[3])";
		else
			$tmp = "";
		echo "<td align=center>";
		echo "<a href='' onClick='winopen(\"$row[0]\"); return false' >";
		echo "$row[1]$tmp";
		echo "</a>";
		echo "</td>\n";
		if(($i % $rowmemno) == ($rowmemno-1))
			echo "</tr>";
	}
	mysql_free_result($result);

	echo "</table>\n";
}else if($mode == "meminfo-photo"){
	heading("ȸ�� ���� ����");

	$rowmemno = 5;
	$dbquery = "select userid, name, photo, grade, gumpuno, boston from member";
	$dbquery .= " where membertype='��ȸ��' order by disporder, gumpuno";
	$result = mysql_query($dbquery) or die("mysql_query error");

	echo "<table border=1><tr><td colspan=$rowmemno align=center style='font-size:20'>��ȸ��</td></tr>";
	$tmp = "";
	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";

		if($row[3])
			$tmp = "$row[3]";

		echo "<td align=center>";
		echo "<a href='' onClick='winopen(\"$row[0]\"); return false' >";
		echo "$row[1]($row[4])";
		if($row[3])
			echo "<br>$row[3]";
		else if($tmp)
			echo "<br>";
		$dbquery2 = "select record from record";
		$dbquery2 .= " where userid='$row[0]' and item='Ǯ' and record != '' order by record limit 1";
		$result2 = mysql_query($dbquery2) or die("mysql_query error2");
		$row2=mysql_fetch_array($result2);
		if($row2[0] != ""){
			echo "<br>$row2[0]";
		}else{
			echo "<br>";
		}
		echo "<br><img src='../photo/$row[2]' border=0>";
		if($row[5] != ""){
			echo "<br>";
			bostonrace($row[5], "20");
		}
		mysql_free_result($result2);
		echo "</a></td>\n";
		if(($i % $rowmemno) == ($rowmemno-1)){
			echo "</tr>";
			$tmp = "";
		}
	}
	echo "<tr><td colspan=$rowmemno align=center>��ȸ�� �� $i ��</td></tr></table><br><br>\n";
	mysql_free_result($result);

	echo "<table border=1><tr><td colspan=$rowmemno align=center style='font-size:20'>��ȸ��</td></tr>";
	$dbquery = "select userid, name, photo, grade, boston from member";
	$dbquery .= " where membertype='��ȸ��' order by disporder, name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";
		if($row[3])
			$tmp = "($row[3])";
		else
			$tmp = "";
		echo "<td align=center>";
		echo "<a href='' onClick='winopen(\"$row[0]\"); return false' >";
		echo "$row[1]$tmp";
		$dbquery2 = "select record from record";
		$dbquery2 .= " where userid='$row[0]' and item='Ǯ' and record != '' order by record limit 1";
		$result2 = mysql_query($dbquery2) or die("mysql_query error2");
		$row2=mysql_fetch_array($result2);
		if($row2[0] != ""){
			echo "<br>$row2[0]";
		}else{
			echo "<br>";
		}
		echo "<br><img src='../photo/$row[2]' border=0>";
		if($row[4] != ""){
			echo "<br>";
			bostonrace($row[4], "20");
		}
		mysql_free_result($result2);
		echo "</a></td>\n";
		if(($i % $rowmemno) == ($rowmemno-1))
			echo "</tr>";
	}
	mysql_free_result($result);

	echo "<tr><td colspan=$rowmemno align=center>��ȸ�� �� $i ��</td></tr>\n";
	echo "</table><p>\n";

	echo "<table border=1><tr><td colspan=$rowmemno align=center style='font-size:20'>����ȸ��</td></tr>";
	$dbquery = "select userid, name, photo, grade from member";
	$dbquery .= " where membertype='����ȸ��' order by disporder, name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";
		echo "<td align=center>\n";
		echo "<a href='' onClick='winopen(\"$row[0]\"); return false' >";
		echo "$row[1]</a></td>\n";
		if(($i % $rowmemno) == ($rowmemno-1))
			echo "</tr>";
	}
	mysql_free_result($result);

	echo "<tr><td colspan=$rowmemno align=center style='font-size:20'>�޸�ȸ��</td></tr>";
	$dbquery = "select userid, name, photo, gumpuno from member";
	$dbquery .= " where membertype='�޸�ȸ��' order by disporder, name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";
		if($row[3])
			$tmp = "($row[3])";
		else
			$tmp = "";
		echo "<td align=center>";
		echo "<a href='' onClick='winopen(\"$row[0]\"); return false' >";
		echo "$row[1]$tmp";
		$dbquery2 = "select record from record";
		$dbquery2 .= " where userid='$row[0]' and item='Ǯ' and record != '' order by record limit 1";
		$result2 = mysql_query($dbquery2) or die("mysql_query error2");
		$row2=mysql_fetch_array($result2);
		if($row2[0] != "")
			echo "<br>$row2[0]";
		else
			echo "<br>";
		echo "<br><img src='../photo/$row[2]' border=0>";
		mysql_free_result($result2);
		echo "</a>";
		echo "</td>\n";
		if(($i % $rowmemno) == ($rowmemno-1))
			echo "</tr>";
	}
	mysql_free_result($result);

	echo "<tr><td colspan=$rowmemno align=center style='font-size:20'>OBȸ��</td></tr>";
	$dbquery = "select userid, name, photo, gumpuno from member";
	$dbquery .= " where membertype='OBȸ��' order by disporder, name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";
		if($row[3])
			$tmp = "($row[3])";
		else
			$tmp = "";
		echo "<td align=center>";
		echo "<a href='' onClick='winopen(\"$row[0]\"); return false' >";
		echo "$row[1]$tmp";
		$dbquery2 = "select record from record";
		$dbquery2 .= " where userid='$row[0]' and item='Ǯ' and record != '' order by record limit 1";
		$result2 = mysql_query($dbquery2) or die("mysql_query error2");
		$row2=mysql_fetch_array($result2);
		if($row2[0] != "")
			echo "<br>$row2[0]";
		else
			echo "<br>";
		echo "<br><img src='../photo/$row[2]' border=0>";
		mysql_free_result($result2);
		echo "</a>";
		echo "</td>\n";
		if(($i % $rowmemno) == ($rowmemno-1))
			echo "</tr>";
	}
	mysql_free_result($result);

	echo "</table>\n";
}else if($mode == "meminfo-one"){
	heading("ȸ�� �Ұ�");

	$dbquery="select name, nickname, juminno, org, orghref, email, photo,";
	$dbquery.="telhome, teloffice, telhand, postaddr, membertype, grade, ";
	$dbquery.="gumpuno, etc, boston from member where userid='$userid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$row=mysql_fetch_array($result);

	$name = $row[0];
	echo "<table border=1>\n";
	echo "<tr><td>�̸�(����)<td>$name";
	if($row[1])
		echo "($row[1])\n";
	else
		echo "\n";
	echo "<tr><td>����<td>$row[11]";
	if($row[12])
		echo "($row[12])";
	if($row[11] == "��ȸ��")
		echo ", ��Ǫ��ȣ:$row[13]";
	echo "\n";
	echo "<tr><td>�������<td>";
	if($row[2] && substr($row[2],0,6) != "xxxxxx"){
		$birthdate = "19";
		$birthdate .= substr($row[2], 0, 2);
		$birthdate .= ".";
		$birthdate .= substr($row[2], 2, 2);
		$birthdate .= ".";
		$birthdate .= substr($row[2], 4, 2);
		echo "$birthdate \n";
	}else
		echo "������� �Է¾ȵ� \n";
	echo "<tr><td>����<td>\n";
	if(strlen($row[4])>4){
		if(substr($row[4],0,4) != "http")
			$orghref = "http://" . $row[4];
		else
			$orghref = $row[4];
		echo "<a href='$orghref' target=_new>$row[3]</a>\n";
	}else{
		echo "$row[3]\n";
	}
	echo "<tr><td>E-mail<td><a href='mailto:$row[5]'>$row[5]</a>\n";
	echo "<tr><td>����<td>";
	if(strlen($row[6])>5)
		echo "<img src='../photo/$row[6]' border=0>";
	if($row[15] != "")
		bostonrace($row[15], "0");
	echo "\n";
	echo "<tr><td>��ȭ��ȣ<td>";
	if($logid != ""){
		if($row[7])
			echo "H:$row[7]";
		if($row[8])
			echo " O:$row[8]";
		if($row[9])
			echo " M:$row[9]";
		echo "\n";
	}

	echo "<tr><td>�ּ�<td>$row[10]\n";
	echo "<tr><td>�Ұ�<td>$row[14]\n";
	echo "</table>* ��ȭ��ȣ, �ּҴ� ȸ�����Ը� ǥ�õ�<br><br>\n";

	require("./func_nextimg.php");

	if(nextimg($name) == 0){
		echo "<p align=center style='color:red;'>��ȸ ���� ������ �����ϴ�.<br>���� ������ ��� ���� �ֽʽÿ�.\n";
	}

	echo "<br><br><table border=1><tr><th colspan=5>���� ���</tr>\n";
	echo "<tr><th>��ȸ��";
	if($orderfield == "raceday"){
		echo "<th>��¥\n";
	}else{
		echo "<th><a href='$PHP_SELF?mode=meminfo-one&userid=$userid&orderfield=raceday'>��¥</a>\n";
	}
	if($orderfield == "item"){
		echo "<th>����\n";
	}else{
		echo "<th><a href='$PHP_SELF?mode=meminfo-one&userid=$userid&orderfield=item'>����</a>\n";
	}
	if($orderfield == "" or $orderfield == "record"){
		echo "<th>���\n";
	}else{
		echo "<th><a href='$PHP_SELF?mode=meminfo-one&userid=$userid&orderfield=record'>���</a>\n";
	}

	if($orderfield == "raceday"){
		$orderfield = "race.raceday desc";
	}else if($orderfield == "item"){
		$orderfield = "itemnew, race.raceday desc";
	}else if($orderfield == "" or $orderfield == "record"){
		$orderfield = "itemnew, record.record";
	}
	$dbquery="select race.raceid, race.nickname, race.raceday, record.item, record.record, record.rank, record.dispyn, record.etc";
	$dbquery .= ", IF( record.item='Ǯ', 1, IF( record.item='����', 2, IF( record.item='10Km', 3, IF( record.item='5Km', 4, 5)))) as itemnew";
	$dbquery .= " from race,record where record.userid='$userid' and (record.record != '' and record.record is not null) and record.raceid=race.raceid order by ".$orderfield;
	$result = mysql_query($dbquery) or die("mysql_query error");

	echo "<th>����</tr>";
	while($row=mysql_fetch_array($result)){
		echo "<tr><td>$row[1] <td>$row[2] <td>$row[3]";
		echo "<td>$row[4]<td>$row[5]\n";
	}
	echo "</tr></table>";

	mysql_free_result($result);

}else if($mode == "meminfo-addrlist"){
	heading("ȸ�� �ּҷ�");

	echo "<table border=1>\n";
	if($orderfield == "" or $orderfield == "name"){
		echo "<th>�̸�\n";
	}else{
		echo "<th><a href='$PHP_SELF?mode=meminfo-addrlist&orderfield=name'>�̸�</a>\n";
	}
	if($orderfield == "type"){
		echo "<th>����\n";
	}else{
		echo "<th><a href='$PHP_SELF?mode=meminfo-addrlist&orderfield=type'>����</a>\n";
	}
	if($orderfield == "birthday"){
		echo "<th>�������\n";
	}else{
		echo "<th><a href='$PHP_SELF?mode=meminfo-addrlist&orderfield=birthday'>�������</a>\n";
	}
	echo "<th>����<th>E-mail �ּ�<th>����ȭ<th>������ȭ<th>�̵���ȭ<th>�ּ�\n";

	if($orderfield == "" or $orderfield == "name"){
		$orderfield = "name";
	}else if($orderfield == "type"){
		$orderfield = "membertype, gumpuno";
	}else if($orderfield == "birthday"){
		$orderfield = "juminno, membertype";
	}
	$dbquery="select name, nickname, juminno, org, orghref, email, photo,";
	$dbquery.="telhome, teloffice, telhand, postaddr, membertype, grade, ";
	$dbquery.="gumpuno, userid from member where membertype='��ȸ��' or membertype='��ȸ��' order by $orderfield";
	$result = mysql_query($dbquery) or die("mysql_query error");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		echo "<tr><td><a href=$PHP_SELF?mode=meminfo-one&userid=$row[14]>$row[0]</a>";
		echo "<td>$row[11]";
		if($row[11] == "��ȸ��")
			echo "($row[13])";
		echo "<td>";
		if($row[2] && substr($row[2],0,6) != "xxxxxx"){
			$birthdate = substr($row[2], 0, 2);
			$birthdate .= ".";
			$birthdate .= substr($row[2], 2, 2);
			$birthdate .= ".";
			$birthdate .= substr($row[2], 4, 2);
			echo "$birthdate";
		}
		echo "<td>$row[3]";
		echo "<td>$row[5]";
		echo "<td>$row[7]";
		echo "<td>$row[8]";
		echo "<td>$row[9]";

		echo "<td>$row[10]\n";
	}

	echo "</table>\n";
	mysql_free_result($result);
}else if($mode == "meminfo-sendmail"){
	heading("ȸ����� E-mail �߼�");

	$dbquery="select name, email from member where userid='$logid'";
	$result = mysql_query($dbquery) or die("mysql_query error");

	$row=mysql_fetch_array($result);
	$name=$row[0];
	$email=$row[1];
	mysql_free_result($result);

	echo "
<script language='JavaScript'>
offset=4;
function all(start, end)
{
	if(end == 0)
		end = document.select.elements.length-2;
	for(i = start+offset; i < end+offset;i++){
		if( ! document.select.elements[i].checked )
			document.select.elements[i].click()
//alert(document.select.elements[i].value);
	}
}
function none(start,end)
{
	if(end == 0)
		end = document.select.elements.length-2;
	for(i = start+offset; i < end+offset;i++){
		if( document.select.elements[i].checked )
			document.select.elements[i].click()
	}
}
function send()
{
	if( document.select.subject.value == ''){
		alert('������ �Է��Ͻʽÿ�.');
		document.select.subject.focus();
		return;
	}
	if( document.select.cont.value == ''){
		alert('������ �Է��Ͻʽÿ�.');
		document.select.cont.focus();
		return;
	}
	sender = '';
	for(i = offset,j = 0; i < document.select.elements.length-1;i++){
		if( document.select.elements[i].checked
		   && document.select.elements[i].value.length > 0 ){
			if( j == 0)
				sender = document.select.elements[i].value
			else
				sender = sender + ',' + document.select.elements[i].value
			j++;
		}
	}
	if( document.select.elements[3].checked)
		j++;
	if(j == 0){
		alert('���� ����� �����ϴ�. ȸ���߿��� ���Ŵ�� ȸ���� �����Ͻʽÿ�.');
	}else{
		if(confirm('' + j + '���� ������ �߼��Ͻðڽ��ϱ�?'))
			document.select.submit();
	}
}
</script>

<form name=select action='$PHP_SELF' method=POST>\n
<input type=hidden name=mode value='meminfo-sendmail2'>\n
<table><tr><td>����:<td><input type=text name=subject size=60>\n
<tr><td>����:<td><textarea wrap=auto name=cont rows=6 cols=60></textarea>\n
<tr><td colspan=2 align=center> <a href='javascript:send()'>��������</a>\n
</table>\n

<p>���� ȸ�� ����(<input type=checkbox name=memselect[] checked value='$name:$email'>������ �⺻���� ����)<p>\n
* �̸��� �ּҰ� ��ϵ� ȸ���� ��Ÿ���ϴ�.(���� ���� ������ ��Ÿ���� ����)<p>
<table border=1>";

	$mtarray = array("��ȸ��","��ȸ��","����ȸ��","�޸�ȸ��","OBȸ��");
	$myemailaddr="";
	$fullmember = 0;

for($mtype = 0; $mtype < count($mtarray); $mtype++){

	echo "<tr><td>".$mtarray[$mtype]."</td><td>";
	$dbquery="select name, email, userid, membertype from member where membertype='".$mtarray[$mtype]."' order by name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(chop($row[1]) == ""){
			$i--;
			continue;
		}

		if($row[2] == $logid){
			$i--;
			$myemailaddr=$row[1];
			continue;
		}else{
		echo "<input type=checkbox name=memselect[] value='$row[0]:$row[1]'>$row[0]��";
		}
		if(strlen($row[0]) == 4) echo "��";
		if($i%5 == 4)
			echo "<br>\n";
	}
	mysql_free_result($result);

	$endno = $i+$fullmember;
	echo "</td><td>\n
<a href='javascript:all($fullmember, $endno)'>��ü����</a>\n
<br>\n
<a href='javascript:none($fullmember, $endno)'>��ü���</a>\n
</td></tr>";
	$fullmember = $endno;
}

	echo "</table>";

	echo "<p align=center><a href='javascript:send()'>��������</a>\n";
	echo "<input type=hidden name=myemail value='$myemailaddr'>\n";
	echo "</form>";
}else if($mode == "meminfo-sendmail2"){
	heading("E-mail �߼� ó��");

	$dbquery="select name, nickname, email from member where userid='$logid'";
	$result = mysql_query($dbquery) or die("mysql_query error");

	$row=mysql_fetch_array($result);
	mysql_free_result($result);

	$no=0;

/*
	if($row[1] != "")
		$sender="\"$row[0]($row[1])\"<$row[2]>";
	else
		$sender="\"$row[0]\"<$row[2]>";

	$mailcont_file = "/tmp/emailconttmp.dat";
	while($memselect[$no]){

		$receiver = explode(":", $memselect[$no]);
		$fp = fopen($mailcont_file, "w");
		fwrite($fp, "From: $sender\n");
		fwrite($fp, "To: \"$receiver[0]�� ����\"<$receiver[1]>\n");
		fwrite($fp, "Subject: $subject\n");
		fwrite($fp, "\n");

		fwrite($fp, $cont);
		fwrite($fp, "\n");

		fclose($fp);
		$execret = exec("mail ".$receiver[1]."  < $mailcont_file");

		$no++;
		echo $receiver[0]." ";
		if(($no % 5) == 0){
			echo "<br>\n";
		}
		if(($no % 100) == 0){
//			sleep(5);
		}
	}
	chmod($mailcont_file, 0777);
	unlink($mailcont_file);
*/
	if($row[1] != "")
		$sender="$row[0]($row[1])";
	else
		$sender="$row[0]";
	$senderaddr = $row[2];

	while($memselect[$no]){

		$receiver = explode(":", $memselect[$no]);
//		mailsend($sender, $senderaddr, $receiver[0], $receiver[1], $subject, $cont);
//		echo $senderaddr." ".$sender." ".$receiver[1]." ".$receiver[0];
		$ret=zb_sendmail2(0, $receiver[1], $receiver[0], $senderaddr, $sender, $subject, $cont, $cc="", $bcc="");
		$no++;
		echo $receiver[0]." ";
		if(($no % 5) == 0){
			echo "<br>\n";
		}
		if(($no % 100) == 0){
//			sleep(5);
		}
	}
	echo "<br>$no �� ���� �߼� �Ϸ�.\n";
}else if($mode == "meminfo-slide"){
	heading("ȸ�� ���� �����̵�� ����");
	echo "
ȸ���Ե��� �󱼰�  �̸��� ������ ���� ���Դϴ�.<br>������ Ŀ���� �ø��� ȭ�� �Ʒ��� �̸��� ���ɴϴ�.
<p align=center>
<applet archive='mosaic/mosaic.jar' code='mosaic.class' width=150 height=200>
<param name=credits value='Applet by Fabio Ciucci (www.anfyteam.com)'>
<param name=regcode value='NO'>
<param name=regnewframe value='NO'>
<param name=regframename value='_blank'>
<param name=res value='1'>\n";

	$dbquery="select name, grade, gumpuno, photo, membertype from member where (membertype='��ȸ��' or membertype='��ȸ��') and photo!='' order by membertype,gumpuno,name";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$rows = mysql_num_rows($result);
	if($startno == "")
		$startno = 1;

	$i = $rows - $startno + 2;
	for($no=1; $row=mysql_fetch_array($result); $no++){
		if($i > $rows)
			$i = $i - $rows;
		if(!file_exists("../photo/$row[3]")){
			$no--;
			continue;
		}
		$photosize = GetImageSize ("../photo/$row[3]");
		if($photosize[0] != 150 || $photosize[1] != 200){
			$errorname .= $row[0]." ";
			$no--;
			continue;
		}
		$memstr="$row[4]";
		if($row[1] != '')
			$memstr .= ",$row[1]";
		if($row[4] == "��ȸ��")
			$memstr.=",��Ǫ��ȣ:$row[2]";
		echo "<param name=image$i value=\"../photo/$row[3]\">
<param name=link$i value=\"NO\">
<param name=statusmsg$i value=\"$no. $row[0]($memstr)\">\n";
		$i++;
	}

	echo "<param name=pause value='1500'>
<param name=tileswidth value=15>
<param name=tilesheight value=4>
<param name=tilesteps value=24>
<param name=backimage value='NO'>
<param name=backr value='112'>
<param name=backg value='128'>
<param name=backb value='160'>
<param name=overimg value='NO'>
<param name=overimgX value='0'>
<param name=overimgY value='0'>
<param name=memdelay value='1000'>
<param name=priority value='3'>
<param name=MinSYNC value='10'>
Sorry, your browser doesn't support Java.
</applet>";

	echo "<br><br>���� ũ��(150x200) �̻��� : ";
	if($errorname == '')
		echo "����";
	else
		echo $errorname;
	echo "<p><form method='POST' action=$PHP_SELF>
<input type=hidden name=mode value='meminfo-slide'>\n
<input type=text name=startno size=4 maxlength=3>��° ��������
<input type=submit value='�ٽ� ����'>
</form>";
}else if($mode == "submenu"){
	heading("�޴� ���� ����");
	echo "���� �޴��� �����Ͻʽÿ�.";
}

?>
</center>
</body>
</html>
