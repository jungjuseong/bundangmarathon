<!-- DQ_Revolution/view_gallery.php begin -->
<?
	if(!file_exists(getcwd().'/zboard.php')) 
		die('정상적인 접근이 아닙니다.');

	$view_once = true;
	include $dir."/".$skin_setup['language_dir']."view.php";

	// EXIF 추출기 불러오기
	if($skin_setup['using_exif'] && is_file($dir."/plug-ins/exif_info.php")) 
		include $dir."/plug-ins/exif_info.php";

	// 설정
	//$ip = str_replace("IP Address : ","&nbsp;ip:",$ip);
	if (!$use_alllist) 
		$_zb_exec="view.php"; 
	else 
		$_zb_exec="zboard.php";

	if(!$face_image) 
		$face_image = str_replace('<div align=left>','',$face_image);

	$this_name = $face_image.str_replace('>'.$data[name],'><font class=view_name>'.$data[name].'</font>',$name).'</b>';
	$this_name = "<span title=\"$ip\">$this_name</span>";

	if($homepage) 
		$homepage = " * ".str_replace(">","><font class=eng></b>",$homepage);

	if($skin_setup['using_market'] && !$is_admin) 
		$bt_delete = '';

	$picarea_vspace = ($skin_setup['using_newspaperMode'] || $skin_setup['using_newspaperMode2'])? $skin_setup[pic_vSpace] : '0';
	$pic_rspace     = ($skin_setup['using_newspaperMode'] || $skin_setup['using_newspaperMode2'])? '10' : '0';

	if($bt_delete) {
	   $tmp=mysql_fetch_array(mysql_query("select file_names from dq_revolution where zb_id='$id' and zb_no='$no'"));
	   if(eregi('data2/',$tmp[file_names])) 
			$bt_delete = str_replace('delete.php','revolg_delete.php',$bt_delete);
	}

	// 코멘트관련 날짜 검사
	if($skin_setup['using_limitComment'] && $skin_setup['using_limitComment2']) {
		$limitday = $skin_setup['using_limitComment2'];
		$time_count = time()-(60*60*24*$limitday);
		if(date('Ymd',$data[reg_date]) < date('Ymd',$time_count)) {
			$limitCommentOFF = 1;
			$comment_grant_element[] = $limitday.'일 이상 지난 게시물';
			$bt_vote = ''; //추천버튼 제거
		}
	}

	// 코멘트 관련 설정
	if($member['level'] > $setup['grant_comment']) 
		$comment_grant_element[] = '권한이 없는 회원레벨';

	//	if(!$member[no] && $setup['grant_comment'] < 10) $comment_grant_element[] = '비회원';
	if($skin_setup['using_cmOwnerOnly'] && !$is_admin && $data[ismember] && $member[no] != $data[ismember]) {
		$limitCommentOFF = 1;
		$comment_grant_element[] = '게시물 작성자 혹은 관리자가 아님';
	}		

	// 추천 날짜 검사
	if($skin_setup['poll_day']) {
		$start_day = mktime(0 ,0 ,0 ,$skin_setup['poll_day2'],$skin_setup['poll_day3'],$skin_setup['poll_day1']);
		$end_day   = mktime(23,59,59,$skin_setup['poll_day5'],$skin_setup['poll_day6'],$skin_setup['poll_day4']);
		if(time() < $start_day || time() > $end_day) {
			$skin_setup['using_vote'] = '';
			$bt_vote = ''; //추천버튼 제거
		}
	}

	// 이미지 다운로드 제한 판단
	if($data[ismember]==$member[no] || ($member[no] && $member[level] <= $skin_setup[mrbt_passLevel]) ||($member[no] && $member[is_admin] < 3)) {
		$skin_setup['mrbt_clickLimit'] = '';
	}

	// 본문 좌,우측 여백지정 변수를 짧게 줄임
	$_lSwidth = $skin_setup[view_lSwidth];
	$_rSwidth = $skin_setup[view_rSwidth];

	// 마우스 오픈쪽 버튼 제한기능
	if($skin_setup[mrbt_clickLimit]) 
		include $dir."/plug-ins/limit_mrbt.php";

	// 본문 내에 이미지 태그가 있는지 검사하고 처리
	if(eregi("<img |\[img ", $memo)) 
		include $dir.'/include/chk_linkimage.php';

	// 이전글과 이후글의 데이타를 구함;
	if(!$setup[use_alllist] && $desc != "desc") $enable_pn_list=true; else $enable_pn_list=false;
	if($select_arrange && $select_arrange!="headnum") $enable_pn_list=false;
	
	if($enable_pn_list && $s_que) {
			$prev_data=@mysql_fetch_array(mysql_query("select * from $t_board"."_$id $s_que and no > '$data[no]' order by no asc limit 0,1"));
			$data[prev_no] = ($prev_data[no] ? $prev_data[no] : '');
			$next_data=@mysql_fetch_array(mysql_query("select * from $t_board"."_$id $s_que and no < '$data[no]' order by no desc limit 0,1"));
			$data[next_no] = ($next_data[no] ? $next_data[no] : '');
	}

	// 글 작성자의 프로필 사진 가져오기
	if(!$skin_setup[member_picture_x] && !$skin_setup[member_picture_y]) 
		$_mb_picture_share = '1';

	if($_mb_picture_share) 
		$c_picWindth = $c_picWindth = 100; 
	else 
		$c_picWindth = $skin_setup[member_picture_x];

	$memberPicture = get_memberPicture($data[ismember], $dir.'/'.$skin_setup[css_dir], $skin_setup[member_picture_x], $skin_setup[member_picture_y]);
	if($memberPicture) 
		$c_picture = "<img src=$memberPicture border=0>"; 
	else 
		$c_picture="<img src=$dir/$skin_setup[css_dir]"."no_face.jpg border=0>";

	// if insert by yhkim
	if($data[ismember] != 0 and substr_count($c_picture,"photo_no_face")>0){
		$c_picture = c_picture_member($data[ismember], $c_picture);
	}
	if($skin_setup['using_vote'] && $skin_setup[vote_type] == "1" &&  $member['no'] != $data[ismember]) $using_vote = true;

	// 추천인 목록 가져오기
	$vote_users = get_voteUsers($id,$no,1);

	// 제목 아래의 여백 계산
	$_subject_vSpace = intval($skin_setup[pic_vSpace]);

	// 게시물 정보 출력(상단)	
	if($skin_setup[using_bmode]) 
		include $dir."/include/view_bmode.php";

	// 업로드된 이미지 목록을 배열로 저장
	if(!$is_vdel) {
		unset($tmp);
		$tmp			= get_uploadImages(&$data);
		$is_vdel		= $tmp[is_vdel];
		if(!$is_vdel) {
			$images			= $tmp[0];
			$s_images		= $tmp[1];
			$images_size	= $tmp[2];
			$images_count	= $tmp[3];

			if(!$images_count && $skin_setup['using_newspaperMode']) $skin_setup['using_newspaperMode'] = '';
		}
	}

