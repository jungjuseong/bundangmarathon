<?php

require("./config.php");
require("./function.php");

top("");

if($mode == "mempub-photo"){
	echo "<p><p align='center'><hr width='80%' noshade color='red'><br><img src='../../image/banner-memberinfo.jpg'
 width='500' height='50' border='0'><p align='center'><hr width='80%' noshade color='red'>";

	echo "<p><table width=80%><tr><td>
<p>źõ��Ǫ ȸ������ ���� �� ���ͳ��� ����� ������ �ְ� �޽��ϴ�.
�̸��� ������ �����ϰ�, Ǯ�ڽ��� �پ��ų� ������ Ǯ�ڽ��� �ٰ��� �ϴ�
������ �ִ� �������� ����ϴ� ����̶�� ������ ������ �����մϴ�. </p>
	<p>ȸ������ ���� ������ ���� ���Դϴ�.
<!--
<p><a href='/member/subscribe.html'>�д� źõ��Ǫ ������ Ŭ�� ȸ�� ���� �ȳ�</a> </p>
<p>ȸ�� �Ա� ���� : �������� 079-21-0501-216(����ö)</p>
-->
<p>������ �� ȸ�� ����Դϴ�. ���� ������ �ִ� ȸ���� <a href='mailto:san2run@hanmir.com'>Ȩ������
��翡�� ����</a> ���� �ֽñ� �ٶ��ϴ�.
</td></tr></table><p>";

	$rowmemno = 5;
	$dbquery = "select userid, name, photo, grade, gumpuno, boston from member";
	$dbquery .= " where membertype='��ȸ��' order by disporder, gumpuno";
	$result = mysql_query($dbquery) or die("mysql_query error1");

	echo "<table border=1><tr><td colspan=$rowmemno align=center style='font-size:20'>��ȸ��</td></tr>";
	$tmp = "";
	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";
		if($row[3])
			$tmp = "$row[3]";
		echo "<td align=center>";
		echo "<a href='$PHP_SELF?mode=mempub-one&userid=$row[0]'>";
		echo "$row[1]($row[4])";
		if($row[3])
			echo "<br>$row[3]";
		else if($tmp)
			echo "<br>";
/*
		$dbquery2 = "select record from record";
		$dbquery2 .= " where userid='$row[0]' and item='Ǯ' and record != '' order by record limit 1";
		$result2 = mysql_query($dbquery2) or die("mysql_query error2");
		$row2=mysql_fetch_array($result2);
		if($row2[0] != ""){
			echo "<br>$row2[0]";
		}else{
			echo "<br>";
		}
*/
		echo "<br><img src='../photo/$row[2]' border=0>";
/*
		if($row[5] != ""){
			echo "<br>";
			bostonrace($row[5], "20");
		}
		mysql_free_result($result2);
*/
		echo "</a>";
		echo "</td>\n";
		if(($i % $rowmemno) == ($rowmemno - 1)){
			echo "</tr>";
			$tmp = "";
		}
	}
	echo "<tr><td colspan=$rowmemno align=center>��ȸ�� �� $i ��</td></tr></table><br><br>\n";
	mysql_free_result($result);

	echo "<table border=1><tr><td colspan=$rowmemno align=center style='font-size:20'>��ȸ��</td></tr>";
	$dbquery = "select userid, name, photo, grade, boston from member";
	$dbquery .= " where membertype='��ȸ��' order by disporder, name";
	$result = mysql_query($dbquery) or die("mysql_query error3");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";
		echo "<td align=center>";
		echo "<a href='$PHP_SELF?mode=mempub-one&userid=$row[0]'>";
		echo "$row[1]";
		if($row[3])
			$tmp = "<br>($row[3])";
		else
			$tmp = "";
		echo "$tmp";
/*
		$dbquery2 = "select record from record";
		$dbquery2 .= " where userid='$row[0]' and item='Ǯ' and record != '' order by record limit 1";
		$result2 = mysql_query($dbquery2) or die("mysql_query error2");
		$row2=mysql_fetch_array($result2);
		if($row2[0] != ""){
			echo "<br>$row2[0]";
		}else{
			echo "<br>";
		}
*/
		echo "<br><img src='../photo/$row[2]' border=0>";
