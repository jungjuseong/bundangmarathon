<?php 
$comdir = "../";
require($comdir."auth.php");
require($comdir."config.php");

function top(){
echo "
<html>
<head>
<title>��ȸ �Ȱ� ��ǥ</title>
</head>

<body>
<center>
";
}

function heading($msg){
	echo "<font size='+2'>".$msg."</font>";
	echo "<hr color=red width='80%'>\n<p>";
}

mysql_select_db("gumpu") or die("mysql_select_db error");

	top();
	heading("2002 ���� ��ȸ �Ȱ� ��ǥ");

	if($logid == ""){
		die("�α������� �ʾҽ��ϴ�.");
	}

	$starttime = mktime(9,0,0,12,9,2002);
	$stoptime = mktime(18,0,0,12,11,2002);
	$currenttime = mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));

	if($currenttime > $stoptime){

    if($rule0 != ""){
	$query_name="pollid,userid,polltime,poll0,poll1,poll2,poll3,poll4,poll5,poll6,poll7,poll8,poll9";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."','".$rule1."','".$rule2."','".$rule3."','".$rule4."','".$rule5."','".$rule6."','".$rule7."','".$rule8."','".$rule9."'";

	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_db_query("gumpu",$dbquery);

	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "<font color=red>�̹� ��ǥ�ϼ̽��ϴ�.</font><br>";
		echo "<br>";;
	}else{
		echo "�����մϴ�.<br>";
		echo "��ǥ ó���� �Ϸ�Ǿ����ϴ�.<br>";
	}
    }

	}
	echo "<p><font color=blue>������ ȸĢ ������ ���� ��������� ��ǥ ����Դϴ�.</font>";
	echo "<p><table><tr><td>\n";

	$dbquery="select count(*) from poll where pollid='$pollid'";
	$result = mysql_query($dbquery);
	$row=mysql_fetch_array($result);
	echo "<p>�� ��ǥ �ο� : $row[0] ��<p>";
	mysql_free_result($result);

	for($i=0; $i<9; $i++){
		$dbquery="select poll$i,count(*) from poll where pollid='$pollid' group by poll$i order by poll$i desc";
		$result = mysql_query($dbquery);

		$ii = $i + 1;
		echo "<p>ȸĢ ���� $ii"."�� �׸� : ";
		while($row=mysql_fetch_array($result)){
			if($row[0] == "Y")
				echo "����:$row[1]�� ";
			else if($row[0] == "N")
				echo "�ݴ�:$row[1]�� ";
			else
				echo "���:$row[1]�� ";
		}
	}
	echo "</table>\n";

?>
</center>
</body>
</html>