// 가상으로 삭제되었을 경우
	if(!$is_admin && $is_vdel) {
		$new_memo = "<br><br><br>----- 운영자에 의해 삭제된 게시물입니다.-----<br><br><br>";
		$new_memo = "<table border=0 cellspacing=0 cellpadding=0 width=100% style=\"table-layout:fixed;\"><col width=100%></col><tr><td valign=top>".$new_memo."</table><br>";
		if($is_admin) $memo = $new_memo.$memo;
		else $memo = &$new_memo;
	}


// 업로드파일 설명 가져옴
	if($images) $file_descript = get_fileDescript($id, $no);
?>

<script type="tex/javascript">
	var str_saveComment = "<?=$_strSkin[save_comment]?>";
</script>

<?if ($skin_setup['show_subj'] && $data[subject] != "." && !$skin_setup['using_newspaperMode']) {
	if(!$images && !$_linkImage) $skin_setup['pic_align'] = 'left'; ?>

<table border=0 cellspacing=0 cellpadding=0 width=<?=$skin_setup['pic_width']?> class=pic_bg>
<tr>
	<td style="padding:15 <?=$_rSwidth?> 0 <?=$_lSwidth?>;" align=<?=$skin_setup['pic_align']?> class=view_title>
		<?=$subject?>
	</td>
</tr>
</table>
<?}?>

