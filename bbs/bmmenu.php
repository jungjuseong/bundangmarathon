<html>
<head>
<title>ȸ������</title>
<!--
<base href='http://www.bundangmarathon.com/bbs/'>
-->
<base target='framecont'>

<style TYPE='text/css'>
a:link, a:visited, a:active {text-decoration:none;}
A:hover{color:#FFCC00; text-decoration:underline;}
A:link{text-decoration:none}
table { font-family:����,arial,sans-serif; font-size:9pt; text-decoration:none; line-height:140%}
td.td0 {height:32px;}
td.td1 {height:15px; text-align:left; vertical-align:middle; color:#060084; cursor:hand;}
td.td2 {font-family:����,arial,sans-serif; font-size:8pt; font-color:#ffffff; text-decoration:none;}
p { font-family:����,arial,sans-serif; font-size:9pt; font-color:#000000; text-decoration:none;}
</style>

<!--
<DIV style="position:relative; left: 50px; top: 50px; color: blue">
Relative, 50, 50, Parent is Document
</DIV>
<DIV style="position:absolute; left: 250px; top: 350px; color: gray">
Absolute, 250, 350, Parent is Document
</DIV>
-->

<script language='JavaScript'>
<!--
function DivVisible(LayerName){
	var i,p,v,obj;
// Div menu item = 10
	if(LayerName == "")
		return false;
	for (i=0; i<10; i++){
		p = 'Layer'+i;
		obj=document.getElementById(p);
		if (p == LayerName) {
			v='show';
		}else{
			v='hide';
		}
		if (obj.style) {
			obj=obj.style;
			v=(v=='show')?'visible':(v=='hide')?'hidden':v;
		}
		obj.visibility=v;
	}
	return true;
}
function ColorDisp(obj, bgcolor, stylecolor){
	obj.style.backgroundColor=bgcolor;
	obj.style.color=stylecolor;
}
//-->
</script>
</head>

<body bgcolor='#E0FFE0' leftmargin='0' topmargin='0' marginwidth='0' marginheight='0' background='image/back.gif' link='#FFFFFF' vlink='#FFFFFF' alink='#FFCC00''>
<table border='0' cellspacing='0' cellpadding='0' height='22'>
  <tr>
    <td class=td2 bgcolor='#000000' align='left'>

<table border='0' cellspacing='0' cellpadding='0' height='22'>
  <tr>
    <td><a href='bmlogon.php?mode=framecont' onMouseOver="DivVisible('Layer0')">��ȸ������Ȩ </a></td>
    <td background='image/line-back.gif' width='10'>&nbsp; </td>
    <td ><a href='bmmeminfo.php?mode=submenu' onMouseOver="DivVisible('Layer1')">��Ŭ������ </a></td>
    <td width=10></td>
    <td><a href='bmmem.php?mode=submenu' onMouseOver="DivVisible('Layer2')">���������� </a></td>
    <td width=10></td>
    <td ><a href='bmrace.php?mode=submenu' onMouseOver="DivVisible('Layer3')">����ȸ���� </a></td>
    <td width=10></td>
    <td ><a href='bminviting.php?mode=submenu' onMouseOver="DivVisible('Layer4')">����ȸ���� </a></td>
    <td width=10></td>
    <td ><a href='bmrecord.php?mode=submenu' onMouseOver="DivVisible('Layer5')">����ϰ���</a></td>
<!--
    <td width=10></td>
    <td ><a href='bmsched.php?mode=submenu' onMouseOver="DivVisible('Layer6')">���������� </a></td>
-->
    <td width=10></td>
    <td ><a href='bmlogon.php?mode=submenu' onMouseOver="DivVisible('Layer7')">����������/��Ÿ </a></td>
<!--
    <td width=10></td>
    <td ><a href='200510match.html' onMouseOver="DivVisible('Layer8')">2005 ��õ ����</a></td>
-->
    <td width=10></td>
    <td ><a href='bmmanager.php?mode=menu' onMouseOver="DivVisible('Layer9')">�������ڱ�� </a></td>
    <td width='10'>&nbsp; </td>
  </tr>
</table>
<div id='Layer0' style='position:absolute; left:50px; top:22px; height:20px; z-index:1; visibility: hidden'>
</div>
<div id='Layer1' style='position:absolute; left:50px; top:22px; height:20px; z-index:1; visibility: hidden'>
  <table border='0' cellspacing='0' cellpadding='0'><tr bgcolor='#0052CE'>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
	<a href='bmmeminfo.php?mode=meminfo-brief'>ȸ����������</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
	<a href='bmmeminfo.php?mode=meminfo-slide'>�������Ӻ���</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
	<a href='bmmeminfo.php?mode=meminfo-addrlist'>ȸ���ּҷ�</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
	<a href='bmmeminfo.php?mode=meminfo-sendmemo'>�����߼�</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
	<a href='bmbook.php'>�����ⳳ��</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
	<a href='bmtraining.php'>�����⼮��</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
	<a href='bmmem.php?mode=chuka'>�����մϴ�</a></td>
  </tr></table>
</div>
<div id='Layer2' style='position:absolute; left:110px; top:22px; height:20px; z-index:2; visibility: hidden'>
  <table border='0' cellspacing='0' cellpadding='0'><tr bgcolor='#0052CE'>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='member_modify.php?group_no=1'>������������1</a></td>
<!--
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='bmmem.php?mode=idpasswd-change'>��ȣ����</a></td>
-->
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='bmmem.php?mode=member-change'>������������2</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='bmmem.php?mode=photo-upload-set'>ȸ���ȳ���󱼻������ε�</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='bmmem.php?mode=racephoto-upload-set'>��ȸ�������ε�</a></td>
  </tr></table>
</div>
<div id='Layer3' style='position:absolute; left:170px; top:22px; height:20px; z-index:3; visibility: hidden'>
  <table border='0' cellspacing='0' cellpadding='0'><tr bgcolor='#0052CE'>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='bmrace.php?mode=race-input'>��ȸ�����űԵ��</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='bmrace.php?mode=race-select'>��ȸ��������/��û����</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='bmrace.php?mode=race-list'>�Էµȴ�ȸ���</a></td>
  </tr></table>
</div>
<div id='Layer4' style='position:absolute; left:200px; top:22px; height:20px; z-index:4; visibility: hidden'>
  <table border='0' cellspacing='0' cellpadding='0'><tr bgcolor='#0052CE'>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='bminviting.php?mode=inviting-input'>������û</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='bminviting.php?mode=inviting-change'>������û����</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='bminviting.php?mode=inviting-list'>�����ڸ��</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='bminviting.php?mode=record-list'>�����ڱ��</a></td>
  </tr></table>
</div>

<div id='Layer5' style='position:absolute; left:150px; top:22px; height:20px; z-index:5; visibility: hidden'>
  <table border='0' cellspacing='0' cellpadding='0'><tr bgcolor='#0052CE'>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='bmrecord.php?mode=record-input'>���α�ϵ��</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='bmrecord.php?mode=record-list'>���α�ϸ��</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='bmrecord.php?mode=record-top20'>Ǯ�ڽ�Top20</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='bmrecord.php?mode=record-yeartop20'>������Top20</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='bmrecord.php?mode=record-racecount'>Ŭ���������</a></td>
      <td width=10></td>
  </tr></table>
</div>
<div id='Layer6' style='position:absolute; left:360; top:22px; height:20px; z-index:6; visibility: hidden'>
  <table border='0' cellspacing='0' cellpadding='0'><tr bgcolor='#0052CE'>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		���߿����Դϴ�.</td>
      <td width=10></td>
  </tr></table>
</div>
<div id='Layer7' style='position:absolute; left:180px; top:22px; height:20px; z-index:7; visibility: hidden'>
  <table border='0' cellspacing='0' cellpadding='0'><tr bgcolor='#0052CE'>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='minipoll.php'>MiniPoll</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
	    <a href='minipoll.php'>[2014�� ���Ƹ�ġ ����]</a></td>
<!--     
     <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
<?php
		$today = date("Y")."/".date("m")."/".date("d");
		if($today>="2008/07/02")
			echo "<a href='2008election.html'>��5�� ȸ��� ����</a>";
?>
-->
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='0000polled.html'>������ ��ǥ</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='bmoldbbs.html'>���� �Խ��� ����</a></td>
<!--
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='logon.php?mode=logoff' target='memberwindow'>�α׿���</a>
-->
</td>
  </tr></table>
</div>
<div id='Layer8' style='position:absolute; left:440px; top:22px; height:20px; z-index:9; visibility: hidden'>
</div>
<div id='Layer9' style='position:absolute; left:490px; top:22px; height:20px; z-index:9; visibility: hidden'>
</div>
</td>
</tr>
</table>
</body>
</html>
