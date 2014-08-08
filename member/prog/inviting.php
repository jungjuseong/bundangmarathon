<?php

require("./auth.php");
require("./config.php");
require("./function.php");

top("");

if($mode == "inviting-input2"){
	heading("대회 참가 신청");
	race_disp($raceid);
	echo "<p>";
	$dbquery2 = "select userid from record where raceid=$raceid and userid='$logid'";
	$result2 = mysql_query($dbquery2) or die("mysql_query error");
	$row2 = mysql_fetch_array($result2);
	mysql_free_result($result2);
	if($row2){
	}else{
		inviting_display("inviting-insert",$raceid,"","","","", $logid);
	}
	if(privcheck($logid) == 2){
		echo "<p><font size='+2'>관리자용 회원 참가 신청</font><p>\n";
		inviting_display("inviting-insert",$raceid,"","","","", "");
	}
}else if($mode == "inviting-input"){
	heading("대회 참가 신청");

	$dbquery="select juminno from member where userid = '$logid'";
	$result2 = mysql_query($dbquery) or die("mysql_query error");
	$row=mysql_fetch_array($result2);
	if(!is_numeric(substr($row[0],0,6))){
		echo "<a href=\"mem.php?mode=member-change&userid=$logid\">주민등록번호가 이상합니다.<br>먼저 여기에서 개인 정보를 입력하십시오.</a>";
		die("");
	}

	echo "단체 참가 신청이 아니더라도 참가 신청하신 분들은 입력 바랍니다.<p>\n";
	$dbquery="select raceid, name, nickname, userid from race where raceday > replace(substring(now(),1,10),'-','/') and inviting='Y' order by raceday";
	$result = mysql_query($dbquery) or die("mysql_query error");
	while($row=mysql_fetch_array($result)){
		if(privcheck($logid) != 2){
			$dbquery2 = "select userid from record where raceid=$row[0] and userid='$logid'";
			$result2 = mysql_query($dbquery2) or die("mysql_query error 2");
			$row2 = mysql_fetch_array($result2);
			mysql_free_result($result2);
			if($row2){
				continue;
			}
		}
		echo "<a href='$PHP_SELF?mode=inviting-input2";
		if($row[3] == $logid)
			echo "&maker=Y";
		echo "&raceid=$row[0]'>$row[2] : $row[1]</a><p>\n";
	}
}else if($mode == "inviting-insert"){
	heading("대회 참가 신청");

	if($item == "etc"){
		if($itemetc == ""){
			die("종목을 입력하십시오.<p><a href='javascript:history.back()'>
뒤로</a>");
		}
		$item = $itemetc;
	}else if($item == ""){
		die("종목을 입력하십시오.<p><a href='javascript:history.back()'>뒤로</a>");
	}
	$query_name="";
	$query_value="";

	$strs = explode(":", $raceid);
	$raceid = $strs[0];
	$nickname = $strs[1];

	$query_name.="raceid,";
	$query_value.=$raceid.",";

	$query_name.="nickname,";
	$query_value.="'".$nickname."',";

	$query_name.="item,";
	$query_value.="'".$item."',";
	$query_name.="size,";
	$query_value.="'".$size."',";

	$query_name.="transport,";
	$query_value.="'".$transport."',";

	$query_name.="userid";
	$query_value.="'".$userid."'";

	$dbquery="insert into record ($query_name) values($query_value)";
//echo "dbquery=".$qdbuery;

	$result = mysql_db_query("coretek",$dbquery);

	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "<font color=red>이미 참가 신청하신 대회입니다.</font><br>";
		echo "확인 바랍니다.";
		die("");
	}else{
		echo "참가 신청 등록 처리 완료.<br>";
	}
}else if($mode == "inviting-change"){
	heading("참가 신청 정보 수정");
	$userid = $logid;
	$dbquery="select raceid from race where inviting='Y' order by raceday";
	$result = mysql_query($dbquery) or die("mysql_query error");
	for($raceids = ""; $row=mysql_fetch_array($result); $raceids.=$row[0]){
		if($raceids != "")
			$raceids.=",";
	}
	mysql_free_result($result);
	if($raceids == ""){
		echo "<font color=red>대회를 찾을 수가 없습니다.</font>";
	}else{
		$dbquery="select raceid, record.nickname, member.name, record.userid from member, record where record.raceid in ($raceids)";
		if(privcheck($userid) != 2){	// not admin
			$dbquery.=" and record.userid='$userid'";
		}
		$dbquery.= " and record.userid=member.userid order by record.nickname, member.name";
		$result2 = mysql_query($dbquery) or die("mysql_query error");
		while($row=mysql_fetch_array($result2)){
			echo "<br><a href='$PHP_SELF?mode=inviting-change2&userid=$row[3]&raceid=$row[0]'>$row[2] : $row[1]</a>";
		}
		mysql_free_result($result2);
	}
	mysql_close() or die("mysql_close error");

}else if($mode == "inviting-change2"){
	heading("참가 신청 정보 수정");

	$dbquery="select raceid, item, size, transport, fellows from record where userid='$userid' and raceid=$raceid";
	$result = mysql_query($dbquery) or die("mysql_query error");
	if($row=mysql_fetch_array($result)){
		inviting_display("inviting-update",  $row[0], $row[1], $row[2],
		 $row[3], $row[4], $userid);
	}else{
		echo "<tr><td><font color=red>'$name' 대회를 찾을 수가 없습니다.</font></td></tr>";
	}
	mysql_free_result($result);
	mysql_close() or die("mysql_close error");

}else if($mode == "inviting-delete"){
	heading("참가 신청 정보 삭제");
	if(privcheck($userid) == 1)
		$userid = $logid;
	$dbquery="delete from record where userid='$userid' and raceid=$raceid";
	$result = mysql_query($dbquery) or die("mysql_query error");

	if($result=="1"){
		echo "참가신청 삭제 완료";
	}else{
		echo "<font color=red>참가신청 삭제 오류</font>";
	}
}else if($mode == "inviting-update"){
	heading("참가 신청 정보 수정 완료");
	if($item == "etc")
		$item = $itemetc;
	$dbquery="update record set item='".$item."',size='".$size.
		"',transport='".$transport."',fellows='".$fellows."'";
	$dbquery.=" where userid='$userid' and raceid=".$raceid;
//echo "dbquery=".$dbquery;
	$result = mysql_query($dbquery) or die("mysql_query error");

	if($result=="1"){
		echo "수정 완료";
	}else{
		echo "<font color=red>수정 오류</font>";
	}
}else if($mode == "inviting-list"){
	heading("대회 참가 신청자 목록");

	$dbquery="select raceid, name, nickname, userid from race where raceday > replace(substring(now(),1,10),'-','/') order by raceday";
	$result = mysql_query($dbquery) or die("mysql_query error");
	while($row=mysql_fetch_array($result)){
		echo "<a href='$PHP_SELF?mode=inviting-list2";
		if($row[3] == $logid)
			echo "&maker=Y";
		echo "&raceid=$row[0]&racenickname=".urlencode($row[2])."'>$row[2] : $row[1]</a><p>\n";
	}
}else if($mode == "inviting-list2"){
	heading("대회 참가 신청자 목록");
	race_disp($raceid);
	echo "<p>단체 참가 신청시 아래 내용을 Copy해 엑셀에서 Paste한 후 고쳐서 사용하십시오.<br>\n";
	if(privcheck($logid) == 2)
		echo "(주민등록번호는 관리자한테만 나타납니다.)<p>\n";
	$dbquery="select record.userid, record.raceid, member.name, record.item, record.transport, record.size, member.sex, member.juminno, record.fellows, member.email  ";

	$dbquery.="from record, member where record.raceid=$raceid and record.userid=member.userid order by record.item desc, member.name";

	$result = mysql_query($dbquery) or die("mysql_query error");

	echo "<table border=1><tr><th>이름<th>성별<th>연령";
	if(privcheck($logid) == 2)
		echo "<th>주민등록번호";
	else
		echo "<th>생년월일";
	echo "<th>종목<th>Size<td>교통편<td>동행인수";
	echo "</tr>";

	$no=0;
	$total=0;
	$date = getdate();
	$year = $date['year'];
	while($row=mysql_fetch_array($result)){
		$age=$year - 1900 - substr($row[7], 0, 2);
//		if(privcheck($logid) == 2 || $maker == "Y")
		if(privcheck($logid) == 2 )
			$birthdate=$row[7];
		else
			$birthdate = substr($row[7], 0, 6);
		echo "<tr><td>";
		if($row[9] == "")
			echo "$row[2]";
		else
			echo "<a href='mailto:$row[9]'>$row[2]</a>";
		echo "<td>$row[6]<td>$age<td>$birthdate<td>$row[3]<td>$row[5]<td>$row[4]<td>$row[8]\n";
		$no++;
		$total = $total + $row[8];
	}
	echo "<tr><td colspan=4>총 $no 명입니다.<td colspan=3><td>총 $total 명";
	echo "</table>\n";
	if($no > 0){
		echo "<a href='$PHP_SELF?mode=inviting-mailsend&raceid=$raceid&racenickname=".urlencode($racenickname)."'>'$racenickname' 대회 참가자 전체에게 메일 발송</a>";
	}
	mysql_free_result($result);
}else if($mode == "record-list"){
	heading("대회 참가자 기록");
	echo "
<form name=form1 method=post action='$PHP_SELF'>
<input type=hidden name='mode' value='record-list2'>
<input type=hidden name='raceid'>
<input type=text name=racename size=50 value='아래에서 대회를 선택후 지정을 누르하십시오.'>
<p><input type=submit onClick=\"if(this.form.raceid.value==''){ alert('아래에서 대회를 지정하십시오.'); return false;}\" value='대회 참가자 기록 조회'>
</form>\n";

}else if($mode == "record-list2"){
	heading("대회 참가자 기록");
	$racenickname = race_disp($raceid);
	$dbquery="select record.userid, record.raceid, member.name, record.item, member.sex, member.juminno, record.record ";
	$dbquery.=",IF( record.item='풀', 1, IF( record.item='하프', 2, IF( record.item='10Km', 3, IF( record.item='5Km', 4, 5)))) as racetype ";
	$dbquery .= ",record.openrecord ";
//	$dbquery.="from record, member where record.raceid=$raceid and record.userid=member.userid and record.dispyn='Y' and record.record!='' order by record.item desc, ";
	$dbquery.="from record, member where record.raceid=$raceid and record.userid=member.userid and record.dispyn='Y' and record.record!='' order by racetype, ";
	if($order == "name")
		$dbquery .= "member.name";
	elseif($order == "record" || $order == "")
		$dbquery .= "record.record";
	elseif($order == "openrecord")
		$dbquery .= "record.openrecord";

//echo "$dbquery";
	$result = mysql_query($dbquery) or die("mysql_query error");

	echo "<table border=1><tr>";
	if($order == "name")
		echo "<th>이름";
	else
		echo "<th><a href='$PHP_SELF?mode=record-list2&raceid=$raceid&order=name'>이름</a>";
	echo "<th>성별<th>생년월일<th>종목";
	if($order == "record" || $order == "")
		echo "<th>기록\n";
	else
		echo "<th><a href='$PHP_SELF?mode=record-list2&raceid=$raceid&order=record'>기록</a>\n";

	if($order == "openrecord")
		echo "<th>Open환산기록\n";
	else
		echo "<th><a href='$PHP_SELF?mode=record-list2&raceid=$raceid&order=openrecord'>Open환산기록</a>\n";
	echo "<br><a href='record.php?mode=record-openrecord&raceid=$raceid&racenickname=".urlencode($racenickname)."'>(환산처리)</a></tr>\n";

				
	$no=0;
	$raceno=0;
	$hh=$mm=$ss=0;
	$racetype="";
	$opennull=0;
	while($row=mysql_fetch_array($result)){

		$birthdate=substr($row[5], 0, 6);
		echo "<tr><td>$row[2]<td>$row[4]<td>$birthdate<td>$row[3]<td>$row[6]";
		echo "<td>$row[8]\n";
		$no++;
		if($racetype=="") $racetype = $row[3];
		if($row[3] == $racetype){
			$rec = str_replace ( ";", ":", $row[6]);
			$hhmmss = explode(":", $rec);
			$hh += $hhmmss[0];
			$mm += $hhmmss[1];
			$ss += $hhmmss[2];
			$raceno++;
		}
	}
	if($raceno != 0){
		$avgsecs = round(($ss + $mm * 60 + $hh * 3600) / $raceno);
		$hh = floor($avgsecs / 3600);
		$temp = ($avgsecs - $hh * 3600);
		$mm = floor($temp / 60);
		$ss = $temp - $mm * 60;
		if(strlen($mm) == 1) $mm = "0".$mm;
		if(strlen($ss) == 1) $ss = "0".$ss;
	//echo "avgsecs=$avgsecs,hh=$hh,mm=$mm,ss=$ss,temp=$temp";
		echo "<tr><td colspan=4 align=center>$racetype $raceno 명 평균<td>$hh:$mm:$ss\n";
	}
	echo "</table>\n";
	if($no > 0){
		echo "<a href='$PHP_SELF?mode=inviting-mailsend&raceid=$raceid&racenickname=".urlencode($racenickname)."'>'$racenickname' 대회 참가자 전체에게 메일 발송</a>";
	}
	mysql_free_result($result);
}else if($mode == "inviting-mailsend"){
	heading("대회 참가자 전체에게 발송할 내용 작성");
	echo "
<form method=post action='$PHP_SELF'>
<input type=hidden name=mode value=inviting-mailsend2>
<input type=hidden name=raceid value=$raceid>
<input type=hidden name=racenickname value='$racenickname'>
<table border=1><tr>
<td align=center>메일 제목</td>
<td><input type=text name=subject size=60 maxlength=60></td>
</tr><tr>
<td align=center>받는이</td>
<td>'$racenickname' 대회 참가자 전원</td>
</tr><tr>
<td align=center>보낼 내용</td>
<td><textarea wrap=auto name=cont rows=12 cols=60></textarea></td>
</tr>
<tr>
<td colspan=2 align=center>
<input type=submit value='메일 보내기'>
</td>
</tr>
</table>
</form>";

}else if($mode == "inviting-mailsend2"){
	heading("대회 참가자 전체에게 메일 발송");
	if($subject == "" || $cont == ""){
		echo "제목과 내용을 입력해 주십시오.";
		die("");
	}

	$dbquery="select name,nickname,email from member where userid = '$logid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$row=mysql_fetch_array($result);
	$sender = "\"$row[0]($row[1])\"<$row[2]>";
	mysql_free_result($result);

	$url = "<a href='$PHP_SELF?mode=inviting-mailsend&raceid=$raceid&racenickname=".urlencode($racenickname)."'>'$racenickname' 대회 참가자 모두에게 메일 보내기</a>\n";
	$dbquery="select record.userid, member.name, member.email ";
	$dbquery.="from record, member where record.raceid=$raceid and record.userid=member.userid order by record.item desc, member.name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	$no=0;
	$mailcont_file = "/tmp/emailconttmp.dat";
	while($row=mysql_fetch_array($result)){

		$fp = fopen($mailcont_file, "w");
		fwrite($fp, "From: $sender\n");
		fwrite($fp, "To: \"$row[1]님 귀하\"<$row[2]>\n");
		fwrite($fp, "Subject: $subject\n");
		fwrite($fp, "\n");

		fwrite($fp, $cont);
		fwrite($fp, "\n");

//		fwrite($fp, "$url");
//		fwrite($fp, "\n");
		fclose($fp);
		$execret = exec("mail ".$row[2]."  < $mailcont_file");

		$no++;
		echo $row[1]." ";
		if(($no % 5) == 0){
			echo "<br>\n";
		}
		if(($no % 100) == 0){
//			sleep(5);
		}
	}
	chmod($mailcont_file, 0777);

	mysql_free_result($result);
	mysql_close() or die("mysql_close error");
	echo "<br>$no 명 메일 발송 완료.\n";
	unlink($mailcont_file);

}else if($mode == "submenu"){
	heading("메뉴 선택 오류");
	echo "서브 메뉴를 선택하십시오.";
}

