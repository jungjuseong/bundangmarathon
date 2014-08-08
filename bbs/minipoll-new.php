<?php
// minipoll
/*
CREATE TABLE minipollq (
  pollno int(5) NOT NULL auto_increment,
  userid varchar(12) NOT NULL,
  question varchar(80),
  items int(2),
  answers varchar(100),
  etc varchar(40),
  start_date DATE NOT NULL,
  stop_date DATE NOT NULL,
  polltime datetime,
  must varchar(1),
  PRIMARY KEY (pollno)
);

CREATE TABLE minipolla (
  pollno int(5) NOT NULL,
  userid varchar(12) NOT NULL,
  polltime datetime,
  selected varchar(20),
  etc varchar(40),
  PRIMARY KEY (pollno,userid)
);
*/


require("./bmauth.php");
require("./bmconfig.php");
require("./bmfunction.php");

echo "<html>
<head><title>Mini Poll(회원용)</title>
<style type='text/css'>
<!--
font{ font-family:'굴림체'; font-size: 10pt; line-height:17px; }
-->
</style>
</head>\n";

echo "<body>\n<div align=center><font color=red><b>Mini Poll</b></font><br></div>";
if($logid == "")
	exit();
if($pollno) if(strlen($pollno) > 5) $pollno=substr($pollno,0,5);
if($question) if(strlen($question) > 80) $question=substr($question,0,80);
if($etc) if(strlen($etc) > 40) $etc=substr($etc,0,40);
if($start_date) if(strlen($start_date) > 10) $start_date=substr($start_date,0,10);
if($start_date) if(strlen($start_date) > 10) $start_date=substr($start_date,0,10);

$answeritems = 5;
$pageitems = 5;
$etclength = 40;
$userid = "";

echo "<font size=2>";
$date = getdate();
$yyyy = $date['year'];
$mm = $date['mon']; if(strlen($mm)== 1) $mm = "0".$mm;
$dd = $date['mday']; if(strlen($dd)== 1) $dd = "0".$dd;
$yyyymmdd=$yyyy."-".$mm."-".$dd;

// 정.준회원만 사용
$dbquery="select * from member where userid = '$logid' and membertype in ('정회원','준회원')";
$result = mysql_query($dbquery) or die("mysql_query error(member table select)");
if(mysql_num_rows($result) == 0){
	echo "사용할 권한이 없습니다.";
	echo "</body></html>\n";
	exit;
}

