<?php 
require("bmauth.php");
require("bmconfig.php");
require("bmfunction.php");

	top("");
	heading("5�� ȸ��� ����");

echo "<font style='font-size:12pt'>";
	if($logid == ""){
		die("�α������� �ʾҽ��ϴ�.");
	}

$startday = "2008/07/02";
$endday = "2008/07/04";
	// echo "endday=$endday pollid=$pollid rule0=$rule0 rule1=$rule1";
if(date("Y/m/d") <= $endday && $mode != "result"){
	$query_name="pollid,userid,polltime,poll0,poll1";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."','".$rule1."'";
	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_query($dbquery);
	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "<font color=red>�̹� ��ǥ�ϼ̽��ϴ�.</font>";
	}else{
		echo "�����մϴ�.<br>";
		echo "��ǥ�� �Ϸ�Ǿ����ϴ�.";
	}
//	die("");
}
/*
	echo "<p><font color=red>��ǥ ����</font><br>";
	echo "<table><tr><td>
1. ȸ�� ����<br>
2. ��ȸ�� ����<br>
</table>
";
*/
	$stop = 3;
	if($logid == "run4joy") $stop = 20;
	echo "<p><font style='color=blue; font-size:20pt'>��ǥ ���</font>";
	for($i=0; $i<2; $i++){
		$dbquery="select poll$i,count(*) cnt from poll where pollid='$pollid' group by poll$i order by cnt desc";
		$result = mysql_query($dbquery);

		$ii = $i + 1;
		if($i == 0)
			echo "<p>��ǥ $ii : ȸ�� ����<br>";
		if($i == 1){
			echo "<p>��ǥ $ii : ��ȸ�� ����<br>";
		}
		for($j=0; ($row=mysql_fetch_array($result)) && $j < $stop; $j++){
			if($i == 0)
				echo " - $row[0] : $row[1]��<br>";
			if(date("Y/m/d") > $endday){
				if($i == 1){
					if($j < 2)
						echo " - $row[0]�� : $row[1]��<br>";
					else
						echo " - ". ($j + 1) . "����(�����) : $row[1]��<br>";
						
				}
				echo "<br>\n";
			}else{
				if($i == 1 && $j == 0)
					echo "* ��ǥ���� �� ��ȸ������ �ִٵ�ǥ�� 2���� ǥ�õ˴ϴ�.";
			}
		}
	}
	if($logid == "rrun4joy" || $logid == "rrun4joy"){
		echo "<p>��ǥ�Ϸ� ȸ��: ";
		$dbquery2="select member.name,member.userid from poll,member where poll.pollid='$pollid' and member.userid=poll.userid order by name";
		$result2 = mysql_query($dbquery2);
		while($row2=mysql_fetch_array($result2)){
			if($logid == 'run4joy')
				echo "$row2[0] ";
		}
	}


?>
</font>
</center>
</body>
</html>
