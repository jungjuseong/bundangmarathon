<HTML>
<HEAD>
<TITLE>Dasom Player MUSIC LIST</TITLE>
<script>

/*����������������������������������������������������
Dasom Player
Copyright (c)2001 by dasomlove.net all right reserved
HomePages : http://www.dasomlove.net/
�� ��ũ��Ʈ�� Dasom Player ���̼����� �����ϴ�.
���� ���۱� ��úκ��� �Ѽ��ϸ� �ȉϴϴ�.
������������������������������������������������������*/

</script>
<META name="Subject" content="I love you warts and all.">
<META name="Title" content="">
<META name="Author" content="���ټ����⢽">
<META name="keywords" content="Dasom BGM player">
<META http-equiv="Content-Type" content="text/html; charset=euc-kr">
<script src="../../java/autoscroll.js"></script>

<script language="JavaScript">

// ����Ʈ ������ �����κ��Դϴ�.

var framesetting = 1; // ������ ������ �����ϴ� �κ��Դϴ�.(0�ϰ�� ��â����, 1�ϰ�� DasomBGM���� ���������� ���Խ�, 2�ϰ�� �ٸ������ӿ� ���Խ�, �Ʒ������� �̸��� �ٲپ��ֿ��� �մϴ�.)
var UP =  0; // UP ��ư ǥ�� ����(1�ϰ�� ��ư ǥ��. 0�ϰ�� ��ư����)
var Down = 0; //Down��ư ǥ�� ����(1�ϰ�� ��ư ǥ��. 0�ϰ�� ��ư����)
var Close =1; // â�ݱ��ư ǥ�� ����(1�ϰ�� ��ư ǥ��. 0�ϰ�� ��ư����)
var DasomBGM=0; // ���ٿ� ��ư ��� �̹���ǥ�� ����(1�ϰ�� ��ư ǥ��. 0�ϰ�� ��ư����)
var scrollover=1; //��ũ�ѹ� ���� ����(1�ϰ�� �ڵ����� ����. 0�ϰ�� ��ũ�ѹ� ����
var strsut="..."; //�߶� ���ڿ� ���̴� ���ڷ� ""�ȿ� �־�� �Ѵ�^^
var e;
var f;
	switch(framesetting) {
	case 0 :
	e = opener;
	f = "opener";
	break;
	case 1 :
	e = parent;
	f = "parent";
	break;
	case 2 :
	e = DasomBGM.parent;
	f = "DasomBGM.parent";
	//���� �ٸ��������� �� ��� ������ �����Ѵٸ� DasomBGM�� DasomBGM.html������ ������ �̸����� �ٲټ���.
	break;
	}
//�ڿ������ �������� ������

function scrolling() { // �ڵ� �ʱ� ����
	switch(Close) {
	case 0 :
	document.all.close.style.visibility = "hidden";
	document.all.close.style.width = 0;
	document.all.close.style.height = 0;
	break;
	case 1 :
	break;
	}
}
function scing() { // ��ũ�ѹ� ����
	if (scrollover==0){
	document.write("<DIV ID=s1 STYLE='width:100%; height:100%; overflow:hidden; margin-left:0px;'>");
	}
	else if (scrollover==1){
	document.write("<DIV ID=s1 STYLE='width:100%; height:100%; overflow:auto; margin-left:0px;'>");
	}
}
</script>
<?
require "../../dbconn.php";
$connect=mysql_connect($host_name,$user_name,$db_password);
mysql_select_db($db_name, $connect);
$temp=mysql_fetch_array(mysql_query("select subject, name, sitelink1, sitelink2, file_name1, file_name2, memo from zetyx_board_$id where no='$no'", $connect));

$memo=nl2br(stripslashes($temp[memo]));
$subject=nl2br(stripslashes($temp[subject]));
$temp[sitelink1]=stripslashes($temp[sitelink1]);
$temp[file_name1]=stripslashes($temp[file_name1]);
$arr = array($zero_path,$temp[file_name1]);
$dasom_path = implode("",$arr);
$dasom_1=$temp[sitelink1];
$dasom_3=$dasom_path;
if ($dasom_1==""){
	$song_path1=$dasom_3;
}else{
	$song_path1=$temp[sitelink1];
}
$song_path3=$dasom_path;

