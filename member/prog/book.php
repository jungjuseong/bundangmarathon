<?php

require("./auth.php");
require("./config.php");
require("./function.php");

$cashmanager = "hm6818";
$inputitems = 5;	// 한 화면의 관리자 입력 출납항목 수
// select yyyymmdd,no,incash,outcash,remains from book order by yyyymmdd,no;
/*
	만약 직접 DB table을 건드린다면 맨 앞날짜에 자료를 넣고 빼주면 잔액계산이 자동으로 됨
*/

top("");
heading("클럽 현금출납부");

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
		for($i = 2004; $i <= 2006; $i++){
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

$dbquery="select name from member where userid='$cashmanager'";
$result = mysql_query($dbquery) or die("mysql_query error(member table select)");
if($row=mysql_fetch_array($result))
	$cashmanagername = $row[0];
else
	$cashmanagername = "미상";
mysql_free_result($result);

echo "</select>월
<td> <input type=submit value='조회'>
<td>(관리자:$cashmanagername)</td></tr>
</form>
</table>\n";

if($mode == "book-insert"){

	$query_name="";
	$query_value="";

	if(privcheck($logid) < 2 || $logid!=$cashmanager){
		errornback("관리자가 아닙니다.");
		return;
	}
    for($i=0; $i < $inputitems && $ayyyymmdd[$i]; $i++){
	$yyyymmdd=$ayyyymmdd[$i];
	$incomment=$aincomment[$i];
	$incash=$aincash[$i];
	if(strlen($incash)<1) $incash=0;
	$outcomment=$aoutcomment[$i];
	$outcash=$aoutcash[$i];
	if(strlen($outcash)<1) $outcash=0;
	$comment=$acomment[$i];

	$yyyymmdd = str_replace(";", "/", $yyyymmdd);
	$yyyymmdd = str_replace(":", "/", $yyyymmdd);
	$yyyymmdd = str_replace(".", "/", $yyyymmdd);
	$yyyymmdd = str_replace(" ", "/", $yyyymmdd);
	if(!($yyyymmdd=daycheck($yyyymmdd))) return;
	if(strlen($yyyymmdd)<8){
		errornback("날짜가 틀립니다.");
		return;
	}
	if($incash>0 && $outcash>0){
		errornback("수입과 지출을 별도로 입력하십시오.");
		return;
	}
	if($incash<1 && $outcash<1){
		errornback("금액이 없습니다.");
		return;
	}
	if($incash>0 && strlen($incomment)<1){
		errornback("수입항목이 없습니다.");
		return;
	}
	if($outcash>0 && strlen($outcomment)<1){
		errornback("지출항목이 없습니다.");
		return;
	}
	if(strlen($yyyymmdd)<8){
		errornback("날짜가 틀립니다.");
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

//echo "dbquery0=$dbquery ";
//echo "beforeremains=$beforeremains incash=$incash outcash=$outcash ";
	$remains = $beforeremains + $incash - $outcash;
//echo "remains=$remains ";
	$dbquery="insert into book
(yyyymmdd,incomment,incash,outcomment,outcash,remains,comment,userid,inputtime)
VALUES
('$yyyymmdd','$incomment',$incash,'$outcomment',$outcash,$remains,'$comment','$userid',now())";

//echo "dbquery00=$dbquery ";
	$result = mysql_db_query("coretek",$dbquery);

	if($result!="1"){
		errornback("book table에 추가할 수 없습니다.");
		return;
	}

	$dbquery = "select yyyymmdd,incash,outcash,remains,no from book where yyyymmdd>'$yyyymmdd' order by yyyymmdd,no";
	$result = mysql_query($dbquery) or die("mysql_query error(book table select2)");
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
			errornback("book table을 수정할 수 없습니다.");
			return;
		}

	}
	mysql_free_result($result);
    }
}else if($mode == "book-edit"){
 	if(privcheck($logid) < 2 || $logid!=$cashmanager){
		errornback("관리자가 아닙니다.");
		return;
	}
}else if($mode == "book-delete"){
 	if(privcheck($logid) < 2 || $logid!=$cashmanager){
		errornback("관리자가 아닙니다.");
		return;
	}

	$dbquery = "select incash,outcash,remains from book where yyyymmdd='$yyyymmdd' and no=$no";
	$result = mysql_query($dbquery) or die("mysql_query error(book table select3)");
//echo "dbquerydel3=$dbquery result=$result ";
	if($row=mysql_fetch_array($result)){
		$remains = $row[2] - $row[0] + $row[1];
	}
	mysql_free_result($result);

	$dbquery="delete from book where yyyymmdd='$yyyymmdd' and no=$no";
	$result = mysql_query($dbquery) or die("mysql_query error");

	if($result!="1"){
		echo "<font color=red>기록 삭제 오류</font>";
	}

	$dbquery = "select yyyymmdd,incash,outcash,remains,no from book where yyyymmdd='$yyyymmdd' and no>$no or yyyymmdd>'$yyyymmdd' order by yyyymmdd,no";
	$result = mysql_query($dbquery) or die("mysql_query error(book table select2)");
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
			errornback("book table을 수정할 수 없습니다.");
			return;
		}

	}
	mysql_free_result($result);
}