<!-- begin images -->
<table id=revolution_main_table border=0 cellspacing=0 cellpadding=0 width=<?=$skin_setup['pic_width']?> class=pic_bg>
<tr>
  <td height=<?=$_subject_vSpace?>>
<?
// 셔터 효과음
	if($skin_setup['using_shutter']) mmplay($dir."/".$skin_setup[css_dir]."camera_sound.swf",'shutter',1);

// 배경음악 재생
	$tmp = '1';
	if($skin_setup[bgmPlayerLevel] && ($skin_setup[bgmPlayerLevel] < $member[level] || !$member[no])) $tmp = '0';
	if(is_mediafile($data[sitelink1]) && $tmp) mmplay($data[sitelink1],"mmp");
	else $skin_setup[using_bgmPlayer] = '';
?>
  </td>
</tr>
<?if($is_admin && $is_vdel) {?>
<tr>
	<td style="padding:15 <?=$_rSwidth?> 20 <?=$_lSwidth?>;" align=<?=$skin_setup['pic_align']?> class=han2>
	----- 운영자에 의해 삭제된 게시물입니다. 아래 내용은 운영자에게만 보입니다. ----
	</td>
</tr>
<?}?>
</table>

<?if($is_admin || !$is_vdel) {?>
<table border=0 cellspacing=0 cellpadding=0 width=<?=$skin_setup['pic_width']?> class=pic_bg>
<tr>
  <td>
<?
// 이미지 출력
	if($images){?>
	<table border=0 cellspacing=0 cellpadding=0 width=100%>
	<tr class=pic_bg>
	  <td align=<?=$skin_setup['pic_align']?> style="padding:0 <?=$_rSwidth?> <?=$picarea_vspace?> <?=$_lSwidth?>;">

	  <?
	  if($skin_setup[using_picBorder]) $_border = "class=\"pic_border\" "; else $_border="border=\"0\" ";
	  if(get_StrValue($data[sitelink2],1) && $data[file_name1]) {
		  $_startimage=1;
		  $skin_setup['using_newspaperMode'] = ''; // 첫번째 이미지가 썸네일로 쓰였을때는 1번 이미지 뉴스보기 모드 해제
	  } else $_startimage = 0;

	  if(phpversion() < '4.2.0') $_resize_text1 = " name=zb_target_resize style=\"cursor:pointer\" onclick=window.open(this.src) galleryimg=\"no\"";
	  else $using_autoResize_text = " name=\"dq_resized_image\" galleryimg=\"no\"";

	  for($i=$_startimage;$i<count($images); $i++) {
		$count++;
		$_total_view = count($images) - $_startimage;

		$img_info=@getimagesize($images[$i]);

		if($skin_setup[using_autoResize] && $img_info[0] > $skin_setup[pic_overLimit1]) {
			$_size = cal_thumb_size($images[$i],$skin_setup[pic_overLimit2],0);
			$_size = "width=\"$_size[0]\" height=\"$_size[1]\"";
			$_resize_text1 = $using_autoResize_text." style='cursor:pointer' onclick=view_img(this.src)";
		} else 
			$_size = "width=\"$img_info[0]\" height=\"$img_info[1]\"";

	// 파일 설명을 출력할것인지 결정
		if($file_descript[$images_count[$i]] && eregi("[use]",$file_descript[$images_count[$i]]) && str_replace("[use]","",$file_descript[$images_count[$i]]) != "") 
			$show_descript = "1"; else $show_descript = "";
		if($show_descript) 
			$img_vspace = $skin_setup[pic_vSpace] /2; 
		else 
			$img_vspace = $skin_setup[pic_vSpace];

	// 이미지 파일이 두개 이상일때는 설명앞에 번호를 붙인다.
		//if($_total_view<2) $img_count=""; else $img_count=$count.". ";
		if($show_descript) {
			$descript[$images_count[$i]] = str_replace("[use]","",stripslashes(nl2br($file_descript[$images_count[$i]])));
			if($descript[$images_count[$i]]) 
				$descript_print = "<font class=han style=\"line-height:180%\">".$img_count.$descript[$images_count[$i]]."</font><br /><br />";
			$newspapermode2 = ($skin_setup['using_newspaperMode2'] && $descript[$images_count[$i]])? '1':'';
			if($newspapermode2) {
				$img_align = 'align="left" ';
				$br_tag = '';
			} 
			else {
				$img_align = ''; 
				$br_tag = '<br/>' ;
			}

			if($skin_setup['using_newspaperMode'] && $i == 0 && $newspapermode2) 
				$skin_setup['using_newspaperMode'] = '';
		} 
		else 
			$newspapermode2 = '';

	// 신문보기 모드
	    if(!count($images)) 
			$skin_setup['using_newspaperMode'] = '';
		if($skin_setup['using_newspaperMode'] && $i == 0) 
			$img_align = 'align="left" ';
		elseif(!$newspapermode2) {
			$img_align = ''; 
			$br_tag = '<br/>';
		}

	// 이미지 출력
        echo '<img src="'.dq_urlencode($images[$i]).'"'.$_resize_text1.' '.$limit_menu.' '.$_size.' galleryimg="no" '.$img_align.$_border.'style="margin:0 '.$pic_rspace.' '.$img_vspace.' 0;">'.$br_tag."\n";

		if($skin_setup['using_newspaperMode'] && $i == 0) {
			if($skin_setup['show_subj'] && $data[subject] != ".") 
				echo "<div style='line-height:180%'><span class=view_title2>< $subject ></span><br/>\n";
			echo trim(stripslashes($data[memo]))."<br/><br/></span>";
		}
		if($newspapermode2) 
			echo $descript_print;

	// 파일설명 출력(본문내용의 폭 크기와 정렬방식을 따른다)
		if($show_descript && !$newspapermode2) {?>
			<table border=0 cellspacing=0 cellpadding=0 width=<?=$skin_setup['memo_width']?>>
			<tr class=pic_bg>
			  <td style="padding:0 0 <?=$skin_setup[pic_vSpace]?> 0;" align=<?=$skin_setup['memo_align']?>>
			  <?echo $descript_print?>
			  </td>
			</tr>
			</table>
	  <?}
		if($skin_setup['using_newspaperMode'] || $skin_setup['using_newspaperMode2']) echo "</td></tr></table><table border=0 cellspacing=0 cellpadding=0 width=100%><tr class=pic_bg><td align=$skin_setup[pic_align] style='padding:0 $_rSwidth $picarea_vspace $_lSwidth;'>";
	  }//for ?>
	</td></tr></table>
<? } ?>

  </td>
</tr>
</table>
<?}?>

