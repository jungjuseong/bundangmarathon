<?php 
$comdir = "../";
require($comdir."auth.php");
require($comdir."config.php");

function top(){
echo "
<html>
<head>
<title>투표</title>
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
	heading("유니폼 관련 의견 수렴");

	if($logid == ""){
		die("로그인하지 않았습니다.");
	}
if($rule0 != ""){
if($rule0 != ""){
		echo "투표 기간이 지났습니다.<br>";
}else{
	$query_name="pollid,userid,polltime,poll0,poll1,poll2,poll3,poll4";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."','".$rule1."','".$rule2."','".$rule3."','".$rule4."'";

	$query_name.=",poll5,poll6,poll7,poll8,poll9";
	$query_value.=",'".$mem0."','".$mem1."','".$mem2."','".$mem3."','".$mem4."'";
	$dbquery="insert into poll ($query_name) values($query_value)";
	$result = mysql_db_query("gumpu",$dbquery);

	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "<font color=red>이미 투표하셨습니다.</font><br>";
		die("");
	}else{
		echo "감사합니다.<br>";
		echo "투표 처리가 완료되었습니다.<br>";
	}
}
}

	echo "<p><font color=blue>다음은 현재까지의 투표 결과입니다.</font>";
	for($i=0; $i<2; $i++){
		$dbquery="select poll$i,count(*) from poll where pollid='$pollid' group by poll$i order by poll$i desc";
		$result = mysql_query($dbquery);

		if($i == 0){
			echo "<p>설문 1번 색상 항목 ";
		}else{
			echo "<p>설문 2번 디자인 항목 ";
		}
		while($row=mysql_fetch_array($result)){
			if($i == 0){
				if($row[0] == "Y")
					$qstr = "현재 색상이 좋다";
				else
					$qstr = "다양화 차원에서 이번에는 새로운 색으로 해보자";
			}else{
				if($row[0] == "Y")
					$qstr = "현재 디자인이 좋다";
				else
					$qstr = "다양화 차원에서 이번에는 새로운 디자인으로 해보자 ";
			}
			echo "<br>$qstr:$row[1]건 ";
		}
	}


?>
</center>
</body>
</html>
