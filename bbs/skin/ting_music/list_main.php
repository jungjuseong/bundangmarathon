<? /////////////////////////////////////////////////////////////////////////
 /*
 목록을 출력하는 부분입니다.
 목록은 여러개이기 때문에 이 파일을 계속 읽어서 출력합니다.
 순환이 되도록 잘 작성하셔야 합니다.
 아래는 HTML 안에 그대로 사용해주시면 순환을 하면서 출력을 합니다.

 <?=$number?> : 가상번호. 즉 순서대로 나오는 번호
 * <?=$data[no]?> : 절대번호, 절대 바뀌지 않는 번호..
 * <?=$loop_number?> : 현재 선택되어 있는 글이라도 번호로 나오게
 <?=$name?> : 메일이 링크되어 있는 이름 * 원래 그대로 <?=$data[name]?>
 <?=$email?> : 메일.. 거의 직접 쓸일은 없음;;
 <?=$subject?> : 링크가 되어 있는 제목  * 원래 그대로 <?=$data[suject]?>
 <?=$memo?> : 내용 부분
 <?=$hit?> : 조회수
 <?=$vote?> : 추천수
 <?=$ip?> : 아피주소
 <?=$comment_num?> : 간단한 답글 수 [ ] 가 둘러싸여 있는것;; <?=$data[comment_num]?> 은 숫자만;;
 <?=$reg_date?> : 글쓴 날자
 <?=$category_name?> : 카테고리 이름

 <?=$face_image?> : 현재 회원상태의 아이콘;;

 <?=$insert?> : 답글일경우 한칸씩 들어가는 깊이를 출력합니다.
 <?=$icon?>   : 현재 글의 상태에 따라서 아이콘을 출력합니다.

 바구니와 카테고리의 경우 사용하지 않는 수가 있으므로 숨겨놓을때 쓰는 변수;;
 <?=$hide_cart_start?> 내용 <?=$hide_cart_end?> : start 와 end 사이에는 사라짐;; 바구니
 <?=$hide_category_start?> 내용 <?=$hide_category_end?> : Start와 end 사이에는 사라짐;; 바구니


 참고: old_head.gif : 원본글이면서 12시간이 넘은 글의 아이콘
       new_head.gif : 12시간에 적히 모든 글. 원본/답글 상관없이
       reply_head.gif : 12시간이 지난 답글의 아이콘
       reply_new_head.gif : 12시간이 지나지 않은 답글의 아이콘;;
       notice_head.gif : 공지사항일때 아이콘
       secret_head.gif : 비밀글을때 나타나는 아이콘
       arror.gif : 현재 리스트에서 선택되어 있는 글 앞에 붙는 아이콘
 */
///////////////////////////////////////////////////////////////////////// ?>
<!-- 목록 부분 시작 -->

<?
$data[sitelink1]=stripslashes($data[sitelink1]);
$data[sitelink2]=stripslashes($data[sitelink2]);
$data[file_name1]=stripslashes($data[file_name1]);
$data[file_name2]=stripslashes($data[file_name2]);
$sitelink1="";
if(!eregi("\.smi",$data[sitelink1])) $sitelink1="$data[sitelink1]";
$sitelink2="";
if(!eregi("\.smi",$data[sitelink2])) $sitelink2="$data[sitelink2]";
$file_name1="";
if(!eregi("\.smi",$data[file_name1])) $file_name1="$data[file_name1]";
$file_name2="";
if(!eregi("\.smi",$data[file_name2])) $file_name2="$data[file_name2]";
if(($sitelink1 || $file_name1)) {$mu1=1;}else {$mu1=0;}
if(($sitelink2 || $file_name2)) {$mu2=1;}else {$mu2=0;}
if(strlen($data[memo])>$dasom_length2){$gasa=1;}else{$gasa=0;}
?>
 <tr align=left height=30 onMouseOver=this.style.backgroundColor='FFF1E4' onMouseOut=this.style.backgroundColor=''>
  <td valign=middle align=center><img src=images/t.gif height=3><br><b><font color="#DF6336"><?=$number?></font></b></td>
