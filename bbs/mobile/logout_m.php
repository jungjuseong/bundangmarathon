<?
  include $_zb_path."_head_m.php";  //�߰� ���̺귯��[����Ͽ�]

// DB ����
	if(!$connect) $connect=dbconn_m();

// ��� ���� ���ؿ���
	$member=member_info();

	if(!$member[no]) error_m("�α��� ���°� �ƴմϴ�");

	if(!$group_no) $group_no=$member[group_no];

	if($id) $setup=get_table_attrib($id);
  
	if($setup[group_no]&&!$group_no) $group_no=$setup[group_no];
  
	mysql_close($connect);

	destroyZBSessionID($member[no]);
	
	// 4.0x �� ���� ó��
	$zb_logged_no='';
	$zb_logged_time='';
	$zb_logged_ip='';
	$zb_secret='';
	$zb_last_connect_check = '0';
	session_register("zb_logged_no");
	session_register("zb_logged_time");
	session_register("zb_logged_ip");
	session_register("zb_secret");
	session_register("zb_last_connect_check");
	session_destroy(); 
?>
<html>
<head>
<title>�д縶����Ŭ�� �����</title>
<meta name="description" content="���κ���, �����, �д縶����Ŭ��">
<meta name="keywords" content="���κ���, �����, �д縶����Ŭ��">
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<script type="text/javascript">
alert("�α׾ƿ� �ϼ̽��ϴ�.");
window.location.href = '/bbs/mobile/';
</script>
</head>
