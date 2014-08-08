<?php 

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

	if($logid == ""){
		die("로그인하지 않았습니다.");
	}
	$query_name="pollid,userid,polltime,poll0,poll1,poll2,poll3,poll4";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."','".$rule1."','".$rule2."','".$rule3."','".$rule4."'";

	$query_name.=",poll5,poll6,poll7,poll8,poll9";
	$query_value.=",'".$mem0."','".$mem1."','".$mem2."','".$mem3."','".$mem4."'";
	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_db_query("coretek",$dbquery);

	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "<font color=red>이미 투표하셨습니다.</font><br>";
		die("");
	}else{
		echo "감사합니다.<br>";
		echo "투표 처리가 완료되었습니다.<br>";
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

	echo "<p><font color=blue>임원 선출은 투표 종료 후 최종 결과를 발표합니다.</font>";

?>
</center>
</body>
</html>
