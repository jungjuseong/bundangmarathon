<html>
<head>
<title>������ ��ȸ �Խ���</title>
<!--
������ ��ȸ �Խ����� ����� 5�ٸ� ������ ����ϴ� ���
-->
<base href='http://board1.hanmir.com'>
<base target=gumpubbs>
<style type='text/css'>TD {COLOR:BLACK; FONT-FAMILY: '����'; FONT-SIZE: 12px; FONT-STYLE: normal; LINE-HEIGHT:15pt; TEXT-DECORATION: none}</style></head>
</head>
<body bgcolor='#E0FFE0'>
<table width=370 cellspacing=0 cellpadding=0 border=0>

<?php
//���ڿ��� �� �������� ������
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
	$link = str_replace(" onMouseOver=\"window.status=('���뺸��'); return true;\" onMouseOut=\"window.status=(''); return true;\"", "", $link);
	echo "<tr><td>$link\n";
	$fcont[0] = ' '; // pattern change
}
	
?>
</table>
</body>
</html>
