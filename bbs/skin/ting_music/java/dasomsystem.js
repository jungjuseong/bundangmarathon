/*♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡
Dasom Player
Copyright (c)2001~2002 by dasomlove.net all right reserved
HomePages : http://www.dasomlove.net/
이 스크립트는 Dasom Player 라이센스에 따릅니다.
사용시 저작권 명시부분을 훼손하면 안됍니다.
♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡
★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
★★이 파일은 절대 수정하지 마세요! 이 파일에 대해서는 어떤한 질문도 받지 않습니다.★★
★★이 파일은 절대 수정하지 마세요! 이 파일에 대해서는 어떤한 질문도 받지 않습니다.★★
★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★*/
var songPlaying;
var songPlaying2=0;
var songtime;
var chktime;
var stopmode = 0;
var person = null;
var subj = null;
var dasomsub = null;
var dasomwor=null;
var smi = null;
var Spec = 1;
var track = 0;
var count = 0;
var stopTitle=1;
var Looping = false;
var dragapproved=false;
browserName = navigator.appName;
browserVer = parseInt(navigator.appVersion);
if(browserName == "Netscape" && browserVer >= 3){ init = "net"; }
else { init = "ie"; }
if(((init == "net")&&(browserVer >=3))||((init == "ie")&&(browserVer >= 4))){
	mutemode_on=new Image;
	mutemode_off=new Image;
	mutemode_on.src= dasomskin+"/images/Mute_on.gif";
	mutemode_off.src= dasomskin+"/images/Mute_off.gif";
	loop_on=new Image;
	loop_off=new Image;
	loop_on.src= dasomskin+"/images/Loop_on.gif";
	loop_off.src= dasomskin+"/images/Loop_off.gif";
	Pause_on=new Image;
	Pause_off=new Image;
	Pause_on.src= dasomskin+"/images/Pause_on.gif";
	Pause_off.src= dasomskin+"/images/Pause_off.gif";
	randommode_on=new Image;
	randommode_off=new Image;
	randommode_on.src= dasomskin+"/images/random_on.gif";
	randommode_off.src= dasomskin+"/images/random_off.gif";
	allloop_on=new Image;
	allloop_off=new Image;
	allloop_on.src= dasomskin+"/images/allloop_on.gif";
	allloop_off.src= dasomskin+"/images/allloop_off.gif";
	stop_on=new Image;
	stop_off=new Image;
	stop_on.src= dasomskin+"/images/Stop_on.gif";
	stop_off.src= dasomskin+"/images/Stop_off.gif";
	play_on=new Image;
	play_off=new Image;
	play_on.src= dasomskin+"/images/Play_on.gif";
	play_off.src= dasomskin+"/images/Play_off.gif";
	spectrum_on=new Image;
	spectrum_off=new Image;
	spectrum_on.src= dasomskin+"/images/spectrum_on.gif";
	spectrum_off.src= dasomskin+"/images/spectrum_off.gif";
	spec_on=new Image;
	spec_off=new Image;
	spec_on.src= dasomskin+"/images/spec_on.gif";
	spec_off.src= dasomskin+"/images/spec_off.gif";
	plist_on=new Image;
	plist_off=new Image;
	plist_on.src= dasomskin+"/images/List_on.gif";
	plist_off.src= dasomskin+"/images/List_off.gif";

}

