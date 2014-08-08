<HTML>
<HEAD>
<TITLE>Dasom Player</TITLE>
<META name="Subject" content="I love you warts and all"> 
<META name="Title" content="Dasom Player"> 
<META name="Author" content="♡다솜지기♡"> 
<META name="keywords" content="Dasom Player[ 정식 버전 ]"> 
<META http-equiv="Content-Type" content="text/html; charset=euc-kr">
<script language="JavaScript">
<!-- JavaScript
/*#################################
★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
★★이 파일은 절대 수정하지 마세요! 이 파일에 대해서는 어떤한 질문도 받지 않습니다.★★
★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
Dasom Player
Copyright (c)2001 by dasomlove.net all right reserved
HomePages : http://www.dasomlove.net/
이 스크립트는아래 Dasom Player 라이센스에 따릅니다.

사용시 저작권 명시부분을 훼손하면 안됍니다.

Dasom Player에 대한 라이센스 명시입니다.

아래 라이센스에 동의하시는 분만  Dasom Player를 사용할수 있습니다.

      프로그램명 : Dasom Player
      배포버젼 :7.x
      프로그램 저작자 : ♡다솜지기♡ (dasomlove75@hotmail.com)
      Homepage : http://www.dasomlove.net/


      1. Dasom Player는 dasomlove.net 및 dasomlove.net에서 허락된 사이트에 한하여 배포하실 수 있습니다.

      2. Dasom Player는 개인홈페이지 및 학교나 교회등의 비영리단체, 기업이나 기타 영리단체에서 사용할수 있습니다.
         (반국가 단체나 불법 싸이트에서의 사용은 금지합니다)

      3. Dasom Player 사용시 저작권 명시부분을 훼손하면 안됍니다.
         음악 정지시 메시지, html소스상의 라이센스 및 웹상 리스트보기 하단에 있는 카피라이트와 링크를 수정하지 마십시요!
         (저작권 표시는 Dasom Player 배포시 작성된 형식만을 허용하며, 임의의 수정은 금지합니다)


      4. Dasom Player의 사용으로 인한 어떠한 문제나 사고에 대해서 dasomlove.net은 책임을 지지 않습니다.

      5. Dasom Player에 대해 dasomlove.net은 유지 / 보수의 의무가 없습니다.

      6. Dasom Player 소스는 개인적으로 사용시 수정하여 사용할수 있지만, 수정된 프로그램의 재배포는 금지합니다.
         (저작권 관련 부분은 수정할 수 없습니다.)

      7. Dasom Player 에 쓰인 스킨의 저작권은 스킨 제작자에게 있으며, 스킨파일에 한하여 제작자의 동의하에 수정배포가 가능합니다.
         (Dasom Player 전 소스배포는 금합니다.)

      8. 이전에 배포됀 Dasom Player 5.x버전, 4.x버전, 3.x버전, 2.x버전, 1.x버전역시 Dasom Player 라이센스에 따릅니다.

      9. 기타 의문사항은 dasomlove.net의 질문게시판에 문의하여 주십시요.

#################################*/
// - JavaScript - -->
</script>
<SCRIPT language=Javascript src="./java/dasommvsetting.js"></SCRIPT>
<script language="JavaScript">
<!-- JavaScript
var randomskinnumber=Math.floor((randomskin.length)*Math.random());
var skin = randomskin[randomskinnumber]; 
var dasomskin = "skin/"+skin;
document.write("<SCR"+"IPT language=Javas"+"cript src='" +dasomskin+"/Playersetting.js'></SCR"+"IPT>");
var dasomcopyright="<font style=font-size:9pt;>Copyright 2001-2002 </font><a href=http://www.dasomlove.net target=_blink title='제작자홈페이지' class='skin'>dasomlove.net</a>";
// - JavaScript - -->
</script>
<SCRIPT language=Javascript src="./java/dasomsystem.js"></SCRIPT>
<script language="JavaScript">
<!-- JavaScript
document.write("<SCR"+"IPT language=Javas"+"cript src='" +dasomskin+"/update.js'></SCR"+"IPT>");
// - JavaScript - -->
</SCRIPT>
<SCRIPT FOR="dasomlove" EVENT="playStateChange(lOldState, lNewState)" LANGUAGE="JavaScript">
switch(document.dasomlove.playState) { 
        case 0:  // Undefined 
		playerstatus.innerHTML = "연결중";
			break; 
        case 1:  // Stopped 
		playerstatus.innerHTML = "중지";
		document.all.item('trackPosition').style.left = trackbarposition; 
		document.all.item('trackPosition').style.top = trackbartopposition;
			break; 
        case 2:  // Paused  
		playerstatus.innerHTML = "일시정지";
			break; 
        case 3:  // Playing  
		playerstatus.innerHTML = "재생중";
			break; 
        case 4:  // ScanForward
		playerstatus.innerHTML = "뒤로";
			break; 
        case 5:  // ScanReverse. 
		playerstatus.innerHTML = "앞으로";
			break; 
        case 6:  // Buffering.
		playerstatus.innerHTML = "버퍼링";
			break; 
        case 7:  // Waiting  
		playerstatus.innerHTML = "대기중";
			break; 
        case 8:  // MediaEnded.
		playerstatus.innerHTML = "종료됨";
			break; 
        case 9:  // Transitioning
		playerstatus.innerHTML = "연결중";
			break; 
        case 10:  // Ready.
		playerstatus.innerHTML = "준비중";
		document.all.item('trackPosition').style.left = trackbarposition; 
		document.all.item('trackPosition').style.top = trackbartopposition;
			break; 
}
</SCRIPT>
<script language="JavaScript">
<?
require "./dbconn.php";
$connect=mysql_connect($host_name,$user_name,$db_password);
mysql_select_db($db_name, $connect);
$checked_song=explode(",",$selected);
$array_cnt=count($checked_song);
for($i=0;$i<$array_cnt-1;$i++)
{
$temp=mysql_fetch_array(mysql_query("select subject, name, sitelink1, sitelink2, file_name1, file_name2, memo from zetyx_board_$id where no='$checked_song[$i]'", $connect));
$subject[$i]=stripslashes($temp[subject]);
$singer[$i]=stripslashes($temp[name]);
$memo[$i]=nl2br(stripslashes($temp[memo]));
$temp[sitelink2]=stripslashes($temp[sitelink2]);
$temp[file_name2]=stripslashes($temp[file_name2]);
if($temp[file_name2]==true){ $arr = array($zero_path,$temp[file_name2]);}
else{
$arr = array($temp[file_name2]);
}

$dasom_path = implode("",$arr);
$dasom_1="";
if(!eregi("\.smi",$temp[sitelink2])) $dasom_1="$temp[sitelink2]";
$dasom_3="";
if(!eregi("\.smi",$dasom_path)) $dasom_3="$dasom_path";
if ($dasom_1==""){
	$song_path1[$i]=$dasom_3;
}else{
	$song_path1[$i]=$temp[sitelink2];
}
$song_path3[$i]=$dasom_path;
$song_smi[$i]="";
if(eregi("\.smi",$temp[file_name1])) $song_smi[$i]="$zero_path$temp[file_name1]";
else if(eregi("\.smi",$temp[sitelink1])) $song_smi[$i]="$temp[sitelink1]";
else if(eregi("\.smi",$temp[file_name2])) $song_smi[$i]="$zero_path$temp[file_name2]";
else if(eregi("\.smi",$temp[sitelink2])) $song_smi[$i]="$temp[sitelink2]";
if ($song_path1[$i]==true)
	{
?> 
DasomBGM_List("<?=$song_path1[$i]?>","<?=$subject[$i]?>","<?=$song_smi[$i]?>","<?=$checked_song[$i]?>"); 
<? 
}
//Hit Up
mysql_query("update zetyx_board"."_$id set hit=hit+1 where no='$checked_song[$i]'");
}
mysql_close($connect); 
?> 
var dasom_Id="<?=$zero_id?>";
</SCRIPT>
<SCRIPT language=javascript for=dasomlove Event=EndOfStream(lResult)>
	checkloop();
