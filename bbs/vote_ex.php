<?
if(!file_exists(getcwd().'/zboard.php')) die('�������� ������ �ƴմϴ�.');

// �������� include
	include "lib.php";
	if(!eregi($HTTP_HOST,$HTTP_REFERER)) Error("���������� ���� �ۼ��Ͽ� �ֽñ� �ٶ��ϴ�.");

// DB ����
	if(!$connect) $connect=dbConn();  

//�Խ��� ���� �о����
	$setup = get_table_attrib($id); 

//��Ų ȯ�漳�� �о����
	include "skin/$setup[skinname]/get_config.php";
	$dir = "skin/$setup[skinname]";

// ���� ��������
	$_inclib_01 = $dir."/include/dq_thumb_engine2.";
	if(file_exists($_inclib_01.'php') && filesize($_inclib_01.'php')) include_once $_inclib_01.'php';
	else include_once $_inclib_01.'zend';

//ȸ������ �о����
	$member = member_info();

// �ش���� �ִ� ���� �˻�
	$check = mysql_fetch_array(mysql_query("select count(*) from $t_board"."_$id where no = '$no'", $connect));
	if(!$check[0]) Error("���� ���� �������� �ʽ��ϴ�.");

/* spam ��� ���� yhkim/san2run */
if($id=="photo" && ($no==18 || $no==18)){
	Error("��۴ޱ� �����Դϴ�.");
	exit;
}
	include $dir.'/include/vote_ex_run.php';
?>
