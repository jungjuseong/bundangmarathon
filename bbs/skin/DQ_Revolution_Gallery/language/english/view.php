<?
// �۾����ư
	if(!eregi("<Zeroboard",$a_write)) $bt_write=$a_write."<font class=han2 style='font-weight:bold'>".$skin_setup['write_buttonName']."</font></a>";

// ��� ��ư
	$bt_list = $a_list."<font class=han style=font-weight:bold>-list</font></a>&nbsp;&nbsp;";

// ��۴ޱ�
	if(!eregi("<Zeroboard",$a_reply)) $bt_reply = $a_reply."<font class=han style=font-weight:bold>-reply</font></a>&nbsp;&nbsp;";

// �����ϱ�	
	if(!eregi("<Zeroboard",$a_modify)) $bt_modify = $a_modify."<font class=han style=font-weight:bold>-modify</font></a>&nbsp;&nbsp;";

// �����ϱ�
	if(!eregi("<Zeroboard",$a_delete)) $bt_delete = $a_delete."<font class=han style=font-weight:bold>-delete</font></a>&nbsp;&nbsp;";

// ��õ�ϱ�	
	if(!eregi("<Zeroboard",$a_vote)) $bt_vote = $a_vote."<font class=han2 style=font-weight:bold>-recommend</font></a>&nbsp;&nbsp;";

// ��������, ��������
	$bt_vprev = $a_prev."�� <font class=han2>prev</font></a>&nbsp;&nbsp;&nbsp;";
	$bt_iprev = $a_prev."�� prev</a>";
	$bt_vnext = $a_next."<font class=han2>next</font> ��</a>&nbsp;&nbsp;";
	$bt_inext = $a_next."�� next</a>";

// �ٿ�ε� ��ư
    $bt_download = "[Download]";

//---- text ----------------------------------

	$_strSkin['exp_memo']		= 'increase size of comment';
	$_strSkin['org_memo']		= 'return to original size of comment';
	$_strSkin['save_comment']	= 'save';
	$_strSkin['save_commentEX']	= 'save';
	$_strSkin['password']		= '<b class=han>password</b>';
	$_strSkin['name']			= '<b class=han>name</b>';
	$_strSkin['vote']			= '<font class=thumb_han>recommend</font>';
	$_strSkin['only_memo']		= '<font class=thumb_han>only memo</font>';
	$_strSkin['vote_cancel']	= '<font class=thumb_han>cancel recommend</font>';

?>