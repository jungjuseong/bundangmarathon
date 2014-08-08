<?
/***************************************************************************
 * 공통 파일 include
 **************************************************************************/
	include "_head_m.php";

	$file="skin/config_m.php";
	$configFile = "../mobileConfig.txt";

	/* config 파일이 존재하지 않을경우 새롭게 생성하며 초기값은 myAllBoard 로 지정한다.*/
	if(!is_file($configFile)) {
		$handle =@fopen($configFile,"w") or error_m("mobileConfig.txt 파일 생성 실패! mobile디렉토리를 포함하고 있는 디렉토리의 퍼미션을 707로 수정해 주십시요");
		@chmod($configFile,0707);
		@fwrite($handle,"myAllBoard\n") or error_m("mobileConfig.txt 파일 생성 실패! mobile디렉토리를 포함하고 있는 디렉토리의 퍼미션을 707로 수정해 주십시요");
		fclose($handle);
	}

	$handle = @fopen($configFile, 'r'); 
	$boardArray = explode("\n", fread($handle, filesize($configFile))); 
	fclose($handle);

	include $file;
	foot();
	@mysql_close($connect);
?>

