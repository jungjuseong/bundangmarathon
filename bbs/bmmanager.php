<?php

require("./bmauth.php");
require("./bmconfig.php");
require("./bmfunction.php");

top("");
if(privcheck($logid) != 2){
	heading("관리자 기능");
	die("관리자만 사용 가능한 기능입니다.");
}

if($mode == "menu"){
	echo "<a href='bmmem.php?mode=member-input'>회원등록</a>\n";
	echo "<p><a href='bmmem.php?mode=member-select'>회원정보수정</a>\n";
	echo "<p><a href='$PHP_SELF?mode=notify'>강제 알림 보내기</a>\n";
//	echo "<p><a href='$PHP_SELF?mode=mailinglist-input'>Maillig-List 메일 발송</a>\n";
//	echo "<p><a href='bmmailinglist.php'>Maillig-List 추가/삭제</a>\n";
//	echo "<p><a href='/race/2002/prog/reg_admin2.php?mode=logon&uid=bundang0505'>대회 접수 관리자 메뉴</a>\n";
	echo "<p><a href='bmmem.php?mode=photo-upload-set&type=manager'>얼굴 사진 업로드</a>\n";
	echo "<p><a href='bmmem.php?mode=racephoto-upload-set&type=manager'>대회 사진 업로드</a>\n";
	echo "<p><a href='bmrec-in.php'>기록 Batch 등록(개인별)</a>\n";
	echo "<p><a href='bmrec-in.php?mode=batch-input-race'>기록 Batch 등록(대회별)</a>\n";
	echo "<p><a href='bmrecordinput.php'>기록 File 등록(대회별)</a>\n";
	echo "<p><a href='$PHP_SELF?mode=file-upload-get'>파일 업로드</a>\n";
	echo "<p><a href='$PHP_SELF?mode=hotnews-upload-get'>HotNews 그림 파일 업로드</a>\n";
	echo "<p><a href='bmclubtraining.php'>클럽훈련프로그램입력</a>\n";
	echo "<p><a href='$PHP_SELF?mode=login_daytime'>회원로그인 시간</a>\n";
	echo "<p><a href='$PHP_SELF?mode=batchprocessing'>Batch 처리</a>\n";
	echo "<p><a href='$PHP_SELF?mode=poll_delete'>투표결과삭제</a>\n";
	echo "<p><a href='/_asalog/'>트래픽분석</a>\n";
	if($member[user_id] == 'run4joy'){
		echo "<p><a href='$PHP_SELF?mode=execget'>명령실행/파일다운로드</a>\n";
		echo "<p><form action='$PHP_SELF'><input type=hidden name=mode value=menu><input type=text name=url value=".base64_encode($url)."><input type=submit value='URL encoding'></form>\n";
		echo "<pre>\n";
		include("bmtodo.txt");
		echo "</pre>";
		echo urlencode(" % / ? ");
	}
}else if($mode == "login_daytime"){
		heading("회원로그인 시간");

		if(privcheck($logid) != 2){
			die("관리자만 사용 가능한 기능입니다.");
		}
		$dbquery="select name, user_id, login_daytime from  zetyx_member_table order by login_daytime desc, name";
		$result = mysql_query($dbquery) or die("mysql_query error");

		echo "<table><tr><th>이름<th>user_id<th>시간";
		while($row=mysql_fetch_array($result)){
			echo "<tr><td>$row[0]<td>$row[1]<td>$row[2]\n";
		}
		echo "</table>";
		mysql_free_result($result);
		mysql_close() or die("mysql_close error");
}else if($mode == "batchprocessing"){
	// 임시용
		heading("주민번호 암호화 Batch 처리(한번만)");

		if(privcheck($logid) != 2){
			die("관리자만 사용 가능한 기능입니다.");
		}
//		$dbquery="select name, juminno from member where juminno < '999999' order by name";
		$dbquery="select name, juminno, gumpuno, userid from member order by name";
		$result = mysql_query($dbquery) or die("mysql_query error");

		while($row=mysql_fetch_array($result)){
			$userid = $row[3];
//if($userid != 'run4joy') continue;

//	$gumpuno = '0';
//$gumpuno = $row[2];
//echo "$row[0] $gumpuno $row[1] $row[3]<br>";
			$str = jmchange(1, $row[1]);

	$dbquery = "update member set juminno='".$str."' where userid = '".$userid."'";
//echo "dbquery=$dbquery";
	$result2 = mysql_query($dbquery) or die("mysql_query error");

	if($result2=="1"){
	}else{
		echo "<font color=red>$row[0] 수정 오류</font>";
	}

			$str = jmchange(2, $str);
if($str != $row[1]){
	echo "Mismatch YYY<br>";
}
		}
		mysql_free_result($result);
		mysql_close() or die("mysql_close error");
}else if($mode == "poll_delete"){
		heading("투표결과삭제");
	
		if(privcheck($logid) != 2){
			die("관리자만 사용 가능한 기능입니다.");
		}
	if($pollid != "" && $deleteuserid != ""){
		$dbquery="delete from poll where pollid='$pollid' and userid like '$deleteuserid%'";
		$result = mysql_query($dbquery) or die("mysql_query error");
		if($result=="1"){
			echo "'$pollid' '$deleteuserid' ".mysql_affected_rows()."건 삭제 완료";
		}else{
			echo "<font color=red>'$pollid' '$deleteuserid' 삭제 오류</font>";
		}
		mysql_close() or die("mysql_close error");
	}else{
			echo "아래 빈 칸에 입력하십시오.";
	}

		echo "<p><form action='$PHP_SELF'><input type=hidden name=mode value='poll_delete'>pollid: <input type=text name='pollid' value='$pollid'><br>userid: <input type=text name='deleteuserid' value=''><br><input type=submit value='삭제'></form>\n";
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
		fwrite($fp, "From: \"분당마라톤대회 운영자\"<$managerEmail>\n");
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
		fwrite($fp, "From: \"Mailing-list 발송프로그램\"<$managerEmail>\n");
		fwrite($fp, "To: \"관리자\"<$managerEmail>\n");
		fwrite($fp, "Subject: 메일 발송 완료\n");
		fwrite($fp, "\n");
		fwrite($fp, "Mailing-list로의 메일 발송이 완료되었습니다.");
		fwrite($fp, "\n");
		fclose($fp);

		$execret = exec("mail $managerEmail < $mailcont_file");
	chmod($mailcont_file, 0777);

	ob_end_flush();

	mysql_free_result($result);
	mysql_close() or die("mysql_close error");

	echo "<p align=center>처리 완료됐습니다.";
	echo "제목이 '메일 발송 완료'로 된 메일이 한참을 기다려도 관리자에게 발송되지 않으면 ~gumpu/html/member/prog/email/emailaccount-sended.dat 파일을 확인해 추가 발송하십시오.\n";

}else {
	top("");
    ////
if($mode == "execget"){
		heading("명령 수행");
		if(privcheck($logid) != 2){
			echo "관리자만 사용 가능한 기능입니다.";
		}else{
			echo "
<form action='$PHP_SELF' method=post>
<input type=hidden name=mode value=execset>
<table>
<tr>
  <td>명령</td>
  <td><input type=input name=command size=40 maxlength=80 value=''></td>
<td rowspan=2><input type=submit value='실행'>[download filename]</td>
</tr>
</table>
		</form>
		";
		}
}else if($mode == "execset"){
		heading("명령 수행");
		if(privcheck($logid) == 2){
		    if(strpos($command, "rm ") >= 1){
			echo "rm 명령 수행 불가";
		    }else{
			    if(($pos = strpos($command, ":")) != 0){	// 
				echo "명령은 반드시 :로 시작해야 함";
			    }else{
				    $command = substr($command, $pos+1);
				    if(substr($command, 0, 8)=="download"){
					echo "<a href='".substr($command, 9)."'>".substr($command, 9)."</a>";
				    }else{
					    echo "<pre>";
					    passthru($command);
					    echo "</pre><br><br>$command 실행완료";
				    }
			    }
		    }
	    }
	    
}else if($mode == "file-upload-get"){
	heading("파일 업로드");

	if(privcheck($logid) == 2){
		echo "
<FORM ENCTYPE='multipart/form-data' ACTION='$PHP_SELF' METHOD=POST>
<INPUT TYPE='hidden' name='MAX_FILE_SIZE' value='10000000'>
<INPUT TYPE='hidden' name='mode' value='file-upload-set'>
파일 지정: <INPUT NAME='userfile' TYPE='file'><br><br>
디렉토리: <INPUT NAME='directory' TYPE='input'>(default : /bbs/upload)<br><br>";
		echo "<INPUT TYPE='submit' VALUE='파일 업로드 하기'>
</FORM>
* 10M까지 업로드 가능; \"'\"가 있으면 이름 보존 안됨";
	}
}else if($mode == "file-upload-set"){
	heading("파일 업로드");

	if($userfile_size>(1024*1024*10)){
		echo "파일이 너무 큽니다.";
		exit;
	}
	if(privcheck($logid) == 2){
		if($directory==""){
			$dir = "upload/";
		}else if(substr($directory, 0, 1) == "/"){
			$dir = $home.$directory;
		}else{
			$dir = $directory;
		}
		if(substr($dir, strlen($dir)-1, 1) != "/"){
			$dir .= "/";
		}
//echo "userfile=$userfile photofile=$photofile dir=$dir";
//		$file = basename ($userfile);
		$file = $userfile_name;
		if(!move_uploaded_file($userfile, "$dir$file")){
			echo "move_uploaded_file() error\n";
		}else{
			chmod("$dir$file", 0777);
			echo "파일($userfile_name -> $dir$file) 업로드 완료";
		}
	}
}else if($mode == "hotnews-upload-get"){
	heading("HotNews 그림 파일 업로드");

	if(privcheck($logid) == 2){
		echo "
<FORM ENCTYPE='multipart/form-data' ACTION='$PHP_SELF' METHOD=POST>
<INPUT TYPE='hidden' name='MAX_FILE_SIZE' value='1000000'>
<INPUT TYPE='hidden' name='mode' value='hotnews-upload-set'>
파일 지정: <INPUT NAME='userfile' TYPE='file'><br>
게시물 번호:<input type=input name=bbsno size=6 maxlength=10><br>
(HotNews 게시판의 게시물 번호)<br><br>";
		echo "<INPUT TYPE='submit' VALUE='업로드'>
</FORM>";
	}
}else if($mode == "hotnews-upload-set"){
	heading("HotNews 그림 파일 업로드");

	if($userfile_size>(1024*1024*1)){
		echo "파일이 너무 큽니다.";
		exit;
	}
	if(privcheck($logid) == 2){
//echo "userfile=$userfile photofile=$photofile ";
//		$file = basename ($userfile);
		$file = $userfile_name;
		$filebase = basename($file);
		$fileextpos = strpos($filebase, ".");
//echo "filebase=$filebase fileextpos=$fileextpos ";
		if ($fileextpos === false) {
			echo "파일 확장자가 없습니다.";
			exit;
		}
		$fileext = substr($filebase, $fileextpos+1);
		$file = $bbsno.".".$fileext;

		if(!move_uploaded_file($userfile, "hotnews/$file")){
			echo "move_uploaded_file() error\n";
		}else{
			chmod("hotnews/$file", 0777);
			if(is_file("hotnews/hotnews.txt") == TRUE)
				unlink("hotnews/hotnews.txt");
			if(($fp = fopen("hotnews/hotnews.txt", "w")) == FALSE){
				echo "hotnews/hotnews.txt file에 쓸 수 없습니다.";
				echo "HotNews 파일($userfile_name -> hotnews/$file) 업로드 실패!!!";
				exit;
			}
			fwrite($fp, "$file\n$bbsno\n");
			fclose($fp);
			echo "HotNews 파일($userfile_name -> hotnews/$file) 업로드 완료";
		}
	}

}else if($mode == "member-input"){
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
//		$dbquery="select userid, passwd, name, nickname, sex, juminno, org, orghref, email, postno, postaddr, photo, telhome, teloffice, telhand, size, membertype, grade, disporder, gumpuno, etc, hanmirid, hanmirpwd, boston from member where userid='$userid'";
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
	$query_value.="'". jmchange(1, $juminno) ."',";

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
	$result = mysql_query($dbquery);

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

	$dbquery.="name='".$name."',nickname='".$nickname."',sex='".$sex."',juminno='". jmchange(1, $juminno) .
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
}else if($mode == "notify"){
		heading("강제 알림 보내기");

		if(privcheck($logid) != 2){
			die("관리자만 사용 가능한 기능입니다.");
		}
		echo "<p align=center>* 로그인하면 홈페이지 내용이 나오기 전에 <br>알림 내용이 나타납니다.<br>한번만 나타나고 바로 삭제됩니다.";
		$dbquery="select userid, name, nickname, sex, membertype from member order by name";
		$result = mysql_query($dbquery) or die("mysql_query error");

		echo "<form name=pollform method=post action='$PHP_SELF'>\n";
		echo "<input type=hidden name='mode' value='notify-exec'>\n";
		echo "<table><tr><td>대상자 지정 : <br>(Ctrl키 눌러<br>다중선택)<td><select MULTIPLE name='userid[]' size='10'  style='background-color: white; color: blue; font:10pt'>\n";

		while($row=mysql_fetch_array($result)){
			echo "<option value='$row[0]'>$row[1]($row[2]):$row[membertype]</option>\n";
		}
		echo "</select>";
		echo "<tr><td align=right>메시지 : <br>(영문40자까지)<td><input type=text name='notifymsg' size=40 maxlength=40>\n";
		echo "<tr><td colspan=2 align=center><input type=submit value='보내기'>";
		echo "</form>";
		mysql_free_result($result);
		mysql_close() or die("mysql_close error");
}else if($mode == "notify-exec"){
		heading("강제 알림 보내기 처리");

		if(privcheck($logid) != 2){
			die("관리자만 사용 가능한 기능입니다.");
		}
		$cnt = count($userid);
		echo $cnt."명<br>";
		for($i = 0; $i < $cnt; $i++){
			echo $userid[$i]." ";
			$dbquery="insert into etc (type, userid, msgstr) values('notify', '$userid[$i]', '$notifymsg')";
			$result = mysql_query($dbquery);
		}
		echo "<br><br>강제 알림 보내기 처리 완료";

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
<title>분당마라톤클럽</title>
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
