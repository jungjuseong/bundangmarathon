<script type="text/javascript" src="./se/js/HuskyEZCreator.js" charset="utf-8"></script>

<?php
	if($mode=="reply") $title="��� ����";
	elseif($mode=="modify") $title="�� �����ϱ�";
	else $title="���� �� ����";
?>
<script type='text/javascript'> 
//<![CDATA[ 

function onSuccess(data, status)         {
	var str = data.split("@");
	if(str[0] == "SUCCESS"){ 
		var url = data.replace(/^SUCCESS@/,''); 
		window.location.href =url;
  }else{
		$("#notification").text(data); 
	}
}
$(document).ready(function() {

	submitContents();
	$("#writeFrm").validate({    
		submitHandler: function() {
			var formData = $("#writeFrm").serialize();
			$.ajax({
				type: "POST",
				url: "./write_ok_m.php",
				cache: false,
				data: formData,
				success: onSuccess
			});
			return false;
		},
		rules: {
			password: "required",
			name: "required",
			memo: "required"
		},     
		messages: {   
			category: "��й�ȣ�� �Է��ϼ���",
			password: "��й�ȣ�� �Է��ϼ���",
			name: "�̸��� �Է��ϼ���",	
			memo: "������ �Է��ϼ���",	
		}
	});  
});
//]]> 
</script> 
<div data-role="page" >

	<div data-role="header" class="backgroundStyle">
		<h1><?= ($setup[title])?$setup[title]:$setup[name]?></h1>
    <a href="/" rel="external" data-icon="refresh" class="ui-btn-right backgroundStyle" >Home</a> 
	</div>
		<h3 id="notification" ></h3>
  <div data-role="content" data-theme="d">
    <ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">
			<li data-role="list-divider" style="text-align:center"><?=$title?></li>
    </ul>
  <form id="writeFrm" name="writeFrm">
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
		<input type=hidden name=homepage value="<?=$homepage?>">
		<input type=hidden name=email value="<?=$email?>">
    <fieldset> 
		<?php echo($hide_notice_start);?> 
		<div data-role="fieldcontain">
			<fieldset data-role="controlgroup">
				<legend>������ ����:</legend>
				<input type="checkbox" name="notice"  id="notice" <?php echo($notice);?> value=1 class="custom" />
				<label for="notice">�����۷� �ۼ��ϰڽ��ϴ�.</label>
				</fieldset>
		</div>  
		<?php echo($hide_notice_end);?>
		<?php echo($hide_category_start);?> 
		<div data-role="fieldcontain">
			<fieldset data-role="controlgroup" >
				<legend>ī�װ�:</legend>
				<?=$category_kind?>				
			</fieldset>
		</div>  
		<?php echo($hide_category_end);?>
		<?php echo($hide_secret_start);?> 
		<div data-role="fieldcontain">
			<fieldset data-role="controlgroup" >
				<legend>��б� ����:</legend>
				<input type="checkbox" name="is_secret"  id="is_secret" <?php echo($secret);?> value=1 class="custom" />
				<label for="is_secret">��б۷� �ۼ��ϰڽ��ϴ�.</label>
				</fieldset>
		</div>  
		<?php echo($hide_secret_end);?>
		<?php echo($hide_start);?>
    <div data-role="fieldcontain">
        <label for="password">Password:</label>
        <input type="password" name="password" maxlength=20 id="password" value="" class="required" />
    </div>
    <div data-role="fieldcontain">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?=$name?>" maxlength=20  class="required" />
    </div>	
		<?php echo($hide_end);?>
		<div data-role="fieldcontain">
				<label for="subject">Subject:</label>
				<input type="text" name="subject" id="subject" value="<?=$subject?>" maxlength=200  />
		</div>
		<div data-role="fieldcontain">
			<textarea name="memo" id="memo" rows="10" cols="40"><?=$memo?></textarea>
		</div>
		<div class="ui-body ui-body-b"> 
		<fieldset class="ui-grid-a"> 
				<div class="ui-block-a"><input type="button" value="Cancel" onclick="javascript:history.back()" /> </div> 
				<div class="ui-block-b"><button type="submit" data-theme="a">Submit</button></div> 
	    </fieldset> 
  	</form>
		</div> 
<script type="text/javascript">
var oEditors = [];
nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "memo",
	sSkinURI: "./se/SmartEditor2Skin.html",	
	htParams : {
		bUseToolbar : true,				// .. .. .. (true:../ false:.... ..)
		bUseVerticalResizer : true,		// ... .. ... .. .. (true:../ false:.... ..)
		bUseModeChanger : true,			// .. .(Editor | HTML | TEXT) .. .. (true:../ false:.... ..)
		//aAdditionalFontList : aAdditionalFontSet,		// .. .. ..
		fOnBeforeUnload : function(){
			//alert("ok!");
		}
	}, //boolean
	fOnAppLoad : function(){
		//.. ..
		//oEditors.getById["memo"].exec("PASTE_HTML", ["... ... .. ... .... text...."]);
	},
	fCreator: "createSEditor2"
});

function pasteHTML() {
	var sHTML = "<span style='color:#FF0000;'>.... .. .... ......<\/span>";
	oEditors.getById["memo"].exec("PASTE_HTML", [sHTML]);
}

function showHTML() {
	var sHTML = oEditors.getById["memo"].getIR();
	alert(sHTML);
}
	
function submitContents(elClickedObj) {
	oEditors.getById["memo"].exec("UPDATE_CONTENTS_FIELD", []);	// .... ... textarea. ......
	
	try {
		elClickedObj.form.submit();
	} catch(e) {}
}

function setDefaultFont() {
	var sDefaultFont = '..';
	var nFontSize = 24;
	oEditors.getById["memo"].setDefaultFont(sDefaultFont, nFontSize);
}
</script>
	<div data-role="footer" style="background:#668EB6;">
		<h4>�� �д縶����Ŭ��</h4>
	</div>
</div>
