<?
 /* 이전 다음글과 버튼 표시

  --- 이전/ 이후글 링크 ---
  <?=$a_prev?> : 이전글 링크
  <?=$a_next?> : 다음글 링크

  <?=$prev_face_image?> : 이전글 글쓴이의 얼굴 아이콘?;
  <?=$next_face_image?> : 다음글 글쓴이의 얼굴 아이콘?;


  <?=$hide_prev_start?> <?=$hide_prev_end?> : 이전글 나타나기/ 숨기기
  <?=$hide_next_start?> <?=$hide_next_end?> : 다음글 나타나기/ 숨기기

  기타 제목이나 글쓴이등은 위의 데이타에서 앞에 prev_ , next_ 를 덧 붙인것임;
  ex) 이전글 제목 : <?=$prev_subject?>

  <?=$a_write?> : 글쓰기 버튼
  <?=$a_list?> : 목록보기 버튼
  <?=$a_reply?> : 답글쓰기 버튼
  <?=$a_delete?> : 글삭제 버튼
  <?=$a_vote?> : 추천버튼
  <?=$a_modify?> : 글수정 버튼

 */
?>

<!-- 이전 / 다음글 출력 -->
<table border=0 cellpadding cellspacing=0 width=100%>
<tr>
<td colspan=10 bgcolor=<?=$sC_dark0?>><img src=images/t.gif height=2></td></tr>
</table>

<?=$hide_prev_start?>
<table border=0 width=100% cellspacing=0 cellpadding=0>
<tr>
 <td colspan=8 bgcolor=<?=$sC_light1?>><img src=images/t.gif height=1></td>
</tr>
<tr align=center height=22>
  <td width=10% style='word-break:break-all;'><img src=images/t.gif height=3><br>[이전곡]</td>
  <td width=50% align=left style='word-break:break-all;'><img src=images/t.gif height=3><br>&nbsp; <?=$prev_icon?><?=$a_prev?><?=$prev_subject?></a></td>
  <td width=20% style='word-break:break-all;'><img src=images/t.gif height=3><br></td>
  <td width=10% class=thm8 nowrap><?=$prev_reg_date?></td>
</tr>
</table>
<?=$hide_prev_end?>

<?=$hide_next_start?>
<table border=0 width=100% cellspacing=0 cellpadding=0>
<tr>
 <td colspan=8 bgcolor=<?=$sC_light1?>><img src=images/t.gif height=1></td>
</tr>
<tr align=center height=22>
  <td width=10% style='word-break:break-all;'><img src=images/t.gif height=3><br>[다음곡]</td>
  <td width=50% align=left style='word-break:break-all;'><img src=images/t.gif height=3><br>&nbsp; <?=$next_icon?><?=$a_next?><?=$next_subject?></a></td>
  <td width=20% style='word-break:break-all;'><img src=images/t.gif height=3><br></td>
  <td class=thm8 width=10% nowrap><?=$next_reg_date?></td>
</tr>
</table>

<?=$hide_next_end?>

<!-- 버튼 관련 출력 -->
<table border=0 cellpadding cellspacing=0 width=100%>
<tr><td colspan=10 bgcolor=<?=$sC_dark0?>><img src=images/t.gif height=3></td></tr>
</table>

<table border=0 cellspacing=0 cellpadding=0 width=100%>
<tr height=23>
 <td>
    <?=$a_list?><img src=<?=$dir?>/images/btn_list.gif border=0 align=absmiddle></a>
    <?=$a_write?><img src=<?=$dir?>/images/btn_write.gif border=0 align=absmiddle></a>
 </td>
 <td align=right>
    <b  onclick="alert('추천이 반영되었습니다.')"><?=$a_vote?><img src=<?=$dir?>/images/btn_vote.gif border=0 align=absmiddle></a></b>
    <?=$a_reply?><img src=<?=$dir?>/images/btn_reply.gif border=0 align=absmiddle></a>
    <?=$a_modify?><img src=<?=$dir?>/images/btn_modify.gif border=0 align=absmiddle></a>
    <?=$a_delete?><img src=<?=$dir?>/images/btn_delete.gif border=0 align=absmiddle></a>
 </td>
</tr>
</table>

<br>
  </td>
  <td background=<?=$dir?>/images/m_5.gif><img src=<?=$dir?>/images/m_5.gif border=0></td>
</tr>
<tr>
  <td>
  <img src=<?=$dir?>/images/m_6.gif border=0></td>
  <td background=<?=$dir?>/images/m_7.gif width=100%>
  <td><img src=<?=$dir?>/images/m_8.gif border=0></td>
</tr>
</table>
