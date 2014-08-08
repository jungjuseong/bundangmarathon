<?
//두번 인클루드 되었는지 검사
if($dq_myInfo_included) return false;
else $dq_myInfo_included = true;

function get_memberPicture($member_no,$dir='',$_user_imagex='100',$_user_imagey='0') {
	global $setup, $skin_setup, $id;

	if(($_user_imagex == 100 || !$_user_imagex) && !$_user_imagey) $share='1';

	if($share) { $_user_imagex = 100; $_user_imagey = 0; }
	if(!$_user_imagex) $_user_imagex = 100;
	if(!$_user_imagey) $_user_imagey = 0;

	$target_admin  = 'DQ_LIBS/icon/'.$id.'_admin_face_'.$member_no.'.thumb';
	$target_noface = 'DQ_LIBS/icon/'.$id.'_no_face_'.$member_no.'.thumb';
	$src_file = 'skin/'.$setup[skinname].'/'.$skin_setup[css_dir].'no_face.jpg';
	if(!$share) $target = $target_noface;

	if(!file_exists('DQ_LIBS/icon/')) {
		mkdir('DQ_LIBS/icon/',0706);
		chmod('DQ_LIBS/icon/',0707);
	}

	if($member_no) {

		$temp = @mysql_query("select is_admin,open_picture,picture from zetyx_member_table where no = '$member_no'");
		$data = @mysql_fetch_array($temp);

		if(!$data) return "";

		if($share) $target_dir = 'icon/'; else $target_dir = 'DQ_LIBS/icon/'.$id.'_';
		$target_mb = explode(".",basename($data[picture]));
		$target_mb = $target_dir.$target_mb[0].".thumb";

		if($data[is_admin] == 3 && (!$data[open_picture] || !$data[picture])) {
			$src_file = $dir.'no_face.jpg';
			$target = &$target_noface;
		}

		if($share) $target="";

		if($data[is_admin] < 3 && !$data[open_picture]) {
			if(@is_file($data[picture])) {
				$src_file = $data[picture];
				$target = &$target_admin;
			}
			else $src_file = $dir.'admin_face.jpg';
		}

		if($data[open_picture] && $data[picture]) { $src_file=$data[picture]; $target=$target_mb; }
	}

	if((!$_user_imagex || !$_user_imagey) && file_exists($target)) {
		$img_size = @getimagesize($target);
		if($_user_imagex && $img_size[0] != $_user_imagex) @unlink($target);
		if($_user_imagey && $img_size[1] != $_user_imagex) @unlink($target);
	}
	if($target) $ret = make_thumb($_user_imagex,$_user_imagey,$src_file,$target);
	else $ret = $src_file;
	return $ret;
}
		

function get_memberInfo($member_no) {
	$temp = @mysql_query("select * from zetyx_member_table where no = '$member_no'");
	$data = @mysql_fetch_array($temp);

	if($data[openinfo] && $data[comment]) return $data;
}
?> 
