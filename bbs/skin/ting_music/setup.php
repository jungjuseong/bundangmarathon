<?
  /*
  이 파일은 게시판에서 상단의 상태를 보여줍니다.

  <?=$width?> : 게시판의 가로크기
  <?=$dir?> : 스킨디렉토리를 가리킵니다.
  <?=$total?> : 전체 글수
  <?=$total_page?> : 전체 페이지수
  <?=$a_status?> : 통계링크
  <?=$a_login?> : 로그인 버튼
  <?=$a_logout?> : 로그오프버튼
  <?=$page?> : 현재페이지 표시

  <?=$a_member_join?> : 회원가입
  <?=$a_member_modify?> : 회원정보수정
  <?=$a_member_memo?> : 쪽지;;
  <?=$member_memo_icon?> : 쪽지아이콘;;
  <?=$memo_on_sound?> : 쪽지가 왔을때 소리 나오는 변수 memo_on.swf

  <?=$total_connect?> : 현재 전체 회원 로그인수
  <?=$group_connect?> : 현재 그룹 로그인수

  * 쪽지아이콘은 member_memo_on.gif, member_memo_off.gif 파일이 있습니다. (기본)
    member_memo_on.gif는 새로운 쪽지가 있을때, 글고 member_memo_off.gif는 새쪽지가 없을때입니다;;

  */
include "$dir/value.php3"; ?>
<script>
var chk;
chk=false;
function CheckAll()
{
	if (!chk){
		for (i=0;i<document.list.length;i++)
		{
			if(document.list[i].type=='checkbox')
		   {
				document.list[i].checked=true;
			}
		}
		chk=true;
	}
	else
	{
		for (i=0;i<document.list.length;i++)
		{
			if(document.list[i].type=='checkbox')
			{
				document.list[i].checked=false;
			}
		}
		chk=false;
	}
}


</script>



<? include "$dir/listen_alljs.php"; ?>
<? include "$dir/cart_js.php"; ?>



<table border=0 cellspacing=0 cellpadding=0 width=<?=$width?>>
<tr>
  <td valign=bottom>
<a href=javascript:CartWindow()><img src=<?=$dir?>/images/album_s.gif border=0 align=absmiddle title='나의앨범보기' onfocus=blur()></a>
<!-- 검색폼 부분 ---------------------->
<!-- 폼태그 부분;; 수정하지 않는 것이 좋습니다 -->
<form method=post name=search action=<?=$PHP_SELF?>>
<input type=hidden name=page value=<?=$page?>>
<input type=hidden name=id value=<?=$id?>>
<input type=hidden name=select_arrange value=<?=$select_arrange?>>
<input type=hidden name=desc value=<?=$desc?>>
<input type=hidden name=page_num value=<?=$page_num?>>
<input type=hidden name=selected>
<input type=hidden name=exec>
<input type=hidden name=sn value="<?=$sn?>">
<input type=hidden name=ss value="<?=$ss?>">
<input type=hidden name=sc value="<?=$sc?>">
<input type=hidden name=category value="<?=$category?>">
<!-----------------------------------------------></td>

   <td width=10% valign=bottom>&nbsp;<input type=text name=keyword value="<?=$keyword?>" <?=size(15)?> class=input style=font-size:9pt;font-family:Arial;border-left-color:#c0c0c0;border-right-color:#c0c0c0;border-top-color:#c0c0c0;border-bottom-color:#c0c0c0;height:18px;>&nbsp;<input type=image border=0 align=absmiddle src=<?=$dir?>/images/search_right.gif></a>

</td><TD width=85% valign=bottom><td <?if(!$setup[use_category]) echo"align=right";?>>
</td></form>

<td align=right valign=bottom>&nbsp;<?=$a_login?><img src=<?=$dir?>/s_login.gif border=0></a><?=$a_logout?><img src=<?=$dir?>/s_logout.gif border=0></a>&nbsp;
<?=$a_setup?><img src=<?=$dir?>/s_setup.gif border=0></a></td><td align=right valign=bottom><?=$hide_category_start?>&nbsp;<?=$a_category?></td>
<?=$hide_category_end?>
 </tr>
<TR align=middle>
                <TD class=light vAlign=top align=middle height="1" width="100%" colspan="7" bgcolor="#999999">
</TD>
</TR>
</table>
