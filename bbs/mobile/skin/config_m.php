<html>
<head>
<title>ȯ�漳��</title>
<meta name="description" content="���κ���, �����, �д縶����Ŭ��">
<meta name="keywords" content="���κ���, �����, �д縶����Ŭ��">
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
		alert("ȯ�漳���� �Ϸ�Ǿ����ϴ�.");
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
			borderList: "�ּ��� �Ѱ� �̻��� �������ֽñ� �ٶ��ϴ�."
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
		<h1>ȯ�漳��</h1>
		<a href="/" rel="external" data-icon="refresh" class="backgroundStyle ui-btn-left" >Home</a> 
	</div><!-- /header -->
	<div data-role="content">
  <form id=boardChk name=boardChk>
		<div  data-role="fieldcontain"> 
			<fieldset data-role="controlgroup"> 
				<legend>�Խ��� ��¿���</legend> 
				<input type="checkbox" name="borderList[]" id="boardAll" value="myAllBoard" <?= ($boardArray[0] == "myAllBoard")?"checked=TRUE":""?> /> 
				<label for="boardAll" class="checkall">��ü ���</label>
				<?php
					$board = mysql_query("select * from zetyx_admin_table");
					while($row = mysql_fetch_assoc($board)){
				?>
				<input type="checkbox" name="borderList[]" id="<?=$row[name]?>" class="checkone" value="<?=$row[name]?>" <?= (in_array($row[name],$boardArray))?"checked=TRUE":""?> /> 
				<label for="<?=$row[name]?>"><?= ($row[title])?$row[title]:$row[name]?></label> 
				<?php } ?>
			</fieldset> 
			<button class="btnConfig" id="submit" type="submit" data-inline="true" data-theme="b" >����Ȯ��</button>
		</div> 
		<h3 id="notification"></h3>
	</form>
	</div>
	<div data-role="footer" style="background:#668EB6;">
		<h4>�� �д縶����Ŭ��</h4>
	</div><!-- /footer -->
</div><!-- /page -->
