<HTML>
<HEAD>
<TITLE> 투표 및 투표 결과</TITLE>
</HEAD>
<body bgcolor="#E0FFE0" text="black" link="blue" vlink="purple" alink="red">
<br>
<center>

<H2>투표 및 투표 결과</H2>
<hr color=red width="90%">
<P>
<?php
$comdir = "../";
require($comdir."auth.php");
require($comdir."config.php");
require($comdir."function.php");

	$dbquery="select name, grade from member where userid='$logid' and membertype='정회원'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	if( mysql_numrows( $result ) == 1){
		$qualify = "Y";
	}else{
		$qualify = "N";
	}
	mysql_free_result($result);

	echo "현재 서버 시간은 ".date("Y.m.d H:i:s")."입니다.<p>";
	$pollname = "2003 총회 안건 투표";

	$starttime = mktime(9,0,0,12,1,2003);
	$stoptime = mktime(23,59,59,12,3,2003);
	$currenttime = mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));

	if($currenttime < $starttime){
		echo "<font size='+2'>* ".$pollname."는 ".date ("Y.m.d H:i:s", $stoptime)."부터 시작합니다.</font>";
	}else if($currenttime > $starttime && $currenttime < $stoptime){
		echo "<img src='/new.gif'>";
		echo "<a href='2003-3.html'>".$pollname."</a>";
		echo "<br>(투표종료시간 : ".date ("Y.m.d H:i:s", $stoptime).")";
		echo "<p>";
	}
	if(privcheck($logid) == 2 || $currenttime > $stoptime){
		echo "<img src='/new.gif'>";
	    if($currenttime > $stoptime){
		echo "<a href='2003-3-result.html'>".$pollname." 결과</a><p>";
	    }else{
		echo "<a href='2003-3-result.html'>".$pollname." 결과(관리자한)</a><p>";
	    }
	}

?>

<P>
<!--
-->
	<a href='2003-2.php?pollid=2003-2'>2003 임원 선거 후보 추천 결과</a><p>
	<a href='2003-1.php?pollid=2003-1'>회장 재신임 투표 결과</a><p>
	<a href='2002-4.php?pollid=2002-4'>2002 연말 총회 안건 투표 결과</a><p>
	<a href='2002-3.php?pollid=2002-3'>2002 기획팀장 보궐 선거 결과</a><p>
	<a href='2002-2.php?pollid=2002-2'>2002 총회 안건 2차 투표 결과</a><p>
	<a href='2002-1.php?pollid=2002-1'>2002 총회 안건 투표 결과</a><p>
	<a href='2001-2.html'>유니폼 관련 의견 수렴(2001)</a><p>
	<a href='2001-1.html'>2001 총회 안건 투표</a><p>
</center>

<br>
<table align=center width="90%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td height="11" background="/images/main_caption.gif"></td>
    </tr>
    <tr>
        <td height="5"></td>
    </tr>
    <tr>
        <td align="center"><p>Copyright ⓒ by 탄천검푸마라톤클럽. All rights reserved. </td>
    </tr>
</table>
</body>
</html>
