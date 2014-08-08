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
    if($rule0 != ""){
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
		echo "<br>";;
	}else{
		echo "감사합니다.<br>";
		echo "투표 처리가 완료되었습니다.<br>";
	}
    }

	echo "<p><font color=blue>다음은 회칙 개정에 대한 현재까지의 투표 결과입니다.</font>";
	echo "<p><table><tr><td>\n";

	$dbquery="select count(*) from poll where pollid='$pollid'";
	$result = mysql_query($dbquery);
	$row=mysql_fetch_array($result);
	echo "<p>총 투표 인원 : $row[0] 명<p>";
	mysql_free_result($result);

	for($i=0; $i<4; $i++){
		$dbquery="select poll$i,count(*) from poll where pollid='$pollid' group by poll$i order by poll$i desc";
		$result = mysql_query($dbquery);

		$ii = $i + 1;
		echo "<p>회칙 개정 $ii"."번 항목 : ";
		while($row=mysql_fetch_array($result)){
			if($row[0] == "Y")
				echo "개정:$row[1]건 ";
			else if($row[0] == "N")
				echo "현행:$row[1]건 ";
			else
				echo "기권:$row[1]건 ";
		}
	}
	echo "</table>\n";

echo "<p>
<table><tr><td>
1. 클럽 명칭 변경에 관한 건<br>
1안 : 분당검푸마라톤크럽<br>
2안 : 분당탄천검푸마라톤클럽(현행)<br>
<br>
2. 임원의 임기 변경에 관한 건<br>
1안 : 선출직 임원의 임기는 2년으로하되 1회에 한해서 연임할 수 있다<br>
2안 : 임원의 임기는 1년으로 연임할 수 있다(현행)<br>
<br>
3. 회원 의무사항 추가 : 클럽 주최 마라톤대회 운영 의무 봉사 <br>
- 회칙 제6조[회원의 권리와 의무]에<br>'회원은 본 클럽에서 주최하는 마라톤대회에 특별한<br>사정이 없는 한 대회 운영에 봉사하여야 한다' 추가 여부 <br>
1안 : 추가 <br>
2안 : 추가 반대(현행) <br>
<br>
4. 임원 피선거 자격 요건 개정에 관한 건<br>
1안 : 정회원 3년차부터 임원 피선거권을 가짐<br>
2안 : 정회원은 임원 피선거권을 가짐(현행)<br>
</table>
";

/*
	echo "<p><font color=blue>임원 선출은 투표 종료 후 최종 결과를 발표합니다.</font>";
*/

?>
</center>
</body>
</html>
