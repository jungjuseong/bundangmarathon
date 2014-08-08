<?php 
require("bmauth.php");
require("bmconfig.php");
require("bmfunction.php");

	top("");
	heading("5기 회장단 선출");

echo "<font style='font-size:12pt'>";
	if($logid == ""){
		die("로그인하지 않았습니다.");
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
		echo "<font color=red>이미 투표하셨습니다.</font>";
	}else{
		echo "감사합니다.<br>";
		echo "투표가 완료되었습니다.";
	}
//	die("");
}
/*
	echo "<p><font color=red>투표 내용</font><br>";
	echo "<table><tr><td>
1. 회장 선출<br>
2. 부회장 선출<br>
</table>
";
*/
	$stop = 3;
	if($logid == "run4joy") $stop = 20;
	echo "<p><font style='color=blue; font-size:20pt'>투표 결과</font>";
	for($i=0; $i<2; $i++){
		$dbquery="select poll$i,count(*) cnt from poll where pollid='$pollid' group by poll$i order by cnt desc";
		$result = mysql_query($dbquery);

		$ii = $i + 1;
		if($i == 0)
			echo "<p>투표 $ii : 회장 선출<br>";
		if($i == 1){
			echo "<p>투표 $ii : 부회장 선출<br>";
		}
		for($j=0; ($row=mysql_fetch_array($result)) && $j < $stop; $j++){
			if($i == 0)
				echo " - $row[0] : $row[1]건<br>";
			if(date("Y/m/d") > $endday){
				if($i == 1){
					if($j < 2)
						echo " - $row[0]님 : $row[1]건<br>";
					else
						echo " - ". ($j + 1) . "위님(비공개) : $row[1]건<br>";
						
				}
				echo "<br>\n";
			}else{
				if($i == 1 && $j == 0)
					echo "* 투표종료 후 부회장으로 최다득표한 2분이 표시됩니다.";
			}
		}
	}
	if($logid == "rrun4joy" || $logid == "rrun4joy"){
		echo "<p>투표완료 회원: ";
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
