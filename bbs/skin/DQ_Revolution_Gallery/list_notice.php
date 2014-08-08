<?
	$subject = str_replace(">","><font class=list_han>",$subject);
	$name= str_replace(">","><font class=list_han>",$name);
	$_notice_visible = true;
	echo $memo_num;
?>

<table border=0 cellpadding=0 cellspacing=0 width=100%>
<tr>
	<td class=han><?=$hide_cart_start?><input type=checkbox name=cart value="<?=$data[no]?>"><?=$hide_cart_end?>::&nbsp;<?=$insert?><b><?=$subject?></b>&nbsp;<font class=eng style=font-size:8pt><?=$comment_num?></font>
	<?if($skin_setup['show_name']){?>&nbsp;-&nbsp;<?=$face_image?>&nbsp;<?=$name?><?}?>
	</td>
</tr>
</table>

