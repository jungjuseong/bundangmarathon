<? include "$dir/variable.php"; ?>

<script language="javascript">

function rChgImg(num)
{ 
	document.write.NowImg.src    = "<?=$dir?>/icon/icon_"+num+".gif";
	document.write.sitelink2.value =num;
} 

</script>


<SCRIPT LANGUAGE="JavaScript">
<!--
function zb_formresize_inc(obj) {
	obj.rows += 3;
}
function zb_formresize_dec(obj) {
    if (obj.rows >=11) {
	obj.rows -= 3;
    }
}
// -->
</SCRIPT>

<?
  if($mode=="reply")  {  ?>

<table align="center" border="0" width=417 bgcolor=#EEEEEE style='table-layout:fixed ;word-break:break-all;' >
    <tr>
        <td align=left style="width:99%;height=20 padding:10;"><?=$data[name]?>&nbsp;(<?= $date=date("m/d H:i", $data[reg_date])?>)</td>
    </tr>
    <tr>
        <td align=center style="width:99%;height:100%;overflow-x:hidden;overflow-y:auto; padding:10"><?=trim(nl2br(stripslashes($data[memo])))?></td>
    </tr>
</table>
<? } ?>


<table>
<form method=post name=write action=write_ok.php  enctype=multipart/form-data>
<input type=hidden name=page value=<?=$page?>>
<input type=hidden name=id value=<?=$id?>>
<input type=hidden name=no value=<?=$no?>>
<input type=hidden name=select_arrange value=<?=$select_arrange?>>
<input type=hidden name=desc value=<?=$desc?>>
<input type=hidden name=page_num value=<?=$page_num?>>
<input type=hidden name=keyword value="<?=$keyword?>">
<input type=hidden name=category value="<?=$category?>">
<input type=hidden name=sn value="<?=$sn?>">
<input type=hidden name=ss value="<?=$ss?>">
<input type=hidden name=sc value="<?=$sc?>">
<? if ($rViewSubject==0) { ?>
    <input type=hidden name=subject  value="guest subject">
<? } ?>
<input type=hidden name=mode value="<?=$mode?>">

<table align=center border="0" width=417 cellspacing=0>
  <?=$hide_start?>

    <tr>
        <td width="40" ><img src=<?=$dir?>/w_id.gif border=0></td>
        <td width="160" ><input type=text name=name value="<?=$name?>" <?=size(20)?> maxlength=20  style=width:160 class=rinput ></td>
        <td width="40" ><img src=<?=$dir?>/w_password.gif border=0></td>
        <td width="170"><input type=password name=password value="<?=$password?>" <?=size(20)?> maxlength=20  style=width:170 class=rinput ></td>
    </tr>
    <tr>
        <td width="40" ><img src=<?=$dir?>/w_mail.gif border=0></td>
        <td width="160" ><input type=text name=email value="<?=$email?>" <?=size(20)?> maxlength=50  style=width:160 class=rinput ></td>
        <td width="40" ><img src=<?=$dir?>/w_homepage.gif border=0></td>
        <td width="170" ><input type=text name=homepage value="<?=$homepage?>" <?=size(40)?> maxlength=200 style=width:170 class=rinput ></td>
    </tr>


  <?=$hide_end?>
</table>
<? if ($rViewSubject==1) { ?>
<table align=center border="0" width=417 cellspacing=0 >

    <tr valign=center>
      <td width="40" ><img src=<?=$dir?>/w_subject.gif border=0></td>
      <td>
                <? if($mode=="reply") { ?>
                    <input type=text name=subject value="" <?=size(60)?> maxlength=200 style=width:100% class=input>
                <? } elseif($mode=="modify")  { ?>
                    <input type=text name=subject value="<?=$subject?>" <?=size(60)?> maxlength=200 style=width:100% class=input>
                <? } else { ?>
                    <input type=text name=subject value="" <?=size(60)?> maxlength=200 style=width:100% class=input>
                <? } ?>
      </td>
    </tr>
</table>
<? } ?>

