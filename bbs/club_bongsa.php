<?php 
require("bmauth.php");
require("bmconfig.php");
require("bmfunction.php");

	top("");
	heading("��ȸ�� Ŭ�� Ȱ���о� ����");

	if($logid == ""){
		die("�α������� �ʾҽ��ϴ�.");
	}
if($mode != "pub"){
	$query_name="pollid,userid,polltime,poll0";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."'";
	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_query($dbquery);

	if($result!="1"){
		echo "<font color=red>�̹� �����ϼ̽��ϴ�.</font><br>";
		die("");
	}
            else{
		echo "�����մϴ�.<br>";
		echo "<p>������ �Ϸ�Ǿ����ϴ�.<br>";
	}
}

if($logid == "seosc" || $logid == "run4joy" || $logid == "jungjuseong"){
	echo "<p><font color=blue>���� ���</font>";
	for($i=0; $i<1; $i++){
		$dbquery="select poll$i,count(*) from poll where pollid='$pollid' group by poll$i order by poll$i desc";
		$result = mysql_query($dbquery);

		$ii = $i + 1;
		echo "<p>[ ���� $ii"."�� ] <br>";
		while($row=mysql_fetch_array($result)){
			echo "<p>&nbsp;&nbsp;- $row[0] : $row[1]��<br>";
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
else{
	echo "<p> <font color=blue> ���� ����� �繫������ ���� ������ �����Դϴ�..</font>";
}
?>
</center>
</body>
</html>
