<?
// ���̺귯�� �Լ� ���� ��ũ���
	include "lib.php";

// DB ����
	if(!$connect) $connect=dbConn();

// ���� �Խ��� ���� �о� ����
	if($id) {
		$setup=get_table_attrib($id);

		// �������� ���� �Խ����϶� ���� ǥ��
		if(!$setup[name]) Error("�������� ���� �Խ����Դϴ�.<br><br>�Խ����� ������ ����Ͻʽÿ�","window.close");
	}

// ��� ���� ���ؿ���;;; ����� ������
	$member=member_info();

	if(!$member[no]) Error("ȸ�� ������ �������� �ʽ��ϴ�","window.close");

	$member[name] = stripslashes($member[name]);
	$member[job] = stripslashes($member[job]);
	$member[email] = stripslashes($member[email]);
	$member[homepage] = stripslashes($member[homepage]);
	$member[birth] = stripslashes($member[birth]);
	if((0+$member[birth]) < 0){
		$birth_1 = date("Y",0-$member[birth]);
		$birth_1 = -50 + $birth_1;
		$birth_2 = date("m",0-$member[birth]);
		$birth_3 = date("d",0-$member[birth]);

	}else{
		$birth_1 = date("Y",$member[birth]);
		$birth_2 = date("m",$member[birth]);
		$birth_3 = date("d",$member[birth]);
	}
	$member[hobby] = stripslashes($member[hobby]);
	$member[icq] = stripslashes($member[icq]);
	$member[msn] = stripslashes($member[msn]);
	$member[home_address] = stripslashes($member[home_address]);
	$member[home_tel] = stripslashes($member[home_tel]);
	$member[office_address] = stripslashes($member[office_address]);
	$member[office_tel] = stripslashes($member[office_tel]);
	$member[handphone] = stripslashes($member[handphone]);
	$member[comment] = stripslashes($member[comment]);


// �׷쵥��Ÿ �о����;;
	$group_data=mysql_fetch_array(mysql_query("select * from $group_table where no='$member[group_no]'"));
	$group=$group_data;
	$group_no=$group[no];

	$check[1]="checked";

	$referer=$HTTP_REFERER;

	$setup[header]="";
	$setup[footer]="";
	$setup[header_url]="";
	$setup[footer_url]="";
	$group[header]="";
	$group[footer]="";
	$group[header_url]="";
	$group[footer_url]="";
	$setup[skinname]="";

	head();

?>
<div align=center><br>

<script>
 function address_popup(num)                                                                                                      
 {                                                                                                                                
  window.open('zipcode/search_zipcode.php?num='+num,'searchaddress','width=440,height=230,scrollbars=yes');                       
 } 
 function check_submit()
 {
  if(write.password.value!=write.password1.value) {alert("�н����尡 ��ġ���� �ʽ��ϴ�.");write.password.value="";write.password1.value=""; write.password.focus(); return false;}
  if(!write.name.value) { alert("�̸��� �Է��ϼ���"); write.name.focus(); return false; }

<? 
	if($group_data[use_birth]) { 
?>

    if ( write.birth_1.value < 1000 || write.birth_1.value <= 0 )  {
         alert('������ �߸��ԷµǾ����ϴ�.');
         write.birth_1.value='';
         write.birth_1.focus();
        return false;
    }
    if ( write.birth_2.value > 12 || write.birth_2.value <= 0 ) {
         alert('������ �߸��ԷµǾ����ϴ�.');
         write.birth_2.value='';
         write.birth_2.focus();
        return false;
    }
    if ( write.birth_3.value > 31 || write.birth_3.value <= 0 )  {
         alert('������ �߸��ԷµǾ����ϴ�.');
         write.birth_3.value='';
         write.birth_3.focus();
        return false;
    }

<?
	} 
?>

  return true;
  }

</script>
<table border=0 cellspacing=1 cellpadding=0 width=540>
<form name=write method=post action=member_modify_ok.php enctype=multipart/form-data onsubmit="return check_submit();">
<input type=hidden name=one_page value="<?=$HTTP_REFERER?>">
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
<input type=hidden name=referer value="<?=$referer?>">

  <tr><td colspan=2><img src=images/member_modify.gif></td></tr>
        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="3"></td>
        </tr>
  <tr height=28 align=right>
     <td width=28% style=font-family:Tahoma;font-size:8pt;><b>ID&nbsp;</td>
     <td align=left>&nbsp;<?=$member[user_id]?> &nbsp;(<?=date("Y�� m�� d�� H�� i��",$member[reg_date])?>�� ����)</td>
  </tr>
        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
  <tr height=28 align=right>
     <td style=font-family:Tahoma;font-size:8pt;><b>Password&nbsp;</td>
     <td align=left>&nbsp;<input type=password name=password size=20 maxlength=20 style=border-color:#d8b3b3 class=input> Ȯ�� : <input type=password name=password1 size=20 maxlength=20 style=border-color:#d8b3b3 class=input></td>
  </tr>        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
  <tr height=28 align=right>
     <td style=font-family:Tahoma;font-size:8pt;>Level&nbsp;</td>
     <td align=left>&nbsp;<?=$member[level]?></td>
  </tr>        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
  <tr height=28 align=right>
     <td style=font-family:Tahoma;font-size:8pt;><b>Name&nbsp;</td>
     <td align=left>&nbsp;<input type=text name=name size=20 maxlength=20 value="<?=$member[name]?>" style=border-color:#d8b3b3 class=input>(�Ǹ��� �ƴϸ� �뺸���� �����˴ϴ�.)</td>
  </tr>        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