function setting() {
	document.all.item('volcontrol').style.left =volposition;
	document.all.item('volcontrol').style.top = voltopposition;
	document.all.item('balcontrol').style.left =balcenposition+ballength;
	document.all.item('balcontrol').style.top = baltopposition;
	document.dasomlove.Controls.Stop(); //미디어 정지상태로 설정
	document.all.item('trackPosition').style.left = trackbarposition;
	document.all.item('trackPosition').style.top = trackbartopposition;
	if (autoplay == 1) {
	if (playmode == 1) {
	track = Math.floor(Math.random() * person.length);
	ImgSrc=eval("randommode_on.src");
	document.randommode.src=ImgSrc;
	document.randommode.alt="순차재생하기";
	ImgSrc=eval("Pause_off.src");
	document.Pause.src=ImgSrc;
	document.Pause.alt="일시중지";
	ImgSrc=eval("play_on.src");
	document.play.src=ImgSrc;
	document.play.alt="♪♬";
	ImgSrc=eval("stop_off.src");
	document.stop.src=ImgSrc;
	document.stop.alt="중 지";
	ImgSrc=eval("spectrum_on.src");
	document.spectrum.src=ImgSrc;
	ImgSrc=eval("spec_on.src");
	document.spec.src=ImgSrc;
	}
	else {
	ImgSrc=eval("randommode_off.src");
	document.randommode.src=ImgSrc;
	document.randommode.alt="랜덤재생하기";
	track = 0;}
	stopmode = 0;
	change(track);
	 }
	else { DasomBGM_Stop(); }
	switch(MuteMode) {
	case 0 :
	document.DasomBGM.mutemode.style.visibility = "hidden";
	document.DasomBGM.mutemode.style. width = 0;
	document.DasomBGM.mutemode.style. height = 0;
	break;
	case 1 :
	break;
	}
	switch(RanDom) {
	case 0 :
	document.DasomBGM.randommode.style.visibility = "hidden";
	document.DasomBGM.randommode.style. width = 0;
	document.DasomBGM.randommode.style. height = 0;
	break;
	case 1 :
	break;
	}
	switch(AllLoopMode) {
	case 0 :
	document.DasomBGM.allloop.style.visibility = "hidden";
	document.DasomBGM.allloop.style. width = 0;
	document.DasomBGM.allloop.style. height = 0;
	break;
	case 1 :
	break;
	}
	switch(LoopMode) {
	case 0 :
	document.DasomBGM.loop.style.visibility = "hidden";
	document.DasomBGM.loop.style.width = 0;
	document.DasomBGM.loop.style.height = 0;
	break;
	case 1 :
	break;
	}
	switch(Spectrum) {
	case 0 :
	document.DasomBGM.spectrum.style.visibility = "hidden";
	document.DasomBGM.spectrum.style.width = 0;
	document.DasomBGM.spectrum.style.height = 0;
	break;
	case 1 :
	break;
	}
	switch(Spec) {
	case 0 :
	document.DasomBGM.spec.style.visibility = "hidden";
	document.DasomBGM.spec.style.width = 0;
	document.DasomBGM.spec.style.height = 0;
	break;
	case 1 :
	break;
	}
	switch(PlayList) {
	case 0 :
	document.DasomBGM.plist.style.visibility = "hidden";
	document.DasomBGM.plist.style.width = 0;
	document.DasomBGM.plist.style.height = 0;
	break;
	case 1 :
	break;
	case 2 :
	break;
	}
}

/*
if(PlayList==2){
parent.resizeTo(bgmlistminw,bgmlistminh);
}
*/
if(PlayList==2){ parent.resizeTo(375,275); }

function Balanceout() {
	songPlaying = document.dasomlove.PlayState;
	if (songPlaying == 0){updateTitle();return true;}
	else{updateTitle(1);return true;}
	}

var isOpenWindow=false;
function setWindowSize2() {
        if (!isOpenWindow) {
                parent.resizeTo(bgmlistmaxw,bgmlistmaxh);
                isOpenWindow=true;
	ImgSrc=eval("plist_on.src");
	document.plist.src=ImgSrc;
	document.plist.alt="목록 숨기기";
        } else {
                parent.resizeTo(bgmlistminw,bgmlistminh);
                isOpenWindow=false;
	ImgSrc=eval("plist_off.src");
	document.plist.src=ImgSrc;
	document.plist.alt="목록보기";
        }
}

function setWindowSize(wi,he) {
var intwidth;
var intheight;
intwidth=wi;
intheight=he;
intwidth=parseInt(intwidth);
intheight=parseInt(intheight);
if(intwidth>0&&intheight>0) {parent.resizeTo(intwidth,intheight);}
else{return;}
}

function Fullscreen()
{
	document.dasomlove.fullscreen=true;
}

function initbalance() {
	iex=event.clientX;
	iey=event.clientY;
	tempx=balcontrol.style.pixelLeft;
	tempy=balcontrol.style.pixelTop;
	dragapproved=true;
	document.onmousemove=baldrag_dropie;
	if (document.all)	{
		document.onmouseup=new Function('dragapproved=false');
	}
}

