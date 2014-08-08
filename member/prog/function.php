<?php

function heading($msg){
	echo "<font size='+2'>".$msg."</font>";
	echo "<hr color=red width='80%'>\n<br>";
}

function privcheck($userid){	// admin_id check
	global $logid, $admin_id;

//userid=admin_id:2, userid=logid:1, other:0
//echo "logid=$logid, userid=$userid, admin_id=$admin_id";
	if(strchr($admin_id, "|".$userid."|"))
		return 2;
	else if($logid == $userid)
		return 1;
	else
		return 0;

}

function top($option){
echo "
<html>
<head>
<title>분당마라톤클럽 회원용 기능</title>
<!--
개발자 : 김영헌
개발자의 동의 없는 사용을 금합니다.
-->
";
if(substr($option,0,1) == "<")
	echo "$option\n";

echo "</head>

<body  bgcolor='#E0FFE0' text='black' link='blue' vlink='purple' alink='red'";
if(substr($option,0,6) == "onLoad")
	echo " $option";
else if(substr($option,0,8) == "setFocus")
	echo " onLoad=\"$option\"";
echo ">
<center>
";
}

function tail(){
	echo "
<p align='center'><font size='2'><hr width='90%' noshade color='red'> </font></p>
<p align='center'>Copyright ⓒ by <a href='http://www.gumpu.com/'>분당 탄천검푸 마라톤클럽</a>.
All rights reserved.<font size='2'> </font></p>
<p align='center'>&nbsp;</p>
</body>
</html>";
}

function emailaddrcheck($email){
	if(ereg("([^[:space:]]+)", $email) && (!ereg("(^[_0-9a-zA-Z-]+(\.[_0-9a-zA-Z-]+)*@[0-9a-zA-Z-]+(\.[0-9a-zA-Z-]+)*$)", $email)) ) {
		return 0;
	}else{
		return 1;
	}
}

function JScheckLength(){
echo "
<script language='JavaScript'>
function checkLength(value, maxlen) {
    var len = value.length;
    for (i = 0; i < value.length; i++)
        if (value.charCodeAt(i) > 127)
            len++;
    if (len > maxlen) {
        alert('입력허용길이 ' + maxlen + '자를 초과하였습니다.');
        return false;
    } else
        return true;
}
</script>";
}

function race_disp($raceid){
	global $logid;

	$dbquery="select raceid, name, nickname, raceday, racetime, organizer, homehref, place, typenfee, etc, inviting, userid from race where raceid=$raceid";

	$result = mysql_query($dbquery) or die("mysql_query error");
	$row=mysql_fetch_array($result);
	$ymd=explode("/", $row[3]);
/*
	$timestamp = mktime(0, 0, 0, $ymd[1], $ymd[2], $ymd[0]);
	$racedate = getdate($timestamp);
	$yoil = date("D", mktime(0, 0, 0, $ymd[1], $ymd[2], $ymd[0]));
//echo "yoil=$yoil"; Sun Mon...
*/
//	$yoilno = dayofweek($ymd[0],$ymd[1],$ymd[2]);	// year,month,day
	$year = $ymd[0];
	$month = $ymd[1];
	$day = $ymd[2];
        if (!checkdate($month,$day,$year)){
                $yoilno = -1;
	}else{
        	$a=(int)((14-$month) / 12);
	        $y=$year-$a;
       		$m=$month + (12*$a) - 2;
	       	$yoilno = ($day + $y + (int)($y/4) - (int)($y/100) + (int)($y/400) + (int)((31*$m)/12)) % 7;
	}

//	$yoil = yoilname($yoilno);
	if($yoilno == 0) $yoil = "일";
	else if($yoilno == 1) $yoil = "월";
	else if($yoilno == 2) $yoil = "화";
	else if($yoilno == 3) $yoil = "수";
	else if($yoilno == 4) $yoil = "목";
	else if($yoilno == 5) $yoil = "금";
	else if($yoilno == 6) $yoil = "토";

	if(strlen($row[6])>4 && substr($row[6],0,4) != "http"){
			$href = "http://" . $row[6];
	}else{
		$href = $row[6];
	}
	echo "
<table border=1>
<tr><td>대회명칭</td><td>$row[1]</td></tr>\n
<tr><td>대회일시</td><td>$row[3]($yoil) $row[4]</td></tr>\n
<tr><td>주최</td><td>$row[5]</td></tr>\n
<tr><td>홈주소</td><td><a href='$href' target=_new>$row[6]</a></td></tr>\n
<tr><td>장소</td><td>$row[7]</td></tr>\n
<tr><td>종목및참가비</td><td>$row[8]</td></tr>\n
<tr><td>기타참고사항</td><td>$row[9]</td></tr>\n";
//	if(privcheck($logid) == 2 || $logid == $row[11]){
	if(privcheck($logid) == 2 ){
		echo "<tr><td colspan=2 align=center><a href='race.php?mode=race-change&raceid=$row[0]'>대회정보 수정</a><td><tr>\n";
	}
	echo "</table>\n";
	return $row[2];
}

