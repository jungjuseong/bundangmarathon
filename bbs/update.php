<?php 

// update.php
// birth, bllod

require("bmauth.php");
require("bmconfig.php");
require("bmfunction.php");

if($logid == ""){
	die("�α������� �ʾҽ��ϴ�.");
}

if($type == "birth"){
	top("onLoad='window.focus(); document.birth.birthdateyyyy.focus()'");
	heading("���� �Է�");

	$birthdate = $birthdateyyyy.".".$birthdatemm.".".$birthdatedd;
	$birthsun = $birthsunmm.".".$birthsundd;
	if($birthdateyyyy == "" || strlen($birthdateyyyy) != 4)
		$birthdateyyyy = "19";
	$inputmode = 0;
	if($mode > 0){
		if(strlen($birthdate) != 10){
			echo "<script>alert('�ֹε�Ϲ�ȣ�� ������ ������ ��� ������ �Է��Ͻʽÿ�.(1958�� X�� X��)');</script>";
			$inputmode++;
		}
		if(strlen($birthtype) == 0){
			echo "<script>alert('���, ���� ������ �ֽʽÿ�.');</script>";
			$inputmode++;
		}
		if(strlen($birthsun) != 5){
			echo "<script>alert('���� ������ ��� ��¥�� �Է��Ͻʽÿ�.');</script>";
			$inputmode++;
		}
	}
	if($inputmode > 0 || $mode == 0){
		$mode++;
		JScheckLength();
		echo "Ȩ�������� ���� �޽��������� ȸ�� �������� ���� ������ �����մϴ�.<br>(�ֹε�Ϲ�ȣ�� ����)<br>";
		echo "
			<form name=birth action='$PHP_SELF' method=post>\n
			<input type=hidden name=type value='$type'>\n
			<input type=hidden name=mode value='$mode'>\n
			<table border=1>\n
			<tr><td>����<br>�������</td><td><input type=text name=birthdateyyyy value='$birthdateyyyy' maxlength=4 size=4>�� <select name='birthdatemm' size='1' style='background-color: white; color: blue; font:10pt'>
<option value=''>?</option>\n";
		for($i=1; $i<=12; $i++){
			echo "<option value='";
			if($i < 10) echo "0";
			echo $i;
			echo "'";
			if($i == (0 + $birthdatemm))	echo " selected";
			echo ">".$i."</option>\n";
		}
		echo "</select>�� <select name='birthdatedd' size='1' style='background-color: white; color: blue; font:10pt'>
<option value=''>?</option>\n";
		for($i=1; $i<=31; $i++){
			echo "<option value='";
			if($i < 10) echo "0";
			echo $i;
			echo "'";
			if($i == (0 + $birthdatedd))	echo " selected";
			echo ">".$i."</option>\n";
		}
		echo "</select>��\n
			<br><input type=radio name=birthtype value=0 $birthtype0>��� <input type=radio name=birthtype value=1 $birthtype1>����\n</td>
			<tr><td>����<br>��»���</td><td><select name='birthsunmm' size='1' style='background-color: white; color: blue; font:10pt'>
<option value=''>?</option>\n";
		for($i=1; $i<=12; $i++){
			echo "<option value='";
			if($i < 10) echo "0";
			echo $i;
			echo "'";
			if($i == (0 + $birthsunmm))	echo " selected";
			echo ">".$i."</option>\n";
		}
		echo "</select>�� <select name='birthsundd' size='1' style='background-color: white; color: blue; font:10pt'>
<option value=''>?</option>\n";
		for($i=1; $i<=31; $i++){
			echo "<option value='";
			if($i < 10) echo "0";
			echo $i;
			echo "'";
			if($i == (0 + $birthsundd))	echo " selected";
			echo ">".$i."</option>\n";
		}
		echo "</select>��\n
			<tr><td colspan=2 align=center><input type=submit value='�Է� ó��'></form>\n		
			</table>\n";
	}else{
		$queryset="birthdate='".$birthdate."',birthtype='".$birthtype."',birthsun='".$birthsun."'";

		$dbquery="update member set $queryset where userid = '$logid'";
//echo $dbquery;
		$result = mysql_query($dbquery);
		if($result!="1"){
			echo "<font color=red>�����Դϴ�. query=$dbquery</font>";
		}else{
			echo "�����մϴ�.<br>�Է��� �Ϸ�Ǿ����ϴ�.<br>";
		}
		echo "<p align=center><FORM NAME='childForm' onSubmit='window.close(); return false;'> 
<BR><INPUT TYPE='SUBMIT' VALUE='â�ݱ�'>
</FORM>";

	}
}else if($type == "blood"){
	top("onLoad='window.focus();'");
//	echo "<p align=center>������ �Է�<p align=center>";
	heading("������ �Է�");

	if($mode == 0){
		$mode++;
		echo "�������ȸ ��ü������û������ ȸ�� �������� �������� �����մϴ�.";
		echo "
			<form name=blood action='$PHP_SELF' method=post>
			<input type=hidden name=type value='$type'>
			<input type=hidden name=mode value='$mode'>
			<table border=1>
<tr><td>������</td><td>Rh+/Rh-</td></tr>
<tr><td><input type=radio name=bloodtype value=A>A <br>
<input type=radio name=bloodtype value=B>B <br>
<input type=radio name=bloodtype value=AB>AB <br>
<input type=radio name=bloodtype value=O>O <br>
<input type=radio name=bloodtype value=UK>��</td>
<td><input type=radio value='' name=is_bloodnegative checked> Rh+<br>
<input type=radio value='-' name=is_bloodnegative> Rh-
</td></tr>\n";
			
		echo "<tr><td colspan=2 align=center><input type=submit value='�Է� ó��'></form>		
			</table>\n";
	}else{
		$dbquery="update member set bloodtype='$bloodtype$is_bloodnegative' where userid = '$logid'";
//echo $dbquery;
		$result = mysql_query($dbquery);
		if($result!="1"){
			echo "<font color=red>�����Դϴ�. query=$dbquery</font>";
		}else{
			echo "�����մϴ�.<br>�Է��� �Ϸ�Ǿ����ϴ�.<br>";
		}
		echo "<p align=center><FORM NAME='childForm' onSubmit='window.close(); return false;'> 
<BR><INPUT TYPE='SUBMIT' VALUE='â�ݱ�'>
</FORM>";
	}
}
?>
</center>
</body>
</html>
