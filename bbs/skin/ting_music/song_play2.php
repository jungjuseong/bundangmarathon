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

<SCRIPT language=Javascript>
<?
require "./dbconn.php";
$connect=mysql_connect($host_name,$user_name,$db_password);
mysql_select_db($db_name, $connect);
$temp=mysql_fetch_array(mysql_query("select subject, name, sitelink1, sitelink2, file_name1, file_name2, memo from zetyx_board_$id where no='$no'", $connect));
$memo=nl2br(stripslashes($temp[memo]));
$name=nl2br(stripslashes($temp[name]));
$subject=nl2br(stripslashes($temp[subject]));
$temp[sitelink2]=stripslashes($temp[sitelink2]);
$arr = array($zero_path,$temp[file_name2]);
$dasom_path = implode("",$arr);
$dasom_1="";
if(!eregi("\.smi",$temp[sitelink2])) $dasom_1="$temp[sitelink2]";
$dasom_3="";
if(!eregi("\.smi",$dasom_path)) $dasom_3="$dasom_path";
if ($dasom_1==""){
	$song_path1=$dasom_3;
}else{
	$song_path1=$temp[sitelink2];
}
$song_path3=$dasom_path;

$song_smi="http://addonis0229.netcci.org/no.smi";
if(eregi("\.smi",$temp[file_name1])) $song_smi="$zero_path$temp[file_name1]";
else if(eregi("\.smi",$temp[sitelink1])) $song_smi="$temp[sitelink1]";
else if(eregi("\.smi",$temp[file_name2])) $song_smi="$zero_path$temp[file_name2]";
else if(eregi("\.smi",$temp[sitelink2])) $song_smi="$temp[sitelink2]";
?>
DasomBGM_List("<?=$song_path1?>","<?=$subject?>","<?=$song_smi?>","<?=$no?>");
<?
mysql_query("update zetyx_board"."_$id set hit=hit+1 where no='$no'");
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
<SCRIPT language=javascript>

function killerror(){
	return true;
}
function processKey()
{
        if( (event.ctrlKey == true && (event.keyCode == 78 || event.keyCode == 82)) ||
        (event.keyCode >= 112 && event.keyCode <= 123) || event.keyCode == 8)
            {
        event.keyCode = 0;
        event.cancelBubble = true;
        event.returnValue = false;
            }
}
window.onerror=killerror;
document.onkeydown = processKey;
var any = '';
var view_mode='close';
function re_size(){
	if(view_mode=='open'){
		oc0.style.display = 'block';
		window.resizeTo(487,595);
		document.oc.src="img/ico_close.gif";
		view_mode = 'close';
	}
}
</script>
</HEAD>
<BODY OnLoad="setting();" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" oncontextmenu="return false" onselectstart="return false" ondragstart="return false" onkeydown="return false">
<form name="DasomBGM">
<script language="JavaScript">
<!-- JavaScript
Player();
// - JavaScript - -->
</script>
<object classid='clsid:6BF52A52-394A-11d3-B153-00C04F79FAA6' id=dasomlove name=dasomlove type='application/x-oleobject' standby='Dasom Windows Media Player...' width=100% height=100%>
	<PARAM NAME="Volume" VALUE="10000">
	<PARAM NAME="uiMode" VALUE="none">
	<PARAM NAME="AutoStart" VALUE="false">
	<PARAM NAME="enableContextMenu" VALUE="false">
</object>

<script language="JavaScript">
document.dasomlove.uiMode = "none" ;
Player2();

</script>

</FORM>
</BODY>
</HTML>