echo "
<p>
<table border=1><tr>
<th>날짜<th>수입항목<th>수입금액<th>지출항목<th>지출금액<th>&nbsp;&nbsp;&nbsp;&nbsp;잔　액&nbsp;&nbsp;&nbsp;&nbsp;<th>비고<th>입력일\n";

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
	$result = mysql_query($dbquery) or die("mysql_query error(book select error)");
	if($row=mysql_fetch_array($result))
		$beforesum = $row[0];
	else
		$beforesum = 0;
//echo "dbquery1=$dbquery ";
	echo "<tr><td>$yyyymm2<td>전기이월금<td align=right>".number_format($beforesum)."<td><td><td align=right>".number_format($beforesum)."<td>\n";

	$dbquery="select yyyymmdd,incomment,incash,outcomment,outcash,remains,comment,approval,no,date_format(inputtime,'%y/%m/%d') from book where yyyymmdd like '$yyyymm%' order by yyyymmdd,no";
	$result = mysql_query($dbquery) or die("mysql_query error(book select error)");
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
<tr><td><input type=submit value='삭제'>
</form></td></tr></table>\n";
		}
		echo "<td>$row[1]<td align=right>".number_format($row[2]);
		echo "<td>$row[3]<td align=right>".number_format($row[4]);
		echo "<td align=right>".number_format($row[5]);
		echo "<td>$row[6]<td>$row[9]\n";
		$insum += $row[2];
		$outsum += $row[4];
	}
	if($no==0){
		echo "<tr><td colspan=7 align=center>내용이 없습니다.</td></tr>";
	}else{
		echo "<tr><td>$yyyymm<td>수입합<td align=right>".number_format($insum)."<td>지출합<td align=right>".number_format($outsum)."<td align=right>".number_format($insum-$outsum)."<td>$row[6]\n";
	}
	mysql_free_result($result);


if(privcheck($logid)<2 || $logid!=$cashmanager || $mode=="book-edit"){
		echo "</table>\n";
		return;
	}

	JScheckLength();
	echo "
<form action='$PHP_SELF' method=post>\n
<input type=hidden name=mode value='book-insert'>\n";

	for($i=0; $i < $inputitems; $i++){
		echo "
<tr>
<td><input type='text' name='ayyyymmdd[]' value='' maxlength=10 size=10>
<td><input type='text' name='aincomment[]' value='' maxlength=20 size=10>
<td><input type='text' name='aincash[]' value='' maxlength=8 size=8>
<td><input type='text' name='aoutcomment[]' value='' maxlength=20 size=10>
<td><input type='text' name='aoutcash[]' value='' maxlength=8 size=8>
<td>
<td><input type='text' name='acomment[]' value='' maxlength=40 size=30>\n";
	}

	echo "
<tr><td colspan=7 align=center>
<input type=submit value='신규저장'>
</form>\n
<form action='$PHP_SELF' method=post>
<input type=hidden name=mode value='book-edit'>
<input type=hidden name=yyyy value='$yyyy'>
<input type=hidden name=mm value='$mm'>
<input type=submit value='수정삭제'>
</form>
</table>";

mysql_close() or die("mysql_close error");

?>
</center>
</body>
</html>
