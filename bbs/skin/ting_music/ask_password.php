<? include "$dir/value.php3"; ?>
<?
  /*
  글을 삭제하거나 할때 비밀번호를 물어보는 부분입니다

  <?=$target?> : 실행파일을 가리킵니다. 수정하지 마세요;;;
  <?=$title?> : 타이틀을 출력합니다

  <?=$a_list?> : 목록보기 링크
  <?=$a_view?> : 내용보기 링크

  <?=$invisible?> : 멤버나 관리자가 삭제시 삭제 버튼만 보입니다;;

  <?=$input_password?> : 비밀번호를 물어보는 input=text 출력
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