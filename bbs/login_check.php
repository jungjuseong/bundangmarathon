<?
	include "lib.php";

	$connect=dbconn();

	$user_id = trim($user_id);
	$password = trim($password);

	if(!$user_id) Error("���̵� �Է��Ͽ� �ֽʽÿ�");
	if(!$password) Error("��й�ȣ�� �Է��Ͽ� �ֽʽÿ�");

	if($id) {
		$setup=get_table_attrib($id);
		$group=group_info($setup[group_no]);
	}

	if($setup[group_no]) 
		$group_no=$setup[group_no];

	echo("<!--.login_check.php. -->\n");

// ȸ�� �α��� üũ
	$result = mysql_query("select * from $member_table where user_id='$user_id' and password=password('$password')") or error(mysql_error());
	$member_data = mysql_fetch_array($result);

	// ȸ���α����� �����Ͽ��� ��� ������ �����ϰ� �������� �̵���
	if($member_data[no]) {
		if($auto_login) {
			makeZBSessionID($member_data[no]);
		}
		// yhkim �α��� �ð� ����
		$result = mysql_query("update $member_table set login_daytime='".date("Y-m-d H:i:s")."' where user_id='$user_id'") or die("mysql_query error");
		
		// 4.0x �� ���� ó��
		$zb_logged_no = $member_data[no];
		$zb_logged_time = time();
		$zb_logged_ip = $REMOTE_ADDR;
		$zb_last_connect_check = '0';

		// san2run $.SESSION["zzzz" ������� �����ؾ� �ϳ�?

		session_register("zb_logged_no");
		session_register("zb_logged_time");
		session_register("zb_logged_ip");
		session_register("zb_last_connect_check");

		// �α��� �� ������ �̵�
		$s_url=urldecode($s_url);

		if ($member_data[user_id] == 'run4joy'){
			echo "<br>login_check.php<br>";
			echo "<br>userid= $user_id:";
			echo "member_data[no]= $member_data[no]<br>";
			echo ",auto_login= $auto_login<br>";
			echo ",,HTTP_SESSION_VARS[zb_logged_no]=".$HTTP_SESSION_VARS["zb_logged_no"];
			echo ",,HTTP_SESSION_VARS[zb_logged_ip]=".$HTTP_SESSION_VARS["zb_logged_ip"];
			
			echo "<br>url=$s_url";

			echo "<br>decode-url=$s_url";

			echo "<br>HTTP_COOKIE_VARS[ZBSESSIONID]=$HTTP_COOKIE_VARS[ZBSESSIONID]";
			echo "<br>login_check.php end<br>";
			ob_flush();flush();
			phpinfo();
			//exit(0);
		}

		if(!$s_url && $id) 
			$s_url="/bbs/zboard.php?id=$id";

		if($s_url)  {
			movepage($s_url); // go homepage
		}
		elseif ($id) 
			movepage("/bbs/zboard.php?id=$id&page=$page&page_num=$page_num&select_arrange=$select_arrange&desc=$des&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&category=$category&no=$no");
		elseif ($group[join_return_url]) 
			movepage($group[join_return_url]);
		elseif ($referer) 
			movepage($referer);
		else 
			echo"<script>history.go(-2);</script>";
		// ȸ���α����� �����Ͽ��� ��� ���� ǥ��
	} 
	else {
		head();
		Error("�α����� �����Ͽ����ϴ�");
		foot();
	}

	@mysql_close($connect);
?>
