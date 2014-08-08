<?php
// 2005.5.8 : 훈련일 기준을 training table에서 message table로 변경

require("./bmauth.php");
require("./bmconfig.php");
require("./bmfunction.php");

$trainingmanager = "('김영철','박순창','이경규')";
// select yyyymmdd,name,userid,onoff from training order by yyyymmdd,name;

top("");
heading("정모 출석부");

if($mode == "training-inputcheck"){
	// 여기는 테스트용이고 여기 내용이 실제 기능을 필요로 하는 곳에 아래 '여기까지 복사' 부분까지 복사하여 사용
	// 적용1. outlogin.php

	// SQL에서 IN (SELECT ...)이 안먹어 select문 둘로 분리 처리
	//	$dbquery="SELECT distinct yyyymmdd FROM training WHERE yyyymmdd NOT IN (SELECT yyyymmdd FROM training WHERE userid='$logid' AND (onoff='Y' OR onoff='N'))";
	// 장차 날짜를 6개월로 제한할 필요 있음
	$dbquery="SELECT distinct yyyymmdd FROM training where yyyymmdd > '2007' order by yyyymmdd desc";
	$result1 = mysql_query($dbquery) or die("mysql_query error(training table select in):".mysql_error());
	$allrows = mysql_num_rows($result1);
	$dbquery="SELECT yyyymmdd FROM training WHERE userid='$logid' AND (onoff='Y' OR onoff='N') and yyyymmdd > '2007' ";
	$result2 = mysql_query($dbquery) or die("mysql_query error(training table select2):".mysql_error());
	$onoffrows = mysql_num_rows($result2);
	if($allrows > $onoffrows){
		$onoffymds="";
		for($i=0; $row=mysql_fetch_array($result2); $i++){

		    	$onoffymds .= "$row[0]:";
		}
//echo "onoffymds=$onoffymds ";
		$yyyymmdds="";
		for($i=0; $row=mysql_fetch_array($result1); ){
		    $yyyymmdd = $row[0];
		    if(strpos($onoffymds, $yyyymmdd) === false){
			if($i > 0){
		    		$yyyymmdds .= ":$row[0]";
	    		}else{
		    		$yyyymmdds .= "$row[0]";
	    		}
	    		$i++;
	    		if($allrows == ($onoffrows + $i)) break;
    		    }
		}
//echo "yyyymmdds=$yyyymmdds ";
		echo "
<script>
trainingedit=window.open('/bbs/bmtraining.php?mode=training-edit2&yyyymmdds=$yyyymmdds','trainingedit','width=300,height=400,statusbar=no,toolbar=no,resizable=yes')
</script>";
	}
// 여기까지 복사

	echo "</body></html>\n";
	die();
}
//echo "QUERY_STRING =".$QUERY_STRING ;

if($mode == "training-edit2" || $mode == "training-update2"){
    if($mode == "training-edit2"){
	    echo "<script>window.focus()</script>";
//echo " yyyymmdds=$yyyymmdds, ".$_GET['yyyymmdds'];
	echo "<br><br>날짜별 출석 상황을 입력해 주십시오.\n";
	$param = explode(":",$yyyymmdds); // 20041024:20041031:20041107
	echo "<form action='$PHP_SELF' method=post>
<input type=hidden name=mode value='training-update2'>
<table border=1>
<tr><th>날짜</th><th>참석여부</th></tr>";
	for($i=0;$i<count($param); $i++){
		    echo "<tr><td>$param[$i]";
		    echo "<td><input type='radio' name='onoff[$i]' value='$param[$i]:Y'>참석\n";
		    echo "<input type='radio' name='onoff[$i]' value='$param[$i]:N'>불참\n";
	}

	echo "<tr><td colspan=2 align=center> <input type=submit value='처리'></td></tr>
</form>
</table>\n";
    }else if($mode == "training-update2"){
	$dbquery="select name from member where userid='$logid'";
//echo "dbquery000=$dbquery ";
	$result = mysql_query($dbquery) or die("mysql_query error(member table select)");
	$row = mysql_fetch_array($result);
	$name = $row[0];
//echo "count=".count($onoff)." ";
	    for($i=0; $onoff[$i]; $i++){
//echo "onoff=$onoff[$i] ";
		$param = explode(":",$onoff[$i]);
//echo "param[0]=$param[0] param[1]=$param[1] \n";
		$dbquery="insert into training (yyyymmdd,name,userid,onoff)
					VALUES ('$param[0]','$name','$logid','$param[1]')";
//echo "dbquery00=$dbquery ";
		$result2 = mysql_query($dbquery);
//echo "result2=".$result2;
		if($result2!="1"){
			$dbquery="update training set onoff='$param[1]' where yyyymmdd='$param[0]' and userid='$logid'";
//echo "dbquery01=$dbquery ";
			$result3 = mysql_query($dbquery);
			if($result3!="1"){
				errornback("training table에 수정할 수 없습니다.\n<br>$dbquery\n");
				die();
			}
		}
	    }
	echo "<br><font size='+1'>정모 출석 처리 완료</font>\n";
	echo "<script>SetTimeout(\"window.close();\",5*1000);</script>";
	echo "<br><br><a href='javascript:window.close()'>닫기</a>";
    }
echo "</center>
</body>
</html>\n";
die();
}

