<? // new ������ �����
        $reg_date="<span title='".date("Y�� m�� d�� H�� i�� s��", $data[reg_date])."'>".date("m/d", $data[reg_date])."</span>";
        $date=date("Y-m-d H:i:s", $data[reg_date]);
        $new = " "; 
$check_time=(time()-$data[reg_date])/60/60; 
if($check_time>24)$new.=" "; 
if($check_time<=24)$new.="<img src=../bbs/images/new.gif border=0>"; ?>

<tr align=center class=zv3_listBox onMouseOver=this.style.backgroundColor='#FBFBFB' onMouseOut=this.style.backgroundColor=''>
	<td></td>
	<?=$hide_cart_start?><td width=20><input type=checkbox name=cart value="<?=$data[no]?>"></td><?=$hide_cart_end?>
	<td class=zv3_small height=26 width=30><?=$number?></td>
	<td align=left style='word-break:break-all;'>&nbsp;<?=$insert?><?=$icon?><?=$hide_category_start?>[<?=$category_name?>] <?=$hide_category_end?><?=$subject?> <font class=zv3_comment><?=$comment_num?><?=$new?></font></td> 
	<td nowrap><?=$face_image?>&nbsp;<?=$name?></td>
	<td nowrap class=zv3_small><?=$reg_date?></td>
	<td nowrap class=zv3_small><?=$hit?></td>
	<td></td>
</tr>
<tr>
	<td colspan=<?=$colspanNum?>><img src=<?=$dir?>/line.gif width=100% height=2></td>
</tr>
