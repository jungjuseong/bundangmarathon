<? $use_view_list_skin=1; ?>

<table border=0 cellspacing=0 cellpadding=0 width=<?=$width?>>
<tr><td width=1>
<form method=post name=list action=list_all.php>
<input type=hidden name=page value=<?=$page?>>
<input type=hidden name=id value=<?=$id?>>
<input type=hidden name=select_arrange value=<?=$select_arrange?>>
<input type=hidden name=desc value=<?=$desc?>>
<input type=hidden name=page_num value=<?=$page_num?>>
<input type=hidden name=selected>
<input type=hidden name=exec>
<input type=hidden name=keyword value="<?=$keyword?>">
<input type=hidden name=sn value="<?=$sn?>">
<input type=hidden name=ss value="<?=$ss?>">
<input type=hidden name=sc value="<?=$sc?>">
</td><td width=100%>
</table>

<table border=0 cellspacing=0 cellpadding=0 width=<?=$width?>>
<col width=1></col>
<col width=50></col>
<col width=></col>
<col width=90></col>
<col width=65></col>
<col width=45></col>
<col width=1></col>
<tr align=center class=zv3_header>
<td hieght=17 widht=1 background=<?=$dir?>/img/robinweb_topbar_both.gif>
<td background=<?=$dir?>/img/robinweb_topbar.gif><table cellspacing=0 cellpadding=0><tr><td align=center><?=$a_no?><img src=<?=$dir?>/img/h_num.gif border=0></a></td></tr></table></td>
<td background=<?=$dir?>/img/robinweb_topbar.gif><table cellspacing=0 cellpadding=0><tr><td align=center><?=$a_subject?><img src=<?=$dir?>/img/h_subject.gif border=0></a></td></tr></table></td>
<td background=<?=$dir?>/img/robinweb_topbar.gif><table cellspacing=0 cellpadding=0><tr><td align=center><?=$a_name?><img src=<?=$dir?>/img/h_writer.gif border=0></a></td></tr></table></td>
<td background=<?=$dir?>/img/robinweb_topbar.gif><table cellspacing=0 cellpadding=0><tr><td align=center><?=$a_date?><img src=<?=$dir?>/img/h_date.gif border=0></a></td></tr></table></td>
<td background=<?=$dir?>/img/robinweb_topbar.gif><table cellspacing=0 cellpadding=0><tr><td align=center><?=$a_hit?><img src=<?=$dir?>/img/h_read.gif border=0></a></td></tr></table></td>
<td widht=1 background=<?=$dir?>/img/robinweb_topbar_both.gif>
</tr>