function baldrag_dropie() {
	bal_length=ballength;
	bal_startpoint=balcenposition;
	if (dragapproved==true) {
		var mov = tempx+event.clientX-iex-bal_length;
		if (mov <= bal_startpoint+bal_length  && mov > bal_startpoint-bal_length)
		{
			document.all.balcontrol.style.pixelLeft=tempx+event.clientX-iex;
			per=((mov-bal_startpoint)/bal_length);
			balance=per*100;
			document.dasomlove.settings.balance = balance;  //new balance
			if((playTitle == 1) || (playTitle == 2)){
			balance=parseInt(balance,10);
			if(balance<0){balance=-balance;
			stitle.innerHTML = " Balance : "+balance+"% Left";
			return true;}
			else if(balance>0){
			stitle.innerHTML = " Balance : "+balance+"% Right";}
			else {stitle.innerHTML = " Balance : Center";}
			}
		}
		return false;
	}
}

function initializedragie() {
	iex=event.clientX;
	iey=event.clientY;
	tempx=volcontrol.style.pixelLeft;
	tempy=volcontrol.style.pixelTop;
	dragapproved=true;
	document.onmousemove=drag_dropie;
	if (document.all)	{
		document.onmouseup=new Function('dragapproved=false');
	}
}
function drag_dropie() {
	vol_length=vollength;
	vol_startpoint=volminposition;
	if (dragapproved==true) {
		var mov = tempx+event.clientX-iex-vol_length;
		if (mov <= vol_startpoint  && mov > vol_startpoint-vol_length)	{
			document.all.volcontrol.style.pixelLeft=tempx+event.clientX-iex;
			per=((mov-vol_startpoint)/vol_length);
			status=per*100 + 100;
			volume=per*100 + 100;
			document.dasomlove.settings.volume = volume;  //new volume
			document.dasomlove.settings.mute = false;
			ImgSrc=eval("mutemode_off.src");
			document.mutemode.src=ImgSrc;
			document.mutemode.alt="소리끄기";
		}
		return false;
	}
}

function DasomBGM_Duration() {
	setTrackIcon();
	if (document.dasomlove.currentMedia.getItemInfo(dasomsub[track]).length>55)
	displaygasa.innerHTML = "";
	document.dasomlove.closedCaption.captioningId = "displaygasa"
	songPlaying = document.dasomlove.PlayState;
	if(songPlaying==10){checkloop();}
	if((songPlaying2==1)&&(songPlaying==1)){checkloop();}
	}


function playerSetPosition() {
	if (positionSet==true) {
		positionSet=false;
		dragapproved=false;
		per=(trackPosition.style.pixelLeft-var_startpoint)/var_length;

		position=document.dasomlove.currentMedia.duration*per;
		setPosition(position);
	}
}

var positionSet=false;
function initTrackPosition() {
	positionSet=true;
	iex=event.clientX;
	iey=event.clientY;
	tempx=trackPosition.style.pixelLeft;
	tempy=trackPosition.style.pixelTop;
	dragapproved=true;
	document.onmousemove=positionDragControl;

	if (document.all)	{
		document.onmouseup=playerSetPosition;
	}
}

var var_length=trackbarlength; 
var var_startpoint=trackbarposition;
function positionDragControl() {
	if (dragapproved==true) {
		var mov = tempx+event.clientX-iex;
		//status="mov="+mov+", iex="+iex+", tempx="+tempx+", event.clientX="+event.clientX;
		
		if (mov >= var_startpoint  && mov <= var_startpoint+var_length) {
			document.all.trackPosition.style.pixelLeft=tempx+event.clientX-iex;
//			clipMuch=trackPosition.style.pixelLeft-var_startpoint;
//			trackPositionBg.style.clip="rect(0," + clipMuch + ",6,0)";
		}
		return false;
	}
}

function setPosition(position) {
	document.dasomlove.controls.currentPosition=position;
}

function setTrackIcon() {
	if (positionSet!=true) {
		if (var_startpoint+(var_length*(document.dasomlove.controls.currentPosition/document.dasomlove.currentMedia.duration))) {
			document.all.trackPosition.style.pixelLeft=var_startpoint+(var_length*(document.dasomlove.controls.currentPosition/document.dasomlove.currentMedia.duration));
//			clipMuch=trackPosition.style.pixelLeft-var_startpoint;
//			trackPositionBg.style.clip="rect(0," + clipMuch + ",6,0)";
	 Dasomtotal=document.dasomlove.currentMedia.durationString ;
	 var chktime = document.dasomlove.controls.currentPositionString ;
	fulltime = chktime+ "/"+ Dasomtotal;
	playtime.innerHTML =  fulltime;
	if (document.dasomlove.currentPlaylist.getItemInfo(track).length>55)
	displaygasa.innerHTML = "";
        document.dasomlove.closedCaption.captioningId = "displaygasa"

		}
	}
}


