<?php

require("./auth.php");
require("./config.php");
require("./function.php");

$trainingmanager = "jkt2004";
$inputitems = 5;	// �� ȭ���� ������ �Է� �ⳳ�׸� ��
// select yyyymmdd,name,userid,onoff from training order by yyyymmdd,name;

top("");
heading("���� �⼮��");

	include "../../bbs/_head.php";

echo "userid=$userid user_id=$user_id member[user_id]=$member[user_id] ";
echo "setup[grant_list]=$setup[grant_list] member[level]=$member[level] ";
phpinfo();
exit;
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

$dbquery="select name from member where userid='$trainingmanager'";
$result = mysql_query($dbquery) or die("mysql_query error(member table select)");
if($row=mysql_fetch_array($result))
	$trainingmanagername = $row[0];
else
	$trainingmanagername = "�̻�";

echo "</select>��
<td> <input type=submit value='��ȸ'>
<td>(������:$trainingmanagername)</td></tr>
</form>
</table>\n";
}

if(!($mode == "" || $mode == "training-list")){
	if(privcheck($logid) < 2 || $logid!=$trainingmanager){
		errornback("�����ڰ� �ƴմϴ�.");
		return;
	}
}

if($mode == "training-input" || $mode == "training-insert"){

	$dbquery="select yyyymmdd from training where yyyymmdd like '$yyyymmdd'";
	$dayresult = mysql_query($dbquery) or die("mysql_query error(training select error)");
	if(mysql_num_rows($dayresult) > 0){
		echo "�̹� �Էµ� ��¥�Դϴ�. �ٸ� ��¥�� �����Ͻʽÿ�.\n";
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
			$result = mysql_db_query("coretek",$dbquery);

			if($result!="1"){
				errornback("training table�� �߰��� �� �����ϴ�.\n<br>$dbquery\n");
				return;
			}
		}
	    }
		$dbquery="insert into message (type,yyyymmdd,msg) VALUES ('training','$yyyymmdd','$msg')";
//echo "dbquery00=$dbquery ";
		$result = mysql_db_query("coretek",$dbquery);
		if($result!="1"){
			errornback("message table�� �߰��� �� �����ϴ�.\n<br>$dbquery\n");
			return;
		}
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
		if($param[2] == "Y"){
			$dbquery="insert into training (yyyymmdd,name,userid,onoff)
						VALUES ('$yyyymmdd','$param[0]','$param[1]','$param[2]')";
		}else{// "N"
			$dbquery="delete from training where yyyymmdd='$yyyymmdd' and name='$param[0]' and userid='$param[1]'";
		}
//echo "dbquery00=$dbquery ";
		$result = mysql_db_query("coretek",$dbquery);
		if($result!="1"){
			errornback("training table�� ó���� �� �����ϴ�.\n$dbquery\n");
			return;
		}
	}
	if($no_on == 0){
		$dbquery="delete from message where type='training' and yyyymmdd='$yyyymmdd'";
		$result = mysql_db_query("coretek",$dbquery) or die("mysql_query error(message table delete)");
	}else{
		$dbquery="update message set msg='$msg' where type='training' and yyyymmdd='$yyyymmdd'";
//echo "dbquery000=$dbquery ";
		$result = mysql_query($dbquery) or die("mysql_query error(message table update)");
	}
	if($result!="1"){
		errornback("message table�� ó���� �� �����ϴ�.\n$dbquery\n");
		return;
	}
}else if($mode == "training-delete"){ // ���ʿ�:��� �����̸� ������ ���� ����
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

	echo "<p><table border=1><tr><th>�̸�";
	$trainingday = array();
	$trainingcount = array();

    if($mode == "training-input" || $mode == "training-edit"){
	$trainingdays = 1;
	$trainingday[$trainingdays] = $yyyymmdd;
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
	$dbquery="select distinct yyyymmdd from training where yyyymmdd like '$yyyymm%' order by yyyymmdd";
	$dayresult = mysql_query($dbquery) or die("mysql_query error(training select error)");
	for($trainingdays=0; $row=mysql_fetch_array($dayresult); $trainingdays++)
		$trainingday[$trainingdays] = $row[0];
	mysql_free_result($dayresult);

	for($i=0; $i < $trainingdays; $i++){
		echo "<th>".substr($trainingday[$i],5)."</th>";
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
		$dbquery="select yyyymmdd from training where yyyymmdd='$yyyymmdd' and userid='$namerow[0]'";
		$oneresult = mysql_query($dbquery) or die("mysql_query error(training select error)");
		if(mysql_num_rows($oneresult) == 1){
		    echo "<td><input type='radio' name='onoff[$i]' value='$namerow[1]:$namerow[0]:YY' checked>����\n";
		    echo "<input type='radio' name='onoff[$i]' value='$namerow[1]:$namerow[0]:N'>����\n";
		}else{
		    echo "<td><input type='radio' name='onoff[$i]' value='$namerow[1]:$namerow[0]:Y' >����\n";
		    echo "<input type='radio' name='onoff[$i]' value='$namerow[1]:$namerow[0]:NN' checked>����\n";
		}
		mysql_free_result($oneresult);
	    }else{
		$dbquery="select yyyymmdd,userid,onoff from training where yyyymmdd like '$yyyymm%' and name='$namerow[1]' order by yyyymmdd";
		$trainingresult = mysql_query($dbquery) or die("mysql_query error(training select error)");
		for($j=0; $trainingrow=mysql_fetch_array($trainingresult); $j++){
			for( ;$j<$trainingdays && $trainingday[$j]!=$trainingrow[0]; $j++)
				echo "<td>";
			if($j<$trainingdays){
				echo "<td align=center>��";
				$trainingcount[$j]++;
			}
		}
		if($j == 0){ // <td> ����
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
</td></tr></table><table><tr><td><input type=submit value='�Ʒ� �Է� ó��'>
</td></form>\n";
    }else{
	for($i=0; $i < $trainingdays; $i++){
		echo "<td align=center>$trainingcount[$i]��";
	}
    }
	echo "</tr></table>\n";
    if(!($mode == "training-input" || $mode == "training-edit")){
	echo "<table border=1><tr><th>��¥<th>�Ʒ��̸�����</tr>\n";
	$dbquery="select yyyymmdd,msg from message where type='training' and yyyymmdd like '$yyyymm%'";
//echo "dbquery=$dbquery \n";
	$msgresult = mysql_query($dbquery) or die("mysql_query error(message select error)");
	for(; $msgrow=mysql_fetch_array($msgresult); ){
		echo "<tr><td>$msgrow[0]<td>".nl2br($msgrow[1])."\n";
	}
	echo "</table>\n";
    }
	if(privcheck($logid)<2 || $logid!=$trainingmanager || $mode=="training-edit"){
		return;
	}

    if(!($mode == "training-input" || $mode == "training-edit")){
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
mysql_close() or die("mysql_close error");

?>
</center>
</body>
</html>
