<?php
	include "_head.php";

	$logid = "$member[user_id]";
	$id="memboard";

	// �α����� ����� �����϶� ����ǥ��
	//echo "logid=$logid, user_id=$user_id, member[user_id]=$member[user_id]";
	//if($logid == "") 
	if($logid == "") {
		Error("<font color=blue size='2'>ȸ�������̹Ƿ�<br>�α����Ͻʽÿ�.</font>");
	}

?>