function DasomBGM_Play() {
	songPlaying = document.dasomlove.PlayState;
	if(songPlaying == 2) {
	document.dasomlove.Controls.Play();
	updateTrack(1);
	updateTitle(1);
	ImgSrc=eval("Pause_off.src");
	document.Pause.src=ImgSrc;
	document.Pause.alt="일시중지";
	ImgSrc=eval("play_on.src");
	document.play.src=ImgSrc;
	document.play.alt="재 생";
	ImgSrc=eval("stop_off.src");
	document.stop.src=ImgSrc;
	document.stop.alt="중 지";
	ImgSrc=eval("spectrum_on.src");
	document.spectrum.src=ImgSrc;
	ImgSrc=eval("spec_on.src");
	document.spec.src=ImgSrc;
	}
	else if(songPlaying == 3)
	{
	alert("이미 재생중입니다!!!");
	return true;
	}
	else{
	if (playmode == 1) {
	track = Math.floor(Math.random() * person.length);
	ImgSrc=eval("randommode_on.src");
	document.randommode.src=ImgSrc;
	document.randommode.alt="순차재생하기";
	ImgSrc=eval("Pause_off.src");
	document.Pause.src=ImgSrc;
	document.Pause.alt="일시중지";
	ImgSrc=eval("play_on.src");
	document.play.src=ImgSrc;
	document.play.alt="재생";
	ImgSrc=eval("stop_off.src");
	document.stop.src=ImgSrc;
	document.stop.alt="중 지";
	ImgSrc=eval("spectrum_on.src");
	document.spectrum.src=ImgSrc;
	ImgSrc=eval("spec_on.src");
	document.spec.src=ImgSrc;
	}
	else {
	ImgSrc=eval("randommode_off.src");
	document.randommode.src=ImgSrc;
	document.randommode.alt="랜덤재생하기";
	track = 0;}
	stopmode = 0;
	change(track);
	}
}

function change(aaa) {
	clearTimeout(songtime);
	songPlaying2=0;
	document.dasomlove.Controls.Stop();
	track = aaa;
	if(track < 0 || track > (person.length - 1) ) {
	DasomBGM_Stop();
	}
	else {
	stopmode = 0;
	var nowtrack1;
	if(smi[track]){nowtrack1 = person[track]+"?sami="+smi[track];}
	else {nowtrack1 = person[track];}
	document.dasomlove.URL=nowtrack1;
	setInterval('DasomBGM_Duration()',500);
	document.dasomlove.Controls.Play();
	songPlaying2=1;
	updateTrack(1);
	updateTitle(1);
	ImgSrc=eval("play_on.src");
	document.play.src=ImgSrc;
	document.play.alt="재생";
	ImgSrc=eval("stop_off.src");
	document.stop.src=ImgSrc;
	document.stop.alt="중 지";
	ImgSrc=eval("spectrum_on.src");
	document.spectrum.src=ImgSrc;
	ImgSrc=eval("spec_on.src");
	document.spec.src=ImgSrc;
	if (allLoop == 1){
	ImgSrc=eval("allloop_on.src");
	document.allloop.src=ImgSrc;
	document.allloop.alt="한번씩 재생";
	}else{
	ImgSrc=eval("allloop_off.src");
	document.allloop.src=ImgSrc;
	document.allloop.alt="전체반복";
	}}
}
function DasomBGM_Timeout(){
	songtime = setTimeout('t_time()', 5000);
 }

function t_time(){
	songPlaying = document.dasomlove.PlayState;
	clearTimeout(songtime);
	if(stopmode == 0) {
	if (songPlaying == 2 || songPlaying == 1) {
	return true;
	}
	else {
	checkloop();
	updateTrack(1);
	updateTitle(1);
	}
	}
	else {updateTrack();
	      updateTitle();}
}
function checkloop() {
	if ( Looping == true ) { change(track);}
	else { DasomBGM_Next();}

}

