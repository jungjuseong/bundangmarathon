<?php
require("./config.php");
require("./function.php");

$memmanmailaddr = $managerEmail;

if($mode == ""){
	logonform(1);
	exit();
}
if($mode == "logon"){
	if (!(isset( $PHP_AUTH_USER ) && isset($PHP_AUTH_PW))) { 
		logon();
	}
	$userid=$PHP_AUTH_USER;
	$passwd=$PHP_AUTH_PW;
	if($userid == "" || $passwd == ""){
		logon();
	}
        $dbquery="select userid,passwd,name,membertype from member";
        $result = mysql_query($dbquery);      
	$idmatch=0;
	while($row=mysql_fetch_array($result)){
		if($row[0] == $userid){
			if($row[3] == "예비회원"){
/*
				top("");
				heading("회원광장 사용 불가");
				echo "예비회원은 사용이 불가능합니다.<p>";
*/
				logon();
				exit();
			}
			mysql_free_result($result);
			if($row[1] == $passwd){
			}else if($row[1] == ""){
				$dbquery="update member set passwd='$passwd' where userid='$userid'";

				$result = mysql_db_query("coretek",$dbquery);
			}else{
				logon();
			}
			$idmatch=1;
			break;
		}
	}
	mysql_close() or die("mysql_close error");
	if($idmatch == 0){
		logon();
	}else{
		header("Content-Type: text/html");
//echo "userid=$userid";
		$logid=$userid;
		framehome();
		exit();
	}
}else if($mode == "logoff"){
//	if (!(isset( $PHP_AUTH_USER ) && isset($PHP_AUTH_PW))) { 
//		logon();
//	}
	logon();
}else if($mode == "passwdsend"){
		header("Content-Type: text/html");
		top("onLoad=\"setFocus()\"");
		heading("ID, Password 문의");
	$dbquery="select userid, passwd, email from member where name='$name'";
	$result = mysql_query($dbquery) or die("mysql_query error");

	$no=0;
	if($row=mysql_fetch_array($result)){
		if($row[2] == ""){
			echo "<br>E-Mail 주소가 등록되어 있지 않습니다.\n";
		}else{
			$cont = "귀하가 사용하시는 ID와 Password는 다음과 같습니다.\n";
			$cont .= "ID : $row[0]\n";
			$cont .= "Password : $row[1]\n";
//			mailsend("회원광장관리자", $memmanmailaddr, $name, $row[2], "회원광장 회원 계정 문의", $cont);

			zb_sendmail2(0, $row[2], $name, $memmanmailaddr, "회원광장관리자", "회원광장 회원 계정 문의", $cont, $cc="", $bcc="");
			echo "<br>문의하신 ID, Password를 '$row[2]'(으)로 E-Mail 발송 완료.\n";
		}
	}else{
		echo "'$name' 님은 등록된 회원이 아닙니다.\n";
		echo "<p>문의하실 일이 있으면 $memmanmailaddr 으로 연락 주십시오.\n";
	}
	mysql_free_result($result);
	mysql_close() or die("mysql_close error");

}else {
//echo "mode=$mode";

//    require("./auth.php");

    $logid=$PHP_AUTH_USER;

    if($mode == "submenu"){
	top("");
	heading("메뉴 선택 오류");
	echo "서브 메뉴를 선택하십시오.";
    }else if($mode == "frame"){
	framehome();
	exit();
    }else if($mode == "framecont"){
	top("");
	heading("회원광장 홈");
	framecont();
    }else if($mode == "framemenu"){
	include("menu.php");
/*
    }else if($mode == "hanmir"){
	top("onLoad=\"document.authform.submit();\"");
	heading("한미르회원광장");
	hanmirconnect();
	echo "한미르회원광장 접속은 본인정보에서 입력한 ID와 Password를 사용합니다.";
	echo "<br>바로 로그인이 되지 않으면 본인정보에서 한미르ID와 한미르Password를 수정하시기 바랍니다.";
	echo "<br><br>";
	echo "처음에는 <a href='http://club.hanmir.com/ClubHome.php?clubid=gumpu' target=hanmir>한미르회원광장</a>에서
	'가입/탈퇴' 버튼을 이용해 회원가입 신청하고<br>관리자가 가입승인을 해야 사용 가능합니다.";
	echo "<br> (한미르 회원이 아니면 한미르 회원 가입부터 해야 함)";
*/
    }else{
	top("");
	heading("해당 기능이 없습니다.");
	exit;
    }
}

function hanmirconnect(){
	global $logid;

	$dbquery="select hanmirid,hanmirpwd,name from member where userid='$logid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	if($row=mysql_fetch_array($result)){
		$userid = $row[0];
		$passwd = $row[1];
		$name = $row[2];
	}
	echo "
		<form name=authform action='http://auth.hanmir.com/login.php?url=".urlencode("http://club.hanmir.com/ClubHome.php?clubid=gumpu")."' method=post target=hanmir>
		<input type=hidden name=loginid value='$userid'>
		<input type=hidden name=passwd value='$passwd'>
		</form>
	";
}

