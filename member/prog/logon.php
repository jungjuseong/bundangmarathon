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
			if($row[3] == "����ȸ��"){
/*
				top("");
				heading("ȸ������ ��� �Ұ�");
				echo "����ȸ���� ����� �Ұ����մϴ�.<p>";
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
		heading("ID, Password ����");
	$dbquery="select userid, passwd, email from member where name='$name'";
	$result = mysql_query($dbquery) or die("mysql_query error");

	$no=0;
	if($row=mysql_fetch_array($result)){
		if($row[2] == ""){
			echo "<br>E-Mail �ּҰ� ��ϵǾ� ���� �ʽ��ϴ�.\n";
		}else{
			$cont = "���ϰ� ����Ͻô� ID�� Password�� ������ �����ϴ�.\n";
			$cont .= "ID : $row[0]\n";
			$cont .= "Password : $row[1]\n";
//			mailsend("ȸ�����������", $memmanmailaddr, $name, $row[2], "ȸ������ ȸ�� ���� ����", $cont);

			zb_sendmail2(0, $row[2], $name, $memmanmailaddr, "ȸ�����������", "ȸ������ ȸ�� ���� ����", $cont, $cc="", $bcc="");
			echo "<br>�����Ͻ� ID, Password�� '$row[2]'(��)�� E-Mail �߼� �Ϸ�.\n";
		}
	}else{
		echo "'$name' ���� ��ϵ� ȸ���� �ƴմϴ�.\n";
		echo "<p>�����Ͻ� ���� ������ $memmanmailaddr ���� ���� �ֽʽÿ�.\n";
	}
	mysql_free_result($result);
	mysql_close() or die("mysql_close error");

}else {
//echo "mode=$mode";

//    require("./auth.php");

    $logid=$PHP_AUTH_USER;

    if($mode == "submenu"){
	top("");
	heading("�޴� ���� ����");
	echo "���� �޴��� �����Ͻʽÿ�.";
    }else if($mode == "frame"){
	framehome();
	exit();
    }else if($mode == "framecont"){
	top("");
	heading("ȸ������ Ȩ");
	framecont();
    }else if($mode == "framemenu"){
	include("menu.php");
/*
    }else if($mode == "hanmir"){
	top("onLoad=\"document.authform.submit();\"");
	heading("�ѹ̸�ȸ������");
	hanmirconnect();
	echo "�ѹ̸�ȸ������ ������ ������������ �Է��� ID�� Password�� ����մϴ�.";
	echo "<br>�ٷ� �α����� ���� ������ ������������ �ѹ̸�ID�� �ѹ̸�Password�� �����Ͻñ� �ٶ��ϴ�.";
	echo "<br><br>";
	echo "ó������ <a href='http://club.hanmir.com/ClubHome.php?clubid=gumpu' target=hanmir>�ѹ̸�ȸ������</a>����
	'����/Ż��' ��ư�� �̿��� ȸ������ ��û�ϰ�<br>�����ڰ� ���Խ����� �ؾ� ��� �����մϴ�.";
	echo "<br> (�ѹ̸� ȸ���� �ƴϸ� �ѹ̸� ȸ�� ���Ժ��� �ؾ� ��)";
*/
    }else{
	top("");
	heading("�ش� ����� �����ϴ�.");
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
				echo "<p align=center style='color:red;'>���� ������ �����ϴ�.\n";
		}else{
			echo "<p align=center style='color:red;'>���� ������ DB�� ��ϵǾ� ���� �ʽ��ϴ�.\n";
		}
	}
	mysql_free_result($result);

	echo "<p><font style='font:bold;'>������û</font>\n";
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

	echo "<p><font style='font:bold;'>��ȸ D-day</font>\n";
