<?

function mmplay($filename, $id="", $playcount='99') {
	global $member;

	if(eregi("msie",getenv("HTTP_USER_AGENT"))) $ie="1"; else $ie="0";
	if($id) $id="id=".$id;

	if(!is_mediafile($filename)) return "";

	$music = explode("@",$filename);
	if(substr($music[0],0,7)=='http://') $music[0] = dq_urlencode($music[0]);

	if(eregi("\.swf",$music[0])) {?>
	  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" width="0" height="0"><param name="menu" value="false"><param name="wmode" value="transparent"><param name="movie" value="<?=$music[0]?>"><param name="quality" value="low"><param name="LOOP" value="false"><embed src="<?=$music[0]?>" quality="low" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="0" height="0" loop="false" wmode="transparent" menu="false"></embed></object>
	<?} elseif(eregi("bugs.co.kr",$music[0])) {?>
		<object <?=$id?> classid="CLSID:5485BEE4-CBD2-41e5-8177-B92663963326" style="height:0;width:0;">
		  <PARAM NAME="SetLBS" VALUE="220.90.216.67;220.90.216.68">
		  <param name="autoStart" value="<?if(!is_null($member[music_play]) &&  $member[music_play]==0){?>false<?}else{?>true<?}?>">
		  <param name="PlayCount" value="<?=$playcount?>">
		  <param name="Volume" value="100">
		  <PARAM NAME="url" VALUE="<?=$music[0]?>">
		</object>
	<? } else {?>
		<embed src="<?=$music[0]?>" <?=$id?><?if($ie){?> playcount="<?=$playcount?>" autostart="<?if(!is_null($member[music_play]) &&  $member[music_play]==0){?>0<?}else{?>1<?}?>"<?}?> style="width:0px; height:0px"></embed>
<?	}
}


function is_mediafile($string) {
	$info = explode("@",$string);
	if(ereg("\.mid|\.mp3|\.wma|\.asf|\.asx|\.wmv|\.mpa|\.wav|/link_player\.aspx|bugs\.co\.kr|\.swf", strtolower($info[0]))) return true;
}

function is_imagefile($string) {
	$info = explode("@",$string);
	if(ereg("\.jpg|\.gif|\.png", strtolower($info[0]))) return true;
}

function chk_previmage($string) {
	if(ereg("\.jpg|\.gif|\.png", strtolower($string))) 
		return "preview_write.jpg";
	else return "preview_app.gif";
}

function get_musicinfo($string) {
	$info = explode("@",$string);
	return $info;
}

function get_voteUsers($id,$no,$view_info) {
	global $member, $connect;
	$vote_users = mysql_fetch_row(mysql_query("select vote_users from dq_revolution where zb_id='$id' and zb_no='$no'",$connect));
	if(!$vote_users[0]) return;

	$vote_users = trim($vote_users[0]);
	$tmp = explode("<",$vote_users);
	$v_users[2] = count($tmp)-1;

	$v_users[1] = ",";
	for($i=1; $i<count($tmp); $i++) {
		if($i>20) {$v_users[0] .= " , ..."; break;}
		if($i>1) $v_users[0] .= " , ";

		$tmp2 = explode(">",$tmp[$i]);

		if($member[no] && $view_info) $v_users[0] .= "<span onClick=\"window.open('view_info2.php?member_no=$tmp2[0]','view_info','width=400,height=510,toolbar=no,scrollbars=yes');\" style=\"cursor:hand\" title=\"회원정보 보기\">$tmp2[1]</span>";
		else $v_users[0] .= $tmp2[1];

		$v_users[1] .= $tmp2[0].",";
	}
	return $v_users;
}

function get_newComment($no) {
	global $t_comment, $id;
	$dtime = time()-(60*60*6);
	$data=@mysql_fetch_array(mysql_query("select count(no) from $t_comment"."_$id where parent='$no' and reg_date > $dtime order by no"));
	return $data[0];
}
?>