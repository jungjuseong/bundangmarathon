<HTML>
<HEAD>
<TITLE> ��ǥ �� ��ǥ ���</TITLE>
</HEAD>
<body bgcolor="#E0FFE0" text="black" link="blue" vlink="purple" alink="red">
<br>
<center>

<H2>��ǥ �� ��ǥ ���</H2>
<hr color=red width="90%">
<P>
<?php
$comdir = "../";
require($comdir."auth.php");
require($comdir."config.php");
require($comdir."function.php");

	$dbquery="select name, grade from member where userid='$logid' and membertype='��ȸ��'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	if( mysql_numrows( $result ) == 1){
		$qualify = "Y";
	}else{
		$qualify = "N";
	}
	mysql_free_result($result);

	echo "���� ���� �ð��� ".date("Y.m.d H:i:s")."�Դϴ�.<p>";
	$pollname = "2003 ��ȸ �Ȱ� ��ǥ";

	$starttime = mktime(9,0,0,12,1,2003);
	$stoptime = mktime(23,59,59,12,3,2003);
	$currenttime = mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));

	if($currenttime < $starttime){
		echo "<font size='+2'>* ".$pollname."�� ".date ("Y.m.d H:i:s", $stoptime)."���� �����մϴ�.</font>";
	}else if($currenttime > $starttime && $currenttime < $stoptime){
		echo "<img src='/new.gif'>";
		echo "<a href='2003-3.html'>".$pollname."</a>";
		echo "<br>(��ǥ����ð� : ".date ("Y.m.d H:i:s", $stoptime).")";
		echo "<p>";
	}
	if(privcheck($logid) == 2 || $currenttime > $stoptime){
		echo "<img src='/new.gif'>";
	    if($currenttime > $stoptime){
		echo "<a href='2003-3-result.html'>".$pollname." ���</a><p>";
	    }else{
		echo "<a href='2003-3-result.html'>".$pollname." ���(��������)</a><p>";
	    }
	}

?>

<P>
<!--
-->
	<a href='2003-2.php?pollid=2003-2'>2003 �ӿ� ���� �ĺ� ��õ ���</a><p>
	<a href='2003-1.php?pollid=2003-1'>ȸ�� ����� ��ǥ ���</a><p>
	<a href='2002-4.php?pollid=2002-4'>2002 ���� ��ȸ �Ȱ� ��ǥ ���</a><p>
	<a href='2002-3.php?pollid=2002-3'>2002 ��ȹ���� ���� ���� ���</a><p>
	<a href='2002-2.php?pollid=2002-2'>2002 ��ȸ �Ȱ� 2�� ��ǥ ���</a><p>
	<a href='2002-1.php?pollid=2002-1'>2002 ��ȸ �Ȱ� ��ǥ ���</a><p>
	<a href='2001-2.html'>������ ���� �ǰ� ����(2001)</a><p>
	<a href='2001-1.html'>2001 ��ȸ �Ȱ� ��ǥ</a><p>
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
        <td align="center"><p>Copyright �� by źõ��Ǫ������Ŭ��. All rights reserved. </td>
    </tr>
</table>
</body>
</html>
