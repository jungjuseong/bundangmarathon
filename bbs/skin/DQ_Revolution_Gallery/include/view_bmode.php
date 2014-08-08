<?
	if(eregi(basename(__FILE__),$PHP_SELF)) 
		die('정상적인 접근이 아닙니다');

	if($skin_setup[show_articleInfo]) {
		//  $skin_setup['using_exif'] = '';

		// 업로드된 파일 목록을 배열로 저장
		$tmp = get_uploadImages($data,'','1');
		$images = $tmp[0];
		$s_images = $tmp[1];
		$images_size = $tmp[2];
		$images_count = $tmp[3];
		$is_vdel = $tmp[is_vdel];

		// 회원프로필 사진
		if(!$skin_setup[member_picture_x] && !$skin_setup[member_picture_y]) 
			$_mb_picture_share = '1';
		if($_mb_picture_share) 
			$c_picWindth = $c_picWindth = 100; 
		else 
			$c_picWindth = $skin_setup[member_picture_x];

	  	include $dir."/include/analysis_02.php";

	  	if(file_exists($_css_dir."bg_view_title.gif")) 
			$bg_string = " background=\"".$_css_dir."bg_view_title.gif\" style=\"background-repeat:repeat-x\"";
?>
<table border=0 cellspacing=0 cellpadding=0 width=<?=$width?>>
	<tr><td height=10></td></tr>
</table>

<table border=0 cellspacing=0 cellpadding=0 width=<?=$width?> class=info_bg<?=$bg_string?>>
	<tr><td height=10></td></tr>
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
		  </tr></table>
		</td></tr>
	<tr><td height=8></td></tr>
	<tr><td class=lined><img src=<?=$dir?>/t.gif height=1></td></tr>
</table>
<?
	}//using_articleInfo
?>
