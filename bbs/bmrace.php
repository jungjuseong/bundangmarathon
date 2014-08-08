<?php

require("./bmauth.php");
require("./bmconfig.php");
require("./bmfunction.php");

top("");

if($mode == "race-input"){
	heading("대회 정보 신규 등록");
	echo "등록 후 관리자나 신규 등록자만 수정 및 참가신청을 마감할 수 있습니다.<p>";
	race_display("race-insert","","","","","","","","","","","",$logid);
}else if($mode == "race-change"){
	heading("대회 정보 수정");

//	if($logid != $admin_id)
//		$userid = $logid;
	$dbquery="select raceid, name, nickname, raceday, racetime, organizer, homehref, place, typenfee, etc, inviting, userid from race where raceid=$raceid";
	$result = mysql_query($dbquery) or die("mysql_query error");
	if($row=mysql_fetch_array($result)){
		race_display("race-update",  $row[0], $row[1], $row[2], $row[3],
		 $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]);
	}else{
		echo "<tr><td>'$name' 대회를 찾을 수가 없습니다.</td></tr>";
	}
	mysql_free_result($result);
	mysql_close() or die("mysql_close error");
}else if($mode == "race-insert"){
	heading("대회 정보 신규 등록");

	$dbquery="select raceid, name, nickname, raceday from race where raceday='$raceday' and replace(nickname,' ', '')='".str_replace(" ", "", $nickname)."'";
//echo $dbquery;
	$result = mysql_query($dbquery) or die("mysql_query error");

	$rows = mysql_num_rows($result);
	if($rows > 0){
		echo "대회 약칭이 있습니다.";
		return;
	}


	$query_name="";
	$query_value="";

	$query_name.="name,";
	$query_value.="'".$name."',";
	$query_name.="nickname,";
	$query_value.="'".$nickname."',";

	if(!($raceday=daycheck($raceday))) return;

	$query_name.="raceday,";
	$query_value.="'".$raceday."',";
	$query_name.="racetime,";
	$query_value.="'".$racetime."',";

	$query_name.="organizer,";
	$query_value.="'".$organizer."',";
	$query_name.="homehref,";
	$query_value.="'".$homehref."',";

	$query_name.="place,";
	$query_value.="'".$place."',";

	$query_name.="typenfee,";
	$query_value.="'".$typenfee."',";
	$query_name.="etc,";
	$query_value.="'".$etc."',";
	$query_name.="inviting,";
	$query_value.="'".$inviting."',";

	$query_name.="userid";
	$query_value.="'".$logid."'";

//echo "query_name=".$query_name;
//echo "query_value=".$query_value;
	$dbquery="insert into race ($query_name) values($query_value)";

	$result = mysql_query($dbquery);

	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "이미 등록하신 대회입니다.<br>";
		echo "대회 약칭을 확인 바랍니다.";
		die("");
	}else{
		echo "대회 등록 처리 완료.<br>";
		echo "
<script language=JavaScript>
	parent.framerace.location = 'bmrace.php?mode=race-framelist';
</script>";

	}

}else if($mode == "race-delete"){
	heading("대회 정보 삭제");
	$dbquery="select count(*) from record where raceid=$raceid";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$row=mysql_fetch_array($result);

	if($row[0] == "0"){
		$dbquery="delete from race where raceid=$raceid";
		if(privcheck($logid) < 2){
			$dbquery .= " and userid='$logid'";
		}
		$result = mysql_query($dbquery) or die("mysql_query error");

		if($result=="1"){
			echo "$nickname 삭제 완료";
		echo "
<script language=JavaScript>
	parent.framerace.location = 'bmrace.php?mode=race-framelist';
</script>";

		}else{
			echo "<font color=red>$nickname 삭제 오류</font>";
		}
	}else{
		echo "기록이 있기 때문에 삭제할 수 없습니다.<br>관리자에게 문의 바랍니다.";
	}
}else if($mode == "race-update"){
	heading("대회 정보 수정 완료");

	if(!($raceday=daycheck($raceday))) return;

	$dbquery="select raceid, name, nickname, raceday from race where raceid!=$raceid and replace(nickname,' ', '')='".str_replace(" ", "", $nickname)."'";
//echo $dbquery;
	$result = mysql_query($dbquery) or die("mysql_query error");

	$rows = mysql_num_rows($result);
	if($rows > 0){
		echo "대회 약칭이 있습니다.";
		return;
	}
	$dbquery="update race set name='".$name."',nickname='".$nickname.
		"',organizer='".$organizer."',homehref='".$homehref.
		"',raceday='".$raceday."',racetime='".$racetime.
		"',place='".$place."',typenfee='".$typenfee.
		"',etc='".$etc."',inviting='".$inviting.
		"',modifier='".$logid."'";
	$dbquery.=" where raceid=".$raceid;
//echo "dbquery=".$dbquery;
	$result = mysql_query($dbquery) or die("mysql_query error");

	if($result=="1"){
		if($oldnickname != "" && $nickname != $oldnickname){
			$dbquery="update record set nickname='".$nickname."'";
			$dbquery.=" where raceid=".$raceid;
			$result = mysql_query($dbquery) or die("mysql_query2 error");
			if($result>="1"){
				echo "\"$name\" 수정 완료";
			}else{
				echo "<font color=red>$name 수정 오류(record nickname update error)</font>";
				return;
			}
		}else{
			echo "\"$name\" 수정 완료";
		}
		echo "
<script language=JavaScript>
	parent.framerace.location = 'bmrace.php?mode=race-framelist';
</script>";

	}else{
		echo "<font color=red>$name 수정 오류(race update error)</font>";
	}
}else if($mode == "race-list"){
	heading("마라톤 대회 목록");

	$dbquery="select raceid, name, nickname, raceday, racetime, organizer, homehref, place, typenfee, etc, inviting from race order by raceday desc";
	$result = mysql_query($dbquery) or die("mysql_query error");

	echo "<table border=1><tr><th>대회명<th>약칭<th>일시<th>주최/홈페이지<th>장소<th>종목/참가비<th>참고사항</tr>";
	while($row=mysql_fetch_array($result)){
		echo "<tr><td><a href='bminviting.php?mode=record-list2&raceid=$row[0]'>$row[1]</a>\n";
		echo "<td>$row[2] <td>$row[3] $row[4]";
		if($row[6] != ""){
			echo "<td><a href='$row[6]' target=_new>$row[5]</a>";
		}else{
			echo "<td>$row[5]";
		}
		echo "<td>$row[7] <td>$row[8] <td>$row[9]\n";
	}
	echo "</tr></table>";
	mysql_free_result($result);
}else if($mode == "race-select"){
	heading("대회 정보 수정");

	echo "<form name=form1 method=post action='$PHP_SELF'>\n";
	echo "<input type=hidden name='mode' value='race-change'>\n";
	echo "<input type=hidden name='raceid'>\n";
	echo "<input type=text name=racename size=50 value='아래에서 대회를 선택후 지정을 누르십시오.'>";
	echo "<p><input type=submit onClick=\"if(this.form.raceid.value==''){ alert('아래에서 대회를 지정하십시오.'); return false;}\" value='자료수정 또는 신청마감 처리'>";
	echo "</form>";
}else if($mode == "race-framelist"){
	$dbquery="select raceid, name, nickname, raceday from race order by raceday desc";
//echo $dbquery;
	$result = mysql_query($dbquery) or die("mysql_query error");

	$rows = mysql_num_rows($result);
	if($rows == 0){
		echo "대회가 없습니다.";
	}else{
		echo "<form name=racelistform method=post>\n";
		echo "<select id='raceid' name='raceid' size='1' style='background-color: white; color: blue; font:10pt'>\n";

		while($row=mysql_fetch_array($result)){
			echo "<option value='$row[0]'>$row[3] : $row[2] : $row[1]</option>\n";
		}
		echo "</select>";
		echo "<input type=button value='지정' onClick=\"parent.framecont.form1.racename.value=racelistform.raceid.options[racelistform.raceid.selectedIndex].text;parent.framecont.form1.raceid.value=racelistform.raceid.options[racelistform.raceid.selectedIndex].value\"\">";
//		echo "<input type=button value='지정' onClick=\"parent.document.getElementById('racename').value=getElementById('raceid').options[getElementById('raceid').selectedIndex].text;parent.document.getElementById('raceid').value=getElementById('raceid').options[getElementById('raceid').selectedIndex].value\"\">";
//alert(this.form.raceid.options[this.form.raceid.selectedIndex].value);
		echo "</form>";
	}
	mysql_free_result($result);
	mysql_close() or die("mysql_close error");
}else if($mode == "submenu"){
	heading("대회정보 메뉴");
	echo "
	<a href='bmrace.php?mode=race-input'>대회정보신규등록</a><br>
	<a href='bmrace.php?mode=race-select'>대회정보수정/신청마감</a><br>
	<a href='bmrace.php?mode=race-list'>입력된대회목록</a><br>";
}

