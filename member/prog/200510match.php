<?php 
require("/bbs/bmauth.php");
require("/bbs/bmconfig.php");
require("/bbs/bmfunction.php");

	top();
	heading("2005 춘천대회 빅매치");

	if($logid == ""){
		die("로그인하지 않았습니다.");
	}
	$query_name="pollid,userid,polltime,poll0,poll1";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."','".$rule1."'";

	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_db_query("coretek",$dbquery);

	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "<font color=red>이미 베팅하셨습니다.</font><br>";
		die("");
	}else{
		echo "감사합니다.<br>";
		echo "베팅이 완료되었습니다.<br>";
	}

	echo "<p><font color=blue>다음은 현재까지의 베팅 결과입니다.</font>";
	for($i=0; $i<2; $i++){
		$dbquery="select poll$i,count(*) from poll where pollid='$pollid' group by poll$i order by poll$i desc";
		$result = mysql_query($dbquery);

		$ii = $i + 1;
		echo "<p>베팅 $ii"."번 : <br>";
		while($row=mysql_fetch_array($result)){
			echo "<&nbsp><&nbsp>- $row[0] : $row[1]건<br>";
		}
	}

?>
</center>
</body>
</html>
