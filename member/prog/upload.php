
<?php

require("./auth.php");
require("./config.php");
require("./function.php");

top("");

if($mode == "input"){
	heading("Upload 파일 지정");
	echo "<p>
	<form name=form1 ENCTYPE='multipart/form-data' method=post action='$PHP_SELF'>
	<input type='hidden' name='MAX_FILE_SIZE' value='3000000'>
	<input type=hidden name='mode' value='upload'>
	<input  type='file' name='file1' size='60'><br>
	<input  type='file' name='file2' size='60'><br>
	<input  type='file' name='file3' size='60'><br>
	<input  type='file' name='file4' size='60'><br>
	<input  type='file' name='file5' size='60'>
	<p><input type=submit value='Upload'>
	</form>\n";

}else if($mode == "upload"){
	heading("Upload 처리");

	$files = array ($file1,$file2,$file3,$file4,$file5);
	$files_name = array ($file1_name,$file2_name,$file3_name,$file4_name,$file5_name);

	for($i=0; $i<5; $i++){
	    if($files_name[$i] ) {

		$d=date("Ymd");
//		$f=$d.$files_name[$i];
		$f=$files_name[$i];
		$target="$base_dir/upload/".$f;

		if(file_exists($target)) {
			echo("

<script>
window.alert('동일 파일명($files_name[$i])이 존재합니다. 파일명을 변경하여 올리십시오.')
history.go(-1)
</script> ");

			exit;

		}

		echo $files_name[$i]." : ";
		if(copy($files[$i],"$target")) {
			unlink($files[$i]);
			echo("업로드 성공.<br>");
		}else{
			echo("업로드 실패(*********).<br>");
		}

	    }
	}
}
?>
</center>
</body>
</html>
