<link rel=StyleSheet HREF=styles.css type=text/css title=style>
<script>

/*♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡
Dasom Player
Copyright (c)2001 by dasomlove.net all right reserved
HomePages : http://www.dasomlove.net/
이 스크립트는 Dasom Player 라이센스에 따릅니다.
사용시 저작권 명시부분을 훼손하면 안됍니다.
♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡*/

</script>
<META name="Subject" content="I love you warts and all.">
<META name="Title" content="">
<META name="Author" content="♡다솜지기♡">
<META name="keywords" content="Dasom BGM player">
<META http-equiv="Content-Type" content="text/html; charset=euc-kr">
<script src="java/autoscroll.js"></script>

<script language="JavaScript">

// 리스트 파일의 설정부분입니다.

var framesetting = 0; // 프래임 삽입을 설정하는 부분입니다.(0일경우 새창으로, 1일경우 DasomBGM내에 아이프래임 삽입시, 2일경우 다른프래임에 삽입시, 아래프래임 이름을 바꾸어주여야 합니다.)
var UP =  0; // UP 버튼 표시 설정(1일경우 버튼 표시. 0일경우 버튼없음)
var Down = 0; //Down버튼 표시 설정(1일경우 버튼 표시. 0일경우 버튼없음)
var Close =0; // 창닫기버튼 표시 설정(1일경우 버튼 표시. 0일경우 버튼없음)
var DasomBGM=0; // 업다운 버튼 가운데 이미지표시 설정(1일경우 버튼 표시. 0일경우 버튼없음)
var scrollover=1; //스크롤바 생성 설정(1일경우 자동으로 생김. 0일경우 스크롤바 없음
var strsut="..."; //잘라낸 곡명뒤에 붙이는 글자로 ""안에 넣어야 한다^^
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
	//만약 다른페이지에 이 목록 파일을 삽입한다면 DasomBGM을 DasomBGM.html파일의 프래임 이름으로 바꾸세요.
	break;
	}
//★여기부터 수정하지 마세요

function scrolling() { // 자동 초기 셋팅
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
function scing() { // 스크롤바 셋팅
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
<TITLE>가사 보기</TITLE>

</HEAD>
<BODY OnLoad='scrolling();' oncontextmenu="return false"  ondragstart="return false" onkeydown="return false"  topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 style='border: 0px solid black; margin: 0pt;'>
<table background=./images/word.gif border=0 cellpadding=0 cellspacing=0 width=100% height=100% class=aa>
<tr>
<td align=center  valign=top><img src=./images/dot2.gif style='cursor:hand;' ONMOUSEOVER="return doScrollerIE('up','s1',10)" ONMOUSEOUT='clearInterval(sRepeat)' border=0 name=up align='middle' alt='위에 리스트보기'></td>
<td width=100% align=center  valign=top><img src=./images/dot2.gif style='cursor:hand;' OnClick="window.open('http://www.dasomlove.net/','_blank');" onfocus=this.blur() border=0 name=dasombgm align=middle alt='제작자 홈페이지가기'></td>
<td align=center  valign=top><img src=./images/dot2.gif style='cursor:hand;' ONMOUSEOVER="return doScrollerIE('down','s1',10)" ONMOUSEOUT="clearInterval(sRepeat)" border=0 name=down align=middle alt='아래 리스트보기'></td>
</tr>
<tr><td height=24></td></tr>
<tr><td width=100%  colspan=3 valign=top ><center><font color=FFCC00 size=2><b><?=$subject?></b></center></td></tr>
<tr><td height=5></td></tr>
<tr><td width=5 valign=top background=./images/dot2.gif><img src=images/dot2.gif></td>
<td width=100% height='100%' valign=top align=left style='line-height:15px' class=button>
<!-- 스크롤바 자동셋팅 시작 -->
<script language=JavaScript>scing()</script>
<!-- 스크롤바 자동셋팅 끝 -->
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
document.write("<img src=./images/Close.gif style='cursor:hand;' onclick='javascript:window.close();' border=0 name=close align=middle alt='가사창닫기'>");
if(Close==1){document.write("<br>");}
<!--document.write("<font style=font-size:9pt;>Copyright 2001-2002 </font><a href=http://www.dasomlove.net target=_blink title='제작자홈페이지' class='skin'>dasomlove.net</a>\n"); //절대 수정하거나 삭제하지 마세요(라이센스 명시부분).
-->
</script>
</td></tr></table>
</body>
</html>