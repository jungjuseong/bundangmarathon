<?php

require("./bmauth.php");
require("./bmconfig.php");
require("./bmfunction.php");

	top("");

$dbquery="select membertype from member where userid='$logid'";
$result = mysql_query($dbquery) or die("mysql_query error");
if($row=mysql_fetch_array($result)){
	if( $row[0]=='정회원' || $row[0]=='준회원'){
		;
	}else{
		exit(0);
		echo "Are you Hacker?\n";
	}
}else{
	exit(0);
	echo "Are you Hacker?\n";
}

if($mode == "meminfo-brief" or $mode == "meminfo-photo"){
	echo "
<style>
A:link { color: blue; text-decoration: none; }
A:visited { color: blue; text-decoration: none;}
A:active { color: blue; text-decoration: none;}
A:hover { color: blue; text-decoration: none}
</style>

<script language='JavaScript'>
function winopen(userid){
    PopUp = window.open ('$PHP_SELF?mode=meminfo-one&userid='+userid, 'popup_answer', 'width=600,height=700, top=100, left=100, resizable=1,scrollbars=yes');
    PopUp.focus();
}
</script>";
}

$photo_dir = substr($path2photo, strlen($home));
//echo "photo_dir=$photo_dir";
if($mode == "meminfo-brief"){
	heading("회원 정보 보기");

	echo "<a href=$PHP_SELF?mode=meminfo-photo>전 회원 사진 일괄 보기</a><br>";

	$date = getdate();
	echo "(".$date['year']."/".$date['mon']."/".$date['mday']." 현재 회원 현황입니다.)<br>";

	$rowmemno = 5;
	$dbquery = "select userid, name, photo, grade, gumpuno, boston from member";
	$dbquery .= " where membertype='정회원' or grade='자문위원' order by disporder, gumpuno";
	$result = mysql_query($dbquery) or die("mysql_query error");

	echo "<table width=500 border=1><tr><td colspan=$rowmemno align=center style='font-size:20'>정회원</td></tr>";
	$tmp = "";
	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";

//		if($row[3])
//			$tmp = "$row[3]";

		echo "<td align=center>";
		echo "<a href='' onClick='winopen(\"$row[0]\"); return false' >";
		echo "$row[1]($row[4])";
		if($row[3])
			echo "<br>$row[3]";
		else
			echo "<br>&nbsp;";
		echo "</a></td>\n";
		if(!$row[gumpuno])
			$nomember++;
		if(($i % $rowmemno) == ($rowmemno-1)){
			echo "</tr>";
//			$tmp = "";
		}
	}
	$members = $i - $nomember;
	echo "<tr><td colspan=$rowmemno align=center>정회원 총 $members 명</td></tr></table><br>\n";
	mysql_free_result($result);

	echo "<table width=500 border=1><tr><td colspan=$rowmemno align=center style='font-size:20'>준회원</td></tr>";
	$dbquery = "select userid, name, photo, grade, boston from member";
	$dbquery .= " where membertype='준회원' order by disporder, name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";
