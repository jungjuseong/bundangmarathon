<?
// 섬네일 이미지가 가로 갯수만큼 채워지지 않았을때
	if ($_temp) {
		$temp = $skin_setup[thumb_hcount] - $_hcol;
		$_ta_width2 = $_ta_width*$temp;
		echo "<td colspan=".$temp." width=".$_ta_width2."%></td>\n";
		echo "</tr>\n<tr><td colspan='$_hcol' style='height:10px' class='thumb_area_bg'></td></tr>\n</table>\n";
	}
?>

  </td></tr>
</form>
</table>

<?if($skin_setup[using_pageNumber]) {?>
<table border=0 cellpadding=0 cellspacing=0 width=<?=$width?> class=thumb_area_bg>
<tr>
  <td class=thumb_area_bg style="padding:10 3 5 10;" align=<?=$skin_setup[pageNum_align]?>>
	<?=$bt_prev_page?> <?=$print_page?> <?=$bt_next_page?><br>
  </td>
</tr>
</table>
<? } ?>


<?if($skin_setup[using_pageNavi] || $skin_setup[using_search]) {?>
<table border=0 cellpadding=0 cellspacing=0 width=<?=$width?> class=info_bg>
<tr><td class=line2 style=height:1px></td></tr>
<tr><td class=line1 style=height:1px></td></tr>
</table>
<? } ?>

<?if($skin_setup[using_pageNavi] || $bt_write) {?>
<table border=0 cellpadding=0 cellspacing=0 width=<?=$width?> class=info_bg>
<tr><td height=5 colspan=3></td></tr>
<tr valign=top>
	<?if($skin_setup[using_pageNavi]) {?>
	<td style="padding-left:10px;">
		<nobr><?=$bt_list?><?=$bt_delete_all?><?=$bt_1_prev_page?><?=$bt_1_next_page?></nobr>
	</td>
	<? } ?>
	<?if($bt_write) {?>
	<td align=right><nobr><?=$bt_write?></a></nobr></td>
	<td style=width:10px;></td>
	<? } ?>
</tr>
</table>
<? } ?>

<?
if($skin_setup[using_search]) {?>
<table border=0 cellpadding=0 cellspacing=0 width=<?=$width?> class=info_bg>
<form method=get name=search action=<?=$PHP_SELF?>><input type=hidden name=id value=<?=$id?>><input type=hidden name=select_arrange value=<?=$select_arrange?>><input type=hidden name=desc value=<?=$desc?>><input type=hidden name=page_num value=<?=$page_num?>><input type=hidden name=selected><input type=hidden name=exec><input type=hidden name=sn value="<?=$sn?>"><input type=hidden name=ss value="<?=$ss?>"><input type=hidden name=sc value="<?=$sc?>"><input type=hidden name=su value="<?=$su?>"><input type=hidden name=category value="<?=$category?>">
<tr><td style=height:10px></td></tr>
<tr>
	<td align=right colspan=2 style="padding-right:5px;">
	<?include $_css_dir."search.php";?>
	</td>
</tr>
</form>
</table>
<? } ?>

<table border=0 cellpadding=0 cellspacing=0 width=<?=$width?>>
<tr class=info_bg><td colspan=2 height=5></td></tr>
<tr><td colspan=2 height=10></td></tr>
</table>
