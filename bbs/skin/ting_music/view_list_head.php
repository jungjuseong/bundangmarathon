<table border=0 cellspacing=0 cellpadding=0 width=<?=$width?>>
<tr><td width=1>
<form method=post name=list action=list_all.php>
<input type=hidden name=page value=<?=$page?>>
<input type=hidden name=id value=<?=$id?>>
<input type=hidden name=select_arrange value=<?=$select_arrange?>>
<input type=hidden name=desc value=<?=$desc?>>
<input type=hidden name=page_num value=<?=$page_num?>>
<input type=hidden name=selected>
<input type=hidden name=exec>
<input type=hidden name=keyword value="<?=$keyword?>">
<input type=hidden name=sn value="<?=$sn?>">
<input type=hidden name=ss value="<?=$ss?>">
<input type=hidden name=sc value="<?=$sc?>">
</td></tr><tr><td width=100%>

<table><tr><td align=left>
관련 노래 모음 ≫
</td></tr></table>
<table border=0 cellspacing=0 cellpadding=0 width=100%>
<tr align=center>
  <td>
    <table border=0 height=18 cellspacing=0 cellpadding=0 width=30 background=<?=$dir?>/images/h_left.gif>
       <tr><td align=center valign=top><img src=images/t.gif height=3 align=absmiddle></td></tr>
    </table>
  </td>
<?=$hide_category_start?>
  <td>
    <table border=0 height=18 cellspacing=0 cellpadding=0 width=70 background=<?=$dir?>/images/h_base.gif>
       <tr><td align=center valign=bottom><b>Category</b></td></tr>
    </table>  
  </td>
<?=$hide_category_end?>
  <td width=100%>
    <table border=0 height=18 cellspacing=0 cellpadding=0 width=100% background=<?=$dir?>/images/h_base.gif>
       <tr><td align=center valign=bottom><b>Subject</b></td></tr>
    </table>
  </td>
  <td>
    <table border=0 height=18 cellspacing=0 cellpadding=0 width=70 background=<?=$dir?>/images/h_base.gif>
       <tr><td align=center valign=bottom><b>Date</b></td></tr>
    </table>
  </td>
  <td>
    <table border=0 height=18 cellspacing=0 cellpadding=0 width=55 background=<?=$dir?>/images/h_base.gif>
       <tr><td align=center valign=bottom><b>R</b></td></tr>
    </table>
  </td>
  <td>
    <table border=0 height=18 cellspacing=0 cellpadding=0 width=30 background=<?=$dir?>/images/h_base.gif>
       <tr><td align=center valign=bottom><b>V</b></td></tr>
    </table>
  </td>
  <td>
    <table border=0 height=18 cellspacing=0 cellpadding=0 width=25 background=<?=$dir?>/images/h_right.gif>
       <tr><td align=center valign=bottom><b>S</b></td></tr>
    </table>
  </td>
</tr>
