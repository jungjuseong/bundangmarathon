<link rel=StyleSheet HREF=styles.css type=text/css title=style>
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
<script src="java/autoscroll.js"></script>

<script language="JavaScript">

// ����Ʈ ������ �����κ��Դϴ�.

var framesetting = 0; // ������ ������ �����ϴ� �κ��Դϴ�.(0�ϰ�� ��â����, 1�ϰ�� DasomBGM���� ���������� ���Խ�, 2�ϰ�� �ٸ������ӿ� ���Խ�, �Ʒ������� �̸��� �ٲپ��ֿ��� �մϴ�.)
var UP =  0; // UP ��ư ǥ�� ����(1�ϰ�� ��ư ǥ��. 0�ϰ�� ��ư����)
var Down = 0; //Down��ư ǥ�� ����(1�ϰ�� ��ư ǥ��. 0�ϰ�� ��ư����)
var Close =0; // â�ݱ��ư ǥ�� ����(1�ϰ�� ��ư ǥ��. 0�ϰ�� ��ư����)
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
	switch(UP) {
	case 0 :
	document.all.up.style.visibility = "hidden";
	document.all.up.style.width = 0;
	document.all.up.style.height = 0;
	break;
	case 1 :
	break;
	}
	switch(Down) {
	case 0 :
	document.all.down.style.visibility = "hidden";
	document.all.down.style.width = 0;
	document.all.down.style.height = 0;
	break;
	case 1 :
	break;
	}
	switch(Close) {
	case 0 :
	document.all.close.style.visibility = "hidden";
	document.all.close.style.width = 0;
	document.all.close.style.height = 0;
	break;
	case 1 :
	break;
	}
	switch(DasomBGM) {
	case 0 :
	document.all.dasombgm.style.visibility = "hidden";
	document.all.dasombgm.style.width = 0;
	document.all.dasombgm.style.height = 0;
	break;
	case 1 :
	break;
	}
}
function scing() { // ��ũ�ѹ� ����
	if (scrollover==0){
	document.write("<DIV ID=s1 STYLE='width:100%; height:100%; overflow:hidden; margin-left:20px; margin-right:19px;' >");
	}
	else if (scrollover==1){
	document.write("<DIV ID=s1 STYLE='width:100%; height:96%; overflow:auto; margin-left:20px; margin-right:19px;'>");
	}
}
</script>
<?
require "dbconn.php";
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
<TITLE>���� ����</TITLE>

</HEAD>
<BODY OnLoad='scrolling();' oncontextmenu="return false"  ondragstart="return false" onkeydown="return false"  topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 style='border: 0px solid black; margin: 0pt;'>
<table background=./images/word.gif border=0 cellpadding=0 cellspacing=0 width=100% height=100% class=aa>
<tr>
<td align=center  valign=top><img src=./images/dot2.gif style='cursor:hand;' ONMOUSEOVER="return doScrollerIE('up','s1',10)" ONMOUSEOUT='clearInterval(sRepeat)' border=0 name=up align='middle' alt='���� ����Ʈ����'></td>
<td width=100% align=center  valign=top><img src=./images/dot2.gif style='cursor:hand;' OnClick="window.open('http://www.dasomlove.net/','_blank');" onfocus=this.blur() border=0 name=dasombgm align=middle alt='������ Ȩ����������'></td>
<td align=center  valign=top><img src=./images/dot2.gif style='cursor:hand;' ONMOUSEOVER="return doScrollerIE('down','s1',10)" ONMOUSEOUT="clearInterval(sRepeat)" border=0 name=down align=middle alt='�Ʒ� ����Ʈ����'></td>
</tr>
<tr><td height=24></td></tr>
<tr><td width=100%  colspan=3 valign=top ><center><font color=FFCC00 size=2><b><?=$subject?></b></center></td></tr>
<tr><td height=5></td></tr>
<tr><td width=5 valign=top background=./images/dot2.gif><img src=images/dot2.gif></td>
<td width=100% height='100%' valign=top align=left style='line-height:15px' class=button>
<!-- ��ũ�ѹ� �ڵ����� ���� -->
<script language=JavaScript>scing()</script>
<!-- ��ũ�ѹ� �ڵ����� �� -->
<table border=0 cellpadding=5 cellspacing=5 width=100% height=100%>
<tr>
<td width=100% height=100% align=left valign=top class=button>
<table border=0 cellpadding=0 cellspacing=0 width=100%><tr><td height=3></td></tr></table>
<?=$memo?>
<?
mysql_close($connect);
?>
</td></tr></table>

</td>
<td width=5 valign=top ><img src=images/dot2.gif align=absmiddle></td>
</tr>
<tr><td width=100%  colspan=3 valign=top ><img src=images/dot2.gif></td></tr>
<tr>
<td width=100% class=type colspan=3 align=center  valign=center>
<script language="JavaScript">
minw=e.bgmlistminw;
minh=e.bgmlistminh;
document.write("<img src=./images/Close.gif style='cursor:hand;' onclick='javascript:window.close();' border=0 name=close align=middle alt='����â�ݱ�'>");
if(Close==1){document.write("<br>");}
<!--document.write("<font style=font-size:9pt;>Copyright 2001-2002 </font><a href=http://www.dasomlove.net target=_blink title='������Ȩ������' class='skin'>dasomlove.net</a>\n"); //���� �����ϰų� �������� ������(���̼��� ��úκ�).
-->
</script>
</td></tr></table>
</body>
</html>