if($mode == "batch-input" || $mode == "batch-update"){
	if($mode=="batch-input"){
	echo "<form action='$PHP_SELF' method=post>
<input type=hidden name=mode value='batch-update'>
<table border=1>
<tr><td colspan=3 align=center>정모 참석자 일괄 입력</td></tr>
<tr><td>날짜</td><td><input type='text' name='yyyymmdd' maxlength=10 size=10> yyyy/mm/dd</td></tr>
<tr><td>참석자명단</td><td><textarea name=alluser rows=8 cols=60></textarea> 콤마와 라인으로 참석자 구분</td></tr>
<tr><td>내용</td><td><textarea name=msg rows=4 cols=60></textarea>내용을 쓰면 이전 내용 없어짐</td></tr>
<tr><td colspan=2 align=center> <input type=submit value='처리'></td></tr>
</form>
</table>\n";
		
	}elseif($mode=="batch-update"){
		echo "정모 참석자 일괄 입력<br><br>";
		if(($yyyymmdd2 = daycheck($yyyymmdd))== false){
			die();
		}
		$users = explode("\n",$alluser);
		for($i=0;$i<count($users); $i++){
			$users[$i] = ltrim(rtrim($users[$i]));
			$oneuser = explode(",",$users[$i]);
			for($j=0;$j<count($oneuser); $j++){
				$oneuser[$j] = ltrim(rtrim($oneuser[$j]));
				if(strlen($oneuser[$j])>0){
//	echo "$i,$j = $oneuser[$j]<br>";
					$dbquery="select userid from member where name = '$oneuser[$j]'";
					$result = mysql_query($dbquery) or die("mysql_query error(member select error)");
					if(mysql_num_rows($result) != 1){
						echo "<br>$oneuser[$j] : 이름이 이상합니다.<br>";
					}else{
						$row = mysql_fetch_array($result);
						$dbquery="insert into training (yyyymmdd,name,userid,onoff)
								VALUES ('$yyyymmdd2','$oneuser[$j]','$row[0]','Y')";
						$result = mysql_query($dbquery);
						if($result!="1"){
							echo"<br>$oneuser[$j] : training table에 추가할 수 없습니다.<br>";
						}else{
							echo"<br>$oneuser[$j] : 추가";
						}
					}
				}
			}
		}
		echo "<br>";
		if(strlen($msg)>0){
			$dbquery="insert into message (type,yyyymmdd,msg) VALUES ('training','$yyyymmdd2','$msg')";
			$result = mysql_query($dbquery);
			if($result == false){
				$dbquery="update message set msg='$msg' where type = 'training' and yyyymmdd = '$yyyymmdd2'";
				$result = mysql_query($dbquery);
echo "<br>dbquery=$dbquery";
			}else{
echo "<br>dbquery=$dbquery";
			}

		}
	}
echo "</center>
</body>
</html>\n";
die();
echo "---------------------------";
}

if(!$yyyymmdd){
	if(!$yyyy && !$mm){
		$date = getdate();
		$yyyy = $date['year'];
		$mm = $date['mon'];
		$dd = $date['mday'];
	}else{
		$yyyymmdd = "$yyyy/$mm";
	}
//echo "year=$yyyy,month=$mm,day=$dd ";
}else{
	$yyyymmdd = str_replace(";", "/", $yyyymmdd);
	$yyyymmdd = str_replace(":", "/", $yyyymmdd);
	$yyyymmdd = str_replace(".", "/", $yyyymmdd);
	$yyyymmdd = str_replace(" ", "/", $yyyymmdd);
//echo "yyyymmdd=$yyyymmdd membercount=$membercount ";
	if(!($yyyymmdd=daycheck($yyyymmdd)))
		return;
	if(strlen($yyyymmdd)<8){
		errornback("날짜가 틀립니다.");
		return;
	}
	$yyyy = substr($yyyymmdd,0,4);
	$mm = substr($yyyymmdd,5,2);
	$dd = substr($yyyymmdd,8,2);
}

