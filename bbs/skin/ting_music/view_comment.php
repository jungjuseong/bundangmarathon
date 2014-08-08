<?
  /* 간단한 답글을 출력하는 부분입니다.
   view.php스킨파일에 간단한 답글을 시작하는 <table>시작 태그가 시작되어 있습니다.
   그리고view_foot.php 파일에 </table>태그가 간단한 답글 쓰기 폼과 같이 있습니다

  <?=$comment_name?> : 글쓴이
  <?=$c_memo?> : 내용
  <?=$c_reg_date?> : 글을 쓴 날자;;
  <?=$a_del?> : 코멘트 삭제 버튼링크
  <?=$c_face_image?> : 멤버용 아이콘;;
 */
?>

<tr>
  <td colspan=2>
   <table border=0 align=center cellpadding=2 cellspacing=0  style="margin-top:1; margin-bottom:1;" width=100%>
   <tr align=center bgcolor=<?=$sC_light01?>>
     <td width=15% align=right style='word-break:break-all;' nowrap valign=top><?=$c_face_image?> <?=$comment_name?></td>
     <td width=60 style='word-break:break-all;' nowrap class=thm8 valign=top align=center><font style=font-size:7pt;>[<?=$c_reg_date?>]</td>
     <td width=8 nowrap valign=top><b>≫</b></td>
     <td align=left style='word-break:break-all;' valign=top><?=nl2br($c_memo)?></td>
     <td width=8 valign=top><img src=images/t.gif height=3 border=0><br><?=$a_del?><img src=<?=$dir?>/secret_head.gif border=0></a></td>
   </tr>
   </table>
 </td>
</tr>

