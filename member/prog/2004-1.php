<?php

function top(){
echo "
<html>
<head>
<title>������ ������ ���� ��������</title>
</head>

<body>
<center>
";
}

function heading($msg){
	echo "<font size='+2'>".$msg."</font>";
	echo "<hr color=red width='80%'>\n<p>";
}

//include "../../bbs/_head.php";
require("config.php");
mysql_select_db("coretek") or die("mysql_select_db error");

	top();
	heading("������ ������ ���� ��������");
/*
	if($logid == ""){
		die("�α������� �ʾҽ��ϴ�.");
	}
*/
	$query_name="pollid,userid,polltime,poll0,poll1,poll2";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."','".$rule1."','".$rule2."'";

	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_db_query("coretek",$dbquery);

	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "<font color=red>�̹� ��ǥ�ϼ̽��ϴ�.</font><br>";
		die("");
	}else{
		echo "�����մϴ�.<br>";
		echo "��ǥ ó���� �Ϸ�Ǿ����ϴ�.<br>";
	}

	echo "<p><font color=blue>������ ��������� �������� ����Դϴ�.</font>";
	for($i=0; $i<3; $i++){
		$dbquery="select poll$i,count(*) from poll where pollid='$pollid' group by poll$i order by poll$i";
		$result = mysql_query($dbquery);

		$ii = $i + 1;
		echo "<p>�������� $ii"."�� �׸� : ";
		while($row=mysql_fetch_array($result)){
			echo "$row[0]:$row[1]�� ";
		}
	}

?>
</center>
</body>
</html>