<!-- 본문 글 출력 -->

<?if ($data[memo] != "." && !$skin_setup['using_newspaperMode']) {
// 본문내용 출력을 재정의
	if(!$images && !$_linkImage[0]) {
		$skin_setup[memo_width] = '100%';
		$skin_setup[memo_align] = 'left';
	}
	if(ereg("<table border=0",$memo)){
		$memo = str_replace("<table border=0 cellspacing=0 cellpadding=0 width=100% style=\"table-layout:fixed;\"><col width=100%></col><tr><td valign=top>","<table border=0 cellspacing=0 cellpadding=0 width=$skin_setup[memo_width] style=\"table-layout:fixed;\" align=$skin_setup[pic_align]>\n<tr>\n<td align=$skin_setup[memo_align] valign=top class=han style=line-height:165%>\n",$memo);
		$memo = str_replace("</table>","</td></tr></table>",$memo);
	} else {
		$memo = "<span class=han style=line-height:165%>".$memo."</span>";
	}?>

	<table border=0 cellspacing=0 cellpadding=0 width=<?=$skin_setup['pic_width']?> class=pic_bg>
	<tr>
	  <td style="padding:0 <?=$_rSwidth?> 0 <?=$_lSwidth?>;" align=<?=$skin_setup['memo_align']?>><?=$memo?></td>
	</tr>
	<tr><td height=15></td></tr>
	</table>
<? } ?>

<!-- 본문 글 끝 -->

