
<?php
require("./bmauth.php");
require("./bmconfig.php");
require("./bmfunction.php");

/*
CREATE TABLE clubtraining (
  tday DATE NOT NULL,
  memo TEXT NOT NULL,
  type VARCHAR(20),
  PRIMARY KEY (tday)
);
*/

top("");
heading("Ŭ�� �ְ� �Ʒ� ��ȹ");

if($mode == "" || $mode == "select" || $mode == "select2"){
	if($weeks == ""){
		$days = 7;
	}else{
		$days = $weeks * 7;
	}
	if($yyyymmdd == ""){
		$date = getdate();
		$yyyymmdd = $date['year']."-".$date['mon']."-".$date['mday'];
		$dbquery="SELECT tday,memo,type FROM clubtraining where tday >= date_sub('$yyyymmdd', INTERVAL 7 DAY) order by tday limit " . $days;
	}else{
		if($datereverse != "on"){
			$weeks = "0";
		}else{
			$weeks = 7 * $weeks;
		}
		$dbquery="SELECT tday,memo,type FROM clubtraining where tday >= date_sub('$yyyymmdd', INTERVAL $weeks DAY) order by tday limit " . $days;
	}
	echo "<form action=$PHP_SELF method=post>
		<input type=hidden name=mode value='select'>
		<table><tr><td>
		��¥: <input name=yyyymmdd value='$yyyymmdd' size=12>
		�� ��: <input name=weeks value='$weeks' size=3>
		</td>
		<td><input type=checkbox name=datereverse>�Ųٷ�
		</td>
		<td><input type=submit value='������Ʈ�� ��ȸ'>
		</form>
		</td></tr></table><br><br>\n";
	$result1 = mysql_query($dbquery) or die("mysql_query error(clubtraining table : $dbquery):".mysql_error());
	$allrows = mysql_num_rows($result1);
	echo "<form action='$PHP_SELF' method=post>
<input type=hidden name=mode value='update'>
<table border=1>
<tr><th>��¥<th>�Ʒó���<th>����</tr>\n";
	$all = "";
	for($i=0; $row=mysql_fetch_array($result1); $i++){
		echo "<tr>
		<td><input name=tday[$i] value=$row[tday] size=12>
		<td><input name=memo[$i] value='$row[memo]' size=60>
		<td><input name=type[$i] value='$row[type]'>
		</tr>\n";
		$all .= $row[tday] . "|" . $row[memo] . "|" . $row[type] . "\n";
	}

	echo "<tr><td colspan=3 align=center> <input type=submit value='������Ʈ'></td></tr>
</form>
</table>\n";
	echo "<br><!--
$all
<br>
-->";;
}else if($mode == "update"){
	for($i=0; $tday[$i]; $i++){
		if($tday[$i] == ""){
		}else if($memo[$i] == "" && $type[$i] == ""){
			$dbquery="delete from clubtraining where tday='$tday[$i]'";
			$result2 = mysql_query($dbquery);
		}else{
			$dbquery="insert into clubtraining (tday,memo,type)
				VALUES ('$tday[$i]','$memo[$i]','$type[i]')";
			$result2 = mysql_query($dbquery);
			if($result2!="1"){
				$dbquery="update clubtraining set memo='$memo[$i]', type='$type[$i]' where tday='$tday[$i]'";
//echo "dbquery01=$dbquery ";
				$result3 = mysql_query($dbquery);
				if($result3!="1"){
					errornback("clubtraining table�� ������ �� �����ϴ�.\n<br>$dbquery\n");
					die();
				}
			}
		}
	}
	echo "<br><font size='+1'>���� ó�� �Ϸ�</font>\n";
	echo "<br><br><a href='$PHP_SELF?mode=select&yyyymmdd=$yyyymmdd'>��ȸ</a>";
}
echo "</center>
</body>
</html>\n";
die();

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
		errornback("��¥�� Ʋ���ϴ�.");
		return;
	}
	$yyyy = substr($yyyymmdd,0,4);
	$mm = substr($yyyymmdd,5,2);
	$dd = substr($yyyymmdd,8,2);
}

$dbquery="select name,userid from member where name in $trainingmanager";
$result = mysql_query($dbquery) or die("mysql_query error(member table select)");
$trainingmanagername = "";
$iammanager = "";
for(; $row=mysql_fetch_array($result); ){
	if($row[1] != "run4joy"){
		$trainingmanagername .= $row[0]." ";	// run4joy ǥ�� ����
	}
	if($row[1] == $logid){
		$iammanager = "Yes";
//echo "training row[1]=$row[1] ";
	}
}
if($trainingmanagername == "")
	$trainingmanagername = "�̻�";

