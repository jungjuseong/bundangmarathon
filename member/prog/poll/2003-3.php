<?php 
$comdir = "../";
require($comdir."auth.php");
require($comdir."config.php");
require($comdir."function.php");

mysql_select_db("gumpu") or die("mysql_select_db error");

	top("");
	heading("��ȸ �Ȱ� ��ǥ");

	if($logid == ""){
		die("�α������� �ʾҽ��ϴ�.");
	}
echo $userid;
    if($rule0 != ""){
	$query_name="pollid,userid,polltime,ip";
	$query_value="'".$pollid."','".$logid."',now(),'$REMOTE_ADDR'";

	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_db_query("gumpu",$dbquery);

	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "<font color=red>�̹� ��ǥ�ϼ̽��ϴ�.</font><br>";
		echo "<br>";;
	}else{
		$query_name="pollid,poll0,poll1,poll2,poll3,poll4";
		$query_value="'".$pollid."','".$rule0."','".$rule1."','".$rule2."','".$rule3."','".$rule4."'";

		$query_name.=",poll5,poll6,poll7,poll8,poll9";
		$query_value.=",'".$rule5."','".$rule6."','".$rule7."','".$rule8."','".$rule9."'";
		$query_name.=",poll10,poll11";
		$query_value.=",'".$rule10."','".$rule11."'";
		$dbquery="insert into poll2 ($query_name) values($query_value)";
		$result = mysql_db_query("gumpu",$dbquery);
		if($result!="1"){
		}else{
			$dbquery="delete from poll where pollid='$pollid' and userid='$logid'";
			$result = mysql_db_query("gumpu",$dbquery);
			echo "DB(poll2) ���� �߻�\n";
			echo "�����մϴ�.<br>";
			echo "��ǥ ó���� �Ϸ�Ǿ����ϴ�.<br>";
		}
	}
    }

	$starttime = mktime(9,0,0,12,1,2003);
	$stoptime = mktime(23,59,59,12,3,2003);
	$currenttime = mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));


    if(privcheck($logid) == 2 || $currenttime > $stoptime){
    	if($currenttime > $stoptime)
		echo "<p><font color=blue>������ 2003 ��ȸ �Ȱǿ� ���� ��ǥ ����Դϴ�.</font>";
	else
		echo "<p><font color=blue>������ 2003 ��ȸ �Ȱǿ� ���� ��������� ��ǥ ����Դϴ�.</font>";

	$dbquery="select count(*) from poll where pollid='$pollid'";
	$result = mysql_query($dbquery);
	$row=mysql_fetch_array($result);
	echo "<p>�� ��ǥ �ο� : $row[0] ��<p>";
	mysql_free_result($result);
    }

$items = array();
$filelines = file("2003-3.html");
$ii = 0;
for($i = 0; $i < count($filelines); $i++){
	if(substr($filelines[$i], 0, 8) == "<!-- -->")	// �Ȱ� ù�κ� ǥ��
		$items[$ii++] = $filelines[$i];
}
    if($currenttime > $stoptime){
	echo "<p><table border=1 width='80%'><tr><th>�Ȱ�<th width=100>��ǥ���\n";
	for($i=0; $i < count($items); $i++){
		$dbquery="select poll$i,count(*) from poll2 where pollid='$pollid' group by poll$i order by poll$i";
		$result = mysql_query($dbquery);

		echo "\n<tr><td>$items[$i]<td>";
		while($row=mysql_fetch_array($result)){
			echo "$row[0]:$row[1]��<br>";
		}
	}
	echo "</table>\n";
    }


?>
</center>
</body>
</html>
