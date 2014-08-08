<?php 
require("bmauth.php");
require("bmconfig.php");
require("bmfunction.php");

	top("");
	heading("2006.6 회칙 개정");

	if($logid == ""){
		die("로그인하지 않았습니다.");
	}
if(date("Ymd") >= "20060605" && date("Ymd") <= "20060609" && $rule0 != ""){
	$query_name="pollid,userid,polltime,poll0,poll1,poll2";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."','".$rule1."','".$rule2."'";

	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_query($dbquery);
	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "<font color=red>이미 투표하셨습니다.</font>";
	}else{
		echo "감사합니다.<br>";
		echo "투표가 완료되었습니다.";
	}
	echo "<br>최종 결과는 2006.6.10일부터 나타납니다.";
//	die("");
}
		
	echo "<p><font color=blue>투표 결과</font>";
	for($i=0; $i<3; $i++){
		$dbquery="select poll$i,count(*) from poll where pollid='$pollid' group by poll$i order by poll$i desc";
		$result = mysql_query($dbquery);
		if(mysql_num_rows($result) == 0){
			echo "<p>투표한 결과가 0 건입니다.\n";
			break;
		}else{
			$ii = $i + 1;
			echo "<p>안건 $ii"."번 : <br>";
			while($row=mysql_fetch_array($result)){
				echo "&nbsp;&nbsp;- $row[0] : $row[1]건 ";
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
