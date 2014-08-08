<HTML>
<HEAD>
<TITLE>Dasom Player MUSIC LIST</TITLE>
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
<script src="../../java/autoscroll.js"></script>

<script language="JavaScript">

// 리스트 파일의 설정부분입니다.

var framesetting = 1; // 프래임 삽입을 설정하는 부분입니다.(0일경우 새창으로, 1일경우 DasomBGM내에 아이프래임 삽입시, 2일경우 다른프래임에 삽입시, 아래프래임 이름을 바꾸어주여야 합니다.)
var UP =  0; // UP 버튼 표시 설정(1일경우 버튼 표시. 0일경우 버튼없음)
var Down = 0; //Down버튼 표시 설정(1일경우 버튼 표시. 0일경우 버튼없음)
var Close =1; // 창닫기버튼 표시 설정(1일경우 버튼 표시. 0일경우 버튼없음)
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
function scing() { // 스크롤바 셋팅
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
if(e.PlayList==2){ //재생목록이 창 크기를 조절하는경우라면....
document.write("<div style='position:absolute;left:250px; top:3px;'>");
document.write("<img src=./images/Close.gif style='cursor:hand;' onclick='javascript:" + f + ".setWindowSize("+minw+","+minh+")' border=0 name=close align=middle alt='가사 창닫기'>");
if(Close==1){document.write("<br>");}
document.write("</div>");
}else if(e.PlayList==1){ // 재생목록이 새창으로 띄워준 경우라면..
document.write("<img src=./images/Close.gif style='cursor:hand;' onclick='javascript:window.close();' border=0 name=close align=middle alt='목록 창닫기'>");
if(Close==1){document.write("<br>");}
}else{ // 재생을 숨긴경우나 잘못된 입력이라면..
document.write("<img src=./images/Close.gif style='cursor:hand;' onclick='javascript:window.close();' border=0 name=close align=middle alt='목록 창닫기'>");
if(Close==1){document.write("<br>");}
}
//document.write(""+ e.dasomcopyright+"<sc"+"ript src=./maker.js></sc"+"ript>\n"); //절대 수정하거나 삭제하지 마세요(라이센스 명시부분).

</script><img src=./images/b.gif border=0 ></td>
</tr><tr><td width=100% height=100%>
<table border=0  background=./images/bac.gif cellpadding=0 cellspacing=0 width=100% height=100% >
<tr>
<td width=100% height='100%' valign=top align=left style='line-height:9px' class=button3>
<!-- 스크롤바 자동셋팅 시작 -->
<script language=JavaScript>scing();</script>
<!-- 스크롤바 자동셋팅 끝 -->
<table border=0 cellpadding=0 cellspacing=0 width=100% height=100%>
<tr>
<td width=100% height=100% align=left valign=top colspan=100 class=button>

<center><br><font color=#F8BC00>◈ <b><?=$subject?></b> ◈<br><br>
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
if(e.PlayList==2){ //재생목록이 창 크기를 조절하는경우라면....
document.write("<div style='position:absolute;left:100px; top:3px;'>");
document.write("<img src=./images/List_off.gif style='cursor:hand;' onclick='javascript:" + f + ".setWindowSize("+minw+","+minh+")' border=0 name=close align=middle alt='목록 창닫기'>");
if(Close==1){document.write("<br>");}
document.write("</div>");
}else if(e.PlayList==1){ // 재생목록이 새창으로 띄워준 경우라면..
document.write("<img src=./images/Close.gif style='cursor:hand;' onclick='javascript:window.close();' border=0 name=close align=middle alt='목록 창닫기'>");
if(Close==1){document.write("<br>");}
}else{ // 재생을 숨긴경우나 잘못된 입력이라면..
document.write("<img src=./images/Close.gif style='cursor:hand;' onclick='javascript:window.close();' border=0 name=close align=middle alt='목록 창닫기'>");
if(Close==1){document.write("<br>");}
}
//document.write(""+ e.dasomcopyright+"<sc"+"ript src=./maker.js></sc"+"ript>\n"); //절대 수정하거나 삭제하지 마세요(라이센스 명시부분).

</td></tr></table>

</script>-->
</body>
</html>