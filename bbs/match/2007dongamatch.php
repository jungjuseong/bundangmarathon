<?php 
require("bmauth.php");
require("bmconfig.php");
require("bmfunction.php");

	top("");
	heading("2007 동아마라톤 대회 빅매치");

	if($logid == ""){
		die("로그인하지 않았습니다.");
	}
$betendday = "20070318";
if(date("Ymd") < $betendday){
	$query_name="pollid,userid,polltime,poll0,poll1,poll2,poll3";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."','".$rule1."','".$rule2."','".$rule3."'";

	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_query($dbquery);
	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "<font color=red>이미 베팅하셨습니다.</font>";
	}else{
		echo "감사합니다.<br>";
		echo "베팅이 완료되었습니다.";
	}
	echo "<br>결과는 대회 후 나타납니다.";
//	die("");
}
	echo "<p><font color=red>매치 내용</font><br>";
	echo "<table><tr><td>
제 1경기 이종창 대 박희선<br>
제 2경기 김도연 대 전제원<br>
제 3경기 송재혁 대 최영대<br>
제 4경기 김영백 대 조상국<br>
<!--
제  1 경기 김경아 vs 김매자(勝)<br>
제  2 경기 유성복(勝) vs 이희원<br>
제  3 경기 나광섭 vs 김영헌A(勝)<br>
제  4 경기 박하명(勝 ) vs 이경규<br>
-->
</table>
";
		
	echo "<p><font color=blue>베팅 결과</font>";
	for($i=0; $i<4; $i++){
		$dbquery="select poll$i,count(*) from poll where pollid='$pollid' group by poll$i order by poll$i desc";
		$result = mysql_query($dbquery);

		$ii = $i + 1;
		echo "<p>베팅 $ii"."번 : <br>";
		while($row=mysql_fetch_array($result)){
			echo "&nbsp;&nbsp;- $row[0] : $row[1]건<br>";
			if(date("Ymd") >= $betendday){
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
