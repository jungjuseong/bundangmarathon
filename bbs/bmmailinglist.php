<?php

require("./bmauth.php");
require("./bmconfig.php");
require("./bmfunction.php");

top("");
    ////
if($mode == "ml-input-new"){
	heading("Bundang Marathon Mailing List �ű� ���");
	ml_display("ml-insert","","","","","","","","","","","",$logid);
}else if($mode == "ml-input-old"){
	heading("Bundang Marathon Mailing List ���� ��û");
	ml_display("ml-deleterequest","","","","","","","","","","","",$logid);
}else if($mode == "ml-insert"){
	heading("Bundang Marathon Mailing List �ű� ���");

	if($email == ""){
		echo "e-mail �ּҸ� �Է� �ٶ��ϴ�.<br><br>";
		echo "<a href='javascript:history.back();'>�ڷ�</a>";
		die("");
	}
	if($name == ""){
		echo "�̸��� �Է� �ٶ��ϴ�.<br><br>";
		echo "<a href='javascript:history.back();'>�ڷ�</a>";
		die("");
	}
	$dbquery="select name from mailinglist where email='$email'";
	$result = mysql_query($dbquery);
	$rows = mysql_num_rows($result);
	if($rows == 1){
		$row=mysql_fetch_array($result);
		if($row[0] == $name){
			echo "�̹� ����Ͻ� E-Mail �ּ��Դϴ�.<br>";
		}else{
			echo "�ٸ� ���� �̹� ����Ͻ� E-Mail �ּ��Դϴ�.<br>";
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
			echo "E-Mail �ּ� ��� �����Դϴ�.<br>";
		}else{
			echo "Mailing List ��� ó�� �Ϸ�.<br>";
		}
	}
// mail send **************************************************************

}else if($mode == "ml-batch"){
	heading("Bundang Marathon Mailing List Batch ���");

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
			echo "E-Mail �ּ�($row[1]) ��� �����Դϴ�.<br>";
		}
	}
	echo "Mailing List ��� ó�� �Ϸ�.<br>";
	mysql_free_result($result);
// mail send **************************************************************

}else if($mode == "ml-deleterequest"){
	heading("Bundang Marathon Mailing List ���� ���� ��û");

	if($email == ""){
		echo "e-mail �ּҸ� �Է� �ٶ��ϴ�.<br><br>";
		echo "<a href='javascript:history.back();'>�ڷ�</a>";
		die("");
	}

	$dbquery="select name, randno from mailinglist where email='$email'";
	$result = mysql_query($dbquery);
	$rows = mysql_num_rows($result);
	if($rows != 1){
		echo "�Է��Ͻ� E-Mail �ּҴ� ��ϵǾ� ���� �ʽ��ϴ�.<br>";
		mysql_free_result($result);
		die("");
	}
	$row=mysql_fetch_array($result);

	$receiver = "\"$row[0]\"<$email>";
	$cont = "<p align=center>Bundang Marathon Mailing List���� ������ E-Mail �ּҸ� �����Ͻ÷��� �Ʒ� ��ũ�� Ŭ���� �ֽʽÿ�.\n";
	$cont .= "<br>(Please click 'Delete' button if you want to delete your email account from bundang marathon club mailing-list)\n";
	$headers = "From: \"�д縶����\" <$managerEmail>\n";
//	$headers .= "X-Sender: <$managerEmail>\n";
//	$headers .= "X-Priority: 1\n"; // Urgent message!
	$headers .= "Return-Path: <$managerEmail>\n";  // Return path for errors
	$headers .= "Content-Type: text/html; charset=iso-8859-1\n"; // Mime type

//	$cont.= "<p align=center><font size='+2'><a href=\"http://$HTTP_HOST$PHP_SELF?mode=ml-delete&email=".urlencode($email)."&randno=$row[1]\">����</a></font>\n";
	$cont.= "<p align=center><font size='+2'>\n";
	$cont.= "<form method=post action=\"http://$HTTP_HOST$PHP_SELF\">\n";
	$cont.= "<input type=hidden name=mode value=ml-delete>\n";
	$cont.= "<input type=hidden name=email value=$email>\n";
	$cont.= "<input type=hidden name=randno value=$row[1]>\n";
	$cont.= "<input type=submit value=\"Delete\">\n";
	$cont.= "</form>\n";
	$cont.= "</font>\n";
	if(mail($receiver, "Bundang Marathon Mailing List ���� ����", $cont, $headers) == FALSE){
		echo "mail �߼� ����\n";
		die("");
	}
//echo $cont;
	echo "�����Ͻ� E-Mail �ּҷ� ���� Ȯ�� ������ �߼��߽��ϴ�.<br><br>��� �� ������ Ȯ���� �ֽñ� �ٶ��ϴ�.\n";

}else if($mode == "ml-delete"){
	heading("Bundang Marathon Mailing List ���� ����");

	$dbquery="select name from mailinglist where email='$email' and randno='$randno'";
	$result = mysql_query($dbquery);
	$rows = mysql_num_rows($result);
	if($rows != 1){
		echo "���� �䱸�Ͻ� E-Mail �ּҴ� ��ϵǾ� ���� �ʽ��ϴ�.<br>";
		mysql_free_result($result);
		die("");
	}

	$dbquery="delete from mailinglist where email='$email' and randno='$randno'";
	$result = mysql_query($dbquery) or die("mysql_query error");
echo $result;
	if($result=="1"){
		echo "<table width=300><tr><td>";
		echo "$email ���� �Ϸ�<br><br>���߿� �д縶����Ŭ���� ������ �����ð� �Ǹ� Ȩ������(www.bundangmarathon.com)���� �ٽ� ������ �ֽñ� �ٶ��ϴ�.";
		echo "</td></tr></table>";
	}else{
		echo "<font color=red>$email ���� ����</font>";
	}
}else{
	heading("Bundang Marathon Mailing List �޴�");

	echo "<p><a href='$PHP_SELF?mode=ml-input-new'>Bundang Marathon Mailing List �ű� ���</a><p>\n";
	echo "<p><a href='$PHP_SELF?mode=ml-input-old'>Bundang Marathon Mailing List ���� ��û</a><p>\n";
}

function ml_display($mode, $email, $name){
	global $logid, $PHP_SELF;

	echo "<table border=1>";
	JScheckLength();
echo "
<form action='$PHP_SELF' method=post>\n
<input type=hidden name='mode' value='$mode'>\n
<tr><td>E-Mail �ּ�</td><td><input type=text name=email value='' maxlength=30 size=30 onChange='return checkLength(this.value,30)'></td></tr>\n
<tr><td>�� ��</td><td><input type=text name=name value='' maxlength=20 size=20 onChange='return checkLength(this.value,20)'></td></tr>\n
<tr><td colspan=2 align=center>";

echo "<br><input type=submit value='";
if($mode == "ml-insert")
	echo "��� ó��";
else
	echo "���� ��û";
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
