<?php 
$comdir = "../";
require($comdir."auth.php");
require($comdir."config.php");
require($comdir."function.php");

mysql_select_db("gumpu") or die("mysql_select_db error");

	top("");
	heading("회장 재신임 투표 결과");

	if($logid == ""){
		die("로그인하지 않았습니다.");
	}
    if($rule0 != ""){
	$dbquery="select name, grade from member where userid='$logid' and membertype='정회원'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	if( mysql_numrows( $result ) == 1){
		$qualify = "Y";
	}else{
		die("정회원만 투표 가능합니다.");
	}
	mysql_free_result($result);

	$query_name="pollid,userid,polltime,poll0";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."'";

	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_db_query("gumpu",$dbquery);

//	mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "<font color=red>이미 투표하셨습니다.</font><br>";
		echo "<br>";;
	}else{
		echo "감사합니다.<p>";
		echo "투표 처리가 완료되었습니다.<br>";
	}
    }

	$starttime = mktime(12,0,0,6,16,2003);
	$stoptime = mktime(23,59,0,6,18,2003);
	$currenttime = mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));

	if($currenttime > $stoptime){
		echo "<p><font color=blue>다음은 투표 결과입니다.</font>\n";
	}else{
		echo "<p><font color=blue>다음은 현재까지의 투표 결과입니다.</font>\n";
	}
	echo "<p><table><tr><td>\n";

	$dbquery="select count(*) from poll where pollid='$pollid'";
	$result = mysql_query($dbquery);
	$row=mysql_fetch_array($result);
	echo "<p>총 투표 인원 : $row[0] 명<p>";
	mysql_free_result($result);

if(privcheck($logid) == 2 || $currenttime > $stoptime){
	for($i=0; $i<1; $i++){
		$dbquery="select poll$i,count(*) as cnt from poll where pollid='$pollid' group by poll$i order by cnt desc limit 3";
		$result = mysql_query($dbquery);

//		$ii = $i - 4;
//		echo "<p>임원 선출 $ii"."번 항목 : ";
		if($currenttime < $stoptime){
			echo "<p>(관리자용 정보) 회장 재신임 : ";
		}else{
			echo "<p>회장 재신임 : ";
		}
		while($row=mysql_fetch_array($result)){
			echo " $row[0]:$row[1]표 ";
		}
		mysql_free_result($result);
	}
}else{
	echo "<p>투표 결과는 투표가 끝난 후 공개됩니다. ";
}
	echo "</table>\n";

?>
</center>
</body>
</html>
