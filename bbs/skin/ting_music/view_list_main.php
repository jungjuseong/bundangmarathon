<tr align=center bgcolor=<?=$sC_light0?>>
  <td class=thm8 nowrap valign=top><img src=images/t.gif height=1 border=0></td>
<?=$hide_category_start?><td valign=top><img src=images/t.gif height=3><br><?=$category_name?></td><?=$hide_category_end?>
  <td align=left style='word-break:break-all;' valign=top><p style="text-indent:-10; margin-top:3; margin-left:10;"><?=$insert?><?=$icon?><?=$subject?> <font style=font-family:Tahoma;font-size:6pt;font-weight:bold;letter-spacing:-1px;><?=$comment_num?></font></p></td> 
  <td class=thm8 nowrap valign=top><img src=images/t.gif height=3><br><?=$reg_date?></td>
  <td class=thm8 nowrap valign=top><img src=images/t.gif height=3><br><?=$hit?></td>
  <td class=thm8 nowrap valign=top><img src=images/t.gif height=3><br><?=$vote?></td>
  <td class=thm8 nowrap valign=top><?if($sitelink1) {?><a href="#" OnClick="Javascript:window.open('<?echo $dir;?>/song_play1.php?<?echo "id=$id&no=$data[no]";?>','ballad', 'width=400, height=300, scrollbars=no, resizable=0, status=no, menubar=0')"> <?echo"<img src=$dir/images/song.gif border=0>";?><?}?></a>
  <?if($sitelink2) {?><a href="#" OnClick="Javascript:window.open('<?echo $dir;?>/song_play2.php?<?echo "id=$id&no=$data[no]";?>','ballad', 'width=400, height=300, scrollbars=no, resizable=0, status=no, menubar=0')"> <?echo"<img src=$dir/images/song.gif border=0>";?><?}?></a>
  <?if($file_name1) {?><a href="#" OnClick="Javascript:window.open('<?echo $dir;?>/song_play3.php?<?echo "id=$id&no=$data[no]";?>','ballad', 'width=400, height=300, scrollbars=no, resizable=0, status=no, menubar=0')"> <?echo"<img src=$dir/images/song.gif border=0>";?><?}?></a>
  <?if($file_name2) {?><a href="#" OnClick="Javascript:window.open('<?echo $dir;?>/song_play4.php?<?echo "id=$id&no=$data[no]";?>','ballad', 'width=400, height=300, scrollbars=no, resizable=0, status=no, menubar=0')"> <?echo"<img src=$dir/images/song.gif border=0>";?><?}?></a>
</td>
</tr>
<tr>
 <td colspan=8 bgcolor=<?=$sC_light1?>><img src=images/t.gif height=1></td>
</tr>