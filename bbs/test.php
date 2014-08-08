<?php 
require("bmauth.php");
require("bmconfig.php");
require("bmfunction.php");

	top("");
	heading("Test");

	if($logid == ""){
		die("로그인하지 않았습니다.");
	}
if($logid == "run4joy"){
	echo "HTTP_USER_AGENT=".$_SERVER['HTTP_USER_AGENT'];

	$query_name="userid,access_time,user_agent";
	$query_value="'".$logid."',now(),'".$_SERVER['HTTP_USER_AGENT']."'";
	$dbquery="insert into user_agent ($query_name) values($query_value)";
	$result = mysql_query($dbquery);

	if($result!="1"){
		echo "<font color=red>이미 저장되었습니다.</font><br>";
	} else{
		echo "<p>저장되었습니다.<br>";
	}
	if(is_mobile_user())
		echo "Mobile User";
	else
		echo "NonMobile User";

}

function is_mobile_user()
{
	
	if(strpos($_SERVER['HTTP_USER_AGENT'], "iPhone") !== false)
		return true;
	elseif(strpos($_SERVER['HTTP_USER_AGENT'], "Mobile") !== false)
		return true;
	else
		return false;
}
?>
</center>
</body>
</html>
