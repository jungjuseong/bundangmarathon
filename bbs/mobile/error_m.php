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
<div data-role="page" id="bar"> 
 
	<div data-role="header" class="backgroundStyle"> 
		<h1>Message</h1> 
	</div><!-- /header --> 
 
	<div data-role="content">	
		<h2>[ERROR!]</h2> 
		<p><?=$message?></p>		
		<a href='#' rel="external" class="ui-btn-left" onclick="history.back(); return false">[이전페이지로 이동]</a>
	</div><!-- /content --> 
	
	<div data-role="footer" style="background:#668EB6;"> 
		<h4>ⓒ 분당마라톤클럽</h4> 
	</div><!-- /footer --> 
</div><!-- /page --> 
</body>
</html>
<?php exit;?>
