<?
// 보안검사
	if(!file_exists(getcwd().'/zboard.php')) die('정상적인 접근이 아닙니다.');

//스킨 환경설정 읽어옴
	include $dir."/get_config.php";

	include $dir."/".$skin_setup['language_dir']."write.php";

// 스킨 경로 환경변수 재설정
	$dir = 'skin/'.$setup['skinname'];


// 설정
	if($mode=="reply") 
		$title=$_strSkin['reply'];
	elseif($mode=="modify") 
		$title=$_strSkin['modify'];
	else 
		$title=$_strSkin['title'];


// 스킨 설정에 따라 제목과 내용 타이틀의 굵기 결정

	if($once_upload) 
		$memo_text1 = $_strSkin['memo1']; 
	else 
		$memo_text1 = $_strSkin['memo2'];

	if(!$skin_setup[using_emptyArticle]) {
		$memo_text = '<b>'.$memo_text1.'</b>';
		$subject_text = '<b>'.$_strSkin['subject'].'</b>';
	} else {
		$memo_text = $memo_text1;
		$subject_text = $_strSkin['subject'];
	}

// 미리입력된 글쓰기 양식 가져옴
	$skin_setup[write_form] = trim($skin_setup[write_form]);
	if($mode=="write" && $skin_setup['write_form']) $memo = stripslashes($skin_setup[write_form]);


// 스킨 설정에 따라 제목과 내용 타이틀의 굵기 결정
	if($skin_setup['using_upload2'] || $skin_setup[upload_number] || count($images) > 1) $once_upload = "1";
	if($once_upload) $memo_text1 = $_strSkin['memo1']; else $memo_text1 = $_strSkin['memo2'];
	if(!$skin_setup[using_emptyArticle]) {
		$memo_text = '<b>'.$memo_text1.'</b>';
		$subject_text = '<b>'.$_strSkin['subject'].'</b>';
	} else {
		$memo_text = $memo_text1;
		$subject_text = $_strSkin['subject'];
	}

?>

<script language="JavaScript" src="<?=$dir?>/write.js" type="text/JavaScript"></script>
<script language="JavaScript" type="text/JavaScript">
function zb_formresize(obj) {
	obj.rows += 3;
}
</script>

