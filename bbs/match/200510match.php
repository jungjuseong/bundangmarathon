<?php 
require("bmauth.php");
require("bmconfig.php");
require("bmfunction.php");

	top("");
	heading("2005 춘천대회 빅매치");

	if($logid == ""){
		die("로그인하지 않았습니다.");
	}
if($mode != "pub"){
	$query_name="pollid,userid,polltime,poll0,poll1";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."','".$rule1."'";

	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_query($dbquery);

	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "<font color=red>이미 베팅하셨습니다.</font><br>";
		die("");
	}else{
		echo "감사합니다.<br>";
		echo "베팅이 완료되었습니다.<br>";
	}
}

	echo "<p><font color=blue>베팅 결과</font>";
	for($i=0; $i<2; $i++){
		$dbquery="select poll$i,count(*) from poll where pollid='$pollid' group by poll$i order by poll$i desc";
		$result = mysql_query($dbquery);

		$ii = $i + 1;
		echo "<p>베팅 $ii"."번 : <br>";
		while($row=mysql_fetch_array($result)){
			echo "<p>&nbsp;&nbsp;- $row[0] : $row[1]건<br>";
			if($logid == "seosc" || $logid == "run4joy"){
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
	echo "<p><font color=red>최종 승자</font><br>베팅 1번 : 서상철님<br>베팅 2번 : 윤금노님";

?>
</center>
</body>
</html>
