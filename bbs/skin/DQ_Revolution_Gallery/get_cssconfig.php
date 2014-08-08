<html>
<head>
<title>DQ'Style Skin Configuration</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
</head> 
<body>
<?
@extract($HTTP_GET_VARS); 

if($mode="css") {
	if(!file_exists($id.'css_info.php')) {
		echo "정상적인 접근이 아닙니다.";
		die();
	}
	include $id."css_info.php";
	$css = $match_bgColor;

	//echo "<SCRIPT LANGUAGE=\"JavaScript\">parent.match_css.innerHTML=\"".$css."\";</SCRIPT>\n";
}

?>
<SCRIPT LANGUAGE="JavaScript">
<!--
if(parent.document.getElementById('match_css')) {
	parent.match_css.innerHTML="<?=$css?>";
}
//-->
</SCRIPT>
</body>
</html>

