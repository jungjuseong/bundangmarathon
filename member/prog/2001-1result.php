<?php 

$pollid = "2001-1";

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

require("../../race/2001/config.php");
mysql_select_db("coretek") or die("mysql_select_db error");

	top();
	heading("총회 안건 투표");

	echo "<p><font color=blue>투표한 회원 명단 : </font>";
	$dbquery="select member.name from poll,member where member.userid=poll.userid order by name";
	$result = mysql_query($dbquery);
	while($row=mysql_fetch_array($result)){
		echo "$row[0] ";
	}
	echo "<p><font color=blue>미투표 회원 명단 : </font>";
	$dbquery="select member.name from member left join poll on member.userid = poll.userid where poll.userid is null order by member.name";
	$result = mysql_query($dbquery);
	while($row=mysql_fetch_array($result)){
		echo "$row[0] ";
	}

	echo "<p><font color=blue>다음은 회칙 개정에 대한 현재까지의 투표 결과입니다.</font>";
	for($i=0; $i<5; $i++){
		$dbquery="select poll$i,count(*) from poll where pollid='$pollid' group by poll$i order by poll$i desc";
		$result = mysql_query($dbquery);

		$ii = $i + 1;
		echo "<p>회칙 개정 $ii"."번 항목 : ";
		while($row=mysql_fetch_array($result)){
			echo "$row[0]:$row[1]건 ";
		}
	}

$mem[0] = "회장";
$mem[1] = "부회장";
$mem[2] = "기획담당";
$mem[3] = "훈련담당";
$mem[4] = "홈담당";
	echo "<p><font color=blue>다음은 임원 선출에 대한 현재까지의 투표 결과입니다.</font>";
	for($i=5; $i<10; $i++){
		$dbquery="select poll$i,count(*) as cnt from poll where pollid='$pollid' group by poll$i order by cnt desc";
		$result = mysql_query($dbquery);

		$ii = $i - 5;
		echo "<p> $mem[$ii]"." 선출 : ";
		while($row=mysql_fetch_array($result)){
			echo "$row[0]:$row[1]건 ";
		}
	}

?>
</center>
</body>
</html>
