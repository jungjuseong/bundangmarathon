<?
if(eregi(basename(__FILE__),$PHP_SELF)) die('정상적인 접근이 아닙니다');

//스킨 환경설정 읽어옴
	include $dir."/get_config.php";

	include $dir."/".$skin_setup['language_dir']."ask_password.php";
?>

<table width=<?=$setup[table_width]?> border=0 cellpadding=0 cellspacing=0>
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
<input type=hidden name=su value="<?=$su?>">
<input type=hidden name=mode value="<?=$mode?>">
<input type=hidden name=c_no value=<?=$c_no?>>
<tr><td align=center>
	<br><br><br>
	<table border=0 cellspacing=2 padding=3>
	<tr><td class=info_bg>
		<table border=0 cellpadding=0 cellspacing=0 width=400>
		<tr><td class=lined><img src=<?=$dir?>/t.gif height=1></td></tr>
		<tr>
			<td align=center style="line-height:160%;padding:5px;"><b class=han><?=$title?></b></td>
		</tr>
		<tr><td class=lined><img src=<?=$dir?>/t.gif height=1></td></tr>
		<tr>
			<td align=center class=han style="padding:20 0 10 0;">
		<?if(!$member[no]) {?><?=$input_password?>
		<?}?>
			</td>
		</tr>
		</table>
	</td></tr>
	</table>
	<table border=0 cellspacing=2 padding=3>
	<tr><td height=30>
		<input type=submit class=submit value=" 확  인 " border=0 accesskey="s">
		<input type=button class=button value="이전화면" onclick=history.back()>
	</td></tr>
	</table>

	<br><br><br>
  </td>
<tr><td colspan=2 class=lined><img src=<?=$dir?>/t.gif height=1></td></tr>
</tr>
</form>
</table>
</div>
<div align=right style=width:<?=$setup[table_width]?>>