$dbquery="select name,userid from member where name in $trainingmanager";
$result = mysql_query($dbquery) or die("mysql_query error(member table select)");
$trainingmanagername = "";
$iammanager = "seosc";
for(; $row=mysql_fetch_array($result); ){
	if($row[1] != "run4joy"){
		$trainingmanagername .= $row[0]." ";	// run4joy 표시 삭제
	}
	if($row[1] == $logid){
		$iammanager = "Yes";
//echo "training row[1]=$row[1] ";
	}
}
if($trainingmanagername == "")
	$trainingmanagername = "미상";

if($mode!="training-input" && $mode!="training-edit"){
echo "
<table border=0><tr>
<form action='$PHP_SELF' method=post>
<input type=hidden name=mode value='training-list'>
<td><select name='yyyy' size='1' style='background-color: white; color: blue; font:10pt'>\n";
		for($i = 2004; $i <= $yyyy; $i++){
			echo "<option value='$i'";
			if($yyyy==$i)
				echo " selected";
			echo ">$i</option>\n";
		}
echo "</select>년
<td><select name='mm' size='1' style='background-color: white; color: blue; font:10pt'>\n";
		for($i = 1; $i <= 12; $i++){
			echo "<option value='$i'";
			if($mm==$i)
				echo " selected";
			echo ">$i</option>\n";
		}
		$allmonth="전체";
		echo "<option value='$allmonth'";
		if($mm==$allmonth)
			echo " selected";
		echo ">$allmonth</option>\n";

echo "</select>월
<td> <input type=submit value='조회'>
<td>관리자:$trainingmanagername</td></tr>
</form>
</table>\n";
}

	if($mm==$allmonth) {
		$yyyymm=$yyyy;
		$yyyymm2=$yyyy-1;
		$yyyymm2dd=$yyyymm2."/12/31";
	}else{
		if($mm==1) {
			$mm2=12;
			$yyyy2=$yyyy-1;
		}else{
			$mm2=$mm-1;
			$yyyy2=$yyyy;
		}
		$yyyymm=daycheck("$yyyy/$mm");
		$yyyymm2=daycheck("$yyyy2/$mm2");
		$yyyymm2dd=$yyyymm2."/31";
	}
//echo "yyyy2=$yyyy2 mm2=$mm2 ";


if(!($mode == "" || $mode == "training-list")){
	if(privcheck($logid) < 2 || $iammanager == ""){
		errornback("관리자가 아닙니다.");
		return;
	}
}

