<?php

require("./bmauth.php");
require("./bmconfig.php");
require("./bmfunction.php");

top("");

if($mode == "record-input"){
	heading("��� �ű� ���");

	echo "<p><font color=blue>������û�� ���� ��� ���</font><p>\n";
	$dbquery="select record.userid, record.raceid, race.name, record.item, member.name from record, member, race ";
	$dbquery .= "where record.userid='$logid' and (record.record = '' or record.record is null) and ";
	$dbquery .= "replace(race.raceday, '/', '-') <= current_date and ";
	$dbquery .= "record.userid=member.userid and record.raceid=race.raceid order by record.nickname, record.item, member.name";
	$result = mysql_query($dbquery) or die("mysql_query error");
	for($i=0; $row=mysql_fetch_array($result); $i++){
		record_display("record-update",  $row[0], $row[1], $row[2], $row[3], "", "", "", "", "");
	}
	if($i == 0){
		echo "��� ��� ������ ��ȸ ����";
	}
	mysql_free_result($result);

	echo "<p><font color=blue>������û���� ���� ���� ��� ���</font><br>\n";
	echo "�Ʒ��� ������ ��ȸ�� ������ ��ȸ�������� �űԵ�� �ٶ��ϴ�.)\n<p>";
	record_display("record-insert",  $logid, 0, "input", "", "", "", "", "", "");
	mysql_close() or die("mysql_close error");
}else if($mode == "record-managerinput"){
	heading("��� �ű� ���");

	$dbquery="select record.userid, record.raceid, record.nickname, record.item, member.name from record, member where ";
	$dbquery .= "record.userid='$logid' and ";
	$dbquery .= "(record.record = '' or record.record is null) and record.userid=member.userid order by record.nickname, record.item, member.name";
	$result = mysql_query($dbquery) or die("mysql_query error");
	while($row=mysql_fetch_array($result)){
		record_display("record-update",  $row[0], $row[1], $row[2], $row[3], $row[4], "", "", "", "");
	}
	mysql_free_result($result);
	if(privcheck($logid) == 2){
		echo "<p><font color=blue>���ϴ� �������̹Ƿ� ������ �ٸ� ȸ�� ��� �Էµ� �����մϴ�.</font><br>\n";
		$dbquery="select record.userid, record.raceid, record.nickname, record.item, member.name from record, member where ";
		$dbquery .= "record.userid != '$logid' and ";
		$dbquery .= "(record.record = '' or record.record is null) and record.userid=member.userid order by record.nickname, record.item, member.name";
		$result = mysql_query($dbquery) or die("mysql_query error");
		while($row=mysql_fetch_array($result)){
			record_display("record-update",  $row[0], $row[1], $row[2], $row[3], $row[4], "", "", "", "");
		}
		mysql_free_result($result);
	}
	mysql_close() or die("mysql_close error");
}else if($mode == "record-change"){
	heading("��� ���� ����");

	if(privcheck($logid) < 2 || $userid == "")
		$userid = $logid;
	$dbquery="select userid, raceid, nickname, item, record, rank, dispyn, etc from record where raceid=$raceid and userid='$userid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	for($i = 0; $row=mysql_fetch_array($result); $i++){
		record_display("record-update",  $row[0], $row[1], $row[2], $row[3], "", $row[4], $row[5], $row[6], $row[7]);
		echo "<p>\n";
	}
	if($i == 0){
		echo "<tr><td>'$name' ��ȸ�� ã�� ���� �����ϴ�.</td></tr>";
	}
	mysql_free_result($result);
	mysql_close() or die("mysql_close error");
}else if($mode == "record-insert"){
	heading("��� ���� �ű� ���");

	if($item=="etc" && $itemetc == ""){ 
		errornback("�Ÿ��� �Է��Ͻʽÿ�.");
		die();
	}
	$record = chop($record);
	if(strlen($record) < 7){ 
		errornback("����� ��:��:�ʷ� ������ '1:23:45'�� ���� �Է��Ͻʽÿ�.");
		die();
	}
	$query_name="";
	$query_value="";

	if(privcheck($logid) < 2 || $userid == "")
		$userid = $logid;
	$query_name.="userid";
	$query_value.="'".$userid."'";
	$query_name.=",raceid";
	$query_value.=",".$raceid;

	$query_name.=",item";
	if($item=="etc"){
		if($itemetc=="10km")
			$itemetc = '10Km';
		else if($itemetc=="5km")
			$itemetc = '5Km';
		else
			$itemetc = strtolower($itemetc);
		$query_value.=",'".$itemetc."'";
	}else
		$query_value.=",'".$item."'";

	$record = setrecord($record);
	$query_name.=",record";
	$query_value.=",'".$record."'";

	$query_name.=",rank";
	$query_value.=",'".$rank."'";

	$query_name.=",dispyn";
	$query_value.=",'".$dispyn."'";

	$query_name.=",etc";
	$query_value.=",'".$etc."'";

	$date = getdate();
	$yyyymmdd = $date['year']."-".$date['mon']."-".$date['mday'];
	$query_name.=",makedate";
	$query_value.=",'".$yyyymmdd."'";

	if($nickname == ""){
		$dbquery="select nickname from race where raceid=$raceid";
		$result = mysql_query($dbquery) or die("mysql_query error");
		$row=mysql_fetch_array($result);
	}
	$query_name.=",nickname";
	$query_value.=",'".$row[0]."'";
//if($item == "Ǯ"){	// Ǯ,����,10Km,5Km �� ����
	$raceday = getRaceDay($raceid);
	if($raceday != ""){
		$openrecord = calcOpenRecord($raceday,$userid,$record,$item);

		$query_name.=",openrecord";
		$query_value.=",'".$openrecord."'";
	}
//}

//echo "query_name=".$query_name."<br>";
//echo "query_value=".$query_value."<br>";
	$dbquery="insert into record ($query_name) values($query_value)";

	$result = mysql_query($dbquery);

	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		$dbquery="update record set record='$record',rank='$rank',etc='$etc',dispyn='$dispyn' ";
		if($item=="etc")
			$dbquery.=",item='$itemetc' ";
		else
			$dbquery.=",item='$item' ";
		$dbquery.="where raceid=$raceid and userid='$userid' ";
//echo "query=$dbquery<br>";
		$result = mysql_query($dbquery);
		if($result!="1"){
			echo "�̹� ����Ͻ� ��ȸ�Դϴ�.<br>";
			echo "��ȸ ��Ī�� Ȯ�� �ٶ��ϴ�.";
			die("");
		}else{
			echo "��� ���� ó�� �Ϸ�.<br>";
		}
	}else{
		echo "��� ��� ó�� �Ϸ�.<br>";
	}

}else if($mode == "record-delete"){
	heading("��� ���� ����");
	$dbquery="delete from record where raceid=$raceid and userid='$userid' and item='$item'";
	$result = mysql_query($dbquery) or die("mysql_query error");

	if($result=="1"){
		echo "��� ���� �Ϸ�";
	}else{
		echo "<font color=red>��� ���� ����</font>";
	}
}else if($mode == "record-update"){
	heading("��� ���� ���� �Ϸ�");

	$record = setrecord($record);

//if($item == "Ǯ"){	// Ǯ,����,10Km,5Km �� ����
	$raceday = getRaceDay($raceid);
	if($raceday != ""){
		$openrecord = calcOpenRecord($raceday,$userid,$record,$item);
	}
//}
	$dbquery="update record set ";
	if($item=="etc")
		$dbquery.="item='".$itemetc."'";
	else
		$dbquery.="item='".$item."'";
	$dbquery.=",record='".$record.
		"',rank='".$rank."',dispyn='".$dispyn."',etc='".$etc."'";
	$dbquery.=",openrecord='".$openrecord."'";
	$dbquery.=" where raceid=$raceid and userid='$userid' and item='$itemold'";
//echo "dbquery=".$dbquery;
	$result = mysql_query($dbquery) or die("mysql_query error");

	if($result=="1"){
		echo "��� ��� �Ϸ�";
	}else{
		echo "<font color=red>��� ��� ����</font>";
	}
}else if($mode == "record-openrecord"){
	heading("Open ȯ�� ��� ���");
	$raceday = getRaceDay($raceid);
	echo "<font size='+2'>$racenickname($raceday)</font>";
	if($raceday == ""){
		die("��ȸ���ڰ� �����ϴ�.");
	}
	$dbquery="select userid,record,item from record where raceid=$raceid and (item='Ǯ' or item='����' or item='10Km' or item='5Km') and length(record) >=7 order by record";
	$result = mysql_query($dbquery) or die("mysql_query error");
	echo "<table border=1><tr><th>��ȣ<th>UserID<th>���<th>Openȯ����\n";
	for($i=0; $row=mysql_fetch_array($result); $i++){

		$openrecord = calcOpenRecord($raceday,$row[userid],$row[record],$row[item]);
//echo "$row[0]-openrecord=$openrecord ";
		if($openrecord != ""){
			$dbquery="update record set openrecord='$openrecord' where raceid=$raceid and userid='$row[0]' ";
//echo "query=$dbquery<br>";
			$result2 = mysql_query($dbquery);
			if($result2 != "1"){
				echo "Open ȯ�� ��� ���� ����.";
				die("");
			}
		}else{
			$openrecord = '���Ұ�';
		}
		echo "<tr><td>".($i+1)."<td>$row[0]<td>$row[1]<td>$openrecord\n";
	}

	echo "</table><p>Open ȯ�� ��� ���� �Ϸ�";
	echo "<br><br><a href='/bbs/bminviting.php?mode=record-list2&raceid=$raceid&order=record'>���ư���</a>";
}else if($mode == "record-list"){
	if(privcheck($logid) < 2 || $userid == "")
		$userid = $logid;
	$dbquery="select name from member where userid='$userid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$name=mysql_fetch_array($result);
	mysql_free_result($result);

	heading("$name[0] ��� ���");

	echo "<table><tr><td><br>Ÿ ȸ�� ��� ��ȸ
<form action='$PHP_SELF' method=post>\n
<input type=hidden name=mode value='$mode'>\n";
		$dbquery="select userid, name from member order by name";
		$result = mysql_query($dbquery) or die("mysql_query error");
		echo "<td><select name='userid' size='1'  style='background-color: white; color: blue; font:10pt'>\n";

		while($row=mysql_fetch_array($result)){
			echo "<option value='$row[0]'";
			if($row[1] == $name[0])
				echo " selected";
			echo ">$row[1]</option>\n";
		}
		echo "</select>\n";
		mysql_free_result($result);
	echo "<td><br>
<input type=submit value='��� ��ȸ'>\n
</form>\n
</table>\n";
	echo "<p><table border=1><tr><th>No<th>��ȸ��\n";
	if($orderfield == "" or $orderfield == "raceday"){
		echo "<th>��¥\n";
	}else{
		echo "<th><a href='$PHP_SELF?mode=record-list&orderfield=raceday&userid=$userid'>��¥</a>\n";
	}
	if($orderfield == "item"){
		echo "<th>����\n";
	}else{
		echo "<th><a href='$PHP_SELF?mode=record-list&orderfield=item&userid=$userid'>����</a>\n";
	}
	if($orderfield == "record"){
		echo "<th>���\n";
	}else{
		echo "<th><a href='$PHP_SELF?mode=record-list&orderfield=record&userid=$userid'>���</a>\n";
	}
	echo "<th>����<th>����<th>��Ÿ<td>���� ���</tr>";
	if($orderfield == "" or $orderfield == "raceday"){
		$orderfield = "race.raceday desc";
	}else if($orderfield == "item"){
		$orderfield = "itemnew, race.raceday desc";
	}else if($orderfield == "record"){
		$orderfield = "itemnew, record.record";
	}
	$dbquery="select race.raceid, race.nickname, race.raceday, record.item, record.record, record.rank, record.dispyn, record.etc";
	$dbquery .= ", IF( record.item='Ǯ', 1, IF( record.item='����', 2, IF( record.item='10Km', 3, IF( record.item='5Km', 4, 5)))) as itemnew";
	$dbquery .= ",record.openrecord";
	$dbquery .= " from race,record where record.raceid=race.raceid and record.userid='$userid' and (record.record != '' and record.record is not null) order by ".$orderfield;
	$result = mysql_query($dbquery) or die("mysql_query error");

	$racecount = array("Ǯ"=>0, "����"=>0, "10Km"=>0, "5Km"=>0);
	$raceother = 0;
	for($i = 1; $row=mysql_fetch_array($result); $i++){
		echo "<tr><td>$i<td><a href='bminviting.php?mode=record-list2&raceid=$row[0]'>$row[1]</a> <td>$row[2] <td>$row[3]";
		echo "<td><a href='$PHP_SELF?mode=record-change&raceid=$row[0]&userid=$userid'>$row[4]</a>\n";
		echo "<td>$row[5] <td>$row[6] <td>$row[7]<td>$row[9]\n";
		$item = $row[3];
		if($item == "Ǯ" or $item == "����" or $item == "10Km" or $item == "5Km")
			array($racecount[$item]++);
		else
			$raceother++;
	}
	echo "</tr></table>";
	mysql_free_result($result);

	echo "<p>��ü ";
	while (list($k,$v) = each($racecount)) {
		echo "$k : $v ȸ, ";
        }
	echo "��Ÿ : $raceother ȸ";

}else if($mode == "record-racecount"){
	heading("Ŭ�� ��� ����(".date("Y-m-d").")");

	echo "<font color=red>ȸ���� ��ȸ ���� ȸ�� �� �ְ���</font> ��ϰ� <font color=red>Ŭ�� ��/��/��ü ��� ���</font>�Դϴ�.<p>";

	if($year == "")
		$year = "2000";
	echo "* ��ȸ��, ��ȸ�� �� ����� ��ϵ� ȸ�� ����Դϴ�.<p>";
	echo "<form action=$PHP_SELF>
<input type=hidden name=mode value='$mode'>
<input type=text name=year value='$year' maxlength=10 size=4>�� ���� ��ȸ ����
<input type=submit value='Ŭ���������'></form>\n";
	echo "<table border=1><tr><th rowspan=2>��ȣ<th rowspan=2>�̸�<th colspan=2 align=center width=60>Ǯ<th colspan=2 align=center width=60>����<th colspan=2 align=center width=60>10Km<th colspan=2 align=center width=60>5Km<th rowspan=2 align=center width=60>��Ÿ<th rowspan=2>��Ÿ �Ÿ�";
	echo "<tr> <td>ȸ<td>�ְ��� <td>ȸ<td>�ְ��� <td>ȸ<td>�ְ��� <td>ȸ<td>�ְ���";
	$dbquery="select member.name, record.userid, record.item, record.record, record.dispyn,member.sex";
	$dbquery .= ", IF( record.item='Ǯ', 1, IF( record.item='����', 2, IF( record.item='10Km', 3, IF( record.item='5Km', 4, 5)))) as itemnew";
	$dbquery .= ",record.openrecord";
//	$dbquery .= " from member,record where member.membertype in ('��ȸ��', '��ȸ��') and member.userid=record.userid and (record.record != '' and record.record is not null) order by member.name,itemnew,record.record";
	$dbquery .= ",record.nickname from member,record,race where member.membertype in ('��ȸ��', '��ȸ��') and member.userid=record.userid and (record.record != '' and record.record is not null) and race.raceid=record.raceid and race.raceday >= '$year' order by member.name,itemnew,record.record";
	$result = mysql_query($dbquery) or die("mysql_query error");

	$oldname = "";
	$olduserid = "";
	$racecount = array("Ǯ"=>0, "����"=>0, "10Km"=>0, "5Km"=>0);
	$racebestrecord = array("Ǯ"=>"", "����"=>"", "10Km"=>"", "5Km"=>"");
	$recordsum = array(
			"M"=>array("Ǯ"=>array("count"=>0,"record"=>0),
				   "����"=>array("count"=>0,"record"=>0),
				   "10Km"=>array("count"=>0,"record"=>0),
				   "5Km"=>array("count"=>0,"record"=>0)),
			"F"=>array("Ǯ"=>array("count"=>0,"record"=>0),
				   "����"=>array("count"=>0,"record"=>0),
				   "10Km"=>array("count"=>0,"record"=>0),
				   "5Km"=>array("count"=>0,"record"=>0))
		);
	$recordtopname = array(
		"M"=>array("Ǯ"=>"", "����"=>"", "10Km"=>"", "5Km"=>""),
		"F"=>array("Ǯ"=>"", "����"=>"", "10Km"=>"", "5Km"=>"")
		);
	$recordtop = array(
		"M"=>array("Ǯ"=>"", "����"=>"", "10Km"=>"", "5Km"=>""),
		"F"=>array("Ǯ"=>"", "����"=>"", "10Km"=>"", "5Km"=>"")
		);
	$no = 0;
	while($row=mysql_fetch_array($result)){
		$name = $row[0];
		$userid = $row[1];
		$item = $row[2];
		$sex = $row[5];
		if($userid != $olduserid){
			if($oldname != ""){
				echo "<tr><td>$no<td><a href='bmmeminfo.php?mode=meminfo-one&userid=$olduserid'>$oldname</a>";
				reset($racecount);
				while (list($k,$v) = each($racecount)) {
					if($racecount[$k] >= 1){
						echo "<td>$v";
						if($k == "Ǯ" and $racebestrecord[$k] < "3")
							echo "<td><font color=red>$racebestrecord[$k]</font>";
						else
							echo "<td>$racebestrecord[$k]";
						$recordsum[$oldsex][$k]["count"]++;
						$recordsum[$oldsex][$k]["record"] += hms2sec($racebestrecord[$k]);
					}else
						echo "<td><td>";
				}
				if($raceother > 0){
					echo "<td>$raceother<td>$raceothername";
				}else{
					echo "<td><td>";
				}
			}
			$racecount["Ǯ"]=0;
			$racecount["����"]=0;
			$racecount["10Km"]=0;
			$racecount["5Km"]=0;
			$raceother = 0;
			$raceothername = "";
			$oldname = $name;
			$olduserid = $userid;
			$oldsex = $sex;
			$no++;
		}
		if($item == "Ǯ" || $item == "����" || $item == "10Km" || $item == "5Km"){
			$racecount[$item]++;
			if($racecount[$item] == 1){	// best record by sorting
				$racebestrecord[$item] = $row[3] . "," . $row[8];
			}
			if($recordtop[$sex][$item] > $row[3] || $recordtop[$sex][$item] == ""){
				$recordtop[$sex][$item] = $row[3];
				$recordtopname[$sex][$item] = $name;
			} 
		}else{
			$raceother++;
			if(strstr($raceothername, $item." ") == false)
				$raceothername .= $item." ";
		}
	}
	{
				echo "<tr><td>$no<td><a href='bmmeminfo.php?mode=meminfo-one&userid=$olduserid'>$oldname</a>";
				reset($racecount);
				while (list($k,$v) = each($racecount)) {
					if($racecount[$k] >= 1){
						echo "<td>$v";
						if($k == "Ǯ" and $racebestrecord[$k] < "3")
							echo "<td><font color=red>$racebestrecord[$k]</font>";
						else
							echo "<td>$racebestrecord[$k]";
						$recordsum[$oldsex][$k]["count"]++;
						$recordsum[$oldsex][$k]["record"] += hms2sec($racebestrecord[$k]);
					}else
						echo "<td><td>";
				}
				if($raceother > 0){
					echo "<td>$raceother<td>$raceothername";
				}else{
					echo "<td><td>";
				}
	}
	echo "</tr></table>";
	echo "<p><font size='+2'>ȸ���� �ְ��� ���� Ŭ�� ��� ���</font><p>";
	echo "
<table border=1>
<tr><th rowspan=2>����<th colspan=2>Ǯ<th colspan=2>����<th colspan=2>10Km<th colspan=2>5Km
<tr><th>�ְ���<th>��ձ��<th>�ְ���<th>��ձ��<th>�ְ���<th>��ձ��<th>�ְ���<th>��ձ��";
	$sexarray = array("M"=>"��", "F"=>"��");
	while (list($sexk,$sexv) = each($sexarray)) {
		echo "<tr><td align=center>$sexv";
		reset($racecount);
		while (list($racek,$racevtmp) = each($racecount)) {
			$cnt = $recordsum[$sexk][$racek]["count"];
			if($cnt > 0){
				echo "<td align=center>".$recordtop[$sexk][$racek]."<br>".$recordtopname[$sexk][$racek]."<td align=center>";
				echo sec2hms($recordsum[$sexk][$racek]["record"]/$cnt)."<br>".$cnt."��";
			}else{
				echo "<td><td>";
			}
		}
	}
	{
		echo "<tr><td>��ü";
		reset($racecount);
		while (list($racek,$racevtmp) = each($racecount)) {
			$cnt = $recordsum["M"][$racek]["count"] + $recordsum["F"][$racek]["count"];
			if($cnt > 0){
				echo "<td align=center><td align=center>";
				echo sec2hms(($recordsum["M"][$racek]["record"]+$recordsum["F"][$racek]["record"])/$cnt)."<br>".$cnt."��";
			}else{
				echo "<td><td>";
			}
		}
	}
	echo "</table>";

mysql_free_result($result);

}else if($mode == "record-check"){
	heading("Ŭ�� ���α�� üũ");

	echo "<font color=red>ȸ���� ��ȸ ���� ȸ�� �� �ְ���</font> ��ϰ� <font color=red>Ŭ�� ��/��/��ü ��� ���</font>�Դϴ�.<p>";

	if($year == "")
		$year = "2000";
	echo "* ��ȸ��, ��ȸ�� �� ����� ��ϵ� ȸ�� ����Դϴ�.<p>";
	echo "<form action=$PHP_SELF>
<input type=hidden name=mode value='$mode'>
<input type=text name=year value='$year' maxlength=4 size=4>�� ���� ��ȸ ����
<input type=submit value='Ŭ���������'></form>\n";
	echo "<table border=1><tr><th rowspan=2>��ȣ<th rowspan=2>�̸�<th colspan=2 align=center width=60>Ǯ<th colspan=2 align=center width=60>����<th colspan=2 align=center width=60>10Km<th colspan=2 align=center width=60>5Km<th rowspan=2 align=center width=60>��Ÿ<th rowspan=2>��Ÿ �Ÿ�<th>�ֹι�ȣ";
	echo "<tr> <td>ȸ<td>�ְ��� <td>ȸ<td>�ְ��� <td>ȸ<td>�ְ��� <td>ȸ<td>�ְ���";
	$dbquery="select member.name, record.userid, record.item, record.record, record.dispyn,member.sex";
	$dbquery .= ", IF( record.item='Ǯ', 1, IF( record.item='����', 2, IF( record.item='10Km', 3, IF( record.item='5Km', 4, 5)))) as itemnew";
	$dbquery .= ",record.openrecord,member.juminno";
//	$dbquery .= " from member,record where member.membertype in ('��ȸ��', '��ȸ��') and member.userid=record.userid and (record.record != '' and record.record is not null) order by member.name,itemnew,record.record";
	$dbquery .= " from member,record,race where member.membertype in ('��ȸ��', '��ȸ��') and member.userid=record.userid and (record.record != '' and record.record is not null) and race.raceid=record.raceid and race.raceday >= '$year' order by member.name,itemnew,record.record";
	$result = mysql_query($dbquery) or die("mysql_query error");

	$oldname = "";
	$olduserid = "";
	$racecount = array("Ǯ"=>0, "����"=>0, "10Km"=>0, "5Km"=>0);
	$racebestrecord = array("Ǯ"=>"", "����"=>"", "10Km"=>"", "5Km"=>"");
	$recordsum = array(
			"M"=>array("Ǯ"=>array("count"=>0,"record"=>0),
				   "����"=>array("count"=>0,"record"=>0),
				   "10Km"=>array("count"=>0,"record"=>0),
				   "5Km"=>array("count"=>0,"record"=>0)),
			"F"=>array("Ǯ"=>array("count"=>0,"record"=>0),
				   "����"=>array("count"=>0,"record"=>0),
				   "10Km"=>array("count"=>0,"record"=>0),
				   "5Km"=>array("count"=>0,"record"=>0))
		);
	$recordtopname = array(
		"M"=>array("Ǯ"=>"", "����"=>"", "10Km"=>"", "5Km"=>""),
		"F"=>array("Ǯ"=>"", "����"=>"", "10Km"=>"", "5Km"=>"")
		);
	$recordtop = array(
		"M"=>array("Ǯ"=>"", "����"=>"", "10Km"=>"", "5Km"=>""),
		"F"=>array("Ǯ"=>"", "����"=>"", "10Km"=>"", "5Km"=>"")
		);
	$no = 0;
	while($row=mysql_fetch_array($result)){
		$name = $row[0];
		$userid = $row[1];
		$item = $row[2];
		$sex = $row[5];
		$juminno = $row[juminno];
		if($userid != $olduserid){
			if($oldname != ""){
				echo "<tr><td>$no<td><a href='bmmeminfo.php?mode=meminfo-one&userid=$olduserid'>$oldname</a>";
				reset($racecount);
				while (list($k,$v) = each($racecount)) {
					if($racecount[$k] >= 1){
						echo "<td>$v";
						if($k == "Ǯ" and $racebestrecord[$k] < "3")
							echo "<td><font color=red>$racebestrecord[$k]</font>";
						else
							echo "<td>$racebestrecord[$k]";
						$recordsum[$oldsex][$k]["count"]++;
						$recordsum[$oldsex][$k]["record"] += hms2sec($racebestrecord[$k]);
					}else
						echo "<td><td>";
				}
				if($raceother > 0){
					echo "<td>$raceother<td>$raceothername";
				}else{
					echo "<td><td>";
				}
				echo "<td>". substr($oldjuminno,0,6);
			}
			$racecount["Ǯ"]=0;
			$racecount["����"]=0;
			$racecount["10Km"]=0;
			$racecount["5Km"]=0;
			$raceother = 0;
			$raceothername = "";
			$oldname = $name;
			$olduserid = $userid;
			$oldsex = $sex;
			$oldjuminno = $juminno;
			$no++;
		}
		if($item == "Ǯ" || $item == "����" || $item == "10Km" || $item == "5Km"){
			$racecount[$item]++;
			if($racecount[$item] == 1){	// best record by sorting
				$racebestrecord[$item] = $row[3];
			}
			if($recordtop[$sex][$item] > $row[3] || $recordtop[$sex][$item] == ""){
				$recordtop[$sex][$item] = $row[3];
				$recordtopname[$sex][$item] = $name;
			} 
		}else{
			$raceother++;
			if(strstr($raceothername, $item." ") == false)
				$raceothername .= $item." ";
		}
	}
	{
				echo "<tr><td>$no<td><a href='bmmeminfo.php?mode=meminfo-one&userid=$olduserid'>$oldname</a>";
				reset($racecount);
				while (list($k,$v) = each($racecount)) {
					if($racecount[$k] >= 1){
						echo "<td>$v";
						if($k == "Ǯ" and $racebestrecord[$k] < "3")
							echo "<td><font color=red>$racebestrecord[$k]</font>";
						else
							echo "<td>$racebestrecord[$k]";
						$recordsum[$oldsex][$k]["count"]++;
						$recordsum[$oldsex][$k]["record"] += hms2sec($racebestrecord[$k]);
					}else
						echo "<td><td>";
				}
				if($raceother > 0){
					echo "<td>$raceother<td>$raceothername";
				}else{
					echo "<td><td>";
				}
				echo "<td>". substr($oldjuminno,0,6);
	}
	echo "</tr></table>";
	echo "<p><font size='+2'>ȸ���� �ְ��� ���� Ŭ�� ��� ���</font><p>";
	echo "
<table border=1>
<tr><th rowspan=2>����<th colspan=2>Ǯ<th colspan=2>����<th colspan=2>10Km<th colspan=2>5Km
<tr><th>�ְ���<th>��ձ��<th>�ְ���<th>��ձ��<th>�ְ���<th>��ձ��<th>�ְ���<th>��ձ��";
	$sexarray = array("M"=>"��", "F"=>"��");
	while (list($sexk,$sexv) = each($sexarray)) {
		echo "<tr><td align=center>$sexv";
		reset($racecount);
		while (list($racek,$racevtmp) = each($racecount)) {
			$cnt = $recordsum[$sexk][$racek]["count"];
			if($cnt > 0){
				echo "<td align=center>".$recordtop[$sexk][$racek]."<br>".$recordtopname[$sexk][$racek]."<td align=center>";
				echo sec2hms($recordsum[$sexk][$racek]["record"]/$cnt)."<br>".$cnt."��";
			}else{
				echo "<td><td>";
			}
		}
	}
	{
		echo "<tr><td>��ü";
		reset($racecount);
		while (list($racek,$racevtmp) = each($racecount)) {
			$cnt = $recordsum["M"][$racek]["count"] + $recordsum["F"][$racek]["count"];
			if($cnt > 0){
				echo "<td align=center><td align=center>";
				echo sec2hms(($recordsum["M"][$racek]["record"]+$recordsum["F"][$racek]["record"])/$cnt)."<br>".$cnt."��";
			}else{
				echo "<td><td>";
			}
		}
	}
	echo "</table>";

mysql_free_result($result);

}else if($mode == "record-top20"){
heading( "Ǯ�ڽ� Top 20");

if($type == '')
	$type = "norepeat";
if($type == "norepeat")
	echo "�ߺ� ����\n";
else
	echo "<a href='$PHP_SELF?mode=record-top20&type=norepeat'>�ߺ� ����</a>\n";
if($type == "norepeat"){
	echo "<a href='$PHP_SELF?mode=record-top20&type=repeat'>�ߺ� ǥ��</a>\n";
	$limitno = 200;
}else{
	echo "�ߺ� ǥ��\n";
	$limitno = 20;
}
echo "<table border=1><tr><th>����<th>��ȸ��<th>���<th>�̸�</tr>\n";

$dbquery="select record.raceid, record.nickname, record.record, member.name from record,member where record.record!='' and record.item='Ǯ' and record.userid=member.userid and member.membertype in ('��ȸ��','��ȸ��') order by record.record limit $limitno";
$result = mysql_query($dbquery) or die("mysql_query error");

$mem='||';	// 0�� false�� �ν��ϱ� ������ 2�ڷ� �ʱ�ȭ
for($no=1; ($row=mysql_fetch_array($result)) && $no<=20;){
if ($type == "norepeat" && strpos($mem, "|$row[3]|") != false){
	continue;
}
echo "<tr><td align=center>$no</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td></tr>\n";
$mem .= "$row[3]|";
$no++;
}
echo "</table>";
	mysql_free_result($result);
}else if($mode == "record-yeartop20"){
	heading("������ Top 20");

	if($type == '')
		$type = "norepeat";
	if($type == "norepeat")
		echo "�ߺ� ����\n";
	else
		echo "<a href='$PHP_SELF?mode=record-yeartop20&type=norepeat'>�ߺ� ����</a>\n";
	if($type == "norepeat"){
		echo "<a href='$PHP_SELF?mode=record-yeartop20&type=repeat'>�ߺ� ǥ��</a>\n";
		$limitno = 200;
	}else{
		echo "�ߺ� ǥ��\n";
		$limitno = 20;
	}
	echo "<table border=1><tr><th>����<th>��ȸ��<th>���<th>�̸�</tr>\n";

	$year = date("Y");
	$dbquery="select record.raceid, record.nickname, record.record, member.name from record,member,race where record.record!='' and record.item='Ǯ' and record.raceid=race.raceid and substring(race.raceday,1,4) like '$year%' and record.userid=member.userid and member.membertype in ('��ȸ��','��ȸ��') order by record.record limit $limitno";
	$result = mysql_query($dbquery) or die("mysql_query error");

	$mem='||';	// 0�� false�� �ν��ϱ� ������ 2�ڷ� �ʱ�ȭ
	for($no=1; ($row=mysql_fetch_array($result)) && $no<=20;){
		if ($type == "norepeat" && strpos($mem, "|$row[3]|") != false){
			continue;
		}
		echo "<tr><td align=center>$no</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td></tr>\n";
		$mem .= "$row[3]|";
		$no++;
	}
	echo "</table>";
	mysql_free_result($result);
}else if($mode == "submenu"){
	heading("��ϰ��� �޴�");
	echo "
	<a href='bmrecord.php?mode=record-input'>���α�ϵ��</a><br>
	<a href='bmrecord.php?mode=record-list'>���α�ϸ��</a><br>
	<a href='bmrecord.php?mode=record-top20'>Ǯ�ڽ�Top20</a><br>
	<a href='bmrecord.php?mode=record-yeartop20'>������Top20</a><br>
	<a href='bmrecord.php?mode=record-racecount'>Ŭ���������</a><br>";
}

