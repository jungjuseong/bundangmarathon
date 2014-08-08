<table align="center" border=0 width=<?=$width?> cellspacing=0>
  <tr>
    <td width=<?=width?> height="5" ></td>
  </tr>
</table>

<table border=0 cellspacing=0 cellpadding=0 width=<?=$width?>>
    <tr>
        <td align=right>
            <div align="right">
                <table border=0 cellspacing=0 class=rReplyWidth   bgcolor=#F8F8F8 >
                    <tr>
                        <td  width="5" height="61" valign=top></td>
                        <td height="61" valign=top>
                            <table border=0 cellspacing=0 width=100% height=100%>
                                <tr>
     			<td  height=10 align=right ></td>
                                </tr>
                                <tr>
     			<td  style='word-break:break-all;' align=right valign=top><?=$memo?></td>
                                </tr>
                                <tr>
     			<td  height=5 align=right></td>
                                </tr>
                            </table>
                        </td>
                        <td width="10" height="61"></td>
                        <td width="5" height="61" bgcolor=#EBEAEA></td>
                        <td  height="61" class=rReplyImgWidth valign=top align=left>
                            <table border=0 width=100% align=center>
                                <tr>
                                    <td height=1>
                                       <?
                                          if($reply_data[sitelink2]) {
                                       ?> 
                                           <img src="<?=$dir?>/icon/icon_<?echo "$reply_data[sitelink2]"?>.gif" border=0 class=rReplyImgWidthHeight>
                                       <?} else {?>      
                                           <img src="<?=$dir?>/icon/icon_1.gif" border=0 class=rReplyImgWidthHeight>
			   <?}?>
                                    </td>
                                </tr>
                                <tr >
                                    <td >
                                        <?=$face_image?>&nbsp;<?=$name?>
                                    </td>
                                </tr>
  	                    <? if ($rReplyViewDate==1) { 
	                        if ($rReplyDateDisplay==1) {  
	                    ?>
                                <tr >
                                    <td align=right ><?= $date=date("m/d H:i", $reply_data[reg_date])?></td>
                                </tr>

	                    <? } else { ?>
                                <tr>
                                    <td align=right ><?= $date=date("Y/m/d", $reply_data[reg_date])?></td>
                                </tr>
            	           <? }
	                         }
	                     ?>
                                <tr >
                                    <td align=right >
			    <?=$hide_cart_start?><input type=checkbox name=cart value="<?=$reply_data[no]?>"><?=$hide_cart_end?>
                                        <?=$a_reply?><img src=<?=$dir?>/reply_s.gif border=0 onfocus=blur()></a>
                                        <?=$a_modify?><img src=<?=$dir?>/modify_s.gif border=0 onfocus=blur()></a>
                                        <?=$a_delete?><img src=<?=$dir?>/delete_s.gif border=0 onfocus=blur()></a>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>
