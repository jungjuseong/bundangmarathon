<?
// �۾����ư
	if(!eregi("<Zeroboard",$a_write)) $bt_write=$a_write."<font class=han2 style='font-weight:bold'>".$skin_setup['write_buttonName']."</font></a>";

// ��� ��ư
	$bt_list = $a_list."<font class=han style=font-weight:bold>-��Ϻ���</font></a>&nbsp;&nbsp;";

// ��۴ޱ�
	if(!eregi("<Zeroboard",$a_reply)) $bt_reply = $a_reply."<font class=han style=font-weight:bold>-��۴ޱ�</font></a>&nbsp;&nbsp;";

// �����ϱ�	
	if(!eregi("<Zeroboard",$a_modify)) $bt_modify = $a_modify."<font class=han style=font-weight:bold>-�����ϱ�</font></a>&nbsp;&nbsp;";

// �����ϱ�
	if(!eregi("<Zeroboard",$a_delete)) $bt_delete = $a_delete."<font class=han style=font-weight:bold>-�����ϱ�</font></a>&nbsp;&nbsp;";

// ��õ�ϱ�	
	if(!eregi("<Zeroboard",$a_vote)) $bt_vote = $a_vote."<font class=han2 style=font-weight:bold>-��õ�ϱ�</font></a>&nbsp;&nbsp;";

// ��������, ��������
	$bt_vprev = $a_prev."�� <font class=han2>��������</font></a>&nbsp;&nbsp;&nbsp;";
	$bt_iprev = $a_prev."�� ��������</a>";
	$bt_vnext = $a_next."<font class=han2>��������</font> ��</a>&nbsp;&nbsp;";
	$bt_inext = $a_next."�� ��������</a>";

// �ٿ�ε� ��ư
    $bt_download = "[�ٿ�ε�]";

//---- text ----------------------------------

	$_strSkin['exp_memo']		= '��ĭũ�� �ø���';
	$_strSkin['org_memo']		= '��ĭũ�� �������';
	$_strSkin['save_comment']	= '����';
	$_strSkin['save_commentEX']	= '����';
	$_strSkin['password']		= '<b class=han>��й�ȣ</b>';
	$_strSkin['name']			= '<b class=han>�̸�(����)</b>';
	$_strSkin['vote']			= '<font class=thumb_han>�� ������ ��õ</font>';
	$_strSkin['only_memo']		= '<font class=thumb_han>�۸� ����</font>';
	$_strSkin['vote_cancel']	= '<font class=thumb_han>��õ ���</font>';
?>