<?php 
require("bmauth.php");
require("bmconfig.php");
require("bmfunction.php");

	top("");
	heading("2006.6 ȸĢ ����");

	if($logid == ""){
		die("�α������� �ʾҽ��ϴ�.");
	}
if(date("Ymd") >= "20060605" && date("Ymd") <= "20060609" && $rule0 != ""){
	$query_name="pollid,userid,polltime,poll0,poll1,poll2";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."','".$rule1."','".$rule2."'";

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
	echo "<br>���� ����� 2006.6.10�Ϻ��� ��Ÿ���ϴ�.";
//	die("");
}
		
	echo "<p><font color=blue>��ǥ ���</font>";
	for($i=0; $i<3; $i++){
		$dbquery="select poll$i,count(*) from poll where pollid='$pollid' group by poll$i order by poll$i desc";
		$result = mysql_query($dbquery);
		if(mysql_num_rows($result) == 0){
			echo "<p>��ǥ�� ����� 0 ���Դϴ�.\n";
			break;
		}else{
			$ii = $i + 1;
			echo "<p>�Ȱ� $ii"."�� : <br>";
			while($row=mysql_fetch_array($result)){
				echo "&nbsp;&nbsp;- $row[0] : $row[1]�� ";
				if(date("Ymd") >= "20060610"){
					$dbquery2="select member.name,member.userid from poll,member where poll.pollid='$pollid' and member.userid=poll.userid and poll$i='$row[0]' order by name";
					$result2 = mysql_query($dbquery2);
//					echo "$row[0] : ";
					while($row2=mysql_fetch_array($result2)){
						if($row2[1] == $logid || $logid == 'ddykim' || $logid == 'sseosc' || $logid == 'rrun4joy')
							echo "$row2[0] ";
					}
					echo "<br>\n";
				}
			}
		}
	}

?>
</center>
</body>
</html>
