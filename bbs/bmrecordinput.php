<?php

require("./bmauth.php");
require("./bmconfig.php");

function tophtml($title){
echo "
<html>
<head>
<title>$title</title>
</head>

<body bgcolor='#E0FFE0' >
<center>
";
}

function heading($msg){
	echo "<font size='+2'>".$msg."</font>";
	echo "<hr color=red width='80%'>\n<p>";
}

header("Content-Type: text/html");
tophtml("��ȸ ��� ��ġ �Է�");
heading("��ȸ ��� ��ġ �Է�");

if($mode == ""){
/*
		$url = $PHP_SELF."?mode=batch-input";
		echo "
<form method=post action='$url'>
Data Format : ���� ����  ������� ��߽ð� �������(5Km) (30Km) ������� <br>
��Ĵ�ȸ��:<input type=text name=nickname size=12><br>
����:<input type=text name=item size=6><br>
���ϸ�:<input type=text name=fname size=20 maxlength=40><br>
<input type=submit value='��� ��ġ �Է� ó��'>
</form>\n<p><br><br>";
*/
		$url = $PHP_SELF."?mode=batch-inputgeneral";
		echo "
<form method=post action='$url'>
Data Format : ���� ��� ����(Ǯ,����,10Km,5Km) ��Ĵ�ȸ�� ���� ��Ÿ
<br>(����Ÿ ������ �� ������, ������ ��Ÿ�� ��� ��)<br>
���� ���ϸ�:<input type=text name=fname size=20 maxlength=40><br>
<input type=submit value='��� ��ġ �Է� ó��'>
</form>\n<p>";

}elseif($mode == "batch-input"){

	if( !file_exists($fname)){
		echo "���� '$fname' �� �����ϴ�.";
		die("");
	}
	$dbquery="select raceid from race where nickname = '$nickname'";
	$result = mysql_query($dbquery) or die("mysql_query select error");
	$row=mysql_fetch_array($result);
	if(mysql_num_rows($result) == 0){
		echo "��Ĵ�ȸ�� '$nickname'�� �����ϴ�.";
		die("");
	}
	$raceid=$row[0];
	mysql_free_result($result);

	$fp = fopen($fname, "r");
	$no = 0;
//	$sexkor = array ("'����'","'��'","'����'","'��'");
//	$sexeng = array ("'M'","'M'","'F'","'F'");
/* record table
| userid    | varchar(12) |      | PRI |         |       |
| raceid    | smallint(6) |      | PRI | 0       |       |
| nickname  | varchar(12) |      |     |         |       |
| item      | varchar(6)  | YES  |     | NULL    |       |
| record    | varchar(10) |      |     |         |       |
| rank      | varchar(5)  | YES  |     | NULL    |       |
| dispyn    | char(2)     |      |     |         |       |
| transport | varchar(20) | YES  |     | NULL    |       |
| etc       | varchar(50) | YES  |     | NULL    |       |
| size      | varchar(4)  | YES  |     | NULL    |       |
| fellows   | char(2)     | YES  |     | NULL    |       |
*/
	$insert_string = "insert into record (userid,raceid,nickname,item,record,rank,dispyn,etc) values ";
//	$item = "Ǯ";
	while (!feof ($fp)) {
		$data = chop(fgets($fp, 256));
		if($data == "" || substr($data,0,1)=="#")
			continue;
//		$data = str_replace($sexkor, $sexeng, $data);
//
//���� ����  ������� ��߽ð� �������(5Km) (30Km) �������
//830 �迵�� 58.06.22 10:02:00 00:24:49 02:26:48 03:25:54
//

//		list($rank,$name, $birthdate, $starttime, $lap5, $lap30, $record)
//			= sscanf( $data,"%s %s %s %s %s %s %s");
		$strs = explode(" ", $data);
		$rank = $strs[0];
		$name = $strs[1];
		$lap5 = $strs[4];
		$lap30 = $strs[5];
		$record = $strs[6];
		if(substr($record,0,1) == "0")
			$record = substr($record, 1);
		if(substr($lap5,0,1) == "0")
			$lap5 = substr($lap5, 1);
		if(substr($lap30,0,1) == "0")
			$lap30 = substr($lap30, 1);
//echo "name=$name,record=$record,rank=$rank,lap5=$lap5,lap30=$lap30<br>";
		$dbquery="select userid from member where name = '$name'";
		$result = mysql_query($dbquery) or die("mysql_query select error");
		if(mysql_num_rows($result) == 0){
			echo "�̸� '$name'�� �����ϴ�.";
			die("");
		}
		$row=mysql_fetch_array($result);
		$userid=$row[0];
		mysql_free_result($result);

		$dbquery="select userid,raceid from record where raceid=$raceid and userid='$userid'";
		$result = mysql_query($dbquery) or die("mysql_query select error");
		if(mysql_num_rows($result) == 0){
			mysql_free_result($result);
//	"(userid,raceid,nickname,item,record,rank,dispyn,etc)";
			$dbquery = $insert_string."('$userid',$raceid,'$nickname','$item','$record','$rank','Y','$lap5(5k) $lap30(30k)')";
			$result = mysql_query($dbquery);
echo "insert dbquery=$dbquery<br>";
//echo "mysql_errno=".mysql_errno().":".mysql_error();
			if($result!=1){
				echo "<br>insert �̻�. dbquery=$dbquery<br>ó�� �̿Ϸ�<p>";
			}else{
				$no++;
			}

		}else{
			$dbquery = "update record set record='$record',item='$item',rank='$rank',dispyn='Y',etc='$lap5(5k) $lap30(30k)' where raceid=$raceid and userid='$userid'";
			$result = mysql_query($dbquery);
echo "<br>update dbquery=$dbquery<p>";
			if($result!=1){
				echo "<br>update �̻�. dbquery=$dbquery<br>ó�� �̿Ϸ�<p>";
			}else{
				$no++;
			}
		}
	}
	fclose ($fp);

	echo "�� $no �� �Է� �Ϸ�.";
}elseif($mode == "batch-inputgeneral"){

	if( !file_exists($fname)){
		echo "���� '$fname' �� �����ϴ�.";
		die("");
	}

	$fp = fopen($fname, "r");
	$no = 0;
/* record table
| userid    | varchar(12) |      | PRI |         |       |
| raceid    | smallint(6) |      | PRI | 0       |       |
| nickname  | varchar(12) |      |     |         |       |
| item      | varchar(6)  | YES  |     | NULL    |       |
| record    | varchar(10) |      |     |         |       |
| rank      | varchar(5)  | YES  |     | NULL    |       |
| dispyn    | char(2)     |      |     |         |       |
| transport | varchar(20) | YES  |     | NULL    |       |
| etc       | varchar(50) | YES  |     | NULL    |       |
| size      | varchar(4)  | YES  |     | NULL    |       |
| fellows   | char(2)     | YES  |     | NULL    |       |
*/
	$insert_string = "insert into record (userid,raceid,nickname,item,record,rank,dispyn,etc) values ";
	$etc = "";
	$rank = 0;
	$oldnickname = "";
	while (!feof ($fp)) {
		$data = chop(fgets($fp, 256));
		if($data == "" || substr($data,0,1)=="#")
			continue;
//
//����	��� 	����	��Ĵ�ȸ��	����	��Ÿ
//�迵�� 3:25:54 	Ǯ	03 ����		111	��� xxx

		$strs = explode("	", $data);
		$name = $strs[0];
		$record = $strs[1];
		$item = $strs[2];
		$nickname = $strs[3];
		$rank = $strs[4];
		$etc = $strs[5];
		if($item!="Ǯ" && $item!="����" && $item!="5Km" && $item!="10Km"){
			echo "���� '$item'�� �̵�� �����Դϴ�.";
			echo "��� ������ Ǯ, ����, 10Km, 5Km�Դϴ�.";
			die("");
		}
		if(substr($record,0,1) == "0" && substr($record,1,1) != ':')
			$record = substr($record, 1);
//echo "name=$name,record=$record<br>";
		$dbquery="select userid from member where name = '$name'";
		$result = mysql_query($dbquery) or die("mysql_query select error,name=$name");
		if(mysql_num_rows($result) == 0){
			echo "�̸� '$name'�� �����ϴ�.";
			die("");
		}
		$row=mysql_fetch_array($result);
		$userid=$row[0];
		mysql_free_result($result);

	    if($nickname != $oldnickname){
		$dbquery="select raceid from race where nickname = '$nickname'";
		$result = mysql_query($dbquery) or die("mysql_query select error, nickname='$nickname'");
		$row=mysql_fetch_array($result);
		if(mysql_num_rows($result) == 0){
			echo "��Ĵ�ȸ�� '$nickname'�� �����ϴ�.";
			die("");
		}
		$raceid=$row[0];
echo "nickname='$nickname', raceid=$raceid";
		mysql_free_result($result);
		$oldnickname = $nickname;
	    }

		$dbquery="select userid,raceid from record where raceid=$raceid and userid='$userid'";
		$result = mysql_query($dbquery) or die("mysql_query select error, raceid=$raceid,userid=$userid");
		if(mysql_num_rows($result) == 0){
			mysql_free_result($result);
//	"(userid,raceid,nickname,item,record,rank,dispyn,etc)";
			$dbquery = $insert_string."('$userid',$raceid,'$nickname','$item','$record','$rank','Y','$etc')";
			$result = mysql_query($dbquery);
echo "insert dbquery=$dbquery<br>";
//echo "mysql_errno=".mysql_errno().":".mysql_error();
			if($result!=1){
				echo "<br>insert �̻�. dbquery=$dbquery<br>ó�� �̿Ϸ�<p>";
			}else{
				$no++;
			}

		}else{
			$update_str = "update record set record='$record'";
			if($item) $update_str .= ",item='$item'";
			if($rank) $update_str .= ",rank='$rank'";
			if($etc) $update_str .= ",etc='$etc'";
			$dbquery = $update_str.",dispyn='Y' where raceid=$raceid and userid='$userid'";
			$result = mysql_query($dbquery);
echo "<br>update dbquery=$dbquery<p>";
			if($result!=1){
				echo "<br>update Ȯ�ο��(2�� �̻��� ���ɼ�). ó�� �Ϸ�<p>";
			}else{
				$no++;
			}
		}
	}
	fclose ($fp);

	echo "�� $no �� �Է� �Ϸ�.";
}else{
	exit;
}
?>
</center>
</body>
</html>