<td valign=middle><?
if(($sitelink1 || $file_name1)) {?><input type=checkbox name=cart value="<?=$data[no]?>" onfocus=blur()><?
} else {?><input type=checkbox name=cart value="<?=$data[no]?>" onfocus=blur() disabled><?
}?></td>
<td align=left valign=middle style='word-break:break-all;'><img src=images/t.gif height=3><br>
&nbsp;<img src="<?=$dir?>/images/mp3a.gif" width="28" height="15" border="0">&nbsp;<?
if($setup[grant_view]<$member[level]&&!$is_admin){
	if(($sitelink1 || $file_name1)) {?><a href="javascript://" onClick="alert('로그인을 하셔야 이페이지를 열수 있습니다.')"><?=$data[subject]?></a><?
	} else {?><a href="javascript://" onClick="alert('로그인을 하셔야 이페이지를 열수 있습니다.')">&nbsp;&nbsp;<?=$data[subject]?></a><?
	}
} else {
	if(($sitelink1 || $file_name1)) {?><a href="javascript:;" OnClick="window.open('<?echo $dir;?>/song_play.php?<?echo "id=$id&no=$data[no]";?>','yhkimdasommusicIT','scrollbars=no,resizable=no height=255 width=375 top=50 left=50');"><?=$data[subject]?></a><?
	} else {?><a href="javascript://" onClick="alert('등록된 곡이 없습니다.')">&nbsp;&nbsp;<?=$data[subject]?></a><?
	}
}?>
</td>
<td align=right valign=middle style='word-break:break-all;'><img src=images/t.gif height=3><br>
<?=$a_modify?><img src=<?=$dir?>/images/modify_s.gif border=0  align=absmiddle></a><?=$a_delete?><img src=<?=$dir?>/images/delete_s.gif border=0  align=absmiddle></a><?
if($setup[grant_view]<$member[level]&&!$is_admin){
	if(($sitelink1 || $file_name1)) {?><a href="javascript://" onClick="alert('사용권한이 없습니다.')"><img src=<?=$dir?>/images/audio_on.gif border=0 align=absmiddle></a><?
	} else {?><a href="javascript://" onClick="alert('사용권한이 없습니다.')"><img src=<?=$dir?>/images/audio_on.gif border=0 align=absmiddle></a><?
	}
} else {?><?if(($sitelink1 || $file_name1)) {?><a href="javascript:;" OnClick="window.open('<?echo $dir;?>/song_play.php?<?echo "id=$id&no=$data[no]";?>','yhkimdasommusicIT','scrollbars=no,resizable=no height=255 width=375 top=50 left=50');"><img src=<?=$dir?>/images/audio_on.gif border=0 align=absmiddle></a><?
	} else {?><a href="javascript://" onClick="alert('등록된 곡이 없습니다.')"><img src=<?=$dir?>/images/audio_on.gif border=0 align=absmiddle></a><?
	}
}
if($setup[grant_view]<$member[level]&&!$is_admin){
	if(($sitelink1 || $file_name1)) {?><a href="javascript://" onClick="alert('사용권한이 없습니다.')"><img src=<?=$dir?>/images/cart.gif border=0 align=absmiddle></a><?
	} else {?><a href="javascript://" onClick="alert('사용권한이 없습니다.')"><img src=<?=$dir?>/images/cart.gif border=0 align=absmiddle></a><?
	}
} else {
	if(($sitelink1 || $file_name1)) {?><a href="javascript:;" OnClick="Cart('<?=$data[no];?>');"><img src=<?=$dir?>/images/cart.gif border=0 align=absmiddle></a><?
	} else {?><a href="javascript://" onClick="alert('등록된 곡이 없습니다.')"><img src=<?=$dir?>/images/cart.gif border=0 align=absmiddle></a><?
	}
}
if($setup[grant_view]<$member[level]&&!$is_admin){
	if(strlen($data[memo])>$dasom_length2){?><img src=<?=$dir?>/images/gasa.gif border=0 alt='가사보기' style="cursor:hand;" align=absmiddle  onClick="alert('사용권한이 없습니다.')"><?
	} else {?><img src=<?=$dir?>/images/gasa.gif border=0 style="cursor:hand;"  onClick="alert('등록된 곡이 없습니다.')" align=absmiddle><?
	}
} else {
	if(strlen($data[memo])>$dasom_length2){?><img src=<?=$dir?>/images/gasa.gif border=0 style="cursor:hand;" onclick="javascript:window.open('<?=$dir?>/Dasom_Words.php?<?echo "id=$id&no=$data[no]";?>' , 'Words', ' width=348 height=507 toolbar=no location=no status=no directories=no scrollbars=no resizable=no copyhistory=no');" align=absmiddle alt='가사보기'><?
	}else{?><img src=<?=$dir?>/images/gasa.gif border=0 style="cursor:hand;"  onClick="alert('등록된 가사가 없습니다.')" align=absmiddle><?
	}
}
if($setup[grant_reply]<$member[level]&&!$is_admin){?><img src=<?=$dir?>/images/musicmail.gif border=0 style="cursor:hand;" onClick="alert('사용권한이 없습니다.')" align=absmiddle alt='메일로 보내기'><?
} else {?><img src=<?=$dir?>/images/musicmail.gif border=0 style="cursor:hand;" onclick="javascript:window.open('./sendmail_this2.php?<?echo "id=$id&no=$data[no]";?>' , 'sendmail', ' width=400,height=500 toolbar=no location=no status=no directories=no scrollbars=no resizable=no copyhistory=no');" align=absmiddle alt='메일로 보내기'><?
}
if($setup[grant_view]<$member[level]&&!$is_admin){
	if(($sitelink2 || $file_name2)) {?><img src=<?=$dir?>/images/musicmv.gif border=0 alt='뮤직 비디오 보기' style="cursor:hand;" align=absmiddle  onClick="alert('사용권한이 없습니다.')"><?
	} else {?><img src=<?=$dir?>/images/musicmv_no.gif border=0 style="cursor:hand;"  onClick="alert('등록된 곡이 없습니다.')" align=absmiddle><?
	}
} else {
	if(($sitelink2 || $file_name2)) {?><a href="javascript:;" OnClick="window.open('<?echo $dir;?>/song_play2.php?<?echo "id=$id&no=$data[no]";?>','yhkimdasommusicIT','scrollbars=no,resizable=no height=215 width=375 top=50 left=50');"><?echo"<img src=$dir/images/musicmv.gif border=0 alt='뮤직 비디오' align=absmiddle>";?><?
	} else {?><img src=<?=$dir?>/images/musicmv_no.gif border=0 style="cursor:hand;"  onClick="alert('등록된 곡이 없습니다.')" align=absmiddle><?
	}
}?></a><img src=<?=$dir?>/images/none.gif border=0 align=absmiddle border=0 width=2>
</td>
<td align=center><img src=images/t.gif height=6><br><?=$hit?></td>
</tr>
<tr>
 <td colspan=7 bgcolor=<?=$sC_light1?>><img src=images/t.gif height=1></td>
</tr>
