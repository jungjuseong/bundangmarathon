<?php 
$comdir = "../";
require($comdir."auth.php");
require($comdir."config.php");

function top(){
echo "
<html>
<head>
<title>총회 안건 투표</title>
</head>

<body>
<center>
";
}

function heading($msg){
	echo "<font size='+2'>".$msg."</font>";
	echo "<hr color=red width='80%'>\n<p>";
}

mysql_select_db("gumpu") or die("mysql_select_db error");

	top();
	heading("총회 안건 투표");

	if($logid == ""){
		die("로그인하지 않았습니다.");
	}
    if($mem0 != ""){
	$query_name="pollid,userid,polltime,poll0,poll1,poll2,poll3,poll4";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."','".$rule1."','".$rule2."','".$rule3."','".$rule4."'";

	$query_name.=",poll5,poll6,poll7,poll8,poll9";
	$query_value.=",'".$mem0."','".$mem1."','".$mem2."','".$mem3."','".$mem4."'";
	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_db_query("gumpu",$dbquery);

	mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "<font color=red>이미 투표하셨습니다.</font><br>";
		echo "<br>";;
	}else{
		echo "감사합니다.<br>";
		echo "투표 처리가 완료되었습니다.<br>";
	}
    }

	echo "<p><font color=blue>다음은 임원 선출에 대한 현재까지의 1,2,3위 득표 결과입니다.</font>\n";
	echo "<p><table><tr><td>\n";

	$dbquery="select count(*) from poll where pollid='$pollid'";
	$result = mysql_query($dbquery);
	$row=mysql_fetch_array($result);
	echo "<p>총 투표 인원 : $row[0] 명<p>";
	mysql_free_result($result);

	for($i=5; $i<10; $i++){
		$dbquery="select poll$i,count(*) as cnt from poll where pollid='$pollid' group by poll$i order by cnt desc limit 3";
		$result = mysql_query($dbquery);

		$ii = $i - 4;
		echo "<p>임원 선출 $ii"."번 항목 : ";
		while($row=mysql_fetch_array($result)){
			echo " $row[0] $row[1]표 ";
		}
		mysql_free_result($result);
	}
	echo "</table>\n";

echo "<p>
<table><tr><td>
1. 회장<br>
2. 부회장<br>
3. 기획담당<br>
4. 훈련담당<br>
5. 홈담당 <br>
</table>
";

?>
</center>
</body>
</html>
