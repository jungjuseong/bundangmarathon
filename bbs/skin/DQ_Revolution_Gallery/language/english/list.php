<?
// ���Ĺ�ư
	if(!$select_arrange || $select_arrange=="headnum") $bt_no = $a_no."<b class=han>number</b></a>"; else $bt_no = $a_no."<font class=han>number</a>";
	if($select_arrange=="hit") $bt_hit = $a_hit."<b class=han>hit</b></a>"; else $bt_hit = $a_hit."<font class=han>hit</a>";
	if($select_arrange=="vote") $bt_vote = $a_vote."<b class=han>recommend</b></a>"; else $bt_vote = $a_vote."<font class=han>recommend</a>";
	if($select_arrange=="reg_date") $bt_date = $a_date."<b class=han>date</b></a>"; else $bt_date = $a_date."<font class=han>date</a>";

	$bt_sort = "<nobr>Sort: $bt_no<font class=thumb_list_comment> | </font>$bt_date<font class=thumb_list_comment> | </font>$bt_hit<font class=thumb_list_comment> | </font>$bt_vote</nobr>";

// �޸������
	if(eregi('_off.gif',$member_memo_icon)) $member_memo_icon = str_replace('/member_memo_off.gif','/'.$skin_setup[css_dir].'member_memo_off.gif',$member_memo_icon);
	if(eregi('_on.gif',$member_memo_icon))  $member_memo_icon = str_replace('/member_memo_on.gif','/'.$skin_setup[css_dir].'member_memo_on.gif',$member_memo_icon);
	$a_write_tmp = str_replace(">","><font class=han2 style=font-weight:bold>",$a_write);

// �α��� ���� ��ư
	$bt_login			= $a_login."[login"; if(!$group[use_join]) $bt_login = $bt_login."]"; $bt_login = $bt_login."</a>\n";
	$bt_member_join		= $a_member_join."join]&nbsp;</a>\n";
	$bt_member_modify	= $a_member_modify."[my info</a>\n";
	$bt_bember_memo		= $a_member_memo."&nbsp;".$member_memo_icon."&nbsp;memo</a>\n";
	$bt_logout			= $a_logout."&nbsp;logout]&nbsp;</a>\n";
	$bt_setup			= $a_setup."-board setup&nbsp;</a>\n";

// ������ ���� ��ư
	$bt_skinsetup = "<b>-gallery setup</b>&nbsp;";

// ī�װ� "��ü" ��ư
	if(!$category) $bt_c_list = "<a href=zboard.php?&id=$id><b>all list</b></a>";
	else $bt_c_list = "<a href=zboard.php?&id=$id>all list</a>";

// �۾����ư
	if(!eregi("<Zeroboard",$a_write)) $bt_write=$a_write."<font class=han2 style='font-weight:bold'>".$skin_setup['write_buttonName']."</font></a>";

// ��� ��ư
	if($view_once) $_strList = "-list"; else $_strList = "-refresh";
	$bt_list = $a_list."<font class=han style=font-weight:bold>".$_strList."</font></a>&nbsp;&nbsp;";

// �Խù�����
	if(!eregi("<Zeroboard",$a_delete_all)) $bt_delete_all = $a_delete_all."<font class=han style='font-weight:bold'>-admin</font></a>&nbsp;&nbsp;";

// ����������, ����������
	if(!eregi("<Zeroboard",$a_1_prev_page)) $bt_1_prev_page = $a_1_prev_page."<font class=han style=font-weight:bold>-prev page</font></a>&nbsp;&nbsp;";
	if(!eregi("<Zeroboard",$a_1_next_page)) $bt_1_next_page	= $a_1_next_page."<font class=han style=font-weight:bold>-next page</font></a>&nbsp;&nbsp;";

// ���� n��
	if(!eregi("<Zeroboard",$a_prev_page)) $bt_prev_page = $a_prev_page."<font class=thumb_list_page style=font-weight:normal>[prev ".$setup[page_num]."]</font></a>&nbsp;";
	if(!eregi("<Zeroboard",$a_next_page)) $bt_next_page = $a_next_page."<font class=thumb_list_page style=font-weight:normal>[next ".$setup[page_num]."]</font></a>";

// ��Ӱ˻�, �����˻�
	$print_page = str_replace("<font style=font-size:8pt>","<font class=han>",$print_page);
	$print_page = str_replace("��� �˻�","<font class=han>Search Continue</font>",$print_page);
	$print_page = str_replace("���� �˻�","<font class=han>Search Continue</font>",$print_page);
	$print_page = str_replace("[","&nbsp;",str_replace("]","&nbsp;&nbsp;",$print_page));
	$print_page = str_replace("</b>","</b>&nbsp;",$print_page);



//---- text ----------------------------------

	$_strSkin['search']		= 'Search';
	$_strSkin['cancel']		= 'Cancel';
	$_strSkin['is_vdel']	= '-��ڿ� ���� �����Ǿ����ϴ�.-';
	$_strSkin['is_secret']	= '������ �� �� �ִ� ������ �����ϴ�.';

?>