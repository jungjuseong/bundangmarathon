<?  /* 간단한 답글을 출력하는 부분입니다.   view.php스킨파일에 간단한 답글을 시작하는 <table>시작 태그가 시작되어 있습니다.   그리고view_foot.php 파일에 </table>태그가 간단한 답글 쓰기 폼과 같이 있습니다  <?=$comment_name?> : 글쓴이  <?=$c_memo?> : 내용  <?=$c_reg_date?> : 글을 쓴 날자;;  <?=$a_del?> : 코멘트 삭제 버튼링크  <?=$c_face_image?> : 멤버용 아이콘;; */?>


<tr>
  <td colspan=2>
   <table border=0 align=center cellpadding=0 cellspacing=8 width=97%>
   <tr>
      <td width=65 class=thm9 valign=top><b><?=$comment_name?></b></td> 
      <td width=4 bgcolor=e3e3e3></td>
	 <td class=thm9 style='word-break:break-all;' valign=top><p style=line-height:150%><?=nl2br($c_memo)?></p></td>
     <td nowrap align=right valign=top width=70><font style='word-break:break-all;font-family:Tahoma;font-size:7pt'><?=$c_reg_date?></font><br><?=$a_del?><img src=<?=$dir?>/image/c_delete.gif border=0 alt="삭제"></a></td>
</tr>
<tr>
<td height=1 colspan=5 background=<?=$dir?>/image/dot.gif><img src=<?=$dir?>/image/dot.gif border=0 height=1></td>
</tr>

   </table>
 </td>
</tr>

