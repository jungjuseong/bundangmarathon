<?php 
require("/bbs/bmauth.php");
require("/bbs/bmconfig.php");
require("/bbs/bmfunction.php");

	top();
	heading("2005 ��õ��ȸ ���ġ");

	if($logid == ""){
		die("�α������� �ʾҽ��ϴ�.");
	}
	$query_name="pollid,userid,polltime,poll0,poll1";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."','".$rule1."'";

	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_db_query("coretek",$dbquery);

	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "<font color=red>�̹� �����ϼ̽��ϴ�.</font><br>";
		die("");
	}else{
		echo "�����մϴ�.<br>";
		echo "������ �Ϸ�Ǿ����ϴ�.<br>";
	}

	echo "<p><font color=blue>������ ��������� ���� ����Դϴ�.</font>";
	for($i=0; $i<2; $i++){
		$dbquery="select poll$i,count(*) from poll where pollid='$pollid' group by poll$i order by poll$i desc";
		$result = mysql_query($dbquery);

		$ii = $i + 1;
		echo "<p>���� $ii"."�� : <br>";
		while($row=mysql_fetch_array($result)){
			echo "<&nbsp><&nbsp>- $row[0] : $row[1]��<br>";
		}
	}

?>
</center>
</body>
</html>
