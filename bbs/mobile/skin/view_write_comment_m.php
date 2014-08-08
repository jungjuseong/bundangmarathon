<script type='text/javascript'> 
//<![CDATA[ 
function onSuccess(data, status)         {
	var str = data.split("@");
  if(str[0] == "SUCCESS")             { 
		var url = data.replace(/^SUCCESS@/,''); 
		window.location.href =url;
	}else{
		$("#notification").text(data); 
  }
}
$(document).ready(function() {
	$("#writeFrm").validate({    
		submitHandler: function() {
			var formData = $("#writeFrm").serialize();

			$.ajax({
				type: "POST",
				url: "./comment_ok_m.php",//여기다시  경로설정을 어떻게 해야할까
				cache: false,
				data: formData,
				success: onSuccess
			});
			return false;
		},
		rules: {
			password: "required",
			name: "required",
			memo: {
				required: true,
				minlength: 10
			}
		},     
		messages: {   
			password : "비밀번호를 입력하세요",
			name : "이름을 입력하세요",	
      memo : {
				required:		"내용을 입력하세요" ,
				minlength: "코멘트는 10자 이상 적어주세요"
			}
		}
	});  
});

//]]> 
</script> 
<h3 id="notification" ></h3>
<div data-role="content" data-theme="d" style="margin-top:10px">
	<form id=writeFrm name=writeFrm>
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
		<?php if(!$member['no']){?>
		<div data-role="fieldcontain" style="padding:5px">
			<fieldset data-role="controlgroup">
				<label for="name">Name:</label>
				<?=$c_name?>
				</fieldset>
		</div>
		<?}?>
		<?=$hide_c_password_start?>
		<div data-role="fieldcontain" style="padding:5px">
				<label for="password">Password:</label>
				<input type="password" name="password" maxlength=20 id="password" value="" class="required" />
		</div>
		<?=$hide_c_password_end?>
		<div data-role="fieldcontain" style="padding:5px;margin-bottom:20px">
			<label for="memo">Comment:</label>
			<textarea name=memo id="memo" cols="40" rows="8" id="memo" class="required"></textarea>
		</div>
			<button type="submit" data-theme="c" name="submit" value="submit-value">글쓰기</button> 
	</form>
</div> 
<div data-role="footer" style="background:#668EB6;margin-top:20px;">
	<h4>ⓒ 분당마라톤클럽</h4>
</div><!-- /footer -->
