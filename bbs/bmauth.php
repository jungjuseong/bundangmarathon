<?php
	include "_head.php";

	$logid = "$member[user_id]";
	$id="memboard";

	// 로그인한 멤버가 비멤버일때 에러표시
	//echo "logid=$logid, user_id=$user_id, member[user_id]=$member[user_id]";
	//if($logid == "") 
	if($logid == "") {
		Error("<font color=blue size='2'>회원전용이므로<br>로그인하십시요.</font>");
	}

?>
