
<?php

require("./auth.php");
require("./config.php");
require("./function.php");

top("");

if($mode == "input"){
	heading("Upload ���� ����");
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
	heading("Upload ó��");

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
window.alert('���� ���ϸ�($files_name[$i])�� �����մϴ�. ���ϸ��� �����Ͽ� �ø��ʽÿ�.')
history.go(-1)
</script> ");

			exit;

		}

		echo $files_name[$i]." : ";
		if(copy($files[$i],"$target")) {
			unlink($files[$i]);
			echo("���ε� ����.<br>");
		}else{
			echo("���ε� ����(*********).<br>");
		}

	    }
	}
}
?>
</center>
</body>
</html>
