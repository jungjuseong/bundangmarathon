<?
 /* 간단한 답글 쓰기 표시

  -- 간단한 답글 관련
  <?=$hide_comment_start?> <?=$hide_comment_end?> : 간단한 답글 쓰기 보여주기/ 숨기기
  <?=$hide_c_password_start?> <?=$hide_c_password_end?> : 간단한 답글시 비밀번호 입력 보여주기/ 숨기기;;

  <?=$c_name?> : 코멘트시 이름 입력하는 곳;;

  ** view.php 제일 아래쪽에 간답한 답글이 시작하는 <table>태그 시작부분이 있습니다.
     그리고 간단한 답글이 있으면 view_comment_view.php 파일에서 출력을 합니다.

 */
?>


<!-- 간단한 답변글 쓰기 -->
<tr><td bgcolor=<?=$sC_dark0?> colspan=10><img src=images/t.gif height=1></td></tr>
<tr align=center height=30>
<td width=0>
<form method=post name=write action=comment_ok.php>
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
</td>
 <td align=left>
<table border=0 cellpadding=0 style="text-align:left;">
     <tr>
        <td width="65"><b>Name : </b></td>
        <td align="left" width="125"><?=$c_name?></td>
        <td>
<?=$hide_c_password_start?>
    <table border=0 cellpadding=0>
     <tr>
        <td width="85"><b>Password : </b></td>
        <td width="100%"><input type=password name=password <?=size(10)?> maxlength=20 class=input border=0></td>
    </tr>
    </table>
<?=$hide_c_password_end?>
        </td>
       <td></td>
    </tr>
</table>
<table border=0 cellpadding=0 style="text-align:left;" width=100%>
     <tr>
        <td width="65" valign="top"><b>Memo : </b></td>
        <td align=left width=350><textarea name=memo<?=size(50)?> rows="3" cols=50 style="border-width:1; border-style:solid;" class=textarea></textarea></td>
        <td valign=top align=left><input type=image border=0 src=<?=$dir?>/images/btn_confirm.gif></td>
    </tr>
</table>
 </td>
</tr>
</form>
</table>
