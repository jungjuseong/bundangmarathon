<?
/******************************************************************************
 * Zeroboard Moblie �� �߰� library 
 *
 * ������ �������� : 2006. 3. 15
 * �� ���ϳ��� ��� �Լ��� ���Ͻô´�� ����ϼŵ� �˴ϴ�.
 *
 * by zero (zero@nzeo.com)
 *
 * ���� 2011-02-11 by �д縶����Ŭ��
 ******************************************************************************/
  session_start();
	// MySQL ����Ÿ ���̽��� ����
	function dbconn_m() {

		global $connect, $config_dir, $autologin, $HTTP_COOKIE_VARS, $_dbconn_is_included;

		if($_dbconn_is_included) return;
		$_dbconn_is_included = true;

		$f=@file($config_dir."config.php") or error_m("config.php������ �����ϴ�.<br>DB������ ���� �Ͻʽÿ�","install.php");

		for($i=1;$i<=4;$i++) $f[$i]=trim(str_replace("\n","",$f[$i]));

		if(!$connect) $connect = @mysql_connect($f[1],$f[2],$f[3]) or error_m("DB ���ӽ� ������ �߻��߽��ϴ�");

		@mysql_select_db($f[4], $connect) or error_m("DB Select ������ �߻��߽��ϴ�","");
	
		return $connect;
	}

	// ���� �޼��� ���
	function error_m($message, $url="") {
		global $setup, $connect, $config_dir;

			include $config_dir."/mobile/error_m.php";

		if($connect) @mysql_close($connect);

		exit;
	}

	// ���� �����ǿ� �־��� ������ ����Ʈ�� ���Ͽ� ������ �� ��������� �˻�
	function check_blockip_m() {
		global $setup;
		$avoid_ip=explode(",",$setup[avoid_ip]);
		$count = count($avoid_ip);
		for($i=0;$i<$count;$i++) {
			if(!isblank($avoid_ip[$i])&&eregi($avoid_ip[$i],$_SERVER['REMOTE_ADDR'])) error_m("���ܴ��� IP �ּ��Դϴ�.");
		}
	}

	//UTF-8�� EUC-KR(�ѱ� �ڵ�������[949])�� 
function iconv_CP949All($array){   
	foreach($array as $k=>$v) { 
		$arr[$k] = iconv("UTF-8","CP949",$v);  
		}   
	return $arr; 
} 

//UTF-8�� EUC-KR(�ѱ� �ڵ�������[949])�� ��ȯ [�迭] 
function iconv_UTFAll($array){   
	foreach($array as $k=>$v) { 
		$arr[$k] = iconv("CP949","UTF-8",$v);  
	}   
	return $arr; 
} 

//UTF-8�� EUC-KR(�ѱ� �ڵ�������[949])�� ��ȯ [����] 
function iconv_UTF($str){   
	$str = iconv("CP949","UTF-8",$str);  
	return $str; 
} 
?>
