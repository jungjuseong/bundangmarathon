<?
  /*
  ���� �����ϰų� �Ҷ� ��й�ȣ�� ����� �κ��Դϴ�
 
  <?=$target?> : ���������� ����ŵ�ϴ�. �������� ������;;;
  <?=$title?> : Ÿ��Ʋ�� ����մϴ�

  <?=$a_list?> : ��Ϻ��� ��ũ
  <?=$a_view?> : ���뺸�� ��ũ

  <?=$invisible?> : ����� �����ڰ� ������ ���� ��ư�� ���Դϴ�;;

  <?=$input_password?> : ��й�ȣ�� ����� input=text ��� 
  */
?>

<br><br><br>
<table border=0 cellspacing=0 cellpadding=0 width=250>
<tr>
 <td background=<?=$dir?>/dot.gif width=100%><img src=<?=$dir?>/t.gif border=0 height=1></td>
</tr>
</table>

<table border=0 width=250>
<form method=post name=delete action=<?=$target?>>
<input type=hidden name=page value=<?=$page?>>
<input type=hidden name=id value=<?=$id?>>
<input type=hidden name=no value=<?=$no?>>
<input type=hidden name=select_arrange value=<?=$select_arrange?>>
<input type=hidden name=desc value=<?=$desc?>>
<input type=hidden name=page_num value=<?=$page_num?>>
<input type=hidden name=keyword value="<?=$keyword?>">
<input type=hidden name=category value="<?=$category?>">
<input type=hidden name=sn value="<?=$sn?>">
<input type=hidden name=ss value="<?=$ss?>">
<input type=hidden name=sc value="<?=$sc?>">
<input type=hidden name=mode value="<?=$mode?>">
<input type=hidden name=c_no value=<?=$c_no?>>
<tr>
   <td align=center><b><?=$title?></b></td>
</tr>
</table>

<table border=0 cellspacing=0 cellpadding=0 width=250>
<tr>
 <td background=<?=$dir?>/dot.gif width=100%><img src=<?=$dir?>/t.gif border=0 height=1></td>
</tr>
</table>

<table border=0 width=250>
<tr height=50>
   <td align=center>
     <?=$input_password?> 
     <br><br><input type=image src=<?=$dir?>/i_confirm.gif border=0>
     <?=$a_list?><img src=<?=$dir?>/i_list.gif border=0></a>
     <a href=javascript:void(history.back())><img src=<?=$dir?>/i_back.gif border=0></a>
   </td>
</tr>
</table>
</form>

