<?php

require("../auth.php");
require("../config.php");
require("../function.php");

top("");

if($mode == ""){

	heading("성명별 기록 조회");
	$dbquery="select raceid, name, nickname, raceday from race order by raceday desc";
	$result = mysql_query($dbquery) or die("mysql_query error");

	$rows = mysql_num_rows($result); 
	if($rows == 0){
		echo "대회가 없습니다.";
	}else{
		echo "<form name=$PHP_SELF method=post>\n";
		echo "<input type=hidden name=mode value='record-display'>\n";
		echo "<select name='raceid' size='1' style='background-color: white; color: blue; font:10pt'>\n";

		while($row=mysql_fetch_array($result)){
			echo "<option value='$row[0]'>$row[3] : $row[2] : $row[1]</option>\n";
		}
		echo "</select>";
		echo "<p><input type=submit value='대회 지정'>";
		echo "</form>";
	}
	mysql_free_result($result);
	mysql_close() or die("mysql_close error");

}else if($mode == "record-display"){

	heading("기록 목록");

	$dbquery="select raceid, name, nickname, raceday from race where raceid=$raceid";
	$result = mysql_query($dbquery) or die("mysql_query error");
	$row=mysql_fetch_array($result);
	$raceid = $row[0];
	mysql_free_result($result);

	echo "$row[3] : $row[2] : $row[1]<p>\n";
	echo "<table><tr><td>이름 <td>기록";
	$dbquery="select userid, name from member order by name";
	$result = mysql_query($dbquery) or die("mysql_query error");

	while($row=mysql_fetch_array($result)){
		$dbquery2 ="select record from record where raceid=$raceid and userid='$row[0]'";
		$result2 = mysql_query($dbquery2) or die("mysql_query error");
		$rows = mysql_num_rows($result2); 
		if($rows == 0){
			echo "<tr><td>$row[1]<td>null\n";
		}else{
			$row2=mysql_fetch_array($result2);
			echo "<tr><td>$row[1]<td>$row2[0]\n";
		}
		mysql_free_result($result2);
	}
	echo "</table>\n";
	mysql_free_result($result);
}
?>
</center>
</body>
</html>
