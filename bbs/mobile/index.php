<?php
/***************************************************************************
 * ���� ���� include
 **************************************************************************/
  include $_zb_path."_head_m.php";  //�߰� ���̺귯��[����Ͽ�]
?>
<html> 
<head>
<title>�д縶����Ŭ��</title>
<meta name="description" content="�д縶����Ŭ��, �����, �д縶����Ŭ��">
<meta name="keywords" content="�д縶����Ŭ��, bundangmarathon, bmc">
<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1"> 
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link rel="stylesheet" href="./css/jquery.mobile.css" />
<link rel="stylesheet" href="./css/_mobile.css" />
<script type="text/javascript" src="./js/jquery-1.5.js"></script>
<script type="text/javascript" src="./js/jquery.mobile.js"></script>
<script type="text/javascript" src="./js/jquery.validate.js"></script>
</head>
<body>
<div data-role="page" class="page_backgroundStyle">
	<div data-role="header" class="backgroundStyle">
		<h1>�д縶����Ŭ�� �����</h1>
		<?php if(!$member[no]) {?>
    <a href="login_m.php" rel="external" class="backgroundStyle">�α���</a> 
		<?php }else{ ?>
    <a href="logout_m.php" rel="external" class="backgroundStyle">�α׾ƿ�</a> 
		<?php } ?>
		<?php if($member[is_admin]==1) {?>
		<a href="config_m.php" rel="external" class="ui-btn-right backgroundStyle" >ȯ�漳��</a> 
		<?php } ?>
	</div><!-- /header -->
	<div data-role="content" data-theme="d">
		<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">
			<li data-role="list-divider" style="text-align:center">�Խ���</li>
			<?php
				/* ���������� ���ų� ��ü���� �Ұ�� ��񿡼� �Խ��� ������ �ҷ��´�. */
				$configFile = "../mobileConfig.txt";
				$handle = @fopen($configFile, 'r'); 
				if($handle){
					$boardArray = explode("\n", fread($handle, filesize($configFile))); 
					fclose($handle);
				}

				if(!is_file($configFile) || $boardArray[0] == "myAllBoard") {
					$whereQuery = "";
				}else{
					$whereQuery = "where";
					while (list($key, $value) = each($boardArray)) { 
						if($boardArray[$key]){ 
							$whereQuery .= ' name="'.$boardArray[$key].'"';
							if(count($boardArray) -2 > $key){$whereQuery .= ' or ';}
						}
					}
				}
				$board = mysql_query("select * from zetyx_admin_table $whereQuery");
				while($row = mysql_fetch_assoc($board)){
			?>
			<li><a href="zboard_m.php?id=<?=$row[name]?>" data-transition='slide' rel="external"><?= ($row[title])?$row[title]:$row[name]?></a></li>
			<?php } ?>
		</ul>
	</div><!-- /content -->
	<div data-role="footer" style="background:#668EB6;">
		<h4>�� 2012 �д縶����Ŭ��</h4>
	</div><!-- /footer -->
</div>
</body>
</html>