/*
function yoilname($yoilno){
	if($yoilno == 0) $yoil = "일";
	else if($yoilno == 1) $yoil = "월";
	else if($yoilno == 2) $yoil = "화";
	else if($yoilno == 3) $yoil = "수";
	else if($yoilno == 4) $yoil = "목";
	else if($yoilno == 5) $yoil = "금";
	else if($yoilno == 6) $yoil = "토";

	return $yoil;
}
*/

function mailsend($sender, $senderaddr, $receiver, $receiveraddr, $subject, $cont){
	$mailcont_file = "./tmp/emailconttmp.dat";

	$fp = fopen($mailcont_file, "w");
	if($fp == FALSE){
		echo "File Open Error($mailcont_file)\n";
		return false;
	}
	fwrite($fp, "From: \"$sender\"<$senderaddr>\n");
	fwrite($fp, "To: \"$receiver 님 귀하\"<$receiveraddr>\n");
	fwrite($fp, "Subject: $subject\n");
	fwrite($fp, "\n");
	fwrite($fp, $cont);
	fwrite($fp, "\n");
	fclose($fp);

	$execret = exec("mail ".$receiveraddr."  < $mailcont_file");
	chmod($mailcont_file, 0777);
//	unlink($mailcont_file);
	return true;
}

/* dayofweek() will return the day of the week a given date falls.
0=Sunday, 1=Monday, etc. */

/*
function dayofweek($year,$month,$day) {

        if (!checkdate($month,$day,$year))
                return -1;

        $a=(int)((14-$month) / 12);
        $y=$year-$a;
        $m=$month + (12*$a) - 2;

        $retval=($day + $y + (int)($y/4) - (int)($y/100) + (int)($y/400) + (int)((31*$m)/12)) % 7;
        return $retval;
}
*/

function bostonrace($years, $size)
{
	if($size == "0")
		$imgsize = "";
	else
		$imgsize = " width=$size";
	$yyyy = 0 + date("Y");
	for($a=2000; $a <= $yyyy; $a++){
		if(strstr($years, "" . $a) != false){
		    if(strstr($years, "" . $a . "A") != false)
			echo "<img border=2 src=/image/star.gif$imgsize alt='" . $a . "년 보스톤 대회 출전'>";
		    else
			echo "<img border=0 src=/image/star.gif$imgsize alt='" . $a . "년 보스톤 대회 출전 자격'>";
		}
	}
}

function zb_sendmail2($type, $to, $to_name, $from, $from_name, $subject, $comment, $cc="", $bcc="") {
		$recipient = "$to_name <$to>";

		if($type==1) $comment = nl2br($comment);

		$headers = "From: $from_name <$from>\n";
		$headers .= "X-Sender: <$from>\n";
		$headers .= "X-Mailer: PHP ".phpversion()."\n";
		$headers .= "X-Priority: 1\n";
		$headers .= "Return-Path: <$from>\n";

		if(!$type) $headers .= "Content-Type: text/plain; ";
		else $headers .= "Content-Type: text/html; ";
		$headers .= "charset=euc-kr\n";

		if($cc)  $headers .= "cc: $cc\n";
		if($bcc)  $headers .= "bcc: $bcc";

		$comment = stripslashes($comment);
		$comment = str_replace("\n\r","\n", $comment);

		return mail($recipient , $subject , $comment , $headers);

}

function daycheck($raceday){
	$temp=explode("/",$raceday);
	if(count($temp)<2 || strlen($temp[0])!=4 && strlen($temp[0])!=2){
		errornback("대회 날짜를 정확히 입력하십시오.($raceday)");
		return false;
	}
	if(strlen($temp[0])==2)
		$rday="20";
	else
		$rday="";
	$rday.=$temp[0]."/";
	if(strlen($temp[1])==1) $rday.="0";
	$rday.=$temp[1];
	if(count($temp)==3){
		$rday.="/";
		if(strlen($temp[2])==1) $rday.="0";
		$rday.=$temp[2];
	}

	return $rday;
}

function errornback($msg){
		echo "<form><table><tr><td>$msg\n
		<tr><td align=center><input type=button value='   뒤로   ' onclick=history.back() style=border-color:#b0b0b0;background-color:#3d3d3d;color:#ffffff;font-size:8pt;font-family:Tahoma;height:23px;>
		</td></tr></table></form>\n";
}
?>
