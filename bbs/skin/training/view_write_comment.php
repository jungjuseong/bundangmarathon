</table>

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

<table border=0 cellspacing=1 cellpadding=0 width=<?=$width?> class=robin_viewform>
<tr>
  <td>
	<table border=0 cellspacing=0 cellpadding=4 width=100% height=100>
	<col width=80></col><col width=></col><col width=80></col>
	<tr align=center> 
	  <td height=20 style=font-family:Verdana;font-size:8pt;letter-spacing:-1px;><img src=images/t.gif border=0 width=80 height=1><br><B><img src=<?=$dir?>/w_name.gif></b></td>
	        <td style=font-family:Verdana;font-size:8pt;letter-spacing:-1px;><font style=font-family:Verdana;font-size:8pt;letter-spacing:-1px;><b><img src=<?=$dir?>/w_comment.gif> 
              </b></font>&nbsp;&nbsp; <img src=<?=$dir?>/btn_down.gif border=0 valign=absmiddle style=cursor:hand; onclick=zb_formresize(document.write.memo)></td>
	  <td>&nbsp;</td>
	</tr>
	<tr align=center valign=top>
	  <td nowrap height=80>
	     <?=$c_name?>
	     <?=$hide_c_password_start?>
	     <br><img src=images/t.gif border=0 height=10><br>
              <font style=font-family:Verdana;font-size:8pt;letter-spacing:-1px;><b><img src=<?=$dir?>/w_password.gif></b></font><br>
	     <img src=images/t.gif border=0 height=5><br>
	     <input type=password name=password <?=size(8)?> maxlength=20 class=robin_input> 
	     <?=$hide_c_password_end?>
	  </td>
	  <td><textarea name=memo <?=size(40)?> rows=5 class=robin_textarea></textarea></td>
	  <td><input type=submit rows=3 <?if($browser){?>class=robin_submit<?}?> value='�ڸ�Ʈ' accesskey="s"></td>
	</tr>
	</table>
  </td>
</tr>
</table>
</form>
