<?php 
require("bmauth.php");
require("bmconfig.php");
require("bmfunction.php");

	top("");
	heading("2008 ���Ƹ����� ��ȸ ���ġ");

	if($logid == ""){
		die("�α������� �ʾҽ��ϴ�.");
	}
// echo "betendday=$betendday pollid=$pollid rule0=$rule0 rule1=$rule1";
if(date("Y/m/d") < $betendday){
	$query_name="pollid,userid,polltime,poll0,poll1,poll2,poll3";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."','".$rule1."','".$rule2."','".$rule3."'";

	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_query($dbquery);
	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "<font color=red>�̹� �����ϼ̽��ϴ�.</font>";
	}else{
		echo "�����մϴ�.<br>";
		echo "������ �Ϸ�Ǿ����ϴ�.";
	}
	echo "<br>����� ��ȸ �� ��Ÿ���ϴ�.";
//	die("");
}
	echo "<p><font color=red>��ġ ����</font><br>";
	echo "<table><tr><td>
�� 1��� �̰�Դ� �� ��ȫ���<br>
�� 2��� �迵���� �� �ӱ�����<br>
�� 3��� �������� �� ���񼱴�(���������� 10�� ������)<br>
�� 4��� �Ǽ���� �� �̸�����<br>
</table>
";
		
	echo "<p><font color=blue>���� ���</font>";
	for($i=0; $i<4; $i++){
		$dbquery="select poll$i,count(*) from poll where pollid='$pollid' group by poll$i order by poll$i desc";
		$result = mysql_query($dbquery);

		$ii = $i + 1;
		echo "<p>���� $ii"."�� : <br>";
		while($row=mysql_fetch_array($result)){
			echo "&nbsp;&nbsp;- $row[0] : $row[1]��<br>";
			if(date("Y/m/d") >= $betendday){
				$dbquery2="select member.name,member.userid from poll,member where poll.pollid='$pollid' and member.userid=poll.userid and poll$i='$row[0]' order by name";
				$result2 = mysql_query($dbquery2);
				echo "$row[0] : ";
				while($row2=mysql_fetch_array($result2)){
					if($row2[1] == $logid || $logid == 'sintofood' || $logid == 'yangsimlkk' || $logid == 'run4joy')
						echo "$row2[0] ";
				}
				echo "<br>\n";
			}
		}
	}

?>
</center>
</body>
</html>
