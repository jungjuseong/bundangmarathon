<table border=0 cellspacing=0 cellpadding=0>
<tr>
	<td><nobr>
		<a href="javascript:dq_OnOff('sn','<?=$_css_dir?>')" onfocus=blur()><img src=<?=$_css_dir?>name_<?=$sn?>.gif border=0 name=sn></a>&nbsp;
		<a href="javascript:dq_OnOff('ss','<?=$_css_dir?>')" onfocus=blur()><img src=<?=$_css_dir?>subject_<?=$ss?>.gif border=0 name=ss></a>&nbsp;&nbsp;
		<a href="javascript:dq_OnOff('sc','<?=$_css_dir?>')" onfocus=blur()><img src=<?=$_css_dir?>content_<?=$sc?>.gif border=0 name=sc></a>&nbsp;&nbsp;
		</nobr>
	</td>
	<td><input type=text name=keyword value="<?if($su!="on") echo $keyword?>" size=15 class='input'></td>
	<td><input type=image src=<?=$_css_dir?>bt_search.gif onFocus="blur()"></td>
	<td><img src=<?=$_css_dir?>bt_cancel.gif onclick="location.href='zboard.php?id=<?=$id?>'" style="cursor:pointer"></td>
</tr>
</table>