if($mode!="training-input" && $mode!="training-edit"){
echo "
<table border=0><tr>
<form action='$PHP_SELF' method=post>
<input type=hidden name=mode value='training-list'>
<td><select name='yyyy' size='1' style='background-color: white; color: blue; font:10pt'>\n";
		for($i = 2004; $i <= 2006; $i++){
			echo "<option value='$i'";
			if($yyyy==$i)
				echo " selected";
			echo ">$i</option>\n";
		}
echo "</select>��
<td><select name='mm' size='1' style='background-color: white; color: blue; font:10pt'>\n";
		for($i = 1; $i <= 12; $i++){
			echo "<option value='$i'";
			if($mm==$i)
				echo " selected";
			echo ">$i</option>\n";
		}
		$allmonth="��ü";
		echo "<option value='$allmonth'";
		if($mm==$allmonth)
			echo " selected";
		echo ">$allmonth</option>\n";

echo "</select>��
<td> <input type=submit value='��ȸ'>
<td>������:$trainingmanagername</td></tr>
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
		errornback("�����ڰ� �ƴմϴ�.");
		return;
	}
}

if($mode == "training-input" || $mode == "training-insert"){

	$dbquery="select yyyymmdd from message where type = 'training' and yyyymmdd like '$yyyymmdd'"; //������ training table���� message tabke�� ����(2����)
	$dayresult = mysql_query($dbquery) or die("mysql_query error(training select error)");
	if(mysql_num_rows($dayresult) > 0){	// null row
		errornback("�̹� �Էµ� ��¥�Դϴ�. �ٸ� ��¥�� �����Ͻʽÿ�.");
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
				errornback("training table�� �߰��� �� �����ϴ�.\n<br>$dbquery\n");
				return;
			}
		}
	    }
		$dbquery="delete from message where type = 'training' and yyyymmdd = '$yyyymmdd'";
//echo "dbquery00=$dbquery ";
		$result = mysql_query($dbquery);
		$dbquery="insert into message (type,yyyymmdd,msg) VALUES ('training','$yyyymmdd','$msg')";
//echo "dbquery01=$dbquery ";
		$result = mysql_query($dbquery);
		if($result!="1"){
			errornback("message table�� �߰��� �� �����ϴ�.\n<br>$dbquery\n");
			return;
		}
	}else if($mode == "training-input"){
/*
		$dbquery="insert into training (yyyymmdd,name,userid,onoff)
					VALUES ('$yyyymmdd','null','null','')";
		$result = mysql_query($dbquery);
		if($result!="1"){
			errornback("training table�� �߰��� �� �����ϴ�.\n<br>$dbquery\n");
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
		if(strlen($param[2]) == 2){	// ���� ������ YY or NN
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
				errornback("training table�� ó���� �� �����ϴ�.\n$dbquery\n");
				return;
			}
		}
	}
	if($no_on == 0 and $msg == ""){
		$dbquery="delete from training where yyyymmdd='$yyyymmdd'";
		$result = mysql_query($dbquery) or die("mysql_query error(training table delete)");
/*
		if(mysql_affected_rows() == 0){
			errornback("training table���� ������ �� �����ϴ�.\n$dbquery\n");
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
	if(mysql_affected_rows() >= 0){ // update���� ���� �����̸� 0 return��. ��� ó��???
		errornback("message table�� ó���� �� �����ϴ�.\n<br>$dbquery\n");
		return;
	}
*/
}else if($mode == "training-delete"){ // ���ʿ�:��� �����̰� ���� ������ ������ ���� ����
	;
}

///
$trainingday = array();
$trainingcount = array();

