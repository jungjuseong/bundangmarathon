<? include "$dir/variable.php"; ?>
<table align="center" border=0 width=<?=$width?> cellspacing=0>
  <tr>
    <td width=<?=width?> height="3" bgcolor=#EBEAEA></td>
  </tr>
</table>
<table align="center" border=0 width=<?=$width?> cellspacing=0>
    <tr>
        <td width="803" height="2" colspan="5" ></td>
    </tr>
    <tr>
        <td width="110"  rowspan="2" valign=top align=center>
            <table border=0 valign=top>
                <tr>
                    <td width="110">
                       <?
                          if($data[sitelink2]) {
                       ?> 
                           <img src="<?=$dir?>/icon/icon_<?echo "$data[sitelink2]"?>.gif" border=0 width=100 height=100>
                       <?} else {?>
                           <img src="<?=$dir?>/icon/icon_1.gif" border=0 width=100 height=100>
                       <?}?>
                    </td>
                </tr>
                <tr>
                    <td width="110">
                     <img src=<?=$dir?>/t.gif border=0 height=3><br>
                     <?=$face_image?>&nbsp;<?=$name?></b><br>
                    </td>
                </tr>
                <tr>
                    <td width="110" align=right>

	            <? if ($rMainViewDate==1) { 
	                if ($rDateDisplay==1) {  
	            ?>
		<?= $date=date("m/d H:i", $data[reg_date])?><br>
	            <? } else { ?>
	            <?= $date=date("Y/m/d", $data[reg_date])?><br>

            	<? }
	              }
	             ?>


	         <?=$hide_cart_start?><input type=checkbox name=cart value="<?=$data[no]?>"><?=$hide_cart_end?>
                     <? 
                      if ($data[homepage])  {
                         echo "<a href='$data[homepage]' onfocus=blur() target=_blank><img src=$dir/home.gif onfocus=blur() border=0></a>";
                      }
                     ?>
                     <?=$a_reply?><img src=<?=$dir?>/reply_s.gif onfocus=blur() border=0 ></a>
                     <?=$a_modify?><img src=<?=$dir?>/modify_s.gif onfocus=blur() border=0></a>
                     <?=$a_delete?><img src=<?=$dir?>/delete_s.gif onfocus=blur() border=0></a>
                    </td>
                </tr>
            </table>
        </td>
        <td width="1" rowspan="2" ></td>
        <td width="8"  rowspan="2" bgcolor=#EBEAEA></td>
        <td width="5"  rowspan="2" ></td>
        <td height="1" valign=top align=left >
            <table border=0 width=100%>
                <tr>
                    <td width=100% valign=center>
                     &nbsp;<img src=<?=$dir?>/no_icon.gif border=0>&nbsp;<?=$number?>
                     <? if ($rViewSubject==1) { ?>
		&nbsp;<?=$data[subject]?>
	         <? } ?>
 

                    </td>
                </tr>
                <tr valign=top>
                   <td  valign=top height=100% style='word-break:break-all;' >
	          <img src=<?=$dir?>/t.gif border=0 height=10><br>
	          <?=$memo?><br>
                   </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<?  include "include/get_reply.php"; ?>
<table border=0 cellspacing=0 cellpadding=0 height=5><tr><td></td></tr></table> 
