<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title>SWFUpload Demos - Simple Demo</title>
<link href="css/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="swfupload/swfupload.js"></script>
<script type="text/javascript" src="swfupload/swfupload.queue.js"></script>
<script type="text/javascript" src="swfupload/cookie.js"></script>
<script type="text/javascript" src="swfupload/handlers.js"></script>

<script type="text/javascript">
(function (){
    var swfu;
	
	window.onload = function () {
		var settings = {
		    	flash_url : "swfupload/swfupload.swf",
				upload_url: "upload.php", 
				post_params: {"PHPSESSID" : "<?php echo session_id(); ?>"},
				file_size_limit : "4 MB",
				file_types : "*.jpg;*.png",
				file_types_description : "All Files",
				file_upload_limit : 50,
				file_queue_limit : 0,
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel",
					statusTarget: "statusDiv",
					progressContainer: "fsUploadProgress",
                    queuedTotal: "queued_total",
                    loadedTotal: "num_loaded",
                    progressBar: "progressBar"					
				},
				debug: false,

				// Button settings
				button_image_url: "images/TestImageNoText_65x29.png",
				button_width: "105",
				button_height: "30",
				button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
				button_placeholder_id: "spanButtonPlaceHolder",
				button_text: '<span class="theFont">Upload Files</span>',
				button_cursor : SWFUpload.CURSOR.HAND,
				
				// The event handler functions are defined in handlers.js
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				file_queue_error_handler : fileQueueError,								
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : photoUploadSuccess,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : queueComplete	// Queue plugin event
			};
			
		swfu = new SWFUpload(settings);
	};
}());
</script>
</head>
  <body>
    <div id="header">
        <h1 id="logo">></h1>
	    <div id="version"><!-- v2.2.0 --></div>
    </div>
    
    <div id="content">
        <h2>Image Uploader</h2>
	
	    <form id="newpost" name="newpost" action="swfupload.php" method="post" enctype="multipart/form-data">
		
		    <!--  The div that holds the total number of queued file and a counter of uploaded files   -->
			<div id="counterDiv"><span id="num_loaded">0</span> of <span id="queued_total">0</span> Files Uploaded</div>
			
			<!-- The div that holds the total number of queued file and a counter of uploaded files -->
			<div class="flash" id="fsUploadProgress">
			    <a href="#cancelUpload"><img id="cancelUpload" src="images/cancel.png" /></a>
			    <div id="progressBar">
				    &nbsp;
				</div>
			</div>
			
			<div id="statusDiv">
                 &nbsp;
			</div>
			<div>
			    <span id="spanButtonPlaceHolder"></span>
				<input type="button" value="Upload Files" id="undercover" />
				<input id="btnCancel" type="button" value="Cancel All Uploads" onclick="swfu.cancelQueue();" disabled="disabled" />
			</div>
			<textarea name="post_content" id="post_content" rows="10" cols="100" style="width:620px; height:412px; display:none;"></textarea>
		</form>
    </div>

  </body>
</html>
