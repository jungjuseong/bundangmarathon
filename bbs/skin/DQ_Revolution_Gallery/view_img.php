<?
//��Ų ȯ�漳�� �о��
	$_put_css = "1";
	include "get_config.php";

//���κ��� ���̺귯�� ������
	include $_zb_path."lib.php";

//DB ���������� ȸ������ ������
	$connect = dbConn();
	$member  = member_info();
	$data[ismember] = $mb;

//���� ��������
	include_once "include/dq_thumb_engine2.zend";
	include_once "include/dq_lib.php";

//���콺 �����ʹ�ư ���ѱ��
	if($skin_setup[mrbt_clickLimit]) include "plug-ins/limit_mrbt.php";

//�����̸��� ���Ե� &���ڸ� ������� �ǵ���
	$filename = str_replace("dq_amp_temp","&",$filename);
?>

<html>
<head>
<title>�̹����� Ŭ���� �����̸� ��ũ�� �˴ϴ�. �̹����� ����Ŭ�� �ϸ� �����ϴ�.</title>
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
