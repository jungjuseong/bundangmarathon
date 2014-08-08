<?php 
	require("bmauth.php");
	require("bmconfig.php");
	require("bmfunction.php");
	top("");
	heading("2010 아!고구려마라톤 싱글매치");

	if($logid == ""){
		die("회원전용이므로 로그인 하셔야합니다.");
	}
	if($mode != "pub"){
		$query_name="pollid,userid,polltime,poll0";
		$query_value="'".$pollid."','".$logid."',now(),'".$rule1."'";
		$dbquery="insert into poll ($query_name) values($query_value)";
		$result = mysql_query($dbquery);

		if($result != "1") {
			echo "<font color=red>이미 베팅하셨습니다.</font><br>";
			die("");
		}
		else {
			echo "베팅이 완료되었습니다.<br>";
			echo "감사합니다.<br>";
		}
	}

	echo "<p><font color=blue>베팅 결과</font>";
	for($i = 0; $i < 1; $i++){
		$dbquery="select poll$i,count(*) from poll where pollid='$pollid' group by poll$i order by poll$i desc";
		$result = mysql_query($dbquery);

		$ii = $i + 1;
		echo "<p>베팅 $ii"."번 : <br>";
		while($row=mysql_fetch_array($result)){
			echo "<p>&nbsp;&nbsp;- $row[0] : $row[1]건<br>";
			if($logid == "jungjuseong" ){
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
?>
</center>
</body>
</html>
