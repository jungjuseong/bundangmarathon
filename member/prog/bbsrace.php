<html>
<head>
<title>마라톤 대회 게시판</title>
<!--
마라톤 대회 게시판의 목록을 5줄만 간단히 출력하는 기능
-->
<base href='http://board1.hanmir.com'>
<base target=gumpubbs>
<style type='text/css'>TD {COLOR:BLACK; FONT-FAMILY: '굴림'; FONT-SIZE: 12px; FONT-STYLE: normal; LINE-HEIGHT:15pt; TEXT-DECORATION: none}</style></head>
</head>
<body bgcolor='#E0FFE0'>
<table width=370 cellspacing=0 cellpadding=0 border=0>

<?php
//문자열로 웹 페이지를 가져옴
//

$fcontents = join ('', file ('http://board1.hanmir.com/blue/Board.cgi?path=db40&db=gumpu005'));

$pos1 = strpos($fcontents, "<a href='/blue/Board.cgi");
$pos2 = strpos($fcontents, "</form>");
$fcont = substr($fcontents, $pos1, $pos2-$pos1);

for($i = 0; $i < 5; $i++){
	$fcont = strstr($fcont, "<a href='/blue/Board.cgi");
	if($fcont == false) break;
	$pos = strpos($fcont, "</a>");
	$link = substr($fcont, 0, $pos +4);
	$link = str_replace(" onMouseOver=\"window.status=('내용보기'); return true;\" onMouseOut=\"window.status=(''); return true;\"", "", $link);
	echo "<tr><td>$link\n";
	$fcont[0] = ' '; // pattern change
}
	
?>
</table>
</body>
</html>
