<?
if ($cafe_style != "yes")
	include "top.php";
?>

<center> <a href="http://www.bundangmarathon.com/member/prog/old_president_list.html"> <img src="../../img/old_presi.jpg"> </a></center>

<?php

require("./config.php");
require("./function.php");

top("");

if($mode == "mempub-photo"){
	echo "<p align='center'>
	<hr width='600' noshade color='red'><br>
	<font size='+5'>회원안내</font>
	<p align='center'>
	<hr width='600' noshade color='red'>";

	echo "<p><table width=650 align=center border=0><tr><td>
<p>분당마라톤클럽 회원들은 거의 다 인터넷을 사용해 정보를 주고 받습니다.
이메일 연락이 가능하고, 풀코스를 뛰었거나 앞으로 풀코스를 뛰고자 하는
열정이 있는 마라톤을 사랑하는 사람이라면 누구나 가입이 가능합니다. </p>
<p>다음은 현 회원 명단입니다. 수정 사항이 있는 회원은 미디어팀장에게 쪽지 보내 주시기 바랍니다.
</td></tr></table><p>";

	echo "<table border=0 width=400 height=30 align='center'>\n";
	echo "<tr align=center><td bgcolor=#309030>서브쓰리<td bgcolor=#50ff50 width=80>330 이내<td bgcolor='#90ff90' width=80>서브4<td bgcolor=#d0ffd0 width=80>그외 기록</td><td bgcolor='#ddddff' width=80>풀기록없음</td></tr>\n";

	echo "</table><br><br>\n";

	$rowmemno = 5;
	$memtype[0] = "정회원";
	$memtype[1] = "준회원";
	$memorder[0] = "gumpuno";
	$memorder[1] = "name";
    for($loop=0; $loop < 2; $loop++){
	$loopname = $memtype[$loop];
	$looporder = $memorder[$loop];
	$dbquery = "select userid, name, photo, grade, gumpuno, boston from member";
	$dbquery .= " where membertype='$loopname'";
	if($loop == 0)
		$dbquery .= " or grade='자문위원'";
	$dbquery .= " order by disporder, $looporder";
	$result = mysql_query($dbquery) or die("mysql_query error1");

	echo "<table border=0 align=center width=540>\n";
	echo "<tr height=5><td width=160><td width=160><td width=160><td width=160></tr>\n";
	echo "<tr><td height=30 colspan=$rowmemno align=center style='font-size:18'>$loopname</td></tr>";
	echo "<tr height=5><td width=160><td width=160><td width=160><td width=160></tr>\n";
	$tmp = "";
	$nomember = 0;
	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";
		if($row[3])
			$tmp = "$row[3]";
		$dbquery2 = "select record from record";
		$dbquery2 .= " where userid='$row[0]' and item='풀' and record != '' order by record";
		$result2 = mysql_query($dbquery2) or die("mysql_query error2");
		$row2=mysql_fetch_array($result2);
		$bestrecord = $row2[0];
		if($bestrecord == ""){
			$bgcol = "'#ddddff'";
		}else if($bestrecord < "3:00:00"){
			$bgcol = "#009000";
		}else if($bestrecord < "3:30:00"){
			$bgcol = "#50ff50";
		}else if($bestrecord < "4:00:00"){
			$bgcol = "'#a0ffa0'"; 
		}else {
			$bgcol = "'#d0ffd0'";
		}
		echo "<td align=center bgcolor=$bgcol width=130>";
		echo "<a href='$PHP_SELF?mode=mempub-one&userid=$row[0]'>";

		// figure
		if ($row[2] !="")
			echo "<img src='../photo/$row[2]' width=135 height=180 border=0><br>";

		echo "$row[1]"; // name

		if($loop == 0 && !$row[gumpuno])
			$nomember++;
		if($row[3])
			echo "$row[3]";
		    echo "($row[gumpuno])";

		if($bestrecord != ""){
			$racetimes = mysql_num_rows($result2) or die("mysql error 3");
			echo "<br>$bestrecord(풀 $racetimes 회)";

		}else{
			echo "<br>";
		}
/* */
		mysql_free_result($result2);
/* */
		echo "</a>";
		echo "</td>\n";
		if(($i % $rowmemno) == ($rowmemno - 1)){
			echo "</tr>";
			echo "<tr height=3><td></td><td/><td/><td/></tr>";
			$tmp = "";
		}
	}
	$members = $i - $nomember;
	echo "<tr><td colspan=$rowmemno align=right>$loopname 총 $members 명</td></tr></table><br><br>\n";
	mysql_free_result($result);
    }

	$rowmemno2 = 5;

	$dbquery = "select userid, name from member";
	$dbquery .= " where membertype='자료이상' order by disporder, name";
	$result = mysql_query($dbquery) or die("mysql_query error4");
    if(mysql_num_rows($result) > 0){
	echo "<table border=0><tr><td height=30 colspan=$rowmemno2 align=center style='font-size:18'>자료이상</td></tr>";
	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno2) == 0)
			echo "<tr valign=top>";
		echo "<td align=center><a href='$PHP_SELF?mode=mempub-one&userid=$row[0]'>$row[1]</a></td>\n";
		if(($i % $rowmemno2) == ($rowmemno2 - 1))
			echo "</tr>";
	}
	mysql_free_result($result);
	echo "</table><br><br>";
    }

	echo "<table border=0><tr><td height=30 colspan=$rowmemno2 align=center style='font-size:14'>예비회원</td></tr>";
	$dbquery = "select userid, name from member";
	$dbquery .= " where membertype='예비회원' order by disporder, name";
	$result = mysql_query($dbquery) or die("mysql_query error4");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno2) == 0)
			echo "<tr valign=top>";
		echo "<td align=center bgcolor=#f0f0f0><a href='$PHP_SELF?mode=mempub-one&userid=$row[0]'>$row[1]</a></td>\n";
		if(($i % $rowmemno2) == ($rowmemno2 - 1))
			echo "</tr>";
	}
	mysql_free_result($result);
	echo "</table><br><br>";

	echo "<table border=0><tr><td colspan=$rowmemno2 align=center style='font-size:14'>휴면회원</td></tr>";
	$dbquery = "select userid, name, photo, gumpuno from member";
	$dbquery .= " where membertype='휴면회원' order by disporder, name";
	$result = mysql_query($dbquery) or die("mysql_query error5");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno2) == 0)
			echo "<tr valign=top>";
		if($row[3])
			$tmp = "($row[3])";
		else
			$tmp = "";
		echo "<td align=center>";
		echo "$row[1]";
		echo "<br>";
		/* echo "<br><img src='../photo/$row[2]' border=0 height=100>"; */
