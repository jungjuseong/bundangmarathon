<? include "$dir/value.php3"; ?>
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
<div align=center>
<table border=0 cellspacing=0 cellpadding=0 width=300>
  <tr>

    <td align=center><img src=<?=$dir?>/images/t.gif height=2><br>

<table border=0 width=100% cellpadding=0 cellspacing=0>
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
  <td colspan=2 height=30>&nbsp;&nbsp;<span style="font-family:Arial;font-size:8pt;font-weight:bold;"><font color=#333333>Enter</font> <span style=font-size:15px;letter-spacing:-1px;>Password</span></span></td>
</tr>
<tr height=1><td colspan=2 bgcolor=<?=$sC_dark1?>><img src=images/t.gif height=1></td></tr>
<tr height=25 style=padding:5px;>
   <td align=center><br><?=$title?></td>
</tr>
<tr>
   <td align=center><?=$input_password?><br><br></td>
</tr>
<tr height=1><td colspan=2 bgcolor=<?=$sC_dark1?>><img src=images/t.gif height=1></td></tr>

<tr height=30>
  <td colspan=2 align=right>
     <input type=image align=absmiddle border=0 src=<?=$dir?>/images/btn_confirm.gif> <?=$a_view?><img src=<?=$dir?>/images/btn_cancel.gif align=absmiddle border=0></a>
  </td>
</tr>
</table><br>
    </td>
    <td width=9 ><img src=<?=$dir?>/images/t.gif height=2></td>
  </tr>
  <tr>
    <td width=9 height=9 ><img src=<?=$dir?>/images/t.gif height=2></td>
    <td height=9 ><img src=<?=$dir?>/images/t.gif height=2></td>
    <td width=9 height=9 ><img src=<?=$dir?>/images/t.gif height=2></td>
  </tr>
</table>
<br><br><br>