// echo "<!-- mode=$mode,pollno=$pollno -->";
if($mode == ""){
	if($pollno == ""){
		$dbquery="select * from minipollq where start_date <= '$yyyymmdd' and stop_date >= '$yyyymmdd' order by pollno";
		$result = mysql_query($dbquery) or die("mysql_query error(minipollq table select)");
		$qno = 0;
		while($row = mysql_fetch_array($result)){
			$dbquery="select * from minipolla where pollno=$row[pollno] and userid='$logid'";
//echo $dbquery;
			$result2 = mysql_query($dbquery) or die(mysql_error());
			if(mysql_num_rows($result2) == 1){	// 설문 응답 상태
				continue;
			}
			$qno++;
			break;
		}
		$pollno = $row[pollno];
	}else{
		$dbquery="select * from minipollq where pollno = $pollno and start_date <= '$yyyymmdd' and stop_date >= '$yyyymmdd'";
		$result = mysql_query($dbquery) or die("mysql_query error(minipollq table select)");
		if(($row = mysql_fetch_array($result))){
			$qno = $pollno;
		}else{
			$qno = 0;
		};
	}
	if($qno == 0){
		$dbquery="select * from minipollq order by pollno desc limit 1";
		$result = mysql_query($dbquery) or die("mysql_query error(minipollq table select)");
		if($row = mysql_fetch_array($result)){
			$pollno = $row[pollno];
			pollresult();
			if($userid == $logid || $logid == "run4joy"){
				echo " <a href='$PHP_SELF?mode=delete&pollno=$pollno'>삭제</a>\n";
			}
		}else{
			echo "설문이 없습니다.";
			echo "<br><br>\n";
		}
	}else{
		echo "<form action='$PHP_SELF' method=post>\n<input type=hidden name=mode value='poll'>\n<input type=hidden name=pollno value='$pollno'>\n<input type=hidden name=items value='$row[3]'>";
		$polldays = substr($row[start_date], 5);
		if($row[start_date]!=$row[stop_date])
			$polldays .= "~".substr($row[stop_date], 5);
		echo "$pollno. $row[question][$row[userid],$polldays]\n";
		$i = 0;
		$checked = "";
		if(trim($row[answers]) != ""){
			$param = explode("<>", $row[answers]);
			for(;$i < count($param); $i++){
			    echo "<br><input type='radio' name='pollano' value='$i'>$param[$i]\n";
			}
		}else{
			$checked = "checked";
		}
		if($row[etc] == "1")
		    echo "<br><input type='radio' name='pollano' value='$i' $checked>기타의견:<input type='input' name='etc' size=20 maxlength=40>\n";
		echo "<br><input type=submit value='보내기'>";
		echo "</form>\n";
		if($row[userid] == $logid || $logid == "run4joy")
			echo " <a href='$PHP_SELF?mode=delete&pollno=$pollno'>삭제</a>";
		echo " <a href='$PHP_SELF?mode=result&pollno=$pollno'>결과</a>";
		echo " <a href='$PHP_SELF?mode='>투표</a>";
	}
//	if($logid == "run4joy")
		echo " <a href='$PHP_SELF?mode=input'>등록</a>";

	echo "<br><br>\n";
	mysql_free_result($result);
	
	polllist();

}else if($mode == "result"){
	if($pollno == ""){
		echo "설문번호가 이상합니다.<br><br>\n";
		errornback("");
		exit;
	}
	pollresult();
//	if($logid == "run4joy")
		echo " <a href='$PHP_SELF?mode=input'>등록</a>";
	if($userid == $logid || $logid == "run4joy"){
		echo " <a href='$PHP_SELF?mode=delete&pollno=$pollno'>삭제</a>\n";
	}
	
	echo "<br><br>\n";
	polllist();

}else if($mode == "input"){
	echo "<미니투표 등록><br><!-- 설문 등록은 회원이면 누구나 가능합니다.-->\n";
	echo "<form action='$PHP_SELF' method=post>\n<input type=hidden name=mode value='insert'>\n";
	echo "시작일:<input type='text' name='start_date' size=10 value='$yyyymmdd'>\n";
	echo "<br>종료일:<input type='text' name='stop_date' size=10 value='$yyyymmdd'>\n";
	echo "<br>성격:<input type=checkbox name='must' value='Y'>체크시 의무\n";
	echo "<br>제목:<input type='text' name='question' size=15 value='**설문내용입력(최대 80자)'>\n";
	echo "<br>설문항목:\n";
	for($i = 0; $i < $answeritems; $i++){
	    echo "<br>".($i+1).". <input type='text' name='pollano[$i]' size=10>\n";
	}
	echo "<br><input type=checkbox value=1 name=etc>기타 의견 수용\n";
	echo "<br><input type=submit value='전송'>\n";
	echo "<input type=button onclick='history.back()' value='이전'\n";
	echo "</form>\n";
}else if($mode == "insert"){
	$pollno = htmlentities(urlencode($pollno));
	$question = htmlspecialchars($question);
	$etc = htmlspecialchars($etc);
	$start_date = htmlentities(urlencode($start_date));
	$stop_date = htmlentities(urlencode($stop_date));
	$must = htmlentities(urlencode($must));
	
	$answers = "";
	for($i = $items = 0; $i < $answeritems; $i++){
		if(trim($pollano[$i]) != ""){
			if($answers == "")
				$answers = $pollano[$i];
			else
				$answers .= "<>".$pollano[$i];
			$items++;
		}
	}
	if($items == 0){
		echo "<br>설문 항목을 하나 이상 작성하십시오.<br><br>\n";
		errornback("");
		exit;
	}
	$dbquery="select pollno from minipollq order by pollno desc limit 1";
	$result = mysql_query($dbquery) or die("mysql_query error(minipollq table select)");
	if($row = mysql_fetch_array($result)){
		$pollno = $row[pollno]+1;
	}else{
		$pollno = 1;
	}
	$dbquery="insert into minipollq (pollno,userid,question,items,answers,etc,start_date,stop_date,must,polltime)
					VALUES ($pollno,'$logid','$question','$items','$answers','$etc','$start_date','$stop_date','$must',now())";
	$result2 = mysql_query($dbquery);
	if($result2!="1"){
		echo $dbquery."<br>".mysql_error();
		echo " <a href='$PHP_SELF?mode='>투표</a>";
	}else{
		movepage("$PHP_SELF?mode=");
		bye("");
	}
}else if($mode == "delete"){
	$pollno = htmlentities(urlencode($pollno));
	
	if($logid == 'run4joy'){
		$dbquery="delete from minipollq where pollno = $pollno";
	}else{
		$dbquery="delete from minipollq where pollno = $pollno and userid = '$logid'";
	}
	$result = mysql_query($dbquery);
	if($result!="1"){
		echo $dbquery."<br>".mysql_error();
		echo " <a href='$PHP_SELF?mode='>투표</a>";
	}else{
		$dbquery="delete from minipolla where pollno = $pollno";
		$result = mysql_query($dbquery);
		movepage("$PHP_SELF?mode=");
		bye("");
	}
}else if($mode == "poll"){
	if($pollano == ""){
		echo "<script>alert('응답하십시오.')</script>";
		movepage("$PHP_SELF?mode=&pollno=$pollno");
		bye("");
	}
	
	$dbquery="select * from minipollq where pollno = $pollno";
	$result = mysql_query($dbquery) or die("mysql_query error(minipollq table select)");
	if(($row = mysql_fetch_array($result))){
		if($yyyymmdd < $row[start_date] || $yyyymmdd > $row[stop_date]){
			echo "<script>alert('설문조사 기간이 아닙니다.')</script>";
			movepage("$PHP_SELF?mode=");
			bye("");
		}
	}else{
		echo "<script>alert('설문이 이상합니다.')</script>";
		movepage("$PHP_SELF?mode=");
		bye("");
	}
		
	$pollno = htmlentities(urlencode($pollno));
	$selected = htmlentities(urlencode($selected));
	$items = htmlentities(urlencode($items));
//	$etc = htmlentities ($etc);
	
	if($items != $pollano) $etc = "";	// etc 무시
	if(strlen($etc) > $etclength)
		$etc = substr($etc, $etclength);
	$selected = $pollano;
	$dbquery="insert into minipolla (pollno,userid,selected,etc,polltime)
					VALUES ($pollno,'$logid','$selected','$etc',now())";
	$result2 = mysql_query($dbquery);
	if($result2!="1"){
//		echo $dbquery."<br>".mysql_error();
		echo "이미 투표하셨습니다.";
		echo "<br><a href='$PHP_SELF?mode='>투표</a>";
	}else{
		movepage("$PHP_SELF?mode=result&pollno=$pollno");
		bye("");
	}
}else{
	echo "이상한 옵션";
}	    