function  DasomBGM_Allloop() {
	if (allLoop == false) {
	allLoop = true;
	ImgSrc=eval("allloop_on.src");
	document.allloop.src=ImgSrc;
	document.allloop.alt="한번씩 재생";
	}
	else if(allLoop = true){
	allLoop =  false;
	ImgSrc=eval("allloop_off.src");
	document.allloop.src=ImgSrc;
	document.allloop.alt="전체 반복";
	}
}

function  DasomBGM_RandomPlay() {
	if (playmode == false) {
	playmode = true;
	ImgSrc=eval("randommode_on.src");
	document.randommode.src=ImgSrc;
	document.randommode.alt="순차재생하기";
	}
	else if (playmode == true) {
	playmode = false;
	ImgSrc=eval("randommode_off.src");
	document.randommode.src=ImgSrc;
	document.randommode.alt="랜덤재생하기";
	}
}

function DasomBGM_Next() {
	if (playmode == 1) {
	var nextnum = Math.floor(Math.random() * person.length);
	ImgSrc=eval("Pause_off.src");
	document.Pause.src=ImgSrc;
	document.Pause.alt="일시중지";
	change(nextnum);
	ImgSrc=eval("randommode_on.src");
	document.randommode.src=ImgSrc;
	document.randommode.alt="순차재생하기";
	}
	else {
	if (allLoop == 1){
	if(track == (person.length - 1)) { var nextnum = 0; }
	else { var nextnum = track + 1; }
	ImgSrc=eval("Pause_off.src");
	document.Pause.src=ImgSrc;
	document.Pause.alt="일시중지";
	change(nextnum);
	}
	else {
	if(track == (person.length - 1)) {
	stopTitle = 0;
	ImgSrc=eval("Pause_off.src");
	document.Pause.src=ImgSrc;
	document.Pause.alt="일시중지";
	document.dasomlove.Controls.Stop();
	songPlaying2=0;
	stopmode = 1;
	updateTrack();
	updateTitle();
	return true;}
	else { var nextnum = track + 1;
	change(nextnum);}
	}
	}
}

function DasomBGM_Prev() {
	if (playmode == 1) {
	var prevnum = Math.floor(Math.random() * person.length);
	ImgSrc=eval("Pause_off.src");
	document.Pause.src=ImgSrc;
	document.Pause.alt="일시정지";
	change(prevnum);
	ImgSrc=eval("randommode_on.src");
	document.randommode.src=ImgSrc;
	document.randommode.alt="순차재생하기";
	}
	else{
	if (allLoop == 1){
	if(track == 0) { var prevnum = person.length - 1; }
	else { var prevnum = track - 1;  }
	ImgSrc=eval("Pause_off.src");
	document.Pause.src=ImgSrc;
	document.Pause.alt="일시정지";
	change(prevnum);
	}
	else {
	if(track == 0) {
	stopTitle = 2;
	ImgSrc=eval("Pause_off.src");
	document.Pause.src=ImgSrc;
	document.Pause.alt="일시정지";
	document.dasomlove.Controls.Stop();
	songPlaying2=0;
	stopmode = 1;
	updateTrack();
	updateTitle();
	return true;}
	else { var prevnum = track - 1;
	change(prevnum);}
	}
       }
}

function DasomBGM_Pause(){
	songPlaying = document.dasomlove.PlayState;
	if ((songPlaying == 0)||(songPlaying == 1)) { return false;}
	else if (songPlaying == 2) {
	playerstatus.innerHTML = "재생";
	document.dasomlove.Controls.Play();
	ImgSrc=eval("Pause_off.src");
	document.Pause.src=ImgSrc;
	document.Pause.alt="일시중지";
	ImgSrc=eval("play_on.src");
	document.play.src=ImgSrc;
	document.play.alt="재생";
	ImgSrc=eval("spectrum_on.src");
	document.spectrum.src=ImgSrc;
	ImgSrc=eval("spec_on.src");
	document.spec.src=ImgSrc;
	}
	else if (songPlaying == 3) {document.dasomlove.Controls.Pause();
	playerstatus.innerHTML = "일시중지";
	ImgSrc=eval("Pause_on.src");
	document.Pause.src=ImgSrc;
	document.Pause.alt="재생";
	ImgSrc=eval("play_off.src");
	document.play.src=ImgSrc;
	document.play.alt="재생";
	ImgSrc=eval("spectrum_off.src");
	document.spectrum.src=ImgSrc;
	ImgSrc=eval("spec_off.src");
	document.spec.src=ImgSrc;
	}
	else {return true;}
}