if($mode == "training-input" || $mode == "training-edit"){
	$trainingdays = 1;
	$trainingday[$trainingdays] = $yyyymmdd;
}else{
// �Ʒ��� �������� training table���� message table�� ����(2����)
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
<td><input type=submit value='���� �Ʒ��� �߰�'>
</tr></form>\n";
	if($trainingdays > 0){
		echo "<tr><form action='$PHP_SELF' method=post>
<input type=hidden name=mode value='training-edit'>
<td><select name='yyyymmdd' size='1' style='background-color: white; color: blue; font:10pt'>\n";
		for($i = 0; $i < $trainingdays; $i++){
			echo "<option value='$trainingday[$i]'>$trainingday[$i]</option>\n";
		}
		echo "</select>
<td><input type=submit value='�Ʒ������ڷ� ����'>
</tr></form>\n";
	}
	echo "</table>\n";
}
///
	echo "<p><table border=1><tr><th>�̸�";

    if($mode == "training-input" || $mode == "training-edit"){
		echo "<th>$trainingday[$trainingdays]</th>";
		$trainingcount[$trainingdays] = 0;
		echo "<form action='$PHP_SELF' method=post>
<input type=hidden name=yyyymmdd value='$yyyymmdd'>\n";
		if($mode == "training-input"){
			echo "<input type=hidden name=mode value='training-insert'>\n";
		}else{
			echo "<input type=hidden name=mode value='training-update'>\n";
		}
    }else{
		for($i=0; $i < $trainingdays; $i++){
			echo "<th>";
			if($mm=="��ü"){
				echo substr($trainingday[$i],5,2)."<br>".substr($trainingday[$i],8);
			}else{
				echo substr($trainingday[$i],5);
			}
			echo "</th>";
			$trainingcount[$i] = 0;
		}
		if($trainingdays == 0)
			echo "<th>�Ʒ� ����� �����ϴ�.\n";
    }
	echo "</tr>\n";

	$dbquery="select userid, name from member where membertype in ('��ȸ��','��ȸ��') order by name";
	$nameresult = mysql_query($dbquery) or die("mysql_query error(member select error)");
	for($i=0; $trainingdays > 0 && $namerow=mysql_fetch_array($nameresult); $i++){
		echo "<tr><td>$namerow[1]";
	    if($mode == "training-input"){
		    echo "<td><input type='radio' name='onoff[$i]' value='$namerow[1]:$namerow[0]:Y' >����\n";
		    echo "<input type='radio' name='onoff[$i]' value='$namerow[1]:$namerow[0]:N' checked>����\n";
	    }else if($mode == "training-edit"){
			$dbquery="select onoff from training where yyyymmdd='$yyyymmdd' and userid='$namerow[0]'";
			$oneresult = mysql_query($dbquery) or die("mysql_query error(training select error)");
			$onerow=mysql_fetch_array($oneresult);
			if($onerow[0] == "Y"){
			    echo "<td><input type='radio' name='onoff[$i]' value='$namerow[1]:$namerow[0]:YY' checked>����\n";
			    echo "<input type='radio' name='onoff[$i]' value='$namerow[1]:$namerow[0]:N'>����\n";
			}else{
			    echo "<td><input type='radio' name='onoff[$i]' value='$namerow[1]:$namerow[0]:Y' >����\n";
			    echo "<input type='radio' name='onoff[$i]' value='$namerow[1]:$namerow[0]:NN' checked>����\n";
			}
			mysql_free_result($oneresult);
	    }else{
			$dbquery="select yyyymmdd,userid,onoff from training where yyyymmdd like '$yyyymm%' and userid='$namerow[0]' and onoff='Y' order by yyyymmdd";
			$trainingresult = mysql_query($dbquery) or die("mysql_query error(training select error)");
if($logid==$namerow[0]) echo "<!-- dbquery=$dbquery -->";
			for($j=$k=0; $trainingrow=mysql_fetch_array($trainingresult); $j++){
				for( ;$j<$trainingdays && $trainingday[$j]!=$trainingrow[0]; $j++){
if($logid==$namerow[0]) echo "<!-- ($j<$trainingdays && $trainingday[$j]!=$trainingrow[0])-->";
					echo "<td>";
				}
				if($j<$trainingdays){
					echo "<td align=center>��";
					$trainingcount[$j]++;
					$k++;
				}
			}
			if($j == 0){ // <td> ����
			}
			if($mm=="��ü"){
				for(; ($trainingdays - $j) > 0; $j++){
					echo "<td>";
				}
				echo "<td align=right>$k/$trainingdays";
				echo "	<td>$namerow[1]";
			}
			mysql_free_result($trainingresult);
	    }
		echo "</tr>\n";
	}
	mysql_free_result($nameresult);

	$membercount = $i;
	echo "<tr><td>�� $membercount ��";
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
	echo "</td></tr></table><table><tr><td align=center>�Ʒ��̸�����<td><textarea name=msg rows=6 cols=60>$msg</textarea>\n";
	echo "<input type=hidden name=membercount value='$membercount'>
</td></tr><tr><td><td>img src='/bbs/data2/photo/xxxxx.JPG'</table><table><tr><td><input type=submit value='�Ʒ� �Է� ó��'>
</td></form>\n";
    }else{
	for($i=0; $i < $trainingdays; $i++){
		echo "<td align=center>$trainingcount[$i]";
		if($mm=="��ü") echo "<br>";
		echo "��";

	}
    }
	echo "</tr></table>\n";
    if($mm != "��ü" && !($mode == "training-input" || $mode == "training-edit"|| $mode == "training-edit2" || $mode == "training-update2")){
	echo "<table border=1><tr><th>��¥<th>�Ʒ��̸�����</tr>\n";
	$dbquery="select yyyymmdd,msg from message where type='training' and yyyymmdd like '$yyyymm%'";
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