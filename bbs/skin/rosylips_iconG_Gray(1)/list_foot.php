<table border=0 cellspacing=0 cellpadding=0 width=<?=$width?> height=2>
<tr>
    <td  colspan=6 class=rfootline></td>
</tr>
</table>

<img src=<?=$dir?>/t.gif border=0 height=10><br>

<table border=0 cellpadding=0 cellspacing=0 width=<?=$width?>>
<tr valign=top>
	<td>
		<?=$a_delete_all?><img src=<?=$dir?>/btn_delete.gif border=0></a>
	</td>
            <td><span style='color:#FFFFFF'>r&nbsp;o&nbsp;s&nbsp;y&nbsp;l&nbsp;i&nbsp;p&nbsp;s&nbsp;</span></td>
	<td align=right>
		<?=$a_prev_page?><img src=<?=$dir?>/btn_prev.gif border=0></a>
		<?=$print_page?>
		<?=$a_next_page?><img src=<?=$dir?>/btn_next.gif border=0></a>

		<table border=0 cellspacing=1 cellpadding=0>
		</form>
		<form method=post name=search action=<?=$PHP_SELF?>>
		<input type=hidden name=page value=<?=$page?>>
		<input type=hidden name=id value=<?=$id?>>
		<input type=hidden name=select_arrange value=<?=$select_arrange?>>
		<input type=hidden name=desc value=<?=$desc?>>
		<input type=hidden name=page_num value=<?=$page_num?>>
		<input type=hidden name=selected><input type=hidden name=exec>
		<input type=hidden name=sn value="on">
		<input type=hidden name=ss value="on">
		<input type=hidden name=sc value="on">
		<input type=hidden name=category value="<?=$category?>">
                        <tr height=10>
                           <td colspan=<?=$colspanNum?>></td>
                        </tr>

		<tr>
			<td><input type=text name=keyword value="<?=$keyword?>" class=rsearch size=10></td>
			<td><input type=image src=<?=$dir?>/btn_search.gif border=0 onfocus=blur()></td>
			<td><?=$a_cancel?><img src=<?=$dir?>/btn_search_cancel.gif border=0></a></td>
		</tr>
		</form>
		</table>
	</td>
</tr>
</table>
