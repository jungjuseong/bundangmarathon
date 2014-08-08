<?
	if(!file_exists(getcwd().'/zboard.php')) die("정상적인 접근이 아닙니다.");

//	$a_vote = str_replace("select_arrange=hit", "select_arrange=vote", $a_hit);

// 정렬버튼 링크 정의
	$a_no	= "<a onfocus=blur() href='$PHP_SELF?$href&select_arrange=headnum&desc=$t_desc'>";
	$a_hit	= "<a onfocus=blur() href='$PHP_SELF?$href&select_arrange=hit&desc=$t_desc'>";
	$a_vote	= "<a onfocus=blur() href='$PHP_SELF?$href&select_arrange=vote&desc=$t_desc'>";
	$a_date	= "<a onfocus=blur() href='$PHP_SELF?$href&select_arrange=reg_date&desc=$t_desc'>";

// 정렬 버튼의 경우 $desc를 역으로 변환
	if($desc=="desc") $t_desc="asc"; else $t_desc="desc";
	include $dir."/".$skin_setup['language_dir']."list.php";
	$_line_print = false;

//글 읽기시 아래에 전체리스트 보기가 활성화된 상태에서 글 읽기가 선행되었다면 구분선과 공백 생성
	if ($view_once) {
?>
	<table width=<?=$width?> cellspacing=0 cellpadding=0 class=thumb_area_bg>
		<tr><td class=line2 style=height:1px></td></tr>
		<tr><td class=line1 style=height:1px></td></tr>
	</table>
<?
	}

//개인갤러리 사용시 개인정보 헤더를 뿌려줌
	if($skin_setup[using_pGallery] && $su=="on" && $keyword && !$view_once) include "$dir/plug-ins/pgallery_header.php";
?>
	<table border=0 cellpadding=0 cellspacing=0 width=<?=$width?> class=thumb_area_bg>
		<form method=post name=list action=list_all.php>
		<input type=hidden name=page value=<?=$page?>>
		<input type=hidden name=id value=<?=$id?>>
		<input type=hidden name=select_arrange value=<?=$select_arrange?>>
		<input type=hidden name=desc value=<?=$desc?>>
		<input type=hidden name=page_num value=<?=$page_num?>>
		<input type=hidden name=selected>
		<input type=hidden name=exec>
		<input type=hidden name=keyword value="<?=$keyword?>">
		<input type=hidden name=sn value="<?=$sn?>">
		<input type=hidden name=ss value="<?=$ss?>">
		<input type=hidden name=sc value="<?=$sc?>">
	<tr><td style="height:5px;"></td></tr>

	<?if($setup[use_category] && $skin_setup[using_category]) {?>
	<tr>
		<td>
		<?include "include/print_category.php"?>
		</td>
	</tr>
	<? $_line_print = 1; }?>

<?
	if(!$skin_setup['disable_login']) {
		if(!eregi("<Zeroboard",$a_login)) $_line_print = 2;
		if(!eregi("<Zeroboard",$a_member_join)) $_line_print = 2;
		if(!eregi("<Zeroboard",$a_member_modify)) $_line_print = 2;
		if(!eregi("<Zeroboard",$a_member_memo)) $_line_print = 2;
		if(!eregi("<Zeroboard",$a_logout)) $_line_print = 2;
		if(!eregi("<Zeroboard",$a_setup)) $_line_print = 2;
		if(!eregi("<Zeroboard",$a_write_tmp) && $_ss_['using_topWriteBT']) $_line_print = 2;
		//if($is_admin) $_line_print = 2;
		if($skin_setup[using_sort]) $_line_print = 2;
	}

	if($_line_print==2) {
?>
	<tr>
		<td><table border=0 cellpadding=0 cellspacing=4 width=100%>
			  <tr>
				  <td style=width:5px;></td>
	<?if($skin_setup[using_sort]) {?>
				  <td class=han><?=$bt_sort?></td>
	<? } ?>
				  <td class=han align="right" style="font-size:8pt;font-family:dotum">
					<? if(!$skin_setup['disable_login']) { ?>
					<nobr><?=$bt_login?><?=$bt_member_join?><?=$bt_member_modify?><?=$bt_bember_memo?><?=$memo_on_sound?><?=$bt_logout?>
					<? } ?>
					<?if($is_admin) {?>
					<?=$bt_setup?><a href="javascript:void(window.open('<?=$dir?>/skin_config.php?id=<?=$id?>&mode=modify','DQStyle','width=770,height=570,toolbars=no,resizable=yes,scrollbars=yes,status=yes,menubar=yes,location=yes,url=yes'))"><?=$bt_skinsetup?></a>
					<? } ?>
					<?if($_ss_['using_topWriteBT']) echo $bt_write."</a>"?>
					</nobr>
				  </td>
				  <td style=width:5px;></td>
			  </tr></table></td>
	</tr>
	<?}?>

	<?if($_line_print) { ?>
	<tr><td style="height:4px;"></td></tr>
	<tr><td colspan=4 class=line2 style=height:1px></td></tr>
	<tr><td colspan=4 class=line1 style=height:1px></td></tr>
	<? } ?>
	<tr><td style="height:10px;"></td></tr>
	</table>

	<table border="0" cellpadding="0" cellspacing="0" width=<?=$width?> class=thumb_area_bg>
	<tr><td style="padding:5 <?=$skin_setup[thumb_aMargin2]?> 0 <?=$skin_setup[thumb_aMargin1]?>;">