echo "</font></center>
</body>
</html>";

function	pollresult(){
	global $pollno, $yyyymmdd, $logid, $PHP_SELF, $userid;
	$dbquery="select * from minipollq where pollno=$pollno";
	$result = mysql_query($dbquery) or die("mysql_query error(minipollq table select)");
	if(!($rowq = mysql_fetch_array($result))){
		echo "설문이 없습니다.<br><br>\n";
	}else{
echo "<!-- TRUE $yyyymmdd $rowq[start_date] $rowq[stop_date] -->";
		if($yyyymmdd >= $rowq[start_date] && $yyyymmdd <= $rowq[stop_date]){
			$valid = TRUE;
		}else{
			$valid = FALSE;
		}
		$items = $rowq[items];
		$userid = $rowq[userid];
		$dbquery="select * from minipolla where pollno=$pollno";
		$result = mysql_query($dbquery) or die("mysql_query error(minipolla table select)".mysql_error());
		$etc = "";
		$answer = array();
		for($i = 0; $i < $items+1; $i++)
			$answer[$i] = 0;
		for($ano = 0; $rowa = mysql_fetch_array($result); $ano++){
			$answer[0+$rowa[selected]]++;
			if($rowa[selected] == $items)
//				$etc .= "-".mb_convert_encoding($rowa[etc],"UTF-8","EUC-KR")."<br>";
				$etc .= "-".$rowa[etc]."<br>";
		}
		$polldays = str_replace("-",".",substr($rowq[start_date], 5));
		$dbquery2="select name from member where userid='$rowq[userid]'";
		$result2 = mysql_query($dbquery2) or die("mysql_query error(member table select)".mysql_error());
		$rowname = mysql_fetch_array($result2);
		
		if($rowq[start_date]!=$rowq[stop_date])
			$polldays .= "~".str_replace("-",".",substr($rowq[stop_date], 5));
		echo "$pollno. $rowq[question][$rowname[name], $polldays]<br>\n";
		$width=140;
		if($ano == 0){
			echo "<br>투표수가 0입니다.<br><br>\n";
			if($valid){
				echo " <a href='$PHP_SELF?mode=&pollno=$pollno'>투표</a>";
			}
			errornback("");
			exit;
		}
			
		$param = explode("<>", $rowq[answers]);
		for($i = 0;$i < $items; $i++){
			$ratio = $answer[$i]/$ano;
		    echo "<br>".($i+1).". $param[$i] : ". round($ratio*100,2) ."% ($answer[$i]/$ano)\n";
		    echo "<table><tr><td height=5 bgcolor=red width=".round($ratio*$width)."></table>\n";
		}
		if($etc)
			echo "기타의견:<br>".$etc;
		echo "<br><br>\n";
		if($valid){
			$dbquery="select * from minipolla where pollno=$pollno and userid='$logid'";
//echo $dbquery;
			$result2 = mysql_query($dbquery) or die(mysql_error());
			if(mysql_num_rows($result2) == 0){	// 설문 비응답 상태
				echo " <a href='$PHP_SELF?mode=&pollno=$pollno'>투표</a>";
			}
		}
	}
}
function	polllist(){
	global $yyyymmdd, $logid, $PHP_SELF, $pageitems, $member, $page;
	
	$dbquery="select * from minipollq where start_date >= '$yyyymmdd' or userid = '$logid' order by pollno desc";
	$result = mysql_query($dbquery) or die("mysql_query error(minipollq table select)");
	$allrows = mysql_num_rows($result);
	$allpage = floor($allrows / $pageitems);
	if($allpage == 0)
		$allpage = 1;
	if($page < 1 || $page == "") $page = 1;
	if($page > 1)
		mysql_data_seek($result, ($page - 1) * $pageitems);
//echo "<script>alert('$member[user_id] $yyyymmdd');</script>\n";

	for($i=0; ($row = mysql_fetch_array($result)) && $i < $pageitems; $i++){
		if($row[stop_date] < $yyyymmdd){
			$mode = "result";
		}else{
//echo "<script>alert('$member[user_id] $row[must] $yyyymmdd');</script>\n";
			if($member[user_id] == 'run4joy' && $row[must] == 'Y'){
				echo "<script>alert('다음 설문에 응해주십시오.\n$row[question]');</script>\n";
			}
			$dbquery="select * from minipolla where pollno=$row[0] and userid='$logid'";
//echo $dbquery;
			$result2 = mysql_query($dbquery) or die(mysql_error());
			if(mysql_num_rows($result2) == 1){	// 설문 응답 상태
				$mode = "result";
			}else{
				$mode = "";
			}
		}
		echo "<font color=red>★</font><a href='$PHP_SELF?mode=$mode&pollno=$row[pollno]'>".cut_str21($row[pollno].". ".$row[question], 40)."</a><br>";
	}
	echo "<br><div align=center>\n";
	$i = $page - 2;
	if($i < 1) $i = 1;
	for($j=0; $j < $pageitems && $page <= $allpage; $j++){
		if($page == $i)
			echo " $i ";
		else
			echo " <a href='$PHP_SELF?mode=result&page=$i'>$i</a> ";
		$page++;
	}
	echo "</div>\n";
}	

?>
</center>
</body>
</html>
