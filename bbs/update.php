<?php 

// update.php
// birth, bllod

require("bmauth.php");
require("bmconfig.php");
require("bmfunction.php");

if($logid == ""){
	die("로그인하지 않았습니다.");
}

if($type == "birth"){
	top("onLoad='window.focus(); document.birth.birthdateyyyy.focus()'");
	heading("생일 입력");

	$birthdate = $birthdateyyyy.".".$birthdatemm.".".$birthdatedd;
	$birthsun = $birthsunmm.".".$birthsundd;
	if($birthdateyyyy == "" || strlen($birthdateyyyy) != 4)
		$birthdateyyyy = "19";
	$inputmode = 0;
	if($mode > 0){
		if(strlen($birthdate) != 10){
			echo "<script>alert('주민등록번호와 별개로 실제로 쇠는 생일을 입력하십시오.(1958년 X월 X일)');</script>";
			$inputmode++;
		}
		if(strlen($birthtype) == 0){
			echo "<script>alert('양력, 음력 선택해 주십시오.');</script>";
			$inputmode++;
		}
		if(strlen($birthsun) != 5){
			echo "<script>alert('올해 생일의 양력 날짜를 입력하십시오.');</script>";
			$inputmode++;
		}
	}
	if($inputmode > 0 || $mode == 0){
		$mode++;
		JScheckLength();
		echo "홈페이지에 축하 메시지용으로 회원 여러분의 실제 생일을 조사합니다.<br>(주민등록번호와 별개)<br>";
		echo "
			<form name=birth action='$PHP_SELF' method=post>\n
			<input type=hidden name=type value='$type'>\n
			<input type=hidden name=mode value='$mode'>\n
			<table border=1>\n
			<tr><td>실제<br>생년월일</td><td><input type=text name=birthdateyyyy value='$birthdateyyyy' maxlength=4 size=4>년 <select name='birthdatemm' size='1' style='background-color: white; color: blue; font:10pt'>
<option value=''>?</option>\n";
		for($i=1; $i<=12; $i++){
			echo "<option value='";
			if($i < 10) echo "0";
			echo $i;
			echo "'";
			if($i == (0 + $birthdatemm))	echo " selected";
			echo ">".$i."</option>\n";
		}
		echo "</select>월 <select name='birthdatedd' size='1' style='background-color: white; color: blue; font:10pt'>
<option value=''>?</option>\n";
		for($i=1; $i<=31; $i++){
			echo "<option value='";
			if($i < 10) echo "0";
			echo $i;
			echo "'";
			if($i == (0 + $birthdatedd))	echo " selected";
			echo ">".$i."</option>\n";
		}
		echo "</select>일\n
			<br><input type=radio name=birthtype value=0 $birthtype0>양력 <input type=radio name=birthtype value=1 $birthtype1>음력\n</td>
			<tr><td>올해<br>양력생일</td><td><select name='birthsunmm' size='1' style='background-color: white; color: blue; font:10pt'>
<option value=''>?</option>\n";
		for($i=1; $i<=12; $i++){
			echo "<option value='";
			if($i < 10) echo "0";
			echo $i;
			echo "'";
			if($i == (0 + $birthsunmm))	echo " selected";
			echo ">".$i."</option>\n";
		}
		echo "</select>월 <select name='birthsundd' size='1' style='background-color: white; color: blue; font:10pt'>
<option value=''>?</option>\n";
		for($i=1; $i<=31; $i++){
			echo "<option value='";
			if($i < 10) echo "0";
			echo $i;
			echo "'";
			if($i == (0 + $birthsundd))	echo " selected";
			echo ">".$i."</option>\n";
		}
		echo "</select>일\n
			<tr><td colspan=2 align=center><input type=submit value='입력 처리'></form>\n		
			</table>\n";
	}else{
		$queryset="birthdate='".$birthdate."',birthtype='".$birthtype."',birthsun='".$birthsun."'";

		$dbquery="update member set $queryset where userid = '$logid'";
//echo $dbquery;
		$result = mysql_query($dbquery);
		if($result!="1"){
			echo "<font color=red>에러입니다. query=$dbquery</font>";
		}else{
			echo "감사합니다.<br>입력이 완료되었습니다.<br>";
		}
		echo "<p align=center><FORM NAME='childForm' onSubmit='window.close(); return false;'> 
<BR><INPUT TYPE='SUBMIT' VALUE='창닫기'>
</FORM>";

	}
}else if($type == "blood"){
	top("onLoad='window.focus();'");
//	echo "<p align=center>혈액형 입력<p align=center>";
	heading("혈액형 입력");

	if($mode == 0){
		$mode++;
		echo "마라톤대회 단체참가신청용으로 회원 여러분의 혈액형을 조사합니다.";
		echo "
			<form name=blood action='$PHP_SELF' method=post>
			<input type=hidden name=type value='$type'>
			<input type=hidden name=mode value='$mode'>
			<table border=1>
<tr><td>혈액형</td><td>Rh+/Rh-</td></tr>
<tr><td><input type=radio name=bloodtype value=A>A <br>
<input type=radio name=bloodtype value=B>B <br>
<input type=radio name=bloodtype value=AB>AB <br>
<input type=radio name=bloodtype value=O>O <br>
<input type=radio name=bloodtype value=UK>모름</td>
<td><input type=radio value='' name=is_bloodnegative checked> Rh+<br>
<input type=radio value='-' name=is_bloodnegative> Rh-
</td></tr>\n";
			
		echo "<tr><td colspan=2 align=center><input type=submit value='입력 처리'></form>		
			</table>\n";
	}else{
		$dbquery="update member set bloodtype='$bloodtype$is_bloodnegative' where userid = '$logid'";
//echo $dbquery;
		$result = mysql_query($dbquery);
		if($result!="1"){
			echo "<font color=red>에러입니다. query=$dbquery</font>";
		}else{
			echo "감사합니다.<br>입력이 완료되었습니다.<br>";
		}
		echo "<p align=center><FORM NAME='childForm' onSubmit='window.close(); return false;'> 
<BR><INPUT TYPE='SUBMIT' VALUE='창닫기'>
</FORM>";
	}
}
?>
</center>
</body>
</html>