/*
		if($row[3])
			$tmp = "<br>($row[3])";
		else
			$tmp = "<br>&nbsp;";
*/
		echo "<td align=center>";
		echo "<a href='' onClick='winopen(\"$row[0]\"); return false' >";
		echo "$row[1]$tmp";
		echo "</a></td>\n";
		if(($i % $rowmemno) == ($rowmemno-1))
			echo "</tr>";
	}
	mysql_free_result($result);

	echo "<tr><td colspan=$rowmemno align=center>준회원 총 $i 명</td></tr>\n";
	echo "</table><p>\n";

	echo "<table border=1><tr><td colspan=$rowmemno align=center style='font-size:20'>예비회원</td></tr>";
	$dbquery = "select userid, name, photo, grade from member";
	$dbquery .= " where membertype='예비회원' order by disporder, name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";
		echo "<td align=center>\n";
		echo "<a href='' onClick='winopen(\"$row[0]\"); return false' >";
		echo "$row[1]</a></td>\n";
		if(($i % $rowmemno) == ($rowmemno-1))
			echo "</tr>";
	}
	mysql_free_result($result);

	echo "<tr><td colspan=$rowmemno align=center style='font-size:20'>휴면회원</td></tr>";
	$dbquery = "select userid, name, photo, gumpuno from member";
	$dbquery .= " where membertype='휴면회원' order by disporder, name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";
		if($row[3])
			$tmp = "($row[3])";
		else
			$tmp = "";
		echo "<td align=center>";
		echo "<a href='' onClick='winopen(\"$row[0]\"); return false' >";
		echo "$row[1]$tmp";
		echo "</a>";
		echo "</td>\n";
		if(($i % $rowmemno) == ($rowmemno-1))
			echo "</tr>";
	}
	mysql_free_result($result);

	echo "<tr><td colspan=$rowmemno align=center style='font-size:20'>OB회원</td></tr>";
	$dbquery = "select userid, name, photo, gumpuno from member";
	$dbquery .= " where membertype='OB회원' order by disporder, name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";
		if($row[3])
			$tmp = "($row[3])";
		else
			$tmp = "";
		echo "<td align=center>";
		echo "<a href='' onClick='winopen(\"$row[0]\"); return false' >";
		echo "$row[1]$tmp";
		echo "</a>";
		echo "</td>\n";
		if(($i % $rowmemno) == ($rowmemno-1))
			echo "</tr>";
	}
	mysql_free_result($result);

	echo "</table>\n";
}else if($mode == "meminfo-photo"){
	heading("회원 정보 보기");

	$rowmemno = 4;
	$dbquery = "select userid, name, photo, grade, gumpuno, boston from member";
	$dbquery .= " where membertype='정회원' order by disporder, gumpuno";
	$result = mysql_query($dbquery) or die("mysql_query error");

	echo "<table border=1><tr><td colspan=$rowmemno align=center style='font-size:20'>정회원</td></tr>";
	$tmp = "";
	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";

		if($row[3])
			$tmp = "$row[3]";

		echo "<td align=center>";
		echo "<a href='' onClick='winopen(\"$row[0]\"); return false' >";
		echo "$row[1]($row[4])";
		if($row[3])
			echo "<br>$row[3]";
		else if($tmp)
			echo "<br>";
		$dbquery2 = "select record from record";
		$dbquery2 .= " where userid='$row[0]' and item='풀' and record != '' order by record limit 1";
		$result2 = mysql_query($dbquery2) or die("mysql_query error2");
		$row2=mysql_fetch_array($result2);
		if($row2[0] != ""){
			echo "<br>$row2[0]";
		}else{
			echo "<br>";
		}
		echo "<br><img src='$photo_dir/$row[2]' border=0>";
/*
		if($row[5] != ""){
			echo "<br>";
			bostonrace($row[5], "20");
		}
*/
		mysql_free_result($result2);
		echo "</a></td>\n";
		if(($i % $rowmemno) == ($rowmemno-1)){
			echo "</tr>";
			$tmp = "";
		}
	}
	echo "<tr><td colspan=$rowmemno align=center>정회원 총 $i 명</td></tr></table><br><br>\n";
	mysql_free_result($result);

	echo "<table border=1><tr><td colspan=$rowmemno align=center style='font-size:20'>준회원</td></tr>";
	$dbquery = "select userid, name, photo, grade, boston from member";
	$dbquery .= " where membertype='준회원' order by disporder, name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";
		if($row[3])
			$tmp = "($row[3])";
		else
			$tmp = "";
		echo "<td align=center>";
		echo "<a href='' onClick='winopen(\"$row[0]\"); return false' >";
		echo "$row[1]$tmp";
		$dbquery2 = "select record from record";
		$dbquery2 .= " where userid='$row[0]' and item='풀' and record != '' order by record limit 1";
		$result2 = mysql_query($dbquery2) or die("mysql_query error2");
		$row2=mysql_fetch_array($result2);
		if($row2[0] != ""){
			echo "<br>$row2[0]";
		}else{
			echo "<br>";
		}
		echo "<br><img src='$photo_dir/$row[2]' border=0>";
