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
    if($rule0 != ""){
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
		echo "<br>";;
	}else{
		echo "�����մϴ�.<br>";
		echo "��ǥ ó���� �Ϸ�Ǿ����ϴ�.<br>";
	}
    }

	echo "<p><font color=blue>������ ȸĢ ������ ���� ��������� ��ǥ ����Դϴ�.</font>";
	echo "<p><table><tr><td>\n";

	$dbquery="select count(*) from poll where pollid='$pollid'";
	$result = mysql_query($dbquery);
	$row=mysql_fetch_array($result);
	echo "<p>�� ��ǥ �ο� : $row[0] ��<p>";
	mysql_free_result($result);

	for($i=0; $i<4; $i++){
		$dbquery="select poll$i,count(*) from poll where pollid='$pollid' group by poll$i order by poll$i desc";
		$result = mysql_query($dbquery);

		$ii = $i + 1;
		echo "<p>ȸĢ ���� $ii"."�� �׸� : ";
		while($row=mysql_fetch_array($result)){
			if($row[0] == "Y")
				echo "����:$row[1]�� ";
			else if($row[0] == "N")
				echo "����:$row[1]�� ";
			else
				echo "���:$row[1]�� ";
		}
	}
	echo "</table>\n";

echo "<p>
<table><tr><td>
1. Ŭ�� ��Ī ���濡 ���� ��<br>
1�� : �д��Ǫ������ũ��<br>
2�� : �д�źõ��Ǫ������Ŭ��(����)<br>
<br>
2. �ӿ��� �ӱ� ���濡 ���� ��<br>
1�� : ������ �ӿ��� �ӱ�� 2�������ϵ� 1ȸ�� ���ؼ� ������ �� �ִ�<br>
2�� : �ӿ��� �ӱ�� 1������ ������ �� �ִ�(����)<br>
<br>
3. ȸ�� �ǹ����� �߰� : Ŭ�� ���� �������ȸ � �ǹ� ���� <br>
- ȸĢ ��6��[ȸ���� �Ǹ��� �ǹ�]��<br>'ȸ���� �� Ŭ������ �����ϴ� �������ȸ�� Ư����<br>������ ���� �� ��ȸ ��� �����Ͽ��� �Ѵ�' �߰� ���� <br>
1�� : �߰� <br>
2�� : �߰� �ݴ�(����) <br>
<br>
4. �ӿ� �Ǽ��� �ڰ� ��� ������ ���� ��<br>
1�� : ��ȸ�� 3�������� �ӿ� �Ǽ��ű��� ����<br>
2�� : ��ȸ���� �ӿ� �Ǽ��ű��� ����(����)<br>
</table>
";

/*
	echo "<p><font color=blue>�ӿ� ������ ��ǥ ���� �� ���� ����� ��ǥ�մϴ�.</font>";
*/

?>
</center>
</body>
</html>
