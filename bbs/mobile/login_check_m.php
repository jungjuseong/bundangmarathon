<?
	include "../lib.php";
	include $_zb_path."lib_m.php";  //�߰� ���̺귯��[����Ͽ�]
	$connect=dbconn_m();

	$user_id = trim($_POST[user_id]);
	$password = trim($_POST[password]);

  if(!get_magic_quotes_gpc()) {
    $user_id = addslashes($user_id);
    $password = addslashes($password);
  }

	if(!$user_id) error_m("���̵� �Է��Ͽ� �ֽʽÿ�");
	if(!$password) error_m("��й�ȣ�� �Է��Ͽ� �ֽʽÿ�");

// ȸ�� �α��� üũ
	$result = mysql_query("select * from $member_table where user_id='$user_id' and password=password('$password')") or error_m(mysql_error());
	$member_data = mysql_fetch_array($result);

// ȸ���α����� �����Ͽ��� ��� ������ �����ϰ� �������� �̵���
	if($member_data[no]) {

		// 4.0x �� ���� ó��
		$zb_logged_no = $member_data[no];
		$zb_logged_time = time();
		$zb_logged_ip = $_SERVER[REMOTE_ADDR];
		$zb_last_connect_check = '0';

		session_register("zb_logged_no");
		session_register("zb_logged_time");
		session_register("zb_logged_ip");
		session_register("zb_last_connect_check");


		// �α��� �� ������ �̵�
		echo("SUCCESS");
// ȸ���α����� �����Ͽ��� ��� ���� ǥ��
	} else {
		echo("FOBIDDEN");
	}

	@mysql_close($connect);
?>
