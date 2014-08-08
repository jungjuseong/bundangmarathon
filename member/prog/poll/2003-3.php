<?php 
$comdir = "../";
require($comdir."auth.php");
require($comdir."config.php");
require($comdir."function.php");

mysql_select_db("gumpu") or die("mysql_select_db error");

	top("");
	heading("총회 안건 투표");

	if($logid == ""){
		die("로그인하지 않았습니다.");
	}
echo $userid;
    if($rule0 != ""){
	$query_name="pollid,userid,polltime,ip";
	$query_value="'".$pollid."','".$logid."',now(),'$REMOTE_ADDR'";

	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_db_query("gumpu",$dbquery);

	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "<font color=red>이미 투표하셨습니다.</font><br>";
		echo "<br>";;
	}else{
		$query_name="pollid,poll0,poll1,poll2,poll3,poll4";
		$query_value="'".$pollid."','".$rule0."','".$rule1."','".$rule2."','".$rule3."','".$rule4."'";

		$query_name.=",poll5,poll6,poll7,poll8,poll9";
		$query_value.=",'".$rule5."','".$rule6."','".$rule7."','".$rule8."','".$rule9."'";
		$query_name.=",poll10,poll11";
		$query_value.=",'".$rule10."','".$rule11."'";
		$dbquery="insert into poll2 ($query_name) values($query_value)";
		$result = mysql_db_query("gumpu",$dbquery);
		if($result!="1"){
		}else{
			$dbquery="delete from poll where pollid='$pollid' and userid='$logid'";
			$result = mysql_db_query("gumpu",$dbquery);
			echo "DB(poll2) 오류 발생\n";
			echo "감사합니다.<br>";
			echo "투표 처리가 완료되었습니다.<br>";
		}
	}
    }

	$starttime = mktime(9,0,0,12,1,2003);
	$stoptime = mktime(23,59,59,12,3,2003);
	$currenttime = mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));


    if(privcheck($logid) == 2 || $currenttime > $stoptime){
    	if($currenttime > $stoptime)
		echo "<p><font color=blue>다음은 2003 총회 안건에 대한 투표 결과입니다.</font>";
	else
		echo "<p><font color=blue>다음은 2003 총회 안건에 대한 현재까지의 투표 결과입니다.</font>";

	$dbquery="select count(*) from poll where pollid='$pollid'";
	$result = mysql_query($dbquery);
	$row=mysql_fetch_array($result);
	echo "<p>총 투표 인원 : $row[0] 명<p>";
	mysql_free_result($result);
    }

$items = array();
$filelines = file("2003-3.html");
$ii = 0;
for($i = 0; $i < count($filelines); $i++){
	if(substr($filelines[$i], 0, 8) == "<!-- -->")	// 안건 첫부분 표시
		$items[$ii++] = $filelines[$i];
}
    if($currenttime > $stoptime){
	echo "<p><table border=1 width='80%'><tr><th>안건<th width=100>투표결과\n";
	for($i=0; $i < count($items); $i++){
		$dbquery="select poll$i,count(*) from poll2 where pollid='$pollid' group by poll$i order by poll$i";
		$result = mysql_query($dbquery);

		echo "\n<tr><td>$items[$i]<td>";
		while($row=mysql_fetch_array($result)){
			echo "$row[0]:$row[1]건<br>";
		}
	}
	echo "</table>\n";
    }


?>
</center>
</body>
</html>
