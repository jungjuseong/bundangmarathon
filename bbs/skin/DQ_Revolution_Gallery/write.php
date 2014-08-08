<?
// 보안검사
	if(!file_exists(getcwd().'/zboard.php')) die('정상적인 접근이 아닙니다.');

//스킨 환경설정 읽어옴
	include $dir."/get_config.php";

	include $dir."/".$skin_setup['language_dir']."write.php";

// 스킨 경로 환경변수 재설정
	$dir = 'skin/'.$setup['skinname'];

// 엔진 가져오기
	$_inclib_01 = $dir."/include/dq_thumb_engine2.";
	if(file_exists($_inclib_01.'php') && filesize($_inclib_01.'php')) include_once $_inclib_01.'php';
	else include_once $_inclib_01.'zend';

// 업로드제한
	if($mode!="modify") include $dir."/include/write_limit.php";

// 설정
	if($mode=="reply") $title=$_strSkin['reply'];
	elseif($mode=="modify") $title=$_strSkin['modify'];
	else $title=$_strSkin['title'];

	$a_preview = str_replace(">","><font class=eng>",$a_preview)."&nbsp;&nbsp;";
	$a_imagebox = str_replace(">","><font class=eng>",$a_imagebox)."&nbsp;&nbsp;";

	if(!$skin_setup[using_upload2] && $data[file_name2]) {
		$skin_setup[using_upload2] = "1";
		$skin_setup[upload_number] = $skin_setup[upload_number] -1;
	}

	$text_row_size = 15;

// 스킨 설정에 따라 제목과 내용 타이틀의 굵기 결정
	if($skin_setup['using_upload2'] || $skin_setup[upload_number]) $once_upload = "1";
	if($once_upload) $memo_text1 = $_strSkin['memo1']; else $memo_text1 = $_strSkin['memo2'];
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

//자료실 기능을 사용할수 있을때...
if($setup[use_pds]) {
	$start_image = 2;
	if($skin_setup['using_upload2']) $start_image++;
	$total_image = 0;
	$max_image = $skin_setup[upload_number] + ($start_image-1);

	//업로드파일 설명 가져옴
	$file_descript = get_fileDescript($id, $no);

	//업로드 확장기에 의한 파일목록 가져옴
	unset($m_data);
	$m_data=mysql_fetch_array(mysql_query("select * from dq_revolution where  zb_id='$id' and zb_no='$no'"));

	if($mode == "modify" && $m_data[file_names]) {
		// 가상 삭제기능
		if($m_data[is_vdel] && $is_admin) $is_vdel = 'checked';
		if(!$is_admin) $is_vdel = $m_data[is_vdel];

		$tmp_files = explode(",",$m_data[file_names]);
		$tmp_sfiles = explode(",",$m_data[s_file_names]);
		for($i=0; $i<=99; $i++) {
			if($tmp_files[$i]) {
				$images[$i] = $tmp_files[$i];
				$s_images[$i] = $tmp_sfiles[$i];
				$images_size[$i] = GetFileSize(filesize($tmp_files[$i]));
				$count++;
				$max_files = $i+1 ;
			}
		}
		$old_start = $start_image;
		if($count) {
			//$start_image = $max_files+1;
			$total_image = $max_files;
		}
	}

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

	
	if(eregi("msie",getenv("HTTP_USER_AGENT"))) $cols_size=50*0.6; else $cols_size=50;

?>
<script language="JavaScript" type="text/JavaScript">
var start_image = <?=$start_image?>;
var total_image = <?=$total_image?>;
var max_image = <?=$max_image?>;
var cols_size = <?=$cols_size?>;
var using_preview_img = 1;
var dir = "<?=$dir?>";
var css_dir = "<?=$dir?>/<?=$skin_setup[css_dir]?>";
var _leftframe_width = "<?=$_leftframe_width?>";
<?if($skin_setup[using_wAgreement]) echo "var using_wAgreement = 1;\n"; else echo "var using_wAgreement = 0;\n";?>
</script>
<? } ?>

<script language="JavaScript" src="<?=$dir?>/write.js" type="text/JavaScript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function zb_formresize(obj) {
	obj.rows += 3;
}
// -->
</script>

