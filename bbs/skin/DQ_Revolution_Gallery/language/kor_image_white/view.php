<?
// �۾����ư
	if(!eregi("<Zeroboard",$a_write)) $bt_write=$a_write."<img src=".$_lang_dir."bt_write.gif border=0></a>";

// ��� ��ư
	$bt_list = $a_list."<img src=".$_lang_dir."bt_list.gif border=0></a>&nbsp;&nbsp;";

// ��۴ޱ�
	if(!eregi("<Zeroboard",$a_reply)) $bt_reply = $a_reply."<img src=".$_lang_dir."bt_re.gif border=0></a>&nbsp;&nbsp;";

// �����ϱ�	
	if(!eregi("<Zeroboard",$a_modify)) $bt_modify = $a_modify."<img src=".$_lang_dir."bt_edit.gif border=0></a>&nbsp;&nbsp;";

// �����ϱ�
	if(!eregi("<Zeroboard",$a_delete)) $bt_delete = $a_delete."<img src=".$_lang_dir."bt_del.gif border=0></a>&nbsp;&nbsp;";

// ��õ�ϱ�	
	if(!eregi("<Zeroboard",$a_vote)) $bt_vote = $a_vote."<img src=".$_lang_dir."bt_vote.gif border=0></a>&nbsp;&nbsp;";

// ��������, ��������
	$bt_vprev = $a_prev."�� <font class=han2>��������</font></a>&nbsp;&nbsp;&nbsp;";
	$bt_iprev = "�� ������";
	$bt_vnext = $a_next."<font class=han2>��������</font> ��</a>&nbsp;&nbsp;";
	$bt_inext = "�� ������";

// �ٿ�ε� ��ư
    $bt_download = "<img src=".$_lang_dir."bt_download.gif border=0 align=absmiddle>";

//---- text ----------------------------------

	$_strSkin['exp_memo']		= '��ĭũ�� �ø���';
	$_strSkin['org_memo']		= '��ĭũ�� �������';
	$_strSkin['save_comment']	= $_lang_dir.'bt_comment_ok.gif';
	$_strSkin['save_commentEX']	= $_lang_dir.'bt_comment_EX.gif';
	$_strSkin['password']		= '<b class=han>��й�ȣ</b>';
	$_strSkin['name']			= '<b class=han>�̸�(����)</b>';
	$_strSkin['vote']			= '<font class=thumb_han>�� ������ ��õ</font>';
	$_strSkin['only_memo']		= '<font class=thumb_han>�۸� ����</font>';
	$_strSkin['vote_cancel']	= '<font class=thumb_han>��õ ���</font>';
?>