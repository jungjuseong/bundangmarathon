<!-- DQ_Revolution/list_main.php begin -->
<?
	if(!file_exists(getcwd().'/zboard.php')) die("정상적인 접근이 아닙니다.");

// 코멘트 재설정
	$css = (get_newComment($data[no]))? 'list_comment2' : 'list_comment';
	$comment_num = ($comment_num) ? '<font class='.$css.'> '.$data[total_comment].' </font>' : '';
	//$comment_num = ($comment_num) ? "&nbsp;<font class=list_comment>$comment_num</font>" : '';

// 제목 재설정
	$chk_subj	= cut_str($data[subject],$setup[cut_length]);
	$subject	= str_replace(" >$chk_subj"," ><font class=thumb_list_title>$chk_subj</font>",$subject);

// 재설정
	$category_name = "<font class=thumb_list_cate>".$category_name;
	$name = str_replace('>'.$data[name].'<','><font class=thumb_list_name style=font-weight:normal>'.$data[name].'</font><',$name);

	if(!$setup[use_alllist]) $_zb_exec="view.php"; else $_zb_exec="zboard.php";
	//$subject = $subject."</font></b>";

	if($_notice_visible) {
		echo "<img src=$dir/t.gif border=0 height=10>\n";
		$_notice_visible = false;
	}
	if($su=="on" && $keyword) {
		$show_name_old=$skin_setup['show_name'];
		$skin_setup['show_name']=false;
	}

	unset($thumb_x);
	unset($thumb_y);

	$_xx++;
	$_hcol++;

	$_temp = ($_xx) % $skin_setup['thumb_hcount'];

	if($skin_setup['thumb_hcount'] == '1') $_temp = '1';

	if ($_temp==1) {?>
	<table border=0 cellpadding=0 cellspacing=0 width=100%>
	  <tr>
<?}

	if($skin_setup['thumb_hcount'] == '1') $_temp = '0';

// 썸네일 설정
	$dqEngine['thumb_resize'] = isset($skin_setup['thumb_resize'])? $skin_setup['thumb_resize']	: 0;

// 섬네일 생성
	$thumb_tag = get_thumbTag($data,$skin_setup['thumb_imagex'],$skin_setup['thumb_imagey'],$dir);
	$thumb_frame = $skin_setup['thumb_frame_width'];
	$thumb_bPadding = ($thumb_frame == 1)? 0 : $thumb_frame;
	if($thumb_frame) {
		//$border_tag = "<div class='thumb_frame' style='width:$thumb_tag[0];height:$thumb_tag[1]; padding:".$thumb_bPadding."px'>[THUMB_TAG]</div>\n";
		$border_tag = "<div class='boxSep'><div class='imgLiquidFill imgLiquid' style='width:120px;height:80px; padding:3px'>\n\t\t[THUMB_TAG]\n</div></div>\n";
	}

// 섬네일이 들어가는 셀의 크기계산
	$_ta_width = 100/$skin_setup['thumb_hcount'];

// 섬네일 세로정렬에 따른 셀 높이 계산
	if($skin_setup[thumb_valign] != "top") $th_height = $skin_setup[thumb_imagey]+2+$add_bPixel+($thumb_bPadding*2);

// 섬네일 정렬에 따른 여백 계산
	if($skin_setup['thumb_align'] == 'left') 
		$_thumb_area_padding = "padding-right:10px;";
	if($skin_setup['thumb_align'] == 'right') 
		$_thumb_area_padding = "padding-left:10px;";
	if($skin_setup['thumb_align'] == 'center') 
		$_thumb_area_padding = "padding-left:10px;padding-right:10px;";

// 새 창으로 띄우기 위한 원본 이미지파일 결정
	if($skin_setup[using_newWindow]) {
		if(!$_zb_url) $_zb_url = str_replace(basename($PHP_SELF),"",$PHP_SELF);

	// 업로드된 이미지 목록가져오기
		$tmp = get_uploadImages($data,1);
		if($tmp[0][0]) $tfile = $_zb_url.$tmp[0][0]; else $tfile = "";

	// 업로드파일이 없을경우 HTML태그 분석
		if(!$tfile) {
			$tfile = get_imgTag($data[memo]);
			$tfile = get_urlPath($tfile[0]);
			$tfile = str_replace("&","dq_amp_temp",$tfile);
		}

		// 이미지 파일을 못찾았을때
		if(!$tfile) 
			$_thumbnail_tag = $thumb_tag[2];
		// 이미지 파일을 찾았을때
		else 
			$_thumbnail_tag = "<a href=# onclick=\"view_img('$tfile','$data[ismember]','$dir','$id')\">\n\t\t$thumb_tag[2]\n</a>\n\t\t";

	} 
	else {
		if($setup[grant_view]<$member[level]&&!$is_admin) 
			$_thumbnail_tag = "<a href=# onClick=\"alert('".$_strSkin[is_secret]."')\" onfocus=blur()>\n\t\t$thumb_tag[2]\n</a>\n\t\t";
		else 
			$_thumbnail_tag = "<a href=$_zb_exec?$href&$sort&no=$data[no] onfocus=blur()>\n\t\t$thumb_tag[2]\n\t\t</a>\n";
	}

	if($thumb_frame) {
		$_thumbnail_tag = str_replace('[THUMB_TAG]',$_thumbnail_tag,$border_tag);
	}
?>
	<td width="<?=$_ta_width?>%" valign="top">
	  <table border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed;" width="100%">
		  <tr><td style="<?=$_thumb_area_padding?>" height="<?=$th_height?>" align="<?=$skin_setup['thumb_align']?>" valign="<?=$skin_setup['thumb_valign']?>">
			<?=$_thumbnail_tag?></td>
		  </tr>
	<?
		if($skin_setup[show_thumbInfo]) {
		  include $dir."/include/analysis_01.php";
	?>
		  <tr align=<?=$skin_setup['thumb_align']?>>
			<td style="padding-top:6px;line-height:120%;<?=$_thumb_area_padding?>">
			<?=$tInfo?>
			</td></tr>
	<? } ?>

		  </table>
		</td>
	<?if (!$_temp) {?>
	  </tr>
	  <tr><td colspan=<?=$_hcol?> height=30 class=thumb_area_bg></td></tr>
	</table>
	<?$_hcol=0;?>
	<?
	  }

	if($su=="on" && $keyword) {
		$skin_setup['show_name']=$show_name_old;
	}

// 썸네일 설정
	$dqEngine['thumb_resize'] = '';
?>
<!-- DQ_Revolution/list_main.php end -->
