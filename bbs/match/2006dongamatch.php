<?php 
require("bmauth.php");
require("bmconfig.php");
require("bmfunction.php");

	top("");
	heading("2006 동아마라톤 대회 빅매치");

	if($logid == ""){
		die("로그인하지 않았습니다.");
	}
if(date("Ymd") < "20060312"){
	$query_name="pollid,userid,polltime,poll0,poll1,poll2,poll3,poll4,poll5,poll6,poll7,poll8,poll9";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."','".$rule1."','".$rule2."','".$rule3."','".$rule4."','".$rule5."','".$rule6."','".$rule7."','".$rule8."','".$rule9."'";

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
제  1 경기 김경아 vs 김매자(勝)<br>
제  2 경기 유성복(勝) vs 이희원<br>
제  3 경기 나광섭 vs 김영헌A(勝)<br>
제  4 경기 박하명(勝 ) vs 이경규<br>
제  5 경기 김철영(勝) vs 이경태<br>
제  6 경기 이홍석 vs 안경근(勝<br>
제  8 경기 정주성(勝) vs 윤재경<br>
제  9 경기 김도연 vs 김영근(勝)<br>
제 10 경기 정관택(勝) vs 황규철<br>
</table>
";
		
	echo "<p><font color=blue>베팅 결과</font>";
	for($i=0; $i<10; $i++){
		$dbquery="select poll$i,count(*) from poll where pollid='$pollid' group by poll$i order by poll$i desc";
		$result = mysql_query($dbquery);

		$ii = $i + 1;
		echo "<p>베팅 $ii"."번 : <br>";
		while($row=mysql_fetch_array($result)){
			echo "&nbsp;&nbsp;- $row[0] : $row[1]건<br>";
			if(date("Ymd") >= "20060312"){
				$dbquery2="select member.name,member.userid from poll,member where poll.pollid='$pollid' and member.userid=poll.userid and poll$i='$row[0]' order by name";
				$result2 = mysql_query($dbquery2);
				echo "$row[0] : ";
				while($row2=mysql_fetch_array($result2)){
					if($row2[1] == $logid || $logid == 'dykim' || $logid == 'seosc' || $logid == 'run4joy')
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