/*
		if($row[4] != ""){
			echo "<br>";
			bostonrace($row[4], "20");
		}
*/
		mysql_free_result($result2);
		echo "</a></td>\n";
		if(($i % $rowmemno) == ($rowmemno-1))
			echo "</tr>";
	}
	mysql_free_result($result);

	echo "<tr><td colspan=$rowmemno align=center>준회원 총 $i 명</td></tr>\n";
	echo "</table><p>\n";

	echo "<table border=1><tr><td colspan=$rowmemno align=center style='font-size:20'>예비회원</td></tr>";
	$dbquery = "select userid, name, photo, grade from member";
	$dbquery .= " where membertype='예비회원' order by disporder, name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";
		echo "<td align=center>\n";
		echo "<a href='' onClick='winopen(\"$row[0]\"); return false' >";
		echo "$row[1]</a></td>\n";
		if(($i % $rowmemno) == ($rowmemno-1))
			echo "</tr>";
	}
	mysql_free_result($result);

	echo "<tr><td colspan=$rowmemno align=center style='font-size:20'>휴면회원</td></tr>";
	$dbquery = "select userid, name, photo, gumpuno from member";
	$dbquery .= " where membertype='휴면회원' order by disporder, name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";
		if($row[3])
			$tmp = "($row[3])";
		else
			$tmp = "";
		echo "<td align=center>";
		echo "<a href='' onClick='winopen(\"$row[0]\"); return false' >";
		echo "$row[1]$tmp";
		$dbquery2 = "select record from record";
		$dbquery2 .= " where userid='$row[0]' and item='풀' and record != '' order by record limit 1";
		$result2 = mysql_query($dbquery2) or die("mysql_query error2");
		$row2=mysql_fetch_array($result2);
		if($row2[0] != "")
			echo "<br>$row2[0]";
		else
			echo "<br>";
		echo "<br><img src='$photo_dir/$row[2]' border=0>";
		mysql_free_result($result2);
		echo "</a>";
		echo "</td>\n";
		if(($i % $rowmemno) == ($rowmemno-1))
			echo "</tr>";
	}
	mysql_free_result($result);

	echo "<tr><td colspan=$rowmemno align=center style='font-size:20'>OB회원</td></tr>";
	$dbquery = "select userid, name, photo, gumpuno from member";
	$dbquery .= " where membertype='OB회원' order by disporder, name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(($i % $rowmemno) == 0)
			echo "<tr valign=top>";
		if($row[3])
			$tmp = "($row[3])";
		else
			$tmp = "";
		echo "<td align=center>";
		echo "<a href='' onClick='winopen(\"$row[0]\"); return false' >";
		echo "$row[1]$tmp";
		$dbquery2 = "select record from record";
		$dbquery2 .= " where userid='$row[0]' and item='풀' and record != '' order by record limit 1";
		$result2 = mysql_query($dbquery2) or die("mysql_query error2");
		$row2=mysql_fetch_array($result2);
		if($row2[0] != "")
			echo "<br>$row2[0]";
		else
			echo "<br>";
		echo "<br><img src='$photo_dir/$row[2]' border=0>";
		mysql_free_result($result2);
		echo "</a>";
		echo "</td>\n";
		if(($i % $rowmemno) == ($rowmemno-1))
			echo "</tr>";
	}
	mysql_free_result($result);

	echo "</table>\n";
}else if($mode == "meminfo-one"){
	heading("회원 소개");

	$dbquery="select name, nickname, juminno, org, orghref, email, photo,";
	$dbquery.="telhome, teloffice, telhand, postaddr, membertype, grade, ";
	$dbquery.="gumpuno, etc, boston from member where userid='$userid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$row=mysql_fetch_array($result);

	$name = $row[0];
	echo "<table border=1>\n";
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
	echo "<tr><td>E-mail<td><a href='mailto:$row[5]'>$row[5]</a>\n";
	echo "<tr><td>사진<td>";
	if(strlen($row[6])>5)
		echo "<img src='$photo_dir/$row[6]' border=0>";
	if($row[15] != "")
		bostonrace($row[15], "0");
	echo "\n";
	echo "<tr><td>전화번호<td>";
	if($logid != ""){
		if($row[7])
			echo "H:$row[7]";
		if($row[8])
			echo " O:$row[8]";
		if($row[9])
			echo " M:$row[9]";
		echo "\n";
	}

	echo "<tr><td>주소<td>$row[10]\n";
	echo "<tr><td>소개<td>$row[14]\n";
	echo "</table>* 전화번호, 주소는 회원에게만 표시됨<br><br>\n";

	require("./bmfunc_nextimg.php");

	if(nextimg($name) == 0){
		echo "<p align=center style='color:red;'>대회 참가 사진이 없습니다.<br>좋은 사진을 골라 보내 주십시오.\n";
	}

	echo "<br><br><table border=1><tr><th colspan=5>개인 기록</tr>\n";
	echo "<tr><th>대회명";
	if($orderfield == "raceday"){
		echo "<th>날짜\n";
	}else{
		echo "<th><a href='$PHP_SELF?mode=meminfo-one&userid=$userid&orderfield=raceday'>날짜</a>\n";
	}
	if($orderfield == "item"){
		echo "<th>종목\n";
	}else{
		echo "<th><a href='$PHP_SELF?mode=meminfo-one&userid=$userid&orderfield=item'>종목</a>\n";
	}
	if($orderfield == "" or $orderfield == "record"){
		echo "<th>기록\n";
	}else{
		echo "<th><a href='$PHP_SELF?mode=meminfo-one&userid=$userid&orderfield=record'>기록</a>\n";
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
	$dbquery .= " from race,record where record.userid='$userid' and (record.record != '' and record.record is not null) and record.raceid=race.raceid order by ".$orderfield;
	$result = mysql_query($dbquery) or die("mysql_query error");

	if(privcheck($logid) == 2){
		$managerRole = 1;
	}else{
		$managerRole = 0;
	}
	echo "<th>순위</tr>";
	while($row=mysql_fetch_array($result)){
		echo "<tr><td>$row[1] <td>$row[2] <td>$row[3]";
		if($managerRole == 1)
			echo "<td><a href='/bbs/bmrecord.php?mode=record-change&raceid=$row[0]&userid=$userid'>$row[4]";
		else
			echo "<td>$row[4]";
		echo "<td>$row[5]\n";
	}
	echo "</tr></table>";

	mysql_free_result($result);

}else if($mode == "meminfo-addrlist"){
	heading("회원 주소록");

	echo "<table border=1>\n";
	if($orderfield == "" or $orderfield == "name"){
		echo "<th>이름\n";
	}else{
		echo "<th><a href='$PHP_SELF?mode=meminfo-addrlist&orderfield=name'>이름</a>\n";
	}
	if($orderfield == "type"){
		echo "<th>구분\n";
	}else{
		echo "<th><a href='$PHP_SELF?mode=meminfo-addrlist&orderfield=type'>구분</a>\n";
	}
	if($orderfield == "birthday"){
		echo "<th>생년월일\n";
	}else{
		echo "<th><a href='$PHP_SELF?mode=meminfo-addrlist&orderfield=birthday'>생년월일</a>\n";
	}
	echo "<th>직장<th>E-mail 주소<th>집전화<th>직장전화<th>이동전화<th>주소\n";

	if($orderfield == "" or $orderfield == "name"){
		$orderfield = "name";
	}else if($orderfield == "type"){
		$orderfield = "membertype, gumpuno";
	}else if($orderfield == "birthday"){
		$orderfield = "birthdate, juminno, gumpuno";
	}
	$dbquery="select name, nickname, juminno, org, orghref, email, photo,";
	$dbquery.="telhome, teloffice, telhand, postaddr, membertype, grade, ";
	$dbquery.="gumpuno, userid, birthdate, birthtype, birthsun from member where membertype='정회원' or membertype='준회원' order by $orderfield";
	$result = mysql_query($dbquery) or die("mysql_query error");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		echo "<tr><td><a href=$PHP_SELF?mode=meminfo-one&userid=$row[14]>$row[0]</a>";
		echo "<td>$row[11]";
		if($row[11] == "정회원")
			echo "($row[13])";
		echo "<td>";
		if($row[birthdate] == null || $row[birthdate] == ""){
		    if($row[2] && substr($row[2],0,6) != "xxxxxx"){
			$birthdate = substr($row[2], 0, 2);
			$birthdate .= ".";
			$birthdate .= substr($row[2], 2, 2);
			$birthdate .= ".";
			$birthdate .= substr($row[2], 4, 2);
			echo "$birthdate";
		    }
		}else{
			echo "$row[birthdate]";
		    if($row[birthtype] == "1"){ //음력
			echo " (양:$row[birthsun])";
		    }
		}
		echo "<td>$row[3]";
		echo "<td>$row[5]";
		echo "<td>$row[7]";
		echo "<td>$row[8]";
		echo "<td>$row[9]";

		echo "<td>$row[10]\n";
	}

	echo "</table>\n";
	mysql_free_result($result);
}else if($mode == "meminfo-sendmail"){
	heading("회원대상 E-mail 발송");

	$dbquery="select name, email from member where userid='$logid'";
	$result = mysql_query($dbquery) or die("mysql_query error");

	$row=mysql_fetch_array($result);
	$name=$row[0];
	$email=$row[1];
	mysql_free_result($result);

	echo "
<script language='JavaScript'>
offset=4;
function all(start, end)
{
	if(end == 0)
		end = document.select.elements.length-2;
	for(i = start+offset; i < end+offset;i++){
		if( ! document.select.elements[i].checked )
			document.select.elements[i].click()
//alert(document.select.elements[i].value);
	}
}
function none(start,end)
{
	if(end == 0)
		end = document.select.elements.length-2;
	for(i = start+offset; i < end+offset;i++){
		if( document.select.elements[i].checked )
			document.select.elements[i].click()
	}
}
function send()
{
	if( document.select.subject.value == ''){
		alert('제목을 입력하십시오.');
		document.select.subject.focus();
		return;
	}
	if( document.select.cont.value == ''){
		alert('내용을 입력하십시오.');
		document.select.cont.focus();
		return;
	}
	sender = '';
	for(i = offset,j = 0; i < document.select.elements.length-1;i++){
		if( document.select.elements[i].checked
		   && document.select.elements[i].value.length > 0 ){
			if( j == 0)
				sender = document.select.elements[i].value
			else
				sender = sender + ',' + document.select.elements[i].value
			j++;
		}
	}
	if( document.select.elements[3].checked)
		j++;
	if(j == 0){
		alert('수신 대상이 없습니다. 회원중에서 수신대상 회원을 선택하십시오.');
	}else{
		if(confirm('' + j + '명에게 메일을 발송하시겠습니까?'))
			document.select.submit();
	}
}
</script>

<form name=select action='$PHP_SELF' method=POST>\n
<input type=hidden name=mode value='meminfo-sendmail2'>\n
<table><tr><td>제목:<td><input type=text name=subject size=60>\n
<tr><td>내용:<td><textarea wrap=auto name=cont rows=6 cols=60></textarea>\n
<tr><td colspan=2 align=center> <a href='javascript:send()'>우편전송</a>\n
</table>\n

<p>수신 회원 선택(<input type=checkbox name=memselect[] checked value='$name:$email'>본인은 기본으로 선택)<p>\n
* 이메일 주소가 등록된 회원만 나타납니다.(본인 메일 계정은 나타나지 않음)<p>
<table border=1>";

//	$mtarray = array("정회원","준회원","예비회원","휴면회원","OB회원");
	$mtarray = array("정회원","준회원","예비회원");
	$myemailaddr="";
	$fullmember = 0;

for($mtype = 0; $mtype < count($mtarray); $mtype++){

	echo "<tr><td>".$mtarray[$mtype]."</td><td>";
	$dbquery="select name, email, userid, membertype from member where membertype='".$mtarray[$mtype]."' order by name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if(chop($row[1]) == ""){
			$i--;
			continue;
		}
/*
		if($row[2] == $logid){
			$i--;
			$myemailaddr=$row[1];
			continue;
		}else{
			echo "<input type=checkbox name=memselect[] value='$row[0]:$row[1]'>$row[0]　";
		}
*/
		echo "<input type=checkbox name=memselect[] value='$row[0]:$row[1]'>$row[0]　";

		if(strlen($row[0]) == 4) echo "　";
		if($i%5 == 4)
			echo "<br>\n";
	}
	mysql_free_result($result);

	$endno = $i+$fullmember;
	echo "</td><td>\n
