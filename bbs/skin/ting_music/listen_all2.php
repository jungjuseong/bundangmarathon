<HTML>
<HEAD>
<TITLE>Dasom Player</TITLE>
<META name="Subject" content="I love you warts and all"> 
<META name="Title" content="Dasom Player"> 
<META name="Author" content="���ټ����⢽"> 
<META name="keywords" content="Dasom Player[ ���� ���� ]"> 
<META http-equiv="Content-Type" content="text/html; charset=euc-kr">
<script language="JavaScript">
<!-- JavaScript
/*#################################
�ڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡ�
�ڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡ�
�ڡ��� ������ ���� �������� ������! �� ���Ͽ� ���ؼ��� ��� ������ ���� �ʽ��ϴ�.�ڡ�
�ڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡ�
�ڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡ�
Dasom Player
Copyright (c)2001 by dasomlove.net all right reserved
HomePages : http://www.dasomlove.net/
�� ��ũ��Ʈ�¾Ʒ� Dasom Player ���̼����� �����ϴ�.

���� ���۱� ��úκ��� �Ѽ��ϸ� �ȉϴϴ�.

Dasom Player�� ���� ���̼��� ����Դϴ�.

�Ʒ� ���̼����� �����Ͻô� �и�  Dasom Player�� ����Ҽ� �ֽ��ϴ�.

      ���α׷��� : Dasom Player
      �������� :7.x
      ���α׷� ������ : ���ټ����⢽ (dasomlove75@hotmail.com)
      Homepage : http://www.dasomlove.net/


      1. Dasom Player�� dasomlove.net �� dasomlove.net���� ����� ����Ʈ�� ���Ͽ� �����Ͻ� �� �ֽ��ϴ�.

      2. Dasom Player�� ����Ȩ������ �� �б��� ��ȸ���� �񿵸���ü, ����̳� ��Ÿ ������ü���� ����Ҽ� �ֽ��ϴ�.
         (�ݱ��� ��ü�� �ҹ� ����Ʈ������ ����� �����մϴ�)

      3. Dasom Player ���� ���۱� ��úκ��� �Ѽ��ϸ� �ȉϴϴ�.
         ���� ������ �޽���, html�ҽ����� ���̼��� �� ���� ����Ʈ���� �ϴܿ� �ִ� ī�Ƕ���Ʈ�� ��ũ�� �������� ���ʽÿ�!
         (���۱� ǥ�ô� Dasom Player ������ �ۼ��� ���ĸ��� ����ϸ�, ������ ������ �����մϴ�)


      4. Dasom Player�� ������� ���� ��� ������ ��� ���ؼ� dasomlove.net�� å���� ���� �ʽ��ϴ�.

      5. Dasom Player�� ���� dasomlove.net�� ���� / ������ �ǹ��� �����ϴ�.

      6. Dasom Player �ҽ��� ���������� ���� �����Ͽ� ����Ҽ� ������, ������ ���α׷��� ������� �����մϴ�.
         (���۱� ���� �κ��� ������ �� �����ϴ�.)

      7. Dasom Player �� ���� ��Ų�� ���۱��� ��Ų �����ڿ��� ������, ��Ų���Ͽ� ���Ͽ� �������� �����Ͽ� ���������� �����մϴ�.
         (Dasom Player �� �ҽ������� ���մϴ�.)

      8. ������ ������ Dasom Player 5.x����, 4.x����, 3.x����, 2.x����, 1.x�������� Dasom Player ���̼����� �����ϴ�.

      9. ��Ÿ �ǹ������� dasomlove.net�� �����Խ��ǿ� �����Ͽ� �ֽʽÿ�.

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
var dasomcopyright="<font style=font-size:9pt;>Copyright 2001-2002 </font><a href=http://www.dasomlove.net target=_blink title='������Ȩ������' class='skin'>dasomlove.net</a>";
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
		playerstatus.innerHTML = "������";
			break; 
        case 1:  // Stopped 
		playerstatus.innerHTML = "����";
		document.all.item('trackPosition').style.left = trackbarposition; 
		document.all.item('trackPosition').style.top = trackbartopposition;
			break; 
        case 2:  // Paused  
		playerstatus.innerHTML = "�Ͻ�����";
			break; 
        case 3:  // Playing  
		playerstatus.innerHTML = "�����";
			break; 
        case 4:  // ScanForward
		playerstatus.innerHTML = "�ڷ�";
			break; 
        case 5:  // ScanReverse. 
		playerstatus.innerHTML = "������";
			break; 
        case 6:  // Buffering.
		playerstatus.innerHTML = "���۸�";
			break; 
        case 7:  // Waiting  
		playerstatus.innerHTML = "�����";
			break; 
        case 8:  // MediaEnded.
		playerstatus.innerHTML = "�����";
			break; 
        case 9:  // Transitioning
		playerstatus.innerHTML = "������";
			break; 
        case 10:  // Ready.
		playerstatus.innerHTML = "�غ���";
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