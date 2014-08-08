<?php

require("./bmauth.php");
require("./bmconfig.php");

function tophtml($title){
echo "
<html>
<head>
<title>$title</title>
</head>

<body bgcolor='#E0FFE0' >
<center>
";
}

function heading($msg){
	echo "<font size='+2'>".$msg."</font>";
	echo "<hr color=red width='80%'>\n<p>";
}

header("Content-Type: text/html");
tophtml("대회 기록 배치 입력");
heading("대회 기록 배치 입력");

if($mode == ""){
/*
		$url = $PHP_SELF."?mode=batch-input";
		echo "
<form method=post action='$url'>
Data Format : 순위 성명  생년월일 출발시각 구간기록(5Km) (30Km) 최종기록 <br>
약식대회명:<input type=text name=nickname size=12><br>
종목:<input type=text name=item size=6><br>
파일명:<input type=text name=fname size=20 maxlength=40><br>
<input type=submit value='기록 배치 입력 처리'>
</form>\n<p><br><br>";
*/
		$url = $PHP_SELF."?mode=batch-inputgeneral";
		echo "
<form method=post action='$url'>
Data Format : 성명 기록 종목(풀,하프,10Km,5Km) 약식대회명 순위 기타
<br>(데이타 구분은 꼭 탭으로, 순위와 기타는 없어도 됨)<br>
서버 파일명:<input type=text name=fname size=20 maxlength=40><br>
<input type=submit value='기록 배치 입력 처리'>
</form>\n<p>";

}elseif($mode == "batch-input"){

	if( !file_exists($fname)){
		echo "파일 '$fname' 이 없습니다.";
		die("");
	}
	$dbquery="select raceid from race where nickname = '$nickname'";
	$result = mysql_query($dbquery) or die("mysql_query select error");
	$row=mysql_fetch_array($result);
	if(mysql_num_rows($result) == 0){
		echo "약식대회명 '$nickname'이 없습니다.";
		die("");
	}
	$raceid=$row[0];
	mysql_free_result($result);

	$fp = fopen($fname, "r");
	$no = 0;
//	$sexkor = array ("'남자'","'남'","'여자'","'여'");
//	$sexeng = array ("'M'","'M'","'F'","'F'");
/* record table
| userid    | varchar(12) |      | PRI |         |       |
| raceid    | smallint(6) |      | PRI | 0       |       |
| nickname  | varchar(12) |      |     |         |       |
| item      | varchar(6)  | YES  |     | NULL    |       |
| record    | varchar(10) |      |     |         |       |
| rank      | varchar(5)  | YES  |     | NULL    |       |
| dispyn    | char(2)     |      |     |         |       |
| transport | varchar(20) | YES  |     | NULL    |       |
| etc       | varchar(50) | YES  |     | NULL    |       |
| size      | varchar(4)  | YES  |     | NULL    |       |
| fellows   | char(2)     | YES  |     | NULL    |       |
*/
	$insert_string = "insert into record (userid,raceid,nickname,item,record,rank,dispyn,etc) values ";
//	$item = "풀";
	while (!feof ($fp)) {
		$data = chop(fgets($fp, 256));
		if($data == "" || substr($data,0,1)=="#")
			continue;
//		$data = str_replace($sexkor, $sexeng, $data);
//
//순위 성명  생년월일 출발시각 구간기록(5Km) (30Km) 최종기록
//830 김영헌 58.06.22 10:02:00 00:24:49 02:26:48 03:25:54
//

//		list($rank,$name, $birthdate, $starttime, $lap5, $lap30, $record)
//			= sscanf( $data,"%s %s %s %s %s %s %s");
		$strs = explode(" ", $data);
		$rank = $strs[0];
		$name = $strs[1];
		$lap5 = $strs[4];
		$lap30 = $strs[5];
		$record = $strs[6];
		if(substr($record,0,1) == "0")
			$record = substr($record, 1);
		if(substr($lap5,0,1) == "0")
			$lap5 = substr($lap5, 1);
		if(substr($lap30,0,1) == "0")
			$lap30 = substr($lap30, 1);
//echo "name=$name,record=$record,rank=$rank,lap5=$lap5,lap30=$lap30<br>";
		$dbquery="select userid from member where name = '$name'";
		$result = mysql_query($dbquery) or die("mysql_query select error");
		if(mysql_num_rows($result) == 0){
			echo "이름 '$name'이 없습니다.";
			die("");
		}
		$row=mysql_fetch_array($result);
		$userid=$row[0];
		mysql_free_result($result);

		$dbquery="select userid,raceid from record where raceid=$raceid and userid='$userid'";
		$result = mysql_query($dbquery) or die("mysql_query select error");
		if(mysql_num_rows($result) == 0){
			mysql_free_result($result);
//	"(userid,raceid,nickname,item,record,rank,dispyn,etc)";
			$dbquery = $insert_string."('$userid',$raceid,'$nickname','$item','$record','$rank','Y','$lap5(5k) $lap30(30k)')";
			$result = mysql_query($dbquery);
echo "insert dbquery=$dbquery<br>";
//echo "mysql_errno=".mysql_errno().":".mysql_error();
			if($result!=1){
				echo "<br>insert 이상. dbquery=$dbquery<br>처리 미완료<p>";
			}else{
				$no++;
			}

		}else{
			$dbquery = "update record set record='$record',item='$item',rank='$rank',dispyn='Y',etc='$lap5(5k) $lap30(30k)' where raceid=$raceid and userid='$userid'";
			$result = mysql_query($dbquery);
echo "<br>update dbquery=$dbquery<p>";
			if($result!=1){
				echo "<br>update 이상. dbquery=$dbquery<br>처리 미완료<p>";
			}else{
				$no++;
			}
		}
	}
	fclose ($fp);

	echo "총 $no 건 입력 완료.";
}elseif($mode == "batch-inputgeneral"){

	if( !file_exists($fname)){
		echo "파일 '$fname' 이 없습니다.";
		die("");
	}

	$fp = fopen($fname, "r");
	$no = 0;
/* record table
| userid    | varchar(12) |      | PRI |         |       |
| raceid    | smallint(6) |      | PRI | 0       |       |
| nickname  | varchar(12) |      |     |         |       |
| item      | varchar(6)  | YES  |     | NULL    |       |
| record    | varchar(10) |      |     |         |       |
| rank      | varchar(5)  | YES  |     | NULL    |       |
| dispyn    | char(2)     |      |     |         |       |
| transport | varchar(20) | YES  |     | NULL    |       |
| etc       | varchar(50) | YES  |     | NULL    |       |
| size      | varchar(4)  | YES  |     | NULL    |       |
| fellows   | char(2)     | YES  |     | NULL    |       |
*/
	$insert_string = "insert into record (userid,raceid,nickname,item,record,rank,dispyn,etc) values ";
	$etc = "";
	$rank = 0;
	$oldnickname = "";
	while (!feof ($fp)) {
		$data = chop(fgets($fp, 256));
		if($data == "" || substr($data,0,1)=="#")
			continue;
//
//성명	기록 	종목	약식대회명	순위	기타
//김영헌 3:25:54 	풀	03 동아		111	배번 xxx

		$strs = explode("	", $data);
		$name = $strs[0];
		$record = $strs[1];
		$item = $strs[2];
		$nickname = $strs[3];
		$rank = $strs[4];
		$etc = $strs[5];
		if($item!="풀" && $item!="하프" && $item!="5Km" && $item!="10Km"){
			echo "종목 '$item'은 미등록 종목입니다.";
			echo "등록 종목은 풀, 하프, 10Km, 5Km입니다.";
			die("");
		}
		if(substr($record,0,1) == "0" && substr($record,1,1) != ':')
			$record = substr($record, 1);
//echo "name=$name,record=$record<br>";
		$dbquery="select userid from member where name = '$name'";
		$result = mysql_query($dbquery) or die("mysql_query select error,name=$name");
		if(mysql_num_rows($result) == 0){
			echo "이름 '$name'이 없습니다.";
			die("");
		}
		$row=mysql_fetch_array($result);
		$userid=$row[0];
		mysql_free_result($result);

	    if($nickname != $oldnickname){
		$dbquery="select raceid from race where nickname = '$nickname'";
		$result = mysql_query($dbquery) or die("mysql_query select error, nickname='$nickname'");
		$row=mysql_fetch_array($result);
		if(mysql_num_rows($result) == 0){
			echo "약식대회명 '$nickname'이 없습니다.";
			die("");
		}
		$raceid=$row[0];
echo "nickname='$nickname', raceid=$raceid";
		mysql_free_result($result);
		$oldnickname = $nickname;
	    }

		$dbquery="select userid,raceid from record where raceid=$raceid and userid='$userid'";
		$result = mysql_query($dbquery) or die("mysql_query select error, raceid=$raceid,userid=$userid");
		if(mysql_num_rows($result) == 0){
			mysql_free_result($result);
//	"(userid,raceid,nickname,item,record,rank,dispyn,etc)";
			$dbquery = $insert_string."('$userid',$raceid,'$nickname','$item','$record','$rank','Y','$etc')";
			$result = mysql_query($dbquery);
echo "insert dbquery=$dbquery<br>";
//echo "mysql_errno=".mysql_errno().":".mysql_error();
			if($result!=1){
				echo "<br>insert 이상. dbquery=$dbquery<br>처리 미완료<p>";
			}else{
				$no++;
			}

		}else{
			$update_str = "update record set record='$record'";
			if($item) $update_str .= ",item='$item'";
			if($rank) $update_str .= ",rank='$rank'";
			if($etc) $update_str .= ",etc='$etc'";
			$dbquery = $update_str.",dispyn='Y' where raceid=$raceid and userid='$userid'";
			$result = mysql_query($dbquery);
echo "<br>update dbquery=$dbquery<p>";
			if($result!=1){
				echo "<br>update 확인요망(2건 이상일 가능성). 처리 완료<p>";
			}else{
				$no++;
			}
		}
	}
	fclose ($fp);

	echo "총 $no 건 입력 완료.";
}else{
	exit;
}
?>
</center>
</body>
</html>