/*
		if($row[4] != ""){
			echo "<br>";
			bostonrace($row[4], "20");
		}
		mysql_free_result($result2);
*/
		echo "</a>";
		echo "</td>\n";
		if(($i % $rowmemno) == ($rowmemno - 1))
			echo "</tr>";
	}
	mysql_free_result($result);

	echo "<tr><td colspan=$rowmemno align=center>��ȸ�� �� $i ��</td></tr>";
	echo "</table><br><br>";

	echo "<table border=1><tr><td colspan=$rowmemno align=center style='font-size:20'>����ȸ��</td></tr>";
	$dbquery = "select userid, name from member";
	$dbquery .= " where membertype='����ȸ��' order by disporder, name";
	$result = mysql_query($dbquery) or die("mysql_query error4");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";
		echo "<td align=center><a href='$PHP_SELF?mode=mempub-one&userid=$row[0]'>$row[1]</a></td>\n";
		if(($i % $rowmemno) == ($rowmemno - 1))
			echo "</tr>";
	}
	mysql_free_result($result);

	echo "<tr><td colspan=$rowmemno align=center style='font-size:20'>�޸�ȸ��</td></tr>";
	$dbquery = "select userid, name, photo, gumpuno from member";
	$dbquery .= " where membertype='�޸�ȸ��' order by disporder, name";
	$result = mysql_query($dbquery) or die("mysql_query error5");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";
		if($row[3])
			$tmp = "($row[3])";
		else
			$tmp = "";
		echo "<td align=center>";
		echo "<a href='$PHP_SELF?mode=mempub-one&userid=$row[0]'>";
#		echo "$row[1]$tmp";
		echo "$row[1]";
/*
		$dbquery2 = "select record from record";
		$dbquery2 .= " where userid='$row[0]' and item='Ǯ' and record != '' order by record limit 1";
		$result2 = mysql_query($dbquery2) or die("mysql_query error2");
		$row2=mysql_fetch_array($result2);
		if($row2[0] != "")
			echo "<br>$row2[0]";
		else
			echo "<br>";
		mysql_free_result($result2);
*/
		echo "<br><img src='../photo/$row[2]' border=0>";
		echo "</a></td>\n";
		if(($i % $rowmemno) == ($rowmemno - 1))
			echo "</tr>";
	}
	mysql_free_result($result);

	echo "<tr><td colspan=$rowmemno align=center style='font-size:20'>OBȸ��</td></tr>";
	$dbquery = "select userid, name, photo, gumpuno from member";
	$dbquery .= " where membertype='OBȸ��' order by disporder, name";
	$result = mysql_query($dbquery) or die("mysql_query error6");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";
		if($row[3])
			$tmp = "($row[3])";
		else
			$tmp = "";
		echo "<td align=center>";
		echo "<a href='$PHP_SELF?mode=mempub-one&userid=$row[0]'>";
#		echo "$row[1]$tmp";
		echo "$row[1]";
