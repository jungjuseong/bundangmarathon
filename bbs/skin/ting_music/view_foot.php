<?
 /* ���� �����۰� ��ư ǥ��

  --- ����/ ���ı� ��ũ ---
  <?=$a_prev?> : ������ ��ũ
  <?=$a_next?> : ������ ��ũ

  <?=$prev_face_image?> : ������ �۾����� �� ������?;
  <?=$next_face_image?> : ������ �۾����� �� ������?;


  <?=$hide_prev_start?> <?=$hide_prev_end?> : ������ ��Ÿ����/ �����
  <?=$hide_next_start?> <?=$hide_next_end?> : ������ ��Ÿ����/ �����

  ��Ÿ �����̳� �۾��̵��� ���� ����Ÿ���� �տ� prev_ , next_ �� �� ���ΰ���;
  ex) ������ ���� : <?=$prev_subject?>

  <?=$a_write?> : �۾��� ��ư
  <?=$a_list?> : ��Ϻ��� ��ư
  <?=$a_reply?> : ��۾��� ��ư
  <?=$a_delete?> : �ۻ��� ��ư
  <?=$a_vote?> : ��õ��ư
  <?=$a_modify?> : �ۼ��� ��ư

 */
?>

<!-- ���� / ������ ��� -->
<table border=0 cellpadding cellspacing=0 width=100%>
<tr>
<td colspan=10 bgcolor=<?=$sC_dark0?>><img src=images/t.gif height=2></td></tr>
</table>

<?=$hide_prev_start?>
<table border=0 width=100% cellspacing=0 cellpadding=0>
<tr>
 <td colspan=8 bgcolor=<?=$sC_light1?>><img src=images/t.gif height=1></td>
</tr>
<tr align=center height=22>
  <td width=10% style='word-break:break-all;'><img src=images/t.gif height=3><br>[������]</td>
  <td width=50% align=left style='word-break:break-all;'><img src=images/t.gif height=3><br>&nbsp; <?=$prev_icon?><?=$a_prev?><?=$prev_subject?></a></td>
  <td width=20% style='word-break:break-all;'><img src=images/t.gif height=3><br></td>
  <td width=10% class=thm8 nowrap><?=$prev_reg_date?></td>
</tr>
</table>
<?=$hide_prev_end?>

<?=$hide_next_start?>
<table border=0 width=100% cellspacing=0 cellpadding=0>
<tr>
 <td colspan=8 bgcolor=<?=$sC_light1?>><img src=images/t.gif height=1></td>
</tr>
<tr align=center height=22>
  <td width=10% style='word-break:break-all;'><img src=images/t.gif height=3><br>[������]</td>
  <td width=50% align=left style='word-break:break-all;'><img src=images/t.gif height=3><br>&nbsp; <?=$next_icon?><?=$a_next?><?=$next_subject?></a></td>
  <td width=20% style='word-break:break-all;'><img src=images/t.gif height=3><br></td>
  <td class=thm8 width=10% nowrap><?=$next_reg_date?></td>
</tr>
</table>

<?=$hide_next_end?>

<!-- ��ư ���� ��� -->
<table border=0 cellpadding cellspacing=0 width=100%>
<tr><td colspan=10 bgcolor=<?=$sC_dark0?>><img src=images/t.gif height=3></td></tr>
</table>

<table border=0 cellspacing=0 cellpadding=0 width=100%>
<tr height=23>
 <td>
    <?=$a_list?><img src=<?=$dir?>/images/btn_list.gif border=0 align=absmiddle></a>
    <?=$a_write?><img src=<?=$dir?>/images/btn_write.gif border=0 align=absmiddle></a>
 </td>
 <td align=right>
    <b  onclick="alert('��õ�� �ݿ��Ǿ����ϴ�.')"><?=$a_vote?><img src=<?=$dir?>/images/btn_vote.gif border=0 align=absmiddle></a></b>
    <?=$a_reply?><img src=<?=$dir?>/images/btn_reply.gif border=0 align=absmiddle></a>
    <?=$a_modify?><img src=<?=$dir?>/images/btn_modify.gif border=0 align=absmiddle></a>
    <?=$a_delete?><img src=<?=$dir?>/images/btn_delete.gif border=0 align=absmiddle></a>
 </td>
</tr>
</table>

<br>
  </td>
  <td background=<?=$dir?>/images/m_5.gif><img src=<?=$dir?>/images/m_5.gif border=0></td>
</tr>
<tr>
  <td>
  <img src=<?=$dir?>/images/m_6.gif border=0></td>
  <td background=<?=$dir?>/images/m_7.gif width=100%>
  <td><img src=<?=$dir?>/images/m_8.gif border=0></td>
</tr>
</table>
