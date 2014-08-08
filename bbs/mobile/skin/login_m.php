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
<script type='text/javascript'> 
//<![CDATA[ 
function onSuccess(data, status){
	if(data == "SUCCESS"){ 
	 window.location.href = '/';
	}else{
		$("#notification").text("로그인을 실패하였습니다."); 
	}
}
$(document).ready(function() {
	$("#login").validate({    
		submitHandler: function() {
			var formData = $("#login").serialize();
			$.ajax({
				type: "POST",
				url: "./login_check_m.php",
				cache: false,
				data: formData,
				success: onSuccess
			});
			return false;
		},
		rules: {
			user_id: "required",
			password: "required"
		},     
		messages: {   
			user_id: "아이디를 입력하세요",    
			password: "비밀번호를 입력하세요"   
		}
	});  
});
//]]> 
</script> 
</head> 
<body>
<div data-role="page">
	<div data-role="header" class="backgroundStyle">
		<h1>MEMBER LOGIN</h1>
		<a href="/" rel="external" data-icon="refresh" class="backgroundStyle ui-btn-left" >Home</a> 
	</div><!-- /header -->
	<div data-role="content">
  <form id=login name=login>
    <input type=hidden name=page value=<?=$page?>>
    <input type=hidden name=id value=<?=$id?>>
    <input type=hidden name=no value=<?=$no?>>
    <input type=hidden name=select_arrange value=<?=$select_arrange?>>
    <input type=hidden name=desc value=<?=$desc?>>
    <input type=hidden name=page_num value=<?=$page_num?>>
    <input type=hidden name=keyword value="<?=$keyword?>">
    <input type=hidden name=category value="<?=$category?>">
    <input type=hidden name=sn value="<?=$sn?>">
    <input type=hidden name=ss value="<?=$ss?>">
    <input type=hidden name=sc value="<?=$sc?>">
    <input type=hidden name=mode value="<?=$mode?>">
    <input type=hidden name=s_url value="<?=$s_url?>">
    <input type=hidden name=referer value="<?=$referer?>">
    <fieldset> 
      <label for="user_id">아이디</label><br>
      <input type="text" name="user_id" id="user_id"value="" class="required" /><br>
      <label for="password">비밀번호</label> <br>
      <input type="password" name="password" id="password" value="" class="required" /> <br>
      <button class="btnLogin" id="submit" type="submit" data-inline="true" data-theme="b" >Login</button>
    </fieldset> 
    <h3 id="notification"></h3>
  	</form>
		</div>
	<div data-role="footer" style="background:#668EB6;">
		<h4>ⓒ 분당마라톤클럽</h4>
	</div><!-- /footer -->
</div><!-- /page -->
