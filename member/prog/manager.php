<?php

require("./auth.php");
require("./config.php");
require("./function.php");

top("");
if(privcheck($logid) != 2){
	heading("관리자 기능");
	die("관리자만 사용 가능한 기능입니다.");
}

if($mode == "menu"){
	echo "<a href='mem.php?mode=member-input'>회원등록</a>\n";
	echo "<p><a href='mem.php?mode=member-select'>회원정보수정</a>\n";
	echo "<p><a href='$PHP_SELF?mode=mailinglist-input'>Maillig-List 메일 발송</a>\n";
	echo "<p><a href='mailinglist.php'>Maillig-List 추가/삭제</a>\n";
	echo "<p><a href='/race/2002/prog/reg_admin2.php?mode=logon&uid=bundang0505'>대회 접수 관리자 메뉴</a>\n";
	echo "<p><a href='mem.php?mode=photo-upload-set&type=manager'>얼굴 사진 업로드</a>\n";
	echo "<p><a href='rec-in.php'>기록 Batch 등록(개인별)</a>\n";
	echo "<p><a href='recordinput.php'>기록 Batch 등록(대회별)</a>\n";
	echo "<p><a href='training.php'>정모참석부(개발중)</a>\n";
}else if($mode == "mailinglist-input"){
	emailcont();
}else if($mode == "mailinglist-send"){

	heading("Mailing-List 메일 발송");

	ob_start();

	if($subject == "" || $cont == ""){
		echo "제목과 내용을 입력해 주십시오";
		die("");
	}

	$dbquery="select name,email from mailinglist ";
	if($emailaccount != '') 
		$dbquery .= "where email > '$emailaccount' ";
	$dbquery .= "order by email";
	$dbquery="select name,email from mailinglist order by email";
//	$dbquery="select bibno,name,email,juminno,org,record,postno,postaddr from reg2001 where email!='' and record is not null order by bibno";
//	$dbquery="select bibno, name, email, juminno, org,record ,postno,postaddr from reg2001 where name='김영헌' and record is not null order by bibno";

	$result = mysql_query($dbquery) or die("mysql_query error");

	$mailcont_file = "./email/emailcont.dat";
	$mailaccount_file = "./email/emailaccount-sended.dat";
	$fpsended = fopen($mailaccount_file, "w");
	$no=0;
	while($row=mysql_fetch_array($result)){
//		if($row[0] == "나석주")
//			continue;
		$fp = fopen($mailcont_file, "w");
		fwrite($fp, "From: \"분당마라톤대회 운영자\"<gumpu@gumpu.pe.kr>\n");
		fwrite($fp, "To: \"$row[0]님 귀하\"<$row[1]>\n");
		fwrite($fp, "Subject: $subject\n");
		fwrite($fp, "\n");
		if($greetingmsg!=""){
			fwrite($fp, $row[0]."님, ".$greetingmsg."\n");
			fwrite($fp, "\n");
		}

		fwrite($fp, $cont);
		fwrite($fp, "\n");
		fclose($fp);

		$execret = exec("mail ".$row[1]."  < $mailcont_file");

		$no++;
		echo $no." ";
		if(($no % 10) == 0){
			echo "\n";
		}
//sleep(60);
		if(($no % 100) == 0){
			ob_end_flush();
//			sleep(5);
			ob_start();
		}
		fwrite($fpsended, "$row[1] $row[0]\n");
		fflush($fpsended);
	}
	fclose($fpsended);

		$fp = fopen($mailcont_file, "w");
		fwrite($fp, "From: \"Mailing-list 발송프로그램\"<gumpu@gumpu.pe.kr>\n");
		fwrite($fp, "To: \"검푸관리자\"<gumpu@gumpu.pe.kr>\n");
		fwrite($fp, "Subject: 메일 발송 완료\n");
		fwrite($fp, "\n");
		fwrite($fp, "Mailing-list로의 메일 발송이 완료되었습니다.");
		fwrite($fp, "\n");
		fclose($fp);

		$execret = exec("mail gumpu@gumpu.pe.kr < $mailcont_file");
	chmod($mailcont_file, 0777);

	ob_end_flush();

	mysql_free_result($result);
	mysql_close() or die("mysql_close error");

	echo "<p align=center>처리 완료됐습니다.";
	echo "제목이 '메일 발송 완료'로 된 메일이 한참을 기다려도 검푸관리자에게 발송되지 않으면 ~gumpu/html/member/prog/email/emailaccount-sended.dat 파일을 확인해 추가 발송하십시오.\n";

}else {
	top("");
    ////
    if($mode == "member-input"){
	heading("회원 정보 등록");
	if(privcheck($logid) != 2){
		echo "관리자만 사용 가능한 기능입니다.";
	}else{
		member_display("member-insert","","","","","","","","","","","","","","","","","","","","","","","","");
	}
    }else if($mode == "member-select"){
	heading("회원 정보 수정");

	if(privcheck($logid) != 2){
		die("관리자만 사용 가능한 기능입니다.");
	}
	$dbquery="select userid, name, nickname, sex from member order by name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	echo "<form name=pollform method=post action='$PHP_SELF'>\n";
	echo "<input type=hidden name='mode' value='member-change'>\n";
	echo "<select name='userid' size='1'  style='background-color: white; color: blue; font:10pt'>\n";

	while($row=mysql_fetch_array($result)){
		echo "<option value='$row[0]'>$row[1]($row[2])</option>\n";
	}
	echo "</select>";
	echo "<p><input type=submit value='선택'>";
	echo "</form>";
	mysql_free_result($result);
	mysql_close() or die("mysql_close error");
    }else if($mode == "member-change"){
	heading("회원 정보 수정");

	if($userid == "")
		$userid = $logid;
//	$dbquery="select userid, passwd, name, nickname, sex, juminno, org, orghref, email, postno, postaddr, photo, telhome, teloffice, telhand, size, membertype, grade, disporder, gumpuno, etc, hanmirid, hanmirpwd, boston from member where userid='$userid'";
	$dbquery="select userid, passwd, name, nickname, sex, juminno, org, orghref, email, postno, postaddr, photo, telhome, teloffice, telhand, size, membertype, grade, disporder, gumpuno, etc, boston from member where userid='$userid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	if($row=mysql_fetch_array($result)){
		member_display("member-update",  $row[0], $row[1], $row[2], $row[3], $row[4], $row[5],
		 $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $row[12],
		 $row[13], $row[14], $row[15], $row[16], $row[17], $row[18], $row[19], $row[20], $row[21], $row[22], $row[23]);
	}else{
		echo "<tr><td>'$name' 회원을 찾을 수가 없습니다.</td></tr>";
	}
	mysql_free_result($result);
	mysql_close() or die("mysql_close error");
    }else if($mode == "member-insert"){
	heading("회원 정보 등록");

	if($userid == ""){
		echo "userid를 입력 바랍니다.<br><br>";
		echo "<a href='javascript:history.back();'>뒤로</a>";
		die("");
	}
	$dbquery="select userid, name from member where userid='$userid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$rows = mysql_num_rows($result);
	if($rows == 1){
		$row=mysql_fetch_array($result);
		echo "ID가 다른 회원($row[1])과 중복입니다.<br><br>";
		echo "<a href='javascript:history.back();'>뒤로</a>";
		die("");
	}
	$dbquery="select userid, name from member where photo='$photo'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$rows = mysql_num_rows($result);
	if($rows == 1){
		$row=mysql_fetch_array($result);
		echo "사진 파일명이 다른 회원($row[1])과 중복입니다.<br><br>";
		echo "<a href='javascript:history.back();'>뒤로</a>";
		die("");
	}

	$query_name="";
	$query_value="";

	$query_name.="userid,";
	$query_value.="'".$userid."',";

	$query_name.="passwd,";
	$query_value.="'".$passwd."',";

	$query_name.="name,";
	$query_value.="'".$name."',";
	$query_name.="nickname,";
	$query_value.="'".$nickname."',";

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

	$query_name.="photo,";
	$query_value.="'".$photo."',";

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

	$query_name.="size,";
	$query_value.="'".$size."',";
	$query_name.="membertype,";
	$query_value.="'".$membertype."',";

	$query_name.="grade,";
	$query_value.="'".$grade."',";

	if($disporder == "")
		$disporder = "99";
	$query_name.="disporder,";
	$query_value.="'".$disporder."',";

	if($gumpuno != ""){
		$query_name.="gumpuno,";
		$query_value.=$gumpuno.",";
	}

	$query_name.="etc,";
	$query_value.="'".$etc."',";

	$query_name.="boston";
	$query_value.="'".$boston."'";

	$dbquery="insert into member ($query_name) values($query_value)";
//echo "qbquery=$dbquery";
	$result = mysql_db_query("gumpu",$dbquery);

	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "등록 오류입니다.<br>";
		echo "<a href='javascript:history.back();'>뒤로</a>";
		die("");
	}else{
		echo "등록 처리 완료.<br>";
	}

    }else if($mode == "member-delete"){
	heading("회원 정보 삭제");
	if(privcheck($logid) != 2)
		$userid = '';
	$dbquery="delete from member where userid = '".$userid."'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$dbquery="delete from record where userid = '".$userid."'";
	$result = mysql_query($dbquery) or die("mysql_query error");

	if($result=="1"){
		echo "$name 삭제 완료";
	}else{
		echo "<font color=red>$name 삭제 오류</font>";
	}
    }else if($mode == "member-update"){
	heading("회원 정보 수정 완료");

	if($photo != $photoorg){
		$dbquery2="select userid, name from member where photo='$photo' and userid != '$userid'";
		$result2 = mysql_query($dbquery2) or die("mysql_query error");
		$rows = mysql_num_rows($result2);
		if($rows >= 1){
			$row=mysql_fetch_array($result2);
			echo "사진 파일명이 다른 회원($row[1])과 중복입니다.<br><br>";
			echo "<a href='javascript:history.back();'>뒤로</a>";
			die("");
		}
	}

	$dbquery="update member set ";
	if($passwd != ""){
		$dbquery.="passwd='".$passwd."',";
	}

	$dbquery.="name='".$name."',nickname='".$nickname."',sex='".$sex."',juminno='".$juminno.
		"',org='".$org."',orghref='".$orghref."',email='".$email."',postno='".$postno.
		"',postaddr='".$postaddr."',telhome='".$telhome.
		"',teloffice='".$teloffice."',telhand='".$telhand.
//		"',hanmirid='".$hanmirid."',hanmirpwd='".$hanmirpwd.
		"',size='".$size."',etc='".$etc."'";
	if(privcheck($logid) == 2){
		$dbquery.=",membertype='".$membertype."',photo='".$photo."',boston='".$boston.
			"',grade='".$grade."',disporder='".$disporder.  "'";
		if($gumpuno != "")
			$dbquery.=",gumpuno=".$gumpuno;
	}
	$dbquery.=" where userid = '".$userid."'";
//echo "dbquery=$dbquery";
	$result = mysql_query($dbquery) or die("mysql_query error");

	if($result=="1"){
		echo "$name 수정 완료";
	}else{
		echo "<font color=red>$name 수정 오류</font>";
	}
    }else if($mode == "idpasswd-change"){
	heading("암호 정보 수정");
	echo "
		<form action='$PHP_SELF' method=post>
		<input type=hidden name=mode value=idpasswd-update>
<table>
<tr>
  <td>새로운 암호</td>
  <td><input type=password name=passwd size=12></td>
<td rowspan=2><input type=submit value='변경'></td>
</tr>
<tr>
  <td>한번더 입력</td>
  <td><input type=password name=passwd2 size=12></td>
</tr>
</table>
		</form>
		";
    }else if($mode == "idpasswd-update"){
	if($passwd == "" || $passwd != $passwd2){
		heading("암호 정보 수정 오류");
		die("입력한 암호가 이상합니다.");
	}
	heading("암호 정보 수정");
	$dbquery="update member set passwd='".$passwd."' where userid = '".$userid."'";
	$result = mysql_query($dbquery) or die("mysql_query error");

	if($result=="1"){
		echo "암호 수정 완료";
	}else{
		echo "<font color=red>암호 수정 오류</font>";
	}
    }else if($mode == "menu-admin"){
	heading("관리자 메뉴");
	menu_admin();
    }else if($mode == "menu-self"){
	heading("본인 정보");
    }else if($mode == "menu-race"){
	heading("대회 정보");
    }else if($mode == "menu-inviting"){
	heading("대회 참가");
    }else if($mode == "menu-record"){
	heading("기록 관리");
    }else if($mode == "menu-etc"){
	heading("기타");
    }else if($mode == "submenu"){
	heading("메뉴 선택 오류");
	echo "서브 메뉴를 선택하십시오.";
    }else if($mode == "frame"){
	echo "
<html>
<head>
<title>분당 탄천검푸 마라톤클럽</title>
</head>

<frameset rows='59, 1*' border='0' frameborder='NO' framespacing='0'>
    <frame src='logon.php?mode=framemenu' name='framemenu' noresize scrolling='no' marginwidth='0'
    <frame src='logon.php?mode=framecont' name='framecont' noresize scrolling='auto' marginwidth='10' marginheight='0' scrollbar='no' frameborder='NO'>
</frameset>
<noframes>
  <body bgcolor='white' text='black' link='blue' vlink='purple' alink='red'>
    <p>이 페이지를 보려면, 프레임을 볼 수 있는 브라우저가 필요합니다.</p>
  </body>
</noframes>
</html>";

    }else if($mode == "menu-framemenu"){
    }else if($mode == "menu-framecont"){
	heading("회원광장 입장");
	connectstatus($logid);
	echo "D-day 표시 부분<p>";
	echo "일정 표시 부분<p>";
    }else{
	heading("해당 기능이 없습니다.");
	exit;
    }
}

function emailcont(){
	global $PHP_SELF;

	heading("Mailing-List 메일 작성");
	echo "
<form method=post action=$PHP_SELF>
<input type=hidden name=mode value='mailinglist-send'>
<table border=1>
<tr><td>메일계정</td>
<td><input type=text name=mailaccount size=20 maxlength=30>추가발송시 이전 최종 발송주소입력(신규발송시 빈칸)</td>
<tr>
<td align=center>제목</td>
<td><input type=text name=subject size=40 maxlength=60></td>
</tr><tr>
<td align=center>인사말</td>
<td><input type=text name=greetingmsg size=40 maxlength=60><br>인사말 앞에 \"XXX님, \"이 자동으로 추가됩니다.</td>
</tr><tr>
<td align=center>보낼 내용</td>
<td><textarea wrap=auto name='cont' rows=12 cols=60></textarea></td>
</tr>
<tr>
<td colspan=2 align=center>
<input type=submit value='우편 보내기'>
</td>
</tr>
</table>
</center>";
}

?>
</center>
</body>
</html>
