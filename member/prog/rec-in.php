
<?php 

require("./auth.php");
require("./config.php");
require("./function.php");

if($logid == ""){
	top("");
	heading("회원 ID 입력");
	echo "<a href='mem.php'>여기서 로그온 하십시오.</a>";
}else{
	top("");
    ////
    if($mode == "" || $mode == "batch-input"){
	heading("기록 Batch 등록(개인별)");

	echo "
	<form action='$PHP_SELF' method=post>\n
	<input type=hidden name=mode value='batch-parse'>\n
	<table><tr><td>
	Name:<td><input type=text name=name value='아무개'><br>\n
	<tr><td>
	Cont:<td><textarea wrap=auto name=cont rows=12 cols=60>종목(풀,하프,10km,5km) 기록 약식대회명
풀 3:01:02 03 동아
하프 1:22:33 03-1 클럽</textarea><br>
	<tr><td colspan=2 align=center>
	<input type=submit value='Batch 처리'>
	</table>
	</form>";
    }else if($mode == "batch-parse"){
	heading("기록 정보 Batch 분류");

//	echo "name=$name<br>cont=$cont<br><br>\n";
	echo "
	<form action='$PHP_SELF' method=post>\n
	<input type=hidden name=mode value='batch-insert'>\n
	Name: $name<input type=hidden name=name value='$name'><br><br>\n";
	for($i=0, $idx=0, $arridx=0; $i< strlen($cont); $i++){
		$chr=substr($cont, $i, 1);
		if($chr == "\n" || $i == (strlen($cont)-1)){
			if($chr == "\n"){
				$partstr=substr($cont, $idx, $i-$idx);
			}else{
				$partstr=substr($cont, $idx, $i-$idx+1);
			}
//			echo "partstr=$partstr ";
//			list($item, $record, $nn1, $nn2, $nn3) = sscanf($partstr,"%s %s (%s %s %s)");
			list($item, $record, $nn1, $nn2, $nn3) = split(' ', $partstr);
			$nickname="$nn1 $nn2 $nn3";
//			$nickname=substr($nickname,0,strlen($nickname)-2);
//		echo "item=$item, rec=$record, nn=$nn1 $nn2 $nn3, nickname=$nickname<br>";
			echo "
			종목:<input type=text name=itemarr[$arridx] value='$item'>\n
			기록:<input type=text name=recordarr[$arridx] value='$record'>\n
			대회:<input type=text name=nicknamearr[$arridx] value='$nickname'><br>\n";
			$idx=$i+1;
			$arridx++;
		}
		if($chr == '\r')
			continue;
	}
	echo "<input type=submit value='Batch 처리'>
	</form>";
	die();
    }else if($mode == "batch-insert"){
	heading("기록 정보 Batch 등록");

	$dbquery="select userid from member where name='$name'";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$rows = mysql_num_rows($result);
	if($rows == 0){
		echo "$name 님은 회원이 아닙니다.";
		  die();
	}
	$row=mysql_fetch_array($result);
	$userid=$row[0];
	mysql_free_result($result);

	$dispyn="Y";
	$rank="";
	$etc="";

	for($i=0, $idx=0; strlen($itemarr[$i])>0; $i++){
		$item=$itemarr[$i];
		$record=$recordarr[$i];
		$nickname=$nicknamearr[$i];
//		echo "item=$item, rec=$record, nickname=$nickname<br>\n";

		$query_name="";
		$query_value="";

		$query_name.="userid";
		$query_value.="'".$userid."'";

		$query_name.=",item";
		$query_value.=",'".$item."'";

		$query_name.=",record";
		$query_value.=",'".$record."'";

		$query_name.=",rank";
		$query_value.=",'".$rank."'";

		$query_name.=",dispyn";
		$query_value.=",'".$dispyn."'";

		$query_name.=",etc";
		$query_value.=",'".$etc."'";

		$query_name.=",nickname";
		$query_value.=",'".$nickname."'";

		$dbquery="select raceid from race where nickname='$nickname'";
		$result = mysql_query($dbquery) or die("mysql_query error");
		$rows = mysql_num_rows($result);
		if($rows == 0){
			echo "'$nickname' 은 저장된 대회의 약칭이 아닙니다.";
			die();
		}
		$row=mysql_fetch_array($result);
		$raceid=$row[0];

		$query_name.=",raceid";
		$query_value.=",".$raceid;

		mysql_free_result($result);
	
//echo "query_name=".$query_name."<br>";
//echo "query_value=".$query_value;
		$dbquery="insert into record ($query_name) values($query_value)";

		$result = mysql_db_query("coretek",$dbquery);

		echo "$item, $record, ($nickname) : ";
		if($result!="1"){
			$dbquery="update record set record='$record',dispyn='$dispyn' where userid='$userid' and raceid=$raceid";
//	echo $dbquery;
			$result = mysql_query($dbquery) or die("mysql_query update error");

			if($result=="1"){
				echo "기록 수정 완료<br>";
			}else{
				echo "<font color=red>기록 등록 오류</font><br>";
			}
		}else{
			echo "등록 처리 완료.<br>";
		}
	}
die();
//	mysql_close($connect);


    }
}

?>
</center>
</body>
</html>
