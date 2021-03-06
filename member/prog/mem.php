<?php

require("./auth.php");
require("./config.php");
require("./function.php");

top("");
////

if($mode == "member-input"){
	heading("회원 정보 등록");
	if(privcheck($logid) != 2){
		echo "관리자만 사용 가능한 기능입니다.";
	}else{
		member_display("member-insert","","","","","","","","","","","","","","","","","","","","","","","","","");
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
//	$dbquery="select userid, passwd, name, nickname, sex, juminno, org, orghref, email, postno, postaddr, photo, telhome, teloffice, telhand, size, membertype, grade, disporder, gumpuno, etc, hanmirid, hanmirpwd, boston, indate from member where userid='$userid'";
	$dbquery="select userid, passwd, name, nickname, sex, juminno, org, orghref, email, postno, postaddr, photo, telhome, teloffice, telhand, size, membertype, grade, disporder, gumpuno, etc, boston, indate from member where userid='$userid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	if($row=mysql_fetch_array($result)){
		member_display("member-update",  $row[0], $row[1], $row[2], $row[3], $row[4], $row[5],
		 $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $row[12],
		 $row[13], $row[14], $row[15], $row[16], $row[17], $row[18], $row[19], $row[20], $row[21], $row[22], $row[23], $row[24]);
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
	mysql_free_result($result);
	$dbquery="select userid, name from member where juminno='$juminno'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$rows = mysql_num_rows($result);
	if($rows == 1){
		$row=mysql_fetch_array($result);
		echo "주민등록번호가 다른 회원($row[1])과 중복입니다.<br><br>";
		echo "<a href='javascript:history.back();'>뒤로</a>";
		die("");
	}
	mysql_free_result($result);

	if($photo != ''){
		$dbquery="select userid, name from member where photo='$photo'";
		$result = mysql_query($dbquery) or die("mysql_query error");
		$rows = mysql_num_rows($result);
		if($rows == 1){
			$row=mysql_fetch_array($result);
			echo "사진 파일명이 다른 회원($row[1])과 중복입니다.<br><br>";
			echo "<a href='javascript:history.back();'>뒤로</a>";
			die("");
		}
	}

	$query_name="";
	$query_value="";

	$query_name.="userid,";
	$query_value.="'$userid',";

	$query_name.="passwd,";
	$query_value.="'$passwd',";

	$query_name.="name,";
	$query_value.="'$name',";
	$query_name.="nickname,";
	$query_value.="'$nickname',";

	$query_name.="sex,";
	$query_value.="'$sex',";

	$query_name.="juminno,";
	$query_value.="'$juminno',";

	$query_name.="org,";
	$query_value.="'$org',";
	$query_name.="orghref,";
	$query_value.="'$orghref',";

	$query_name.="email,";
	$query_value.="'$email',";

	$query_name.="postno,";
	$query_value.="'$postno',";

	$query_name.="postaddr,";
	$query_value.="'$postaddr',";

	$query_name.="photo,";
	$query_value.="'$photo',";

	if($telhome!=""){
		$query_name.="telhome,";
		$query_value.="'$telhome',";
	}

	if($teloffice!=""){
		$query_name.="teloffice,";
		$query_value.="'$teloffice',";
	}

	if($telhand!=""){
		$query_name.="telhand,";
		$query_value.="'$telhand',";
	}

	$query_name.="size,";
	$query_value.="'$size',";
	$query_name.="membertype,";
	$query_value.="'$membertype',";

	$query_name.="grade,";
	$query_value.="'$grade',";

	if($disporder == "")
		$disporder = "99";
	$query_name.="disporder,";
	$query_value.="'$disporder',";

	if($gumpuno != ""){
		$query_name.="gumpuno,";
		$query_value.="$gumpuno,";
	}

	$query_name.="etc,";
	$query_value.="'$etc',";

	$query_name.="boston,";
	$query_value.="'$boston',";

	$query_name.="indate";
	$query_value.="replace(substring(now(),1,10), '-', '/')";

	$dbquery="insert into member ($query_name) values($query_value)";
echo "dbquery=$dbquery";
	$result = mysql_db_query("coretek",$dbquery);

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

	if(emailaddrcheck($email) == 0){
		echo ("E-mail을 정확히 입력하여 주십시오!<br><br>");
		echo "<a href='javascript:history.back();'>뒤로</a>";
		exit;
	}

	if($photo >= '0' and $photo <= '99'){
		$photodir = "../photo/";
		$index = substr(date("i"), 1, 1);	// 분 끝자리
		if($index >= 5)
			$index = $index - 5;
		if($sex == "M")
			$samplename = "boy";
		else
			$samplename = "girl";
		$samplename = $photodir.$samplename.($index + 1).".jpg";
echo $samplename;

		$photoname = $userid.".jpg";
		if(file_exists ($photodir.$photoname)){
			echo ("사진 파일명 자동 생성시 중복 에러입니다. 파일명을 입력하여 주십시오!<br><br>");
			echo "<a href='javascript:history.back();'>뒤로</a>";
			exit;
		}
		$photo = $photoname;
		$photoname = $photodir.$photoname;
		$execret = exec("cp $samplename $photoname");
	}

	if($photo != $photoorg && $photo != ''){
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
//	if($passwd != ""){
//		$dbquery.="passwd='$passwd',";
//	}

	$dbquery.="name='$name',nickname='$nickname',sex='$sex',juminno='$juminno'".
		",org='$org',orghref='$orghref',email='$email',postno='$postno'".
		",postaddr='$postaddr',telhome='$telhome'".
		",teloffice='$teloffice',telhand='$telhand'".
//		",hanmirid='$hanmirid',hanmirpwd='$hanmirpwd'".
		",size='$size',etc='$etc'";
	if(privcheck($logid) == 2){
		$dbquery.=",membertype='$membertype',photo='$photo',boston='$boston'".
			",grade='$grade',disporder='$disporder',indate='$indate'";
		if($gumpuno != "")
			$dbquery.=",gumpuno=$gumpuno";
	}
	$dbquery.=" where userid = '$userid'";
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
  <td>기존 암호</td>
  <td><input type=password name=passwdold size=12></td>
<td rowspan=3><input type=submit value='변경'></td>
</tr>
<tr>
  <td>새로운 암호</td>
  <td><input type=password name=passwd size=12></td>
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
	if(strstr($passwd, "'") != false){
		echo "패스워드에 해당 특수문자를 사용할 수 없습니다.";
		die("");
	}
	$dbquery="select userid, passwd from member where userid='$logid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$rows = mysql_num_rows($result);
	if($rows >= 1){
		$row=mysql_fetch_array($result);
		if($row[1] != $passwdold){
			echo "<font color=red>암호 수정 불가(패스워드 불일치)</font>";
			exit();
		}
	}else{
		echo "<font color=red>암호 수정 불가(사용자ID 불일치)</font>";
		exit();
	}
	mysql_free_result($result);

	$dbquery="update member set passwd='$passwd' where userid='$logid'";
	$result = mysql_query($dbquery) or die("mysql_query error");

	if($result=="1"){
		echo "암호 수정 완료";
	}else{
		echo "<font color=red>암호 수정 오류</font>";
	}
}else if($mode == "photo-upload-set"){
	heading("얼굴사진 업로드");

	echo "
<FORM ENCTYPE='multipart/form-data' ACTION='$PHP_SELF' METHOD=POST>
<INPUT TYPE='hidden' name='MAX_FILE_SIZE' value='20480'>
<INPUT TYPE='hidden' name='mode' value='photo-upload-save'>
사진 파일 지정: <INPUT NAME='userfile' TYPE='file'><br><br>";
	if(privcheck($logid) == 2 && $type=='manager'){
		$dbquery="select userid, name, nickname, sex from member order by name";
		$result = mysql_query($dbquery) or die("mysql_query error");

		echo "<select name='userid' size='1'  style='background-color: white; color: blue; font:10pt'>\n";

		while($row=mysql_fetch_array($result)){
			echo "<option value='$row[0]'>$row[1]($row[2])</option>\n";
		}
		echo "</select>
<br><br>\n";
	}
	echo "<INPUT TYPE='submit' VALUE='사진 업로드 하기'>
</FORM>
* 주의 : 사진 크기(pixel)는 150 x 200, 사이즈는 20K 이하, jpg 파일만 업로드 가능합니다.";

//	phpinfo();
}else if($mode == "photo-upload-save"){
	heading("얼굴사진 업로드");

//	echo "수정중입니다.";
//	return;
/*

	if($HTTP_POST_FILES[file1]) {
		$file1 = $HTTP_POST_FILES[file1][tmp_name];
		$file1_name = $HTTP_POST_FILES[file1][name];
		$file1_size = $HTTP_POST_FILES[file1][size];
		$file1_type = $HTTP_POST_FILES[file1][type];
	}

	if($file1_size>0&&$setup[use_pds]&&$file1) {

		if(!is_uploaded_file($file1)) Error("정상적인 방법으로 업로드 해주세요");
		if($file1_name==$file2_name) Error("같은 파일은 등록할수 없습니다");
		$file1_size=filesize($file1);

		if($setup[max_upload_size]<$file1_size&&!$is_admin) error("첫번째 파일 업로드는 최고 ".GetFileSize($setup[max_upload_size])." 까지 가능합니다");

		// 업로드 금지
		if($file1_size>0) {
			$s_file_name1=$file1_name;
			if(eregi("\.inc",$s_file_name1)||eregi("\.phtm",$s_file_name1)||eregi("\.htm",$s_file_name1)||eregi("\.shtm",$s_file_name1)||eregi("\.ztx",$s_file_name1)||eregi("\.php",$s_file_name1)||eregi("\.dot",$s_file_name1)||eregi("\.asp",$s_file_name1)||eregi("\.cgi",$s_file_name1)||eregi("\.pl",$s_file_name1)) Error("Html, PHP 관련파일은 업로드할수 없습니다");

			//확장자 검사
			if($setup[pds_ext1]) {
				$temp=explode(".",$s_file_name1);
				$s_point=count($temp)-1;
				$upload_check=$temp[$s_point];
				if(!eregi($upload_check,$setup[pds_ext1])||!$upload_check) Error("첫번째 업로드는 $setup[pds_ext1] 확장자만 가능합니다");
			}

			$file1=eregi_replace("\\\\","\\",$file1);
			$s_file_name1=str_replace(" ","_",$s_file_name1);
			$s_file_name1=str_replace("-","_",$s_file_name1);

			// 디렉토리를 검사함
			if(!is_dir("data/".$id)) {
				@mkdir("data/".$id,0777);
				@chmod("data/".$id,0706);
			}

			// 중복파일이 있을때;;
			if(file_exists("data/$id/".$s_file_name1)) {
				@mkdir("data/$id/".$reg_date,0777);
				if(!move_uploaded_file($file1,"data/$id/".$reg_date."/".$s_file_name1)) Error("파일업로드가 제대로 되지 않았습니다");
				$file_name1="data/$id/".$reg_date."/".$s_file_name1;
				@chmod($file_name1,0706);
				@chmod("data/$id/".$reg_date,0707);
			} else {
				if(!move_uploaded_file($file1,"data/$id/".$s_file_name1)) Error("파일업로드가 제대로 되지 않았습니다");
				$file_name1="data/$id/".$s_file_name1;
				@chmod($file_name1,0706);
			}
		}
  	}

*/

/*
	echo "userfile=$userfile";
	echo " userfile_name=$userfile_name";
	echo " userfile_size=$userfile_size";
	echo ":$HTTP_POST_FILES[userfile][name]:";
	echo ":$HTTP_POST_FILES[userfile][size]:";
	echo ":$HTTP_POST_FILES[userfile][tmp_name]:";
        if($HTTP_POST_FILES[userfile]) {
                $userfile = $HTTP_POST_FILES[userfile][tmp_name];
                $userfile_name = $HTTP_POST_FILES['userfile']['name'];
                $userfile_size = $HTTP_POST_FILES[userfile][size];
echo "if true";
        }

echo "userfile_name=$userfile_name userfile_size=$userfile_size ";
*/
	if(substr(strtolower($userfile_name), strlen($userfile_name)-4) != ".jpg"){
		echo "jpg 사진 파일만 업로드 가능합니다.";
		exit;
	}
	if($userfile_size>(1024*20)){
		echo "사진 파일이 너무 큽니다. 20K 이하로 만든 후 업로드하십시오.";
		exit;
	}
	$photosize = GetImageSize ($userfile);
	if($photosize[0] > 150 || $photosize[1] > 200){
		echo "사진 파일 사이즈($photosize[0] x $photosize[1])를 150 x 200 보다 적게 만든 후 업로드하십시오.";
		exit;
	}
	if(privcheck($logid) == 2 && $userid > ' '){
	}else{
		$userid = $logid;
	}
	$dbquery="select userid, name, photo from member where userid='$userid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$row=mysql_fetch_array($result);
	if($row[2] > " " && $row[2] != "0"){
		$photofile = $row[2];
	}else{
		$photofile = $row[0].".jpg";
		$dbquery="update member set photo='$photofile' where userid='$userid'";
		$result = mysql_query($dbquery) or die("mysql_query error");
		if($result!="1"){
			echo "사진 파일명 DB 저장 에러";
			exit;
		}
		//mysql_free_result($result);
	}
//echo "userfile=$userfile photofile=$photofile ";
	if(!move_uploaded_file($userfile, "../photo/$photofile")){
		echo "move_uploaded_file() error\n";
	}else{
		chmod("../photo/$photofile", 0777);
		echo "사진 파일($userfile_name -> $photofile) 업로드 완료";
	}

}else if($mode == "racephoto-upload-set"){
	heading("대회 사진 업로드/삭제");

	echo "<font size='+2'>대회 사진 업로드</font><p>";
	require("./func_nextimg.php");

	//Create an array to hold the files
	$filesArray = array();

	//Pass the array by reference
	GetDirContFiles($path2racephoto,&$filesArray,"DirIsUsed");

	$imgnos = count($filesArray);
	if($imgnos > 1){
		rsort ($filesArray);
		reset ($filesArray);
	}
	if($imgnos == 0){
		echo "사진을 저장할 Directory가 없습니다.";
		exit;
	}
//echo "imgno=$imgnos ";

	echo "
<FORM ENCTYPE='multipart/form-data' ACTION='$PHP_SELF' METHOD=POST>
<INPUT TYPE='hidden' name='MAX_FILE_SIZE' value='100000'>
<INPUT TYPE='hidden' name='mode' value='racephoto-upload-save'>
사진 파일 지정: <INPUT NAME='userfile' TYPE='file'><br><br>
대회 : <select name='savedir' size='1' style='background-color: white; color: blue; font:10pt'>
<option value='null'>대회 선택</option>\n";
	for($i=0; $i < $imgnos; $i++){
//echo dirname($filesArray[$i])." ";
		$path = substr(dirname($filesArray[$i]),strlen("/member/racephoto"));
		if(strlen($path)>0)
			echo "<option value='$path'>$path</option>\n";
	}
	echo "
</select><br><br>
<INPUT TYPE='submit' VALUE='대회사진 업로드 하기'>
</FORM>
* 주의 : 사진 크기(pixel)는 300 x 400, 사이즈는 50K 이하, jpg 파일만 업로드 가능합니다.";

    if(privcheck($logid) == 2){
	echo "<br><br><font size='+1'>사진 저장 대회 지정(관리자 기능)</font><br>";
	echo "<form name=form1 method=post action='$PHP_SELF'>
<input type=hidden name='mode' value='racephoto-makedir'>
<input type=hidden name='raceid'>
<input type=text name=racename size=50 value='맨 아래에서 대회를 선택후 옆의 지정을 누르십시오.'><br>
<input type=submit onClick=\"if(this.form.raceid.value==''){ alert('아래에서 대회를 지정하십시오.'); return false;}\" value='대회 지정'>
</form>\n";
	}

	echo "<p><br><br><font size='+2'>대회 사진 삭제</font><p>";

	$dbquery="select name from member where userid='$logid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$row=mysql_fetch_array($result);
	$name = $row[0];

	echo "
<FORM ENCTYPE='multipart/form-data' ACTION='$PHP_SELF' METHOD=POST>
<INPUT TYPE='hidden' name='mode' value='racephoto-upload-delete'>
대회 : <select name='racedir' size='1' style='background-color: white; color: blue; font:10pt'>\n";
	echo "<option value='null'>삭제 사진 선택</option>\n";
	for($i=0; $i < $imgnos; $i++){
		$fname = "..".substr(dirname($filesArray[$i]), 7)."/$name.jpg";
		if(is_file($fname)){
			$path = substr(dirname($filesArray[$i]), 17);
			echo "<option value='$path'>$path</option>\n";
		}
	}
	echo "
</select><br><br>
<INPUT TYPE='submit' VALUE='대회사진 삭제'>
</FORM>";

}else if($mode == "racephoto-upload-save"){
	heading("대회사진 업로드");

	if($savedir == "null"){
		echo "사진을 저장할 대회가 지정되지 않았습니다.";
		exit;
	}
	if(substr(strtolower($userfile_name), strlen($userfile_name)-4) != ".jpg"){
		echo "jpg 사진 파일만 업로드 가능합니다.";
		exit;
	}
	if($userfile_size>(1024*50) || $userfile == "none"){
		echo "사진 파일이 너무 큽니다. 50K 이하로 만든 후 업로드하십시오.";
		exit;
	}
	$photosize = GetImageSize ($userfile);
	if($photosize[0] > 300 && $photosize[1] > 400){
		echo "사진 파일 사이즈를 300 x 400 보다 작게 만든 후 업로드하십시오.";
		exit;
	}

	$dbquery="select userid, name, photo from member where userid='$logid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$row=mysql_fetch_array($result);
	if(!move_uploaded_file($userfile, "../racephoto$savedir/$row[1].jpg")){
		echo "move_uploaded_file() error\n".error();
	}else{
		chmod("../racephoto$savedir/$row[1].jpg",0606);
		echo "대회사진 파일 업로드 완료";
	}

}else if($mode == "racephoto-upload-delete"){
	heading("대회사진 삭제");

	if($racedir == "null"){
	 	echo "삭제할 대회를 지정하십시오.";
		echo "<br><a href='javascript:history.back()'>이전으로</a>";
		die("");
	}
	$dbquery="select name from member where userid='$logid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$row=mysql_fetch_array($result);
	$name = $row[0];

	if(!unlink("../racephoto$racedir/$name.jpg")){
		echo "unlink error:../racephoto$racedir/$name.jpg";
	}else{
		echo "대회사진 파일 삭제 완료";
	}
}else if($mode == "racephoto-makedir"){
	heading("사진 저장 대회 지정");

	if(privcheck($logid) != 2){
		echo "대회를 지정할 수 없습니다.\n";
		return;
	}
        $dbquery="select raceid, nickname, raceday from race where raceid=$raceid";
        $result = mysql_query($dbquery) or die("mysql_query error");
        if($row=mysql_fetch_array($result)){
		$year=substr($row[2],0,4);
		$month=substr($row[2],5,2);
		$day=substr($row[2],8,2);
		for($i=0; $i < strlen($row[1]); $i++){
			$tmp=substr($row[1],$i,1);
			if($tmp>="0" && $tmp<="9" || $tmp==" ")
				;
			else
				break;
		}
		$shortname = substr($row[1],$i);
        	$dir = "../racephoto/$year/$month$day-$shortname";
        	if(!mkdir($dir, 0707)){
			echo "Directory 생성 오류($dir)\n";
			return;
		}
		chmod($dir, 0707);
		if (!copy("../racephoto/DirIsUsed", $dir."/DirIsUsed")) {
			print ("DirIsUsed file을 복사하는데 실패했습니다.<br>\n");
		}else{
			chmod($dir."/DirIsUsed", 0707);
			echo "사진 저장 대회 지정 완료";
		}

        }else{
                echo "<tr><td>'$name' 대회를 찾을 수가 없습니다.</td></tr>";
        }
        mysql_free_result($result);
}else if($mode == "submenu"){
	heading("메뉴 선택 오류");
	echo "서브 메뉴를 선택하십시오.";
}else{
	heading("해당 기능이 없습니다.");
	exit;
}

// function member_display($mode, $userid, $passwd, $name, $nickname, $sex, $juminno, $org, $orghref, $email, $postno, $postaddr, $photo, $telhome, $teloffice, $telhand, $size, $membertype, $grade, $disporder, $gumpuno, $etc, $hanmirid, $hanmirpwd, $boston, $indate){
function member_display($mode, $userid, $passwd, $name, $nickname, $sex, $juminno, $org, $orghref, $email, $postno, $postaddr, $photo, $telhome, $teloffice, $telhand, $size, $membertype, $grade, $disporder, $gumpuno, $etc, $boston, $indate){

	global $PHP_SELF, $logid;

	if($sex == "F"){
		$sexf = "checked";
		$sexm = "";
	}else{
		$sexm = "checked";
		$sexf = "";
	}
	echo "<table border=1>";
	JScheckLength();
echo "
<form action='$PHP_SELF' method=post>\n
<input type=hidden name=mode value='$mode'>\n
";
	if($mode == "member-update"){
		echo "
<tr><td>사용자ID</td><td>$userid</td></tr>\n
<input type=hidden name=userid value='$userid'>\n";
//		if($logid == $userid){
//			echo "
//<tr><td>암호</td><td><input type=password name=passwd value='$passwd' maxlength=10 size=10></td></tr>\n";
//		}
	}else{
		echo "
<tr><td>사용자ID</td><td><input type=text name=userid value='$userid' maxlength=12 size=12> 영문소문자/숫자로 작성</td></tr>\n
<tr><td>암호</td><td><input type=text name=passwd value='3456' maxlength=10 size=10>디폴트값 : 3456</td></tr>\n";
	}
	echo "
<tr><td>이름</td><td><input type=text name=name value='$name' maxlength=10 size=10></td></tr>\n
<tr><td>별명</td><td><input type=text name=nickname value='$nickname' maxlength=20 size=20></td></tr>\n
<tr><td>성별</td><td>
<input type='radio' name='sex' value='M' $sexm>남(Male)
<input type='radio' name='sex' value='F' $sexf>여(Female)
</td></tr>\n";
if($juminno=="")
	$juminno="xxxxxx-yyyyyyy";
echo "
<tr><td>주민번호</td><td><input type=text name=juminno value='$juminno' maxlength=14 size=20>생년월일만 외부공개됨. 주민번호는 단체 신청시 활용</td></tr>\n
<tr><td>직장명</td><td><input type=text name=org value='$org' maxlength=30 size=30 onChange='return checkLength(this.value,30)'></td></tr>\n
<tr><td>개인/직장홈주소</td><td><input type=text name=orghref value='$orghref' maxlength=50 size=40 onChange='return checkLength(this.value,50)'></td></tr>\n
<tr><td>E-Mail 주소</td><td><input type=text name=email value='$email' maxlength=30 size=30 onChange='return checkLength(this.value,30)'></td></tr>\n
<tr><td>우편번호</td><td><input type=text name=postno value='$postno' maxlength=7 size=8></td></tr>\n
<tr><td>주소</td><td><input type=text name=postaddr value='$postaddr' maxlength=60 size=40 onChange='return checkLength(this.value,60)'></td></tr>\n
";

	if(privcheck($logid) == 2){
		echo "
<tr><td>사진파일명</td><td><input type=text name=photo value='$photo' maxlength=15 size=20></td></tr>\n
";
		echo "<input type=hidden name=photoorg value='$photo'>\n";
	}else{
		echo "<input type=hidden name=photo value='$photo'>\n";
		echo "<input type=hidden name=photoorg value='$photo'>\n";
	}
	echo "
<tr><td>전화Home</td><td><input type=text name=telhome value='$telhome' maxlength=15 size=20></td></tr>\n
<tr><td>전화Office</td><td><input type=text name=teloffice value='$teloffice' maxlength=15 size=20></td></tr>\n
<tr><td>전화Hand</td><td><input type=text name=telhand value='$telhand' maxlength=15 size=20></td></tr>\n
<tr><td>티셔츠사이즈</td><td>";

	echo "<select name='size' size='1'  style='background-color: white; color: blue; font:10pt'>";
	if($size == "")
		$size = "100(X)";
	$sizearray = array("90(S)","95(M)","100(X)","105(XL)","110(XXL)");
	for($i=0; $i<count($sizearray); $i++){
		if($sizearray[$i] == $size)
			echo "<option value='$sizearray[$i]' selected>$sizearray[$i]</option>";
		else
			echo "<option value='$sizearray[$i]'>$sizearray[$i]</option>";
	}
	echo "</td></tr>\n";

    if(privcheck($logid) == 2){
		echo "
<tr><td>회원구분</td><td>";
	echo "<select name='membertype' size='1'  style='background-color: white; color: blue; font:10pt'>";

	if($membertype == "")
		$membertype = "예비회원";
	$mtarray = array("정회원","준회원","예비회원","휴면회원","OB회원");
	for($i=0; $i<count($mtarray); $i++){
		if($mtarray[$i] == $membertype)
			echo "<option value='$mtarray[$i]' selected>$mtarray[$i]</option>";
		else
			echo "<option value='$mtarray[$i]'>$mtarray[$i]</option>";
	}
	echo "</select>";
	if($disporder == "")
		$disporder = "99";
	echo "</td></tr>\n
<tr><td>직책</td><td><input type=text name=grade value='$grade' maxlength=10 size=20>회장, 부회장,... 운영위원</td></tr>\n
<tr><td>표시순서</td><td><input type=text name=disporder value='$disporder' maxlength=2 size=3>1:회장,2:부회장,3:기획,4:훈련,5:홈,6:총무,7:운영위원,8:기타,99:평회원 등</td></tr>\n
<tr><td>검푸번호</td><td><input type=text name=gumpuno value='$gumpuno' maxlength=4 size=5></td></tr>\n";
/*
		if($logid != $userid){
			echo "<input type=hidden name=hanmirid value='$hanmirid'>\n";
			echo "<input type=hidden name=hanmirpwd value='$hanmirpwd'>\n";
		}else{
			echo "
<tr><td>한미르회원광장</td><td>
ID:<input type=text name=hanmirid value='$hanmirid' maxlength=12 size=12>
Password:<input type=password name=hanmirpwd value='$hanmirpwd' maxlength=10 size=10> 한미르회원광장 접속용
</td></tr>\n";
		}
*/
	echo "<tr><td>보스톤기록년도</td><td><input type=text name=boston value='$boston' maxlength=30 size=30> 기준 기록 통과 연도 (예:1999-2001,2002A,2003; 참가한 경우 A 붙임)</td></tr>\n";
	echo "<tr><td>입회일</td><td><input type=text name=indate value='$indate' maxlength=10 size=12> 예 : 2002/02/02, 정회원/준회원 등록일 공동</td></tr>\n";
    }else{
		echo "<input type=hidden name=membertype value='$membertype'>\n";
		echo "<input type=hidden name=grade value='$grade'>\n";
		echo "<input type=hidden name=disporder value='$disporder'>\n";
		echo "<input type=hidden name=gumpuno value='$gumpuno'>\n";
/*
		echo "
<tr><td>한미르회원광장</td><td>
ID:<input type=text name=hanmirid value='$hanmirid' maxlength=12 size=12>
Password:<input type=password name=hanmirpwd value='$hanmirpwd' maxlength=10 size=10> 한미르회원광장 접속용
</td></tr>\n";
*/
    }
	echo "
<tr><td>소감</td><td><input type=text name=etc value='$etc' maxlength=100 size=40 onChange='return checkLength(this.value,100)'></td></tr>\n
<tr><td colspan=2 align=center><input type=submit value='처리'></form>";

	if($mode == "member-update" && privcheck($logid) == 2){
		echo "
<form action='$PHP_SELF' method=post>\n
<input type=hidden name=mode value='member-delete'>\n
<input type=hidden name=userid value='$userid'>\n
<input type=submit value='삭제 처리'></form>";
	}

	echo "</td></tr>\n";
	echo "
</table>
";
}

?>
</center>
</body>
</html>
