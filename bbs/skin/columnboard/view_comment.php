<?  /* ������ ����� ����ϴ� �κ��Դϴ�.   view.php��Ų���Ͽ� ������ ����� �����ϴ� <table>���� �±װ� ���۵Ǿ� �ֽ��ϴ�.   �׸���view_foot.php ���Ͽ� </table>�±װ� ������ ��� ���� ���� ���� �ֽ��ϴ�  <?=$comment_name?> : �۾���  <?=$c_memo?> : ����  <?=$c_reg_date?> : ���� �� ����;;  <?=$a_del?> : �ڸ�Ʈ ���� ��ư��ũ  <?=$c_face_image?> : ����� ������;; */?>


<tr>
  <td colspan=2>
   <table border=0 align=center cellpadding=0 cellspacing=8 width=97%>
   <tr>
      <td width=65 class=thm9 valign=top><b><?=$comment_name?></b></td> 
      <td width=4 bgcolor=e3e3e3></td>
	 <td class=thm9 style='word-break:break-all;' valign=top><p style=line-height:150%><?=nl2br($c_memo)?></p></td>
     <td nowrap align=right valign=top width=70><font style='word-break:break-all;font-family:Tahoma;font-size:7pt'><?=$c_reg_date?></font><br><?=$a_del?><img src=<?=$dir?>/image/c_delete.gif border=0 alt="����"></a></td>
</tr>
<tr>
<td height=1 colspan=5 background=<?=$dir?>/image/dot.gif><img src=<?=$dir?>/image/dot.gif border=0 height=1></td>
</tr>

   </table>
 </td>
</tr>

