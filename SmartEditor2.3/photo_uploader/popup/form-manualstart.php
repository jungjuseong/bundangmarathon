<?php require_once "phpuploader/include_phpuploader.php" ?>
<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta http-equiv="Content-Style-Type" content="text/css">
<title> Upload images </title>
<script type="text/javascript">
function doStart()
{
	var uploadobj = document.getElementById('myuploader');
	if (uploadobj.getqueuecount() > 0) {
		uploadobj.startupload();
	}
	else {
		alert("Please browse files for upload");
	}
}
</script>
<style type="text/css">
/* NHN Web Standard 1Team JJS 120106 */ 
/* Common */
body,p,h1,h2,h3,h4,h5,h6,ul,ol,li,dl,dt,dd,table,th,td,form,fieldset,legend,input,textarea,button,select{margin:0;padding:0}
body,input,textarea,select,button,table{font-family:'..',Dotum,Helvetica,sans-serif;font-size:12px}
img,fieldset{border:0}
ul,ol{list-style:none}
em,address{font-style:normal}
a{text-decoration:none}
a:hover,a:active,a:focus{text-decoration:underline}

/* Contents */
.blind{visibility:hidden;position:absolute;line-height:0}
#pop_wrap{width:383px}
#pop_header{height:26px;padding:14px 0 0 20px;border-bottom:1px solid #ededeb;background:#f4f4f3}
.pop_container{padding:11px 20px 0}
#pop_footer{margin:21px 20px 0;padding:10px 0 16px;border-top:1px solid #e5e5e5;text-align:center}
h1{color:#333;font-size:14px;letter-spacing:-1px}
.btn_area{word-spacing:2px}
.pop_container .drag_area{overflow:hidden;overflow-y:auto;position:relative;width:341px;height:129px;margin-top:4px;border:1px solid #eceff2}
.pop_container .drag_area .bg{display:block;position:absolute;top:0;left:0;width:341px;height:129px;background:#fdfdfd url(../../img/photoQuickPopup/bg_drag_image.png) 0 0 no-repeat}
.pop_container .nobg{background:none}
.pop_container .bar{color:#e0e0e0}
.pop_container .lst_type li{overflow:hidden;position:relative;padding:7px 0 6px 8px;border-bottom:1px solid #f4f4f4;vertical-align:top}
.pop_container :root .lst_type li{padding:6px 0 5px 8px}
.pop_container .lst_type li span{float:left;color:#222}
.pop_container .lst_type li em{float:right;margin-top:1px;padding-right:22px;color:#a1a1a1;font-size:11px}
.pop_container .lst_type li a{position:absolute;top:6px;right:5px}
.pop_container .dsc{margin-top:6px;color:#666;line-height:18px}
.pop_container .dsc_v1{margin-top:12px}
.pop_container .dsc em{color:#13b72a}
.pop_container2{padding:46px 60px 20px}
.pop_container2 .dsc{margin-top:6px;color:#666;line-height:18px}
.pop_container2 .dsc strong{color:#13b72a}
.upload{margin:0 4px 0 0;_margin:0;padding:6px 0 4px 6px;border:solid 1px #d5d5d5;color:#a1a1a1;font-size:12px;border-right-color:#efefef;border-bottom-color:#efefef;length:300px;}
:root  .upload{padding:6px 0 2px 6px;}
</style>	

	<script type='text/javascript'>
	function CuteWebUI_AjaxUploader_OnTaskComplete(task)
	{
		//var div=document.createElement("DIV");
		//div.innerHTML=task.FileName + " is uploaded!";
		//document.body.appendChild(div);
		goStartMode();
	}
	</script>
</head>
<body>
<div id="pop_wrap">
	<!-- header -->
    <div id="pop_header">
        <h1>Image Upload</h1>
    </div>
	<P>Allowed image types: <span style="color:red">jpg, gif, png</span></p>
			<!-- do not need enctype="multipart/form-data" -->
			<?php				
				$uploader=new PhpUploader();
				$uploader->MaxSizeKB=10240;
				$uploader->Name="myuploader";
				$uploader->InsertText="Upload multiple images (Max 10M)";
				
				$uploader->SaveDirectory="./photo_dir";
				$uploader->AllowedFileExtensions="*.jpg,*.png,*.gif";	
				$uploader->MultipleFilesUpload=true;
				$uploader->Render();
			?>
			
<?php
$fileguidlist=@$_POST["myuploader"];
if($fileguidlist)
{
	$guidlist=explode("/",$fileguidlist);
	
	echo("<div style='font-family:Fixedsys;'>");
	echo("Uploaded ");
	echo(count($guidlist));
	echo(" files:");
	echo("</div>");
	echo("<hr/>");
	
	foreach($guidlist as $fileguid)
	{
		$mvcfile=$uploader->GetUploadedFile($fileguid);
		if($mvcfile)
		{
			echo("<div style='font-family:Fixedsys;border-bottom:dashed 1px gray;padding:6px;'>");
			echo("FileName: ");
			echo($mvcfile->FileName);
			echo("<br/>FileSize: ");
			echo($mvcfile->FileSize." b");
	//		echo("<br/>FilePath: ");
	//		echo($mvcfile->FilePath);
			echo("</div>");
			
			//Moves the uploaded file to a new location.
			//$mvcfile->MoveTo("/uploads");
			//Copys the uploaded file to a new location.
			//$mvcfile->CopyTo("/uploads");
			//Deletes this instance.
			//$mvcfile->Delete();
		}
	}
}
?>
				
	</div>
    <!-- footer -->
    <div id="pop_footer">
	    <div class="btn_area">
            <a href="#"><img src="../../img/photoQuickPopup/btn_confirm.png" width="49" height="28" alt="confirm" id="btn_confirm"></a>
            <a href="#"><img src="../../img/photoQuickPopup/btn_cancel.png" width="48" height="28" alt="cancel" id="btn_cancel"></a>
        </div>
    </div>
    <!-- //footer -->
</div>
<script type="text/javascript" src="jindo.min.js" charset="utf-8"></script>
<script type="text/javascript" src="jindo.fileuploader.js" charset="utf-8"></script>
<script type="text/javascript" src="attach_photo.js" charset="utf-8"></script>

</body>
</html>
