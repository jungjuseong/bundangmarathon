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
	heading("��ȸ �Ȱ� ��ǥ");

	if($logid == ""){
		die("�α������� �ʾҽ��ϴ�.");
	}
    if($mem0 != ""){
	$query_name="pollid,userid,polltime,poll0,poll1,poll2,poll3,poll4";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."','".$rule1."','".$rule2."','".$rule3."','".$rule4."'";

	$query_name.=",poll5,poll6,poll7,poll8,poll9";
	$query_value.=",'".$mem0."','".$mem1."','".$mem2."','".$mem3."','".$mem4."'";
	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_db_query("gumpu",$dbquery);

	mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "<font color=red>�̹� ��ǥ�ϼ̽��ϴ�.</font><br>";
		echo "<br>";;
	}else{
		echo "�����մϴ�.<br>";
		echo "��ǥ ó���� �Ϸ�Ǿ����ϴ�.<br>";
	}
    }

	echo "<p><font color=blue>������ �ӿ� ���⿡ ���� ��������� 1,2,3�� ��ǥ ����Դϴ�.</font>\n";
	echo "<p><table><tr><td>\n";

	$dbquery="select count(*) from poll where pollid='$pollid'";
	$result = mysql_query($dbquery);
	$row=mysql_fetch_array($result);
	echo "<p>�� ��ǥ �ο� : $row[0] ��<p>";
	mysql_free_result($result);

	for($i=5; $i<10; $i++){
		$dbquery="select poll$i,count(*) as cnt from poll where pollid='$pollid' group by poll$i order by cnt desc limit 3";
		$result = mysql_query($dbquery);

		$ii = $i - 4;
		echo "<p>�ӿ� ���� $ii"."�� �׸� : ";
		while($row=mysql_fetch_array($result)){
			echo " $row[0] $row[1]ǥ ";
		}
		mysql_free_result($result);
	}
	echo "</table>\n";

echo "<p>
<table><tr><td>
1. ȸ��<br>
2. ��ȸ��<br>
3. ��ȹ���<br>
4. �Ʒô��<br>
5. Ȩ��� <br>
</table>
";

?>
</center>
</body>
</html>
