
<?
	include "lib.php";

	$connect=dbconn();

	$user_id = trim($user_id);
	$password = trim($password);

	if(!$user_id) Error("아이디를 입력하여 주십시요");
	if(!$password) Error("비밀번호를 입력하여 주십시요");

	if($id) {
		$setup=get_table_attrib($id);
		$group=group_info($setup[group_no]);
	}

	if($setup[group_no]) 
		$group_no=$setup[group_no];

	echo("<!--.login_check.php. -->\n");

// 회원 로그인 체크
	$result = mysql_query("select * from $member_table where user_id='$user_id' and password=password('$password')") or error(mysql_error());
	$member = mysql_fetch_array($result);
	$member_data = mysql_fetch_array($result);

	// 회원로그인이 성공하였을 경우 세션을 생성하고 페이지를 이동함
	if($member[no]) {
		if($auto_login) {
			makeZBSessionID($member[no]);
		}
		// yhkim 로그인 시간 저정
		$result = mysql_query("update $member_table set login_daytime='".date("Y-m-d H:i:s")."' where user_id='$user_id'") or die("mysql_query error");
		
		// san2run $.SESSION["zzzz" 방식으로 변경해야 하나?

		@session_start();

		$_SESSION["zb_user_id"] = $user_id; // by jungjuseong
		$_SESSION["zb_logged_no"] = $member[no];
		$_SESSION["zb_logged_time"] = time();
		$_SESSION["zb_logged_ip"] = $REMOTE_ADDR;
		$_SESSION["zb_last_connect_check"] = '0';

		// 로그인 후 페이지 이동
		$s_url=urldecode($s_url);

		if ($member[user_id] == 'jungjuseong'){
			echo "<br>login_check.php<br>";
			echo "<br>userid= $user_id<br/>";
			echo "member[no]= $member[no]<br>";
			echo "auto_login= $auto_login<br>";
			echo "<br/>HTTP_SESSION_VARS[zb_logged_no]=".$HTTP_SESSION_VARS["zb_logged_no"];
			echo "<br/>HTTP_SESSION_VARS[zb_logged_ip]=".$HTTP_SESSION_VARS["zb_logged_ip"];
			echo "<br>url=$s_url";

			echo "<br>decode-url=$s_url";

			echo "<br>HTTP_COOKIE_VARS[ZBSESSIONID]=$HTTP_COOKIE_VARS[ZBSESSIONID]";
			
			//ob_flush();flush();
			phpinfo();

			//@mysql_close($connect);
			//exit(0);
		}

		if(!$s_url && $id) 
			$s_url="/bbs/zboard.php?id=$id";

		if($s_url)  {
			movepage($s_url);
		}
		elseif ($id) 
			movepage("/bbs/zboard.php?id=$id&page=$page&page_num=$page_num&select_arrange=$select_arrange&desc=$des&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&category=$category&no=$no");
		elseif ($group[join_return_url]) 
			movepage($group[join_return_url]);
		elseif ($referer) 
			movepage($referer);
		else 
			echo"<script>history.go(-2);</script>";
		// 회원로그인이 실패하였을 경우 에러 표시
	} 
	else {
		head();
		Error("로그인을 실패하였습니다");
		foot();
	}

	@mysql_close($connect);
?>
