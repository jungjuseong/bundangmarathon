	<div data-role="controlgroup" data-type="horizontal" style="text-align:right;margin-right:15px;"> 
		<?php echo($a_delete);?>
		<?php echo($a_list)?>
	</div> 
	<div data-role="content" style="margin-top:-20px;"> 
		<div class='ui-bar ui-bar-b'><?=$subject?></div>
    <div class='ui-bar ui-bar-c' style='text-align:right;border:0px'>
      <div style="float:left"><?=$name?></div> <?=$reg_date?>, 조회 : <b><?=number_format($hit)?></b>, 추천 : <b><?=$vote?></b>
    </div>
    <div class='ui-body ui-body-d' style="border:0px"> 
      <div style="padding:10px 0;font-size:16pt;">
<?php
$upload_image1 = $upload_image2="";
$maxWidth = 260; //이미지 최대넓이

if(eregi("\.jpg",$file_name1)||eregi("\.gif",$file_name1)||eregi("\.png",$file_name1)){
	$imgInfo = getimagesize("../$data[file_name1]");
	$width = $imgInfo[0];
	$height = $imgInfo[1];

	$showImgWidth = ($width > $maxWidth) ? $maxWidth : $width;    //width값 지정
	$showImgHeight = ceil($showImgWidth * 3 / 4); //4:3 비율

	//$upload_image1="<img src=../$data[file_name1] border=0 name=zb_target_resize style=\"cursor:hand\" width=".$showImgWidth."px height=".$showImgHeight."px><br>";
	$upload_dir = "/bbs/";
	$encoded_src = $upload_dir.$data[file_name1];
	$upload_image1="<img src=".$encoded_src." border=0 name=zb_target_resize style=\"cursor:hand\" width=".$showImgWidth."px height=".$showImgHeight."px><br>";
}
if(eregi("\.jpg",$file_name2)||eregi("\.gif",$file_name2)||eregi("\.png",$file_name2)){
	$imgInfo = getimagesize("../$data[file_name2]");
	$width = $imgInfo[0];
	$height = $imgInfo[1];
	
	$showImgWidth = ($width > $maxWidth) ? $maxWidth : $width;    //width값 지정
	$showImgHeight = ceil($showImgWidth * 3 / 4); //4:3 비율

	$upload_image2="<img src=../$data[file_name2] border=0 name=zb_target_resize style=\"cursor:hand\" width=".$showImgWidth."px height=".$showImgHeight."px><br>";
}
?>
			<?=$hide_download1_start?><?=$upload_image1?><?=$hide_download1_end?>
			<?=$hide_download2_start?><?=$upload_image2?><?=$hide_download2_end?>
			<?
			//이미지 리사이징
			$m = preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i",$data[memo], $output);  
			if ($m) { 
				for ($j=0;$j<$m;$j++) {
					if(@getimagesize($output[1][$j])){
						$imgInfo = getimagesize($output[1][$j]);
						$width = $imgInfo[0];
						$height = $imgInfo[1];
					}else{
						$width = $maxWidth;
						$height = ceil($width * 3 / 4);
					}

					$showImgWidth = ($width > $maxWidth) ? $maxWidth : $width;    //width값 지정
					$showImgHeight = ceil($showImgWidth * 3 / 4); //4:3 비율

					$data[memo] = str_replace($output[0][$j],'<img src="'.$output[1][$j].'" width='.$showImgWidth.'px height='.$showImgHeight.'px>',$data[memo]); 
				} 
			} 
			?>
			<?=$data[memo]?>

			</div> 
    </div> 
		<div class='ui-bar ui-bar-b' style="margin-top:20px;">덧글</div>
