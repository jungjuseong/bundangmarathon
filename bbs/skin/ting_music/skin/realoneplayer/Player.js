/*♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡
Dasom Player
Copyright (c)2001~2002 by dasomlove.net all right reserved
HomePages : http://www.dasomlove.net/
이 스크립트는 Dasom Player 라이센스에 따릅니다.
사용시 저작권 명시부분을 훼손하면 안됍니다.
♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡
★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
 아래는 플래이어의 모양을 설정하는 부분입니다.
 document.write("이안에 태그를 삽입하세요");
 alt태그에 의해 나타나는 도움말은 bgm 내부 설정과 맞춘것입니다.
 현제 사용하고 있는 이미지 이름과 alt의 도움말은 동일하게 사용하시기 바랍니다.
★주의, 큰따옴표(")는 사용이 안돼니 작은따옴표(')를 사용하세요.
★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★*/

function Player() { // 플래이어의 모양을 설정하는 부분
document.write("<img src="+dasomskin+"/images/Playerbg.gif>");
document.write("<div style='position:absolute;left:159px; top:150px;'>");
document.write("<img src="+dasomskin+"/images/spectrum_off.gif align=absmiddle name='spectrum' border=0 class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">");
document.write("</div>");
document.write("<div style='position:absolute;left:40px; top:104px;'>");
document.write("<img src="+dasomskin+"/images/spec_off.gif align=absmiddle name='spec' border=0 class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">");
document.write("</div>");
document.write("</div>");

document.write("<div style='position:absolute;left:13px; top:76px;'>");
document.write("<img src="+dasomskin+"/images/allloop_off.gif style='cursor:hand;' onclick='javascript:DasomBGM_Allloop()' border=0 name=allloop align='absmiddle' alt='' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">");
document.write("</div>");
   //document.write("<img src="+dasomskin+"/images/none.gif align=absmiddle width=5>");
document.write("<div style='position:absolute;left:9px; top:51px;'>");
document.write("<img src="+dasomskin+"/images/random_off.gif style='cursor:hand;' onclick='javascript:DasomBGM_RandomPlay()' border=0 name=randommode align='absmiddle' alt='' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">");
document.write("</div>");
   //document.write("<img src="+dasomskin+"/images/none.gif align=absmiddle width=5>");
document.write("<div style='position:absolute;left:6px; top:27px;'>");
document.write("<img src="+dasomskin+"/images/Loop_off.gif onclick='javascript:DasomBGM_Loop()' border=0 style='cursor:hand;' name=loop align='absmiddle' alt='현재곡 반복' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">");
document.write("</div>");
//document.write("<div style='position:absolute;left:436px; top:10px;'>");
//document.write("<img src="+dasomskin+"/images/cl.gif style='cursor:hand;' onclick='javascript:window.close();' border=0 name=close align=middle alt='목록 창닫기'>");
//document.write("</div>");
//document.write("<div style='position:absolute;left:436px; top:10px;'>");
//document.write("<<?if($sitelink2) {?><?echo"<img src=$sitelink2 border=0  width=60 height=40>";?><?} else {?><?echo"<img src=$dir/bbox.gif border=0  width=60 height=40>";?><?}?>>");
//document.write("</div>");


document.write("<div style='position:absolute;left:120px; top:105px;'>");
if(playTitle == 0) {// 노래 제목이 나타날 부분
   document.write("<span id=stitle name='stitle' style='width:0px; height:0px;visibility:hidden;'></span>");
}else if (playTitle == 1){
   document.write("<span id=stitle name='stitle' class ='buttom1' style='width:200px;'></span>");
}else if(playTitle == 2){ // 제목을 스크롤 시킨다면.
   document.write("<marquee class ='buttom1' style='width:135px;' truespeed scrollamount=3><span id=stitle name='stitle'></span></marquee>");
}// 제목 나타나는 부분 설정 끝.
document.write("</div>");
document.write("<div style='position:absolute;left:250px; top:22px;'>");
   if(status == 0) { // 플래이어 상태표시 시작
   document.write("<span id='playerstatus' name='playerstatus' style='font-size:9pt;width:0;visibility:hidden;'></span>");
   }else if (status == 1){
   document.write("<span id='playerstatus' name='playerstatus' class=buttom3></span>");
   }// 플래이어 상태표시 끝
document.write("</div>");
document.write("<div style='position:absolute;left:230px; top:73px;'>");
   if(playruntime == 0) { // 진행시간표시시작
   document.write("<span id='playtime' name='playtime' style='font-size:9pt;width:0;visibility:hidden;'></span>");
   }else if (playruntime == 1){
   document.write("<span id='playtime'  class=buttom>00:00/00:00</span>");
   }// 진행시간표시 끝
document.write("</div>");

document.write("<div style='position:absolute;left:4px; top:176px;'>");
document.write("<span id=words name=words></span>");
document.write("</div>");


document.write("<div style='position:absolute;left:339px; top:176px;'>");
if(PlayList == 0){ //리스트 버튼조절 시작
   document.write("<img src="+dasomskin+"/images/List_on.gif style='cursor:hand;' align='absmiddle' name=plist style='width:0px; height:0px;visibility:hidden;'>");
}else if(PlayList == 1){
   document.write("<img src="+dasomskin+"/images/List_on.gif style='cursor:hand;' onclick='javascript:DasomBGM_PList(); return false;' border='0' align='absmiddle' name=plist alt='음악목록' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">");
}else if(PlayList == 2){ // 창 크기를 조절을 해야하는 버튼이라면..
   document.write("<a href="+dasomskin+"/PlayerList.html target=Player onfocus=this.blur()><img src="+dasomskin+"/images/List_off.gif onclick='javascript:setWindowSize("+bgmlistmaxw+","+bgmlistmaxh+")' border='0' align='absmiddle' name=plist alt='목록보기' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\"></a>");
}
document.write("</div>");
//리스트 버튼 끝
//콘트롤 버튼 시작
document.write("<div style='position:absolute;left:267px; top:151px;'>");
   document.write("<img src="+dasomskin+"/images/Prev.gif onclick='javascript:DasomBGM_Prev()' border=0 style='cursor:hand;' align=absmiddle alt='이전곡으로' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">");
document.write("</div>");
   document.write("<div style='position:absolute;left:303px; top:151px;'>");
   document.write("<img src="+dasomskin+"/images/Next.gif onclick='javascript:DasomBGM_Next()' border=0 style='cursor:hand;' align='absmiddle' alt='다음곡으로' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">");
   document.write("</div>");
document.write("<div style='position:absolute;left:274px; top:115px;'>");
 document.write("<img src="+dasomskin+"/images/Stop_off.gif onclick='javascript:DasomBGM_Stop()' style='cursor:hand;' border=0 align=absmiddle name='stop' alt='' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">");
 document.write("</div>");
 document.write("<div style='position:absolute;left:297px; top:115px;'>");
 document.write("<img src="+dasomskin+"/images/Play_off.gif onclick='javascript:DasomBGM_Play()' border=0 style='cursor:hand;' name='play' align=absmiddle alt='' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">");
    document.write("</div>");
   document.write("<div style='position:absolute;left:286px; top:137px;'>");
   document.write("<img src="+dasomskin+"/images/Pause_off.gif onclick='javascript:DasomBGM_Pause()' border=0 style='cursor:hand;' align=absmiddle name=Pause alt='' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">");
document.write("</div>");

   document.write("<div style='position:absolute;left:127px; top:150px;'>");
   document.write("<img src="+dasomskin+"/images/Mute_off.gif onclick='javascript:DasomBGM_Mute()' border=0 style='cursor:hand;' name=mutemode align='absmiddle' alt='소리끄기' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">");
   document.write("</div>");

   document.write("<div style='position:absolute;left:122px; top:117px;'>");
   if(trackControll == 1) { //트랙 진행볼 시작
document.write("<img src="+dasomskin+"/images/Vol_back.gif name=volbar id=imgbar style='width:0px; height:0px;visibility:hidden;'>");
   document.write("<div ID='trackPosition' NAME='trackPosition' style='position:absolute; z-index:5; visibility:visible'>");
   document.write("<img src="+dasomskin+"/images/pnt_play.gif alt='트랙탐색' onmousedown=initTrackPosition() style='cursor:hand;' valign=absmiddle name=trackvol class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">");
   document.write("</div>");

  } else if (trackControll == 0){
document.write("<img src="+dasomskin+"/images/Vol_back.gif name=volbar id=imgbar style='width:0px; height:0px;visibility:hidden;'>");
   document.write("<div ID='trackPosition' NAME='trackPosition' style='width:0px; height:0px;visibility:hidden;'>");
   document.write("<img src="+dasomskin+"/images/pnt_play.gif name=trackvol id=trackvol style='width:0px; height:0px;visibility:hidden;'>");
   document.write("</div>"); //트랙 진행볼 끝
      }
document.write("</div>");
 document.write("<div style='position:absolute;left:90px; top:189px;'>");
if(BalanceControll == 1) { //볼륨벨런스 조절 시작
document.write("<img src="+dasomskin+"/images/Vol_back.gif name=volbar id=imgbar style='width:0px; height:0px;visibility:hidden;'>");
   document.write("<div ID='balcontrol' NAME='balcontrol' style='position:absolute; z-index:2; visibility: visible'>");
   document.write("<img src="+dasomskin+"/images/bal_ball.gif onMousedown='initbalance();' onMouseup='Balanceout();' valign=absmiddle style='cursor:hand;' name=bal alt='볼륨 벨런스조절' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">");
   document.write("</div>");
   } else if (BalanceControll == 0){
document.write("<img src="+dasomskin+"/images/Vol_back.gif name=volbar id=imgbar style='width:0px; height:0px;visibility:hidden;'>");
   document.write("<div ID='balcontrol' NAME='balcontrol' style='width:0px; height:0px;visibility:hidden;'>");
   document.write("<img src="+dasomskin+"/images/bal_ball.gif name=bal style='width:0px; height:0px;visibility:hidden;'>");
   document.write("</div>");
   }//볼륨벨런스 조절끝
document.write("</div>");

document.write("<div style='position:absolute;left:112px; top:188px;'>");
   if(VolumeControll == 1) { //볼륨조절 시작
document.write("<img src="+dasomskin+"/images/Vol_back.gif name=volbar id=imgbar style='width:0px; height:0px;visibility:hidden;'>");
   document.write("<div ID='volcontrol' NAME='volcontrol' style='position:absolute; z-index:2; visibility: visible'>");
   document.write("<img src="+dasomskin+"/images/vol_ball.gif onMousedown='initializedragie()' onMouseup='Balanceout();' valign=absmiddle style='cursor:hand;' name=vol alt='볼륨조절' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">");
   document.write("</div>");
   } else if (VolumeControll == 0){
   document.write("<img src="+dasomskin+"/images/Vol_back.gif name=volbar id=imgbar style='width:0px; height:0px;visibility:hidden;'>");
   document.write("<div ID='volcontrol' NAME='volcontrol' style='width:0px; height:0px;visibility:hidden;'>");
   document.write("<img src="+dasomskin+"/images/vol_ball.gif name=vol style='width:0px; height:0px;visibility:hidden;'>");
   document.write("</div>");
   }//볼륨조절 끝
 document.write("</div>");
   if(wordsplay == 0) { // 실시간 가사설정시작.
   document.write("<div id='displaygasa' name='displaygasa' style='position:absolute;left:0px; top:-1000px;z-index:4;visibility:hidden'></div>");
   }else if (wordsplay == 1){
   document.write("<div ID='displaygasa' NAME='displaygasa'  align=center STYLE='Position: absolute; Left:"+displayleft+"; Top:"+displaytop+"; width:270px; height:35px;'></div>");
   } // 실시간 가사설정끝
document.write("<div style='position:absolute;left:31px; top:240px;'>");
   document.write("<iframe src="+dasomskin+"/PlayerList.html STYLE='border-right: 0px; width:311px; height:223px;' scrolling=no name=Player frameborder=0 border=0></iframe>");
document.write("</div>");

}