function inviting_display($mode, $raceid, $item, $size, $transport, $fellows, $userid){

	global $logid, $PHP_SELF;

	$itemf=$itemh=$item10=$item5=$iteme="";
	if($item == "풀" || $item == ''){
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
	echo "<table border=1>";

	JScheckLength();
	echo "
<form action='$PHP_SELF' method=post>\n
<input type=hidden name=mode value='$mode'>\n";

	$count=0;
	echo "<tr><td>참가대회</td><td>\n";
	if($mode == "inviting-inserttmp"){
		$dbquery="select raceid, name, nickname from race where inviting='Y'";
		$result = mysql_query($dbquery) or die("mysql_query error");
		echo "<select name='raceid' size='1' style='background-color: white; color: blue; font:10pt'>\n";

		for(; $row=mysql_fetch_array($result); ){
			$dbquery="select count(*) from record where userid='$userid' and raceid=$row[0]";

			$result2 = mysql_query($dbquery) or die("mysql_query error2");
			$row2=mysql_fetch_array($result2);
			if($row2[0] == 0){
				echo "<option value='$row[0]:$row[2]'>$row[2] : $row[1]</option>\n";
				$count++;
			}
		}
		if($count == 0)
			echo "<option value='0:0'>!! 참가 가능한 대회가 없습니다 !!</option>";
		echo "</select>";
	}else{
		$dbquery="select raceid, name, nickname from race where raceid=$raceid";
		$result = mysql_query($dbquery) or die("mysql_query error");
		if($row=mysql_fetch_array($result)){
			echo "$row[2] : $row[1]\n";
			if($mode == "inviting-insert" || $mode == "inviting-insertmember")
				echo "<input type=hidden name='raceid' value='$row[0]:$row[2]'>\n";
			else	// inviting-update
				echo "<input type=hidden name='raceid' value='$row[0]'>\n";
			$count=1;
		}
	}
	mysql_free_result($result);

	if($userid){
		echo "<input type=hidden name=userid value='$userid'>\n";
	}else{
		echo "<tr><td>참가자</td><td>\n";
		$dbquery="select userid, name from member order by name";
		$result = mysql_query($dbquery) or die("mysql_query error");
		echo "<select name='userid' size='1' style='background-color: white; color: blue; font:10pt'>\n";

		for(; $row=mysql_fetch_array($result); ){
			echo "<option value='$row[0]'>$row[1]</option>\n";
		}
		mysql_free_result($result);
	}

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
<tr><td>T-Shirt크기</td><td><input type=text name=size value='$size' maxlength=4 size=5 onChange='return checkLength(this.value,4)'>반드시 대회 요강을 확인 후 기재 요망</td></tr>\n
<tr><td>교통편</td><td><input type=text name=transport value='$transport' maxlength=20 size=20 onChange='return checkLength(this.value,20)'>예 : 무임승차 요망, 자가용 제공 등</td></tr>\n
<tr><td>단체이동인원</td><td><input type=text name=fellows value='$fellows' maxlength=2 size=2 onChange='return checkLength(this.value,2)'>본인을 포함한 단체이동 인원수, 단체이동이 아닐 경우 0</td></tr>\n
<tr><td colspan=2 align=center>";

	if(privcheck($logid)){
		if($count > 0){
			echo "<br><input type=submit value='";
			if($mode == "inviting-insert")
				echo "등록";
			else
				echo "수정";
			echo " 처리'>";
			if($mode == "inviting-update"){
				echo "<p>
</form>
<form action='$PHP_SELF' method=post>\n
<input type=hidden name=mode value='inviting-delete'>\n
<input type=hidden name=raceid value='$raceid'>\n
<input type=submit value='삭제 처리'>";
			}
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