//		echo "</a>";
		echo "</td>\n";
		if(($i % $rowmemno2) == ($rowmemno2 - 1))
			echo "</tr>";
	}
	mysql_free_result($result);
	echo "</table><br><br>\n";

//if(0 == 1){ // 당분간 사용하지 않음
	echo "<table border=0><tr><td height=30 colspan=$rowmemno2 align=center style='font-size:14'>OB회원</td></tr>";
	$dbquery = "select userid, name, photo, gumpuno from member";
	$dbquery .= " where membertype='OB회원' order by disporder, name";
	$result = mysql_query($dbquery) or die("mysql_query error6");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno2) == 0)
			echo "<tr valign=top>";
		if($row[3])
			$tmp = "($row[3])";
		else
			$tmp = "";
		echo "<td align=center>";
//		echo "<a href='$PHP_SELF?mode=mempub-one&userid=$row[0]'>";
#		echo "$row[1]$tmp";
		echo "$row[1]";
/*
		$dbquery2 = "select record from record";
		$dbquery2 .= " where userid='$row[0]' and item='풀' and record != '' order by record limit 1";
		$result2 = mysql_query($dbquery2) or die("mysql_query error2");
		$row2=mysql_fetch_array($result2);
		if($row2[0] != "")
			echo "<br>$row2[0]";
		else
			echo "<br>";
		mysql_free_result($result2);
*/
//		echo "<br><img src='../photo/$row[2]' border=0>";
//		echo "</a>";
		echo "</td>\n";
		if(($i % $rowmemno2) == ($rowmemno2 - 1))
			echo "</tr>";
	}
	mysql_free_result($result);

	echo "</table><br><br>\n";
