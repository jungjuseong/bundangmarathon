<?php 

$pollid = "2001-1";

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

	echo "<p><font color=blue>��ǥ�� ȸ�� ��� : </font>";
	$dbquery="select member.name from poll,member where member.userid=poll.userid order by name";
	$result = mysql_query($dbquery);
	while($row=mysql_fetch_array($result)){
		echo "$row[0] ";
	}
	echo "<p><font color=blue>����ǥ ȸ�� ��� : </font>";
	$dbquery="select member.name from member left join poll on member.userid = poll.userid where poll.userid is null order by member.name";
	$result = mysql_query($dbquery);
	while($row=mysql_fetch_array($result)){
		echo "$row[0] ";
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

$mem[0] = "ȸ��";
$mem[1] = "��ȸ��";
$mem[2] = "��ȹ���";
$mem[3] = "�Ʒô��";
$mem[4] = "Ȩ���";
	echo "<p><font color=blue>������ �ӿ� ���⿡ ���� ��������� ��ǥ ����Դϴ�.</font>";
	for($i=5; $i<10; $i++){
		$dbquery="select poll$i,count(*) as cnt from poll where pollid='$pollid' group by poll$i order by cnt desc";
		$result = mysql_query($dbquery);

		$ii = $i - 5;
		echo "<p> $mem[$ii]"." ���� : ";
		while($row=mysql_fetch_array($result)){
			echo "$row[0]:$row[1]�� ";
		}
	}

?>
</center>
</body>
</html>
