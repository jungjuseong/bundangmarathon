<? /////////////////////////////////////////////////////////////////////////
  /*
  �� ������ ����� �� ����� ���� ������ ���� �κ��Դϴ�.
  ���̺��� �ݰ� ������ ����̳� �˻� ���, ��ư���� ����ϸ� �˴ϴ�.
  �Ʒ��κ��� �״�� ����Ͻø� �˴ϴ�.


  <?=$a_1_prev_page?> : ������������ ����մϴ�. (���������� �̵�)
  <?=$a_1_next_page?> : ���� �������� ����մϴ�. (���������� �̵�)
  <?=$a_prev_page?> : ������������ ����մϴ�.
  <?=$a_next_page?> : ���� �������� ����մϴ�.
  <?=$print_page?> : �������� ����մϴ�
  <?=$a_write?> : �۾��� ��ư
  <?=$a_list?> : ��Ϻ��� ��ư
  <?=$a_cancel?> : ��� ��ư
  <?=$a_reply?> : ��۾��� ��ư
  <?=$a_delete?> : �ۻ��� ��ư
  <?=$a_modify?> : �ۼ��� ��ư
  <?=$a_delete_all?> : �������϶� ��Ÿ���� ���õ� �� ���� ��ư;;

  */
///////////////////////////////////////////////////////////////////////// ?>

<!-- ������ �κ��Դϴ� -->
</table>
<table border=0 cellpadding=0 cellspacing=0 width=100%>
<tr>
 <td></td>
 <td>

<!-- ��ư �κ� -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td height="7">
            <p></p>
        </td>
    </tr>
</table>
<table border=0 cellspacing=0 cellpadding=0 width=100%>
<tr>
 <td width=40% nowrap>
 <img src=<?=$dir?>/images/all_select.gif border=0 align=absmiddle title='��ü����,�������' onfocus=blur() onClick="CheckAll()" style="cursor:hand"><?
if($setup[grant_view]<$member[level]&&!$is_admin){
	?><img src=<?=$dir?>/images/select_music.gif border=0 alt='�������ǵ��' style="cursor:hand;" align=absmiddle  onClick="alert('�������� �����ϴ�.')"><?
} else {
	?><a onfocus=blur() href='javascript:listen_all()'><img src=<?=$dir?>/images/select_music.gif border=0 align=absmiddle title="�������ǵ��"></a><?
}
if($setup[grant_view]<$member[level]&&!$is_admin){
	?><img src=<?=$dir?>/images/cart1.gif border=0 alt='�������� �ٹ��� ���' style="cursor:hand;" align=absmiddle  onClick="alert('�������� �����ϴ�.')"><?
} else {
	?><a onfocus=blur() href='javascript:Cart()'><img src=<?=$dir?>/images/cart1.gif border=0 align=absmiddle title="�������� �ٹ��� ���"></a><?
}
?><a href=javascript:CartWindow()><img src=<?=$dir?>/images/album.gif border=0 align=absmiddle title='���Ǿٹ�����' onfocus=blur()></a></td>
 <td align=center colspan=2 nowrap>
<?=$a_prev_page?>[PREV]</a> <?=$print_page?> <?=$a_next_page?>[NEXT]</a>

 </td>
 <td align=right width=40%>
  <?=$a_delete_all?><img src=<?=$dir?>/images/btn_manage.gif border=0 align=absmiddle></a>
<?=$a_write?><img src=<?=$dir?>/images/btn_write.gif border=0 align=absmiddle></a>
 </td>
</tr>
</form>
</table>

 </td>
</tr>
<tr>
 <td>

 </td>
 <td>



</td></tr></table>