if($mode == "training-input" || $mode == "training-insert"){

	$dbquery="select yyyymmdd from message where type = 'training' and yyyymmdd like '$yyyymmdd'"; //기준이 training table에서 message tabke로 변경(2군데)
	$dayresult = mysql_query($dbquery) or die("mysql_query error(training select error)");
	if(mysql_num_rows($dayresult) > 0){	// null row
		errornback("이미 입력된 날짜입니다. 다른 날짜를 지정하십시오.");
		return;
	}
	mysql_free_result($dayresult);

	if($mode == "training-insert"){
		
	    for($i=0; $i < $membercount; $i++){
		$param = explode(":",$onoff[$i]);
//echo "param[0]=$param[0] param[1]=$param[1] param[2]=$param[2] \n";
		if($param[2] == "Y"){
			$dbquery="insert into training (yyyymmdd,name,userid,onoff)
						VALUES ('$yyyymmdd','$param[0]','$param[1]','$param[2]')";

//echo "dbquery00=$dbquery ";
			$result = mysql_query($dbquery);

			if($result!="1"){
				errornback("training table에 추가할 수 없습니다.\n<br>$dbquery\n");
				return;
			}
		}
	    }
	    
		$addattenders = str_replace ("\r\n", ",", $addattenders);
		$attenders = explode(",",$addattenders);
		foreach($attenders as $attender){
			$attender = trim($attender);
			if($attender == "")
				continue;
			$dbquery="select userid from member where name = '$attender'";
			$result = mysql_query($dbquery) or die("mysql_query error(member table select)");
			if(mysql_num_rows($result) != 1){
				echo "<br>XXXXXXXXXXXXXXXXXXX 이상:$attender <br>";
				continue;
			}
			$row=mysql_fetch_array($result);
			$dbquery="insert into training (yyyymmdd,name,userid,onoff)
						VALUES ('$yyyymmdd','$attender','$row[0]','Y')";

			$result = mysql_query($dbquery);
		}
		$dbquery="delete from message where type = 'training' and yyyymmdd = '$yyyymmdd'";
//echo "dbquery00=$dbquery ";
		$result = mysql_query($dbquery);
		$dbquery="insert into message (type,yyyymmdd,msg) VALUES ('training','$yyyymmdd','$msg')";
//echo "dbquery01=$dbquery ";
		$result = mysql_query($dbquery);
		if($result!="1"){
			errornback("message table에 추가할 수 없습니다.\n<br>$dbquery\n");
			return;
		}
	}else if($mode == "training-input"){

/*
		$dbquery="insert into training (yyyymmdd,name,userid,onoff)
					VALUES ('$yyyymmdd','null','null','')";
		$result = mysql_query($dbquery);
		if($result!="1"){
			errornback("training table에 추가할 수 없습니다.\n<br>$dbquery\n");
			return;
		}
*/
	}
}else if($mode == "training-update"){
	for($i=$no_on=0; $i < $membercount; $i++){
		$param = explode(":",$onoff[$i]); // name:userid:onoff
//echo "param[0]=$param[0] param[1]=$param[1] param[2]=$param[2] \n";
		if(substr($param[2],0,1) == "Y"){
			$no_on++;
		}
		if(strlen($param[2]) == 2){	// 변경 없으면 YY or NN
			continue;
		}
		$dbquery="insert into training (yyyymmdd,name,userid,onoff)
					VALUES ('$yyyymmdd','$param[0]','$param[1]','$param[2]')";
//echo "dbquery00=$dbquery ";
		$result = mysql_query($dbquery);
		if($result!="1"){
			$dbquery="UPDATE training SET onoff='$param[2]' WHERE yyyymmdd='$yyyymmdd' and name='$param[0]' and userid='$param[1]'";
			$result = mysql_query($dbquery);
			if($result!="1"){
				errornback("training table에 처리할 수 없습니다.\n$dbquery\n");
				return;
			}
		}
	}
	if($no_on == 0 and $msg == ""){
		$dbquery="delete from training where yyyymmdd='$yyyymmdd'";
		$result = mysql_query($dbquery) or die("mysql_query error(training table delete)");
/*
		if(mysql_affected_rows() == 0){
			errornback("training table에서 삭제할 수 없습니다.\n$dbquery\n");
			return;
		}
*/
		$dbquery="delete from message where type='training' and yyyymmdd='$yyyymmdd'";
		$result = mysql_query($dbquery) or die("mysql_query error(message table delete)");
	}else{
		$dbquery="update message set msg='$msg' where type='training' and yyyymmdd='$yyyymmdd'";
		$result = mysql_query($dbquery) or die("mysql_query error(message table update)");
//echo "dbquery000=$dbquery result=$result ";
//echo "mysql_affected_rows=".mysql_affected_rows();
	}
/*
	if(mysql_affected_rows() >= 0){ // update에서 같은 내용이면 0 return함. 어떻게 처리???
		errornback("message table에 처리할 수 없습니다.\n<br>$dbquery\n");
		return;
	}
*/
}else if($mode == "training-delete"){ // 불필요:모두 불참이고 내용 없으면 데이터 남지 않음
	;
}

///
$trainingday = array();
$trainingcount = array();
$trainingdayofweek = array();

if($mode == "training-input" || $mode == "training-edit"){
	$trainingdays = 1;
	$trainingday[$trainingdays] = $yyyymmdd;
}else{
// 훈련한 기준일이 training table에서 message table로 변경(2군데)
//	$dbquery="select distinct yyyymmdd from training where yyyymmdd like '$yyyymm%' order by yyyymmdd";
	$dbquery="select yyyymmdd from message where type='training' and yyyymmdd like '$yyyymm%' order by yyyymmdd";
	$dayresult = mysql_query($dbquery) or die("mysql_query error(training select error)");
	for($trainingdays=0; $row=mysql_fetch_array($dayresult); $trainingdays++){
//echo "trainingday=$row[0] ";
		$trainingday[$trainingdays] = $row[0];
	}
	mysql_free_result($dayresult);
}

