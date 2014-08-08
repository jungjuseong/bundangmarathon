<?
// 제로보드의 이미지 리사이즈 기능을 차단
	$old_autoResize_text   = " name=zb_target_resize style=\"cursor:hand\" onclick=window.open(this.src)";
	$using_autoResize_text = " galleryimg=\"no\"";
	$memo=str_replace($old_autoResize_text,$using_autoResize_text,$memo);

	if($skin_setup[using_picBorder]) $_border = " class=\"pic_border\" "; else $_border=" border=\"0\"";

// 이미지태그 가져오기
	$_linkImage = get_imgTag($memo, $data[ismember], 99);

// 얻어진 이미지태그를 이용해서 이미지 사이즈 재정렬
	if($_linkImage[0]) {

		if($skin_setup[using_HTMLSeparator]) {
		  $memo = convt_imagebox($memo,$data[ismember]);
		  $memo = str_replace($_linkImage[0],"</td></tr></table></td></tr></table><table border=0 cellspacing=0 cellpadding=0 width=$skin_setup[pic_width]><tr class=pic_bg><td align=$skin_setup[pic_align] style='padding:0 $_rSwidth 0 $_lSwidth;line-height:160%'>".$_linkImage[0],$memo);
		  $memo = str_replace($_linkImage[(count($_linkImage)-1)]."<br />",$_linkImage[(count($_linkImage)-1)],$memo);
		  $memo = str_replace($_linkImage[(count($_linkImage)-1)],$_linkImage[(count($_linkImage)-1)]."</td></tr></table><table border=0 cellpadding=0 cellspacing=0 width=$skin_setup[pic_width] class=pic_bg><tr><td style='padding:0 $_lSwidth 15 $_rSwidth' align=$skin_setup[memo_align]><table border=0 cellpadding=0 cellspacing=0 width=$skin_setup[memo_width]><tr><td align=$skin_setup[memo_align] style=line-height:160%>",$memo);
		}

		for($i=0; $i<count($_linkImage);$i++) {

		  $_getImageURL  = get_urlPath($_linkImage[$i]);
		  $tmp_str = str_replace($_getImageURL,dq_urlEncode($_getImageURL),$_linkImage[$i]);
		  //$WheelCheck = onmousewheel='wheel_check(event,this,$data[prev_no],$data[next_no])';
		  if($skin_setup[using_HTMLSeparator] && $skin_setup[pic_vSpace]) $tmp_str = str_replace(">", " style=\"margin:0 0 ".$skin_setup[pic_vSpace]." 0;\">",$tmp_str);
		  
		  if(!$skin_setup[using_picBorder] && !eregi(" border.?=",$tmp_str)) {
			  if(!eregi("border.?=",$tmp_str)) $tmp_str = str_replace(">", " border=\"0\">",$tmp_str);
		  }

	  // 제한한 사이즈보다 큰 이미지라면 리사이즈 하고, 새 창 띄우는 기능 켬
		  if($skin_setup[using_autoResize]) {
			  if(!eregi("width.?=",$tmp_str)) $_tmp_width = " width='1'"; else $_tmp_width = '';
			  $tmp_str = str_replace(">", $_tmp_width." id=\"dqResizedImage".$i."\" onLoad=\"imageResize(this)\">",$tmp_str);
			  $tmp_str = str_replace(">"," onClick=\"view_linkImg(this)\">",$tmp_str);
		  }

		  $memo = str_replace($_linkImage[$i],$tmp_str, $memo);
		} //for
	}
?>