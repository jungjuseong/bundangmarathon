<?
/***************************************************************************
 * 공통 파일 include
 **************************************************************************/
  // 라이브러리 함수 파일 인크루드
	include "../lib.php";			//기존 라이브러리
	include "lib_m.php";			//추가 라이브러리[모바일용]

	// 유효성 검사
	if(!eregi($HTTP_HOST,$HTTP_REFERER)){
		echo(iconv_UTF("정상적으로 글을 삭제하여 주시기 바랍니다."));
		exit;
	}

	if(getenv("REQUEST_METHOD") == 'GET' ){
		echo(iconv_UTF("정상적으로 글을 삭제하시기 바랍니다"));
		exit;
	}

	if(!$_POST[borderList]){
		echo(iconv_UTF("출력하실 게시판들을 선택해 주시기 바랍니다."));
		exit;
	}

  //설정파일을 확인하고 정상적일경우 게시판 목록을 등록한다.
	$fp = @fopen("../mobileConfig.txt","w"); 
	if(!$fp){ 
		echo(iconv_UTF("mobileConfig.txt 파일 생성 실패! mobile디렉토리를 포함하고 있는 디렉토리의 퍼미션을 707로 수정해 주십시요"));
		exit;
	}else{
		foreach($_POST[borderList] as $val){
			@fwrite($fp,"$val\n");
		}
	}
	//완료후 정상적으로 끝났다고 정보를 보낸다.
	echo("SUCCESS");
?>
