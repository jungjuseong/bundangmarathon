<?
	$_empty_value_str = $skin_setup['info_emptyValue'];

	$tInfo = stripslashes(trim($skin_setup[article_info]));

	if($skin_setup[using_pGallery] && eregi("[name]",$tInfo) && $su!="on")
		$_tPg = "&nbsp;&nbsp;<a href=zboard.php?id=$id&su=on&keyword=$data[ismember]>[ 이 사진가의 전체 사진보기 ]</a>";

	$tInfo = str_replace("[no]",$number,$tInfo);

	if($is_vdel && !$is_admin) $data[subject] = '';

	if($data[subject] != "." && $data[subject] != "") {
		$tInfo = str_replace("[subj_start]","",$tInfo);
		$tInfo = str_replace("[subj_end]","",$tInfo);
		$tInfo = str_replace("[subj]","<font class=view_title2>$subject</font>",$tInfo);
	} else {
		$tInfo = str_replace("[subj_start]","<!-- ",$tInfo);
		$tInfo = str_replace("[subj_end]"," -->",$tInfo);
		$tInfo = str_replace("[subj]","",$tInfo);
	}


	if($setup[use_category]) {
		$tInfo = str_replace("[cate_start]","",$tInfo);
		$tInfo = str_replace("[cate_end]","",$tInfo);
		$tInfo = str_replace("[cate]","<font class=view_cate>$category_name</font>",$tInfo);
	} else {
		$tInfo = str_replace("[cate_start]","<!-- ",$tInfo);
		$tInfo = str_replace("[cate_end]"," -->",$tInfo);
		$tInfo = str_replace("[cate]","",$tInfo);
	}

	if($su != "on") {
		$tInfo = str_replace("[name_start]","",$tInfo);
		$tInfo = str_replace("[name_end]","",$tInfo);
		$tInfo = str_replace("[name]",$this_name.$homepage.$_tPg,$tInfo);
	} else {
		$tInfo = str_replace("[name_start]","<!-- ",$tInfo);
		$tInfo = str_replace("[name_end]"," -->",$tInfo);
		$tInfo = str_replace("[name]","",$tInfo);
	}

	$ppoint1=0; $ppoint=0;
	$ppoint1 = $data[total_comment]+1;
	if($data[vote]) $ppoint = ceil((100*($data[vote]*$ppoint1)/$data[hit])+($data[hit]/3));

	if($hit||$vote||$data[total_comment]||$ppoint) {
		$tInfo = str_replace("[info1_start]","",$tInfo);
		$tInfo = str_replace("[info1_end]","",$tInfo);
	} else {
		$tInfo = str_replace("[info1_start]","<!-- ",$tInfo);
		$tInfo = str_replace("[info1_end]"," -->",$tInfo);
	}


	if($ppoint) {
		$tInfo = str_replace("[point_start]","",$tInfo);
		$tInfo = str_replace("[point_end]","",$tInfo);
		$tInfo = str_replace("[point]",$ppoint,$tInfo);
	} else {
		$tInfo = str_replace("[point_start]","<revolution ",$tInfo);
		$tInfo = str_replace("[point_end]","</revolution>",$tInfo);
		$tInfo = str_replace("[point]",$_empty_value_str,$tInfo);
	}

	if($hit) {
		$tInfo = str_replace("[hit_start]","",$tInfo);
		$tInfo = str_replace("[hit_end]","",$tInfo);
		$tInfo = str_replace("[hit]",$hit,$tInfo);
	} else {
		$tInfo = str_replace("[hit_start]","<revolution ",$tInfo);
		$tInfo = str_replace("[hit_end]","</revolution>",$tInfo);
		$tInfo = str_replace("[hit]",$_empty_value_str,$tInfo);
	}

	if($data[total_comment]) {
		$tInfo = str_replace("[comment_start]","",$tInfo);
		$tInfo = str_replace("[comment_end]","",$tInfo);
		$tInfo = str_replace("[comment]",$data[total_comment],$tInfo);
	} else {
		$tInfo = str_replace("[comment_start]","<revolution ",$tInfo);
		$tInfo = str_replace("[comment_end]","</revolution>",$tInfo);
		$tInfo = str_replace("[comment]",$_empty_value_str,$tInfo);
	}

	if($vote && $skin_setup['using_vote']) {
		$tInfo = str_replace("[vote_start]","",$tInfo);
		$tInfo = str_replace("[vote_end]","",$tInfo);
		$tInfo = str_replace("[vote]",$vote,$tInfo);
	} else {
		$tInfo = str_replace("[vote_start]","<revolution ",$tInfo);
		$tInfo = str_replace("[vote_end]","</revolution>",$tInfo);
		$tInfo = str_replace("[vote]",$_empty_value_str,$tInfo);
	}

	$tInfo = str_replace("[regdate]",date("Y-m-d H:i",$data[reg_date]),$tInfo);

	if($is_admin) $is_vdel = '';

	if(!$is_vdel) {
		if(get_StrValue($data[sitelink1],0) && !is_mediafile($data[sitelink1])) $link1 = true;
		if(get_StrValue($data[sitelink2],0)) $link2 = true;

		if($link1 || $link2) {
			$tInfo = str_replace("[link_start]","",$tInfo);
			$tInfo = str_replace("[link_end]","",$tInfo);

			if($link1) {
				$tInfo = str_replace("[link1_start]","",$tInfo);
				$tInfo = str_replace("[link1_end]","",$tInfo);
				$tInfo = str_replace("[link1]",autolink(get_StrValue($data[sitelink1],0)),$tInfo);
			} else {
				$tInfo = str_replace("[link1_start]","<revolution ",$tInfo);
				$tInfo = str_replace("[link1_end]","</revolution>",$tInfo);
				$tInfo = str_replace("[link1]",$_empty_value_str,$tInfo);
			}

			if($link2) {
				$tInfo = str_replace("[link2_start]","",$tInfo);
				$tInfo = str_replace("[link2_end]","",$tInfo);
				$tInfo = str_replace("[link2]",autolink(get_StrValue($data[sitelink2],0)),$tInfo);
			} else {
				$tInfo = str_replace("[link2_start]","<revolution ",$tInfo);
				$tInfo = str_replace("[link2_end]","</revolution>",$tInfo);
				$tInfo = str_replace("[link2]",$_empty_value_str,$tInfo);
			}
		} else {
			$tInfo = str_replace("[link_start]","<!-- ",$tInfo);
			$tInfo = str_replace("[link_end]","-->",$tInfo);
		}
		
		//파일이름 표시
		if(eregi("[file]",$tInfo) && $images) {
			$tInfo = str_replace("[file_start]","",$tInfo);
			$tInfo = str_replace("[file_end]","",$tInfo);

			if(empty($_startimage)) $_startimage = 0;

			$font1 = "<font class=eng>";
			$font2 = "</font><br>\n";
			for($i=$_startimage;$i<count($images); $i++) {
				if($i==2) {
					$more = true;
					$font1 = "";
					$font2 = "\n";
					$tt .= "[spacer]<br><span class=\"eng\" style=\"cursor:hand\" title=\"";
				}

				unset($exif1);
				unset($dlink);

				if($i == count($images)-1 && $more) $font2 = "";
				if($i<2 && $skin_setup['using_exif']) $exif1 = exiflist($images[$i]);

				if($i==0 && $s_images[$i] == $data[s_file_name1] && !eregi("\.gif|\.jpg|\.png",$s_images[$i])) $dlink="download.php?id=$id&no=$data[no]&filenum=1";
				if($i==1 && $s_images[$i] == $data[s_file_name2] && !eregi("\.gif|\.jpg|\.png",$s_images[$i])) $dlink="download.php?id=$id&no=$data[no]&filenum=2";
				if($dlink) {
					if($i==0) $dfile = $data[download1]; else $dfile = $data[download2];
					$dlink = "&nbsp;&nbsp;다운받은 횟수: $dfile&nbsp;&nbsp;<a href=$dlink>$bt_download</a>";
				}

				$tt .= $font1.$s_images[$i]." (".$images_size[$i].")".$dlink.$font2;

				if($exif1) $tt .= "$exif1\n";
				if($i == count($images)-1 && $more) $tt .= "\">More files(".(count($images)-2).")...</span>";
			}
		$tInfo = str_replace("[file]",$tt,$tInfo);
		} else {
			$tInfo = str_replace("[file_start]","<revolution ",$tInfo);
			$tInfo = str_replace("[file_end]","</revolution>",$tInfo);
			$tInfo = str_replace("[file]","",$tInfo);
		}

		if($skin_setup['using_vote'] && eregi("[vote_user]",$tInfo) && $vote_users[2]) {

			$tInfo = str_replace("[vote_user_start]","",$tInfo);
			$tInfo = str_replace("[vote_user_end]","",$tInfo);

			$vote_user_tmp = "<span class=\"han2\">이 글(사진)을 추천 하신분들</span><span class=\"han\">(".$vote_users[2]."명)</span>\n<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=\"100%\">\n<tr><td>".$vote_users[0]."</td></tr>\n</table>\n";
			$tInfo = str_replace("[vote_user]","[spacer]<br>[spacer]<br>".$vote_user_tmp,$tInfo);
		} else {
			$tInfo = str_replace("[vote_user_start]","<revolution ",$tInfo);
			$tInfo = str_replace("[vote_user_end]","</revolution>",$tInfo);
			$tInfo = str_replace("[vote_user]","",$tInfo);
		}

	} else { //가상으로 삭제 되었을때
		$tInfo = str_replace("[link_start]","<!-- ",$tInfo);
		$tInfo = str_replace("[link_end]","-->",$tInfo);

		$tInfo = str_replace("[file_start]","<revolution ",$tInfo);
		$tInfo = str_replace("[file_end]","</revolution>",$tInfo);
		$tInfo = str_replace("[file]","",$tInfo);
		$tInfo = str_replace("[vote_user_start]","<revolution ",$tInfo);
		$tInfo = str_replace("[vote_user_end]","</revolution>",$tInfo);
		$tInfo = str_replace("[vote_user]","",$tInfo);
	}

	$tInfo = str_replace("[spacer]","<img src=$dir/t.gif height=5 width=5 border=0>",$tInfo);

?>