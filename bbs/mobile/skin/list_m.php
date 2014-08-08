<?
/***************************************************************************
 * 공통 파일 include
 **************************************************************************/
  include $_zb_path."_head_m.php";  //추가 라이브러리[모바일용]
?>
<html>
<head>
<title>제로보드 모바일</title>
<meta name="description" content="제로보드, 모바일, 분당마라톤클럽">
<meta name="keywords" content="제로보드, 모바일, 분당마라톤클럽">
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">
<link rel="stylesheet" href="./css/jquery.mobile.css" />
<link rel="stylesheet" href="./css/_mobile.css" />
<script src="./js/jquery-1.5.js"></script>
<script src="./js/jquery.mobile.js"></script>
<script src="./js/jquery.validate.js"></script>
</head>
<body>
<div data-role="page">
	<div data-role="header">
		<h1>제로보드 모바일</h1>
<?
if(!$member[no]) {
?>
    <a href="login_m.php" rel="external">로그인</a> 
<? }else{ ?>
    <a href="logout_m.php" rel="external">로그아웃</a> 
<? }?>
	</div><!-- /header -->

	<div data-role="content">
		
		<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">
			<li data-role="list-divider">게시판 목록</li>
<?
  $board = mysql_query("select * from zetyx_admin_table");
  while($row = mysql_fetch_array($board)){
?>
			<li><a href="../zboard.php?id=<?=$row[name]?>" rel="external"><?= ($row[title])?$row[title]:$row[name]?></a></li>
<? } ?>
		</ul>
<!-- /content -->

	<div data-role="footer" style="background:#668EB6;">
		<h4>ⓒ 분당마라톤클럽</h4>
	</div><!-- /footer -->
</div><!-- /page -->
</body>
</html>