function framecont(){
	global $logid;

	echo "<table><tr><td width='20%' valign=top>\n";
	$dbquery="select name, photo, juminno, email, org, telhome, teloffice, telhand from member where userid='$logid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	if($row=mysql_fetch_array($result)){
		$name = $row[0];
		$photo = $row[1];
		$juminno = $row[2];
		if(substr($juminno,0,6) == "xxxxxx" || substr($juminno,7,7) == "yyyyyyy"){
			$juminno = "";
		}
		$email = $row[3];
		$org = $row[4];
		if($row[5] == "" && $row[6] == "" && $row[7] == ""){
			$tel = "";
		}else{
			$tel = $row[5]." ".$row[6]." ".$row[7];
		}
		echo "<p align=center><font style='font:bold;'>$name</font>\n";
		if($photo != ""){
			if(is_file("../photo/$photo"))
				echo "<p align=center><img src='../photo/$photo' border=0>\n";
			else
				echo "<p align=center style='color:red;'>사진 파일이 없습니다.\n";
		}else{
			echo "<p align=center style='color:red;'>사진 파일이 DB에 등록되어 있지 않습니다.\n";
		}
	}
	mysql_free_result($result);

	echo "<p><font style='font:bold;'>참가신청</font>\n";
	$dbquery = "select raceid, nickname, raceday from race";
//	$dbquery .= " where inviting='Y' or userid='$logid' and replace(raceday, '/', '-') >= current_date order by raceday";
	$dbquery .= " where inviting='Y' order by raceday";
//echo "dbquery=$dbquery";
	$result = mysql_query($dbquery) or die("mysql_query error");
	echo "<font style='font-size:10pt'>\n";
	while($row=mysql_fetch_array($result)){
		$dbquery = "select userid from record where raceid=$row[0] and userid='$logid'";
		$result2 = mysql_query($dbquery) or die("mysql_query2 error");
		$rows = mysql_num_rows($result2);
		if($rows == 0){
			$ymd=substr($row[2], 5);
			$race=substr(strstr($row[1], " "), 1);
			echo "<br><a href='inviting.php?mode=inviting-input2&raceid=$row[0]'>$race($ymd)</a>\n";
		}
	}
	echo "</font>\n";
	mysql_free_result($result);

	echo "<p><font style='font:bold;'>대회 D-day</font>\n";
/* 분당 대회 D-day 표시 부분
	$raceday = mktime(0,0,0,5,5,2002);
	$today = mktime (0,0,0,date("m"),date("d"),date("Y"));
//echo "raceday=$raceday, today=$today";
	$days = (date("U", $raceday) - date("U", $today))/(60*60*24);
//echo "dayes=$days";
	echo "<font style='font-size:10pt'>\n";
	echo "<br><font color=red>분당 : D-$days</font>";
*/
	$dbquery = "select race.nickname, race.raceday, to_days(race.raceday)-to_days(now())";
	$dbquery .= " from record,race where record.userid='$logid'";
	$dbquery .= " and record.raceid=race.raceid";
	$dbquery .= " and race.raceday >= replace(substring(now(),1,10),'-','/')";
	$dbquery .= " order by race.raceday";

//echo $dbquery;
	$result = mysql_query($dbquery) or die("mysql_query error");
	while($row=mysql_fetch_array($result)){
		$race=substr(strstr($row[0], " "), 1);
		echo "<br> $race : D-$row[2]";
	}
	mysql_free_result($result);
	echo "</font>\n";

	echo "<p><font style='font:bold;'>일정 표시</font>\n";
	$month = date("m");
	if(substr($month,0,1) == "0")
		$month = substr($month, 1, 1);
	echo "<p><font style='font:bold;'>".$month.".".date("d")." ".date("H").":".date("i")."</font>\n";
	echo "</td><td valign=top align=center width=380>";

	require("./func_nextimg.php");

	if(nextimg($name) == 0){
		echo "<p align=center style='color:red;'>대회 참가 사진이 없습니다.<br>좋은 사진을 골라 보내 주십시오.\n";
	}

	echo "</td><td valign=top>\n";
	echo "<font color=red>";
	if($juminno == "") {echo "주민번호 : 없음<br>"; $req="yes";}
	if($email == "") {echo "E-mail주소 : 없음<br>"; $req="yes";}
	if($org == "") {echo "직장 : 없음<br>"; $req="yes";}
	if($tel == "") {echo "전화번호 : 없음<br>"; $req="yes";}
	if($req == "yes"){
		echo "<a href='/member/prog/mem.php?mode=member-change'>본인정보수정</a><br><br>";
	}
	echo "</font>";
	echo "<a href='/member/prog/record.php?mode=record-input'>본인기록등록</a>";
	$dbquery = "select race.nickname, record.record from record, race where record.userid='$logid'";
	$dbquery .= " and record.raceid=race.raceid";
	$dbquery .= " and substring(race.raceday,1,4) = substring(now(),1,4)";
	$dbquery .= " and race.raceday <= replace(substring(now(),1,10), '-', '/')";
	$dbquery .= " order by race.raceday desc";