<? if($group_data[use_birth]) { ?>
  <tr height=28 align=right>
     <td style=font-family:Tahoma;font-size:8pt;><b>Birthday&nbsp;</td>
     <td align=left>&nbsp;<input type=text name=birth_1 size=4 maxlength=4 value="<?=$birth_1?>" style=border-color:#d8b3b3 class=input> �� 
                    &nbsp;<input type=text name=birth_2 size=2 maxlength=2 value="<?=$birth_2?>" style=border-color:#d8b3b3 class=input> ��
                    &nbsp;<input type=text name=birth_3 size=2 maxlength=2 value="<?=$birth_3?>" style=border-color:#d8b3b3 class=input> �� 
          <input type=checkbox value=1 name=open_birth <?=$check[$member[open_birth]]?>> ����
  </tr>        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
<? } ?>

  <tr height=28 align=right>
     <td style=font-family:Tahoma;font-size:8pt;><b>E-mail&nbsp;</td>
     <td align=left>&nbsp;<input type=text name=email size=40 maxlength=255 value="<?=$member[email]?>" style=border-color:#d8b3b3 class=input>
                          <input type=checkbox value=1 name=open_email <?=$check[$member[open_email]]?>> ����
                          </td>
  </tr>        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>

<? if($group_data[use_handphone]) { ?>
  <tr height=28 align=right>
     <td style=font-family:Tahoma;font-size:8pt;>�̵���ȭ��ȣ&nbsp;</td>
     <td align=left>&nbsp;<input type=text name=handphone size=20 maxlength=20 value="<?=$member[handphone]?>" style=border-color:#d8b3b3 class=input>
                          <input type=checkbox value=1 name=open_handphone <?=$check[$member[open_handphone]]?>> ����</td>
  </tr>        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
<? } ?>

<? if($group_data[use_mailing]) { ?>
  <tr height=28 align=right>
     <td style=font-family:Tahoma;font-size:8pt;><b>Mailling List</td>
<!--
     <td align=left>&nbsp;<input type=checkbox name=mailing value=1 <?=$check[$member[mailing]]?>> ���ϸ� ����</td>
-->
     <td align=left>&nbsp;<input type=hidden name=mailing value=1 > ���ϸ� �ڵ� ����</td>
  </tr>        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
<? } ?>

  <tr height=28 align=right>
     <td style=font-family:Tahoma;font-size:8pt;><b>�������� ����</td>
     <td align=left>&nbsp;<input type=checkbox name=openinfo value=1 <?=$check[$member[openinfo]]?>> ���� ����</td>
  </tr>        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>

<? if($group_data[use_picture]) { ?>
  <tr height=28 align=right>
     <td style=font-family:Tahoma;font-size:8pt;>���䰶������<br>Photo</td>
     <td align=left>&nbsp;<input type=file name=picture size=34 maxlength=255 style=border-color:#d8b3b3 class=input>
                 <? if($member[picture]) echo"<br>&nbsp;<img src='$member[picture]' border=0> <input type=checkbox name=del_picture value=1> ����"; ?>
                          <input type=checkbox value=1 name=open_picture <?=$check[$member[open_picture]]?>> ����
                          
     </td>
  </tr>        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
<? } ?>

<? if($group_data[use_comment]) { ?>
  <tr height=28 align=right>
     <td style=font-family:Tahoma;font-size:8pt;>Comments<br>(�޸��� ��� ��<br> ���� �Ż�)</td>
     <td align=left>&nbsp;<textarea cols=40 rows=4 name=comment style=border-color:#d8b3b3 class=textarea><?=$member[comment]?></textarea>
                          <input type=checkbox value=1 name=open_comment <?=$check[$member[open_comment]]?>> ����</td>
  </tr>        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
<? } ?>
  <tr height=28 align=right>
     <td style=font-family:Tahoma;font-size:8pt;>* �� : </td>
     <td align=left>&nbsp;������� �ϴ��� Level 5(��ȸ��), 6(��ȸ��)���Դ� �����˴ϴ�.</td>
  </tr>
  <tr height=28 align=right>
     <td style=font-family:Tahoma;font-size:8pt;>Point</td>
     <td align=left>&nbsp;<?=($member[point1]*10+$member[point2])?> �� ( �ۼ��ۼ� : <?=$member[point1]?>, �ڸ�Ʈ : <?=$member[point2]?> )</td>
  </tr>        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
<tr height=30 bgcolor=#ffffff>
   <td align=center><? if($member[no]>1) {?><a href=member_out.php?id=<?=$id?>&group_no=<?=$group_no?> onclick="return confirm('Ż���Ͻðڽ��ϱ�?\n\nŻ�� �Ͻø� ��� ������ DB���� ������ϴ�.\n\nŻ���� ������ �� ���԰����մϴ�\n')"><img src=images/button_out.gif border=0 alt="ȸ��Ż��"></a><?}?></td>
   <td align=right ><img src=images/t.gif height=5><br>
   <input type=image border=0 src=images/button_modify.gif> &nbsp;
   <img src=images/memo_close.gif border=0 onClick=window.close() style=cursor:hand>&nbsp;&nbsp;&nbsp;
   </td>
</tr>
  </form>
</table>

<?
	@mysql_close($connect);
	foot();
?>
