<?
$_comment_grant_guide = $comment_grant_element ? implode(', ',$comment_grant_element) : '';
if(!$skin_setup[using_comment] || !$comment_count) $skin_setup[using_bodyBtTool2] = '';

if($limitCommentOFF || ($skin_setup[using_comment] && $_comment_grant_guide && $member['level']>$setup['grant_comment'])) { ?>
	<table border=0 cellspacing=0 cellpadding=5 height=5 width=<?=$width?>>
	<tr><td style=height:15px class=info_bg></td></tr>
	<tr><td class=lined style='padding:0px'><img src=<?=$dir?>/t.gif width=1 height=1></td></tr>
	<tr class=info_bg>
	  <td align=center style='padding:10 <?=$_rSwidth?> 8 <?=$_lSwidth?>'>
		<font class=han2>의견(코멘트)을 작성하실 수 없습니다.</font><font class=han> 이유: <?=$_comment_grant_guide?></font>
	  </td>
	</tr>
	</table>
<?
} elseif($skin_setup[using_bodyBtTool2]) {?>
	<table border=0 cellspacing=0 cellpadding=0 height=1 width=<?=$width?> class=info_bg>
	<tr><td style=height:10px></td></tr>
	</table>
<?
}
?>

<?if($skin_setup[using_bodyBtTool2] || ($enable_pn_list && ($prev_data[no]||$next_data[no]))) {?>
	<table width=<?=$width?> cellspacing=0 cellpadding=0 class=info_bg>
	<tr><td class=lined style=height:1px><img src=<?=$dir?>/t.gif height=1></td></tr>
	</table>
<? } ?>

<?if($skin_setup[using_bodyBtTool2]) { ?>
	<table width=<?=$width?> cellspacing=0 cellpadding=0 class=info_bg>
	<tr><td colspan=4 height=3></td></tr>
	<tr>
	 <td width=<?=$_lSwidth?>><img src=<?=$dir?>/t.gif width=<?=$_lSwidth?> height=1>
	 <td height=30>
		<?=$bt_reply?><?if($is_admin || !$is_vdel) {?><?=$bt_modify?><?=$bt_delete?><?}?>
		<?if($using_vote) {?><?=$bt_vote?><?}?>
	 </td>
	 <td align=right>
		<?=$bt_list?><?=$bt_write?>
	 </td>
	 <td width=<?=$_rSwidth?>><img src=<?=$dir?>/t.gif width=<?=$_rSwidth?> height=1>
	</tr>
	</table>
<? } ?>

<?if($skin_setup['using_bmode'] && $enable_pn_list && ($prev_data[no]||$next_data[no])) {?>
	<table border=0 cellspacing=0 cellpadding=0 width=<?=$width?> class=info_bg>
	<tr><td height=10></td></tr>
	<?
	if($prev_data[no]) echo "<tr><td class=han style='padding:0 0 5 10'>$bt_iprev: <a href=$_zb_exec?$href&$sort&no=$prev_data[no] onfocus=blur()><font class=han2>".cut_str(stripslashes($prev_data[subject]),$setup[cut_length])."</font></a></td></tr>";
	if($next_data[no]) echo "<tr><td class=han style='padding:0 0 5 10'>$bt_inext: <a href=$_zb_exec?$href&$sort&no=$next_data[no] onfocus=blur()><font class=han2>".cut_str(stripslashes($next_data[subject]),$setup[cut_length])."</font></a></td></tr>";
	?>
	</table>
<? } ?>

<?if(!$setup[use_alllist]) { ?>
	<table border=0 cellspacing=0 cellpadding=0 width=<?=$width?>>
	<tr><td style=height:10px></td></tr>
	</table>
<? } ?>
