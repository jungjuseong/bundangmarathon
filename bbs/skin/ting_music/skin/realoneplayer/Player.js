/*������������������������������������������������������������������������
Dasom Player
Copyright (c)2001~2002 by dasomlove.net all right reserved
HomePages : http://www.dasomlove.net/
�� ��ũ��Ʈ�� Dasom Player ���̼����� �����ϴ�.
���� ���۱� ��úκ��� �Ѽ��ϸ� �ȉϴϴ�.
������������������������������������������������������������������������
�ڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡ�
�ڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡ�
 �Ʒ��� �÷��̾��� ����� �����ϴ� �κ��Դϴ�.
 document.write("�̾ȿ� �±׸� �����ϼ���");
 alt�±׿� ���� ��Ÿ���� ������ bgm ���� ������ ������Դϴ�.
 ���� ����ϰ� �ִ� �̹��� �̸��� alt�� ������ �����ϰ� ����Ͻñ� �ٶ��ϴ�.
������, ū����ǥ(")�� ����� �ȵŴ� ��������ǥ(')�� ����ϼ���.
�ڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡ�
�ڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡ�*/

function Player() { // �÷��̾��� ����� �����ϴ� �κ�
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
document.write("<img src="+dasomskin+"/images/Loop_off.gif onclick='javascript:DasomBGM_Loop()' border=0 style='cursor:hand;' name=loop align='absmiddle' alt='����� �ݺ�' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">");
document.write("</div>");
//document.write("<div style='position:absolute;left:436px; top:10px;'>");
//document.write("<img src="+dasomskin+"/images/cl.gif style='cursor:hand;' onclick='javascript:window.close();' border=0 name=close align=middle alt='��� â�ݱ�'>");
//document.write("</div>");
//document.write("<div style='position:absolute;left:436px; top:10px;'>");
//document.write("<<?if($sitelink2) {?><?echo"<img src=$sitelink2 border=0  width=60 height=40>";?><?} else {?><?echo"<img src=$dir/bbox.gif border=0  width=60 height=40>";?><?}?>>");
//document.write("</div>");


document.write("<div style='position:absolute;left:120px; top:105px;'>");
if(playTitle == 0) {// �뷡 ������ ��Ÿ�� �κ�
   document.write("<span id=stitle name='stitle' style='width:0px; height:0px;visibility:hidden;'></span>");
}else if (playTitle == 1){
   document.write("<span id=stitle name='stitle' class ='buttom1' style='width:200px;'></span>");
}else if(playTitle == 2){ // ������ ��ũ�� ��Ų�ٸ�.
   document.write("<marquee class ='buttom1' style='width:135px;' truespeed scrollamount=3><span id=stitle name='stitle'></span></marquee>");
}// ���� ��Ÿ���� �κ� ���� ��.
document.write("</div>");
document.write("<div style='position:absolute;left:250px; top:22px;'>");
   if(status == 0) { // �÷��̾� ����ǥ�� ����
   document.write("<span id='playerstatus' name='playerstatus' style='font-size:9pt;width:0;visibility:hidden;'></span>");
   }else if (status == 1){
   document.write("<span id='playerstatus' name='playerstatus' class=buttom3></span>");
   }// �÷��̾� ����ǥ�� ��
document.write("</div>");
document.write("<div style='position:absolute;left:230px; top:73px;'>");
   if(playruntime == 0) { // ����ð�ǥ�ý���
   document.write("<span id='playtime' name='playtime' style='font-size:9pt;width:0;visibility:hidden;'></span>");
   }else if (playruntime == 1){
   document.write("<span id='playtime'  class=buttom>00:00/00:00</span>");
   }// ����ð�ǥ�� ��
document.write("</div>");

document.write("<div style='position:absolute;left:4px; top:176px;'>");
document.write("<span id=words name=words></span>");
document.write("</div>");


document.write("<div style='position:absolute;left:339px; top:176px;'>");
if(PlayList == 0){ //����Ʈ ��ư���� ����
   document.write("<img src="+dasomskin+"/images/List_on.gif style='cursor:hand;' align='absmiddle' name=plist style='width:0px; height:0px;visibility:hidden;'>");
}else if(PlayList == 1){
   document.write("<img src="+dasomskin+"/images/List_on.gif style='cursor:hand;' onclick='javascript:DasomBGM_PList(); return false;' border='0' align='absmiddle' name=plist alt='���Ǹ��' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">");
}else if(PlayList == 2){ // â ũ�⸦ ������ �ؾ��ϴ� ��ư�̶��..
   document.write("<a href="+dasomskin+"/PlayerList.html target=Player onfocus=this.blur()><img src="+dasomskin+"/images/List_off.gif onclick='javascript:setWindowSize("+bgmlistmaxw+","+bgmlistmaxh+")' border='0' align='absmiddle' name=plist alt='��Ϻ���' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\"></a>");
}
document.write("</div>");
//����Ʈ ��ư ��
//��Ʈ�� ��ư ����
document.write("<div style='position:absolute;left:267px; top:151px;'>");
   document.write("<img src="+dasomskin+"/images/Prev.gif onclick='javascript:DasomBGM_Prev()' border=0 style='cursor:hand;' align=absmiddle alt='����������' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">");
document.write("</div>");
   document.write("<div style='position:absolute;left:303px; top:151px;'>");
   document.write("<img src="+dasomskin+"/images/Next.gif onclick='javascript:DasomBGM_Next()' border=0 style='cursor:hand;' align='absmiddle' alt='����������' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">");
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
   document.write("<img src="+dasomskin+"/images/Mute_off.gif onclick='javascript:DasomBGM_Mute()' border=0 style='cursor:hand;' name=mutemode align='absmiddle' alt='�Ҹ�����' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">");
   document.write("</div>");

   document.write("<div style='position:absolute;left:122px; top:117px;'>");
   if(trackControll == 1) { //Ʈ�� ���ຼ ����
document.write("<img src="+dasomskin+"/images/Vol_back.gif name=volbar id=imgbar style='width:0px; height:0px;visibility:hidden;'>");
   document.write("<div ID='trackPosition' NAME='trackPosition' style='position:absolute; z-index:5; visibility:visible'>");
   document.write("<img src="+dasomskin+"/images/pnt_play.gif alt='Ʈ��Ž��' onmousedown=initTrackPosition() style='cursor:hand;' valign=absmiddle name=trackvol class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">");
   document.write("</div>");

  } else if (trackControll == 0){
document.write("<img src="+dasomskin+"/images/Vol_back.gif name=volbar id=imgbar style='width:0px; height:0px;visibility:hidden;'>");
   document.write("<div ID='trackPosition' NAME='trackPosition' style='width:0px; height:0px;visibility:hidden;'>");
   document.write("<img src="+dasomskin+"/images/pnt_play.gif name=trackvol id=trackvol style='width:0px; height:0px;visibility:hidden;'>");
   document.write("</div>"); //Ʈ�� ���ຼ ��
      }
document.write("</div>");
 document.write("<div style='position:absolute;left:90px; top:189px;'>");
if(BalanceControll == 1) { //���������� ���� ����
document.write("<img src="+dasomskin+"/images/Vol_back.gif name=volbar id=imgbar style='width:0px; height:0px;visibility:hidden;'>");
   document.write("<div ID='balcontrol' NAME='balcontrol' style='position:absolute; z-index:2; visibility: visible'>");
   document.write("<img src="+dasomskin+"/images/bal_ball.gif onMousedown='initbalance();' onMouseup='Balanceout();' valign=absmiddle style='cursor:hand;' name=bal alt='���� ����������' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">");
   document.write("</div>");
   } else if (BalanceControll == 0){
document.write("<img src="+dasomskin+"/images/Vol_back.gif name=volbar id=imgbar style='width:0px; height:0px;visibility:hidden;'>");
   document.write("<div ID='balcontrol' NAME='balcontrol' style='width:0px; height:0px;visibility:hidden;'>");
   document.write("<img src="+dasomskin+"/images/bal_ball.gif name=bal style='width:0px; height:0px;visibility:hidden;'>");
   document.write("</div>");
   }//���������� ������
document.write("</div>");

document.write("<div style='position:absolute;left:112px; top:188px;'>");
   if(VolumeControll == 1) { //�������� ����
document.write("<img src="+dasomskin+"/images/Vol_back.gif name=volbar id=imgbar style='width:0px; height:0px;visibility:hidden;'>");
   document.write("<div ID='volcontrol' NAME='volcontrol' style='position:absolute; z-index:2; visibility: visible'>");
   document.write("<img src="+dasomskin+"/images/vol_ball.gif onMousedown='initializedragie()' onMouseup='Balanceout();' valign=absmiddle style='cursor:hand;' name=vol alt='��������' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">");
   document.write("</div>");
   } else if (VolumeControll == 0){
   document.write("<img src="+dasomskin+"/images/Vol_back.gif name=volbar id=imgbar style='width:0px; height:0px;visibility:hidden;'>");
   document.write("<div ID='volcontrol' NAME='volcontrol' style='width:0px; height:0px;visibility:hidden;'>");
   document.write("<img src="+dasomskin+"/images/vol_ball.gif name=vol style='width:0px; height:0px;visibility:hidden;'>");
   document.write("</div>");
   }//�������� ��
 document.write("</div>");
   if(wordsplay == 0) { // �ǽð� ���缳������.
   document.write("<div id='displaygasa' name='displaygasa' style='position:absolute;left:0px; top:-1000px;z-index:4;visibility:hidden'></div>");
   }else if (wordsplay == 1){
   document.write("<div ID='displaygasa' NAME='displaygasa'  align=center STYLE='Position: absolute; Left:"+displayleft+"; Top:"+displaytop+"; width:270px; height:35px;'></div>");
   } // �ǽð� ���缳����
document.write("<div style='position:absolute;left:31px; top:240px;'>");
   document.write("<iframe src="+dasomskin+"/PlayerList.html STYLE='border-right: 0px; width:311px; height:223px;' scrolling=no name=Player frameborder=0 border=0></iframe>");
document.write("</div>");

}