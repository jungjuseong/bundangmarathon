<?php

require("./auth.php");
require("./config.php");
require("./function.php");

{
	top("");
    ////
    if($mode == "idea-input"){
	heading("의견 신규 등록");

	echo "<p><font color=blue>본인 의견 등록</font><p>\n";
	$dbquery="select record.userid, record.raceid, record.nickname, record.item, member.name from record, member where ";
	$dbquery .= "record.userid='$logid' and ";
	$dbquery .= "(record.record = '' or record.record is null) and record.userid=member.userid order by record.nickname, record.item, member.name";
	$result = mysql_query($dbquery) or die("mysql_query error");
	for($i=0; $row=mysql_fetch_array($result); $i++){
		record_display("idea-update",  $row[0], $row[1], $row[2], $row[3], "", "", "", "", "");
	}
	if($i == 0){
		echo "신청한 대회 없음";
	}
	mysql_free_result($result);

	echo "<p><font color=blue>참가신청하지 않은 본인 기록 등록</font><p>\n";
	record_display("idea-insert",  $logid, 0, "input", "", "", "", "", "", "");
	mysql_close() or die("mysql_close error");
    }else if($mode == "idea-change"){
	heading("기록 정보 수정");

//	if($logid != $admin_id)
//		$userid = $logid;
	$dbquery="select userid, zzzz zzzz raceid, nickname, item, record, rank, dispyn, etc from idea where ideano=$ideano and userid='$userid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	if($row=mysql_fetch_array($result)){
		record_display("idea-update",  $row[0], $row[1], $row[2], $row[3], "", $row[4], $row[5], $row[6], $row[7]);
	}else{
		echo "<tr><td>'$name' 대회를 찾을 수가 없습니다.</td></tr>";
	}
	mysql_free_result($result);
	mysql_close() or die("mysql_close error");
    }else if($mode == "idea-insert"){
	heading("의견 신규 등록");

	$query_name="";
	$query_value="";

	$query_name.="userid";
	$query_value.="'".$logid."'";

	$query_name.=",answer";
	$query_value.=",'".$answer."'";

//echo "query_name=".$query_name."<br>";
//echo "query_value=".$query_value;
	$dbquery="insert into idea ($query_name) values ($query_value)";

	$result = mysql_db_query("coretek",$dbquery);

	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "이미 등록하신 의견입니다.<br>";
		die("");
	}else{
		echo "의견 등록 완료.<br>";
	}

    }else if($mode == "idea-delete" || $mode == "idea-update" and chop($answer) == ""){
	heading("의견 삭제");
	$dbquery="delete from answer where ideano=$ideano and userid='$logid'";
	$result = mysql_query($dbquery) or die("mysql_query error");

	if($result=="1"){
		echo "의견 삭제 완료";
	}else{
		echo "<font color=red>의견 삭제 오류</font>";
	}
    }else if($mode == "idea-update"){
	heading("의견 수정 완료");
	$dbquery="update idea set answer='".$answer."',answertime=now()";
	$dbquery.=" where ideano=$ideano and userid='$logid';
//echo "dbquery=".$dbquery;
	$result = mysql_query($dbquery) or die("mysql_query error");

	if($result=="1"){
		echo "의견 수정 완료";
	}else{
		echo "<font color=red>의견 수정 오류</font>";
	}
    }else if($mode == "idea-list"){
	heading("의견 목록");

	echo "<table border=1>\n";
	if($orderfield == "name"){
		echo "<th>이름\n";
	}else{
		echo "<th><a href='$PHP_SELF?mode=idea-list&orderfield=name'>이름</a>\n";
	}
    	if($orderfield == "" or $orderfield == "answertime"){
		echo "<th>입력시간\n";
	}else{
		echo "<th><a href='$PHP_SELF?mode=idea-list&orderfield=answertime'>입력시간</a>\n";
	}
	echo "<th>의견</tr>";
    	if($orderfield == "" or $orderfield == "answertime"){
		$orderfield = "idea.answertime";
	}else if($orderfield == "name"){
		$orderfield = "member.name";
	}
	$dbquery="select idea.ideano, idea.userid, member.name, idea.answertime, idea.answer from member,idea where idea.ideano=$ideano and idea.userid=member.userid order by ".$orderfield;
	$result = mysql_query($dbquery) or die("mysql_query error");

	while($row=mysql_fetch_array($result)){
		echo "<tr><td>$row[2] <td>$row[3]";
		if($logid == $row[1])
			echo "<td><a href='$PHP_SELF?mode=idea-change&ideano=$row[0]'>$row[4]</a>\n";
		else
			echo "<td>$row[4]\n";
		echo "<td>$row[4]\n";
	}
	echo "</tr></table>";
	mysql_free_result($result);
    }else{
	heading("없는 기능");

    }
}