function race_inviting($mode, $raceid, $item, $size, $transport, $userid){

	global $PHP_SELF;

	$itemf=$itemh=$item10=$item5="";
	if($item == "Ǯ"){
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
<input type=hidden name=userid value='$userid'>\n
<input type=hidden name=mode value='$mode'>\n
<tr><td>������ȸ</td><td>";
	$dbquery="select raceid, name, nickname from race where inviting='Y'";
	$result = mysql_query($dbquery) or die("mysql_query error");

	echo "<input type=hidden name='mode' value='$mode'>\n";
	echo "<select name='raceid' size='1'  style='background-color: white; color: blue; font:10pt'>\n";

	while($row=mysql_fetch_array($result)){
		echo "<option value='$row[0]:$row[2]'";
		if($row[0] == $raceid)
			echo " selected";
		echo ">$row[2] : $row[1]";
		echo "</option>\n";
	}
	echo "</select>";
	mysql_free_result($result);

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
<tr><td>ũ��</td><td><input type=text name=size value='$size' maxlength=4 size=5 onChange='return checkLength(this.value,4)'>�ݵ�� ��ȸ �䰭�� Ȯ�� �� ���� ���</td></tr>\n
<tr><td>������</td><td><input type=text name=transport value='$transport' maxlength=20 size=20 onChange='return checkLength(this.value,20)'>�� : ���ӽ��� ���, �ڰ��� ���� ��</td></tr>\n
<tr><td colspan=2 align=center>";

	if(privcheck($userid)){
		echo "<br><input type=submit value='";
		if($mode == "record-insert")
			echo "���";
		else
			echo "����";
		echo " ó��'>";
		if($mode == "record-update"){
			echo "<p>
</form>
<form action='$PHP_SELF' method=post>\n
<input type=hidden name=mode value='record-delete'>\n
<input type=hidden name=raceid value='$raceid'>\n
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

function record_display($mode, $userid, $raceid, $nickname, $item, $name, $record, $rank, $dispyn, $etc){

	global $logid, $PHP_SELF;

	$itemf=$itemh=$item10=$item5="";
	if($item == "Ǯ"){
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
	if($dispyn == "Y"){
		$dispy = "checked";
	}else if($dispyn == "N"){
		$dispn = "checked";
	}else{
		$dispy = "checked";
	}

	JScheckLength();
	echo "
<form action='$PHP_SELF' method=post>
<input type=hidden name=mode value='$mode'>
<input type=hidden name=itemold value='$item'>\n";
	echo "
<table border=1>\n
<tr><td><table border=1>\n";
	if($name != ""){
		echo "
<tr><td>�̸�</td><td>$name</td></tr>";
	}
	echo "
<tr><td>��ȸ��</td><td>";
	if($raceid > 0){
		echo "$nickname\n
<input type=hidden name=raceid value='$raceid'>\n";
	}else{
		if($nickname == "input"){
			$dbquery="select race.raceid, race.name, race.nickname, race.raceday from race";
			if(privcheck($logid) < 2){
				$dbquery.=" left join record on race.nickname=record.nickname";
				$dbquery.=" and record.userid = '$logid'";
				$dbquery.=" where record.nickname is null";
			}
			$dbquery.=" order by race.raceday desc";

			$result = mysql_query($dbquery) or die("mysql_query error");
		}
		echo "<select name='raceid' size='1'  style='background-color: white; color: blue; font:10pt'>\n";

		while($row=mysql_fetch_array($result)){
			echo "<option value='$row[0]'>$row[3] : $row[2] : $row[1]</option>\n";
		}
		echo "</select>\n";
		mysql_free_result($result);

	}
	if(privcheck($logid) < 2 || $mode == "record-update"){
		echo "<input type=hidden name=userid value='$userid'>\n";
		$dbquery="select name from member where userid='$userid'";
		$result = mysql_query($dbquery) or die("mysql_query error");
		$row=mysql_fetch_array($result);
		mysql_free_result($result);
		echo "</td>\n<tr><td>������</td><td>$row[0]\n";
	}else{
		echo "</td>\n<tr><td>������</td><td>\n";
		$dbquery="select userid, name from member order by name";
		$result = mysql_query($dbquery) or die("mysql_query error");
		echo "<select name='userid' size='1'  style='background-color: white; color: blue; font:10pt'>\n";

		while($row=mysql_fetch_array($result)){
			if($logid == $row[0])
				echo "<option value='$row[0]' selected>$row[1]</option>\n";
			else
				echo "<option value='$row[0]'>$row[1]</option>\n";
		}
		echo "</select>\n";
		mysql_free_result($result);
	}

	echo "</td>\n
<tr><td>����</td><td>\n
  <input type='radio' name='item' value='Ǯ' $itemf>Ǯ\n
  <input type='radio' name='item' value='����' $itemh>����\n
  <input type='radio' name='item' value='10Km' $item10>10Km\n
  <input type='radio' name='item' value='5Km' $item5>5Km\n
  <input type='radio' name='item' value='etc' $iteme>��Ÿ\n
<input type=text name=itemetc value='$itemetc' maxlength=6 size=7 onChange='return checkLength(this.value,6)'>�� : 7.5Km</td></tr>\n
<tr><td>���</td><td><input type=text name=record  value='$record' maxlength=8 size=8 onChange='return checkLength(this.value,8)'>��: 3:03:03</td></tr>\n
<tr><td>����</td><td><input type=text name=rank value='$rank' maxlength=12 size=12 onChange='return checkLength(this.value,12)'></td></tr>\n
<tr><td>�߰���� ��</td><td><input type=text name=etc value='$etc' maxlength=80 size=60 onChange='return checkLength(this.value,80)'></td></tr>\n
<tr><td>��������</td><td>
  <input type='radio' name='dispyn' value='Y' $dispy>������
  <input type='radio' name='dispyn' value='N' $dispn>���θ� ��
  </td>\n
</tr></table></td>\n
<td align=center valign=center>";

	if(privcheck($logid) == 2 || $logid == $userid){
		echo "<input type=submit value='ó��'>";
	}
	echo "</form><p>\n";
	if($mode == "record-update"){
		echo "
<form action='$PHP_SELF' method=post>\n
<input type=hidden name=raceid value='$raceid'>\n
<input type=hidden name=userid value='$userid'>\n
<input type=hidden name=item value='$item'>\n
<input type=hidden name=mode value='record-delete'>\n
<input type=submit value='������û ���� ����'>\n
</form></td></tr>\n";
	}
	echo "</table>";
}

function getRaceDay($raceid){
	global $dbquery;

	$dbquery="select raceday from race where raceid=$raceid";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$row=mysql_fetch_array($result);
	$raceday = $row[0];
	mysql_free_result($result);
//echo "raceday=$raceday ";
	if(strlen($raceday) != 10)
		return "";
	else
		return $raceday;
}

function calcOpenRecord($raceday,$userid,$record,$item){
	global $dbquery;

	if($item!='Ǯ' and $item!='����')
		return "";
		
	$dbquery="select juminno,sex,birthdate from member where userid='$userid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$row=mysql_fetch_array($result);
	if($row[birthdate] <= '2100.12.31' && substr($row[birthdate], 4, 1)=='.' && substr($row[birthdate], 7, 1)=='.'){
		$birthday = substr($row[birthdate], 0, 4).substr($row[birthdate], 5, 2).substr($row[birthdate], 8, 2);
	}else{
		$juminno = $row[juminno];
		if(strlen($juminno) < 6 || $juminno <= '211231')
			return "";
		$juminno = substr($juminno, 0, 6);
		if(substr($juminno, 0, 1) <= "1")
			$birthday = "20".$juminno;
		else
			$birthday = "19".$juminno;
	}
	$mf = $row[1];

//echo "userid=$userid,record=$record,birthday=$birthday/$row[birthdate]/$row[juminno] ";
	mysql_free_result($result);
	$age = substr($raceday, 0, 4) - substr($birthday, 0, 4) - 1;

	$rmon = substr($raceday, 5, 2);
	$bmon = substr($birthday, 4, 2);
	if($rmon > $bmon)
		$age = $age + 1;
	elseif($rmon == $bmon){
		$rday = substr($raceday, 8, 2);
		$bday = substr($birthday, 6, 2);
		if($rday >= $bday)
			$age = $age + 1;
	}
//$age="15";
//echo "age=$age ";

$WAVA_ages = array(0,0,0,8,9,10,11,12,13,14,15,16,17,18,19,20,29,30,31,32,33,34,35,36,37,38,39,40,45,49,50,55,59,60,65,69,70,75,79,80,85,90,95,100);
                         
$WAVA_M_facs = array(
	"Ǯ" => array("MAR",   42.200, 7610.00, 0.7645,0.8020,0.8348,0.8634,0.8884,0.9101,0.9289,0.9452,0.9591,0.9710,0.9810,0.9894,1.0000,1.0000,1.0000,1.0000,1.0000,1.0000,1.0000,1.0000,1.0000,1.0000,0.9973,0.9904,0.9835,0.9486,0.9201,0.9130,0.8763,0.8457,0.8380,0.7975,0.7628,0.7541,0.7070,0.6655,0.6551,0.5964,0.5262,0.4317,0.2758),
	"����" => array("hMar",  21.100, 3579.00, 0.7847,0.8211,0.8524,0.8793,0.9024,0.9221,0.9389,0.9531,0.9650,0.9750,0.9832,0.9899,1.0000,1.0000,1.0000,1.0000,1.0000,1.0000,1.0000,1.0000,1.0000,0.9957,0.9888,0.9820,0.9751,0.9404,0.9121,0.9050,0.8685,0.8380,0.8304,0.7901,0.7555,0.7469,0.7000,0.6586,0.6483,0.5898,0.5198,0.4255,0.2698),
	"10Km" => array("10K",   10.000, 1618.40, 0.7919,0.8279,0.8588,0.8853,0.9078,0.9271,0.9433,0.9570,0.9685,0.9780,0.9858,0.9921,1.0000,1.0000,1.0000,1.0000,1.0000,1.0000,1.0000,1.0000,0.9953,0.9884,0.9816,0.9747,0.9679,0.9333,0.9051,0.8980,0.8616,0.8312,0.8236,0.7834,0.7489,0.7403,0.6935,0.6522,0.6419,0.5835,0.5136,0.4194,0.2638),
	"5Km" => array("5K",     5.000,  778.40, 0.7809,0.8177,0.8496,0.8772,0.9011,0.9216,0.9393,0.9543,0.9671,0.9779,0.9868,0.9925,1.0000,1.0000,1.0000,1.0000,1.0000,1.0000,1.0000,0.9963,0.9895,0.9827,0.9760,0.9692,0.9624,0.9281,0.9001,0.8931,0.8570,0.8268,0.8193,0.7794,0.7452,0.7366,0.6901,0.6491,0.6388,0.5807,0.5111,0.4172,0.2619)
	);


$WAVA_W_facs = array(
	"Ǯ" => array("MAR",   42.200, 8331.00, 0.7258,0.7727,0.8134,0.8485,0.8785,0.9040,0.9254,0.9432,0.9579,0.9699,0.9794,0.9870,1.0000,1.0000,1.0000,1.0000,1.0000,1.0000,1.0000,1.0000,1.0000,0.9979,0.9901,0.9823,0.9745,0.9351,0.9030,0.8950,0.8538,0.8196,0.8110,0.7660,0.7277,0.7181,0.6665,0.6214,0.6101,0.5469,0.4722,0.3732,0.2128),
	"����" => array("hMar",  21.100, 3948.00, 0.7384,0.7850,0.8251,0.8594,0.8885,0.9129,0.9332,0.9499,0.9635,0.9745,0.9831,0.9899,1.0000,1.0000,1.0000,1.0000,1.0000,1.0000,1.0000,1.0000,0.9969,0.9891,0.9813,0.9735,0.9657,0.9263,0.8942,0.8862,0.8450,0.8108,0.8022,0.7572,0.7189,0.7093,0.6577,0.6126,0.6013,0.5381,0.4634,0.3644,0.2040),
	"10Km" => array("10K",   10.000, 1795.00, 0.7591,0.8047,0.8434,0.8760,0.9032,0.9257,0.9442,0.9591,0.9711,0.9805,0.9879,0.9935,1.0000,1.0000,1.0000,1.0000,1.0000,1.0000,1.0000,0.9974,0.9896,0.9818,0.9741,0.9663,0.9585,0.9192,0.8872,0.8792,0.8381,0.8039,0.7954,0.7505,0.7123,0.7027,0.6512,0.6062,0.5949,0.5318,0.4572,0.3583,0.1980),
	"5Km" => array("5K",     5.000,  863.70, 0.7731,0.8177,0.8553,0.8866,0.9125,0.9337,0.9509,0.9647,0.9756,0.9841,0.9907,0.9956,1.0000,1.0000,1.0000,1.0000,1.0000,1.0000,0.9990,0.9913,0.9835,0.9758,0.9680,0.9603,0.9525,0.9133,0.8814,0.8734,0.8324,0.7983,0.7898,0.7450,0.7068,0.6973,0.6459,0.6009,0.5897,0.5267,0.4522,0.3534,0.1932)
	);

	for($ageidx=0; $ageidx < count($WAVA_ages) ; $ageidx++){
//echo "ageidx=$ageidx,WAVA_ages[]=$WAVA_ages[$ageidx] ";
		if($WAVA_ages[$ageidx] >= $age)
			break;
	}
	if($ageidx == count($WAVA_ages)){
		return "";
	}
	if($WAVA_ages[$ageidx] == $age){
		if($mf == "M")
			$factor = $WAVA_M_facs[$item][$ageidx];
		else
			$factor = $WAVA_W_facs[$item][$ageidx];
	}else{
		$age1 = $WAVA_ages[$ageidx - 1];
		$age2 = $WAVA_ages[$ageidx];
		if($mf == "M"){
			$fac1 = $WAVA_M_facs[$item][$ageidx - 1];
			$fac2 = $WAVA_M_facs[$item][$ageidx];
		}else{
			$fac1 = $WAVA_W_facs[$item][$ageidx - 1];
			$fac2 = $WAVA_W_facs[$item][$ageidx];
		}
//		$factor = round($fac1 - ($age - $age1) * ($fac1 - $fac2) / ($age2 - $age1), 4);
		$factor = $fac1 - ($age - $age1) * ($fac1 - $fac2) / ($age2 - $age1);
	}
//echo "fac1=$fac1,fac2=$fac2,factor=$factor ";
	$secs = hms2sec($record);
//echo "secs=$secs ";
	$secs = round($secs * $factor, 0);
//echo "secs=$secs ";
	$record = sec2hms($secs);
//echo "record=$record ";
//echo "age=$age,$mf,factor=$factor,record=$record\n";
	return $record;
}

function hms2sec($record){
	$strs = explode(":", $record);
	$cnt = count($strs);
//echo "record=$record, cnt=$cnt ";
	if($cnt == 3)
		$secs = $strs[0] * 3600 + $strs[1] * 60 + $strs[2];
	elseif($cnt == 2)
		$secs = $strs[0] * 60 + $strs[1];
	else
		$secs = $strs[0];
	return $secs;
}

function sec2hms($secs){
	$hour = $min = $sec = 0;
	$hour = floor($secs / 3600);
	$min = floor(($secs - $hour * 3600) / 60);
	$sec = $secs % 60;
	$record = $hour.":";
	if($min <10)
		$record .= "0";
	$record .= $min.":";
	if($sec <10)
		$record .= "0";
	$record .= $sec;
	return $record;
}

function setrecord($record){
	if(substr($record, 0, 1) == "0" && substr($record, 1, 1) >= "0" && substr($record, 1, 1) <= "9")
		$record = substr($record, 1);
	$record = str_replace(";", ":", $record);
	$record = str_replace(".", ":", $record);
	return $record;
}
?>
</center>
</body>
</html>
