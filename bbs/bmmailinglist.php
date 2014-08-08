<?php

require("./bmauth.php");
require("./bmconfig.php");
require("./bmfunction.php");

top("");
    ////
if($mode == "ml-input-new"){
	heading("Bundang Marathon Mailing List 신규 등록");
	ml_display("ml-insert","","","","","","","","","","","",$logid);
}else if($mode == "ml-input-old"){
	heading("Bundang Marathon Mailing List 삭제 요청");
	ml_display("ml-deleterequest","","","","","","","","","","","",$logid);
}else if($mode == "ml-insert"){
	heading("Bundang Marathon Mailing List 신규 등록");

	if($email == ""){
		echo "e-mail 주소를 입력 바랍니다.<br><br>";
		echo "<a href='javascript:history.back();'>뒤로</a>";
		die("");
	}
	if($name == ""){
		echo "이름을 입력 바랍니다.<br><br>";
		echo "<a href='javascript:history.back();'>뒤로</a>";
		die("");
	}
	$dbquery="select name from mailinglist where email='$email'";
	$result = mysql_query($dbquery);
	$rows = mysql_num_rows($result);
	if($rows == 1){
		$row=mysql_fetch_array($result);
		if($row[0] == $name){
			echo "이미 등록하신 E-Mail 주소입니다.<br>";
		}else{
			echo "다른 분이 이미 등록하신 E-Mail 주소입니다.<br>";
		}
		mysql_free_result($result);
	}else{
		$query_name="";
		$query_value="";

		$query_name.="email,";
		$query_value.="'".$email."',";
		$query_name.="name,";
		$query_value.="'".$name."',";

		srand((double)microtime()*1000000);
		$randno = rand (100000000,999999999);
		$query_name.="randno";
		$query_value.="'".$randno."'";

		$dbquery="insert into mailinglist ($query_name) values($query_value)";

		$result = mysql_query($dbquery);

		if($result!="1"){
			echo "E-Mail 주소 등록 오류입니다.<br>";
		}else{
			echo "Mailing List 등록 처리 완료.<br>";
		}
	}
// mail send **************************************************************

}else if($mode == "ml-batch"){
	heading("Bundang Marathon Mailing List Batch 등록");

//	$dbquery="select name, email from reg2002 where email>='0'";
	$dbquery="select name, email from member";
	$result = mysql_query($dbquery);
		
	while($row=mysql_fetch_array($result)){
		$query_name="";
		$query_value="";
		if($row[1] == '')
			continue;

		$query_name.="email,";
		$query_value.="'".$row[1]."',";
		$query_name.="name,";
		$query_value.="'".$row[0]."',";

		srand((double)microtime()*1000000);
		$randno = rand (100000000,999999999);
		$query_name.="randno";
		$query_value.="'".$randno."'";

		$dbquery="insert into mailinglist ($query_name) values($query_value)";

		$result2 = mysql_query($dbquery);

		if($result2 != "1"){
			echo "E-Mail 주소($row[1]) 등록 오류입니다.<br>";
		}
	}
	echo "Mailing List 등록 처리 완료.<br>";
	mysql_free_result($result);
// mail send **************************************************************

}else if($mode == "ml-deleterequest"){
	heading("Bundang Marathon Mailing List 정보 삭제 요청");

	if($email == ""){
		echo "e-mail 주소를 입력 바랍니다.<br><br>";
		echo "<a href='javascript:history.back();'>뒤로</a>";
		die("");
	}

	$dbquery="select name, randno from mailinglist where email='$email'";
	$result = mysql_query($dbquery);
	$rows = mysql_num_rows($result);
	if($rows != 1){
		echo "입력하신 E-Mail 주소는 등록되어 있지 않습니다.<br>";
		mysql_free_result($result);
		die("");
	}
	$row=mysql_fetch_array($result);

	$receiver = "\"$row[0]\"<$email>";
	$cont = "<p align=center>Bundang Marathon Mailing List에서 귀하의 E-Mail 주소를 삭제하시려면 아래 링크를 클릭해 주십시오.\n";
	$cont .= "<br>(Please click 'Delete' button if you want to delete your email account from bundang marathon club mailing-list)\n";
	$headers = "From: \"분당마라톤\" <$managerEmail>\n";
//	$headers .= "X-Sender: <$managerEmail>\n";
//	$headers .= "X-Priority: 1\n"; // Urgent message!
	$headers .= "Return-Path: <$managerEmail>\n";  // Return path for errors
	$headers .= "Content-Type: text/html; charset=iso-8859-1\n"; // Mime type

//	$cont.= "<p align=center><font size='+2'><a href=\"http://$HTTP_HOST$PHP_SELF?mode=ml-delete&email=".urlencode($email)."&randno=$row[1]\">삭제</a></font>\n";
	$cont.= "<p align=center><font size='+2'>\n";
	$cont.= "<form method=post action=\"http://$HTTP_HOST$PHP_SELF\">\n";
	$cont.= "<input type=hidden name=mode value=ml-delete>\n";
	$cont.= "<input type=hidden name=email value=$email>\n";
	$cont.= "<input type=hidden name=randno value=$row[1]>\n";
	$cont.= "<input type=submit value=\"Delete\">\n";
	$cont.= "</form>\n";
	$cont.= "</font>\n";
	if(mail($receiver, "Bundang Marathon Mailing List 정보 삭제", $cont, $headers) == FALSE){
		echo "mail 발송 에러\n";
		die("");
	}
//echo $cont;
	echo "지정하신 E-Mail 주소로 삭제 확인 메일을 발송했습니다.<br><br>잠시 후 메일을 확인해 주시기 바랍니다.\n";

}else if($mode == "ml-delete"){
	heading("Bundang Marathon Mailing List 정보 삭제");

	$dbquery="select name from mailinglist where email='$email' and randno='$randno'";
	$result = mysql_query($dbquery);
	$rows = mysql_num_rows($result);
	if($rows != 1){
		echo "삭제 요구하신 E-Mail 주소는 등록되어 있지 않습니다.<br>";
		mysql_free_result($result);
		die("");
	}

	$dbquery="delete from mailinglist where email='$email' and randno='$randno'";
	$result = mysql_query($dbquery) or die("mysql_query error");
echo $result;
	if($result=="1"){
		echo "<table width=300><tr><td>";
		echo "$email 삭제 완료<br><br>나중에 분당마라톤클럽에 관심을 가지시게 되면 홈페이지(www.bundangmarathon.com)에서 다시 가입해 주시기 바랍니다.";
		echo "</td></tr></table>";
	}else{
		echo "<font color=red>$email 삭제 오류</font>";
	}
}else{
	heading("Bundang Marathon Mailing List 메뉴");

	echo "<p><a href='$PHP_SELF?mode=ml-input-new'>Bundang Marathon Mailing List 신규 등록</a><p>\n";
	echo "<p><a href='$PHP_SELF?mode=ml-input-old'>Bundang Marathon Mailing List 삭제 요청</a><p>\n";
}

function ml_display($mode, $email, $name){
	global $logid, $PHP_SELF;

	echo "<table border=1>";
	JScheckLength();
echo "
<form action='$PHP_SELF' method=post>\n
<input type=hidden name='mode' value='$mode'>\n
<tr><td>E-Mail 주소</td><td><input type=text name=email value='' maxlength=30 size=30 onChange='return checkLength(this.value,30)'></td></tr>\n
<tr><td>성 명</td><td><input type=text name=name value='' maxlength=20 size=20 onChange='return checkLength(this.value,20)'></td></tr>\n
<tr><td colspan=2 align=center>";

echo "<br><input type=submit value='";
if($mode == "ml-insert")
	echo "등록 처리";
else
	echo "삭제 요청";
echo "'>";
echo "</form></td></tr>\n";
echo "
</table>
";
}

?>
</center>
</body>
</html>
