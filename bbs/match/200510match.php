<?php 
require("bmauth.php");
require("bmconfig.php");
require("bmfunction.php");

	top("");
	heading("2005 ��õ��ȸ ���ġ");

	if($logid == ""){
		die("�α������� �ʾҽ��ϴ�.");
	}
if($mode != "pub"){
	$query_name="pollid,userid,polltime,poll0,poll1";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."','".$rule1."'";

	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_query($dbquery);

	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "<font color=red>�̹� �����ϼ̽��ϴ�.</font><br>";
		die("");
	}else{
		echo "�����մϴ�.<br>";
		echo "������ �Ϸ�Ǿ����ϴ�.<br>";
	}
}

	echo "<p><font color=blue>���� ���</font>";
	for($i=0; $i<2; $i++){
		$dbquery="select poll$i,count(*) from poll where pollid='$pollid' group by poll$i order by poll$i desc";
		$result = mysql_query($dbquery);

		$ii = $i + 1;
		echo "<p>���� $ii"."�� : <br>";
		while($row=mysql_fetch_array($result)){
			echo "<p>&nbsp;&nbsp;- $row[0] : $row[1]��<br>";
			if($logid == "seosc" || $logid == "run4joy"){
				$dbquery2="select member.name from poll,member where poll.pollid='$pollid' and member.userid=poll.userid and poll$i='$row[0]' order by name";
				$result2 = mysql_query($dbquery2);
				echo "$row[0] : ";
				while($row2=mysql_fetch_array($result2)){
					echo "$row2[0] ";
				}
				echo "<br>\n";
			}
		}
	}
	echo "<p><font color=red>���� ����</font><br>���� 1�� : ����ö��<br>���� 2�� : ���ݳ��";

?>
</center>
</body>
</html>