function race_display($mode, $raceid, $name, $nickname, $raceday, $racetime,
	 $organizer, $homehref, $place, $typenfee, $etc, $inviting, $userid){
	global $logid, $PHP_SELF;
	$oldnickname = $nickname;



	if($inviting == "Y"){
		$invitingy = "checked";
		$invitingn = "";
	}else{
		$invitingn = "checked";
		$invitingy = "";
	}
	echo "<table border=1>";
	JScheckLength();
echo "
<form action='$PHP_SELF' method=post>\n
<input type=hidden name=raceid value='$raceid'>\n
<input type=hidden name=userid value='$userid'>\n
<input type=hidden name=mode value='$mode'>\n
<input type=hidden name=oldnickname value='$oldnickname'>\n
<tr><td>대회명칭</td><td><input type=text name=name value='$name' maxlength=60 size=50 onChange='return checkLength(this.value,60)'></td></tr>\n
<tr><td>대회약칭</td><td><input type=text name=nickname value='$nickname' maxlength=15 size=15 onChange='return checkLength(this.value,15)'>연도 2자리 + 빈칸 + 장소(예 : 01 동아, 01 생체 진천)</td></tr>\n
<tr><td>대회날짜</td><td><input type=text name=raceday value='$raceday' maxlength=10 size=10 onChange='return checkLength(this.value,10)'>예 : 2001/07/26</td></tr>\n
<tr><td>출발시간</td><td><input type=text name=racetime value='$racetime' maxlength=5 size=6 onChange='return checkLength(this.value,5)'>최장거리 종목 기준 (예 : 9:30)</td></tr>\n
<tr><td>주최</td><td><input type=text name=organizer value='$organizer' maxlength=30 size=30 onChange='return checkLength(this.value,30)'></td></tr>\n
<tr><td>홈주소</td><td><input type=text name=homehref value='$homehref' maxlength=60 size=50 onChange='return checkLength(this.value,60)'></td></tr>\n
<tr><td>장소</td><td><input type=text name=place  value='$place' maxlength=20 size=30 onChange='return checkLength(this.value,30)'></td></tr>\n
<tr><td>종목및참가비</td><td><input type=text name=typenfee value='$typenfee' maxlength=60 size=60 onChange='return checkLength(this.value,60)'></td></tr>\n
<tr><td>기타참고사항</td><td><input type=text name=etc value='$etc' maxlength=200 size=50 onChange='return checkLength(this.value,200)'>티셔츠 크기 등(영문 200자)</td></tr>\n
<tr><td>참가신청여부</td><td>
  <input type='radio' name='inviting' value='Y' $invitingy>회원 참가신청 받음　　
  <input type='radio' name='inviting' value='N' $invitingn>회원 참가신청 마감함
  </td></tr>\n
<tr><td colspan=2 align=center>";

	if($userid == $logid || privcheck($logid) == 2){
		echo "<br><input type=submit value='";
		if($mode == "race-insert")
			echo "등록";
		else
			echo "수정";
		echo " 처리'>";
		if($mode == "race-update"){
			echo "<p>
</form>

<form action='$PHP_SELF' method=post>\n
<input type=hidden name=mode value='race-delete'>\n
<input type=hidden name=raceid value='$raceid'>\n
<input type=hidden name=nickname value='$nickname'>\n
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

?>
</center>
</body>
</html>
