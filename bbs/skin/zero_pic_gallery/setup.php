<?
  /*
	  �� ������ �Խ��ǿ��� ����� ���¸� �����ݴϴ�.

		<?=$width?> : �Խ����� ����ũ��
		<?=$dir?> : ��Ų���丮�� ����ŵ�ϴ�.
		<?=$total?> : ��ü �ۼ�
		<?=$total_page?> : ��ü ��������
		<?=$a_status?> : ��踵ũ
		<?=$a_login?> : �α��� ��ư
		<?=$a_logout?> : �α׿�����ư
		<?=$page?> : ���������� ǥ��
		<?=$a_member_join?> : ȸ������
		<?=$a_member_modify?> : ȸ����������
		<?=$a_member_memo?> : ����;;
		<?=$member_memo_icon?> : ����������;;
		<?=$memo_on_sound?> : ������ ������ �Ҹ� ������ ���� memo_on.swf
		<?=$total_connect?> : ���� ��ü ȸ�� �α��μ�
		<?=$group_connect?> : ���� �׷� �α��μ�

		* ������������ member_memo_on.gif, member_memo_off.gif ������ �ֽ��ϴ�. (�⺻)

		member_memo_on.gif�� ���ο� ������ ������, �۰� member_memo_off.gif�� �������� �������Դϴ�;;
	*/



	/*************************************************************
	*
	* ���� ������ ��Ų (ver 0.1)
	*                 - by zero
	*
	* �Ʒ� ������ �ش��ϴ� ���� �����Ͻø� �˴ϴ�.
	*
	**************************************************************/
	$_hsize = 110; // ���� ũ��
	$_h_num = 5; // ���� ����

	// ���ѻ��� (���� �׵θ�)
	$_color1="eeeeee";

	// ���ѻ��� (���� ����)
	$_color2="white";

	$_x = 0; // ���� �ʿ��� ����

?>



<table border=0 cellspacing=0 cellpadding=0 width=<?=$width?>>
<?=$memo_on_sound?>
<tr>
  <td style=font-family:tahoma;font-size:7pt; align=left>
  &nbsp; Total : <b><?=$setup[total_article]?></b><?if($setup[total_article]!=$total)echo" (<font color=red>$total</font> searched) ";?>, <B><?=$page?></b> / <b><?=$total_page?> pages
  </td>
  <td style=font-family:tahoma;font-size:8pt; align=right height=30>
    <?=$a_member_modify?><img src=<?=$dir?>/s_myinfo.gif border=0></a> &nbsp;
    <?=$a_member_memo?><img src=<?=$dir?>/s_memobox.gif border=0></a> &nbsp;
    <?=$a_logout?><img src=<?=$dir?>/s_logout.gif border=0></a> &nbsp;
    <?=$a_setup?><img src=<?=$dir?>/s_setup.gif border=0></a>
    <?=$a_login?><img src=<?=$dir?>/s_login.gif border=0></a> &nbsp;
    <?=$a_member_join?><img src=<?=$dir?>/s_signup.gif border=0></a> 
    &nbsp;

  </td>
</tr>
<tr><td height=1 colspan=3 background=<?=$dir?>/dot.gif><img src=<?=$dir?>/dot.gif border=0 height=1></td></tr>
</table>
