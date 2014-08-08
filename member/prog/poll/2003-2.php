<?php 
$comdir = "../";
require($comdir."auth.php");
require($comdir."config.php");

function top(){
echo "
<html>
<head>
<title>2003 임원 선거 후보 추천</title>
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
	heading("2003 임원 선거 후보 추천");

	if($logid == ""){
		die("로그인하지 않았습니다.");
	}
    if($mem0 != ""){
	$query_name="pollid,userid,polltime,poll0,poll1,poll2,poll3,poll4";
	$query_value="'".$pollid."','".$logid."',now(),'".$mem0."','".$mem1."','".$mem2."','".$mem3."','".$mem4."'";

	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_db_query("gumpu",$dbquery);

//	mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		$dbquery="update poll set polltime=now(),poll0='$mem0', poll1='$mem1', poll2='$mem2', poll3='$mem3', poll4='$mem4' where pollid='$pollid' and userid='$logid'";
		$result = mysql_db_query("gumpu",$dbquery);
		echo "<font color=red>투표 수정이 완료되었습니다.</font><br>";
		echo "<br>";;
	}else{
		echo "감사합니다.<br>";
		echo "투표 처리가 완료되었습니다.<br>";
	}
    }

	$dbquery="select count(*) from poll where pollid='$pollid'";
	$result = mysql_query($dbquery);
	$row=mysql_fetch_array($result);
	echo "<p>총 투표 인원 : $row[0] 명<p>";
	mysql_free_result($result);

	$starttime = mktime(8,0,0,11,12,2003);
	$stoptime = mktime(18,0,0,11,18,2003);
	$currenttime = mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));

if($currenttime > $stoptime){
    if($logid == "nogok"){	/* 기획팀장 */
	echo "<p><font color=blue>다음은 임원 추천에 대한 현재까지의 1~5위 득표 결과입니다.</font>\n";
	echo "<p><table><tr><td>\n";

$imwon = array ("회장", "부회장", "기획팀장", "훈련팀장", "미디어팀장");
	for($i=0; $i<5; $i++){
		$dbquery="select poll$i,count(*) as cnt from poll where pollid='$pollid' group by poll$i order by cnt desc limit 5";
		$result = mysql_query($dbquery);

		echo "<p>$imwon[$i] 추천 : ";
		while($row=mysql_fetch_array($result)){
			echo " $row[0] $row[1]표 ";
		}
		mysql_free_result($result);
	}
	echo "</table>\n";
    }
}

?>
</center>
</body>
</html>
