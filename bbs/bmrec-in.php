<?php 

require("./bmauth.php");
require("./bmconfig.php");
require("./bmfunction.php");

if($logid == ""){
	top("");
	heading("회원 ID 입력");
	echo "<a href='bmmem.php'>여기서 로그온 하십시오.</a>";
}else{
	top("");
    ////
if($mode == "" || $mode == "batch-input-person"){
	heading("기록 Batch 등록(개인별)");

	echo "
	<form action='$PHP_SELF' method=post>\n
	<input type=hidden name=mode value='batch-parse-person'>\n
	<table><tr><td>
	Name:<td><input type=text name=name value='아무개'><br>\n
	<tr><td>
	Cont:<td><textarea wrap=auto name=cont rows=12 cols=60>종목(풀,하프,10km,5km) 기록(시:분:초) 약식대회명
풀 3:01:02 03 동아
하프 1:22:33 06 4/4기록회(탭 or 빈칸으로 구분)</textarea><br>
	<tr><td colspan=2 align=center>
	<input type=submit value='Batch 처리'>
	</table>
	</form>";
}else if($mode == "batch-parse-person"){
	heading("기록 정보 Batch 분류");

//	echo "name=$name<br>cont=$cont<br><br>\n";
	echo "
	<form action='$PHP_SELF' method=post>\n
	<input type=hidden name=mode value='batch-insert-person'>\n
	Name: $name<input type=hidden name=name value='$name'><br><br>\n";
	for($i=0, $idx=0, $arridx=0; $i< strlen($cont); $i++){
		$chr=substr($cont, $i, 1);
		if($chr == "\n" || $i == (strlen($cont)-1)){
			if($chr == "\n"){
				$partstr=substr($cont, $idx, $i-$idx);
			}else{
				$partstr=substr($cont, $idx, $i-$idx+1);
			}
			if($arridx == 0){
				if(substr_count($partstr, "\t") >= 2)
					$dividechar = "\t";
				else
					$dividechar = " ";
			}		
//			echo "partstr=$partstr ";
//			list($item, $record, $nn1, $nn2, $nn3) = sscanf($partstr,"%s %s (%s %s %s)");
			list($item, $record, $nn1, $nn2, $nn3) = split($dividechar, $partstr);
			$nickname="$nn1 $nn2 $nn3";
//			$nickname=substr($nickname,0,strlen($nickname)-2);
//		echo "item=$item, rec=$record, nn=$nn1 $nn2 $nn3, nickname=$nickname<br>";
			echo "
			종목:<input type=text name=itemarr[$arridx] value='$item'>
			기록:<input type=text name=recordarr[$arridx] value='$record'>
			대회:<input type=text name=nicknamearr[$arridx] value='$nickname'><br>\n";
			$idx=$i+1;
			$arridx++;
		}
		if($chr == '\r')
			continue;
	}
	echo "<input type=submit value='Batch 처리'>
	</form>";
	die();
}else if($mode == "batch-insert-person"){
	heading("기록 정보 Batch 등록");

	$dbquery="select userid from member where name='$name'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$rows = mysql_num_rows($result);
	if($rows == 0){
		echo "$name 님은 회원이 아닙니다.";
		  die();
	}
	$row=mysql_fetch_array($result);
	$userid=$row[0];
	mysql_free_result($result);

	$dispyn="Y";
	$rank="";
	$etc="";

	for($i=0, $idx=0; strlen($itemarr[$i])>0; $i++){
		$item=$itemarr[$i];
		$record=$recordarr[$i];
		$nickname=$nicknamearr[$i];
//		echo "item=$item, rec=$record, nickname=$nickname<br>\n";

		$query_name="";
		$query_value="";

		$query_name.="userid";
		$query_value.="'".$userid."'";

		$query_name.=",item";
		if($item=="10km")
			$item = "10Km";
		else if($item=="5km")
			$item = "5Km";
		else
			$item = strtolower($item);
		$query_value.=",'".$item."'";

		$query_name.=",record";
		$query_value.=",'".$record."'";

		$query_name.=",rank";
		$query_value.=",'".$rank."'";

		$query_name.=",dispyn";
		$query_value.=",'".$dispyn."'";

		$query_name.=",etc";
		$query_value.=",'".$etc."'";

		$query_name.=",nickname";
		$query_value.=",'".$nickname."'";

		$dbquery="select raceid from race where nickname='$nickname'";
		$result = mysql_query($dbquery) or die("mysql_query error");
		$rows = mysql_num_rows($result);
		if($rows == 0){
			echo "'$nickname' 은 저장된 대회의 약칭이 아닙니다.";
			die();
		}
		$row=mysql_fetch_array($result);
		$raceid=$row[0];

		$query_name.=",raceid";
		$query_value.=",".$raceid;

		$date = getdate();
		$yyyymmdd = $date['year']."-".$date['mon']."-".$date['mday'];
		$query_name.=",makedate";
		$query_value.=",'".$yyyymmdd."'";

		mysql_free_result($result);
	
//echo "query_name=".$query_name."<br>";
//echo "query_value=".$query_value;
		$dbquery="insert into record ($query_name) values($query_value)";

		$result = mysql_query($dbquery);

		echo "$item, $record, ($nickname) : ";
		if($result!="1"){
			$dbquery="update record set record='$record',dispyn='$dispyn' where userid='$userid' and raceid=$raceid";
//	echo $dbquery;
			$result = mysql_query($dbquery) or die("mysql_query update error");

			if($result=="1"){
				echo "기록 수정 완료<br>";
			}else{
				echo "<font color=red>기록 등록 오류</font><br>";
			}
		}else{
			echo "등록 처리 완료.<br>";
		}
	}
	echo "$i 건 입력(수정) 완료";
die();
//	mysql_close($connect);


}else if($mode == "batch-input-race"){
	heading("기록 Batch 등록(대회별)");

	echo "
	<form action='$PHP_SELF' method=post>\n
	<input type=hidden name=mode value='batch-parse-race'>\n
	<table><tr><td>
	Name:<td><input type=text name=nickname value='약식대회명'><br>\n
	<tr><td>
	Cont:<td>이름 종목(풀,하프,10km,5km) 기록(시:분:초) 순위 기타(탭 or 빈칸으로 구분)<br>
김영헌A 풀 2:59:58 842<br>
<textarea wrap=auto name=cont rows=12 cols=60></textarea><br>
	<tr><td colspan=2 align=center>
	<input type=submit value='Batch 처리'>
	</table>
	</form>";
}else if($mode == "batch-parse-race"){
	heading("기록 정보 Batch 분류");

//	echo "name=$name<br>cont=$cont<br><br>\n";
	echo "
	<form action='$PHP_SELF' method=post>\n
	<input type=hidden name=mode value='batch-insert-race'>\n
	약식대회명: $nickname<input type=hidden name=nickname value='$nickname'><br>\n";
		$dbquery="select name, raceday from race where nickname='$nickname'";
		$result = mysql_query($dbquery) or die("mysql_query error");
		$rows = mysql_num_rows($result);
		if($rows == 0){
			echo "'$nickname' 은 저장된 대회의 약칭이 아닙니다.";
			die();
		}
		$row=mysql_fetch_array($result);
		mysql_free_result($result);
		echo "대회명 : $row[0]<br>\n";
		echo "대회일 : <font color=red>$row[1]</font><br><br>\n";

	echo "<table border=1><tr><th>이름<th>종목<th>기록<th>순위<th>기타\n";
	for($i=0, $idx=0, $arridx=0; $i< strlen($cont); $i++){
		$chr=substr($cont, $i, 1);
		if($chr == "\n" || $i == (strlen($cont)-1)){
			if($chr == "\n"){
				$partstr=substr($cont, $idx, $i-$idx);
			}else{
				$partstr=substr($cont, $idx, $i-$idx+1);
			}
			if($arridx == 0){
				if(substr_count($partstr, "\t") >= 2)
					$dividechar = "\t";
				else
					$dividechar = " ";
			}		
//			echo "partstr=$partstr ";
			list($name, $item, $record, $rank, $etc1, $etc2, $etc3, $etc4, $etc5) = split($dividechar, $partstr);
			$etc="$etc1 $etc2 $etc3 $etc4 $etc5";

			if(($pos = strpos($record, ".")) > 0){
				$record = substr($record, 0, $pos);
			}
			echo "<tr>
			<td><input type=text name=namearr[$arridx] value='$name'>
			<td><input type=text name=itemarr[$arridx] value='$item'>
			<td><input type=text name=recordarr[$arridx] value='$record'>
			<td><input type=text name=rankarr[$arridx] value='$rank'>
			<td><input type=text name=etcarr[$arridx] value='$etc'>\n";
			$idx=$i+1;
			$arridx++;
		}
		if($chr == '\r')
			continue;
	}
	echo "</table>\n";
	echo "<input type=submit value='Batch 처리'>
	</form>";
	die();
}else if($mode == "batch-insert-race"){
	heading("기록 정보 Batch 등록");

		$dbquery="select raceid from race where nickname='$nickname'";
		$result = mysql_query($dbquery) or die("mysql_query error");
		$rows = mysql_num_rows($result);
		if($rows == 0){
			echo "'$nickname' 은 저장된 대회의 약칭이 아닙니다.";
			die();
		}
		$row=mysql_fetch_array($result);
		$raceid=$row[0];
		mysql_free_result($result);
		echo "약식대회명 : $nickname<br><br>\n";

	$dispyn="Y";
	$rank="";
	$etc="";
	$newRecord="<br><br>기록경신 내역<br>";
	$newNo = $newRecord;

	for($i=0, $idx=0; $i < count($itemarr); $i++){
		if(strlen($itemarr[$i]) == 0) continue;
		$item=$itemarr[$i];
		$record=$recordarr[$i];
		if(strlen($record) == 5)
			$record = "0:".$record;
		$name=$namearr[$i];
		$rank=$rankarr[$i];
		$etc=$etcarr[$i];
//		echo "item=$item, rec=$record, nickname=$nickname<br>\n";

		$query_name="";
		$query_value="";

		$dbquery="select userid from member where name='$name'";
		$result = mysql_query($dbquery) or die("mysql_query error");
		$rows = mysql_num_rows($result);
		if($rows == 0){
			echo "$name 님은 회원이 아닙니다.";
			  die();
		}
		$row=mysql_fetch_array($result);
		$userid=$row[0];
		mysql_free_result($result);

		$query_name.="userid";
		$query_value.="'".$userid."'";

		$query_name.=",item";
		if($item=="10km")
			$item = "10Km";
		else if($item=="5km")
			$item = "5Km";
		else
			$item = strtolower($item);
		$query_value.=",'".$item."'";

		$tmp = substr($record, 0, 1);
		if($tmp<'0' || $tmp > '9'){
			echo "기록이 이상합니다.";
			die();
		}
		$query_name.=",record";
		$query_value.=",'".$record."'";

		$query_name.=",rank";
		$query_value.=",'".$rank."'";

		$query_name.=",dispyn";
		$query_value.=",'".$dispyn."'";

		$query_name.=",etc";
		$query_value.=",'".$etc."'";

		$query_name.=",nickname";
		$query_value.=",'".$nickname."'";

		$query_name.=",raceid";
		$query_value.=",".$raceid;

		$date = getdate();
		$yyyymmdd = $date['year']."-".$date['mon']."-".$date['mday'];
		$query_name.=",makedate";
		$query_value.=",'".$yyyymmdd."'";

//		mysql_free_result($result);
	
//echo "query_name=".$query_name."<br>";
//echo "query_value=".$query_value;
		$dbquery="insert into record ($query_name) values($query_value)";

		$result = mysql_query($dbquery);

		echo "$name, $item, $record : ";
		$ok = "1";
		if($result!="1"){
			$dbquery="update record set record='$record',dispyn='$dispyn' where userid='$userid' and raceid=$raceid";
//	echo $dbquery;
			$result = mysql_query($dbquery) or die("mysql_query update error");

			if($result=="1"){
				echo "기록 수정 완료<br>";
			}else{
				$ok = "no";
				echo "<font color=red>기록 등록 오류</font><br>";
			}
		}else{
			echo "등록 처리 완료.<br>";
		}
		if($ok == "1"){
			$dbquery="select record from record where userid='$userid' and item='$item' and raceid!=$raceid and record > '0:00:00' order by record limit 1";
			$result = mysql_query($dbquery) or die("mysql_query error");
			$rows = mysql_num_rows($result);
			if($rows > 0){
				$row=mysql_fetch_array($result);
				if($record < $row[0]){
					list($hour, $minute, $second) = split(":", $record);
					list($hour2, $minute2, $second2) = split(":", $row[0]);
					$new = 0+($hour2-$hour)*3600+($minute2-$minute)*60+($second2-$second);
					$hh = floor($new / 3600);
					$temp = ($new - $hh * 3600);
					$mm = floor($temp / 60);
					$ss = $temp - $mm * 60;
					if(strlen($mm) == 1) $mm = "0".$mm;
					if(strlen($ss) == 1) $ss = "0".$ss;
					$newRecord .= "$name : 구:$row[0] 신:$record $hh:$mm:$ss<br>";
				}
			}else{
				$newRecord .= "최초<br>";
			}
			mysql_free_result($result);
		}
	}
	echo "$i 건 입력(수정) 완료";
	if($newRecord != $newNo){
		echo $newRecord;
	}
die();
//	mysql_close($connect);


}
}

?>
</center>
</body>
</html>
