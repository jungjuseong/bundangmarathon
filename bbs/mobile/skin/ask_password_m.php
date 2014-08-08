<script type='text/javascript'> 
//<![CDATA[ 
function onSuccess(data, status){
	var str = data.split("@");
	if(str[0] == "SUCCESS"){ 
		var url = data.replace(/^SUCCESS@/,''); 
		window.location.href =url;
	}else{
		$("#notification").text(data); 
  }
}
$(document).ready(function() {
	$("#delete").validate({    
	<?php if($target != "delete_ok_m.php" && $target != "del_comment_ok_m.php") { ?>
		$.mobile.ajaxFormsEnabled = false;
	<?php } ?>
		submitHandler: function() {
		<?php if($target != "delete_ok_m.php" && $target != "del_comment_ok_m.php") { ?>
			$("#delete").attr("action","<?php echo($target);?>");
			$("#delete").attr("method","post");
		<?php }else{ ?>
			var formData = $("#delete").serialize();
			$.ajax({
				type: "POST",
				url: "<?php echo($target);?>",
				cache: false,
				data: formData,
				success: onSuccess
			});
		<?php } ?>
			return false;
		},
		rules: {
			password: "required"
		},     
		messages: {   
			password : "비밀번호를 입력하세요"
		}
	});  
});
//]]> 
</script> 
<div data-role="page" >
	<div data-role="header" class="backgroundStyle">
		<h1><?= ($setup[title])?$setup[title]:$setup[name]?></h1>
    <a href="/" rel="external" data-icon="refresh" class="ui-btn-left backgroundStyle" >Home</a> 
	</div><!-- /header -->
	<h3 id="notification" ></h3>
	<div data-role="content" data-theme="d" style="margin-top:10px">
		<form id="delete" name="delete">
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
		<input type=hidden name=c_no value=<?=$c_no?>>
		<div data-role="content" data-theme="d">
		<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">
			<li data-role="list-divider" style="text-align:center"><?=$title?></li>
		</ul>
<?
	if(!$member[no]) {
?>
			<div data-role="fieldcontain">
				<label for="password">Password:</label>
				<?=$input_password?> 
			</div>
<?
	}
?>
			<fieldset class="ui-grid-a"> 
<?= $a_cancel;?>
					<div class="ui-block-a"><input type="button" value="Cancel" onclick="javascript:history.back()" /> </div> 
					<div class="ui-block-b"><button type="submit" data-theme="a">Submit</button></div> 
				</fieldset> 
		</form>
	</div>
</div><!-- /page -->
<div data-role="footer" style="background:#668EB6;margin-top:20px;">
	<h4>ⓒ solapun</h4>
</div><!-- /footer -->