<table align=center border="0" width=417 cellspacing=0>
    <tr>
        <td  colspan="4" >

      <? if($mode=="modify")  {  ?>

       <?=$hide_notice_start?> <input type=checkbox name=notice <?=$notice?> value=1 > Notice <?=$hide_notice_end?>
       <?=$hide_html_start?> <input type=checkbox name=use_html <?=$use_html?> value=1 > Use html <?=$hide_html_end?>
       <input type=checkbox name=reply_mail <?=$reply_mail?> value=1 > Reply mail
	    &nbsp;<img src=<?=$dir?>/btn_down.gif border=0 valign=absmiddle style=cursor:hand; onclick=zb_formresize_inc(document.write.memo)>
	     <img src=<?=$dir?>/btn_up.gif border=0 valign=absmiddle style=cursor:hand; onclick=zb_formresize_dec(document.write.memo)>

      <? } else { ?>
       <?=$hide_notice_start?> <input type=checkbox name=notice value=1 > Notice <?=$hide_notice_end?>
       <?=$hide_html_start?> <input type=checkbox name=use_html value=1 > Use html <?=$hide_html_end?>
       <input type=checkbox name=reply_mail value=1 checked> Reply mail
	    &nbsp;<img src=<?=$dir?>/btn_down.gif border=0 valign=absmiddle style=cursor:hand; onclick=zb_formresize_inc(document.write.memo)>
	     <img src=<?=$dir?>/btn_up.gif border=0 valign=absmiddle style=cursor:hand; onclick=zb_formresize_dec(document.write.memo)>



      <? } ?>     
        </td>
    </tr>
    <tr>
        <td colspan=4>
      <?
          for($i=1;$i<=$rImageCount;$i++) echo "<a href='javascript:rChgImg($i)'  onfocus='this.blur()'><img src='$dir/icon/icon_$i.gif' width=$rListImageWidth height=$rListImageHeight  border=0></a> ";
      ?>
        </td>
    </tr>
</table>
<table align="center" border="0" width=417 cellspacing=0>
    <tr>
        <td   colspan="4">
            <table border="0" width=417 height=100 cellspacing=0 >
                <tr>
                    <td width="100" height=100 valign=top align=left>

                        <? if($mode=="reply" || $mode=="modify")  {  ?>
                              <? if ($data[sitelink2]) { ?>
                                  <img src="<?=$dir?>/icon/icon_<?=$data[sitelink2]?>.gif" width=100 height=100 border="0" name="NowImg">
                              <? } else { ?>
                              <img src="<?=$dir?>/icon/icon_1.gif" width=100 height=100 border="0" name="NowImg">
                              <? } ?>
                        <? } else {  ?>
                              <img src="<?=$dir?>/icon/icon_1.gif" width=100 height=100 border="0" name="NowImg">
                         <? } ?>
                    </td>

                    <? if($mode=="reply")  {  ?>
	        <td height=100 valign=top  style='word-break:break-all;'><textarea name=memo <?=size2(90)?> rows=8 style=width:100% class=rTextarea  ></textarea></td>
                    <? } elseif($mode=="modify")  {  ?>
 	        <td height=100 valign=top  style='word-break:break-all;'><textarea name=memo <?=size2(90)?> rows=8 style=width:100% class=rTextarea  ><?=$memo?></textarea></td>
                    <? } else {  ?>
 	        <td height=100 valign=top style='word-break:break-all;'><textarea name=memo <?=size2(90)?> rows=8 style=width:100% class=rTextarea ></textarea></td>
                     <? } ?>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table align="center" border="0" width=417 cellspacing=0 >

    <?
      if($mode=="reply")  {  if ($data[sitelink2]) { ?>
        <td><input type=hidden style="width:100%" type=text name=sitelink2 value="<?=$data[sitelink2]?>" > </td>
      <? } else { ?>
        <td><input type=hidden style="width:100%" type=text name=sitelink2 value="1" ></td>
      <?  } 

         } else {  if ($data[sitelink2]) { ?>
        <td><input type=hidden style="width:100%" type=text name=sitelink2 value="<?=$sitelink2?>" > </td>
       <? } else { ?>
        <td><input type=hidden style="width:100%" type=text name=sitelink2 value="1" ></td>
         <?  } 
      } ?>
</table>
<table align="center" border="0" width=417 cellspacing=0 >


    <tr>
        <td align=right>
            <input type=image src=<?=$dir?>/btn_writeok.gif border=0 onfocus=blur() border=0 >&nbsp;
	<? if($mode=="reply") { ?>
            <a href=javascript:void(history.back()) onfocus=blur()><img src=<?=$dir?>/btn_writecancel.gif border=0>&nbsp;</a>
	<? } ?>
	<? if($mode=="modify") { ?>
            <a href=javascript:void(history.back()) onfocus=blur()><img src=<?=$dir?>/btn_writecancel.gif border=0>&nbsp;</a>
	<? } ?>

    </td>

    </tr>
</table>
</form>
<!-- </table> -->
