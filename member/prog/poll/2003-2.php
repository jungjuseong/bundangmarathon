<?php 
$comdir = "../";
require($comdir."auth.php");
require($comdir."config.php");

function top(){
echo "
<html>
<head>
<title>2003 �ӿ� ���� �ĺ� ��õ</title>
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
	heading("2003 �ӿ� ���� �ĺ� ��õ");

	if($logid == ""){
		die("�α������� �ʾҽ��ϴ�.");
	}
    if($mem0 != ""){
	$query_name="pollid,userid,polltime,poll0,poll1,poll2,poll3,poll4";
	$query_value="'".$pollid."','".$logid."',now(),'".$mem0."','".$mem1."','".$mem2."','".$mem3."','".$mem4."'";

	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_db_query("gumpu",$dbquery);

//	mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		$dbquery="update poll set polltime=now(),poll0='$mem0', poll1='$mem1', poll2='$mem2', poll3='$mem3', poll4='$mem4' where pollid='$pollid' and userid='$logid'";
		$result = mysql_db_query("gumpu",$dbquery);
		echo "<font color=red>��ǥ ������ �Ϸ�Ǿ����ϴ�.</font><br>";
		echo "<br>";;
	}else{
		echo "�����մϴ�.<br>";
		echo "��ǥ ó���� �Ϸ�Ǿ����ϴ�.<br>";
	}
    }

	$dbquery="select count(*) from poll where pollid='$pollid'";
	$result = mysql_query($dbquery);
	$row=mysql_fetch_array($result);
	echo "<p>�� ��ǥ �ο� : $row[0] ��<p>";
	mysql_free_result($result);

	$starttime = mktime(8,0,0,11,12,2003);
	$stoptime = mktime(18,0,0,11,18,2003);
	$currenttime = mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));

if($currenttime > $stoptime){
    if($logid == "nogok"){	/* ��ȹ���� */
	echo "<p><font color=blue>������ �ӿ� ��õ�� ���� ��������� 1~5�� ��ǥ ����Դϴ�.</font>\n";
	echo "<p><table><tr><td>\n";

$imwon = array ("ȸ��", "��ȸ��", "��ȹ����", "�Ʒ�����", "�̵������");
	for($i=0; $i<5; $i++){
		$dbquery="select poll$i,count(*) as cnt from poll where pollid='$pollid' group by poll$i order by cnt desc limit 5";
		$result = mysql_query($dbquery);

		echo "<p>$imwon[$i] ��õ : ";
		while($row=mysql_fetch_array($result)){
			echo " $row[0] $row[1]ǥ ";
		}
		mysql_free_result($result);
	}
	echo "</table>\n";
    }
}

?>
</center>
</body>
</html>
