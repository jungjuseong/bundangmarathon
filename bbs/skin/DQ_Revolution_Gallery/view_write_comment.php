<?
if($data[headnum] <= -2000000000 && !$skin_setup[using_noticecomment]) $skin_setup[using_comment] = '';

if($skin_setup[using_comment] && !$limitCommentOFF) {
	$c_name=str_replace("size=8 maxlength=10","size=12 maxlength=20",$c_name);
	if($skin_setup['using_vote'] && $skin_setup[vote_type] == "2" && file_exists("vote_ex.php") && $member['no']) {
		 $usine_voteEX = true;
		 $_target_comment = "vote_ex.php";
	}else $_target_comment = "vote_ex.php";

	$vote_msg = $_strSkin['vote'];
	$vote_type = "vote";

	if(@eregi(",".$member[no].",",",".$vote_users[1])) {
		$already_vote="1";
		$vote_msg = $_strSkin['vote_cancel'];
		$vote_type = "del";
	}

	$_rSpacer = $_rSwidth + 40;
	$_lSpacer = $_lSwidth + 40;

	$comment_guide = str_replace("_NAME_","$this_name",$skin_setup['comment_guide']);
	$comment_guide = str_replace("_SMILE_","<img src=".$_css_dir."smile.gif border=0>",$comment_guide);

	?>


	<table id=table_write border=0 cellspacing=0 cellpadding=0 width=<?=$width?> class=info_bg>
	<tr>
	  <td width=<?=$_lSwidth?>><img src=<?=$dir?>/t.gif width=<?=$_lSwidth?> height=1>
	  <td>
		<table border=0 cellspacing=0 cellpadding=0 width=100%>
		<tr><td class=info_bg style=height:10px;></td></tr>
	  <?if($comment_count || $skin_setup[show_articleInfo]) {?>
		<tr><td class=lined style=height:1px><img src=<?=$dir?>/t.gif height=1></td></tr>
	  <? } ?>
		</table>
		<table border=0 cellspacing=0 cellpadding=0 width=100% class=info_bg>
		<tr><td class=info_bg style=height:10px;></td></tr>
		<tr>
		  <td valign=top style=padding-top:8px; width=30>&nbsp;</td>
		  <td><font class=thumb_han style="line-height:160%"><?=$comment_guide?></font></td>
		</tr>
		</table>
	  </td>
	  <td width=<?=$_rSwidth?>><img src=<?=$dir?>/t.gif width=<?=$_rSwidth?> height=1>
	</table>

	<table border=0 cellspacing=0 cellpadding=0 class=info_bg width=<?=$width?> style='table-layout:fixed'>
	<form method=post name=write action=<?=$_target_comment?>>
		<input type=hidden name=page value=<?=$page?>>
		<input type=hidden name=id value=<?=$id?>>
		<input type=hidden name=no value=<?=$no?>>
		<input type=hidden name=select_arrange value=<?=$select_arrange?>>
		<input type=hidden name=desc value=<?=$desc?>>
		<input type=hidden name=page_num value=<?=$page_num?>>
		<input type=hidden name=keyword value="<?=$keyword?>">
		<input type=hidden name=category value="<?=$category?>">
		<input type=hidden name=sn value="<?=$sn?>">
		<input type=hidden name=ss value="<?=$ss?>">
		<input type=hidden name=sc value="<?=$sc?>">
		<input type=hidden name=su value="<?=$su?>">
		<input type=hidden name=mode value="<?=$mode?>">
	<tr>	
		<td valign=top style="padding:8 5 0 0;" width=<?=$_lSpacer?> align=right>
		  <font class=bt onclick="document.write.memo.rows=6;document.write.memo.focus();" style="cursor:pointer;padding-top:3px;" title="<?=$_strSkin['org_memo']?>">¡á</font><br>
		  <font class=bt onclick="document.write.memo.rows=document.write.memo.rows+4;document.write.memo.focus();" style="cursor:pointer;padding-top:3px;" title="<?=$_strSkin['exp_memo']?>">¡å</font>
		</td>
		<td>
			<table border=0 cellspacing=2 cellpadding=0 width=100% height=100% style="table-layout:fixed;">
			<tr>
			  <td><textarea name=memo cols=20 rows=6 class=textarea style=width:100%></textarea></td>
			  <td width=<?=$_rSpacer?> align=center style="padding:1 0 1 0;"></td>
			</tr>

			<?if($usine_voteEX){?>
			<tr>
			  <td>
				<table border=0 cellspacing=2 cellpadding=0 width=100% height=100% style="table-layout:fixed;">
				<tr>
				  <td>&nbsp;</td>
				  <td width=115>
					<input name="ment_type" type="radio" value="<?=$vote_type?>" <?if($member[no]!=$data[ismember] && !$already_vote) echo "checked"?>><?=$vote_msg?><br>
					<input name="ment_type" type="radio" value="ment" <?if($member[no]==$data[ismember] || $already_vote) echo "checked"?>><?=$_strSkin['only_memo']?> </td>
				  <td width=85 style=padding-top:4px;><?
				if(!eregi(".gif",$_strSkin['save_commentEX'])) echo "<input type=submit rows=5 class=submit_c  name='reply_vote' value=$_strSkin[save_commentEX] accesskey='s' style='height:38;width:80'>";
				else echo "<input type=image src=$_strSkin[save_commentEX] name='reply_vote' accesskey='s'>";
				?></td>
				</tr></table>
			  </td>
			  <td>&nbsp;</td>
			</tr>		  

			<?} elseif($member['no']) {?>
			<tr>
			  <td align=right style="padding:4 8 0 0;"><?
				if(!eregi(".gif",$_strSkin['save_comment'])) echo "<input type=submit rows=5 class=submit_c  name='reply_vote' value=$_strSkin[save_comment] accesskey='s' style='height:28;width:80'>";
				else echo "<input type=image src=$_strSkin[save_comment] name='reply_vote' accesskey='s'>";
				?></td>
			  <td>&nbsp;</td>
			</tr>
			<?}?>
			</table>
		</td>
	</tr>
	<?if(!$member['no']){?>
	<tr>
		<td width=<?=$_lSwidth?> align=right>&nbsp;</td>
		<td>
		  <table border=0 cellspacing=2 cellpadding=0 height=100% align=right style='table-layout:fixed'>
			<tr>
				<td>&nbsp;</td>
				<td width=68 align=right><?=$_strSkin['name']?>&nbsp;</td>
				<td width=90><?=$c_name?></td>
				<td width=60 align=right><?=$_strSkin['password']?>&nbsp;</td>
				<td width=90><input type=password name=password <?=size(12)?> maxlength=20 class=input></td>
				<td width=85><?
				if(!eregi(".gif",$_strSkin['save_comment'])) echo "<input type=submit rows=5 class=submit_c  name='reply_vote' value=$_strSkin[save_comment] accesskey='s' style='height:28;width:80'>";
				else echo "<input type=image src=$_strSkin[save_comment] name='reply_vote' accesskey='s'>";
				?></td>
				<td width=<?=$_rSpacer?> align=right>&nbsp;</td>
			</tr>
		  </table>
		</td>
	</tr>
	<?}?>
	<tr><td class=info_bg style=height:20px;></td></tr>
	</form>
	</table>
<?
}
//$_miniwiniEditor_incFile = './miniwini.visualEditor.php';
//if(file_exists($_miniwiniEditor_incFile)) include $_miniwiniEditor_incFile;
?>