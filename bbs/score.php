<?php
require("./bmauth.php");
require("./bmconfig.php");

		echo "<p align=center>���� �̵��� ������ ������ ���� ���ھ� ���<br><br>\n";
		$dbquery="UPDATE scoresum SET scoresum = 0";
		$result2 = mysql_query($dbquery);

		$dbquery="select no, name, boardtype, score from score order by no, name";
		$result = mysql_query($dbquery) or die("mysql_query error");

		while($row=mysql_fetch_array($result)){
			echo "name=$row[name], no=$row[no], type=$row[boardtype], score=$row[score]\n";
			if($row[boardtype] == "memboard" || $row[boardtype] == "pubboard" || $row[boardtype] == "photo")
				$addscore = $row[score] * 10;
			else
				$addscore = $row[score];
			$dbquery="UPDATE scoresum SET scoresum = scoresum + $addscore WHERE no=$row[no] and name='$row[name]' ";
			$result2 = mysql_query($dbquery);
			if($result2!="1"){
				error("scoresum table�� ó���� �� �����ϴ�.\n$dbquery\n");
				bye("");
			}
//			mysql_free_result($result2);
			$dbquery="select scoresum from scoresum WHERE no=$row[no] and name='$row[name]'";
			$result2 = mysql_query($dbquery) or die("mysql_query error");
			$row=mysql_fetch_array($result2);
			echo " ������ : $row[scoresum]<br>\n";
			mysql_free_result($result2);
		}
		mysql_free_result($result);
		
		$dbquery="select no, name, scoresum from scoresum order by scoresum desc limit 20";
		$result = mysql_query($dbquery) or die("mysql_query error");

		echo "<table border=1><tr><th>�̸�<th>ȸ����ȣ<th>����\n";
		while($row=mysql_fetch_array($result)){
			echo "<tr><td>$row[name]<td>$row[no]<td>$row[scoresum]\n";
		}
		echo "</table>\n";

		$dbquery="select name, sum(scoresum) sss from scoresum group by name order by sss desc limit 20";
		$result = mysql_query($dbquery) or die("mysql_query error");

		echo "<table border=1><tr><th>�̸�<th>����\n";
		while($row=mysql_fetch_array($result)){
			echo "<tr><td>$row[name]<td>$row[1]\n";
		}
		echo "</table>\n";

		mysql_close() or die("mysql_close error");
?>
