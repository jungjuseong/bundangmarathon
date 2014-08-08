<?
if(eregi(basename(__FILE__),$PHP_SELF)) die('정상적인 접근이 아닙니다');

if($HTTP_POST_VARS[upload_number]>99) $HTTP_POST_VARS[upload_number] = 99;

$_CONFIG_MBPIC_STR .= "<?\n";
$_CONFIG_MBPIC_STR .= "\$skin_setup[member_picture_x] = \"$member_picture_x\";\n";
$_CONFIG_MBPIC_STR .= "\$skin_setup[member_picture_y] = \"$member_picture_y\";\n";
$_CONFIG_MBPIC_STR .= "?>\n";

if($copy_file && $cfg_link == 1) {
	$_CONFIG_STR .= "<?\n";
	$_CONFIG_STR .= "\$cfg_linkFile   = \"$copy_file\"; \n";
	$_CONFIG_STR .= "include \$_SKIN_config_dir.\$cfg_linkFile; \n";
	$_CONFIG_STR .= "\$skin_setup[version]   = \"$skin_version\";\n";
	$_CONFIG_STR .= "\$skin_setup[config_id] = \"$id\";\n";
	$_CONFIG_STR .= "?>\n";
} else {
	if($copy_file && $cfg_link==2){
//		$_SKIN_config_file_old = $_SKIN_config_file;
		unset($HTTP_POST_VARS);
		include $_SKIN_config_dir.$copy_file;
		foreach ($skin_setup as $key => $value) {
		   if(!eregi("^config_id|^version",$key)) {
			   if(is_string($value) && strlen($value)>4) $value=addslashes(trim($value));
			   $$key = $value;
			   $HTTP_POST_VARS[$key] = $value;
		   }
		}
//		$_SKIN_config_file = $_SKIN_config_file_old;
	}

	unset($tmp);
	$using_titlebar3 = 1;
	$HTTP_POST_VARS[using_titlebar3] = 1;
	if($using_titlebar1) $tmp = 1;
	if($using_titlebar2) $tmp = 2;
	if($using_titlebar3) $tmp = 3;
	if($using_titlebar4) $tmp = 4;
	if($using_titlebar5) $tmp = 5;
	if($using_titlebar6) $tmp = 6;
	if($using_titlebar7) $tmp = 7;
	if(!$tmp) $using_titlebar = '';
	
	// if($HTTP_POST_VARS['IMGDown_limitEX']) $HTTP_POST_VARS['using_autoResize'] = '';
	$HTTP_POST_VARS['using_usm']		= $HTTP_POST_VARS['using_usm'];
	$HTTP_POST_VARS['using_thumbnail']	= $HTTP_POST_VARS['using_thumbnail'];
	$HTTP_POST_VARS['using_urlImg']		= $HTTP_POST_VARS['using_urlImg'];
	$HTTP_POST_VARS['using_socket']		= $HTTP_POST_VARS['using_socket'];

	ksort($HTTP_POST_VARS);

	$_CONFIG_STR .= "<?\n";
	$_CONFIG_STR .= "\$skin_setup[config_id] = \"$id\";\n";
	$_CONFIG_STR .= "\$skin_setup[version]   = \"$skin_version\";\n";

	$passkey = array('pos','css_sel','lang_sel','copy_file','cfg_link','submit2','save_as','save_file');
	foreach ($HTTP_POST_VARS as $key => $value) {
		if(is_string($value) && strlen($value)>4) $value=addslashes(trim($value));
		if(!in_array($key,$passkey)) {
			$_CONFIG_STR .= "\$skin_setup['$key'] = \"$value\";\n";
		}
	}

	$_CONFIG_STR .= "?>\n";
}
?>