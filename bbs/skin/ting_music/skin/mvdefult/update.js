/*������������������������������������������������������������������������
Dasom Player
Copyright (c)2001~2002 by dasomlove.net all right reserved
HomePages : http://www.dasomlove.net/
�� ��ũ��Ʈ�� Dasom Player ���̼����� �����ϴ�.
���� ���۱� ��úκ��� �Ѽ��ϸ� �ȉϴϴ�.
������������������������������������������������������������������������
�ڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡ�
�ڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡ�
�� �Ʒ��� ������ ���� ������Ʈ �ϴ� �κ��Դϴ�.
�� (��������)�̶� �޽����� �ִ� �κи� �����ϼ���!
�� ū ����ǥ���� ���ڸ� �����ϵ��� ���մϴ�.
�� ���� ��� ǥ�úκ��� �߶� ǥ���� ��� dasomsub[track]�� subj[track]���� �ٲټ���^^
�� subj[track]���� ���ÿ��� �����ϰ� ���� ����Ʈ�� �߶󳻾� ���ϴ�.
�ڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡ�
�ڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡڡ�*/

function updateTitle(f) { //�뷡 ���� ������Ʈ
	if (f == 1) {
	track_idx = track + 1;
	if((playTitle == 1) || (playTitle == 2)){
	stitle.innerHTML ="" + dasomsub[track]; //������� ��� �޽���(��������)
	words.innerHTML = "<a href="+dasomskin+"/Dasom_Words.php?id="+dasom_Id+"&no=" + dasomwor[track]+ " target=Player onfocus=this.blur()><img src=" +dasomskin+"/images/Words.gif border=0 align=absmiddle name=plist alt=���纸�� onclick='javascript:setWindowSize("+bgmlistmaxw+","+bgmlistmaxh+")' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">"; //�뷡 ����� �� �����..
	}else if(playTitle == 0){
	document.all.stitle.style.visibility = "hidden";
	words.innerHTML = "<a href="+dasomskin+"/Dasom_Words.php?id="+dasom_Id+"&no=" + dasomwor[track]+ " target=Player onfocus=this.blur()><img src=" +dasomskin+"/images/Words.gif border=0 align=absmiddle name=plist alt=���纸�� onclick='javascript:setWindowSize("+bgmlistmaxw+","+bgmlistmaxh+")' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">"; //�뷡 ����� �� �����..
	document.all.stitle.style.width = 0;
	document.all.stitle.style.height = 0;
	}
	}
	else { //�뷡�� ����ϰ� ���� �ʴٸ�...
	if((playTitle == 1) || (playTitle == 2)){
	if (stopTitle == 0) {
	stitle.innerHTML = " Dasom Player End. ";// �������� ����
	words.innerHTML = "<a href="+dasomskin+"/Dasom_Words.php?id="+dasom_Id+"&no=" + dasomwor[track]+ " target=Player onfocus=this.blur()><img src=" +dasomskin+"/images/Words.gif border=0 align=absmiddle name=plist alt=���纸�� onclick='javascript:setWindowSize("+bgmlistmaxw+","+bgmlistmaxh+")' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">"; //�뷡 ����� �� �����..
	return true;
	}
	else if (stopTitle == 1){
	stitle.innerHTML = "  Dasom Player Stopped";// �������� ����
	return true;
	}
	else if (stopTitle == 2){
	stitle.innerHTML = " ó���� �� " + dasomsub[track];// ó����� ������ ��ư Ŭ���� �޽���(��������)
	words.innerHTML = "<a href="+dasomskin+"/Dasom_Words.php?id="+dasom_Id+"&no=" + dasomwor[track]+ " target=Player onfocus=this.blur()><img src=" +dasomskin+"/images/Words.gif border=0 align=absmiddle name=plist alt=���纸�� onclick='javascript:setWindowSize("+bgmlistmaxw+","+bgmlistmaxh+")' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">"; //�뷡 ����� �� �����..
	return true;
	}
	}else if(playTitle == 0){
	document.all.stitle.style.visibility = "hidden";
	document.all.stitle.style.width = 0;
	document.all.stitle.style.height = 0;
	words.innerHTML = "<a href="+dasomskin+"/Dasom_Words.php?id="+dasom_Id+"&no=" + dasomwor[track]+ " target=Player onfocus=this.blur()><img src=" +dasomskin+"/images/Words.gif border=0 align=absmiddle name=plist alt=���纸�� onclick='javascript:setWindowSize("+bgmlistmaxw+","+bgmlistmaxh+")' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">"; //�뷡 ����� �� �����..
	}
	}
}

//function ErrorTitle() {
//       var TrackError = track + 1
 //      stitle.innerHTML = "" + dasomsub[track]; // ����߿� �����߻��� �����޽��� ��� (��������)
//       words.innerHTML = "<a href="+dasomskin+"/Dasom_Words.php?id="+dasom_Id+"&no=" + dasomwor[track]+ " target=Player onfocus=this.blur()><img src=" +dasomskin+"/images/Words.gif border=0 align=absmiddle name=plist alt=���纸�� onclick='javascript:setWindowSize("+bgmlistmaxw+","+bgmlistmaxh+")' class=\"opacity1\" onmouseover=\"this.className='opacity2'\" onmouseout=\"this.className='opacity1'\">"; //�뷡 ����� �� �����..
//}