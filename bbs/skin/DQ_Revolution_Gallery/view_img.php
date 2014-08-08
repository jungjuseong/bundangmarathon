<?
//스킨 환경설정 읽어옴
	$_put_css = "1";
	include "get_config.php";

//제로보드 라이브러리 가져옴
	include $_zb_path."lib.php";

//DB 연결정보와 회원정보 가져옴
	$connect = dbConn();
	$member  = member_info();
	$data[ismember] = $mb;

//엔진 가져오기
	include_once "include/dq_thumb_engine2.zend";
	include_once "include/dq_lib.php";

//마우스 오픈쪽버튼 제한기능
	if($skin_setup[mrbt_clickLimit]) include "plug-ins/limit_mrbt.php";

//파일이름에 포함될 &문자를 원래대로 되돌림
	$filename = str_replace("dq_amp_temp","&",$filename);
?>

<html>
<head>
<title>이미지에 클릭후 움직이면 스크롤 됩니다. 이미지에 더블클릭 하면 닫힙니다.</title>
<meta http-equiv=Content-Type content=text/html; charset=EUC-KR>
<META HTTP-EQUIV="imagetoolbar" CONTENT="no">
</head>

<font style="height:0;">
<?if($skin_setup['using_shutter']) mmplay($skin_setup[css_dir]."camera_sound.swf","mmp",1)?>
</font>

<script language="JavaScript" src="default.js" type="text/JavaScript"></script>

<script language="javascript"> 

	var windowX, windowY;
	var bLargeImage = 0;
	var x,y,mx,my;

	function fitWindowSize()
	{
		window.resizeTo(200, 200);
		width = 200 - (document.body.clientWidth -  document.images[0].width);
		height = 200 - (document.body.clientHeight -  document.images[0].height);

		windowX = (window.screen.width-width)/2;
		windowY = (window.screen.height-height)/2;
		if(width>screen.width){
			width = screen.width;
			windowX = 0;
			bLargeImage = 1;
		}
		if(height>screen.height){
			height = screen.height;
			windowY = 0;
			bLargeImage = 1;
		}
		x = width/2;
		y = height/2;
		window.resizeTo(width, height);
		window.moveTo(windowX,windowY);
	}

	var posX = 0;  
	var posY = 0;  
	var posX2 = 0;  
	var posY2 = 0;
	var captureMode = false;  

	function MouseCheck(event,obj) {
	   captureMode = captureMode ? false : true;
	   posX = event.x;
	   posY = event.y;
	   obj.style.cursor = captureMode ? 'move' : 'pointer';
	}  
	function scrollPage(event) {  
		if(!captureMode) return;
		move = 1;
		posX2 = event.clientX;  
		posY2 = event.clientY; 
		pX = posX - posX2; 
		pY = posY - posY2; 
		window.scrollBy(pX,pY); 
		posX = event.clientX;  
		posY = event.clientY;  
	} 

	function move(event){
		if(bLargeImage)	window.scroll(event.clientX - wx,event.clientY -wy);
		return true;
	}
</script>

<body onLoad="fitWindowSize()" style='margin:0'>
<img src="<?=dq_urlencode($filename)?>" <?=$limit_menu?> border="0" onDblClick='window.close()' onmousemove="scrollPage(event)"  onClick="MouseCheck(event,this)" style="cursor:pointer">
</body>
</html>
