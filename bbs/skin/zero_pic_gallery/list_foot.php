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

<?
 // ����Ʈ���� ���ڶ�� <Td> �κ� ���� �����.. ��/////////////////////
 for($_i=$_x;$i<$_h_hum;$i++)
 {
?>
	<td>&nbsp;</td>
<?
 }
 ////////////////////////////////////////////////////////////////////////
?>

<tr>
  <td height=1 colspan=<?=$_h_num?> background=<?=$dir?>/dot.gif><img src=<?=$dir?>/dot.gif border=0 height=1></td>
</tr>

<!-- ������ �κ��Դϴ� -->
</table>

<!-- ��ư �κ� -->
<table border=0 cellspacing=1 cellpadding=1 width=<?=$width?>>
<tr>
 <td width=100% align=left colspan=2 class=font-family:matchworks;font-size:8pt nowrap>
  <?=$a_prev_page?>[PREV]</a> <?=$print_page?> <?=$a_next_page?>[NEXT]</a>  
 </td>
 <td align=right height=20 nowrap> 
  <?=$a_list?><img src=<?=$dir?>/i_list.gif border=0 align=absmiddle></a>
  <?=$a_1_prev_page?><img src=<?=$dir?>/i_prev.gif border=0 align=absmiddle></a>  
  <?=$a_1_next_page?><img src=<?=$dir?>/i_back.gif border=0 align=absmiddle></a>
  <?=$a_delete_all?><img src=<?=$dir?>/i_delete.gif border=0 align=absmiddle></a>
  <?=$a_write?><img src=<?=$dir?>/i_write.gif border=0 align=absmiddle></a>
 </td>
</tr>
</form>
</table>

<table border=0 cellspacing=1 cellpadding=1 width=<?=$width?>>
<tr>
	<td width=1>
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
<!----------------------------------------------->
 </td>
 <td align=center>

<table border=0 cellspcing=0 cellpadding=0>
<tr>
 <td align=center>
    <a href="javascript:OnOff('sn')" onfocus=blur()><img src=<?=$dir?>/name_<?=$sn?>.gif border=0 name=sn></a>
    <a href="javascript:OnOff('ss')" onfocus=blur()><img src=<?=$dir?>/subject_<?=$ss?>.gif border=0 name=ss></a>
    <a href="javascript:OnOff('sc')" onfocus=blur()><img src=<?=$dir?>/content_<?=$sc?>.gif border=0 name=sc></a><img src=images/t.gif width=35 height=1>
  </td>
</tr>
</table>
<table border=0 cellspacing=0 cellpadding=0>
<tr>
  <td><img src=<?=$dir?>/s_left.gif align=absmiddle></td>
  <td background=<?=$dir?>/s_bg.gif width=100><input type=text name=keyword value="<?=$keyword?>" class=input2 size=20></td>
  <td><input type=image src=<?=$dir?>/search.gif border=0></td>
  <td><?=$a_cancel?><img src=<?=$dir?>/cancel.gif align=absmiddle border=0></a></td>
</form>
</tr>
</table>

	</td>
</tr>
</table>