<table border=0 width=<?=$width?> cellspacing=0 cellpadding=0 class=info_bg>
<tr><td>
	<table border=0 width=100% cellspacing=0 cellpadding=0>
	<form method=post name=write action=unlimit_write_ok.php onsubmit="submitContents(); return revolg_check_submit('<?=$setup[use_category]?>','<?=$member[no]?>','<?=$skin_setup[using_emptyArticle]?>');" enctype=multipart/form-data>
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
		   <?if($mode=="modify" && $is_admin) draw_is_vdel(1)?>
	  </td>
	</tr>
	</table>

	
<?if($setup[use_pds]) {?>

	<table border=0 width=100% cellspacing=1 cellpadding=0 id=table_upload>
	<col width=<?=$_leftframe_width?>></col><col width=53></col><col></col>
	<tr><td colspan=3 style=height:15px></td></tr>
	<tr><td colspan=3 style=height:5px></td></tr>
	<tr><td colspan=3 class=separator1 height=1></td></tr>
	<tr><td colspan=3 style=height:15px></td></tr>
	<tr>
	  <td valign=top>
	   <div width=<?=$_leftframe_width?> align="right" style="height:100%;padding:4 10 0 0;line-height:180%;">
	   <?=$_strSkin['file']?><?if($skin_setup['using_upload2']) echo "<br>1"?>
	   </div>
	  </td>
	  <td align=center valign=top style="padding:2 3 0 0" height=60>
	  <?if($data[file_name1]){$calc_size = cal_thumb_size($data[file_name1],50,50);?><img src="<?=$data[file_name1]?>" id=preview_image_z1 width=<?=$calc_size[0]?> height=<?=$calc_size[1]?>><?}?>
	  <?if(!$data[file_name1]){?><img src="<?=$dir?>/<?=$skin_setup[css_dir]?>preview_write.jpg" id=preview_image_z1 width=50 height=50><?}?>
	  </td>
	  <td class=eng valign=top style='padding:0 10 10 0'">
	    <input type=file name=file1 <?=$cols_size?> maxlength=255 class=input2 style=width:100% onChange='image_preview(document.write.preview_image_z1,use_descript_z1); imgLoad(this.value);'>
	    <span id=show_descript_z1<?if(!eregi("[use]",$file_descript[0])) echo " style=\"display:none\""?>>
	      <textarea name=descript_z1 <?=size2(90)?> rows=2 class=textarea style=width:100%><?=str_replace("<br />","\n",str_replace("[use]","",$file_descript[0]))?></textarea>
	    </span>
	  <?if($file_name1) echo str_replace("이"," 파일이",str_replace('<br>','',$file_name1))."&nbsp;&nbsp;&nbsp;"?>

	  <?if($once_upload) {?>
<!-- yhkim -->
	  <input type=checkbox name=use_descript_z1 value=1 onClick=showhide(show_descript_z1,descript_z1) onFocus=blur()<?if(eregi("[use]",$file_descript[0])) echo " checked"?>><?=$_strSkin['descript']?>&nbsp;&nbsp;&nbsp;
	  <input type=checkbox name=use_thumbimg id=use_thumbimg value=1<?if(get_StrValue($sitelink2,1)) echo " checked"?><?if(!$skin_setup['using_upload2'] && $skin_setup[upload_number]) echo " onclick=\"add_upField2()\""?>><?=$_strSkin['use_thumb']?>
	  <?} else {?><script>var use_descript_z1 = '';</script><?}?>

	  </td>
	</tr>

	<?if($skin_setup['using_upload2']) {?>
	<tr>
	  <td valign=top><div width=100 align="right" style="height:100%;padding:4 10 0 0;">2</div></td>
	  <td align=center valign=top style="padding:2 3 0 0" height=60>
	  <?if($data[file_name2]){$calc_size = cal_thumb_size($data[file_name2],50,50);?><img src="<?=$data[file_name2]?>" id=preview_image_z2 width=<?=$calc_size[0]?> height=<?=$calc_size[1]?>><?}?>
	  <?if(!$data[file_name2]){?><img src="<?=$dir?>/<?=$skin_setup[css_dir]?>preview_write.jpg" id=preview_image_z2 width=50 height=50><?}?>
	  </td>
	  <td class=eng valign=top style='padding:0 10 10 0'><input type=file name=file2 <?=$cols_size?> maxlength=255 class=input2 style=width:100% onChange=image_preview(document.write.preview_image_z2,use_descript_z2)>
	  <span id=show_descript_z2<?if(!eregi("[use]",$file_descript[1])) echo " style=\"display:none\""?>>
	    <textarea name=descript_z2 <?=size2(90)?> rows=2 class=textarea style=width:100%><?=str_replace("[use]","",$file_descript[1])?></textarea>
	  </span>
	  <?if($file_name2) echo str_replace("이"," 파일이",str_replace('<br>','',$file_name2))."&nbsp;&nbsp;&nbsp;"?>
	  <input type=checkbox name=use_descript_z2 value=1 onClick=showhide(show_descript_z2,descript_z2) onFocus=blur()<?if(eregi("[use]",$file_descript[1])) echo " checked"?>><?=$_strSkin['descript']?></td>
	</tr>
	<?}?>
	<tr><td colspan=3 style=height:15px></td></tr>
	<tr>
	  <td align="right"></td>
	  <td colspan=2 class="han" align="left" style="line-height:160%;padding-right:10px">
<!-- yhkim -->
	  <?=str_replace('[upload_size]','<font class=han2>'.getFileSize($setup[max_upload_size]).'</font>',$_strSkin['up_size'])?>
	  <?if($skin_setup[upload_number] && $mode != "reply") {?><br><?=str_replace('[upfile_cnt]','<font class=han2>'.$skin_setup['upload_number'].'</font>',$_strSkin['upfile_cnt'])?>
	  <a href="javascript:add_upField();" onFocus="blur()"><?=$bt_addfield?></a><? } ?>
	  </td>
	</tr>
	<tr><td colspan=3 style=height:8px></td></tr>

	<?
	//if($skin_setup['using_upload2']) $jadd=2; else $jadd=1;
	$jadd=2;

	if($count) {
		$total_image = 0;
		for($i=0; $i<$max_files; $i++) {
			
			$j = $i+$jadd;
			$calc_size = cal_thumb_size($images[$i],50,50);

			echo "\n<tr>\n<td valign=\"top\"><div width=\"$_leftframe_width\" align=\"right\" style=\"height:100%;padding:5 10 0 0;\">".($total_image+$old_start)."</div></td>\n";
			echo "<td align=center valign=top style=\"padding:2 3 0 0\" height=60>\n";
			if($images[$i]) echo "<img src=\"$images[$i]\" id=\"preview_image_".$total_image."\" width=$calc_size[0] height=$calc_size[1]>\n";
			else echo "<img src=\"$dir/$skin_setup[css_dir]"."preview_write.jpg\" id=\"preview_image_".$total_image."\" width=50 height=50>\n";
			echo "</td>\n<td valign=top style='padding:0 10 10 0'><input type=file name=upload_ex[".$total_image."] ".size(50)." maxlength=255 class=input2 style=width:100%";
			echo " onChange=image_preview(this,document.write.preview_image_".$total_image.",use_descript_".$total_image.")>\n";
			echo "<span id=show_descript_".$total_image;
			if(!eregi("[use]",$file_descript[$j])) echo " style=\"display:none\"";
			echo ">\n<textarea name=descript_".$total_image." id=descript_".$total_image." ".size2(90)." rows=2 class=textarea style=width:100%>";
			echo str_replace("[use]","",$file_descript[$j])."</textarea>\n</span>\n";	  
			if($s_images[$i]) echo $s_images[$i]." 파일이 등록되어 있습니다. <input type=checkbox name=del_files[".$i."] value=1>삭제";
			if($s_images[$i]) echo "&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "<input type=checkbox name=use_descript_".$total_image." value=1 onClick=showhide(show_descript_".$total_image.",descript_".$total_image.") onFocus=blur()";
			if(eregi("[use]",$file_descript[$j])) echo " checked";
			echo ">설명첨부</td>\n";
			echo "</tr>\n";

			$total_image++;
		}
	}
	?>
	</table>
<? } ?>

	<table border=0 width=100% cellspacing=0 cellpadding=0 style="table-layout:fixed">
	<col width=<?=$_leftframe_width?>></col><col></col>

	<tr><td colspan=2 style=height:5px></td></tr>
	<tr><td height=1 colspan=2 class=separator1></td></tr>
	<tr><td colspan=2 style=height:15px></td></tr>
	<tr>
	  <td align="right" style="padding-right:10px;"><font class=han><?=$subject_text?></font></td>
	  <td style='padding-right:10px'><input type=text name=subject value="<?=$subject?>" <?=size(60)?> maxlength=200 style=width:100% class=input2></td>
	</tr>
	<tr><td colspan=2 style=height:10px></td></tr>
	<?=$hide_sitelink1_start?>
	<tr>
	  <td align="right" style="padding-right:10px;"><font class=han><?=$_strSkin['bgm']?></font></td>
	  <td class=han style='padding-right:10px'><input type=text name=sitelink1 value="<?=str_replace("\"","&quot;",$sitelink1)?>" <?=size(62)?> maxlength=200 class=input2 style=width:100%></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td class=han align=left height=20><?=str_replace('[host_url]','http://'.getenv('HTTP_HOST').'/music.wma',$_strSkin['guide_bgm'])?></td>
	</tr>
	<?=$hide_sitelink1_end?>

	<?
	if($mode == "modify" && $setup[use_alllist]) $zfile="/zboard.php?";
	if($mode == "modify" && !$setup[use_alllist]) $zfile="/view.php?";

	$_zboard_url = str_replace(strstr($_SERVER['HTTP_REFERER'],$zfile),"",$_SERVER['HTTP_REFERER']);
	$imageBoxPattern = "/\[img\:(.+?)\.(jpg|gif)\,align\=([a-z]){0,}\,width\=([0-9]+)\,height\=([0-9]+)\,vspace\=([0-9]+)\,hspace\=([0-9]+)\,border\=([0-9]+)\]/i";
	$memo=preg_replace($imageBoxPattern,"<img src='$_zboard_url/icon/member_image_box/$data[ismember]/\\1.\\2' align='\\3' width='\\4' height='\\5' vspace='\\6' hspace='\\7' border='\\8'>", stripslashes($memo));
	?>

	<tr>
	  <td  align="right" style="padding-top:12px;padding-right:10px;" valign="top">
	    <font class=han><?=$memo_text?></font><br><br><br>
		<font class=bt onclick="document.write.memo.rows=<?=$text_row_size?>;document.write.memo.focus();" style="cursor:pointer;padding-top:3px;" title='<?=$_strSkin['org_memo']?>'>■</font><br>
		<font class=bt onclick="document.write.memo.rows=document.write.memo.rows+4;document.write.memo.focus();" style="cursor:pointer;padding-top:3px;" title='<?=$_strSkin['exp_memo']?>'>▼</font>
	  </td>
	  <td style='padding:8 10 8 0'><textarea name="memo" id="memo" <?=size2(90)?> rows=<?=$text_row_size?> class=textarea style=width:100%><?= $memo?></textarea></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td class=han align=left>
	  <?
	  if(!$is_admin) {
		  if(!trim($setup[avoid_tag]) || $setup[use_html]==0) echo $_strSkin['no_html'];
		  if(trim($setup[avoid_tag]) && $use_html && $setup[use_html]==1 && $setup[grant_html]<$member[level]) echo str_replace('[avoid_tag]','<font class=han2>'.trim($setup[avoid_tag]).'</font>',$_strSkin['sum_html']);
	  }
	  if($is_admin || $setup[grant_html] >= $member[level] || $setup[use_html]==2) echo $_strSkin['all_html'];
	  ?>
	  </td>
	</tr>
	<?
	 // 게시물 등록약관 동의
	  if($skin_setup[using_wAgreement]) {?>
  	  <tr><td colspan=2 style=height:15px></td></tr>
	  <tr><td colspan=2 class=separator1 height=1></td></tr>
	  <tr>
	    <td class=han style="padding:10 0 0 0">&nbsp;</td>
		<td class=han style="padding:10 0 0 0;line-height:160%"><?=stripslashes($skin_setup['write_agreement'])?><?=draw_wAgreement(1)?></td>
	  </tr>
	  <?}?>
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
		<?if(!eregi('.gif',$_strSkin['write_ok'])){?><input type="submit" value="<?=$_strSkin['write_ok']?>" class=submit_w accesskey="s" onClick="javascript:document.write.action='unlimit_write_ok.php'">
		<? } else {?><input type="image" src="<?=$_strSkin['write_ok']?>" accesskey="s" onClick="javascript:document.write.action='unlimit_write_ok.php'"><? } ?>
	  </td>
	  <td align=right valign=bottom width=20 style='padding: 0 10 0 10'>
		<?if(!eregi('.gif',$_strSkin['cancel'])){?><input type="button" value="<?=$_strSkin['cancel']?>" class="button" onclick="history.back()">
		<? } else {?><img src="<?=$_strSkin['cancel']?>" onclick="history.back()" onFocus="blur()" style="cursor:pointer"><? } ?>
	  </td>
	</tr>
	</form>
	</table>
	<br>
</td></tr></table>