function DasomBGM_Stop() {
	songPlaying = document.dasomlove.PlayState;
	playtime.innerHTML = "00:00/00:00" ;
	if (songPlaying == 1) {
	alert("이미 정지돼었습니다.!!!");
	return true;}
	else {
	document.dasomlove.Controls.Stop();
	songPlaying2=0;
	stopmode = 1;
	stopTitle = 1;
	updateTrack();
	updateTitle();
	return true;
	}
}

function DasomBGM_Loop() {
	if(Looping == false)
	{
	Looping = true;
	ImgSrc=eval("loop_on.src");
	document.loop.src=ImgSrc;
	document.loop.alt="한번재생";
  }
	else if(Looping = true) {
	Looping = false;
	ImgSrc=eval("loop_off.src");
	document.loop.src=ImgSrc;
	document.loop.alt="현재곡 반복";
  }
 }

function DasomBGM_Mute() {
	if(document.dasomlove.settings.mute == false)
	{
	document.dasomlove.settings.mute = true;
	ImgSrc=eval("mutemode_on.src");
	document.mutemode.src=ImgSrc;
	document.mutemode.alt="소리켜기";
  }
	else if(document.dasomlove.settings.mute == true) {
	document.dasomlove.settings.mute = false;
	ImgSrc=eval("mutemode_off.src");
	document.mutemode.src=ImgSrc;
	document.mutemode.alt="소리끄기";
  }
 }

function DasomBGM_List( url, title,smifile,war) {
	if (person == null) { person = new Array(); count = 0;}
	else { count = person.length; }
	if (subj == null) { subj = new Array(); }
	person[count] = url;
	if (title == null || title == '' ) { title1 = ' Track [' + (count + 1) + '] '; }
	else { title1 = title; }
	subj[count] = title1;
	if(Titlecut!=0){subj[count] = subj[count].substring(0,Titlecut);}
	if (dasomsub == null) { dasomsub = new Array(); }
	dasomsub[count] = title;
	if (smi == null) { smi = new Array(); }
	smi[count] = smifile;
	if (dasomwor == null) { dasomwor = new Array(); }
	dasomwor[count] = war;
}

function updateTrack(f) { //이미지 업데이트
	if (f == 1) {
	ImgSrc=eval("Pause_off.src");
	document.Pause.src=ImgSrc;
	document.Pause.alt="일시중지";
	}
	else { //노래를 재생하고 있지 않다면...
	if ((stopTitle == 0)||(stopTitle == 2)) {
	ImgSrc=eval("Pause_off.src");
	document.Pause.src=ImgSrc;
	document.Pause.alt="일시중지";
	ImgSrc=eval("stop_on.src");
	document.stop.src=ImgSrc;
	document.stop.alt="중지됨";
	ImgSrc=eval("play_off.src");
	document.play.src=ImgSrc;
	document.play.alt="재생";
	ImgSrc=eval("spectrum_off.src");
	document.spectrum.src=ImgSrc;
	ImgSrc=eval("spec_off.src");
	document.spec.src=ImgSrc;
	playerstatus.innerHTML = "종료됨";
	return true;
	}
	else if (stopTitle == 1){
	ImgSrc=eval("Pause_off.src");
	document.Pause.src=ImgSrc;
	document.Pause.alt="일시중지";
	ImgSrc=eval("stop_on.src");
	document.stop.src=ImgSrc;
	document.stop.alt="중지됨";
	ImgSrc=eval("play_off.src");
	document.play.src=ImgSrc;
	document.play.alt="재생";
	ImgSrc=eval("spectrum_off.src");
	document.spectrum.src=ImgSrc;
	ImgSrc=eval("spec_off.src");
	document.spec.src=ImgSrc;
	return true;
	}
	}
}

function DasomBGM_PList() {
	window.open("./"+dasomskin+"/PlayerList.html" , "MPList", " width="+bgmlistwidth+" height="+bgmlistheight+" toolbar=no location=no status=no directories=no scrollbars=no resizable=no copyhistory=no");
}