<table border=0 width=<?=$width?> cellspacing=0 cellpadding=0 class=info_bg>
<tr><td>
	<table border=0 width=100% cellspacing=0 cellpadding=0>
	<form method=post name="write" action="unlimit_write_ok.php" onsubmit="return revolg_check_submit('<?=$setup[use_category]?>','<?=$member[no]?>','<?=$skin_setup[using_emptyArticle]?>');" enctype=multipart/form-data>
	 <input type=hidden name=page value=<?=$page?>>
	 <input type=hidden name=id value=<?=$id?>>
	 <input type=hidden name=no value=<?=$no?>>
	 <input type=hidden name=select_arrange value=<?=$select_arrange?>>
	 <input type=hidden name=desc value=<?=$desc?>><?if($mode=="modify"){?>
	 <input type=hidden name=page value=<?=$page?>><?}?>
	 <input type=hidden name=page_num value=<?=$page_num?>>
	 <input type=hidden name=keyword value="<?=$keyword?>">
	 <input type=hidden name=category value="<?=$category?>">
	 <input type=hidden name=sn value="<?=$sn?>">
	 <input type=hidden name=ss value="<?=$ss?>">
	 <input type=hidden name=sc value="<?=$sc?>"><input type=hidden name=su value="<?=$su?>">
	 <input type=hidden name=mode value="<?=$mode?>">
     <?if($mode=="modify" && !$is_admin) draw_is_vdel(2)?>
	 <?if($skin_setup[using_secretonly]){
		 $hide_secret_start = "<!-- ";
		 $hide_secret_end   = " -->";
		 echo "<script>var using_secretonly = 1;</script>\n";
		 echo "<input type=hidden name=is_secret value=\"1\">\n";
	 } echo "<script>var using_secretonly = 0;</script>\n";?>
	<col width=<?=$_leftframe_width?>></col><col></col>

	<tr>
		<td align=left colspan=2 class=wArticle style='padding-left:20px'>
			<b><?=$title?></b>
		</td>
	</tr>
	<tr>
		<td align=left colspan=2 class=han style="padding:5 5 10 35;line-height:160%;"><?=stripslashes($skin_setup['write_guide'])?>&nbsp;</td>
	</tr>
	<tr><td colspan=2 class=line2 style=height:1px></td></tr>
	<tr><td colspan=2 class=line1 style=height:1px></td></tr>

	<?=$hide_start?>
	<tr><td colspan=2 style=height:15px></td></tr>
	<tr>
	  <td align="right" style="padding-right:10px;"><font class=han><?=$_strSkin['password']?></font></td>
	  <td><input type=password name=password <?=size(20)?> maxlength=20 class=input2></td>
	</tr>

	<tr>
	  <td align="right" style="padding-right:10px;"><font class=han><?=$_strSkin['name']?></font></td>
	  <td><input type=text name=name value="<?=$name?>" <?=size(20)?> maxlength=20 class=input2></td>
	</tr>

	<tr>
	  <td align="right" style="padding-right:10px;"><font class=han><?=$_strSkin['email']?></font></td>
	  <td><input type=text name=email value="<?=$email?>" <?=size(40)?> maxlength=200 class=input2></td>
	</tr>

	<tr>
	  <td align="right" style="padding-right:10px;"><font class=han><?=$_strSkin['homepage']?></font></td>
	  <td><input type=text name=homepage value="<?=$homepage?>" <?=size(40)?> maxlength=200 class=input2></td>
	</tr>
	<?=$hide_end?>

	<tr><td colspan=2 style=height:15px></td></tr>
	<tr>
	  <td align="right" style="padding-right:10px;"><font class=han><?=$_strSkin['option']?></font></td>
	  <td class=han>
		   <?=str_replace('<option>Category</option>','<option>'.$_strSkin['category'].'</option>',$category_kind)?>
		   <?=$hide_notice_start?> <input type=checkbox name=notice <?=$notice?> value=1><?=$_strSkin['use_notice']?><?=$hide_notice_end?>
		   <?=$hide_html_start?> <input type=checkbox name=use_html <?=$use_html?> value=1><?=$_strSkin['use_html']?><?=$hide_html_end?>
		   <input type=checkbox name=reply_mail <?=$reply_mail?> value=1><?=$_strSkin['use_reply']?>
		   <?=$hide_secret_start?><input type=checkbox name=is_secret <?=$secret?> value=1><?=$_strSkin['use_secret']?><?=$hide_secret_end?>
	  </td>
	</tr>
	</table>

	
	<table border=0 width=100% cellspacing=0 cellpadding=0 style="table-layout:fixed">
	<col width=<?=$_leftframe_width?>></col><col></col>

	<tr><td colspan=2 style=height:5px></td></tr>
	<tr><td height=1 colspan=2 class=separator1></td></tr>
	<tr><td colspan=2 style=height:15px></td></tr>
	<tr>
	  <td align="center" style="padding-right:2px;"><span><?=$subject_text?></span></td>
	  <td style='padding-right:10px'><input type=text name=subject value="<?=$subject?>" <?=size(60)?> maxlength=200 style=width:100% class=input2></td>
	</tr>
	<tr><td colspan=2 style=height:10px></td></tr>
	<?=$hide_sitelink1_start?>
	<tr>
	  <td align="right" style="padding-right:10px;"><font class=han><?=$_strSkin['bgm']?></font></td>
	  <td class=han style='padding-right:10px'><input type=text name=sitelink1 value="<?=str_replace("\"","&quot;",$sitelink1)?>" <?=size(62)?> maxlength=200 class=input2 style=width:100%></td>
	</tr>
	<?=$hide_sitelink1_end?>

	<?
	if($mode == "modify" && $setup[use_alllist]) $zfile="/zboard.php?";
	if($mode == "modify" && !$setup[use_alllist]) $zfile="/view.php?";

	$_zboard_url = str_replace(strstr($_SERVER['HTTP_REFERER'],$zfile),"",$_SERVER['HTTP_REFERER']);
	?>

	<tr>
	<td colspan=2> 
		<textarea name="memo" id="memo" rows="10" cols="50" style="width:660px;height:412px;display:none;">
			<? echo $memo ?>
		</textarea> 
	</td>
	</tr>
	</table>

	<table border=0 width=100% cellspacing=0 cellpadding=0>
	<tr>
	<tr><td colspan=3 style=height:15px></td></tr>
	<tr><td colspan=3 class=line2 style=height:1px></td></tr>
	<tr><td colspan=3 class=line1 style=height:1px></td></tr>
	<tr><td colspan=3 style=height:5px></td></tr>
	<tr>
	  <td style="padding-left:38;"><?=$bt_preview?><?=$bt_imgbox?></td>
	  <td align=right valign=bottom width=20>
		<input type="submit" value="<?=$_strSkin['write_ok']?>" class=submit_w accesskey="s" onClick="'unlimit_write_ok.php'">
	  </td>
	  <td align=right valign=bottom width=20 style='padding: 0 10 0 10'>
		<input type="button" value="<?=$_strSkin['cancel']?>" class="button" onclick="history.back()">
	  </td>
	</tr>
	</form>
	</table>
	<br>
</td></tr></table>
