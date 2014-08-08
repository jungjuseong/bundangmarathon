<?php 
require("bmauth.php");
require("bmconfig.php");
require("bmfunction.php");

	top("");
	heading("2006 유니폼 신청");

	if($logid == ""){
		die("로그인하지 않았습니다.");
	}
if(date("Ymd") >= "20060927" && date("Ymd") <= "20060929" && $rule0 != ""){
	$query_name="pollid,userid,polltime,poll0";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."'";

	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_query($dbquery);
	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		$dbquery="update poll set poll0 = '$rule0', polltime = now() where pollid = '$pollid' and userid = '$logid'";
		$result = mysql_query($dbquery);
		echo "수정 감사합니다.<br>";
	}else{
		echo "신청 감사합니다.<br>";
		if($logid == 'marajeon' || $logid == 'rrun4joy'){
		}else{
			echo "<br><a href='javascript:window.close()'>닫기</a>";
			die("");
		}
	}
	if($logid == 'marajeon' || $logid == 'run4joy' || $logid == 'yangsimlkk'){
	}else{
		echo "<br><br><a href='javascript:window.close()'>닫기</a>";
		die("");
	}
//	die("");
}
		
	echo "<p><font color=blue size='+2'>유니폼 신청 결과</font><p>";
	for($i=0; $i<1; $i++){
		$dbquery="select poll$i,count(*) from poll where pollid='$pollid' group by poll$i order by poll$i ";
		$result = mysql_query($dbquery);
		if(($polledno = mysql_num_rows($result)) == 0){
			echo "<p>신청한 결과가 0 건입니다.\n";
			break;
		}else{
			$ii = $i + 1;
//			echo "<p><font color=blue size='20px'>안건 $ii"."번 : </font><br>";
			$polledno = 0;
			while($row=mysql_fetch_array($result)){
				echo "&nbsp;&nbsp;- $row[0] : $row[1]건 ";
				$polledno += $row[1];
				if(date("Ymd") >= "20060927"){
					$dbquery2="select member.name,member.userid from poll,member where poll.pollid='$pollid' and member.userid=poll.userid and poll$i='$row[0]' order by name";
					$result2 = mysql_query($dbquery2);
//					echo "$row[0] : ";
					while($row2=mysql_fetch_array($result2)){
						if($row2[1] == $logid || $logid == 'marajeon' || $logid == 'run4joy' || $logid == 'yangsimlkk')
							echo "$row2[0] ";
					}
					echo "<br>\n";
				}
			}
		}
	}
	echo "<p><font color=blue size='20px'>총 $polledno 명 신청</font><br>";

?>
</center>
</body>
</html>
