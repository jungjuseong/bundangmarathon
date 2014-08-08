<? // new 아이콘 만들기
        $reg_date="<span title='".date("Y년 m월 d일 H시 i분 s초", $data[reg_date])."'>".date("Y/m/d", $data[reg_date])."</span>";
        $date=date("Y-m-d H:i:s", $data[reg_date]);
        $new = " "; 
$check_time=(time()-$data[reg_date])/60/60; 
if($check_time>240)$new.=" "; 
if($check_time<=240)$new.="<img src=../bbs/images/new.gif border=0>"; ?>

<tr align=center class=zv3_listBox onMouseOver=this.style.backgroundColor='#FBFBFB' onMouseOut=this.style.backgroundColor=''>
	<td></td>
	<?=$hide_cart_start?><td width=30><input type=checkbox name=cart value="<?=$data[no]?>"></td><?=$hide_cart_end?>
	<td class=zv3_small height=26 width=50><?=$number?></td>
	<td align=left style='word-break:break-all;'>&nbsp;<?=$insert?><?=$icon?><?=$hide_category_start?>[<?=$category_name?>] <?=$hide_category_end?><b><?=$subject?> <font class=zv3_comment><?=$comment_num?></font></b></td> 
	<td nowrap><?=$face_image?>&nbsp;<?=$name?></td>
	<td nowrap class=zv3_small><?=$reg_date?></td>
	<td nowrap class=zv3_small><?=$hit?></td>
	<td></td>
</tr>
<tr>
	<td colspan=<?=$colspanNum?>><img src=<?=$dir?>/img/line.gif width=100% height=2></td>
</tr>