function idea_input($mode, $raceid, $item, $size, $transport, $userid){

	echo "<table border=1>";

	JScheckLength();
	echo "
<form action='$PHP_SELF' method=post>\n
<input type=hidden name=userid value='$userid'>\n
<input type=hidden name=mode value='$mode'>\n
<tr><td>참가대회</td><td>";
	$dbquery="select raceid, name, nickname from race where inviting='Y'";
	$result = mysql_query($dbquery) or die("mysql_query error");

	echo "<input type=hidden name='mode' value='$mode'>\n";
	echo "<select name='raceid' size='1'  style='background-color: white; color: blue; font:10pt'>\n";

	while($row=mysql_fetch_array($result)){
		echo "<option value='$row[0]:$row[2]'";
		if($row[0] == $raceid)
			echo " selected";
		echo ">$row[2] : $row[1]";
		echo "</option>\n";
	}
	echo "</select>";
	mysql_free_result($result);

	echo "
</td></tr>\n
<tr><td>종목</td><td>
  <input type='radio' name='item' value='풀' $itemf>풀
  <input type='radio' name='item' value='하프' $itemh>하프
  <input type='radio' name='item' value='10Km' $item10>10Km
  <input type='radio' name='item' value='5Km' $item5>5Km
  <input type='radio' name='item' value='etc' $iteme>기타
<input type=text name=itemetc value='$itemetc' maxlength=6 size=7 onChange='return checkLength(this.value,6)'>예 : 7.5Km</td></tr>\n
  </td></tr>\n
<tr><td>크기</td><td><input type=text name=size value='$size' maxlength=4 size=5 onChange='return checkLength(this.value,4)'>반드시 대회 요강을 확인 후 기재 요망</td></tr>\n
<tr><td>교통편</td><td><input type=text name=transport value='$transport' maxlength=20 size=20 onChange='return checkLength(this.value,20)'>예 : 무임승차 요망, 자가용 제공 등</td></tr>\n
<tr><td colspan=2 align=center>";

	if(privcheck($userid)){
		echo "<br><input type=submit value='";
		if($mode == "idea-insert")
			echo "등록";
		else
			echo "수정";
		echo " 처리'>";
		if($mode == "idea-update"){
			echo "<p>
</form>
<form action='$PHP_SELF' method=post>\n
<input type=hidden name=mode value='idea-delete'>\n
<input type=hidden name=raceid value='$raceid'>\n
<input type=submit value='삭제 처리'>";
		}
	}else{
		echo "<br>관리자나 등록자만 수정 가능합니다.";
	}


	echo "</form></td></tr>\n";
	echo "
</table>
";
}

function record_display($mode, $userid, $raceid, $nickname, $item, $name, $record, $rank, $dispyn, $etc){

	global $logid;

	$itemf=$itemh=$item10=$item5="";
	if($item == "풀"){
		$itemf = "checked";
	}else if($item == "하프"){
		$itemh = "checked";
	}else if($item == "10Km"){
		$item10 = "checked";
	}else if($item == "5Km"){
		$item5 = "checked";
	}else{
		$iteme = "checked";
		$itemetc = $item;
	}
	if($dispyn == "Y"){
		$dispy = "checked";
	}else if($dispyn == "N"){
		$dispn = "checked";
	}else{
		$dispy = "checked";
	}

	JScheckLength();
	echo "
<form action='$PHP_SELF' method=post>\n
<input type=hidden name=userid value='$userid'>\n
<input type=hidden name=mode value='$mode'>\n";
	echo "
<table border=1>\n
<tr><td><table border=1>\n";
	if($name != ""){
		echo "
<tr><td>이름</td><td>$name</td></tr>";
	}
	echo "
<tr><td>대회명</td><td>";
	if($raceid > 0){
		echo "$nickname\n
<input type=hidden name=raceid value='$raceid'>\n";
	}else{
		if($nickname == "input"){
	$dbquery="select race.raceid, race.name, race.nickname, race.raceday from race";
	$dbquery.=" left join record on race.nickname=record.nickname";
	$dbquery.=" and record.userid = '$logid'";
	$dbquery.=" where record.nickname is null order by race.raceday desc";

	$result = mysql_query($dbquery) or die("mysql_query error");
		}
		echo "<select name='raceid' size='1'  style='background-color: white; color: blue; font:10pt'>\n";

		while($row=mysql_fetch_array($result)){
			echo "<option value='$row[0]'>$row[3] : $row[2] : $row[1]</option>\n";
		}
		echo "</select>\n";
		mysql_free_result($result);

	}
	echo "</td>\n
<tr><td>종목</td><td>\n
  <input type='radio' name='item' value='풀' $itemf>풀\n
  <input type='radio' name='item' value='하프' $itemh>하프\n
  <input type='radio' name='item' value='10Km' $item10>10Km\n
  <input type='radio' name='item' value='5Km' $item5>5Km\n
  <input type='radio' name='item' value='etc' $iteme>기타\n
<input type=text name=itemetc value='$itemetc' maxlength=6 size=7 onChange='return checkLength(this.value,6)'>예 : 7.5Km</td></tr>\n
<tr><td>기록</td><td><input type=text name=record  value='$record' maxlength=10 size=10 onChange='return checkLength(this.value,10)'>예: 3:03:03</td></tr>\n
<tr><td>순위</td><td><input type=text name=rank value='$rank' maxlength=5 size=5 onChange='return checkLength(this.value,5)'></td></tr>\n
<tr><td>중간기록 등</td><td><input type=text name=etc value='$etc' maxlength=50 size=50 onChange='return checkLength(this.value,50)'></td></tr>\n
<tr><td>공개여부</td><td>
  <input type='radio' name='dispyn' value='Y' $dispy>공개함
  <input type='radio' name='dispyn' value='N' $dispn>본인만 봄
  </td>\n
</tr></table></td>\n
<td align=center valign=center>";

	if(privcheck($logid) == 2 || $logid == $userid){
		echo "<input type=submit value='처리'>";
	}
	echo "</form><p>\n";
	if($mode == "idea-update"){
		echo "
<form action='$PHP_SELF' method=post>\n
<input type=hidden name=raceid value='$raceid'>\n
<input type=hidden name=userid value='$userid'>\n
<input type=hidden name=mode value='idea-delete'>\n
<input type=submit value='삭제'>\n
</form></td></tr>\n";
	}
	echo "
</table>
";
}

?>
</center>
</body>
</html>
