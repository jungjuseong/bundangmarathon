<html>
<head>
<title>���κ��� �����</title>
<meta name="description" content="���κ���, �����, �д縶����Ŭ��">
<meta name="keywords" content="���κ���, �����, �д縶����Ŭ��">
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
		<a href='#' rel="external" class="ui-btn-left" onclick="history.back(); return false">[������������ �̵�]</a>
	</div><!-- /content --> 
	
	<div data-role="footer" style="background:#668EB6;"> 
		<h4>�� �д縶����Ŭ��</h4> 
	</div><!-- /footer --> 
</div><!-- /page --> 
</body>
</html>
<?php exit;?>
