<?php 
$comdir = "../";
require($comdir."auth.php");
require($comdir."config.php");

function top(){
echo "
<html>
<head>
<title>��ǥ</title>
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
	heading("������ ���� �ǰ� ����");

	if($logid == ""){
		die("�α������� �ʾҽ��ϴ�.");
	}
if($rule0 != ""){
if($rule0 != ""){
		echo "��ǥ �Ⱓ�� �������ϴ�.<br>";
}else{
	$query_name="pollid,userid,polltime,poll0,poll1,poll2,poll3,poll4";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."','".$rule1."','".$rule2."','".$rule3."','".$rule4."'";

	$query_name.=",poll5,poll6,poll7,poll8,poll9";
	$query_value.=",'".$mem0."','".$mem1."','".$mem2."','".$mem3."','".$mem4."'";
	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_db_query("gumpu",$dbquery);

	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "<font color=red>�̹� ��ǥ�ϼ̽��ϴ�.</font><br>";
		die("");
	}else{
		echo "�����մϴ�.<br>";
		echo "��ǥ ó���� �Ϸ�Ǿ����ϴ�.<br>";
	}
}
}

	echo "<p><font color=blue>������ ��������� ��ǥ ����Դϴ�.</font>";
	for($i=0; $i<2; $i++){
		$dbquery="select poll$i,count(*) from poll where pollid='$pollid' group by poll$i order by poll$i desc";
		$result = mysql_query($dbquery);

		if($i == 0){
			echo "<p>���� 1�� ���� �׸� ";
		}else{
			echo "<p>���� 2�� ������ �׸� ";
		}
		while($row=mysql_fetch_array($result)){
			if($i == 0){
				if($row[0] == "Y")
					$qstr = "���� ������ ����";
				else
					$qstr = "�پ�ȭ �������� �̹����� ���ο� ������ �غ���";
			}else{
				if($row[0] == "Y")
					$qstr = "���� �������� ����";
				else
					$qstr = "�پ�ȭ �������� �̹����� ���ο� ���������� �غ��� ";
			}
			echo "<br>$qstr:$row[1]�� ";
		}
	}


?>
</center>
</body>
</html>
