<?
/***************************************************************************
 * ���� ���� include
 **************************************************************************/
  // ���̺귯�� �Լ� ���� ��ũ���
	include "../lib.php";			//���� ���̺귯��
	include "lib_m.php";			//�߰� ���̺귯��[����Ͽ�]

	// ��ȿ�� �˻�
	if(!eregi($HTTP_HOST,$HTTP_REFERER)){
		echo(iconv_UTF("���������� ���� �����Ͽ� �ֽñ� �ٶ��ϴ�."));
		exit;
	}

	if(getenv("REQUEST_METHOD") == 'GET' ){
		echo(iconv_UTF("���������� ���� �����Ͻñ� �ٶ��ϴ�"));
		exit;
	}

	if(!$_POST[borderList]){
		echo(iconv_UTF("����Ͻ� �Խ��ǵ��� ������ �ֽñ� �ٶ��ϴ�."));
		exit;
	}

  //���������� Ȯ���ϰ� �������ϰ�� �Խ��� ����� ����Ѵ�.
	$fp = @fopen("../mobileConfig.txt","w"); 
	if(!$fp){ 
		echo(iconv_UTF("mobileConfig.txt ���� ���� ����! mobile���丮�� �����ϰ� �ִ� ���丮�� �۹̼��� 707�� ������ �ֽʽÿ�"));
		exit;
	}else{
		foreach($_POST[borderList] as $val){
			@fwrite($fp,"$val\n");
		}
	}
	//�Ϸ��� ���������� �����ٰ� ������ ������.
	echo("SUCCESS");
?>
