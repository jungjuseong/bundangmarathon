<?php 
require("bmauth.php");
require("bmconfig.php");
require("bmfunction.php");

	top("");
	heading("2006 유니폼 선정");

	if($logid == ""){
		die("로그인하지 않았습니다.");
	}
if(date("Ymd") >= "20060918" && date("Ymd") <= "20060923" && $rule0 != ""){
	$query_name="pollid,userid,polltime,poll0,poll1,poll2";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."','".$rule1."','".$rule2."'";

	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_query($dbquery);
	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "<font color=red>이미 투표하셨습니다.</font>";
	}else{
		echo "감사합니다.<br>";
	}
//	echo "<br>최종 결과는 2006.9.24일부터 나타납니다.";
//	die("");
}
		
	echo "<p><font color=blue size='+2'>투표 결과</font>";
	for($i=0; $i<2; $i++){
		$dbquery="select poll$i,count(*) from poll where pollid='$pollid' group by poll$i order by poll$i ";
		$result = mysql_query($dbquery);
		if(($polledno = mysql_num_rows($result)) == 0){
			echo "<p>투표한 결과가 0 건입니다.\n";
			break;
		}else{
			$ii = $i + 1;
			echo "<p><font color=blue size='20px'>안건 $ii"."번 : </font><br>";
			$polledno = 0;
			while($row=mysql_fetch_array($result)){
				echo "&nbsp;&nbsp;- $row[0] : $row[1]건 ";
				$polledno += $row[1];
				if(date("Ymd") >= "20060918"){
					$dbquery2="select member.name,member.userid from poll,member where poll.pollid='$pollid' and member.userid=poll.userid and poll$i='$row[0]' order by name";
					$result2 = mysql_query($dbquery2);
//					echo "$row[0] : ";
					while($row2=mysql_fetch_array($result2)){
						if($row2[1] == $logid || $logid == 'ddykim' || $logid == 'run4joy')
							echo "$row2[0] ";
					}
					echo "<br>\n";
				}
			}
		}
	}
	echo "<p><font color=blue size='20px'>총 $polledno 명 투표</font><br>";

?>
</center>
</body>
</html>