<a href='javascript:all($fullmember, $endno)'>전체선택</a>\n
<br>\n
<a href='javascript:none($fullmember, $endno)'>전체취소</a>\n
</td></tr>";
	$fullmember = $endno;
}

	echo "</table>";

	echo "<p align=center><a href='javascript:send()'>우편전송</a>\n";
	echo "<input type=hidden name=myemail value='$myemailaddr'>\n";
	echo "</form>";
}else if($mode == "meminfo-sendmail2"){
	heading("E-mail 발송 처리");

	$dbquery="select name, nickname, email from member where userid='$logid'";
	$result = mysql_query($dbquery) or die("mysql_query error");

	$row=mysql_fetch_array($result);
	mysql_free_result($result);

	$no=0;

/*
	if($row[1] != "")
		$sender="\"$row[0]($row[1])\"<$row[2]>";
	else
		$sender="\"$row[0]\"<$row[2]>";

	$mailcont_file = "/tmp/emailconttmp.dat";
	while($memselect[$no]){

		$receiver = explode(":", $memselect[$no]);
		$fp = fopen($mailcont_file, "w");
		fwrite($fp, "From: $sender\n");
		fwrite($fp, "To: \"$receiver[0]님 귀하\"<$receiver[1]>\n");
		fwrite($fp, "Subject: $subject\n");
		fwrite($fp, "\n");

		fwrite($fp, $cont);
		fwrite($fp, "\n");

		fclose($fp);
		$execret = exec("mail ".$receiver[1]."  < $mailcont_file");

		$no++;
		echo $receiver[0]." ";
		if(($no % 5) == 0){
			echo "<br>\n";
		}
		if(($no % 100) == 0){
//			sleep(5);
		}
	}
	chmod($mailcont_file, 0777);
	unlink($mailcont_file);
*/
	if($row[1] != "")
		$sender="$row[0]($row[1])";
	else
		$sender="$row[0]";
	$senderaddr = $row[2];

	while($memselect[$no]){

		$receiver = explode(":", $memselect[$no]);
//		mailsend($sender, $senderaddr, $receiver[0], $receiver[1], $subject, $cont);
//		echo $senderaddr." ".$sender." ".$receiver[1]." ".$receiver[0];
		$ret=zb_sendmail2(0, $receiver[1], $receiver[0], $senderaddr, $sender, $subject, $cont, $cc="", $bcc="");
echo "ret=$ret ";
		$no++;
		echo $receiver[0]." ";
		if(($no % 5) == 0){
			echo "<br>\n";
		}
		if(($no % 100) == 0){
//			sleep(5);
		}
	}
	echo "<br>$no 명 메일 발송 완료.\n";
}else if($mode == "meminfo-sendmemo"){
	heading("회원대상 쪽지(Memo) 발송");
	echo "<a href='http://www.bundangmarathon.com/bbs/member_memo.php'>쪽지함 관리</a><br><br>\n";

	echo "
<script language='JavaScript'>
offset=4;
function all(start, end)
{
	if(end == 0)
		end = document.select.elements.length-2;
	for(i = start+offset; i < end+offset;i++){
		if( ! document.select.elements[i].checked )
			document.select.elements[i].click()
//alert(document.select.elements[i].value);
	}
}
function none(start,end)
{
	if(end == 0)
		end = document.select.elements.length-2;
	for(i = start+offset; i < end+offset;i++){
		if( document.select.elements[i].checked )
			document.select.elements[i].click()
	}
}
function send()
{
	if( document.select.subject.value == ''){
		alert('제목을 입력하십시오.');
		document.select.subject.focus();
		return;
	}
	if( document.select.memo.value == ''){
		alert('내용을 입력하십시오.');
		document.select.memo.focus();
		return;
	}
	sender = '';
	for(i = offset,j = 0; i < document.select.elements.length-1;i++){
		if( document.select.elements[i].checked
		   && document.select.elements[i].value.length > 0 ){
			if( j == 0)
				sender = document.select.elements[i].value
			else
				sender = sender + ',' + document.select.elements[i].value
			j++;
		}
	}
	if( document.select.elements[3].checked)
		j++;
	if(j == 0){
		alert('수신 대상이 없습니다. 회원중에서 수신대상 회원을 선택하십시오.');
	}else{
		if(confirm('' + j + '명에게 쪽지를 발송하시겠습니까?'))
			document.select.submit();
	}
}
</script>

<form name=select action='$PHP_SELF' method=POST>\n
<input type=hidden name=mode value='meminfo-sendmemo2'>\n
<table><tr><td>제목:<td><input type=text name=subject size=60>\n
<tr><td>내용:<td><textarea wrap=auto name=memo rows=6 cols=60></textarea>\n
<tr><td colspan=2 align=center> <a href='javascript:send()'>쪽지전송</a>\n
</table>\n

<p>수신 회원 선택(<input type=checkbox name=memselect[] checked value='$name:$logid'>본인은 기본으로 선택)<p>\n
<table border=1>";

//	$mtarray = array("정회원","준회원","예비회원","휴면회원","OB회원");
	$mtarray = array("정회원","준회원","예비회원");
	$fullmember = 0;

for($mtype = 0; $mtype < count($mtarray); $mtype++){

	echo "<tr><td>".$mtarray[$mtype]."</td><td>";
	$dbquery="select name, userid, membertype from member where membertype='".$mtarray[$mtype]."' or name like '%??' order by name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	for($i=0; $row=mysql_fetch_array($result); $i++){
		if($row[1] == $logid){
			$i--;
			continue;
		}
		echo "<input type=checkbox name=memselect[] value='$row[0]:$row[1]'>$row[0]　";
		if(strlen($row[0]) == 4) echo "　";
		if($i%5 == 4)
			echo "<br>\n";
	}
	if($mtype==0){
		echo "<br>\n";
		echo "<input type=checkbox name=memselect[] value='Samuguk:bmcsamu'>Samuguk　";
		echo "<input type=checkbox name=memselect[] value='TrainingTeam:bmctraining'>TrainingTeam　";
		echo "<input type=checkbox name=memselect[] value='MediaTeam:bmcmedia'>MediaTeam　";
		echo "<input type=checkbox name=memselect[] value='ChongmuTeam:bmcchongmu'>ChongmuTeam　";
	}
	mysql_free_result($result);

	$endno = $i+$fullmember;
	echo "</td><td>\n
<a href='javascript:all($fullmember, $endno)'>전체선택</a>\n
<br>\n
<a href='javascript:none($fullmember, $endno)'>전체취소</a>\n
</td></tr>";
	$fullmember = $endno;
}

	echo "</table>";

	echo "<p align=center><a href='javascript:send()'>쪽지전송</a>\n";
	echo "</form>";

}else if($mode == "meminfo-sendmemo2"){
	heading("쪽지 발송 처리");

	$dbquery="select name, no from $member_table where user_id='$logid'";
	$result = mysql_query($dbquery) or die("mysql_query error");

	$row=mysql_fetch_array($result);
	mysql_free_result($result);
	$member_from = $row[1];
	$no=0;

	$reg_date=time();
	while($memselect[$no]){
		$receiver = explode(":", $memselect[$no]);	// name; user_id
		db_memo_send($get_memo_table, $send_memo_table, $member_table, $member_from, $receiver[1], $subject, $memo, $reg_date);
		$no++;
		echo $receiver[0]." ";
		if(($no % 5) == 0){
			echo "<br>\n";
		}
		if(($no % 100) == 0){
//			sleep(5);
		}
	}
	echo "<br>$no 명 쪽지 발송 완료.\n";
}else if($mode == "meminfo-slide"){
	heading("회원 사진 슬라이드로 보기");
	echo "
회원님들의 얼굴과  이름을 익히기 위한 것입니다.<br>사진에 커서를 올리면 화면 아래에 이름이 나옵니다.
<p align=center>
<applet archive='/member/prog/mosaic/mosaic.jar' code='mosaic.class' width=150 height=200>
<param name=credits value='Applet by Fabio Ciucci (www.anfyteam.com)'>
<param name=regcode value='NO'>
<param name=regnewframe value='NO'>
<param name=regframename value='_blank'>
<param name=res value='1'>\n";

	$dbquery="select name, grade, gumpuno, photo, membertype from member where (membertype='정회원' or membertype='준회원') and photo!='' order by membertype,gumpuno,name";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$rows = mysql_num_rows($result);
	if($startno == "")
		$startno = 1;

	$i = $rows - $startno + 2;
	for($no=1; $row=mysql_fetch_array($result) && ($i < 5); $no++){
		if($i > $rows)
			$i = $i - $rows;
		if(!file_exists("$path2photo/$row[3]")){
			$no--;
			continue;
		}
		$photosize = GetImageSize ("$path2photo/$row[3]");
		if($photosize[0] != 150 || $photosize[1] != 200){
			$errorname .= $row[0]." ";
			$no--;
			continue;
		}
		$memstr="$row[4]";
		if($row[1] != '')
			$memstr .= ",$row[1]";
		if($row[4] == "정회원")
			$memstr.=",회원번호:$row[2]";
		echo "<param name=image$i value=\"$path2photo/$row[3]\">
<param name=link$i value=\"NO\">
<param name=statusmsg$i value=\"$no. $row[0]($memstr)\">\n";
		$i++;
	}

	echo "<param name=pause value='1500'>
<param name=tileswidth value=15>
<param name=tilesheight value=4>
<param name=tilesteps value=24>
<param name=backimage value='NO'>
<param name=backr value='112'>
<param name=backg value='128'>
<param name=backb value='160'>
<param name=overimg value='NO'>
<param name=overimgX value='0'>
<param name=overimgY value='0'>
<param name=memdelay value='1000'>
<param name=priority value='3'>
<param name=MinSYNC value='10'>
Sorry, your browser doesn't support Java.
</applet>";

	echo "<br><br>사진 크기(150x200) 이상자 : ";
	if($errorname == '')
		echo "없음";
	else
		echo $errorname;
	echo "<p><form method='POST' action=$PHP_SELF>
<input type=hidden name=mode value='meminfo-slide'>\n
<input type=text name=startno size=4 maxlength=3>번째 사진부터
<input type=submit value='다시 보기'>
</form>";
}else if($mode == "submenu"){
	heading("클럽 정보 메뉴");
	echo "
	<a href='bmmeminfo.php?mode=meminfo-brief'>회원정보보기</a><br>
	<a href='bmmeminfo.php?mode=meminfo-slide'>사진연속보기</a><br>
	<a href='bmmeminfo.php?mode=meminfo-addrlist'>회원주소록</a><br>
	<a href='bmmeminfo.php?mode=meminfo-sendmemo'>쪽지발송</a><br>
	<a href='bmbook.php'>현금출납부</a><br>
	<a href='bmtraining.php'>정모출석부</a><br>
	<a href='bmmem.php?mode=chuka'>축하합니다</a>";
}

?>
</center>
</body>
</html>