//echo $dbquery;
	$result = mysql_query($dbquery) or die("mysql_query error");
	while($row=mysql_fetch_array($result)){
		$race=substr(strstr($row[0], " "), 1);
		echo "<br> $row[0] $row[1]";
	}
	mysql_free_result($result);

	echo "<p><font style='font:bold;'>회원 변동(한달간)</font><br>\n";
	$dbquery = "select name,indate,userid,membertype";
	$dbquery .= ", IF( membertype='정회원', 1, IF( membertype='준회원', 2, IF( membertype='예비회원', 3, IF( membertype='휴면회원', 4, IF( membertype='OB회원', 5, 6))))) as typeorder";
	$dbquery .= " from member where (to_days(now())-to_days(indate))<=30 order by typeorder, indate desc";

//echo $dbquery;
	$result = mysql_query($dbquery) or die("mysql_query error");

	$memtype = array(0, 0, 0, 0, 0, 0);
	$memtypename = array("", "정회원", "준회원", "예비회원", "휴면회원", "OB회원", "기타");
	while($row=mysql_fetch_array($result)){
		if($memtype[$row[4]] == 0){
			$memtype[$row[4]] = 1;
		echo "<font style='font:bold;'>".$memtypename[$row[4]]."</font><br>\n";
		}	
	
		echo "<a href='meminfo.php?mode=meminfo-one&userid=$row[2]'>$row[0]($row[1])</a><br>\n";
	}
	mysql_free_result($result);
	echo "</td></tr></table>\n";


	echo "<br><hr color=red width='80%'><br>회원광장 문의는 <a href='mailto:$memmanmailaddr'>여기로</a>";
}

function connectstatus($userid){
	$dbquery="select name from member where userid='$userid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	if($row=mysql_fetch_array($result)){
		echo $row[0]."님이시군요.<p>";
	}else{
		die($userid."는 없는 ID입니다.");
	}
}

function logonform($type){
	global $PHP_SELF;

	if($type !=0)
		top("");
	heading("탄천검푸 회원광장");
	echo "
<form name=logform method=post action='$PHP_SELF'>
<input type=hidden name=mode value=logon>
<table> <tr> <td>
  <input type=submit value=' 회원광장 입장 '>
</td> </tr> </table>
</form>
<br>
<!--
시스템 이상으로 ID/패스워드 문의기능 잠정 중단합니다.
<br>
ID/Password를 모르시는 분은 san2run@hanmir.com으로 메일 보내 주십시오.
-->
<form name=logform2 method=post action='$PHP_SELF'>
<input type=hidden name=mode value=passwdsend>
<table> <tr>
    <td>ID, password 문의:</td>
    <td><input type=text name=name value='본인 이름 입력' size=15 onClick=\"this.value=''\"><br></td>
    <td><input type=submit value='문의'></td>
</tr>
<tr><td colspan=3>* ID, Password는 지정하신 E-Mail 주소로 보내집니다.</td>
</tr></table>
</form>
<!--
-->

<br>
<table border=0><tr><td>
<p>
<font size='+1'><a href='/bbs/member_join.php?id=memboard' target=bbs>** 회원 가입 신청 **</a></font>
<br>
</td><tr>
</table>

<script language=JavaScript>
function setFocus(){
	document.logform.userid.focus();
	return true;
}
</script>
";
}

function logon(){
    header( 'WWW-Authenticate: Basic realm="탄천검푸(정회원,준회원용)		*예비회원은 사용할 수 없습니다.		*사용자 이름에 사용자 ID를 사용하십시오."' );
    header( 'HTTP/1.0 401 Unauthorized' );
    logonform(1);
//    echo 'Authorization Required.';
    exit;
}

function framehome(){
	global $PHP_SELF;
	echo "
<html>
<head>
<title>분당 탄천검푸 마라톤클럽 회원광장</title>
</head>
<frameset rows='40, *, 40' border='0' frameborder='NO' framespacing='0'>
    <frame src='$PHP_SELF?mode=framemenu' name='framemenu' noresize scrolling='no' marginwidth='10' marginheight='0' scrollbar='no' frameborder='NO'>
    <frame src='$PHP_SELF?mode=framecont' name='framecont' noresize scrolling='auto' marginwidth='10' marginheight='10' scrollbar='no' frameborder='NO'>
    <frame src='race.php?mode=race-framelist' name='framerace' noresize scrolling='auto' marginwidth='10' marginheight='10' scrollbar='no' frameborder='NO'>
</frameset>
<noframes>
  <body bgcolor='white' text='black' link='blue' vlink='purple' alink='red'>
    <p>이 페이지를 보려면, 프레임을 볼 수 있는 브라우저가 필요합니다.</p>
  </body>
</noframes>
</html>
";
}
?>
</center>
</body>
</html>
