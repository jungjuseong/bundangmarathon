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
include "$dir/value.php3"; ?>
<script>
var chk;
chk=false;
function CheckAll()
{
	if (!chk){
		for (i=0;i<document.list.length;i++)
		{
			if(document.list[i].type=='checkbox')
		   {
				document.list[i].checked=true;
			}
		}
		chk=true;
	}
	else
	{
		for (i=0;i<document.list.length;i++)
		{
			if(document.list[i].type=='checkbox')
			{
				document.list[i].checked=false;
			}
		}
		chk=false;
	}
}


</script>



<? include "$dir/listen_alljs.php"; ?>
<? include "$dir/cart_js.php"; ?>



<table border=0 cellspacing=0 cellpadding=0 width=<?=$width?>>
<tr>
  <td valign=bottom>
<a href=javascript:CartWindow()><img src=<?=$dir?>/images/album_s.gif border=0 align=absmiddle title='���Ǿٹ�����' onfocus=blur()></a>
<!-- �˻��� �κ� ---------------------->
<!-- ���±� �κ�;; �������� �ʴ� ���� �����ϴ� -->
<form method=post name=search action=<?=$PHP_SELF?>>
<input type=hidden name=page value=<?=$page?>>
<input type=hidden name=id value=<?=$id?>>
<input type=hidden name=select_arrange value=<?=$select_arrange?>>
<input type=hidden name=desc value=<?=$desc?>>
<input type=hidden name=page_num value=<?=$page_num?>>
<input type=hidden name=selected>
<input type=hidden name=exec>
<input type=hidden name=sn value="<?=$sn?>">
<input type=hidden name=ss value="<?=$ss?>">
<input type=hidden name=sc value="<?=$sc?>">
<input type=hidden name=category value="<?=$category?>">
<!-----------------------------------------------></td>

   <td width=10% valign=bottom>&nbsp;<input type=text name=keyword value="<?=$keyword?>" <?=size(15)?> class=input style=font-size:9pt;font-family:Arial;border-left-color:#c0c0c0;border-right-color:#c0c0c0;border-top-color:#c0c0c0;border-bottom-color:#c0c0c0;height:18px;>&nbsp;<input type=image border=0 align=absmiddle src=<?=$dir?>/images/search_right.gif></a>

</td><TD width=85% valign=bottom><td <?if(!$setup[use_category]) echo"align=right";?>>
</td></form>

<td align=right valign=bottom>&nbsp;<?=$a_login?><img src=<?=$dir?>/s_login.gif border=0></a><?=$a_logout?><img src=<?=$dir?>/s_logout.gif border=0></a>&nbsp;
<?=$a_setup?><img src=<?=$dir?>/s_setup.gif border=0></a></td><td align=right valign=bottom><?=$hide_category_start?>&nbsp;<?=$a_category?></td>
<?=$hide_category_end?>
 </tr>
<TR align=middle>
                <TD class=light vAlign=top align=middle height="1" width="100%" colspan="7" bgcolor="#999999">
</TD>
</TR>
</table>
