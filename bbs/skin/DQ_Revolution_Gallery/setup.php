<!-- DQ_Revolution/setup.php begin -->
<?
if(eregi(basename(__FILE__),$PHP_SELF)) 
	die('�������� ������ �ƴմϴ�');
if (!extension_loaded("Zend Optimizer")) 
	error("\"�������� �ʴ� ������ ����!!<br>\"DQ�����Ͽ���\"�� �� �������� ������� �ʽ��ϴ�.");

// ��Ų ȯ�漳�� �о��
	include $dir."/get_config.php";
// ���� ��������
	if(!function_exists('make_thumb')) {
		$_inclib_01 = $dir."/include/dq_thumb_engine2.";
		if(file_exists($_inclib_01.'php') && filesize($_inclib_01.'php')) 
			include_once $_inclib_01.'php';
		else 
			include_once $_inclib_01.'zend';
	}
	include_once $dir."/include/member_info.php";
	include_once $dir."/include/dq_lib.php";

// ��Ų ȯ������ �˻�
	if(($is_admin && $skin_setup[version] != $skin_version) || !file_exists($_LIBS_include_dir.'list_all_01.php'))
		include $dir.'/include/lib_copy.php';

// ȯ�漳���� ����ȭ
	if($skin_setup['pic_width'] && $skin_setup['pic_width']<=100) 
		$skin_setup['pic_width'] .= "%";
	elseif(!$skin_setup['pic_width']) 
		$skin_setup['pic_width'] = $width;

	if($skin_setup['memo_width'] && $skin_setup['memo_width']<=100) 
		$skin_setup['memo_width'] .= "%";
	elseif(!$skin_setup['memo_width']) 
		$skin_setup['memo_width'] = "";

// ���� PHP������ ȣȯ���� ���� ó��
	if (substr(phpversion(),0,5) < '4.1.0') {
		global $_SERVER, $_REQUEST;
		$_SERVER  = $HTTP_SERVER_VARS;
		$_REQUEST = $HTTP_GET_VARS;
	}

// �������̰�, ��Ų������ �������� ���� ���¶�� ��Ų ����â�� ����.
	if(($is_admin && $skin_setup[config_id] != $id && !$cfg_linkFile) || ($is_admin && $skin_setup[version] < $skin_version)) 
		echo "<script language='JavaScript'>window.open('$dir/skin_config.php?id=$id&mode=modify','DQStyle','width=770,height=570,toolbars=no,resizable=yes,scrollbars=yes,status=yes,menubar=yes,location=yes,url=yes');</script>\n";

?>

<!-- DQ Revolution Gallery <?=$skin_version?>.<?=get_gdVersion()?>.<?=phpversion()?> -->

<script type="text/JavaScript">
	var id="<?=$id?>", no="<?=$no?>", page="<?=$page?>", select_arrange="<?=$select_arrange?>";
	var desc="<?=$desc?>", page_num="<?=$page_num?>", keyword="<?=$keyword?>", category="<?=$category?>";
	var sn="<?=$sn?>", ss="<?=$ss?>", sc="<?=$sc?>", su="<?=$su?>";
	var url="<?=$REQUEST_URI?>";
	var pic_overLimit1="<?=$skin_setup[pic_overLimit1]?>", pic_overLimit2="<?=$skin_setup[pic_overLimit2]?>", dir="<?=$dir?>";
</script>
<script src="<?=$dir?>/default.js" type="text/JavaScript"></script>

<!-- DQ_Revolution/setup.php end  -->

