<?php

require("./bmauth.php");
require("./bmconfig.php");
require("./bmfunction.php");

$cashmanagername = "��â��";
$myid = "pheath";
$inputitems = 5;	// �� ȭ���� ������ �Է� �ⳳ�׸� ��
// select yyyymmdd,no,incash,outcash,remains from book order by yyyymmdd,no;
/*
	���� ���� DB table�� �ǵ�ȴٸ� �� �ճ�¥�� �ڷḦ �ְ� ���ָ� �ܾװ���� �ڵ����� ��
*/

top("");
heading("Ŭ�� �����ⳳ��");

if($mode=="book-delete"){
	$yyyy = substr($yyyymmdd,0,4);
	$mm = substr($yyyymmdd,5,2);
}else if(!$yyyy && !$mm){
	$date = getdate();
	$yyyy = $date['year'];
	$mm = $date['mon'];
//echo "year=$yyyy,month=$mm";
}

echo "
<table border=0><tr>
<form action='$PHP_SELF' method=post>\n
<input type=hidden name=mode value='book-list'>
<td><select name='yyyy' size='1' style='background-color: white; color: blue; font:10pt'>\n";
		for($i = $yyyy; $i >= 2004; $i--){
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

$dbquery="select m1.no,m2.userid from zetyx_member_table as m1, member as m2 where m1.name=m2.name and m1.name='$cashmanagername'";
$result = mysql_query($dbquery) or die("mysql_query error(member table select)");
if($row=mysql_fetch_array($result)){
	$cashmanagerno = $row[0];
	$cashmanagerid = $row[1];
}else{
	$cashmanagerno = 0;
	$cashmanagerid = "�̻�";
}

mysql_free_result($result);

echo "</select>��
<td> <input type=submit value='��ȸ'>
<td>(������:$cashmanagername)</td></tr>
</form>
</table>\n";

if($mode == "book-insert"){

	$query_name="";
	$query_value="";

	if(privcheck($logid) < 2 || $logid!=$cashmanagerid && $logid!=$myid){
		errornback("�����ڰ� �ƴմϴ�.");
		return;
	}
    for($i=0; $i < $inputitems && $ayyyymmdd[$i]; $i++){
		$yyyymmdd=$ayyyymmdd[$i];
		$incomment=$aincomment[$i];
		$incash=$aincash[$i];
		if(substr_count($incash, ",") > 0)
			$incash=str_replace(",","",$incash);
		if(strlen($incash)<1) $incash=0;

		$outcomment=$aoutcomment[$i];
		$outcash=$aoutcash[$i];
		if(substr_count($outcash, ",") > 0)
			$outcash=str_replace(",","",$outcash);
		if(strlen($outcash)<1) $outcash=0;
		
		$comment=$acomment[$i];
		if($notify == "1")
			$comment = "�Ű�:".$comment;

		$yyyymmdd = str_replace(";", "/", $yyyymmdd);
		$yyyymmdd = str_replace(":", "/", $yyyymmdd);
		$yyyymmdd = str_replace(".", "/", $yyyymmdd);
		$yyyymmdd = str_replace(" ", "/", $yyyymmdd);
		if(is_numeric($yyyymmdd)){
			if(strlen($yyyymmdd) == 3){
				$yyyymmdd = $yyyy."/0".substr($yyyymmdd,0,1)."/".substr($yyyymmdd,1,2);
			}
			else if(strlen($yyyymmdd) == 4){
				$yyyymmdd = $yyyy."/".substr($yyyymmdd,0,2)."/".substr($yyyymmdd,2,2);
			}
			else if(strlen($yyyymmdd) == 8){
				$yyyymmdd = substr($yyyymmdd,0,4)."/".substr($yyyymmdd,4,2)."/".substr($yyyymmdd,6,2);
			}
		}

		if(!($yyyymmdd=daycheck($yyyymmdd))) return;
		if(strlen($yyyymmdd)<8){
			errornback("��¥�� Ʋ���ϴ�.");
			return;
		}
		if($incash>0 && $outcash>0){
			errornback("���԰� ������ ������ �Է��Ͻʽÿ�.");
			return;
		}
		if($incash<1 && $outcash<1){
			errornback("�ݾ��� �����ϴ�.");
			return;
		}
		if($incash>0 && strlen($incomment)<1){
			errornback("�����׸��� �����ϴ�.");
			return;
		}
		if($outcash>0 && strlen($outcomment)<1){
			errornback("�����׸��� �����ϴ�.");
			return;
		}
		if(strlen($yyyymmdd)<8){
			errornback("��¥�� Ʋ���ϴ�.");
			return;
		}
		$userid = $logid;

		$dbquery="select remains from book where yyyymmdd<='$yyyymmdd' order by yyyymmdd desc,no desc limit 1";
		$result = mysql_query($dbquery) or die("mysql_query error(book table select)");
		if($row=mysql_fetch_array($result))
			$beforeremains=$row[0];
		else
			$beforeremains=0;
		mysql_free_result($result);

		$dbquery="select * from book where yyyymmdd='$yyyymmdd' and incomment='$incomment' and incash=$incash and outcomment='$outcomment' and outcash=$outcash";
		$result = mysql_query($dbquery) or die("mysql_query error(book table select2=$dbquery)");
		if(mysql_num_rows($result) == 1){
			errornback("�ڷᰡ �ߺ��Դϴ�.<br>$yyyymmdd $incomment $incash $outcomment $outcash");
			return;
		}
		mysql_free_result($result);

//echo "dbquery0=$dbquery ";
//echo "beforeremains=$beforeremains incash=$incash outcash=$outcash ";
		$remains = $beforeremains + $incash - $outcash;
//echo "remains=$remains ";
		$dbquery="insert into book
(yyyymmdd,incomment,incash,outcomment,outcash,remains,comment,userid,inputtime)
VALUES
('$yyyymmdd','$incomment',$incash,'$outcomment',$outcash,$remains,'$comment','$userid',now())";

//echo "dbquery00=$dbquery ";
		$result = mysql_query($dbquery);

		if($result!="1"){
			errornback("book table�� �߰��� �� �����ϴ�.");
			return;
		}

		$dbquery = "select yyyymmdd,incash,outcash,remains,no from book where yyyymmdd>'$yyyymmdd' order by yyyymmdd,no";
		$result = mysql_query($dbquery) or die("mysql_query error(book table select3)");
//echo "dbquery3=$dbquery result=$result ";
		while($row=mysql_fetch_array($result)){
			$yyyymmdd=$row[0];
			$remains = $remains + $row[1] - $row[2];
			$no = $row[4];
			$dbquery="update book set ";
			$dbquery.="remains=".$remains;
			$dbquery.=" where yyyymmdd='$yyyymmdd' and no=$no";
//echo "dbquery4=".$dbquery;
			$result2 = mysql_query($dbquery) or die("mysql_query error(book table update)");

			if($result2!="1"){
				errornback("book table�� ������ �� �����ϴ�.");
				return;
			}

		}
		mysql_free_result($result);
    }
}elseif($mode == "book-copyinsert"){

	$query_name="";
	$query_value="";

	if(privcheck($logid) < 2 || $logid!=$cashmanagerid && $logid!=$myid){
		errornback("�����ڰ� �ƴմϴ�.");
		return;
	}
	$trade = explode("\r", $tradetext);
    for($i=0; $i < count($trade); $i++){
		$onetrade = explode("	", $trade[$i]);
//echo "6=$onetrade[6] ";
		for($j=0; $j < count($onetrade); $j++){
			$onetrade[$j] = trim($onetrade[$j]);
		}
		if($onetrade[0]=="")
			continue;
		if(substr($onetrade[6],0,2) == "\\\""){	//	multiple line���� ������� Į��(����ǥ �ȿ� �������)
			$onetrade[6] = substr($onetrade[6],2);
//echo "61=$onetrade[6] ";
//echo "$i=$trade[$i] ";
			for($i++; ($pos = strpos($trade[$i], "\\\"")) === FALSE; $i++){
//echo "$i=$trade[$i] ";
				$onetrade[6] .= $trade[$i];
			}
			$onetrade[6] .= substr($trade[$i], 0, $pos);
//echo "onetrade[6]=$onetrade[6] ";
//echo "$i=$trade[$i] ";
		}
		
		$incash=$onetrade[4];
		if(strlen($incash)<1) $incash=0;
		if(substr_count($incash, ",") > 0)
			$incash=str_replace(",","",$incash);
		if($incash > 0)
			$incomment=$onetrade[2];
		else
			$incomment="";
		
		$outcash=$onetrade[3];
		if(strlen($outcash)<1) $outcash=0;
		if(substr_count($outcash, ",") > 0)
			$outcash=str_replace(",","",$outcash);
		if($outcash > 0)
			$outcomment=$onetrade[2];
		else
			$outcomment="";
			
		$comment=$onetrade[6];

		if(!($yyyymmdd=daycheck($onetrade[0]))) return;
		if(strlen($yyyymmdd)<8){
			errornback("��¥�� Ʋ���ϴ�.");
			return;
		}
		if($incash>0 && $outcash>0){
			errornback("���԰� ������ ������ �Է��Ͻʽÿ�.");
			return;
		}
		if($incash<1 && $outcash<1){
			errornback("�ݾ��� �����ϴ�.");
			return;
		}
		if($incash>0 && strlen($incomment)<1){
			errornback("�����׸��� �����ϴ�.");
			return;
		}
		if($outcash>0 && strlen($outcomment)<1){
			errornback("�����׸��� �����ϴ�.");
			return;
		}
		if(strlen($yyyymmdd)<8){
			errornback("��¥�� Ʋ���ϴ�.");
			return;
		}
		$userid = $logid;

		$dbquery="select remains from book where yyyymmdd<='$yyyymmdd' order by yyyymmdd desc,no desc limit 1";
		$result = mysql_query($dbquery) or die("mysql_query error(book table select4)");
		if($row=mysql_fetch_array($result))
			$beforeremains=$row[0];
		else
			$beforeremains=0;
		mysql_free_result($result);

		$dbquery="select * from book where yyyymmdd='$yyyymmdd' and incomment='$incomment' and incash=$incash and outcomment='$outcomment' and outcash=$outcash";
//echo "dbquery=$dbquery ";
		$result = mysql_query($dbquery) or die("mysql_query error(book table select5)");
		if(mysql_num_rows($result) == 1){
			errornback("�ڷᰡ �ߺ��Դϴ�.<br>$yyyymmdd $incomment $incash $outcomment $outcash");
			return;
		}
		mysql_free_result($result);
//echo "$yyyymmdd,$incomment,$incash,$outcomment,$outcash,$comment<br>";


//echo "dbquery0=$dbquery ";
//echo "beforeremains=$beforeremains incash=$incash outcash=$outcash ";
		$remains = $beforeremains + $incash - $outcash;
//echo "remains=$remains ";
		$dbquery="insert into book
(yyyymmdd,incomment,incash,outcomment,outcash,remains,comment,userid,inputtime)
VALUES
('$yyyymmdd','$incomment',$incash,'$outcomment',$outcash,$remains,'$comment','$userid',now())";

//echo "dbquery00=$dbquery ";
		$result = mysql_query($dbquery);

		if($result!="1"){
			errornback("book table�� �߰��� �� �����ϴ�.");
			return;
		}

		$dbquery = "select yyyymmdd,incash,outcash,remains,no from book where yyyymmdd>'$yyyymmdd' order by yyyymmdd,no";
		$result = mysql_query($dbquery) or die("mysql_query error(book table select6)");
//echo "dbquery3=$dbquery result=$result ";
		while($row=mysql_fetch_array($result)){
			$yyyymmdd=$row[0];
			$remains = $remains + $row[1] - $row[2];
			$no = $row[4];
			$dbquery="update book set ";
			$dbquery.="remains=".$remains;
			$dbquery.=" where yyyymmdd='$yyyymmdd' and no=$no";
//echo "dbquery4=".$dbquery;
			$result2 = mysql_query($dbquery) or die("mysql_query error(book table update)");

			if($result2!="1"){
				errornback("book table�� ������ �� �����ϴ�.");
				return;
			}

		}
		mysql_free_result($result);

    }
}else if($mode == "book-edit"){
 	if(privcheck($logid) < 2 || $logid!=$cashmanagerid && $logid!=$myid){
		errornback("�����ڰ� �ƴմϴ�.");
		return;
	}
}else if($mode == "book-change"){
	$mode = "book-edit";
 	if(privcheck($logid) < 2 || $logid!=$cashmanagerid && $logid!=$myid){
		errornback("�����ڰ� �ƴմϴ�.");
		return;
	}

	$dbquery="update book set comment='$comment' where yyyymmdd='$yyyymmdd' and no=$no";
	$result = mysql_query($dbquery) or die("mysql_query error");

	if($result!="1"){
		echo "<font color=red>�ڷ� ���� ����</font>";
	}
}else if($mode == "book-delete"){
	$mode = "book-edit";
 	if(privcheck($logid) < 2 || $logid!=$cashmanagerid && $logid!=$myid){
		errornback("�����ڰ� �ƴմϴ�.");
		return;
	}

	$dbquery = "select incash,outcash,remains from book where yyyymmdd='$yyyymmdd' and no=$no";
	$result = mysql_query($dbquery) or die("mysql_query error(book table select7)");
//echo "dbquerydel3=$dbquery result=$result ";
	if($row=mysql_fetch_array($result)){
		$remains = $row[2] - $row[0] + $row[1];
	}
	mysql_free_result($result);

	$dbquery="delete from book where yyyymmdd='$yyyymmdd' and no=$no";
	$result = mysql_query($dbquery) or die("mysql_query error");

	if($result!="1"){
		echo "<font color=red>�ڷ� ���� ����</font>";
	}

	$dbquery = "select yyyymmdd,incash,outcash,remains,no from book where yyyymmdd='$yyyymmdd' and no>$no or yyyymmdd>'$yyyymmdd' order by yyyymmdd,no";
	$result = mysql_query($dbquery) or die("mysql_query error(book table select8)");
//echo "dbquerydel3=$dbquery result=$result ";
	while($row=mysql_fetch_array($result)){
		$yyyymmdd=$row[0];
		$remains = $remains + $row[1] - $row[2];
		$no = $row[4];
		$dbquery="update book set ";
		$dbquery.="remains=".$remains;
		$dbquery.=" where yyyymmdd='$yyyymmdd' and no=$no";
//echo "dbquerydel4=".$dbquery;
		$result2 = mysql_query($dbquery) or die("mysql_query error(book table update)");

		if($result2!="1"){
			errornback("book table�� ������ �� �����ϴ�.");
			return;
		}

	}
	mysql_free_result($result);
}


echo "
<p>
<table border=1><tr>
<th>��¥<th>�����׸�<th>���Աݾ�<th>�����׸�<th>����ݾ�<th>&nbsp;&nbsp;&nbsp;&nbsp;�ܡ���&nbsp;&nbsp;&nbsp;&nbsp;<th>���<th>�Է���\n";

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
	$dbquery="select remains from book where yyyymmdd <= '$yyyymm2dd' order by yyyymmdd desc,no desc limit 1";
	$result = mysql_query($dbquery) or die("mysql_query error(book select error`)");
	if($row=mysql_fetch_array($result))
		$beforesum = $row[0];
	else
		$beforesum = 0;
//echo "dbquery1=$dbquery ";
	echo "<tr><td>$yyyymm2<td>�����̿���<td align=right>".number_format($beforesum)."<td><td><td align=right>".number_format($beforesum)."<td>\n";

	$dbquery="select yyyymmdd,incomment,incash,outcomment,outcash,remains,comment,approval,no,date_format(inputtime,'%y/%m/%d') from book where yyyymmdd like '$yyyymm%' order by yyyymmdd,no";
	$result = mysql_query($dbquery) or die("mysql_query error(book select error1)");
//echo "dbquery2=$dbquery ";

	$insum=$beforesum;
	$outsum=0;
	for($no=0; $row=mysql_fetch_array($result); $no++){
		echo "<tr>";
		echo "<td>$row[0]";
		if($mode=="book-edit"){
			echo "<table><form action='$PHP_SELF' method=post>
<input type=hidden name=mode value='book-delete'>
<input type=hidden name=yyyymmdd value='$row[0]'>
<input type=hidden name=no value='$row[8]'>
<tr><td><input type=submit value='����'>
</form></td></tr></table>\n";
		}
		echo "<td>$row[1]<td align=right>".number_format($row[2]);
		echo "<td>$row[3]<td align=right>".number_format($row[4]);
		echo "<td align=right>".number_format($row[5]);
		echo "<td>";
		if($mode=="book-edit"){
			echo "<table><form action='$PHP_SELF' method=post>
<input type=hidden name=mode value='book-change'>
<input type=hidden name=yyyymmdd value='$row[0]'>
<input type=hidden name=no value='$row[8]'>
<tr><td>
<textarea name=comment class=textarea rows=4 cols=30 style=border-color:#d8b3b3>$row[6]</textarea>
<input type=submit value='����'>
</form></td></tr></table>\n";
		}else{
			if(strpos($row[6], "\n"))
				echo "<pre>$row[6]</pre>";
			else
				echo "$row[6]";
				
		}
		echo "<td>$row[9]\n";
		$insum += $row[2];
		$outsum += $row[4];
	}
	if($no==0){
		echo "<tr><td colspan=7 align=center>������ �����ϴ�.</td></tr>";
	}else{
		echo "<tr><td>$yyyymm<td>������<td align=right>".number_format($insum)."<td>������<td align=right>".number_format($outsum)."<td align=right>".number_format($insum-$outsum)."<td>$row[6]\n";
	}
	mysql_free_result($result);


	if(privcheck($logid)<2 || $logid!=$cashmanagerid && $logid!==$myid || $mode=="book-edit"){
		echo "</table>\n";
		return;
	}

	JScheckLength();
	echo "
<form action='$PHP_SELF' method=post>\n
<input type=hidden name=notify value='0'>\n
<input type=hidden name=mode value='book-insert'>\n";

	for($i=0; $i < $inputitems; $i++){
		echo "
<tr>
<td><input type='text' name='ayyyymmdd[]' value='' maxlength=10 size=10>
<td><input type='text' name='aincomment[]' value='' maxlength=20 size=10 onChange='return checkLength(this.value,20)'>
<td><input type='text' name='aincash[]' value='' maxlength=9 size=9>
<td><input type='text' name='aoutcomment[]' value='' maxlength=20 size=10 onChange='return checkLength(this.value,20)'>
<td><input type='text' name='aoutcash[]' value='' maxlength=9 size=9>
<td>
<td><textarea name='acomment[]' class=textarea rows=2 cols=30 style=border-color:#d8b3b3></textarea>";
	}

	echo "
<tr><td colspan=7 align=center>
<input type=submit value='�ű�����'>
</form>\n
<form action='$PHP_SELF' method=post>
<input type=hidden name=mode value='book-edit'>
<input type=hidden name=yyyy value='$yyyy'>
<input type=hidden name=mm value='$mm'>
<input type=submit value='��������'>
</form>
</table>";

$today = date("Y/m/d");
$dbquery="select name from member where userid='$logid'";
$result = mysql_query($dbquery) or die("mysql_query error(member table select2)");
if($row=mysql_fetch_array($result))
	$myname = $row[0];

mysql_close() or die("mysql_close error");

?>

<table border=1>
<form name=select action='<?$PHP_SELF?>' method=POST>
<input type=hidden name=mode value='book-insert'>
<input type=hidden name=notify value='1'>
<tr>
<td rowspan=2 style='bold'><b>�Ա� �Ű�</b></td>
<th>�Ա���<th>�Ա���<th>�Աݾ�<th>�Աݳ���(���)
<tr>
<td><input type='text' name='ayyyymmdd[]' value='<?echo $today?>' maxlength=10 size=10>
<td><input type='text' name='aincomment[]' value='<?echo $myname?>' maxlength=20 size=10 onChange='return checkLength(this.value,20)'>
<td><input type='text' name='aincash[]' value='' maxlength=9 size=9>
<td><textarea name=acomment[] class=textarea rows=2 cols=30 style=border-color:#d8b3b3></textarea>
<td><input type=submit value='�Ű�'></td>
</tr>
</form>
</table><br>
<table border=1>

<form method=post action=/bbs/send_message.php name=write>
<input type=hidden name=id value=>
<input type=hidden name=member_no value="<?=$cashmanagerno?>">
<input type=hidden name=kind value=1>
<input type=hidden name=subject value="�����ⳳ�� �̻� �Ű�-<?=$myname?>">
<input type=hidden name=html value=0>
<tr>
<td style='bold'><b>�����ⳳ��<br>�̻� �Ű�</b></td>
<td><textarea name=memo class=textarea rows=3 cols=60 style=border-color:#d8b3b3>�̻� ������ �Է��� �ֽʽÿ�.
*** �����ڿ��� ������ �����ϴ�. ***
</textarea>
</td>
<td><input type=submit value='������'></td>
</tr>
</form>
</table>
<br><br>

<table border=1>

<form name=select action='<?$PHP_SELF?>' method=POST>
<input type=hidden name=mode value='book-copyinsert'>
<tr>
<td rowspan=2 style='bold'><b>�Է� ���� ó��</b><br><font size='-1'></font></td>
<th>����<th>����<th>���系��<th>ã���ݾ�<th>�ñ�ݾ�<th>�ܾ�<th>���<br><font size='-2' color=red>����ǥ ����</font>
<tr>
<td colspan=7><textarea name=tradetext class=textarea rows=6 cols=80 style=border-color:#d8b3b3>
������� �ŷ������� copy �� ���⿡ paste�Ͽ� ����մϴ�. �ܾ��� �״�� �Էµ��� �ʰ� ���Ǿ� ���ɴϴ�.
Ȥ�� ���� �ŷ����� Į���� �ٷ� �� Į���� ������ ��ġ���� ������(���� �ð� Į��) ������ ���� copy �� �Ŀ� Į���� ���� �� �ٽ� copy �� paste �Ͻñ� �ٶ��ϴ�. 
�� �� �Ǹ� Ȩ����ڿ��� ���� �ٶ��ϴ�.
</textarea>
</td>
<td><input type=submit value='�ڵ��Է�ó��'></td>
</tr>
</form>
</table>

</center>
</body>
</html>
