<? /////////////////////////////////////////////////////////////////////////
  /*
  이 파일은 목록을 다 출력한 다음 마무리 짓는 부분입니다.
  테이블을 닫고 페이지 출력이나 검색 출력, 버튼등을 출력하면 됩니다.
  아래부분은 그대로 사용하시면 됩니다.


  <?=$a_1_prev_page?> : 이전페이지를 출력합니다. (한페이지씩 이동)
  <?=$a_1_next_page?> : 다음 페이지를 출력합니다. (한페이지씩 이동)
  <?=$a_prev_page?> : 이전페이지를 출력합니다.
  <?=$a_next_page?> : 다음 페이지를 출력합니다.
  <?=$print_page?> : 페이지를 출력합니다
  <?=$a_write?> : 글쓰기 버튼
  <?=$a_list?> : 목록보기 버튼
  <?=$a_cancel?> : 취소 버튼
  <?=$a_reply?> : 답글쓰기 버튼
  <?=$a_delete?> : 글삭제 버튼
  <?=$a_modify?> : 글수정 버튼
  <?=$a_delete_all?> : 관리자일때 나타나는 선택된 글 삭제 버튼;;

  */
///////////////////////////////////////////////////////////////////////// ?>

<!-- 마무리 부분입니다 -->
</table>
<table border=0 cellpadding=0 cellspacing=0 width=100%>
<tr>
 <td></td>
 <td>

<!-- 버튼 부분 -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td height="7">
            <p></p>
        </td>
    </tr>
</table>
<table border=0 cellspacing=0 cellpadding=0 width=100%>
<tr>
 <td width=40% nowrap>
 <img src=<?=$dir?>/images/all_select.gif border=0 align=absmiddle title='전체선택,선택취소' onfocus=blur() onClick="CheckAll()" style="cursor:hand"><?
if($setup[grant_view]<$member[level]&&!$is_admin){
	?><img src=<?=$dir?>/images/select_music.gif border=0 alt='선택음악듣기' style="cursor:hand;" align=absmiddle  onClick="alert('사용권한이 없습니다.')"><?
} else {
	?><a onfocus=blur() href='javascript:listen_all()'><img src=<?=$dir?>/images/select_music.gif border=0 align=absmiddle title="선택음악듣기"></a><?
}
if($setup[grant_view]<$member[level]&&!$is_admin){
	?><img src=<?=$dir?>/images/cart1.gif border=0 alt='선택음악 앨범에 담기' style="cursor:hand;" align=absmiddle  onClick="alert('사용권한이 없습니다.')"><?
} else {
	?><a onfocus=blur() href='javascript:Cart()'><img src=<?=$dir?>/images/cart1.gif border=0 align=absmiddle title="선택음악 앨범에 담기"></a><?
}
?><a href=javascript:CartWindow()><img src=<?=$dir?>/images/album.gif border=0 align=absmiddle title='나의앨범보기' onfocus=blur()></a></td>
 <td align=center colspan=2 nowrap>
<?=$a_prev_page?>[PREV]</a> <?=$print_page?> <?=$a_next_page?>[NEXT]</a>

 </td>
 <td align=right width=40%>
  <?=$a_delete_all?><img src=<?=$dir?>/images/btn_manage.gif border=0 align=absmiddle></a>
<?=$a_write?><img src=<?=$dir?>/images/btn_write.gif border=0 align=absmiddle></a>
 </td>
</tr>
</form>
</table>

 </td>
</tr>
<tr>
 <td>

 </td>
 <td>



</td></tr></table>
