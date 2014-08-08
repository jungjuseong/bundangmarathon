<html>
<head>
<title>분당마라톤클럽 회원광장</title>
<!--
<base href='http://www.gumpu.pe.kr/member/prog/'>
-->
<base target='framecont'>

<style TYPE='text/css'>
a:link, a:visited, a:active {text-decoration:none;}
A:hover{color:#FFCC00; text-decoration:underline;}
A:link{text-decoration:none}
table { font-family:굴림,arial,sans-serif; font-size:9pt; text-decoration:none; line-height:140%}
td.td0 {height:32px;}
td.td1 {height:15px; text-align:left; vertical-align:middle; color:#060084; cursor:hand;}
td.td2 {font-family:굴림,arial,sans-serif; font-size:8pt; font-color:#ffffff; text-decoration:none;}
p { font-family:굴림,arial,sans-serif; font-size:9pt; font-color:#000000; text-decoration:none;}
</style>

<script language='JavaScript'>
<!--
function DivVisible(LayerName){
	var i,p,v,obj;
// Div menu item = 10
	if(LayerName == "")
		return false;
	for (i=0; i<10; i++){
		p = 'Layer'+i;
		obj=document.all[p];
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
    <td><a href='logon.php?mode=framecont' onMouseOver="DivVisible('Layer0')">⊙회원광장홈 </a></td>
    <td background='image/line-back.gif' width='10'>&nbsp; </td>
    <td ><a href='meminfo.php?mode=submenu' onMouseOver="DivVisible('Layer1')">⊙클럽정보 </a></td>
    <td width=10></td>
    <td><a href='mem.php?mode=submenu' onMouseOver="DivVisible('Layer2')">⊙본인정보 </a></td>
    <td width=10></td>
    <td ><a href='race.php?mode=submenu' onMouseOver="DivVisible('Layer3')">⊙대회정보 </a></td>
    <td width=10></td>
    <td ><a href='inviting.php?mode=submenu' onMouseOver="DivVisible('Layer4')">⊙대회참가 </a></td>
    <td width=10></td>
    <td ><a href='record.php?mode=submenu' onMouseOver="DivVisible('Layer5')">⊙기록관리</a></td>
    <td width=10></td>
    <td ><a href='sched.php?mode=submenu' onMouseOver="DivVisible('Layer6')">⊙일정관리 </a></td>
    <td width=10></td>
    <td ><a href='logon.php?mode=submenu' onMouseOver="DivVisible('Layer7')">⊙기타 </a></td>
<!--
    <td width=10></td>
    <td ><a href='logon.php?mode=hanmir' onMouseOver="DivVisible('Layer8')">한미르회원광장</a></td>
-->
    <td width=10></td>
    <td ><a href='manager.php?mode=menu' onMouseOver="DivVisible('Layer9')">⊙관리자기능 </a></td>
    <td width='10'>&nbsp; </td>
  </tr>
</table>
<div id='Layer0' style='position:absolute; left:50px; top:22px; height:20px; z-index:1; visibility: hidden'>
</div>
<div id='Layer1' style='position:absolute; left:50px; top:22px; height:20px; z-index:1; visibility: hidden'>
  <table border='0' cellspacing='0' cellpadding='0'><tr bgcolor='#0052CE'>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
	<a href='meminfo.php?mode=meminfo-brief'>회원정보보기</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
	<a href='meminfo.php?mode=meminfo-slide'>사진슬라이드보기</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
	<a href='meminfo.php?mode=meminfo-addrlist'>회원주소록</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
	<a href='meminfo.php?mode=meminfo-sendmail'>회원대상메일발송</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
	<a href='book.php'>현금출납부</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
	<a href='training.php'>정모출석부</a></td>
  </tr></table>
</div>
<div id='Layer2' style='position:absolute; left:110px; top:22px; height:20px; z-index:2; visibility: hidden'>
  <table border='0' cellspacing='0' cellpadding='0'><tr bgcolor='#0052CE'>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='mem.php?mode=member-change'>본인정보수정</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='mem.php?mode=idpasswd-change'>암호변경</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='mem.php?mode=photo-upload-set'>얼굴사진업로드</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='mem.php?mode=racephoto-upload-set'>대회사진업로드</a></td>
  </tr></table>
</div>
<div id='Layer3' style='position:absolute; left:170px; top:22px; height:20px; z-index:3; visibility: hidden'>
  <table border='0' cellspacing='0' cellpadding='0'><tr bgcolor='#0052CE'>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='race.php?mode=race-input'>대회정보신규등록</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='race.php?mode=race-select'>대회정보수정/신청마감</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='race.php?mode=race-list'>입력된대회목록</a></td>
  </tr></table>
</div>
<div id='Layer4' style='position:absolute; left:200px; top:22px; height:20px; z-index:4; visibility: hidden'>
  <table border='0' cellspacing='0' cellpadding='0'><tr bgcolor='#0052CE'>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='inviting.php?mode=inviting-input'>참가신청</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='inviting.php?mode=inviting-change'>참가신청수정</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='inviting.php?mode=inviting-list'>참가자목록</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='inviting.php?mode=record-list'>참가자기록</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='record.php?mode=record-racecount'>회원기록종합</a></td>
  </tr></table>
</div>

<div id='Layer5' style='position:absolute; left:250px; top:22px; height:20px; z-index:5; visibility: hidden'>
  <table border='0' cellspacing='0' cellpadding='0'><tr bgcolor='#0052CE'>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='record.php?mode=record-input'>본인기록등록</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='record.php?mode=record-list'>본인기록목록</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='record.php?mode=record-top20'>풀코스 Top20</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='record.php?mode=record-yeartop20'>올해의Top20</a></td>
      <td width=10></td>
  </tr></table>
</div>
<div id='Layer6' style='position:absolute; left:360; top:22px; height:20px; z-index:6; visibility: hidden'>
  <table border='0' cellspacing='0' cellpadding='0'><tr bgcolor='#0052CE'>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		개발예정입니다.</td>
      <td width=10></td>
  </tr></table>
</div>
<div id='Layer7' style='position:absolute; left:400px; top:22px; height:20px; z-index:7; visibility: hidden'>
  <table border='0' cellspacing='0' cellpadding='0'><tr bgcolor='#0052CE'>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='poll/pollresult.php'>투표</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='/oldbbs.html'>이전 게시판 모음</a></td>
      <td width=10></td>
      <td class=td1 onMouseOver="ColorDisp(this,'#000000','#1800FF')" onMouseOut="ColorDisp(this,'#0052CE','#060084')">
		<a href='logon.php?mode=logoff' target='memberwindow'>로그오프</a>
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