/* �д� ��ȸ D-day ǥ�� �κ�
	$raceday = mktime(0,0,0,5,5,2002);
	$today = mktime (0,0,0,date("m"),date("d"),date("Y"));
//echo "raceday=$raceday, today=$today";
	$days = (date("U", $raceday) - date("U", $today))/(60*60*24);
//echo "dayes=$days";
	echo "<font style='font-size:10pt'>\n";
	echo "<br><font color=red>�д� : D-$days</font>";
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

	echo "<p><font style='font:bold;'>���� ǥ��</font>\n";
	$month = date("m");
	if(substr($month,0,1) == "0")
		$month = substr($month, 1, 1);
	echo "<p><font style='font:bold;'>".$month.".".date("d")." ".date("H").":".date("i")."</font>\n";
	echo "</td><td valign=top align=center width=380>";

	require("./func_nextimg.php");

	if(nextimg($name) == 0){
		echo "<p align=center style='color:red;'>��ȸ ���� ������ �����ϴ�.<br>���� ������ ��� ���� �ֽʽÿ�.\n";
	}

	echo "</td><td valign=top>\n";
	echo "<font color=red>";
	if($juminno == "") {echo "�ֹι�ȣ : ����<br>"; $req="yes";}
	if($email == "") {echo "E-mail�ּ� : ����<br>"; $req="yes";}
	if($org == "") {echo "���� : ����<br>"; $req="yes";}
	if($tel == "") {echo "��ȭ��ȣ : ����<br>"; $req="yes";}
	if($req == "yes"){
		echo "<a href='/member/prog/mem.php?mode=member-change'>������������</a><br><br>";
	}
	echo "</font>";
	echo "<a href='/member/prog/record.php?mode=record-input'>���α�ϵ��</a>";
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

	echo "<p><font style='font:bold;'>ȸ�� ����(�Ѵް�)</font><br>\n";
	$dbquery = "select name,indate,userid,membertype";
	$dbquery .= ", IF( membertype='��ȸ��', 1, IF( membertype='��ȸ��', 2, IF( membertype='����ȸ��', 3, IF( membertype='�޸�ȸ��', 4, IF( membertype='OBȸ��', 5, 6))))) as typeorder";
	$dbquery .= " from member where (to_days(now())-to_days(indate))<=30 order by typeorder, indate desc";

//echo $dbquery;
	$result = mysql_query($dbquery) or die("mysql_query error");

	$memtype = array(0, 0, 0, 0, 0, 0);
	$memtypename = array("", "��ȸ��", "��ȸ��", "����ȸ��", "�޸�ȸ��", "OBȸ��", "��Ÿ");
	while($row=mysql_fetch_array($result)){
		if($memtype[$row[4]] == 0){
			$memtype[$row[4]] = 1;
		echo "<font style='font:bold;'>".$memtypename[$row[4]]."</font><br>\n";
		}	
	
		echo "<a href='meminfo.php?mode=meminfo-one&userid=$row[2]'>$row[0]($row[1])</a><br>\n";
	}
	mysql_free_result($result);
	echo "</td></tr></table>\n";


	echo "<br><hr color=red width='80%'><br>ȸ������ ���Ǵ� <a href='mailto:$memmanmailaddr'>�����</a>";
}

function connectstatus($userid){
	$dbquery="select name from member where userid='$userid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	if($row=mysql_fetch_array($result)){
		echo $row[0]."���̽ñ���.<p>";
	}else{
		die($userid."�� ���� ID�Դϴ�.");
	}
}

function logonform($type){
	global $PHP_SELF;

	if($type !=0)
		top("");
	heading("źõ��Ǫ ȸ������");
	echo "
<form name=logform method=post action='$PHP_SELF'>
<input type=hidden name=mode value=logon>
<table> <tr> <td>
  <input type=submit value=' ȸ������ ���� '>
</td> </tr> </table>
</form>
<br>
<!--
�ý��� �̻����� ID/�н����� ���Ǳ�� ���� �ߴ��մϴ�.
<br>
ID/Password�� �𸣽ô� ���� san2run@hanmir.com���� ���� ���� �ֽʽÿ�.
-->
<form name=logform2 method=post action='$PHP_SELF'>
<input type=hidden name=mode value=passwdsend>
<table> <tr>
    <td>ID, password ����:</td>
    <td><input type=text name=name value='���� �̸� �Է�' size=15 onClick=\"this.value=''\"><br></td>
    <td><input type=submit value='����'></td>
</tr>
<tr><td colspan=3>* ID, Password�� �����Ͻ� E-Mail �ּҷ� �������ϴ�.</td>
</tr></table>
</form>
<!--
-->

<br>
<table border=0><tr><td>
<p>
<font size='+1'><a href='/bbs/member_join.php?id=memboard' target=bbs>** ȸ�� ���� ��û **</a></font>
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
    header( 'WWW-Authenticate: Basic realm="źõ��Ǫ(��ȸ��,��ȸ����)		*����ȸ���� ����� �� �����ϴ�.		*����� �̸��� ����� ID�� ����Ͻʽÿ�."' );
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
<title>�д� źõ��Ǫ ������Ŭ�� ȸ������</title>
</head>
<frameset rows='40, *, 40' border='0' frameborder='NO' framespacing='0'>
    <frame src='$PHP_SELF?mode=framemenu' name='framemenu' noresize scrolling='no' marginwidth='10' marginheight='0' scrollbar='no' frameborder='NO'>
    <frame src='$PHP_SELF?mode=framecont' name='framecont' noresize scrolling='auto' marginwidth='10' marginheight='10' scrollbar='no' frameborder='NO'>
    <frame src='race.php?mode=race-framelist' name='framerace' noresize scrolling='auto' marginwidth='10' marginheight='10' scrollbar='no' frameborder='NO'>
</frameset>
<noframes>
  <body bgcolor='white' text='black' link='blue' vlink='purple' alink='red'>
    <p>�� �������� ������, �������� �� �� �ִ� �������� �ʿ��մϴ�.</p>
  </body>
</noframes>
</html>
";
}
?>
</center>
</body>
</html>
