<?
 /* ���� �����۰� ��ư ǥ��
 
  --- ����/ ���ı� ��ũ ---
  <?=$a_prev?> : ������ ��ũ
  <?=$a_next?> : ������ ��ũ

  <?=$prev_face_image?> : ������ �۾����� �� �������;;
  <?=$next_face_image?> : ������ �۾����� �� �������;;


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

<?=$hide_prev_start?>
<table border=0 width=<?=$width?> cellspacing=0 cellpadding=0 bgcolor=<?=$_color1?>>
<tr><td colspan=10 bgcolor=888888><img src=images/t.gif height=1></td></tr>
<tr align=center>
  <td width=8% style='word-break:break-all;font-family:matchworks;font-size:10px'>PREV</td>
  <td width=82% align=left style='word-break:break-all;'>&nbsp; <?=$a_prev?><?=$prev_subject?></a></td>
  <td width=10% nowrap><?=$prev_face_image?> <?=$prev_name?></td>
</tr>
</table>
<?=$hide_prev_end?>

<?=$hide_next_start?>
<table border=0 width=<?=$width?> cellspacing=0 cellpadding=0  bgcolor=<?=$_color1?>>
<tr><td colspan=10 bgcolor=888888><img src=images/t.gif height=1></td></tr>
<tr align=center>
  <td width=8% style='word-break:break-all;font-family:matchworks;font-size:10px'>NEXT</td>
  <td width=82% align=left style='word-break:break-all;'>&nbsp; <?=$a_next?><?=$next_subject?></a></td>
  <td width=10% nowrap><?=$next_face_image?> <?=$next_name?></td>
</tr>
</table>

<?=$hide_next_end?>
<table border0 width=<?=$width?> cellspacing=0 cellpadding=0><tr><td colspan=10 bgcolor=888888><img src=images/t.gif height=1></td></tr></table>

<!-- ��ư ���� ��� -->
<br>
<table border=0 cellspacing=0 cellpadding=0 width=<?=$width?>>
<tr>
 <td>
    <?=$a_list?><img src=<?=$dir?>/i_list.gif border=0></a>
    <?=$a_write?><img src=<?=$dir?>/i_write.gif border=0></a>
 </td>
 <td align=right>
    <?=$a_reply?><img src=<?=$dir?>/i_reply.gif border=0></a>
    <?=$a_modify?><img src=<?=$dir?>/i_modify.gif border=0></a>
    <?=$a_delete?><img src=<?=$dir?>/i_delete.gif border=0></a>
 </td>
</tr>
</table>
<br><br>

