<script language=javascript>
var favoriteurl="http://www.woholcanada.com"
var favoritetitle="★ 워홀캐나다 ★"
function addfavorites(){ if (document.all) window.external.AddFavorite(favoriteurl,favoritetitle); }

function autoBlur(){ 
if(event.srcElement.tagName=="A"||event.srcElement.tagName=="IMG") 
document.body.focus(); } document.onfocusin=autoBlur; 
</script>

<!-- ◈ 메인플래시 좌측 이벤트 배너 ◈ -->
<script type="text/javascript">
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
</script>
<script language="javascript">

	var isDOM = (document.getElementById ? true : false);
	var isIE4 = ((document.all && !isDOM) ? true : false);
	var isNS4 = (document.layers ? true : false);

	function getRef(id)
	{
		if (isDOM) return document.getElementById(id);
		if (isIE4) return document.all[id];
		if (isNS4) return document.layers[id];
	}

	var isNS = navigator.appName == "Netscape";

	function moveRightEdge()
	{
		var yMenuFrom, yMenuTo, yOffset, timeoutNextCheck;
		if (isNS4)
		{
			yMenuFrom   = Probal_Layer.top;
			yMenuTo     = windows.pageYOffset + 139;   // 위쪽 위치
		}
		else if (isDOM)
		{
			yMenuFrom   = parseInt (Probal_Layer.style.top, 10);
			yMenuTo     = (isNS ? window.pageYOffset : document.body.scrollTop) + 139; // 위쪽 위치
		}

		timeoutNextCheck = 500;

		if (yMenuFrom != yMenuTo)
		{
			yOffset = Math.ceil(Math.abs(yMenuTo - yMenuFrom) / 20);
			if (yMenuTo < yMenuFrom)
				yOffset = -yOffset;
			if (isNS4)
				Probal_Layer.top += yOffset;
			else if (isDOM)
				Probal_Layer.style.top = parseInt (Probal_Layer.style.top, 10) + yOffset;
				timeoutNextCheck = 10;
		}
		setTimeout ("moveRightEdge()", timeoutNextCheck);
	}
</script>
<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
<script src="/embed.js" language="JavaScript" type="text/javascript"></script>
<script src="DWConfiguration/ActiveContent/IncludeFiles/AC_RunActiveContent.js" type="text/javascript"></script>
<body >

<div id="Probal_Layer" style="position:absolute; align:center; margin:auto; top:18px; width:115px; height:220px; z-index:1; visibility: visible;left:expression( 1040 + (document.body.clientWidth-1040)/2 );">
  <table width="115" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><img src="../images/sub_quick_menu.gif" width="115" height="220" border="0" usemap="#Map"></td>
    </tr>
  </table>
</div>
<script language="javascript">
	if (isNS4)
	{
		var Probal_Layer = document["Probal_Layer"];
		Probal_Layer.top = top.pageYOffset + 120;
		Probal_Layer.visibility = "visible";
		moveRightEdge();

	}
	else if (isDOM)
	{
		var Probal_Layer = getRef('Probal_Layer');
		Probal_Layer.style.top = (isNS ? window.pageYOffset : document.body.scrollTop) + 120;
		Probal_Layer.style.visibility = "visible";
		moveRightEdge();
	}
</script>

<map name="Map"><area shape="rect" coords="10,152,92,183" href="http://www.woholcanada.com/comm/comm_06.asp" target="_self">
</map>