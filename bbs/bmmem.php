<?php
/*
CREATE TABLE member (
  userid varchar(12) NOT NULL,
  passwd varchar(12) default '',
  name varchar(10),
  nickname varchar(20),
  sex char(1),
  juminno varchar(14),
  org varchar(30),
  orghref varchar(50),
  email varchar(30),
  postno varchar(7),
  postaddr varchar(60),
  photo varchar(15),
  telhome varchar(15),
  teloffice varchar(15),
  telhand varchar(15),
  size varchar(10),
  membertype varchar(10),
  grade varchar(12),
  disporder varchar(2) default '99',
  gumpuno smallint(5) unsigned,
  indate varchar(200), // ��ȸ�Ͽ��� ȸ�������� ���� ����(��ȸ��;��������������;ȸ������)
  boston varchar(50),
  birthdate varchar(10),
  birthtype char(1),
  birthsun varchar(5),
  bloodtype varchar(3),
  etc text,
  PRIMARY KEY (userid)
);

*/
require("./bmauth.php");
require("./bmconfig.php");
require("./bmfunction.php");

top("");
////

$photo_dir = substr($path2photo, strlen($home));

if($mode == "member-input"){
	heading("ȸ�� ���� ���");
	if(privcheck($logid) != 2){
		echo "�����ڸ� ��� ������ ����Դϴ�.";
	}else{
		member_display("member-insert","","","","","","","","","","","","","","","","","","","","","","","","","","","","","");
	}
}else if($mode == "member-select"){
	heading("ȸ�� ���� ����");

	if(privcheck($logid) != 2){
		die("�����ڸ� ��� ������ ����Դϴ�.");
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
	echo "<p><input type=submit value='����'>";
	echo "</form>";
	mysql_free_result($result);
	mysql_close() or die("mysql_close error");
}else if($mode == "member-change"){
	heading("���� ���� ����2");

	if($userid == "")
		$userid = $logid;
//	$dbquery="select userid, passwd, name, nickname, sex, juminno, org, orghref, email, postno, postaddr, photo, telhome, teloffice, telhand, size, membertype, grade, disporder, gumpuno, etc, hanmirid, hanmirpwd, boston, indate from member where userid='$userid'";
	$dbquery="select userid, passwd, name, nickname, sex, juminno, org, orghref, email, postno, postaddr, photo, telhome, teloffice, telhand, size, membertype, grade, disporder, gumpuno, etc, boston, indate, birthdate, birthtype, birthsun, bloodtype from member where userid='$userid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	if($row=mysql_fetch_array($result)){
		echo "������ �� �Ǵ� �׸��� '������������1'�� ����Ͻʽÿ�.\n";
		member_display("member-update",  $row[0], $row[1], $row[2], $row[3], $row[4], $row[5],
		 $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $row[12],
		 $row[13], $row[14], $row[15], $row[16], $row[17], $row[18], $row[19], $row[20], $row[21], $row[22], $row[23], $row[24],$row[25],$row[26],$row[27],$row[28]);
	}else{
		echo "<tr><td>'$name' ȸ���� ã�� ���� �����ϴ�.</td></tr>";
	}
	mysql_free_result($result);
	mysql_close() or die("mysql_close error");
}else if($mode == "member-insert"){
	heading("ȸ�� ���� ���");

	if($userid == ""){
		echo "userid�� �Է� �ٶ��ϴ�.<br><br>";
		echo "<a href='javascript:history.back();'>�ڷ�</a>";
		die("");
	}
	$dbquery="select userid, name from member where userid='$userid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$rows = mysql_num_rows($result);
	if($rows == 1){
		$row=mysql_fetch_array($result);
		echo "ID�� �ٸ� ȸ��($row[1])�� �ߺ��Դϴ�.<br><br>";
		echo "<a href='javascript:history.back();'>�ڷ�</a>";
		die("");
	}
	mysql_free_result($result);
	$dbquery="select userid, name from member where juminno='$juminno'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$rows = mysql_num_rows($result);
	if($rows == 1){
		$row=mysql_fetch_array($result);
		echo "�ֹε�Ϲ�ȣ�� �ٸ� ȸ��($row[1])�� �ߺ��Դϴ�.<br><br>";
		echo "<a href='javascript:history.back();'>�ڷ�</a>";
		die("");
	}
	mysql_free_result($result);

	if($photo != ''){
		$dbquery="select userid, name from member where photo='$photo'";
		$result = mysql_query($dbquery) or die("mysql_query error");
		$rows = mysql_num_rows($result);
		if($rows == 1){
			$row=mysql_fetch_array($result);
			echo "���� ���ϸ��� �ٸ� ȸ��($row[1])�� �ߺ��Դϴ�.<br><br>";
			echo "<a href='javascript:history.back();'>�ڷ�</a>";
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
	$query_value.="'" . jmchange(1, $juminno) . "',";

	$query_name.="birthdate,";
	$query_value.="'$birthdate',";
	$query_name.="birthtype,";
	$query_value.="'$birthtype',";
	$query_name.="birthsun,";
	$query_value.="'$birthsun',";

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

	$query_name.="bloodtype,";
	$query_value.="'$bloodtype$is_bloodnegative',";

	$query_name.="indate";
	$query_value.="'".date("Y/m/d").";��������������;ȸ������'"; // indate �ǹ̰� ��ȸ�Ͽ��� ȸ������(��ȸ��;��������������;ȸ������)�� ����

	$dbquery="insert into member ($query_name) values($query_value)";
echo "dbquery=$dbquery";
	$result = mysql_query($dbquery);

	//mysql_free_result($result);
//	mysql_close($connect);

	if($result!="1"){
		echo "��� �����Դϴ�.<br>";
		echo "<a href='javascript:history.back();'>�ڷ�</a>";
		die("");
	}else{
		echo "��� ó�� �Ϸ�.<br>";
	}

}else if($mode == "member-delete"){
	heading("ȸ�� ���� ����");
	if(privcheck($logid) != 2)
		$userid = '';
	if($membertype == "����ȸ��" || $membertype == "Ż��"){
		$dbquery="delete from member where userid = '".$userid."'";
		$result = mysql_query($dbquery) or die("mysql_query error");
		$dbquery="delete from record where userid = '".$userid."'";
		$result = mysql_query($dbquery) or die("mysql_query error");
	}else{
		/* name, userid, gumpuno, indate ������ �� �ڷ� ���� */
		$dbquery="update member set ";
		$dbquery.="nickname='',sex='',juminno=''".
		",org='',orghref='',email='',postno=''".
		",postaddr='',telhome='',teloffice='',telhand='',size='',etc='',photo='',boston=''".
		",membertype='Ż��',indate=CONCAT(DATE_FORMAT(now(), '%Y/%m/%d'),';$indate')".
			",grade='',disporder='',bloodtype='' where userid = '$userid'";
		$result = mysql_query($dbquery) or die("mysql_query error");
	}

	if($result=="1"){
		echo "$name ���� �Ϸ�";
	}else{
		echo "<font color=red>$name ���� ����</font>";
	}
}else if($mode == "member-update"){
	heading("���� ���� ����2");

	if(emailaddrcheck($email) == 0){
		echo ("E-mail�� ��Ȯ�� �Է��Ͽ� �ֽʽÿ�!<br><br>");
		echo "<a href='javascript:history.back();'>�ڷ�</a>";
		exit;
	}

	if($photo >= '0' and $photo <= '99'){
		$index = substr(date("i"), 1, 1);	// �� ���ڸ�
		if($index >= 5)
			$index = $index - 5;
		if($sex == "M")
			$samplename = "boy";
		else
			$samplename = "girl";
		$samplename = "$path2photo/$samplename".($index + 1).".jpg";
//echo $samplename;

		$photoname = $userid.".jpg";
		if(file_exists ("$path2photo/$photoname")){
			echo ("���� ���ϸ� �ڵ� ������ �ߺ� �����Դϴ�. ���ϸ��� �Է��Ͽ� �ֽʽÿ�!<br><br>");
			echo "<a href='javascript:history.back();'>�ڷ�</a>";
			exit;
		}
		$photo = $photoname;
		$photoname = "$path2photo/$photoname";
		$execret = exec("cp $samplename $photoname");
	}

	if($photo != $photoorg && $photo != ''){
		$dbquery2="select userid, name from member where photo='$photo' and userid != '$userid'";
		$result2 = mysql_query($dbquery2) or die("mysql_query error");
		$rows = mysql_num_rows($result2);
		if($rows >= 1){
			$row=mysql_fetch_array($result2);
			echo "���� ���ϸ��� �ٸ� ȸ��($row[1])�� �ߺ��Դϴ�.<br><br>";
			echo "<a href='javascript:history.back();'>�ڷ�</a>";
			die("");
		}
	}

	$dbquery="update member set ";
//	if($passwd != ""){
//		$dbquery.="passwd='$passwd',";
//	}

	$dbquery.="name='$name',nickname='$nickname',sex='$sex',juminno='".jmchange(1, $juminno)."'".
		",birthdate='$birthdate',birthtype='$birthtype',birthsun='$birthsun'".
		",org='$org',orghref='$orghref',email='$email',postno='$postno'".
		",postaddr='$postaddr',telhome='$telhome'".
		",teloffice='$teloffice',telhand='$telhand'".
//		",hanmirid='$hanmirid',hanmirpwd='$hanmirpwd'".
		",size='$size',bloodtype='$bloodtype$is_bloodnegative',etc='$etc'";
	if(privcheck($logid) == 2){
		$dbquery.=",membertype='$membertype',photo='$photo',boston='$boston'".
			",grade='$grade',disporder='$disporder',indate='$indate'";
//		if($gumpuno != "")		// �ִ� �ڷ� �ڿ� �� �ʿ�
			$dbquery.=",gumpuno='$gumpuno'";
	}
	$dbquery.=" where userid = '$userid'";
//echo "dbquery=$dbquery";
	$result = mysql_query($dbquery) or die("mysql_query error");

	if($result=="1"){
		echo "$name ���� �Ϸ�";
	}else{
		echo "<font color=red>$name ���� ����</font>";
	}
}else if($mode == "idpasswd-change"){
	heading("��ȣ ���� ����");
	echo "
		<form action='$PHP_SELF' method=post>
		<input type=hidden name=mode value=idpasswd-update>
<table>
<tr>
  <td>���� ��ȣ</td>
  <td><input type=password name=passwdold size=12></td>
<td rowspan=3><input type=submit value='����'></td>
</tr>
<tr>
  <td>���ο� ��ȣ</td>
  <td><input type=password name=passwd size=12></td>
</tr>
<tr>
  <td>�ѹ��� �Է�</td>
  <td><input type=password name=passwd2 size=12></td>
</tr>
</table>
		</form>
		";
}else if($mode == "idpasswd-update"){
	if($passwd == "" || $passwd != $passwd2){
		heading("��ȣ ���� ���� ����");
		die("�Է��� ��ȣ�� �̻��մϴ�.");
	}
	heading("��ȣ ���� ����");
	if(strstr($passwd, "'") != false){
		echo "�н����忡 �ش� Ư�����ڸ� ����� �� �����ϴ�.";
		die("");
	}
	$dbquery="select userid, passwd from member where userid='$logid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$rows = mysql_num_rows($result);
	if($rows >= 1){
		$row=mysql_fetch_array($result);
		if($row[1] != $passwdold){
			echo "<font color=red>��ȣ ���� �Ұ�(�н����� ����ġ)</font>";
			exit();
		}
	}else{
		echo "<font color=red>��ȣ ���� �Ұ�(�����ID ����ġ)</font>";
		exit();
	}
	mysql_free_result($result);

	$dbquery="update member set passwd='$passwd' where userid='$logid'";
	$result = mysql_query($dbquery) or die("mysql_query error");

	if($result=="1"){
		echo "��ȣ ���� �Ϸ�";
	}else{
		echo "<font color=red>��ȣ ���� ����</font>";
	}
}else if($mode == "photo-upload-set-org"){
	heading("�󱼻��� ���ε�");

	echo "
<FORM ENCTYPE='multipart/form-data' ACTION='$PHP_SELF' METHOD=POST>
<INPUT TYPE='hidden' name='MAX_FILE_SIZE' value='20480'>
<INPUT TYPE='hidden' name='mode' value='photo-upload-save'>
���� ���� ����: <INPUT NAME='userfile' TYPE='file'><br><br>\n";
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
	echo "<INPUT TYPE='submit' VALUE='���� ���ε� �ϱ�'>
</FORM>
* ���� : ���� ũ��(pixel)�� 150 x 200, ������� 30K ����, jpg ���ϸ� ���ε� �����մϴ�.";

//	phpinfo();
}else if($mode == "photo-upload-set"){
	heading("�󱼻��� ���ε� �׽�Ʈ");

	echo "
<FORM ENCTYPE='multipart/form-data' id=frmphoto name=frmphoto ACTION='$PHP_SELF' METHOD=POST>
<INPUT TYPE='hidden' name='MAX_FILE_SIZE' value='30720'>
<INPUT TYPE='hidden' name='mode' value='photo-upload-save'>
���� ���� ����: <INPUT id=userfile NAME='userfile' TYPE='file' onChange='imgLoad(this.value, 30720)'><br><br>\n";
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
	echo "<INPUT TYPE='submit' VALUE='���� ���ε� �ϱ�' >
</FORM>
* ���� : ���� ũ��(pixel)�� 150 x 200, ������� 30K ����, jpg ���ϸ� ���ε� �����մϴ�.<br>";

	dispJavaScript();
	
//	phpinfo();
}else if($mode == "photo-upload-save"){
	heading("�󱼻��� ���ε�");

//	echo "�������Դϴ�.";
//	return;
/*

	if($HTTP_POST_FILES[file1]) {
		$file1 = $HTTP_POST_FILES[file1][tmp_name];
		$file1_name = $HTTP_POST_FILES[file1][name];
		$file1_size = $HTTP_POST_FILES[file1][size];
		$file1_type = $HTTP_POST_FILES[file1][type];
	}

	if($file1_size>0&&$setup[use_pds]&&$file1) {

		if(!is_uploaded_file($file1)) Error("�������� ������� ���ε� ���ּ���");
		if($file1_name==$file2_name) Error("���� ������ ����Ҽ� �����ϴ�");
		$file1_size=filesize($file1);

		if($setup[max_upload_size]<$file1_size&&!$is_admin) error("ù��° ���� ���ε�� �ְ� ".GetFileSize($setup[max_upload_size])." ���� �����մϴ�");

		// ���ε� ����
		if($file1_size>0) {
			$s_file_name1=$file1_name;
			if(eregi("\.inc",$s_file_name1)||eregi("\.phtm",$s_file_name1)||eregi("\.htm",$s_file_name1)||eregi("\.shtm",$s_file_name1)||eregi("\.ztx",$s_file_name1)||eregi("\.php",$s_file_name1)||eregi("\.dot",$s_file_name1)||eregi("\.asp",$s_file_name1)||eregi("\.cgi",$s_file_name1)||eregi("\.pl",$s_file_name1)) Error("Html, PHP ���������� ���ε��Ҽ� �����ϴ�");

			//Ȯ���� �˻�
			if($setup[pds_ext1]) {
				$temp=explode(".",$s_file_name1);
				$s_point=count($temp)-1;
				$upload_check=$temp[$s_point];
				if(!eregi($upload_check,$setup[pds_ext1])||!$upload_check) Error("ù��° ���ε�� $setup[pds_ext1] Ȯ���ڸ� �����մϴ�");
			}

			$file1=eregi_replace("\\\\","\\",$file1);
			$s_file_name1=str_replace(" ","_",$s_file_name1);
			$s_file_name1=str_replace("-","_",$s_file_name1);

			// ���丮�� �˻���
			if(!is_dir("data/".$id)) {
				@mkdir("data/".$id,0777);
				@chmod("data/".$id,0706);
			}

			// �ߺ������� ������;;
			if(file_exists("data/$id/".$s_file_name1)) {
				@mkdir("data/$id/".$reg_date,0777);
				if(!move_uploaded_file($file1,"data/$id/".$reg_date."/".$s_file_name1)) Error("���Ͼ��ε尡 ����� ���� �ʾҽ��ϴ�");
				$file_name1="data/$id/".$reg_date."/".$s_file_name1;
				@chmod($file_name1,0706);
				@chmod("data/$id/".$reg_date,0707);
			} else {
				if(!move_uploaded_file($file1,"data/$id/".$s_file_name1)) Error("���Ͼ��ε尡 ����� ���� �ʾҽ��ϴ�");
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
		echo "jpg ���� ���ϸ� ���ε� �����մϴ�.";
		exit;
	}
	if($userfile_size>(1024*30)){
		echo "���� ������ �ʹ� Ů�ϴ�. 30K ���Ϸ� ���� �� ���ε��Ͻʽÿ�.";
		exit;
	}
	$photosize = GetImageSize ($userfile);
	if($photosize[0] > 150 || $photosize[1] > 200){
		echo "���� ���� ������($photosize[0] x $photosize[1])�� 150 x 200 ���� ���� ���� �� ���ε��Ͻʽÿ�.";
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
			echo "���� ���ϸ� DB ���� ����";
			exit;
		}
		//mysql_free_result($result);
	}
//echo "userfile=$userfile photofile=$photofile ";
	if(!move_uploaded_file($userfile, "$path2photo/$photofile")){
		echo "move_uploaded_file() error\n";
		print_r($_FILES);
	}else{
		chmod("$path2photo/$photofile", 0777);
		echo "���� ����($userfile_name -> $photofile) ���ε� �Ϸ�";
	}

}else if($mode == "racephoto-upload-set"){
	heading("��ȸ ���� ���ε�/����");

	echo "<font size='+2'>��ȸ ���� ���ε�</font><p>";
	require("./bmfunc_nextimg.php");

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
		echo "������ ������ Directory�� �����ϴ�.";
		exit;
	}
//echo "imgno=$imgnos ";

	echo "
<FORM ENCTYPE='multipart/form-data' name=frmracephoto ACTION='$PHP_SELF' METHOD=POST>
<INPUT TYPE='hidden' name='MAX_FILE_SIZE' value='214800'>
<INPUT TYPE='hidden' name='mode' value='racephoto-upload-save'>
���� ���� ����: <INPUT NAME='userfile' TYPE='file' onChange='imgLoad(this.value, 214800)'><br><br>\n";
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
	echo "
��ȸ : <select name='savedir' size='1' style='background-color: white; color: blue; font:10pt'>
<option value='null'>��ȸ ����</option>\n";
	for($i=0; $i < $imgnos; $i++){
echo dirname($filesArray[$i])." ";
		$path = substr(dirname($filesArray[$i]),strlen(substr($path2racephoto, strlen($home))));
		if(strlen($path)>0)
			echo "<option value='$path'>$path</option>\n";
	}
	echo "
</select><br><br>
<INPUT TYPE='submit' VALUE='��ȸ���� ���ε� �ϱ�'>
</FORM>
* ���� : ���� ũ��(pixel)�� 400 x 500, ������� 200K ����, jpg ���ϸ� ���ε� �����մϴ�.<br>";

	dispJavaScript();

    if(privcheck($logid) == 2){
	echo "<br><br><font size='+1'>���� ���� ��ȸ ����(������ ���)</font><br>";
	echo "<form name=form1 method=post action='$PHP_SELF'>
<input type=hidden name='mode' value='racephoto-makedir'>
<input type=hidden name='raceid'>
<input type=text name=racename size=50 value='�� �Ʒ����� ��ȸ�� ������ �Ʒ��� ��ȸ ������ �����ʽÿ�.'><br>
<input type=submit onClick=\"if(this.form.raceid.value==''){ alert('�Ʒ����� ��ȸ�� �����Ͻʽÿ�.'); return false;}\" value='��ȸ ����'>
</form>\n";
	}

	echo "<p><br><br><font size='+2'>��ȸ ���� ����</font><p>";

	$dbquery="select name from member where userid='$logid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$row=mysql_fetch_array($result);
	$name = $row[0];

	echo "
<FORM ENCTYPE='multipart/form-data' ACTION='$PHP_SELF' METHOD=POST>
<INPUT TYPE='hidden' name='mode' value='racephoto-upload-delete'>\n";
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
	echo "
��ȸ : <select name='racedir' size='1' style='background-color: white; color: blue; font:10pt'>\n";
	echo "<option value='null'>���� ���� ����</option>\n";
	for($i=0; $i < $imgnos; $i++){
		$fname = "$home".dirname($filesArray[$i])."/$name.jpg";
echo "fname=$fname ";
		if(is_file($fname)){
			$path = substr(dirname($filesArray[$i]), 17);
			echo "<option value='$path'>$path</option>\n";
		}
	}
	echo "</select><br><br>
<INPUT TYPE='submit' VALUE='��ȸ���� ����'>
</FORM>";

}else if($mode == "racephoto-upload-save"){
	heading("��ȸ���� ���ε�");
/*
echo "name=".$_FILES['userfile']['name'];
echo " tmp_name=".$_FILES['userfile']['tmp_name'];
echo " type=".$_FILES['userfile']['type'];
echo " size=".$_FILES['userfile']['size'];
echo " error=".$_FILES['userfile']['error'];
*/

if(is_uploaded_file($_FILES[userfile][tmp_name])) echo "O"; else echo "X";

	if($savedir == "null"){
		echo "������ ������ ��ȸ�� �������� �ʾҽ��ϴ�.";
		exit;
	}
	if(SubStr(strtolower($userfile_name), strlen($userfile_name)-4) != ".jpg"){
		echo "jpg ���� ���ϸ� ���ε� �����մϴ�.";
		exit;
	}
	if($userfile_size>(1024*200) || $userfile == "none"){
		echo "���� ������ �ʹ� Ů�ϴ�. 200K ���Ϸ� ���� �� ���ε��Ͻʽÿ�.";
		exit;
	}
	$photosize = GetImageSize ($userfile);
//echo " userfile=$userfile userfile_name=$userfile_name userfile_size=$userfile_size $photosize[0],$photosize[1] ";

	if($photosize[0] > 400 && $photosize[1] > 500){
		echo "<font color=red>���� ���� ����� 400 x 500 ���� �۰� ���� �� ���ε��Ͻʽÿ�.</font>";
		exit;
	}

	if(PrivCheck($logid) == 2 && $userid > ' '){
	}else{
		$userid = $logid;
	}
	$dbquery="select userid, name, photo from member where userid='$userid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$row=mysql_fetch_array($result);
//echo " check�� $_FILES 1.$path2racephoto$savedir/$row[1].jpg 2.$userfile 3.$userfile_name 4.$photosize[0]";
	if(!move_uploaded_file($_FILES['userfile']['tmp_name'], "$path2racephoto$savedir/$row[1].jpg")){
		echo "move_uploaded_file() error\n".error("move_uploaded_file()");
	}else{
		chmod("$path2racephoto$savedir/$row[1].jpg",0606);
		echo "��ȸ���� ���� ���ε� �Ϸ�";
	}

}else if($mode == "racephoto-upload-delete"){
	heading("��ȸ���� ����");

	if($racedir == "null"){
	 	echo "������ ��ȸ�� �����Ͻʽÿ�.";
		echo "<br><a href='javascript:history.back()'>��������</a>";
		die("");
	}
	if(privcheck($logid) == 2 && $userid > ' '){
	}else{
		$userid = $logid;
	}
	$dbquery="select name from member where userid='$userid'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$row=mysql_fetch_array($result);
	$name = $row[0];

	if(!unlink("$path2racephoto$racedir/$name.jpg")){
		echo "unlink error:$path2racephoto$racedir/$name.jpg";
	}else{
		echo "��ȸ���� ���� ���� �Ϸ�";
	}
}else if($mode == "racephoto-makedir"){
	heading("���� ���� ��ȸ ����");

	if(privcheck($logid) != 2){
		echo "��ȸ�� ������ �� �����ϴ�.\n";
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
        	$dir = "$path2racephoto/$year/$month$day-$shortname";
        	if(!mkdir($dir, 0707)){
			echo "Directory ���� ����($dir)\n";
			return;
		}
		chmod($dir, 0707);
		if (!copy("$path2racephoto/DirIsUsed", $dir."/DirIsUsed")) {
			print ("DirIsUsed file�� �����ϴµ� �����߽��ϴ�.<br>\n");
		}else{
			chmod($dir."/DirIsUsed", 0707);
			echo "���� ���� ��ȸ ���� �Ϸ�";
		}

        }else{
                echo "<tr><td>'$name' ��ȸ�� ã�� ���� �����ϴ�.</td></tr>";
        }
        mysql_free_result($result);

}else if($mode == "chuka"){
	heading("���� ���� ó��");

	if($type == "insert"){
		$dbquery="insert into chuka (name,memo,in_date,end_date,userid) values";
		$dbquery.="('$name','$memo',now(),'$end_date','$logid')";
//echo "dbquery=$dbquery";
		$result = mysql_query($dbquery) or die("mysql_query chuka insert error");
	}else if($type == "delete"){
		$dbquery="delete from chuka where no = $no";
		if(privcheck($logid) != 2){
			$dbquery .= " and userid = '$logid'";
		}
		$result = mysql_query($dbquery) or die("mysql_query chuka delete error");
	}

	echo "
<table border=1>
<tr>
  <th>���ȸ��</th>
  <th>���ϳ���</th>
  <th>�Է���</th>
  <th>����������</th>
  <th>ó��</th>
</tr>\n";
	echo "<tr>
		<form action='$PHP_SELF' method=post>
		<input type=hidden name=mode value=chuka>
		<input type=hidden name=type value=insert>
  <td><select name='name' size='1' style='background-color: white; color: blue; font:10pt'>\n";
	$dbquery="select name from member order by name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	echo "<option value='�д縶����Ŭ��'>�츮 Ŭ��</option>\n";
	while($row=mysql_fetch_array($result)){
		echo "<option value='$row[0]'>$row[0]</option>\n";
	}
	echo "   </select>��</td>
  <td><input type=text name=memo size=28 maxlength=30></td>
  <td></td>
  <td><input type=text name=end_date size=10></td>
<td><input type=submit value='�߰�'></td>
</tr>
<tr><td colspan=4>
* ������������ �Է����� �ʾƵ� �˴ϴ�.<br>
* ��ȭ������ �󸶵��� ȯ���մϴ�. �δ� ���� �Է��Ͻʽÿ�.
</tr>
		</form>\n";

	if(privcheck($logid) == 2){
		$wherestr = "";
	}else{
		$wherestr = "where userid='$logid'";
	}
	$dbquery="select no,name,memo,in_date,end_date from chuka $wherestr order by in_date desc";
	$result = mysql_query($dbquery) or die("mysql_query chuka select error");
	for(; $row=mysql_fetch_array($result); ){
	        echo "<tr><td>$row[1]<td>$row[2]<td>$row[3]<td>$row[4]\n";
	        echo "<td><form action='$PHP_SELF' method=post>
		<input type=hidden name=mode value=chuka>
		<input type=hidden name=type value=delete>
		<input type=hidden name=no value=$row[0]>
	        <input type=submit value='����'>
	        </tr></form>\n";
	}
	echo "
</table>\n";

}else if($mode == "submenu"){
	heading("�������� �޴�");
	echo "";
	echo "
	<a href='member_modify.php?group_no=1'>������������1</a><br>
	<a href='bmmem.php?mode=member-change'>������������2</a><br>
	<a href='bmmem.php?mode=photo-upload-set'>ȸ���ȳ���󱼻������ε�</a><br>
	<a href='bmmem.php?mode=racephoto-upload-set'>��ȸ�������ε�</a><br>";
}else{
	heading("�ش� ����� �����ϴ�.");
	exit;
}

function dispJavaScript()
{

?>
<span id=ShowImg name=ShowImg></span>
<script language='JavaScript'>
// photogallery �ݿ��� ���� skin/DQ_Revolution_Gallery/write.js �� �߰���
var warningalert = 0;
function imgLoad(filepathvalue, maxsize)
{
	var strT = new String();
	document.getElementById("ShowImg").innerHTML= "";
//	strT = document.frmphoto.userfile.value;
//	strT = filepath.value;
	strT = filepathvalue;
	if(strT != "")
	{
		strT = "<img id='PhotoSample' src='" + strT + "' width='100'></img>";
		document.getElementById("ShowImg").innerHTML= strT;
		if(!LimitedSize(maxsize))
		{
			alert("********** ���**********\n���� ũ�Ⱑ " + maxsize + " �ʰ���. \n�ݵ�� �̹����� ���� �� ��� �ٶ�. \n�׷��� ���� ���  �Է��۾��� ��ҵ�.");
			document.getElementById("ShowImg").innerHTML= "";
//			document.getElementById("userfile").value = "";
		}else{
			if(warningalert == 1)
				alert('���� ũ�� �̻� ����');
			warningalert = 0;
		}
	}
}

function LimitedSize(maxfilesize)
{
	var i;
	var y = document.images;
	for (i=0;i<y.length;i++)
	{
		if((y[i].id) == 'PhotoSample')
		{ 
			if(y[i].fileSize == -1){
				alert('���� ũ�� Ȯ��');
				warningalert = 1;
			}
			if(y[i].fileSize > maxfilesize){
				return false;
			}
			if(y[i].fileWidth * y[i].fileHeight > 2000000){
				alert('200�� ȭ�� �̻�');
				return false;
			}
		}
	}
	return true;
}
</script>
<?php

}

// function member_display($mode, $userid, $passwd, $name, $nickname, $sex, $juminno, $org, $orghref, $email, $postno, $postaddr, $photo, $telhome, $teloffice, $telhand, $size, $membertype, $grade, $disporder, $gumpuno, $etc, $hanmirid, $hanmirpwd, $boston, $indate){
function member_display($mode, $userid, $passwd, $name, $nickname, $sex, $juminno, $org, $orghref, $email, $postno, $postaddr, $photo, $telhome, $teloffice, $telhand, $size, $membertype, $grade, $disporder, $gumpuno, $etc, $boston, $indate, $birthdate, $birthtype, $birthsun, $bloodtype){

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
<tr><td>�����ID</td><td>$userid</td></tr>\n
<input type=hidden name=userid value='$userid'>\n";
//		if($logid == $userid){
//			echo "
//<tr><td>��ȣ</td><td><input type=password name=passwd value='$passwd' maxlength=10 size=10></td></tr>\n";
//		}
	}else{
		echo "
<tr><td>�����ID</td><td><input type=text name=userid value='$userid' maxlength=12 size=12> �����ҹ���/���ڷ� �ۼ�</td></tr>\n
<tr><td>��ȣ</td><td><input type=text name=passwd value='3456' maxlength=10 size=10>����Ʈ�� : 3456</td></tr>\n";
	}
	echo "
<tr><td>�̸�</td><td>$name<input type=hidden name=name value='$name' maxlength=10 size=10></td></tr>\n
<tr><td>����</td><td><input type=text name=nickname value='$nickname' maxlength=20 size=20></td></tr>\n
<tr><td>����</td><td>
<input type='radio' name='sex' value='M' $sexm>��(Male)
<input type='radio' name='sex' value='F' $sexf>��(Female)
</td></tr>\n";
if($juminno=="")
	$juminno="xxxxxx-yyyyyyy";
if($birthdate=="")
	$birthdate = "19yy.mm.dd";
if($birthtype=="" || $birthtype=="0")
	$birthtype0 = "checked";
else
	$birthtype1 = "checked";
if(($len = strlen($bloodtype))>=2 && substr($bloodtype, $len-1) == "-"){
	$is_bloodnegative = "checked";
	$bloodtype = substr($bloodtype, 0, $len-1);
}
if($bloodtype=="A")
	$bloodtypeA = "checked";
elseif($bloodtype=="B")
	$bloodtypeB = "checked";
elseif($bloodtype=="B")
	$bloodtypeB = "checked";
elseif($bloodtype=="O")
	$bloodtypeO = "checked";
elseif($bloodtype=="AB")
	$bloodtypeAB = "checked";
else{
	$bloodtypeUK = "checked";
	$is_bloodnegative = "";
}
$juminno=jmchange(2,$juminno);

echo "
<tr><td>�ֹι�ȣ</td><td><input type=text name=juminno value='$juminno' maxlength=14 size=20>��ȣȭ �� ����. �ֹι�ȣ�� ��ü ��û�� Ȱ��</td></tr>\n
<tr><td>�������</td><td><input type=text name=birthdate value='$birthdate' maxlength=10 size=10><input type=radio name=birthtype value=0 $birthtype0>��� <input type=radio name=birthtype value=1 $birthtype1>���� &nbsp;&nbsp;��»���(mm.dd)<input type=text name=birthsun value='$birthsun' maxlength=5 size=5>
</td></tr>\n
<tr><td>������</td><td><input type=radio name=bloodtype value=A $bloodtypeA>A &nbsp;&nbsp;<input type=radio name=bloodtype value=B $bloodtypeB>B &nbsp;&nbsp;<input type=radio name=bloodtype value=AB $bloodtypeAB>AB &nbsp;&nbsp;<input type=radio name=bloodtype value=O $bloodtypeO>O &nbsp;&nbsp;<input type=radio name=bloodtype value=UK $bloodtypeUK>�� &nbsp;&nbsp;&nbsp;<input type=checkbox value='-' name=is_bloodnegative $is_bloodnegative> \"Rh-\"�̸� üũ�ϼ���.
</td></tr>\n
<tr><td>�����</td><td>$org<input type=hidden name=org value='$org' maxlength=30 size=30 onChange='return checkLength(this.value,30)'></td></tr>\n
<tr><td>����/����Ȩ�ּ�</td><td>$orghref<input type=hidden name=orghref value='$orghref' maxlength=50 size=40 onChange='return checkLength(this.value,50)'></td></tr>\n
<tr><td>E-Mail �ּ�</td><td>$email<input type=hidden name=email value='$email' maxlength=30 size=30 onChange='return checkLength(this.value,30)'></td></tr>\n
<tr><td>�����ȣ</td><td><input type=text name=postno value='$postno' maxlength=7 size=8></td></tr>\n
<tr><td>�ּ�</td><td>$postaddr<input type=hidden name=postaddr value='$postaddr' maxlength=60 size=40 onChange='return checkLength(this.value,60)'></td></tr>\n
";

	if(privcheck($logid) == 2){
		echo "
<tr><td>�������ϸ�</td><td><input type=text name=photo value='$photo' maxlength=15 size=20></td></tr>\n
";
		echo "<input type=hidden name=photoorg value='$photo'>\n";
	}else{
		echo "<input type=hidden name=photo value='$photo'>\n";
		echo "<input type=hidden name=photoorg value='$photo'>\n";
	}
	echo "
<tr><td>��ȭHome</td><td>$telhome<input type=hidden name=telhome value='$telhome' maxlength=15 size=20></td></tr>\n
<tr><td>��ȭOffice</td><td>$teloffice<input type=hidden name=teloffice value='$teloffice' maxlength=15 size=20></td></tr>\n
<tr><td>��ȭHand</td><td>$telhand<input type=hidden name=telhand value='$telhand' maxlength=15 size=20></td></tr>\n
<tr><td>Ƽ����������</td><td>";

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
<tr><td>ȸ������</td><td>";
	if($membertype == ""){
		$membertype = "����ȸ��";
	}
	echo "<input type=hidden name=membertype value='$membertype'>\n";

/*
	echo "<select name='membertype' size='1'  style='background-color: white; color: blue; font:10pt'>";

	$mtarray = array("��ȸ��","��ȸ��","����ȸ��","�޸�ȸ��","OBȸ��","Ż��");
	for($i=0; $i<count($mtarray); $i++){
		if($mtarray[$i] == $membertype)
			echo "<option value='$mtarray[$i]' selected>$mtarray[$i]</option>";
		else
			echo "<option value='$mtarray[$i]'>$mtarray[$i]</option>";
	}
	echo "</select>";
*/
	echo $membertype;
	if($disporder == "")
		$disporder = "99";
	echo "</td></tr>\n
<tr><td>��å</td><td><input type=text name=grade value='$grade' maxlength=12 size=20>ȸ��, ��ȸ��,... �����</td></tr>\n
<tr><td>ǥ�ü���</td><td><input type=text name=disporder value='$disporder' maxlength=2 size=3><font size='-1'>1:ȸ��,2:��ȸ��,3:��ȹ,4:�Ʒ�,5:Ȩ,6:�ѹ�,7:�����,8:��Ÿ,99:��ȸ�� ��</font></td></tr>\n
<tr><td>ȸ����ȣ</td><td><input type=text name=gumpuno value='$gumpuno' maxlength=4 size=5></td></tr>\n";
/*
		if($logid != $userid){
			echo "<input type=hidden name=hanmirid value='$hanmirid'>\n";
			echo "<input type=hidden name=hanmirpwd value='$hanmirpwd'>\n";
		}else{
			echo "
<tr><td>�ѹ̸�ȸ������</td><td>
ID:<input type=text name=hanmirid value='$hanmirid' maxlength=12 size=12>
Password:<input type=password name=hanmirpwd value='$hanmirpwd' maxlength=10 size=10> �ѹ̸�ȸ������ ���ӿ�
</td></tr>\n";
		}
*/
//	echo "<tr><td>�������Ͽ���</td><td><input type=text name=boston value='$boston' maxlength=30 size=30> ���� ��� ��� ���� (��:1999-2001,2002A,2003; ������ ��� A ����)</td></tr>\n";
	echo "<tr><td>��������������</td><td><input type=text name=boston value='$boston' maxlength=30 size=30> (2002A : 2002�⿡ ������ ���)</td></tr>\n";
	if($mode == "member-update"){
		echo "<tr><td>ȸ��������������</td><td><input type=text name=indate value='$indate' maxlength=200 size=33><font size='-1'>�� �� ��¥ �������� ȸ���������泻���� ǥ�õ˴ϴ�.<br>[[��ȸ����;]��ȸ����;]��ȸ��;��������������;ȸ������ (yyyy/mm/dd)</font></td></tr>\n";
	}else{
		echo "<input type=hidden name=indate value=''>\n";
	}
    }else{
		echo "<input type=hidden name=membertype value='$membertype'>\n";
		echo "<input type=hidden name=grade value='$grade'>\n";
		echo "<input type=hidden name=disporder value='$disporder'>\n";
		echo "<input type=hidden name=gumpuno value='$gumpuno'>\n";
/*
		echo "
<tr><td>�ѹ̸�ȸ������</td><td>
ID:<input type=text name=hanmirid value='$hanmirid' maxlength=12 size=12>
Password:<input type=password name=hanmirpwd value='$hanmirpwd' maxlength=10 size=10> �ѹ̸�ȸ������ ���ӿ�
</td></tr>\n";
*/
    }
	echo "
<tr><td>�Ұ�</td><td>$etc<!-- <textarea cols=60 rows=4 name=etc>$etc</textarea> --></td></tr>\n
<tr><td colspan=2 align=center><input type=submit value='���� ó��'></form>";

	if($mode == "member-update" && privcheck($logid) == 2){
		echo "
<form action='$PHP_SELF' method=post>\n
<input type=hidden name=mode value='member-delete'>\n
<input type=hidden name=userid value='$userid'>\n
<input type=hidden name=membertype value='$membertype'>\n
<input type=hidden name=indate value='$indate'>\n
<input type=submit value='���� ó��'></form><br><font color=red>* ��޺����� �Խ��� ������ ����� �̿� �ٶ��ϴ�.<br>* ���� : ����ȸ���� �ٷ� ���� �ǰ�, �� �� ȸ���� Ż��� �����Ǹ� �ѹ� �� �����ϸ� �ڷᰡ ���� ���ŵ˴ϴ�.</font>";
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
