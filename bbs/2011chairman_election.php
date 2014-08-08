<?php 
require("bmauth.php");
require("bmconfig.php");
require("bmfunction.php");

	top("");
	heading("제 7대 회장단 선임 투표");

	if($logid == ""){
		die("로그인하지 않았습니다.");
	}
if($mode != "pub"){
	$query_name="pollid,userid,polltime,poll0";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."'";
	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_query($dbquery);

	if($result!="1"){
		echo "<font color=red>이미 투표 하셨습니다.</font><br>";
		die("");
	}
            else{
		echo "감사합니다.<br>";
		echo "<p>투표가 완료되었습니다.<br>";
	}
}

if($logid == "seosc" || $logid == "run4joy"){
	echo "<p><font color=blue>투표 결과</font>";
	for($i=0; $i<1; $i++){
		$dbquery="select poll$i,count(*) from poll where pollid='$pollid' group by poll$i order by poll$i desc";
		$result = mysql_query($dbquery);

		$ii = $i + 1;
		echo "<p>[ 투표 $ii"."번 ] <br>";
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
	echo "<p> <font color=blue> 투표 결과는 12월 3일(송년회/총회) 공개합니다.</font>";
}
?>
</center>
</body>
</html>
