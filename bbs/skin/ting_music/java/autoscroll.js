/*������������������������������������������������������������
 Dasom BGM Player
 Copyleft (c)2001~2002 by dasomlove.net all right reserved
 HomePages : http://www.dasomlove.net/
 �������� �����ϴ�.
������������������������������������������������������������*/
var sRepeat=null;
function doScrollerIE(dir, src, amount) {
	if (amount==null) amount=10;
	if (dir=="up")
		document.all[src].scrollTop-=amount;
	else
		document.all[src].scrollTop+=amount;
	if (sRepeat==null)
		sRepeat = setInterval("doScrollerIE('" + dir + "','" + src + "'," + amount + ")",100); //��ũ�� �ӵ� ����
	return false
}
window.document.onmouseout = new Function("clearInterval(sRepeat);sRepeat=null");
window.document.ondragstart = new Function("return false");

