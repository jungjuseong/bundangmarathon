<?
if(eregi(basename(__FILE__),$PHP_SELF)) die('�������� ������ �ƴմϴ�');

//���κ��� ���丮�� ������� �˻�
	if(!file_exists($_LIBS_dir) && !is_writable($_zb_path)) 
		error("���κ��� ���丮�� ���� ������ �����ϴ�<br>�� ��Ų�� ����ϱ� ���ؼ��� ���κ��� ���丮�� ���� ������ �־�� �մϴ�");

	if(!is_dir("data/$id")) {
		mkdir("data/$id",0777);
		chmod("data/$id",0707);
	}

	if(!is_writable("data/$id")) error("\"���κ���/data\" ���丮�� ���� ������ �����ϴ�.");

// ���߾��ε带 ���� DB�ʵ� ����
	$dq_revolution_table_schema ="
		CREATE TABLE dq_revolution (
		no INT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
		zb_id VARCHAR(40) NOT NULL ,
		zb_no INT(20) NOT NULL ,
		file_names TEXT NULL ,
		s_file_names TEXT NULL ,
		file_descript TEXT NULL ,
		vote_users TEXT NULL ,
		is_slide INT(1) NOT NULL DEFAULT '0',
		is_hidden INT(1) NOT NULL DEFAULT '0',
		is_vdel INT(1) NOT NULL DEFAULT '0',

	    KEY zb_id (zb_id),
		KEY zb_no (zb_no)
		)
	";

	if(!@mysql_field_name(mysql_query("SELECT no from dq_revolution"),0)) {
		mysql_query($dq_revolution_table_schema,$connect) or error(mysql_error(),"");
	}
	@mysql_field_name(mysql_query("SELECT is_vdel from dq_revolution"),0) or mysql_query("ALTER TABLE `dq_revolution` ADD `is_vdel` INT(1) NOT NULL DEFAULT '0'");
	@mysql_field_name(mysql_query("SELECT is_hidden from dq_revolution"),0) or mysql_query("ALTER TABLE `dq_revolution` ADD `is_hidden` INT(1) NOT NULL DEFAULT '0'");

//ȯ�漳�� ������ ��ġ�� ���丮 ����
	dq_mkdir($_LIBS_dir);
	dq_mkdir($_LIBS_dir."icon");
	dq_mkdir($_LIBS_include_dir);
	dq_mkdir($_SKIN_config_dir);

	if(!is_writable($_SKIN_config_dir)) ;

//�⺻ ȯ�漳������ ����
	copy("$dir/skinconfig_default.php",$_SKIN_config_dir."cfg_�����ʱ�ȭ.php");
	if(!file_exists($_SKIN_config_dir."member_picture_config_".$setup[group_no].".php"))
		copy("$dir/skinconfig_mbpic_default.php",$_SKIN_config_dir."member_picture_config_".$setup[group_no].".php");
	chmod($_SKIN_config_dir."cfg_�����ʱ�ȭ.php",0707);
	chmod($_SKIN_config_dir."member_picture_config_".$setup[group_no].".php",0707);

	if(!is_file($_SKIN_config_file))
		copy($_SKIN_config_dir."cfg_�����ʱ�ȭ.php",$_SKIN_config_file);
		chmod($_SKIN_config_file,0707);

//��Ų���� �о����
	include $_SKIN_config_file;
	include $_SKIN_config_dir."member_picture_config_".$setup[group_no].".php";
	$_css_dir = $dir."/".$skin_setup[css_dir];

//��Ÿ�Ͻ�Ʈ ���
	echo "<link rel=\"StyleSheet\" HREF=\"".$_css_dir."style.css\" type=\"text/css\" title=\"style\">\n";
	$_put_css = 1;

//���̺귯���� �����ϴ��� �˻� & ����
	dq_copy("revolg_delete_ok.php",$dir."/include/",$_zb_path);
//	dq_copy("dq_thumb_engine2.zend",$dir."/include/",$_LIBS_include_dir);
//	dq_copy("phpthumb.gif.php",$dir."/include/",$_LIBS_include_dir);
//	dq_copy("member_info.php",$dir."/include/",$_LIBS_include_dir);
//	dq_copy("write_limit.php",$dir."/include/",$_LIBS_include_dir);
//	dq_copy("unlimit_write2.zend",$dir."/include/",$_LIBS_include_dir);
	dq_copy("unlimit_write_ok.php",$dir."/include/",$_zb_path);
	dq_copy("revolg_delete.php",$dir."/include/",$_zb_path);
	dq_copy("revolg_delete_ok.php",$dir."/include/",$_zb_path);
	dq_copy("list_all_01.php",$dir."/include/",$_LIBS_include_dir);
	dq_copy("list_all_02.php",$dir."/include/",$_LIBS_include_dir);
//	dq_copy("vote_ex_run.php",$dir."/include/",$_LIBS_include_dir);
	dq_copy("vote_ex.php",$dir."/include/",$_zb_path);

/*
	$os = get_serveros();
	if(eregi("windows",$os))	 $exec = "exiflist_win.exe";
	elseif(eregi("linux",$os))	 $exec = "exiflist_linux.bin";
	elseif(eregi("macos x",$os)) $exec = "exiflist_osx.bin";
	elseif(eregi("solaris",$os)) $exec = "exiflist_sunos.bin";
	dq_copy($exec,$dir."/plug-ins/",$_LIBS_include_dir);
	chmod($_LIBS_include_dir.$exec, 0707);
*/

// ----------------------------------------------------------------------------------------------------------
//  ���Ϻ��縦 ���� �Լ�����
// ----------------------------------------------------------------------------------------------------------
	function dq_mkdir($dir) {
		if(is_dir($dir)) return;
		else @mkdir($dir, 0777);

		$mk = @chmod($dir, 0707);
		if($mk) return "1";
	}

	function dq_copy($file,$sd, $td) {
		if(is_file($td.$file)) @unlink($td.$file);
		if(!is_file($sd.$file)) return;

		$cp = copy($sd.$file, $td.$file);
		if(!cp) return;
		$cp = chmod($td.$file, 0707);
		if(!cp) return;
	}
?>