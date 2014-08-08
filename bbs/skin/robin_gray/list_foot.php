</table>
<table border=0 cellspacing=0 cellpadding=0 width=<?=$width?> height=2>
<tr>
	<td height=2 class=robin_footer><img src=<?=$dir?>/img/t.gif border=0 height=2></td>
</tr>
</table>

<img src=<?=$dir?>/img/t.gif border=0 height=10><br>

<table border=0 cellpadding=0 cellspacing=0 width=<?=$width?>>
<tr valign=top>
	<td>
		<?=$a_list?><img src=<?=$dir?>/img/btn_list.gif border=0></a>
		<?=$a_delete_all?><img src=<?=$dir?>/img/btn_admin.gif border=0></a>
		<?=$a_1_prev_page?><img src=<?=$dir?>/img/btn_prev.gif border=0></a>
		<?=$a_1_next_page?><img src=<?=$dir?>/img/btn_next.gif border=0></a>
		<?=$a_write?><img src=<?=$dir?>/img/btn_write.gif border=0></a>
	</td>
	<td align=right>
		<font class=zv3_normal><?=$a_prev_page?>[이전 <?=$setup[page_num]?>개]</a></font> <?=$print_page?> <font class=zv3_normal><?=$a_next_page?>[다음 <?=$setup[page_num]?>개]</font></a><br>
		<table border=0 cellspacing=0 cellpadding=0>
		</form>
		<form method=post name=search action=<?=$PHP_SELF?>><input type=hidden name=page value=<?=$page?>><input type=hidden name=id value=<?=$id?>><input type=hidden name=select_arrange value=<?=$select_arrange?>><input type=hidden name=desc value=<?=$desc?>><input type=hidden name=page_num value=<?=$page_num?>><input type=hidden name=selected><input type=hidden name=exec><input type=hidden name=sn value="<?=$sn?>"><input type=hidden name=ss value="<?=$ss?>"><input type=hidden name=sc value="<?=$sc?>"><input type=hidden name=category value="<?=$category?>">
		<tr>
			<td>
				<a href="javascript:OnOff('sn')" onfocus=blur()><img src=<?=$dir?>/img/name_<?=$sn?>.gif border=0 name=sn></a>
				<a href="javascript:OnOff('ss')" onfocus=blur()><img src=<?=$dir?>/img/subject_<?=$ss?>.gif border=0 name=ss></a>
				<a href="javascript:OnOff('sc')" onfocus=blur()><img src=<?=$dir?>/img/content_<?=$sc?>.gif border=0 name=sc></a>&nbsp;
			</td>
			<td><input type=text name=keyword value="<?=$keyword?>" class=zv3_search size=10></td>
			<td><input type=image src=<?=$dir?>/img/btn_search.gif border=0 onfocus=blur()></td>
			<td><?=$a_cancel?><img src=<?=$dir?>/img/btn_search_cancel.gif border=0></a></td>
		</tr>
		</form>
		</table>
	</td>
</tr>
</table>
<br>
