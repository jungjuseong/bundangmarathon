<?php 
require("bmauth.php");
require("bmconfig.php");
require("bmfunction.php");

	top("");
	heading("2006 ������ ����");

	if($logid == ""){
		die("�α������� �ʾҽ��ϴ�.");
	}
if(date("Ymd") >= "20060918" && date("Ymd") <= "20060923" && $rule0 != ""){
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
	}
//	echo "<br>���� ����� 2006.9.24�Ϻ��� ��Ÿ���ϴ�.";
//	die("");
}
		
	echo "<p><font color=blue size='+2'>��ǥ ���</font>";
	for($i=0; $i<2; $i++){
		$dbquery="select poll$i,count(*) from poll where pollid='$pollid' group by poll$i order by poll$i ";
		$result = mysql_query($dbquery);
		if(($polledno = mysql_num_rows($result)) == 0){
			echo "<p>��ǥ�� ����� 0 ���Դϴ�.\n";
			break;
		}else{
			$ii = $i + 1;
			echo "<p><font color=blue size='20px'>�Ȱ� $ii"."�� : </font><br>";
			$polledno = 0;
			while($row=mysql_fetch_array($result)){
				echo "&nbsp;&nbsp;- $row[0] : $row[1]�� ";
				$polledno += $row[1];
				if(date("Ymd") >= "20060918"){
					$dbquery2="select member.name,member.userid from poll,member where poll.pollid='$pollid' and member.userid=poll.userid and poll$i='$row[0]' order by name";
					$result2 = mysql_query($dbquery2);
//					echo "$row[0] : ";
					while($row2=mysql_fetch_array($result2)){
						if($row2[1] == $logid || $logid == 'ddykim' || $logid == 'run4joy')
							echo "$row2[0] ";
					}
					echo "<br>\n";
				}
			}
		}
	}
	echo "<p><font color=blue size='20px'>�� $polledno �� ��ǥ</font><br>";

?>
</center>
</body>
</html>
