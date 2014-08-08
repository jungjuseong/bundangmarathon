<?
if(eregi(basename(__FILE__),$PHP_SELF)) die('정상적인 접근이 아닙니다');

// 썸네일 설정
//	$dqEngine['thumb_resize'] = isset($skin_setup['thumb_resize'])? $skin_setup['thumb_resize']	: 0;

// id 생성
	$cidno++;

	if($skin_setup[using_comment]) {

		$cetime = time()-(60*$skin_setup['using_commentEditor2']);
		if($skin_setup[using_commentEditor] && $c_data[reg_date] > $cetime) $a_edit = "<span onclick=\"comment_edit(event,cid$cidno,'$c_data[no]',document.body.scrollTop)\" style='cursor:pointer'>[편집]</span>";

		include $dir."/".$skin_setup['language_dir']."comment.php";
		$comment_count++;

		$comment_name = str_replace(">".$c_data[name],"><font class=view_name>".$c_data[name]."</font>",$comment_name)."</b>";
		//if($is_admin) $show_comment_ip = "<font class=eng>".$c_data['ip']."</font>";
		//else $show_comment_ip = "";

	// 코멘트 작성자의 프로필 사진 가져오기
		$memberPicture = get_memberPicture($c_data[ismember], $dir."/$skin_setup[css_dir]",$skin_setup[member_picture_x],$skin_setup[member_picture_y]);

/*
echo "<script>alert('";
echo $dir."/".$skin_setup['language_dir']."comment.php\n";
echo $id." ".$c_data[ismember]." ".$dir."/$skin_setup[css_dir] $skin_setup[member_picture_x] $skin_setup[member_picture_y]\n";
echo "memberPicture=$memberPicture";
echo "');</script>";
*/
		if($memberPicture) {
			$c_picture = "<img src=$memberPicture border=0>"; 
//echo "picture(yy)=".$c_picture;
		}else{
			$c_picture="<img src=$dir/$skin_setup[css_dir]"."no_face.jpg border=0>";
//echo "picture(nn)=".$c_picture;
		}
		  // if insert by yhkim
		if($c_data[ismember] != 0 and substr_count($c_picture,"photo_no_face")>0){
			$c_picture = c_picture_member($c_data[ismember], $c_picture);
		}
//		
		if($_mb_picture_share) $c_picWindth = $c_picWindth = 100; else $skin_setup[member_picture_x];
		?>

		<table border=0 width=<?=$width?> cellspacing=0 cellpadding=0 class=info_bg style=table-layout:fixed>
		<tr>
		 <td style="padding:0 <?=$_lSwidth?> 0 <?=$_rSwidth?>">

			<?if($comment_count == "1") { ?>
			<table border=0 cellspacing=0 cellpadding=0 width=100%>
			<tr><td height=5 class=info_bg></td></tr>
			<tr><td height=1 class=separator1></td></tr>
			<tr><td height=4 class=info_bg></td></tr>
			</table>
			<? } ?>
			<table border=0 width=100% cellspacing=0 cellpadding=0 class=info_bg style="table-layout:fixed;">
			<tr valign="top">
			  <?if($skin_setup[using_memberPicture]) {?>
				<td width=<?=$c_picWindth?> align=right><?=$c_picture?></td>
				<td class="info_bg" width="6"></td>
				<td class="separator2" width="3"></td>
				<td width=3></td>
			  <? } ?>
				<td style="padding:2 4 4 5;word-break:break-all;">
				  <?=$c_face_image?> <?=$comment_name?></b><br>
				  <div id=cid<?=$cidno?> class=han style="line-height:160%"><?=str_replace("\n","<br />",$c_memo)?></div>
				</td>
				<td align=right width=80 style=padding-top:2px>
					<font class=eng><?=date("Y-m-d",$c_data[reg_date])?><br><?=date("H:i:s",$c_data[reg_date])?></font>
					<?if(!ereg("<Zeroboard ",$a_del)) {?><br><?=$bt_cdel?><?if($member[no]&&($is_admin||$member[no]==$c_data[ismember])) echo $a_edit?><?}?>
				</td>
			</tr>
			</table>
			<?if($comment_count < $data[total_comment]) { ?>
			<table border=0 cellspacing=0 cellpadding=0 height=15 width=100%>
			<tr><td height=10 class=info_bg></td></tr>
			<tr><td height=1 class=separator1></td></tr>
			<tr><td height=4 class=info_bg></td></tr>
			</table>
			<? } ?>
		 </td>
		</tr>
		</table>

<?
	}
	$dqEngine['thumb_resize'] = '';
?>