//}

}else if($mode == "mempub-one"){
	echo "<p align='center'>
	<hr width='600' noshade color='red'><br>
	<font size='+2'>회원안내</font>
	<p align='center'>
	<hr width='600' noshade color='red'>";

	$dbquery="select name, nickname, juminno, org, orghref, email, photo,";
	$dbquery.="telhome, teloffice, telhand, postaddr, membertype, grade, ";
	$dbquery.="gumpuno, etc, boston from member where userid='$userid'";
	$result = mysql_query($dbquery) or die("mysql_query error7");
	$row=mysql_fetch_array($result);

	$name = $row[0];
	$membertype = $row[11];
	echo "
<script language='javascript'> 
function AntiSpam2(id) 
{ 
	window.open('/bbs/gdantispamin.php?UniqId='+id,'AntiSpam','width=180,height=263,left=1,top=1,resize'); 
} 
</script>\n";
	echo "<table align='center' border=1>\n";
	echo "<tr><td>이름(별명)<td>$name";
	if($row[1])
		echo "($row[1])\n";
	else
		echo "\n";
	echo "<tr><td>구분<td>$row[11]";
	if($row[12])
		echo "($row[12])";
	if($row[11] == "정회원")
		echo ", 회원번호:$row[13]";
	echo "\n";
/*
	echo "<tr><td>생년월일<td>";
	if($row[2] && substr($row[2],0,6) != "xxxxxx"){
		$birthdate = "19";
		$birthdate .= substr($row[2], 0, 2);
		$birthdate .= ".";
		$birthdate .= substr($row[2], 2, 2);
		$birthdate .= ".";
		$birthdate .= substr($row[2], 4, 2);
		echo "$birthdate \n";
	}else
		echo "생년월일 입력안됨 \n";
*/
	echo "<tr><td>일터<td>\n";
	if(strlen($row[4])>4){
		if(substr($row[4],0,4) != "http")
			$orghref = "http://" . $row[4];
		else
			$orghref = $row[4];
		echo "<a href='$orghref' target=_new>$row[3]</a>\n";
	}else{
		echo "$row[3]\n";
	}
	echo "<tr><td>E-mail<td><a href=\"javascript:AntiSpam2('$userid')\">클릭하십시오.</a>\n"; // $row[5]
	if($membertype != "예비회원")
		echo "<tr><td>사진<td><img src='../photo/$row[6]' border=0>";
	if($row[15] != "")
		bostonrace($row[15], "0");
	echo "\n";

	// outlogin.php에 copy됨
	$addr=$row[10];
	if(($pos = strstr($addr, "동 ")) != false){
		$addr=substr($addr,0,strlen($addr)-strlen($pos)+2);
	}else if(($pos = strstr($addr, "리 ")) != false){
		$addr=substr($addr,0,strlen($addr)-strlen($pos)+2);
	}else if(($pos = strstr($addr, "번지 ")) != false){
		$addr=substr($addr,0,strlen($addr)-strlen($pos)+4);
	}else if(($pos = strstr($addr, "마을 ")) != false){
		$addr=substr($addr,0,strlen($addr)-strlen($pos)+4);
	}else if(($pos = strstr($addr, "단지 ")) != false){
		$addr=substr($addr,0,strlen($addr)-strlen($pos)+4);
	}else if(($pos = strstr($addr, "아파트 ")) != false){
		$addr=substr($addr,0,strlen($addr)-strlen($pos)+6);
	}else if(($pos = strstr($addr, "APT ")) != false){
		$addr=substr($addr,0,strlen($addr)-strlen($pos)+3);
	}else if(($pos = strrpos($addr, " ")) != false){
		$addr=substr($addr,0,$pos);
	}else{
		$addr=substr($addr, 0, strlen($addr)/2);
	}
//	$addr="";
	echo "<tr><td>주소<td>$addr\n"; // $row[10]
	echo "<tr><td>소개<td>$row[14]\n";
	echo "</table>\n";

	if($membertype == "예비회원")
			die("");

	echo "<br><br>\n";
	require("./func_nextimg.php");

	if(nextimg($name) == 0){
		echo "<p align=center style='color:red;'>대회 참가 사진이 없습니다.<br>좋은 사진을 골라 보내 주십시오.\n";
	}

	if($orderfield == "")
		$orderfield = "record";
	if($orderfield == "item" || $orderfield == "record"){
		$nodisp = "Y";
	}else{
		$nodisp = "N";
	}
	echo "<br><br><table align='center' border=1><tr><th colspan=7>개인 기록</tr>\n";
	echo "<tr>";
	if ($nodisp == "Y"){
			echo "<th><font color=black>No</font>";
	}
	echo "<th><font color=black>대회명</font>";
    	if($orderfield == "raceday"){
		echo "<th><font color=black>날짜</font>\n";
	}else{
		echo "<th><a href='$PHP_SELF?mode=mempub-one&userid=$userid&orderfield=raceday'><font color=blue>날짜</font></a>\n";
	}
	if($orderfield == "item"){
		echo "<th><font color=black>종목</font>\n";
	}else{
		echo "<th><a href='$PHP_SELF?mode=mempub-one&userid=$userid&orderfield=item'><font color=blue>종목</font></a>\n";
	}
	if($orderfield == "record"){
		echo "<th><font color=black>기록</font>\n";
	}else{
		echo "<th><a href='$PHP_SELF?mode=mempub-one&userid=$userid&orderfield=record'><font color=blue>기록</font></a>\n";
	}

    	if($orderfield == "raceday"){
		$orderfield = "race.raceday desc";
	}else if($orderfield == "item"){
		$orderfield = "itemnew, race.raceday desc";
	}else if($orderfield == "" or $orderfield == "record"){
		$orderfield = "itemnew, record.record";
	}
	$dbquery="select race.raceid, race.nickname, race.raceday, record.item, record.record, record.rank, record.dispyn, record.etc";
	$dbquery .= ", IF( record.item='풀', 1, IF( record.item='하프', 2, IF( record.item='10Km', 3, IF( record.item='5Km', 4, 5)))) as itemnew";
	$dbquery .= " from race,record where record.userid='$userid' and (record.record != '' and record.record is not null) and record.dispyn='Y' and record.raceid=race.raceid order by ".$orderfield;
	$result = mysql_query($dbquery) or die("mysql_query error8");

	echo "<th><font color=black>순위</font><th><font color=black>기타</font></tr>";
	$racetype = "";
	for($i = 1; $row=mysql_fetch_array($result); $i++){
		if($racetype != $row[3]){
			$i = 1;
			$racetype = $row[3];
		}
		echo "<tr>";
		if ($nodisp == "Y"){
			echo "<td>$i";
		}
		echo "<td>$row[1] <td>$row[2] <td>$row[3]";
		echo "<td>$row[4]<td>$row[5]<td>$row[7]\n";
	}
	echo "</tr></table>";

	mysql_free_result($result);

}else if($mode == "mempub-subscribe-input"){
	heading("회원가입신청");

	echo "<table border=1 align='center'>";
	JScheckLength();
echo "
<form action='$PHP_SELF' method=post>\n
<input type=hidden name=mode value='mempub-subscribe-insert'>\n
";
	echo "
<tr><td>사용자ID*</td><td><input type=text name=userid maxlength=12 size=12> 영문소문자/숫자로 작성(부적절하면 임의 수정함)</td></tr>\n
<tr><td>암호*</td><td><input type=password name=passwd maxlength=10 size=10>\n
&nbsp;&nbsp;&nbsp;암호확인*<input type=password name=passwd2 maxlength=10 size=10></td></tr>\n";

	echo "
<tr><td>이름*</td><td><input type=text name=name maxlength=10 size=10></td></tr>\n
<tr><td>성별</td><td>
<input type='radio' name='sex' value='M' checked>남(Male)
<input type='radio' name='sex' value='F'>여(Female)
</td></tr>\n";

echo "
<tr><td>주민등록번호*</td><td><input type=text name=juminno maxlength=14 size=15> (123456-1234567)</td></tr>\n
<tr><td>직장명</td><td><input type=text name=org maxlength=30 size=30 onChange='return checkLength(this.value,30)'></td></tr>\n
<tr><td>직장홈주소</td><td><input type=text name=orghref maxlength=50 size=40 onChange='return checkLength(this.value,50)'> (예: http://www.xxx.yyy.kr)</td></tr>\n
<tr><td>E-Mail 주소*</td><td><input type=text name=email maxlength=30 size=30 onChange='return checkLength(this.value,30)'></td></tr>\n
<tr><td>우편번호</td><td><input type=text name=postno maxlength=7 size=8></td></tr>\n
<tr><td>주소</td><td><input type=text name=postaddr maxlength=60 size=40 onChange='return checkLength(this.value,60)'></td></tr>\n
";

	echo "
<tr><td>전화Home</td><td><input type=text name=telhome maxlength=15 size=20></td></tr>\n
<tr><td>전화Office</td><td><input type=text name=teloffice maxlength=15 size=20></td></tr>\n
<tr><td>전화Hand</td><td><input type=text name=telhand maxlength=15 size=20></td></tr>\n";


	echo "
<tr><td>가입 소감</td><td><input type=text name=etc maxlength=80 size=40 onChange='return checkLength(this.value,80)'> (한글 40자 이내)</td></tr>\n
<tr><td colspan=2 align=center><input type=submit value='가입신청'>\n
<p>3개월 내에 준회원 자격을 갖추지 못하면 입력한 자료는 임의로 삭제될 수 있습니다.\n
</form>";
	echo "</table>";
}else if($mode == "mempub-subscribe-insert"){
	heading("신규 회원 등록");

	if($userid == "" || $passwd == "" || $name == "" || $juminno == "" || $email == ""){
		echo "<font color=red size='+2'>자료 입력 이상</font><p>\n";
		echo "사용자ID, 암호, 이름, 생년월일, E-Mail 주소 등이 없습니다.<br><br>";
		echo "<a href='javascript:history.back();'>뒤로</a>";
		die("");
	}
	for($i=0; $i < strlen($userid); $i++){
		$onechar = substr($userid,$i,1);
		if($i == 0 && ($onechar < "a" || $onechar > "z") ||
			$onechar < "0" || $onechar > "z"){
			echo "<font color=red size='+2'>자료 입력 이상</font><p>\n";
			echo "사용자ID는 영문 소문자로 시작하고 영문 소문자나 숫자로 구성됩니다.";
			echo "<a href='javascript:history.back();'>뒤로</a>";
			die("");
		}
	}
	if($passwd != $passwd2){
		echo "암호가 서로 틀립니다.<p>";
			echo "<a href='javascript:history.back();'>뒤로</a>";
			die("");
	}
	if(strstr($passwd, "'") != false){
		echo "암호에 해당 특수문자를 사용할 수 없습니다.";
			echo "<a href='javascript:history.back();'>뒤로</a>";
			die("");
	}
	$dbquery="select userid, name from member where userid='$userid'";
	$result = mysql_query($dbquery) or die("mysql_query error9");
	$rows = mysql_num_rows($result);
	if($rows == 1){
		$row=mysql_fetch_array($result);
		echo "ID가 다른 회원($row[1])과 중복입니다.<br><br>";
		echo "<a href='javascript:history.back();'>뒤로</a>";
		die("");
	}
	mysql_free_result($result);

/* 최대 하루 등록 건수 10건 제한 */
	$timenow = time();
	$currentday = date("Y/m/d", $timenow);
//echo "currentday=$currentday";

	$dbquery="select userid, name, photo from member where nickname='$currentday' and photo >= '0' and photo <= '99' order by photo desc";
	$result = mysql_query($dbquery) or die("mysql_query error10");
	$rows = mysql_num_rows($result);
	if($rows >= 1){
		$row=mysql_fetch_array($result);
		$maxno = $row[2];
		if($maxno >= '9'){
			echo "신규등록이 너무 많습니다. 내일 다시 하십시오.<br><br>";
			echo "<a href='javascript:history.back();'>뒤로</a>";
			die("");
		}
		$maxno++;
	}else{
		$maxno = "0";
	}

	$query_name="";
	$query_value="";

	$query_name.="userid,";
	$query_value.="'".$userid."',";

	$query_name.="passwd,";
	$query_value.="'".$passwd."',";

	$name = str_replace(" ", "", $name);
	$query_name.="name,";
	$query_value.="'".$name."',";

	$query_name.="sex,";
	$query_value.="'".$sex."',";

	$query_name.="juminno,";
	$query_value.="'".$juminno."',";

	$query_name.="org,";
	$query_value.="'".$org."',";
	$query_name.="orghref,";
	$query_value.="'".$orghref."',";

	$query_name.="email,";
	$query_value.="'".$email."',";

	$query_name.="postno,";
	$query_value.="'".$postno."',";

	$query_name.="postaddr,";
	$query_value.="'".$postaddr."',";

	if($telhome!=""){
		$query_name.="telhome,";
		$query_value.="'".$telhome."',";
	}

	if($teloffice!=""){
		$query_name.="teloffice,";
		$query_value.="'".$teloffice."',";
	}

	if($telhand!=""){
		$query_name.="telhand,";
		$query_value.="'".$telhand."',";
	}

	$query_name.="membertype,";
	$query_value.="'예비회원',";

	if($disporder == "")
		$disporder = "99";
	$query_name.="disporder,";
	$query_value.="'".$disporder."',";

	$query_name.="nickname,";
	$query_value.="'".$currentday."',";
	$query_name.="photo,";
	$query_value.="'".$maxno."',";

	$query_name.="indate,";
	$query_value.="'".$currentday."',";

	$query_name.="etc";
	$query_value.="'".$etc."'";

	$dbquery="insert into member ($query_name) values($query_value)";
//echo "qbquery=$dbquery";
	$result = mysql_db_query("coretek",$dbquery);

	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "등록 오류입니다.<br>";
		echo "<a href='javascript:history.back();'>뒤로</a>";
		die("");
	}else{
		echo "예비회원으로 등록 처리 완료.<br><br>";
		echo "가입 내역이 총무에게 메일로 전달됩니다.<br><br>";
		echo "준회원 요건을 갖춘 후 총무가 준회원으로 등록하면<br>회원광장 이용이 가능합니다.\n";

		$cont = "회원광장에서 신규 가입 신청을 하였습니다.\n\n";
		$cont.= "이름: $name\nID: $userid\n성별: $sex\n생년월일: $juminno\n";
		$cont.= "소속: $org\nE-mail: $email\n주소: $postaddr\n";
		$cont.= "Tel Home: $telhome\nTel Office: $teloffice\nTel Hand: $telhand\n";
		$cont.= "가입소감: $etc\n";
		mailsend($name, $email, "총무", $managerEmail, "신규 가입 신청 - $name", $cont);
	}

}

?>
<p>&nbsp;</p>
</center>
</body>
</html>
<?
	include "bot.php";
?>
<map name="home">
<area shape="rect" coords="500, 50, 541, 66" href="/">
</map>
