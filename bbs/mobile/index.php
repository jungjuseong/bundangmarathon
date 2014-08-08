<?php
/***************************************************************************
 * 공통 파일 include
 **************************************************************************/
  include $_zb_path."_head_m.php";  //추가 라이브러리[모바일용]
?>
<html> 
<head>
<title>분당마라톤클럽</title>
<meta name="description" content="분당마라톤클럽, 모바일, 분당마라톤클럽">
<meta name="keywords" content="분당마라톤클럽, bundangmarathon, bmc">
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
		<h1>분당마라톤클럽 모바일</h1>
		<?php if(!$member[no]) {?>
    <a href="login_m.php" rel="external" class="backgroundStyle">로그인</a> 
		<?php }else{ ?>
    <a href="logout_m.php" rel="external" class="backgroundStyle">로그아웃</a> 
		<?php } ?>
		<?php if($member[is_admin]==1) {?>
		<a href="config_m.php" rel="external" class="ui-btn-right backgroundStyle" >환경설정</a> 
		<?php } ?>
	</div><!-- /header -->
	<div data-role="content" data-theme="d">
		<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">
			<li data-role="list-divider" style="text-align:center">게시판</li>
			<?php
				/* 설정파일이 없거나 전체보기 할경우 디비에서 게시판 정보를 불러온다. */
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
		<h4>ⓒ 2012 분당마라톤클럽</h4>
	</div><!-- /footer -->
</div>
</body>
</html>