</SCRIPT>
<SCRIPT language=javascript for=dasomlove Event=Error> 
        ErrorTitle();
        DasomBGM_Timeout(); 
</SCRIPT> 
<script language="JavaScript">
<!-- JavaScript
var dasom_Id="<?=$zero_id?>";
document.write("<SCR"+"IPT language=Javas"+"cript src='" +dasomskin+"/Player.js'></SCR"+"IPT>");
document.write("<LINK REL=stylesheet TYPE=text/css HREF=" +dasomskin+"/Player.css>");
// - JavaScript - -->
</SCRIPT>
</HEAD>
<BODY OnLoad="setting();" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" oncontextmenu="return false" onselectstart="return false" ondragstart="return false" onkeydown="return false">
<form name="DasomBGM">
<script language="JavaScript">
<!-- JavaScript
Player();
// - JavaScript - -->
</script>
<object classid='clsid:6BF52A52-394A-11d3-B153-00C04F79FAA6' id=dasomlove name=dasomlove type='application/x-oleobject' standby='Dasom Windows Media Player...' width=100% height=100%>
	<PARAM NAME=AnimationAtStart VALUE=false>
	<PARAM NAME=AutoStart value=false>
	<PARAM NAME=AutoSize value=false>
	<PARAM NAME=backgroundColor VALUE=2566468>
	<PARAM NAME=balance value=0>
	<PARAM NAME=baseURL value=false>
	<PARAM NAME=captioningID value=false>
	<PARAM NAME=currentPosition value=0>
	<PARAM NAME=currrentMarker value=false>
	<PARAM NAME=DisplayForeColor value="15264680">
	<PARAM NAME=defaultFrame value=false>
	<PARAM NAME=enableContextMenu value=false>
	<PARAM NAME=enableErrorDialogs value=false>
	<PARAM NAME=enabled value=false>
	<PARAM NAME=fullScreen value=false>
	<PARAM NAME=invokeURLs value=false>
	<PARAM NAME=mute value=false>
	<PARAM NAME=playCount value=false>
	<PARAM NAME=rate value=false>
	<PARAM NAME=ShowStatusBar VALUE=false>
	<PARAM NAME=ShowDisplay value=false>
	<PARAM NAME=uiMode value=none>
	<PARAM NAME=volume value=100>
	<Param Name = "WMFSDKNeeded" Value = "0.0.0.0000" />
	<Param Name = "WMFSDKVersion" Value = "7.01.00.3055" />
</object>
<script language="JavaScript">
<!-- JavaScript
Player2();
// - JavaScript - -->
 </script>
</FORM>
</BODY>
</HTML>