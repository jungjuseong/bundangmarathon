<?php 

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

require("../../race/2001/config.php");
mysql_select_db("coretek") or die("mysql_select_db error");

	top();
	heading("��ȸ �Ȱ� ��ǥ");

	if($logid == ""){
		die("�α������� �ʾҽ��ϴ�.");
	}
	$query_name="pollid,userid,polltime,poll0,poll1,poll2,poll3,poll4";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."','".$rule1."','".$rule2."','".$rule3."','".$rule4."'";

	$query_name.=",poll5,poll6,poll7,poll8,poll9";
	$query_value.=",'".$mem0."','".$mem1."','".$mem2."','".$mem3."','".$mem4."'";
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

	echo "<p><font color=blue>������ ȸĢ ������ ���� ��������� ��ǥ ����Դϴ�.</font>";
	for($i=0; $i<5; $i++){
		$dbquery="select poll$i,count(*) from poll where pollid='$pollid' group by poll$i order by poll$i desc";
		$result = mysql_query($dbquery);

		$ii = $i + 1;
		echo "<p>ȸĢ ���� $ii"."�� �׸� : ";
		while($row=mysql_fetch_array($result)){
			echo "$row[0]:$row[1]�� ";
		}
	}

	echo "<p><font color=blue>�ӿ� ������ ��ǥ ���� �� ���� ����� ��ǥ�մϴ�.</font>";

?>
</center>
</body>
</html>
