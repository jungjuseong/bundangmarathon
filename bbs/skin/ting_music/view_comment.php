<?
  /* ������ ����� ����ϴ� �κ��Դϴ�.
   view.php��Ų���Ͽ� ������ ����� �����ϴ� <table>���� �±װ� ���۵Ǿ� �ֽ��ϴ�.
   �׸���view_foot.php ���Ͽ� </table>�±װ� ������ ��� ���� ���� ���� �ֽ��ϴ�

  <?=$comment_name?> : �۾���
  <?=$c_memo?> : ����
  <?=$c_reg_date?> : ���� �� ����;;
  <?=$a_del?> : �ڸ�Ʈ ���� ��ư��ũ
  <?=$c_face_image?> : ����� ������;;
 */
?>

<tr>
  <td colspan=2>
   <table border=0 align=center cellpadding=2 cellspacing=0  style="margin-top:1; margin-bottom:1;" width=100%>
   <tr align=center bgcolor=<?=$sC_light01?>>
     <td width=15% align=right style='word-break:break-all;' nowrap valign=top><?=$c_face_image?> <?=$comment_name?></td>
     <td width=60 style='word-break:break-all;' nowrap class=thm8 valign=top align=center><font style=font-size:7pt;>[<?=$c_reg_date?>]</td>
     <td width=8 nowrap valign=top><b>��</b></td>
     <td align=left style='word-break:break-all;' valign=top><?=nl2br($c_memo)?></td>
     <td width=8 valign=top><img src=images/t.gif height=3 border=0><br><?=$a_del?><img src=<?=$dir?>/secret_head.gif border=0></a></td>
   </tr>
   </table>
 </td>
</tr>

