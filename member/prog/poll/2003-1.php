<?php 
$comdir = "../";
require($comdir."auth.php");
require($comdir."config.php");
require($comdir."function.php");

mysql_select_db("gumpu") or die("mysql_select_db error");

	top("");
	heading("ȸ�� ����� ��ǥ ���");

	if($logid == ""){
		die("�α������� �ʾҽ��ϴ�.");
	}
    if($rule0 != ""){
	$dbquery="select name, grade from member where userid='$logid' and membertype='��ȸ��'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	if( mysql_numrows( $result ) == 1){
		$qualify = "Y";
	}else{
		die("��ȸ���� ��ǥ �����մϴ�.");
	}
	mysql_free_result($result);

	$query_name="pollid,userid,polltime,poll0";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."'";

	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_db_query("gumpu",$dbquery);

//	mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "<font color=red>�̹� ��ǥ�ϼ̽��ϴ�.</font><br>";
		echo "<br>";;
	}else{
		echo "�����մϴ�.<p>";
		echo "��ǥ ó���� �Ϸ�Ǿ����ϴ�.<br>";
	}
    }

	$starttime = mktime(12,0,0,6,16,2003);
	$stoptime = mktime(23,59,0,6,18,2003);
	$currenttime = mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));

	if($currenttime > $stoptime){
		echo "<p><font color=blue>������ ��ǥ ����Դϴ�.</font>\n";
	}else{
		echo "<p><font color=blue>������ ��������� ��ǥ ����Դϴ�.</font>\n";
	}
	echo "<p><table><tr><td>\n";

	$dbquery="select count(*) from poll where pollid='$pollid'";
	$result = mysql_query($dbquery);
	$row=mysql_fetch_array($result);
	echo "<p>�� ��ǥ �ο� : $row[0] ��<p>";
	mysql_free_result($result);

if(privcheck($logid) == 2 || $currenttime > $stoptime){
	for($i=0; $i<1; $i++){
		$dbquery="select poll$i,count(*) as cnt from poll where pollid='$pollid' group by poll$i order by cnt desc limit 3";
		$result = mysql_query($dbquery);

//		$ii = $i - 4;
//		echo "<p>�ӿ� ���� $ii"."�� �׸� : ";
		if($currenttime < $stoptime){
			echo "<p>(�����ڿ� ����) ȸ�� ����� : ";
		}else{
			echo "<p>ȸ�� ����� : ";
		}
		while($row=mysql_fetch_array($result)){
			echo " $row[0]:$row[1]ǥ ";
		}
		mysql_free_result($result);
	}
}else{
	echo "<p>��ǥ ����� ��ǥ�� ���� �� �����˴ϴ�. ";
}
	echo "</table>\n";

?>
</center>
</body>
</html>
