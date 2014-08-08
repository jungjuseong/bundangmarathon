<?php

function top(){
echo "
<html>
<head>
<title>유니폼 디자인 선정 설문조사</title>
</head>

<body>
<center>
";
}

function heading($msg){
	echo "<font size='+2'>".$msg."</font>";
	echo "<hr color=red width='80%'>\n<p>";
}

//include "../../bbs/_head.php";
require("config.php");
mysql_select_db("coretek") or die("mysql_select_db error");

	top();
	heading("유니폼 디자인 선정 설문조사");
/*
	if($logid == ""){
		die("로그인하지 않았습니다.");
	}
*/
	$query_name="pollid,userid,polltime,poll0,poll1,poll2";
	$query_value="'".$pollid."','".$logid."',now(),'".$rule0."','".$rule1."','".$rule2."'";

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

	echo "<p><font color=blue>다음은 현재까지의 설문조사 결과입니다.</font>";
	for($i=0; $i<3; $i++){
		$dbquery="select poll$i,count(*) from poll where pollid='$pollid' group by poll$i order by poll$i";
		$result = mysql_query($dbquery);

		$ii = $i + 1;
		echo "<p>설문조사 $ii"."번 항목 : ";
		while($row=mysql_fetch_array($result)){
			echo "$row[0]:$row[1]건 ";
		}
	}

?>
</center>
</body>
</html>
