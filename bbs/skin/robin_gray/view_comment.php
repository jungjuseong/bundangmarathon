<tr>
    <td bgcolor=dddddd><img src=<?=$dir?>/img/t.gif height=1></td>
</tr>
<tr>
	<td height=3><img src=<?=$dir?>/img/t.gif border=0 hieght=3></td>
</tr>
<tr valign=top>
	<td align=left style='word-break:break-all;' class=zv3_header>
		<table border=0 cellspacing=0 cellpadding=0 width=100% class=zv3_header_inside>
		<tr>
			<td><?=$c_face_image?> <?=$comment_name?> </b><font class=zv3_small color=888888>(<?=date("Y-m-d H:i:s",$c_data[reg_date])?>)</font></td>
			<td align=right><?=$a_del?><img src=<?=$dir?>/img/btn_delete.gif border=0 valign=absmiddle></a></td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td align=left style='word-break:break-all;padding:2px'>
		<?=str_replace("\n","<br>",$c_memo)?>
	 </td>
</tr>
<tr>
	<td height=3><img src=<?=$dir?>/img/t.gif border=0 hieght=3></td>
</tr>
