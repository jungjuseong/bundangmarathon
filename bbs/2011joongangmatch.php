<?php 
require("bmauth.php");
require("bmconfig.php");
require("bmfunction.php");

	top("");
	heading("2011 중앙마라톤대회 빅매치");

	if($logid == ""){
		die("로그인하지 않았습니다.");
	}
if($mode != "pub"){
	$query_name="pollid,userid,polltime,poll0,poll1,poll2,poll3,poll4,poll5,poll6";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."','".$rule1."','".$rule2."','".$rule3."','".$rule4."','".$rule5."','".$rule6."'";
	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_query($dbquery);

	if($result!="1"){
		echo "<font color=red>이미 베팅하셨습니다.</font><br>";
		die("");
	}
            else{
		echo "감사합니다.<br>";
		echo "<p>베팅이 완료되었습니다.<br>";
	}
}

if($logid == "seosc" || $logid == "run4joy"){
	echo "<p><font color=blue>베팅 결과</font>";
	for($i=0; $i<7; $i++){
		$dbquery="select poll$i,count(*) from poll where pollid='$pollid' group by poll$i order by poll$i desc";
		$result = mysql_query($dbquery);

		$ii = $i + 1;
		echo "<p>[ 베팅 $ii"."번 ] <br>";
		while($row=mysql_fetch_array($result)){
			echo "<p>&nbsp;&nbsp;- $row[0] : $row[1]건<br>";
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
	echo "<p> <font color=blue> 베팅 결과는 11월 7일(월요일) 공개됩니다.</font>";
}
?>
</center>
</body>
</html>
