<?
/***************************************************************************
 * ���� ���� include
 **************************************************************************/
	include "_head_m.php";

	$file="skin/config_m.php";
	$configFile = "../mobileConfig.txt";

	/* config ������ �������� ������� ���Ӱ� �����ϸ� �ʱⰪ�� myAllBoard �� �����Ѵ�.*/
	if(!is_file($configFile)) {
		$handle =@fopen($configFile,"w") or error_m("mobileConfig.txt ���� ���� ����! mobile���丮�� �����ϰ� �ִ� ���丮�� �۹̼��� 707�� ������ �ֽʽÿ�");
		@chmod($configFile,0707);
		@fwrite($handle,"myAllBoard\n") or error_m("mobileConfig.txt ���� ���� ����! mobile���丮�� �����ϰ� �ִ� ���丮�� �۹̼��� 707�� ������ �ֽʽÿ�");
		fclose($handle);
	}

	$handle = @fopen($configFile, 'r'); 
	$boardArray = explode("\n", fread($handle, filesize($configFile))); 
	fclose($handle);

	include $file;
	foot();
	@mysql_close($connect);
?>

