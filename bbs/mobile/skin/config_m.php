<html>
<head>
<title>환경설정</title>
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
		alert("환경설정이 완료되었습니다.");
	 window.location.href = '/';
	}else{
		$("#notification").text(data); 
	}
}

$(document).ready(function() {
	$("#boardChk").validate({    
		submitHandler: function() {
			var formData = $("#boardChk").serialize();
			$.ajax({
				type: "POST",
				url: "./config_check_m.php",
				cache: false,
				data: formData,
				success: onSuccess
			});
			return false;
		},
		rules: {
			borderList: "required"
		},     
		messages: {   
			borderList: "최소한 한개 이상은 선택해주시기 바랍니다."
		}
	});  

});
$(document).ready(function() 
{ 
	<?php
		if($boardArray[0] == 'myAllBoard'){
	?>
			$(".checkone").attr("disabled", true).checkboxradio( "refresh" );
	<?php
		}
	?>

	$('.checkall').tap(function(event) {
		if ($("#boardAll").is(":checked")){  
			$(".checkone").each(function() 
			{ 
				$(this).attr('checked', false).checkboxradio( "refresh" );
				$(this).attr("disabled", true).checkboxradio( "refresh" );
			}); 
		}else{
			$(".checkone").each(function() 
			{ 
				$(this).attr("disabled", false).checkboxradio( "refresh" );
			}); 
		}   
	});
}); 

//]]> 
</script> 
</head> 
<body>
<div data-role="page">
	<div data-role="header" class="backgroundStyle">
		<h1>환경설정</h1>
		<a href="/" rel="external" data-icon="refresh" class="backgroundStyle ui-btn-left" >Home</a> 
	</div><!-- /header -->
	<div data-role="content">
  <form id=boardChk name=boardChk>
		<div  data-role="fieldcontain"> 
			<fieldset data-role="controlgroup"> 
				<legend>게시판 출력여부</legend> 
				<input type="checkbox" name="borderList[]" id="boardAll" value="myAllBoard" <?= ($boardArray[0] == "myAllBoard")?"checked=TRUE":""?> /> 
				<label for="boardAll" class="checkall">전체 출력</label>
				<?php
					$board = mysql_query("select * from zetyx_admin_table");
					while($row = mysql_fetch_assoc($board)){
				?>
				<input type="checkbox" name="borderList[]" id="<?=$row[name]?>" class="checkone" value="<?=$row[name]?>" <?= (in_array($row[name],$boardArray))?"checked=TRUE":""?> /> 
				<label for="<?=$row[name]?>"><?= ($row[title])?$row[title]:$row[name]?></label> 
				<?php } ?>
			</fieldset> 
			<button class="btnConfig" id="submit" type="submit" data-inline="true" data-theme="b" >설정확인</button>
		</div> 
		<h3 id="notification"></h3>
	</form>
	</div>
	<div data-role="footer" style="background:#668EB6;">
		<h4>ⓒ 분당마라톤클럽</h4>
	</div><!-- /footer -->
</div><!-- /page -->