<?if($skin_setup[using_bgmPlayer] && is_mediafile($data[sitelink1])) {
	$music_info = get_musicinfo($data[sitelink1]);
	if($music_info[1]) $_tpadding = "0"; else $_tpadding = "10";
?>
<!-- BGM 플레이어 -->
<table border=0 cellspacing=0 cellpadding=0 width=<?=$skin_setup['pic_width']?>>
<?if($music_info[1]) {?>
<tr><td align=right style="font-family:바탕;font-size:8pt;padding:10 <?=$_rSwidth?> 0 <?=$_lSwidth?>;"><?=stripslashes($music_info[1])?></td></tr>
<? } ?>
<tr><td class=pic_bg align=right style="padding:<?=$_tpadding?> <?=$_rSwidth?> 5 <?=$_lSwidth?>;">
  <font class=mmp>[&nbsp;<b>BGM</b>:&nbsp;</font>
  <span style=cursor:pointer onClick="javascript:mmp.play();" class=mmp><b>P</b>lay</span>&nbsp;&nbsp;<span style=cursor:pointer onClick=mmp.stop() class=mmp><b>S</b>top</span>&nbsp;&nbsp;<span style=cursor:pointer onClick=mmp.pause() class=mmp><b>P</b>ause</span><font class=mmp>&nbsp;]</font>
  </td></tr>
</table>
<!-- BGM 플레이어 끝 -->
<?}?>


<table border=0 width=<?=$width?> cellspacing=0 cellpadding=0 class=info_bg>
<tr><td class=lined colspan=5 style=height:2px><img src=<?=$dir?>/t.gif width=<?=$_lSwidth?> height=1></td></tr>
<tr><td height=5 class=info_bg></td></tr>
<tr>
 <td width=<?=$_lSwidth?>><img src=<?=$dir?>/t.gif width=<?=$_lSwidth?> height=1></td>
 <td height=24>
    <?=$bt_reply?><?if($is_admin || !$is_vdel) {?><?=$bt_modify?><?=$bt_delete?><?}?>
	<?if($using_vote) {?><?=$bt_vote?><?}?>
 </td>
 <td align="center">&nbsp;</td>
 <td align=right>
	<?if($skin_setup['using_gmode'] && !$skin_setup[show_articleInfo] && !$setup[use_alllist]) {
		if($prev_data[no]) echo $bt_vprev;
		if($next_data[no]) echo $bt_vnext;
	  }
	?>
    <?=$bt_list?><?=$bt_write?>
 </td>
 <td width=<?=$_rSwidth?>><img src=<?=$dir?>/t.gif width=<?=$_rSwidth?> height=1></td>
</tr>
</table>

<?if(!$skin_setup[using_bmode] && $skin_setup[show_articleInfo]) { ?>
<table width=<?=$width?> cellspacing=0 cellpadding=0 class=info_bg>
<tr><td height=5></td></tr>
<tr><td class=lined style=height:1px><img src=<?=$dir?>/t.gif height=1></td></tr>
<tr><td style="height:15px"></td></tr>
</table>

<?include $dir."/include/view_gmode.php"?>
<? } ?>

<?
if($enable_pn_list && $skin_setup[using_keyNavi]) {
	include $dir."/plug-ins/key_navigator.php";
}

if($is_vdel && !$is_admin) $skin_setup[using_comment] = '';
?>

<?if($member['level']<=$setup['grant_comment']){?>

<!-- facebook -->
<!--
<script src="http://connect.facebook.net/ko_KR/all.js#xfbml=1"></script>
<fb:like href="http://www.bundangmarathon.com/bbs/zboard.php?id=<?=$id?>&no=<?=$no?>" send="true" width="500" show_faces="true" font="arial">
</fb:like>
 
<div id="fb-root"></div>
<script src="http://connect.facebook.net/ko_KR/all.js#appId=???&amp;xfbml=1"></script>
<fb:comments href="/bbs/zboard..php?id=<?=$id?>&no=<?=$no?>" num_posts="2" width="500"></fb:comments>
-->

<table border=0 cellspacing=0 cellpadding=0 height=5 width=<?=$width?>>
<tr><td class=info_bg style=height:5px id=ctop></td></tr>
</table>

<?
}
?>
<!-- DQ_Revolution/view_gallery.php end  -->
