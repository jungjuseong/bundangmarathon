<?
if(!file_exists(getcwd().'/zboard.php')) die('�������� ������ �ƴմϴ�.');

//��Ų ȯ�漳�� �о��
	include $dir."/get_config.php";

	include $dir."/".$skin_setup['language_dir']."login.php";

?>

<table width=<?=$setup[table_width]?> border=0 cellpadding=0 cellspacing=0 class=info_bg>
<tr><td align=center><br><br><br>
<table border=0 width=300 height=1 cellspacing=0 cellpadding=0 align=center>
</table>
	<table border=0 width=300>
	<col width=100 style=padding-right:10px></col><col width=></col>
	<tr><td colspan=2 class=lined style='height:1px;padding:0px'><img src=<?=$dir?>/t.gif height=1></td></tr>
	<tr>
	  <td align=center colspan=2 height=27><?=$_strSkin['title']?></td>
	</tr>
	<tr><td colspan=2 class=lined style='height:1px;padding:0px'><img src=<?=$dir?>/t.gif height=1></td></tr>
	<tr><td colspan=2 height=10></td></tr>
	<tr>
	  <td align=right height=26><?=$_strSkin['id']?></td>
	  <td align=left><input type=text name=user_id size=20 maxlength=20 class=input style=width:120></td>
	</tr>
	<tr>
	  <td align=right height=26><?=$_strSkin['password']?></td>
	  <td align=left><input type=password name=password size=20 maxlength=20 class=input style=width:120></td>
	</tr>
	</table>
	<br>
	<div align=center><input type=submit value="<?=$_strSkin['ok']?>" class=submit> <input type=button class=button value="<?=$_strSkin['cancel']?>" onclick=history.back()></div>
	<br><br>
<table border=0 width=300 height=1 cellspacing=0 cellpadding=0 align=center>
</table>
<br><br><br>
</td>
</tr>
<tr><td class=lined style=height:1px><img src=<?=$dir?>/t.gif height=1></td></tr>
</table>
</div>
<div align=right style=width:<?=$setup[table_width]?>>
