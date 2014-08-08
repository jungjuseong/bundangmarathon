<?
/******************************************************************************
 * Zeroboard Moblie 용 추가 library 
 *
 * 마지막 수정일자 : 2006. 3. 15
 * 이 파일내의 모든 함수는 원하시는대로 사용하셔도 됩니다.
 *
 * by zero (zero@nzeo.com)
 *
 * 변경 2011-02-11 by 분당마라톤클럽
 ******************************************************************************/
  session_start();
	// MySQL 데이타 베이스에 접근
	function dbconn_m() {

		global $connect, $config_dir, $autologin, $HTTP_COOKIE_VARS, $_dbconn_is_included;

		if($_dbconn_is_included) return;
		$_dbconn_is_included = true;

		$f=@file($config_dir."config.php") or error_m("config.php파일이 없습니다.<br>DB설정을 먼저 하십시요","install.php");

		for($i=1;$i<=4;$i++) $f[$i]=trim(str_replace("\n","",$f[$i]));

		if(!$connect) $connect = @mysql_connect($f[1],$f[2],$f[3]) or error_m("DB 접속시 에러가 발생했습니다");

		@mysql_select_db($f[4], $connect) or error_m("DB Select 에러가 발생했습니다","");
	
		return $connect;
	}

	// 에러 메세지 출력
	function error_m($message, $url="") {
		global $setup, $connect, $config_dir;

			include $config_dir."/mobile/error_m.php";

		if($connect) @mysql_close($connect);

		exit;
	}

	// 현재 아이피와 주어진 아이피 리스트를 비교하여 아이피 블럭 대상자인지 검사
	function check_blockip_m() {
		global $setup;
		$avoid_ip=explode(",",$setup[avoid_ip]);
		$count = count($avoid_ip);
		for($i=0;$i<$count;$i++) {
			if(!isblank($avoid_ip[$i])&&eregi($avoid_ip[$i],$_SERVER['REMOTE_ADDR'])) error_m("차단당한 IP 주소입니다.");
		}
	}

	//UTF-8을 EUC-KR(한글 코드페이지[949])로 
function iconv_CP949All($array){   
	foreach($array as $k=>$v) { 
		$arr[$k] = iconv("UTF-8","CP949",$v);  
		}   
	return $arr; 
} 

//UTF-8을 EUC-KR(한글 코드페이지[949])로 변환 [배열] 
function iconv_UTFAll($array){   
	foreach($array as $k=>$v) { 
		$arr[$k] = iconv("CP949","UTF-8",$v);  
	}   
	return $arr; 
} 

//UTF-8을 EUC-KR(한글 코드페이지[949])로 변환 [변수] 
function iconv_UTF($str){   
	$str = iconv("CP949","UTF-8",$str);  
	return $str; 
} 
?>