/*
		$dbquery2 = "select record from record";
		$dbquery2 .= " where userid='$row[0]' and item='Ǯ' and record != '' order by record limit 1";
		$result2 = mysql_query($dbquery2) or die("mysql_query error2");
		$row2=mysql_fetch_array($result2);
		if($row2[0] != "")
			echo "<br>$row2[0]";
		else
			echo "<br>";
		mysql_free_result($result2);
*/
		echo "<br><img src='../photo/$row[2]' border=0>";
		echo "</a></td>\n";
		if(($i % $rowmemno) == ($rowmemno - 1))
			echo "</tr>";
	}
	mysql_free_result($result);

	echo "</table>\n";
}else if($mode == "mempub-one"){
	echo "<br><br><hr width='80%' noshade color='red'><br><img src='../../image/banner-memberinfo.jpg'
 width='500' height='50' border='0'><br><br><hr width='80%' noshade color='red'>";

	$dbquery="select name, nickname, juminno, org, orghref, email, photo,";
	$dbquery.="telhome, teloffice, telhand, postaddr, membertype, grade, ";
	$dbquery.="gumpuno, etc, boston from member where userid='$userid'";
	$result = mysql_query($dbquery) or die("mysql_query error7");
	$row=mysql_fetch_array($result);

	$name = $row[0];
	$membertype = $row[11];
	echo "<table align='center' border=1>\n";
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
/*
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
*/
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
	echo "<tr><td>E-mail<td>$row[5]\n";
	if($membertype != "����ȸ��")
		echo "<tr><td>����<td><img src='../photo/$row[6]' border=0>";
	if($row[15] != "")
		bostonrace($row[15], "0");
	echo "\n";

	$addr=$row[10];
	if(($pos = strstr($addr, "�� ")) != false){
		$addr=substr($addr,0,strlen($addr)-strlen($pos)+2);
	}else if(($pos = strstr($addr, "�� ")) != false){
		$addr=substr($addr,0,strlen($addr)-strlen($pos)+2);
	}else if(($pos = strstr($addr, "���� ")) != false){
		$addr=substr($addr,0,strlen($addr)-strlen($pos)+4);
	}else if(($pos = strstr($addr, "���� ")) != false){
		$addr=substr($addr,0,strlen($addr)-strlen($pos)+4);
	}else if(($pos = strstr($addr, "���� ")) != false){
		$addr=substr($addr,0,strlen($addr)-strlen($pos)+4);
	}else if(($pos = strstr($addr, "����Ʈ ")) != false){
		$addr=substr($addr,0,strlen($addr)-strlen($pos)+6);
	}else if(($pos = strstr($addr, "APT ")) != false){
		$addr=substr($addr,0,strlen($addr)-strlen($pos)+3);
	}else if(($pos = strrpos($addr, " ")) != false){
		$addr=substr($addr,0,$pos);
	}else{

	}
//	$addr="";
	echo "<tr><td>�ּ�<td>$addr\n"; // $row[10]
	echo "<tr><td>�Ұ�<td>$row[14]\n";
	echo "</table>\n";

	if($membertype == "����ȸ��")
			die("");

	echo "<br><br>\n";
	require("./func_nextimg.php");

	if(nextimg($name) == 0){
		echo "<p align=center style='color:red;'>��ȸ ���� ������ �����ϴ�.<br>���� ������ ��� ���� �ֽʽÿ�.\n";
	}

	echo "<br><br><table align='center' border=1><tr><th colspan=5>���� ���</tr>\n";
	echo "<tr><th>��ȸ��";
    	if($orderfield == "raceday"){
		echo "<th>��¥\n";
	}else{
		echo "<th><a href='$PHP_SELF?mode=mempub-one&userid=$userid&orderfield=raceday'>��¥</a>\n";
	}
	if($orderfield == "item"){
		echo "<th>����\n";
	}else{
		echo "<th><a href='$PHP_SELF?mode=mempub-one&userid=$userid&orderfield=item'>����</a>\n";
	}
	if($orderfield == "" or $orderfield == "record"){
		echo "<th>���\n";
	}else{
		echo "<th><a href='$PHP_SELF?mode=mempub-one&userid=$userid&orderfield=record'>���</a>\n";
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
	$dbquery .= " from race,record where record.userid='$userid' and (record.record != '' and record.record is not null) and record.dispyn='Y' and record.raceid=race.raceid order by ".$orderfield;
	$result = mysql_query($dbquery) or die("mysql_query error8");

	echo "<th>����<th>��Ÿ</tr>";
	while($row=mysql_fetch_array($result)){
		echo "<tr><td>$row[1] <td>$row[2] <td>$row[3]";
		echo "<td>$row[4]<td>$row[5]<td>$row[7]\n";
	}
	echo "</tr></table>";

	mysql_free_result($result);

}else if($mode == "mempub-subscribe-input"){
	heading("ȸ�����Խ�û");

	echo "<table border=1>";
	JScheckLength();
echo "
<form action='$PHP_SELF' method=post>\n
<input type=hidden name=mode value='mempub-subscribe-insert'>\n
";
	echo "
<tr><td>�����ID*</td><td><input type=text name=userid maxlength=12 size=12> �����ҹ���/���ڷ� �ۼ�(�������ϸ� ���� ������)</td></tr>\n
<tr><td>��ȣ*</td><td><input type=password name=passwd maxlength=10 size=10>\n
&nbsp;&nbsp;&nbsp;��ȣȮ��*<input type=password name=passwd2 maxlength=10 size=10></td></tr>\n";

	echo "
<tr><td>�̸�*</td><td><input type=text name=name maxlength=10 size=10></td></tr>\n
<tr><td>����</td><td>
<input type='radio' name='sex' value='M' checked>��(Male)
<input type='radio' name='sex' value='F'>��(Female)
</td></tr>\n";

echo "
<tr><td>�ֹε�Ϲ�ȣ*</td><td><input type=text name=juminno maxlength=14 size=15> (123456-1234567)</td></tr>\n
<tr><td>�����</td><td><input type=text name=org maxlength=30 size=30 onChange='return checkLength(this.value,30)'></td></tr>\n
<tr><td>����Ȩ�ּ�</td><td><input type=text name=orghref maxlength=50 size=40 onChange='return checkLength(this.value,50)'> (��: http://www.xxx.yyy.kr)</td></tr>\n
<tr><td>E-Mail �ּ�*</td><td><input type=text name=email maxlength=30 size=30 onChange='return checkLength(this.value,30)'></td></tr>\n
<tr><td>�����ȣ</td><td><input type=text name=postno maxlength=7 size=8></td></tr>\n
<tr><td>�ּ�</td><td><input type=text name=postaddr maxlength=60 size=40 onChange='return checkLength(this.value,60)'></td></tr>\n
";

	echo "
<tr><td>��ȭHome</td><td><input type=text name=telhome maxlength=15 size=20></td></tr>\n
<tr><td>��ȭOffice</td><td><input type=text name=teloffice maxlength=15 size=20></td></tr>\n
<tr><td>��ȭHand</td><td><input type=text name=telhand maxlength=15 size=20></td></tr>\n";


	echo "
<tr><td>���� �Ұ�</td><td><input type=text name=etc maxlength=80 size=40 onChange='return checkLength(this.value,80)'> (�ѱ� 40�� �̳�)</td></tr>\n
<tr><td colspan=2 align=center><input type=submit value='���Խ�û'>\n
<p>3���� ���� ��ȸ�� �ڰ��� ������ ���ϸ� �Է��� �ڷ�� ���Ƿ� ������ �� �ֽ��ϴ�.\n
</form>";
	echo "</table>";
}else if($mode == "mempub-subscribe-insert"){
	heading("�ű� ȸ�� ���");

	if($userid == "" || $passwd == "" || $name == "" || $juminno == "" || $email == ""){
		echo "<font color=red size='+2'>�ڷ� �Է� �̻�</font><p>\n";
		echo "�����ID, ��ȣ, �̸�, �������, E-Mail �ּ� ���� �����ϴ�.<br><br>";
		echo "<a href='javascript:history.back();'>�ڷ�</a>";
		die("");
	}
	for($i=0; $i < strlen($userid); $i++){
		$onechar = substr($userid,$i,1);
		if($i == 0 && ($onechar < "a" || $onechar > "z") ||
			$onechar < "0" || $onechar > "z"){
			echo "<font color=red size='+2'>�ڷ� �Է� �̻�</font><p>\n";
			echo "�����ID�� ���� �ҹ��ڷ� �����ϰ� ���� �ҹ��ڳ� ���ڷ� �����˴ϴ�.";
			echo "<a href='javascript:history.back();'>�ڷ�</a>";
			die("");
		}
	}
	if($passwd != $passwd2){
		echo "��ȣ�� ���� Ʋ���ϴ�.<p>";
			echo "<a href='javascript:history.back();'>�ڷ�</a>";
			die("");
	}
	if(strstr($passwd, "'") != false){
		echo "��ȣ�� �ش� Ư�����ڸ� ����� �� �����ϴ�.";
			echo "<a href='javascript:history.back();'>�ڷ�</a>";
			die("");
	}
	$dbquery="select userid, name from member where userid='$userid'";
	$result = mysql_query($dbquery) or die("mysql_query error9");
	$rows = mysql_num_rows($result);
	if($rows == 1){
		$row=mysql_fetch_array($result);
		echo "ID�� �ٸ� ȸ��($row[1])�� �ߺ��Դϴ�.<br><br>";
		echo "<a href='javascript:history.back();'>�ڷ�</a>";
		die("");
	}
	mysql_free_result($result);

/* �ִ� �Ϸ� ��� �Ǽ� 10�� ���� */
	$timenow = time();
	$currentday = date("Y/m/d", $timenow);
//echo "currentday=$currentday";

	$dbquery="select userid, name, photo from member where nickname='$currentday' and photo >= '0' and photo <= '99' order by photo desc";
	$result = mysql_query($dbquery) or die("mysql_query error10");
	$rows = mysql_num_rows($result);
	if($rows >= 1){
		$row=mysql_fetch_array($result);
		$maxno = $row[2];
		if($maxno >= '9'){
			echo "�űԵ���� �ʹ� �����ϴ�. ���� �ٽ� �Ͻʽÿ�.<br><br>";
			echo "<a href='javascript:history.back();'>�ڷ�</a>";
			die("");
		}
		$maxno++;
	}else{
		$maxno = "0";
	}

	$query_name="";
	$query_value="";

	$query_name.="userid,";
	$query_value.="'".$userid."',";

	$query_name.="passwd,";
	$query_value.="'".$passwd."',";

	$name = str_replace(" ", "", $name);
	$query_name.="name,";
	$query_value.="'".$name."',";

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

	$query_name.="membertype,";
	$query_value.="'����ȸ��',";

	if($disporder == "")
		$disporder = "99";
	$query_name.="disporder,";
	$query_value.="'".$disporder."',";

	$query_name.="nickname,";
	$query_value.="'".$currentday."',";
	$query_name.="photo,";
	$query_value.="'".$maxno."',";

	$query_name.="indate,";
	$query_value.="'".$currentday."',";

	$query_name.="etc";
	$query_value.="'".$etc."'";

	$dbquery="insert into member ($query_name) values($query_value)";
//echo "qbquery=$dbquery";
	$result = mysql_db_query("coretek",$dbquery);

	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "��� �����Դϴ�.<br>";
		echo "<a href='javascript:history.back();'>�ڷ�</a>";
		die("");
	}else{
		echo "����ȸ������ ��� ó�� �Ϸ�.<br><br>";
		echo "���� ������ �ѹ����� ���Ϸ� ���޵˴ϴ�.<br><br>";
		echo "��ȸ�� ����� ���� �� �ѹ��� ��ȸ������ ����ϸ�<br>ȸ������ �̿��� �����մϴ�.\n";

		$cont = "ȸ�����忡�� �ű� ���� ��û�� �Ͽ����ϴ�.\n\n";
		$cont.= "�̸�: $name\nID: $userid\n����: $sex\n�������: $juminno\n";
		$cont.= "�Ҽ�: $org\nE-mail: $email\n�ּ�: $postaddr\n";
		$cont.= "Tel Home: $telhome\nTel Office: $teloffice\nTel Hand: $telhand\n";
		$cont.= "���ԼҰ�: $etc\n";
		mailsend($name, $email, "źõ��Ǫ�ѹ�", $managerEmail, "�ű� ���� ��û - $name", $cont);
	}

}

?>
<p>&nbsp;</p>
</center>
</body>
</html>