?>
<TITLE><?=$subject?></TITLE>
<LINK REL='stylesheet' TYPE='text/css' HREF='./PlayerList.css'>
</HEAD>
<BODY  bgcolor="transparent" OnLoad='scrolling();' oncontextmenu="return false"  ondragstart="return false" onkeydown="return false"  topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 style='border: 0px solid black; margin: 0pt;'>
<table border=0  cellpadding=0 cellspacing=0 width=100% height=100% >
<tr>
<td width=312 height=20>
<script language="JavaScript">
minw=e.bgmlistminw;
minh=e.bgmlistminh;
if(e.PlayList==2){ //�������� â ũ�⸦ �����ϴ°����....
document.write("<div style='position:absolute;left:250px; top:3px;'>");
document.write("<img src=./images/Close.gif style='cursor:hand;' onclick='javascript:" + f + ".setWindowSize("+minw+","+minh+")' border=0 name=close align=middle alt='���� â�ݱ�'>");
if(Close==1){document.write("<br>");}
document.write("</div>");
}else if(e.PlayList==1){ // �������� ��â���� ����� �����..
document.write("<img src=./images/Close.gif style='cursor:hand;' onclick='javascript:window.close();' border=0 name=close align=middle alt='��� â�ݱ�'>");
if(Close==1){document.write("<br>");}
}else{ // ����� �����쳪 �߸��� �Է��̶��..
document.write("<img src=./images/Close.gif style='cursor:hand;' onclick='javascript:window.close();' border=0 name=close align=middle alt='��� â�ݱ�'>");
if(Close==1){document.write("<br>");}
}
//document.write(""+ e.dasomcopyright+"<sc"+"ript src=./maker.js></sc"+"ript>\n"); //���� �����ϰų� �������� ������(���̼��� ��úκ�).

</script><img src=./images/b.gif border=0 ></td>
</tr><tr><td width=100% height=100%>
<table border=0  background=./images/bac.gif cellpadding=0 cellspacing=0 width=100% height=100% >
<tr>
<td width=100% height='100%' valign=top align=left style='line-height:9px' class=button3>
<!-- ��ũ�ѹ� �ڵ����� ���� -->
<script language=JavaScript>scing();</script>
<!-- ��ũ�ѹ� �ڵ����� �� -->
<table border=0 cellpadding=0 cellspacing=0 width=100% height=100%>
<tr>
<td width=100% height=100% align=left valign=top colspan=100 class=button>

<center><br><font color=#F8BC00>�� <b><?=$subject?></b> ��<br><br>
<?=$memo?>
<?
mysql_close($connect);
?></center>
</td></tr></table></td></tr></table></td></tr></table>


<!--
<table border=0 cellpadding=0 cellspacing=0 width=100%>
<tr>
<td align=center class=type>
<script language="JavaScript">
minw=e.bgmlistminw;
minh=e.bgmlistminh;
if(e.PlayList==2){ //�������� â ũ�⸦ �����ϴ°����....
document.write("<div style='position:absolute;left:100px; top:3px;'>");
document.write("<img src=./images/List_off.gif style='cursor:hand;' onclick='javascript:" + f + ".setWindowSize("+minw+","+minh+")' border=0 name=close align=middle alt='��� â�ݱ�'>");
if(Close==1){document.write("<br>");}
document.write("</div>");
}else if(e.PlayList==1){ // �������� ��â���� ����� �����..
document.write("<img src=./images/Close.gif style='cursor:hand;' onclick='javascript:window.close();' border=0 name=close align=middle alt='��� â�ݱ�'>");
if(Close==1){document.write("<br>");}
}else{ // ����� �����쳪 �߸��� �Է��̶��..
document.write("<img src=./images/Close.gif style='cursor:hand;' onclick='javascript:window.close();' border=0 name=close align=middle alt='��� â�ݱ�'>");
if(Close==1){document.write("<br>");}
}
//document.write(""+ e.dasomcopyright+"<sc"+"ript src=./maker.js></sc"+"ript>\n"); //���� �����ϰų� �������� ������(���̼��� ��úκ�).

</td></tr></table>

</script>-->
</body>
</html>