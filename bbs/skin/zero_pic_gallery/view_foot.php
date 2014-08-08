<?
 /* ÀÌÀü ´ÙÀ½±Û°ú ¹öÆ° Ç¥½Ã
 
  --- ÀÌÀü/ ÀÌÈÄ±Û ¸µÅ© ---
  <?=$a_prev?> : ÀÌÀü±Û ¸µÅ©
  <?=$a_next?> : ´ÙÀ½±Û ¸µÅ©

  <?=$prev_face_image?> : ÀÌÀü±Û ±Û¾´ÀÌÀÇ ¾ó±¼ ¾ÆÀÌÄÜÜ;;
  <?=$next_face_image?> : ´ÙÀ½±Û ±Û¾´ÀÌÀÇ ¾ó±¼ ¾ÆÀÌÄÜÜ;;


  <?=$hide_prev_start?> <?=$hide_prev_end?> : ÀÌÀü±Û ³ªÅ¸³ª±â/ ¼û±â±â
  <?=$hide_next_start?> <?=$hide_next_end?> : ´ÙÀ½±Û ³ªÅ¸³ª±â/ ¼û±â±â

  ±âÅ¸ Á¦¸ñÀÌ³ª ±Û¾´ÀÌµîÀº À§ÀÇ µ¥ÀÌÅ¸¿¡¼­ ¾Õ¿¡ prev_ , next_ ¸¦ µ¡ ºÙÀÎ°ÍÀÓ;
  ex) ÀÌÀü±Û Á¦¸ñ : <?=$prev_subject?>

  <?=$a_write?> : ±Û¾²±â ¹öÆ°
  <?=$a_list?> : ¸ñ·Ïº¸±â ¹öÆ°
  <?=$a_reply?> : ´ä±Û¾²±â ¹öÆ°
  <?=$a_delete?> : ±Û»èÁ¦ ¹öÆ°
  <?=$a_vote?> : ÃßÃµ¹öÆ°
  <?=$a_modify?> : ±Û¼öÁ¤ ¹öÆ°

 */
?>

<!-- ÀÌÀü / ´ÙÀ½±Û Ãâ·Â -->

<?=$hide_prev_start?>
<table border=0 width=<?=$width?> cellspacing=0 cellpadding=0 bgcolor=<?=$_color1?>>
<tr><td colspan=10 bgcolor=888888><img src=images/t.gif height=1></td></tr>
<tr align=center>
  <td width=8% style='word-break:break-all;font-family:matchworks;font-size:10px'>PREV</td>
  <td width=82% align=left style='word-break:break-all;'>&nbsp; <?=$a_prev?><?=$prev_subject?></a></td>
  <td width=10% nowrap><?=$prev_face_image?> <?=$prev_name?></td>
</tr>
</table>
<?=$hide_prev_end?>

<?=$hide_next_start?>
<table border=0 width=<?=$width?> cellspacing=0 cellpadding=0  bgcolor=<?=$_color1?>>
<tr><td colspan=10 bgcolor=888888><img src=images/t.gif height=1></td></tr>
<tr align=center>
  <td width=8% style='word-break:break-all;font-family:matchworks;font-size:10px'>NEXT</td>
  <td width=82% align=left style='word-break:break-all;'>&nbsp; <?=$a_next?><?=$next_subject?></a></td>
  <td width=10% nowrap><?=$next_face_image?> <?=$next_name?></td>
</tr>
</table>

<?=$hide_next_end?>
<table border0 width=<?=$width?> cellspacing=0 cellpadding=0><tr><td colspan=10 bgcolor=888888><img src=images/t.gif height=1></td></tr></table>

<!-- ¹öÆ° °ü·Ã Ãâ·Â -->
<br>
<table border=0 cellspacing=0 cellpadding=0 width=<?=$width?>>
<tr>
 <td>
    <?=$a_list?><img src=<?=$dir?>/i_list.gif border=0></a>
    <?=$a_write?><img src=<?=$dir?>/i_write.gif border=0></a>
 </td>
 <td align=right>
    <?=$a_reply?><img src=<?=$dir?>/i_reply.gif border=0></a>
    <?=$a_modify?><img src=<?=$dir?>/i_modify.gif border=0></a>
    <?=$a_delete?><img src=<?=$dir?>/i_delete.gif border=0></a>
 </td>
</tr>
</table>
<br><br>

