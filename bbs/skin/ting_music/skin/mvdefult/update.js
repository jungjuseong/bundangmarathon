/*♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡
Dasom Player
Copyright (c)2001~2002 by dasomlove.net all right reserved
HomePages : http://www.dasomlove.net/
이 스크립트는 Dasom Player 라이센스에 따릅니다.
사용시 저작권 명시부분을 훼손하면 안됍니다.
♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡♡
★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
★ 아래는 음악의 제목를 업데이트 하는 부분입니다.
★ (수정가능)이란 메시지가 있는 부분만 수정하세요!
★ 큰 따옴표안의 글자만 수정하도록 권합니다.
★ 만약 곡명 표시부분을 잘라서 표시할 경우 dasomsub[track]을 subj[track]으로 바꾸세요^^
★ subj[track]으로 사용시에는 재생목록과 같은 바이트로 잘라내어 집니다.
★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★*/

function updateTitle(f) { //노래 제목 업데이트
	if (f == 1) {
	track_idx = track + 1;
	if((playTitle == 1) || (playTitle == 2)){
	stitle.innerHTML ="" + dasomsub[track]; //재생중인 곡명 메시지(수정가능)
	words.innerHTML = "<a href="+dasomskin+"/Dasom_Words.php?id="+dasom_Id+"&no=" + dasomwor[track]+ " target=Player onfocus=this.blur()><img src=" +dasomskin+"/images/Words.gif border=0 align=absmiddle name=plist alt=가사보기 onclick='javascript:setWindowSize("+bgmlistmaxw+","+bgmlistmaxh+")' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">"; //노래 재생의 곡 가사는..
	}else if(playTitle == 0){
	document.all.stitle.style.visibility = "hidden";
	words.innerHTML = "<a href="+dasomskin+"/Dasom_Words.php?id="+dasom_Id+"&no=" + dasomwor[track]+ " target=Player onfocus=this.blur()><img src=" +dasomskin+"/images/Words.gif border=0 align=absmiddle name=plist alt=가사보기 onclick='javascript:setWindowSize("+bgmlistmaxw+","+bgmlistmaxh+")' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">"; //노래 재생의 곡 가사는..
	document.all.stitle.style.width = 0;
	document.all.stitle.style.height = 0;
	}
	}
	else { //노래를 재생하고 있지 않다면...
	if((playTitle == 1) || (playTitle == 2)){
	if (stopTitle == 0) {
	stitle.innerHTML = " Dasom Player End. ";// 수정하지 말것
	words.innerHTML = "<a href="+dasomskin+"/Dasom_Words.php?id="+dasom_Id+"&no=" + dasomwor[track]+ " target=Player onfocus=this.blur()><img src=" +dasomskin+"/images/Words.gif border=0 align=absmiddle name=plist alt=가사보기 onclick='javascript:setWindowSize("+bgmlistmaxw+","+bgmlistmaxh+")' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">"; //노래 재생의 곡 가사는..
	return true;
	}
	else if (stopTitle == 1){
	stitle.innerHTML = "  Dasom Player Stopped";// 수정하지 말것
	return true;
	}
	else if (stopTitle == 2){
	stitle.innerHTML = " 처음곡 ▷ " + dasomsub[track];// 처음곡에서 이전곡 버튼 클릭시 메시지(수정가능)
	words.innerHTML = "<a href="+dasomskin+"/Dasom_Words.php?id="+dasom_Id+"&no=" + dasomwor[track]+ " target=Player onfocus=this.blur()><img src=" +dasomskin+"/images/Words.gif border=0 align=absmiddle name=plist alt=가사보기 onclick='javascript:setWindowSize("+bgmlistmaxw+","+bgmlistmaxh+")' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">"; //노래 재생의 곡 가사는..
	return true;
	}
	}else if(playTitle == 0){
	document.all.stitle.style.visibility = "hidden";
	document.all.stitle.style.width = 0;
	document.all.stitle.style.height = 0;
	words.innerHTML = "<a href="+dasomskin+"/Dasom_Words.php?id="+dasom_Id+"&no=" + dasomwor[track]+ " target=Player onfocus=this.blur()><img src=" +dasomskin+"/images/Words.gif border=0 align=absmiddle name=plist alt=가사보기 onclick='javascript:setWindowSize("+bgmlistmaxw+","+bgmlistmaxh+")' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">"; //노래 재생의 곡 가사는..
	}
	}
}

//function ErrorTitle() {
//       var TrackError = track + 1
 //      stitle.innerHTML = "" + dasomsub[track]; // 재생중에 에러발생시 에러메시지 출력 (수정가능)
//       words.innerHTML = "<a href="+dasomskin+"/Dasom_Words.php?id="+dasom_Id+"&no=" + dasomwor[track]+ " target=Player onfocus=this.blur()><img src=" +dasomskin+"/images/Words.gif border=0 align=absmiddle name=plist alt=가사보기 onclick='javascript:setWindowSize("+bgmlistmaxw+","+bgmlistmaxh+")' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">"; //노래 재생의 곡 가사는..
//}