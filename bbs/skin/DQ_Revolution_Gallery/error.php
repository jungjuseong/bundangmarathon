<?
if(eregi(basename(__FILE__),$PHP_SELF)) die('�������� ������ �ƴմϴ�');
//��Ų ȯ�漳�� �о��
	if(!$dir) $dir = '.';
	include $dir."/get_config.php";
?>
<table width=<?=$setup[table_width]?> border=0 cellpadding=0 cellspacing=0>
<tr><td align=center>
	<br><br><br>
	<table border=0 cellspacing=2>
	<tr><td class=info_bg>
		<table border=0 cellpading=0 cellspacing=0 cellpadding=0>
		<tr><td align=center height=25><b class=han>�˸��ϴ�</b></td></tr>
		<tr><td class=lined><img src=<?=$dir?>/t.gif height=1></td></tr>
		<tr><td align=center class=han style=padding:15px;line-height:160%><?echo $message;?></td></tr>
		<tr><td class=lined><img src=<?=$dir?>/t.gif height=1></td></tr>
		<tr><td height=30>
		<? if(!$url){ ?>
		  <div align=center><a href=# onclick=history.back() onfocus=blur()><font class=han>[���� ȭ��]</font></a></div>
			<? } else { ?>			<div align=center><a href=# onclick=location.href="<?echo $url;?>" onfocus=blur()><font class=han>[������ �̵�]</font></a></div>
			<? } ?>
		</td></tr>
		</table>
	</td></tr></table>
	<br><br><br>
  </td>
<tr><td class=lined><img src=<?=$dir?>/t.gif height=1></td></tr>
</tr>
</table>
