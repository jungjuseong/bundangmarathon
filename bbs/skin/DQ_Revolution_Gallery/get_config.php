<?
if(eregi(basename(__FILE__),$PHP_SELF)) die('정상적인 접근이 아닙니다');

	global $_MAKING_THUMBNAIL;
	if(!$id) global $id;

//제로보드 경로
	if(!$_zb_path || !@is_file($_zb_path.'zboard.php')) {
		if(@is_file("./zboard.php")) $_zb_path = realpath("./");
		elseif(@is_file("../zboard.php")) $_zb_path = realpath("../");
		elseif(@is_file("../../zboard.php")) $_zb_path = realpath("../../");
		elseif(@is_file("../../../zboard.php")) $_zb_path = realpath("../../../");
		else die("<br><br>제로보드 경로를 찾지못했습니다.<br><br>");

		$_zb_path .= "/";
	}

//경로설정
	$_LIBS_dir         = $_zb_path."DQ_LIBS/";
	$_LIBS_include_dir = $_LIBS_dir."include/";
	$_SKIN_config_dir  = $_LIBS_dir."skin_config/";
	$_SKIN_config_file = $_SKIN_config_dir."cfg_$id.php";

	if(!$id) include $_SKIN_config_dir."cfg_설정초기화.php";
	elseif(file_exists($_SKIN_config_file)) include $_SKIN_config_file;

	if($setup['group_no']) @include $_SKIN_config_dir."member_picture_config_".$setup['group_no'].".php";

	include dirname(__FILE__)."/include/chk_skinconfig.php";
	include dirname(__FILE__)."/skin_version.php";

	$skin_setup['libs_dir'] = $_LIBS_dir;
	if($skin_setup['css_dir']) $_css_dir = $dir."/".$skin_setup['css_dir'];
	$_lang_dir = $dir."/".$skin_setup['language_dir'];

// CSS 환경설정 적용
	if(file_exists($_css_dir."/css_value.php")) include $_css_dir."css_value.php";

	if(!$_put_css) {
		echo "\n<link rel=\"StyleSheet\" HREF=\"".$_css_dir."style.css\" type=\"text/css\" title=\"style\">\n";
		$_put_css = 1;
	}
?>
<HR color=green>
