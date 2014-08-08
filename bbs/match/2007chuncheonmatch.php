<?php 
require("bmauth.php");
require("bmconfig.php");
require("bmfunction.php");

	top("");
	heading("2007 춘천마라톤 대회 빅매치");

	if($logid == ""){
		die("로그인하지 않았습니다.");
	}
$betendday = "20071027";
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
제 1경기 양희왕님 대 이점우님<br>
제 2경기 김영철님 대 최남균님<br>
제 3경기 박균철님 대 박하명님(박균철님이 3분 접어줌)<br>
</table>
";
		
	echo "<p><font color=blue>베팅 결과</font>";
	for($i=0; $i<3; $i++){
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
