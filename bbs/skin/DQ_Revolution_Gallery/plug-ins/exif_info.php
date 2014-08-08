<?
// 제로보드용 EXIF 출력 플러그-인 ver 2.0
// 제작: 드림퀘스트/안현우 / e-mail:dwander@netian.com / homepage: http://www.dqstyle.com
// 
// -- 사용법 --
// $_LIBS_include_dir = "EXIFUtils 프로그램의 경로";
// exiflist("이미지파일 경로");
//

function exiflist($image_file) {
  global $_zb_path, $dir, $_LIBS_include_dir;

  if(file_exists($image_file) && eregi("\.jpg",$image_file)) {
	  
	if(function_exists('get_serveros')) $os = get_serveros();
	else $os = 'linux';

	if(eregi("windows",$os)) {
	  $image_file= str_replace("/","\\",$_zb_path).str_replace("/","\\",$image_file);
	  $exec		 = $_LIBS_include_dir."exiflist.exe";
	  $tmp_file  = str_replace("/","\\",tempnam("data","exif_"));
	} else {
	  $exec = $_LIBS_include_dir."exiflist";
	  $image_file = $_zb_path.$image_file;
	  $tmp_file   = tempnam("data","exif_");
	}

	if(!file_exists($exec)) return;
	exec($exec." \"$image_file\" >\"$tmp_file\"");
	if(!filesize($tmp_file)) {unlink($tmp_file); return;}

	$exif_data = file($tmp_file);
	$exif_info = array();

	unlink($tmp_file);

	for($i==0;$i<count($exif_data);$i++) {
	  if(eregi(":",$exif_data[$i])) {
		 $tmp = explode(':',$exif_data[$i]);
		 $tmp[0] = str_replace(' ', '', $tmp[0]);
		 $j=2;
		 if(count($tmp)>2) {
			 for($j==2;$j<count($tmp);$j++) {$tmp[1] .= $tmp[$j];}
		 }
		 if(!$exif_info[trim($tmp[0])]) $exif_info[trim($tmp[0])] = trim($tmp[1]);
	  } else continue;
	}

	//var_dump($exif_info);

	if(!$exif_info['Model']) return;

	$ev = $exif_info['ExposureBias(EV)'];
	$ev = (($ev > 0)? '+': '').$ev.' EV';

	$_date		 = &$exif_info['Date/TimeTaken'];
	$_exif_date .= substr($_date,0,4)."-".substr($_date,4,2)."-";
	$_exif_date .= substr($_date,6,2)." ";
	$_exif_date .= substr($_date,9,2).":".substr($_date,11,2).":";
	$_exif_date .= substr($_date,13,2);

	$spacer = "<b class=exif_spacer> | </b>";

	if($exif_info['Make'])				$ImgInfo = $exif_info['Make'].$spacer;
	if($exif_info['Model'])				$ImgInfo = $ImgInfo.$exif_info['Model'].$spacer;
	if($exif_info['Date/TimeTaken'])	$ImgInfo = $ImgInfo.$_exif_date.'<br>';

	if($exif_info['ExposureProgram'])	$ImgInfo .= $exif_info['ExposureProgram'];
	if($exif_info['MeteringMode'])		$ImgInfo .= $spacer.$exif_info['MeteringMode'];
	if($exif_info['WhiteBalance'])		$ImgInfo .= $spacer.$exif_info['WhiteBalance']." WB";
	if($exif_info['ExposureTime(sec)'])	$ImgInfo .= $spacer.$exif_info['ExposureTime(sec)'].'s';
	if($exif_info['F-Number'])			$ImgInfo .= $spacer.'F'.$exif_info['F-Number'];
	if($exif_info['ExposureBias(EV)'])	$ImgInfo .= $spacer.$ev;
	if($exif_info['ISOSpeed'])			$ImgInfo .= $spacer.'ISO-'.$exif_info['ISOSpeed'];
	if($exif_info['FocalLength(mm)'])	$ImgInfo .= $spacer.$exif_info['FocalLength(mm)'].'mm';
	if($exif_info['FocalLength(35mmequiv)']) $ImgInfo .= $spacer.'35mm equiv '.$exif_info['FocalLength(35mmequiv)'].'mm';
	if($exif_info['Flash'])				$ImgInfo .= $spacer.$exif_info['Flash'];

	if(!$ImgInfo) return;

	$put .= "<table cellpadding=0 cellspacing=0 border=0>";
	$put .= "<tr><td style='padding:1px 5px 5px 10px;' class='exif_bg + eng'>$ImgInfo</td></tr>";
	$put .= "<tr><td height=3></td></tr></table>";

	return $put;
  } //$_exif_filenames
} 
?>