if(!($mode == "training-input" || $mode == "training-edit" || $mode == "training-edit2" || $mode == "training-update2")){
	for($i=0; $i < 7; $i++){
		$lastsunday = mktime (0,0,0,date("m"),date("d")-$i,date("Y"));
		if(date("D", $lastsunday) == "Sun")
			break;
	}
	$date = getdate($lastsunday);
	$exyyyymmdd = $date['year']."/".$date['mon']."/".$date['mday'];
	$exyyyymmdd=daycheck($exyyyymmdd);
	echo "<table border=1><tr><form action='$PHP_SELF' method=post>
<input type=hidden name=mode value='training-input'>
<td><input type='text' name='yyyymmdd' value='$exyyyymmdd' maxlength=10 size=10>
<td><input type=submit value='정모 훈련일 추가'>
</tr></form>\n";
	if($trainingdays > 0){
		echo "<tr><form action='$PHP_SELF' method=post>
<input type=hidden name=mode value='training-edit'>
<td><select name='yyyymmdd' size='1' style='background-color: white; color: blue; font:10pt'>\n";
		for($i = 0; $i < $trainingdays; $i++){
			echo "<option value='$trainingday[$i]'>$trainingday[$i]</option>\n";
		}
		echo "</select>
<td><input type=submit value='훈련참석자료 수정'>
</tr></form>
<tr><td colspan=2 align=center><a href='$PHP_SELF?mode=batch-input'>참석자 일괄 처리<a>\n";
	}
	echo "</table>\n";
}
///

    if($mode == "training-input" || $mode == "training-edit"){
		echo "<p><table border=1><tr><th>날짜 : $trainingday[$trainingdays]</th></table>\n";
		$trainingcount[$trainingdays] = 0;
		echo "<p><table border=1>\n";
		echo "<form action='$PHP_SELF' method=post>
<input type=hidden name=yyyymmdd value='$yyyymmdd'>\n";
		if($mode == "training-input"){
			echo "<input type=hidden name=mode value='training-insert'>\n";
		}else{
			echo "<input type=hidden name=mode value='training-update'>\n";
		}
    }else{
	echo "<p><table border=1><tr><th>이름";
		for($i=0; $i < $trainingdays; $i++){
			echo "<th>";
				$trainingdayofweek[$i] = date("w", mktime(0,0,0,substr($trainingday[$i],5,2), substr($trainingday[$i],8,2), substr($trainingday[$i],0,4)));
//				echo "<br>d=".$trainingdayofweek[$i];
				if($trainingdayofweek[$i] == 0){
					echo "<font color='red'>";
				}else{
					echo "<font color='blue'>";
				}
			if($mm=="전체"){
				echo substr($trainingday[$i],5,2)." ".substr($trainingday[$i],8);
			}else{
				echo substr($trainingday[$i],5);
			}
			echo "</font>";

			echo "</th>";
			$trainingcount[$i] = 0;
		}
		if($mm=="전체"){
			echo "<th>통계</th><th>이름</th>";
		}
		if($trainingdays == 0)
			echo "<th>훈련 결과가 없습니다.\n";
    }
	echo "</tr>\n";

	$dbquery="select userid, name from member where membertype in ('정회원','준회원') order by name";
	$nameresult = mysql_query($dbquery) or die("mysql_query error(member select error)");
	for($i=0; $trainingdays > 0 && $namerow=mysql_fetch_array($nameresult); $i++){
	    if($mode == "training-input" || $mode == "training-edit"){
		if($i % 5 == 0) echo "<tr>";
		echo "<td>$namerow[1]";
	    }else{
		echo "<tr><td>$namerow[1]";
	    }
	    if($mode == "training-input"){
		    echo "<input type='radio' name='onoff[$i]' value='$namerow[1]:$namerow[0]:Y' >참석 ";
		    echo "<input type='radio' name='onoff[$i]' value='$namerow[1]:$namerow[0]:N' checked>불참\n";
	    }else if($mode == "training-edit"){
			$dbquery="select onoff from training where yyyymmdd='$yyyymmdd' and userid='$namerow[0]'";
			$oneresult = mysql_query($dbquery) or die("mysql_query error(training select error)");
			$onerow=mysql_fetch_array($oneresult);
			if($onerow[0] == "Y"){
			    echo "<input type='radio' name='onoff[$i]' value='$namerow[1]:$namerow[0]:YY' checked>참석 ";
			    echo "<input type='radio' name='onoff[$i]' value='$namerow[1]:$namerow[0]:N'>불참\n";
			}else{
			    echo "<input type='radio' name='onoff[$i]' value='$namerow[1]:$namerow[0]:Y' >참석 ";
			    echo "<input type='radio' name='onoff[$i]' value='$namerow[1]:$namerow[0]:NN' checked>불참\n";
			}
			mysql_free_result($oneresult);
	    }else{
			$dbquery="select yyyymmdd,userid,onoff from training where yyyymmdd like '$yyyymm%' and userid='$namerow[0]' and onoff='Y' order by yyyymmdd";
			$trainingresult = mysql_query($dbquery) or die("mysql_query error(training select error)");
if($logid==$namerow[0]) echo "<!-- dbquery=$dbquery -->";
			for($j=$k=$score=0; $trainingrow=mysql_fetch_array($trainingresult); $j++){
				for( ;$j<$trainingdays && $trainingday[$j]!=$trainingrow[0]; $j++){
if($logid==$namerow[0]) echo "<!-- ($j<$trainingdays && $trainingday[$j]!=$trainingrow[0])-->";
					echo "<td>";
				}
				if($j<$trainingdays){
					echo "<td align=center>●";
					$trainingcount[$j]++;
					$k++;
					if($trainingdayofweek[$j] == 0){
						$score += 2;
					}else{
						$score += 1;
					}
				}
			}
			if($j == 0){ // <td> 생략
			}
			if($mm=="전체"){
				for(; ($trainingdays - $j) > 0; $j++){
					echo "<td>";
				}
				echo "<td align=right>$k/$trainingdays <br> $score";
				echo "	<td>$namerow[1]";
			}
			mysql_free_result($trainingresult);
	    }
		echo "</tr>\n";
	}
	mysql_free_result($nameresult);

	$membercount = $i;
	echo "<tr><td>총 $membercount 명";
    if($mode == "training-input" || $mode == "training-edit"){
	if($mode == "training-edit"){
		$dbquery="select yyyymmdd,msg from message where type='training' and yyyymmdd = '$yyyymmdd'";
		$result = mysql_query($dbquery) or die("mysql_query error(message select error)");
		if($row=mysql_fetch_array($result)){
			$msg = $row[1];
		}
	}else{
		$msg = "";
	}
	echo "</td></tr></table><table><tr><td align=center>훈련이모저모<td><textarea name=msg rows=10 cols=70>$msg</textarea>\n";
	echo "<input type=hidden name=membercount value='$membercount'></td><td>&lt;img src='/bbs/data2/photo/xxxxx.JPG'&gt;<br>&lt;img src=''&gt;</tr>\n";
	if($mode == "training-input")
		echo "<tr><td>추가 참가자 리스트</td><td colspan=2><textarea name=addattenders rows=8 cols=70></textarea></td><td>콤마로 구분, 여러 라인/블랭크 가능</td></tr>";
	echo "</table><table><tr><td><input type=submit value='훈련 입력 처리'>
</td></form>\n";
    }else{
	for($i=0; $i < $trainingdays; $i++){
		echo "<td align=center>$trainingcount[$i]";
		if($mm=="전체") echo "<br>";
		echo "명";

	}
    }
	echo "</tr></table>\n";
    if($mm != "전체" && !($mode == "training-input" || $mode == "training-edit"|| $mode == "training-edit2" || $mode == "training-update2")){
	echo "<table border=1><tr><th>날짜<th>훈련이모저모</tr>\n";
	$dbquery="select yyyymmdd,msg from message where type='training' and yyyymmdd like '$yyyymm%' order by yyyymmdd";
//echo "dbquery=$dbquery \n";
	$msgresult = mysql_query($dbquery) or die("mysql_query error(message select error)");
	for(; $msgrow=mysql_fetch_array($msgresult); ){
		echo "<tr><td>$msgrow[0]<td>".nl2br($msgrow[1])."\n";
	}
	echo "</table>\n";
    }
	if(privcheck($logid)<2 || $iammanager == "" || $mode=="training-edit"){
		return;
	}

mysql_close() or die("mysql_close error");

?>
</center>
</body>
</html>
