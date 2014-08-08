<?
if(eregi(basename(__FILE__),$PHP_SELF)) die('정상적인 접근이 아닙니다');

	if($skin_setup[show_articleInfo]) {

	// 업로드된 파일 목록을 배열로 저장
		$tmp = get_uploadImages($data,'','1');
		$images = $tmp[0];
		$s_images = $tmp[1];
		$images_size = $tmp[2];
		$images_count = $tmp[3];
		$is_vdel = $tmp[is_vdel];

		if(!$skin_setup[member_picture_x] && !$skin_setup[member_picture_y]) $_mb_picture_share = '1';
		if($_mb_picture_share) $c_picWindth = $c_picWindth = 100; else $c_picWindth = $skin_setup[member_picture_x];

	// 내용스크립트 치환
	    include $dir."/include/analysis_02.php";

	// 썸네일 설정
		$dqEngine['thumb_resize'] = isset($skin_setup['thumb_resize'])? $skin_setup['thumb_resize']	: 0;
?>

<table border=0 cellspacing=0 cellpadding=0 width=<?=$width?> class=info_bg>
<tr>
	<td valign=top style="padding:0 <?=$_rSwidth?> 0 <?=$_lSwidth?>">
	  <table border=0 cellpadding=0 cellspacing=0 width=100% style=table-layout:fixed>
	  <tr>
	  <?if($skin_setup[using_memberPicture]) {?>
		<td valign=top class=han width=<?=$c_picWindth?> align=right><?=$c_picture?></td>
		<td width="6"></td>
		<td class="separator2" width="3"></td>
		<td width=3></td>
	  <? } ?>
		<td valign=top nowrap style="padding-left:6px;line-height:140%;" class=han>
		  <?=$tInfo?>
		</td>
<?
if($skin_setup['using_thumbNavi'] && $enable_pn_list) {
	if($prev_data[no]||$next_data[no]) {
		if($prev_data[no]) {
			//섬네일 생성
			$prev_thumb_tag = get_thumbTag($prev_data,$skin_setup['thumb_imagex'],$skin_setup['thumb_imagey'],$dir);
			
			$prev_space = $prev_thumb_tag[0]+10;
			if ($prev_space < 80) $prev_space=80;
		}

		if ($next_data[no]) {
			//섬네일 생성
			$next_thumb_tag = get_thumbTag($next_data,$skin_setup['thumb_imagex'],$skin_setup['thumb_imagey'],$dir);

			$next_space = $next_thumb_tag[0]+10;
			if ($next_space < 80) $next_space=80;
		}
	}
	?>

		<?if ($prev_data[no]||$next_data[no]) {?>

		<td style=width:3px class=separator2></td>

		  <?if ($prev_data[no]) {?>
			  <td valign="top" width="<?=$prev_space?>" style="padding:0 5 5 5;">
			  <?=$bt_iprev?>
			  <table cellpadding=0 cellspacing=0 border=0>
				<tr><td valign=top>
				<?echo "\n<a href=$_zb_exec?$href&$sort&no=$prev_data[no] onfocus=blur()>$prev_thumb_tag[2]</a>\n</td></tr></table>"?>
				<img src=<?=$dir?>/t.gif border=0 height=2><br>
				<?if(eregi("[subj]",$tInfo) && trim($prev_data[subject]) != ".") echo "<a href=$_zb_exec?$href&$sort&no=$prev_data[no] onfocus=blur()><font class=thumb_list_title>".cut_str(stripslashes($prev_data[subject]),$setup[cut_length])."</font></a>"?>
			  </td>
		  <?}?>

		  <?if ($next_data[no]){?>
			  <td valign="top" width="<?=$next_space?>" style="padding:0 5 5 5;">
			  <?=$bt_inext?>
			  <table cellpadding=0 cellspacing=0 border=0>
				<tr><td valign=top>
				<?echo "\n<a href=$_zb_exec?$href&$sort&no=$next_data[no] onfocus=blur()>$next_thumb_tag[2]</a>\n</td></tr></table>"?>
				<img src=<?=$dir?>/t.gif border=0 height=2><br>
				<?if(eregi("[subj]",$tInfo) && trim($next_data[subject]) != ".") echo "<a href=$_zb_exec?$href&$sort&no=$next_data[no] onfocus=blur()><font class=thumb_list_title>".cut_str(stripslashes($next_data[subject]),$setup[cut_length])."</font></a>"?>
			  </td>
		  <?
		  }//다음사진?>
	
<?	}//이전사진, 다음사진
}//$enable_pn_list
?>

	  </tr></table>
	</td></tr>
</table>
<?
}//using_articleInfo

// 썸네일 설정 초기화
	unset($dqEngine['thumb_resize']);
?>