<?
// ���̺귯�� �Լ� ���� ��ũ���
	include "lib.php";

// DB ����
	if(!$connect) $connect=dbConn();

// �׷� ��ȣ üũ
	if(!$group_no) {
		$tmpResult = mysql_fetch_array(mysql_query("select * from $group_table order by no limit 1"));
		$group_no = $tmpResult[no];
	}

// ��� ���� ���ؿ���;;; ����� ������
	$member=member_info();

	if($mode=="admin"&&($member[is_admin]==1||($member[is_admin]==2&&$member[group_no]==$group_no))) $mode = "admin";
	else $mode = "";

	if($member[no]&&!$mode) Error("�̹� ������ �Ǿ� �ֽ��ϴ�.","window.close");


// �Խ��ǰ� �׷켳���� ���� ȸ�� ���� ����
	if($id) {
		// ���� �Խ��� ���� �о� ����
		$setup=get_table_attrib($id);

		// �������� ���� �Խ����϶� ���� ǥ��
		if(!$setup[name]) Error("�������� ���� �Խ����Դϴ�.<br><br>�Խ����� ������ ����Ͻʽÿ�","window.close");

		// ���� �Խ����� �׷��� ���� �о� ����
		$group=group_info($setup[group_no]);
		if(!$group[use_join]&&!$mode) Error("���� ������ �׷��� �߰� ȸ���� �������� �ʽ��ϴ�","window.close");

	} else {

		if($group_name) $group=mysql_fetch_array(mysql_query("select * from $group_table where name='$group_name'"));
		elseif($group_no) $group=mysql_fetch_array(mysql_query("select * from $group_table where no='$group_no'"));
		if(!$group[no]) Error("������ �׷��� �������� �ʽ��ϴ�");
		if(!$group[use_join]&&!$mode) Error("���� ������ �׷��� �߰� ȸ���� �������� �ʽ��ϴ�");

	}

	$check[1]="checked";

	if(!$referer) $referer=$HTTP_REFERER;

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

	echo "<div align=center><br>";
?>

<script>
 function address_popup(num)
 {
  window.open('zipcode/search_zipcode.php?num='+num,'searchaddress','width=440,height=230,scrollbars=yes');
 }

 function check_submit()
 {

<?
	if(file_exists("./join_license.txt")) {
?>

  if(!write.accept.checked) {
	alert("���Ծ���� �����ϼž� ȸ�������� �Ҽ� �ֽ��ϴ�");
	return false;
  }

<?
	}
?>
  if(!write.user_id.value) {alert("���̵� �Է��Ͽ� �ֽʽÿ�.");write.user_id.focus(); return false;}

<?
	if($_zbDefaultSetup[enable_hangul_id]=="false") {
?>

  if(write.comment.value.length<20) {
    alert("�ڱ�Ұ� ���� 20�� �̻� �ڼ��� �� �ֽʽÿ�.");
    write.comment.focus();
    return false;
  }
  // ID Check
  if(write.user_id.value.length<4||write.user_id.value.length>40) {
    alert("���̵�� 4�� �̻�, 40�� ���Ͽ��� �մϴ�.");
    write.user_id.focus();
    return false;
  }
  var valid = "abcdefghijklmnopqrstuvwxyz0123456789_";
  var startChar = "abcdefghijklmnopqrstuvwxyz";
  var temp;
  write.user_id.value = write.user_id.value.toLowerCase();
  temp = write.user_id.value.substring(0,1);
  if (startChar.indexOf(temp) == "-1") {
    alert("���̵��� ù ���ڴ� �����̾�� �մϴ�.");
    write.user_id.value = "";
    write.user_id.focus();
    return false;
  }
  for (var i=0; i<write.user_id.value.length; i++) {
    temp = "" + write.user_id.value.substring(i, i+1);
    if (valid.indexOf(temp) == "-1") {
      alert("���̵�� ������ ����, _ �θ� �̷������ �ֽ��ϴ�.");
      write.user_id.value = "";
      write.user_id.focus();
      return false;
    }
  }
<?
	}
?>

  if(!write.password.value) {alert("��й�ȣ�� �Է��Ͽ� �ֽʽÿ�.");write.password.focus(); return false;}
  if(!write.password1.value) {alert("��й�ȣ Ȯ���� �Է��Ͽ� �ֽʽÿ�.");write.password1.focus(); return false;}
  if(write.password.value!=write.password1.value) {alert("�н����尡 ��ġ���� �ʽ��ϴ�.");write.password.value="";write.password1.value=""; write.password.focus(); return false;}
  if(!write.name.value) { alert("�̸��� �Է��ϼ���"); write.name.focus(); return false; }

<? if($group[use_birth])
   { ?>

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
<? } ?>
  if(!write.email.value) {alert("E-Mail�� �Է��Ͽ� �ֽʽÿ�.");write.email.focus(); return false;}

/*
<? if($group[use_jumin]&&!$mode)
   { ?>
   if(!write.jumin1.value) {alert("�ֹε�Ϲ�ȣ�� �Է��Ͽ� �ֽʽÿ�");write.jumin1.focus(); return false;}
   if(!write.jumin2.value) {alert("�ֹε�Ϲ�ȣ�� �Է��Ͽ� �ֽʽÿ�");write.jumin2.focus(); return false;}
<?}?>
*/
   if(!write.jumin1.value) {alert("�ֹε�Ϲ�ȣ�� �Է��Ͽ� �ֽʽÿ�");write.jumin1.focus(); return false;}
   if(!write.jumin2.value) {alert("�ֹε�Ϲ�ȣ�� �Է��Ͽ� �ֽʽÿ�");write.jumin2.focus(); return false;}

   if(!write.home_address.value) {alert("���ּҸ� �Է��Ͽ� �ֽʽÿ�");write.home_address.focus(); return false;}
   if(!write.home_tel.value) {alert("�� ��ȭ��ȣ�� �Է��Ͽ� �ֽʽÿ�");write.home_tel.focus(); return false;}
/*
   if(!write.office_address.value) {alert("�繫�� �ּҸ� �Է��Ͽ� �ֽʽÿ�");write.office_address.focus(); return false;}
   if(!write.office_tel.value) {alert("�繫�� ��ȭ��ȣ�� �Է��Ͽ� �ֽʽÿ�");write.office_tel.focus(); return false;}
*/
   if(!write.handphone.value) {alert("�޴��� ��ȣ�� �Է��Ͽ� �ֽʽÿ�");write.handphone.focus(); return false;}


  return true;
  }

  function check_id(id)
  {
   if(!id)
   {
    alert('���̵� �Է��Ͽ� �ֽʽÿ�');
   }
   else
   {
    window.open('check_user_id.php?user_id='+id,'check_user_id','width=200,height=100,toolbar=no,status=no,resizable=no');
   }
  }

  function check_accept() {
	return confirm("���� ���� ����� ��� ��������, �����Ͻʴϱ�?");
  }

</script>
<table border=0 cellspacing=1 cellpadding=0 width=540>
<form name=write method=post action=member_join_ok.php enctype=multipart/form-data onsubmit="return check_submit();">
<input type=hidden name=id value=<?=$id?>>
<input type=hidden name=referer value="<?=$referer?>">
<input type=hidden name=group_no value="<?=$group[no]?>">
<input type=hidden name=mode value="<?=$mode?>">

  <tr>
<!--
      <td colspan=2>
        <img src=images/member_joinin.gif>
-->
      <td colspan=2 align=center>
	<font color=blue size="+2">�д縶����Ŭ�� ���Խ�û</font>
        <br><br></td></tr>

<?
	if(file_exists("./join_license.txt")) {
		$f=fopen("join_license.txt",r);
		$join_license = fread($f,filesize("join_license.txt"));
		fclose($f);
?>
  <tr><td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="3"></td></tr>
  <tr>
  	<td colspan=2>
  		<br><div align=center><textarea cols=80 rows=12 readonly style=border-color:#d8b3b3;width:95% class=input><?=$join_license?></textarea></div>
	</td>
  </tr>
  <tr>
  	<td colspan=2>&nbsp;&nbsp;&nbsp;<input type=checkbox name=accept value=1 onclick="return check_accept()"> ���� ���� ����� �����մϴ�</td>
  </tr>
<?
	}
?>
        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="3"></td>
        </tr>
  <tr align=right>
     <td width=25% style=font-family:Tahoma;font-size:8pt;><b>ID&nbsp;</td>
     <td align=left>&nbsp;<input type=text name=user_id size=20 maxlength=20 style=border-color:#d8b3b3 class=input> <input type=button value='Check ID' style=color:#000000;border-color:#dfb8b8;background-color:#f0f0f0;font-size:8pt;font-family:Tahoma;height:20px; onclick=check_id(write.user_id.value)><br><img src=images/t.gif border=0 height=4><? if($_zbDefaultSetup[enable_hangul_id]=="false") {?><br>&nbsp;(����,����,_�θ� ���̵� �ۼ��ϼ���)<? } ?></td>
  </tr>
        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
  <tr align=right height=28>
     <td style=font-family:Tahoma;font-size:8pt;><B>Password&nbsp;</td>
     <td align=left>&nbsp;<input type=password name=password size=20 maxlength=20 style=border-color:#d8b3b3 class=input> Ȯ�� : <input type=password name=password1 size=20 maxlength=20 style=border-color:#d8b3b3 class=input></td>
  </tr>
        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
  <tr align=right height=28>
     <td style=font-family:Tahoma;font-size:8pt;><b>Name&nbsp;</td>
     <td align=left>&nbsp;<input type=text name=name size=20 maxlength=20 value="<?=$member[name]?>" style=border-color:#d8b3b3 class=input>(�Ǹ��� �ƴϸ� �뺸���� �����˴ϴ�.)</td>
  </tr>
        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
<? if($group[use_birth]) { ?>
  <tr align=right height=28>
     <td style=font-family:Tahoma;font-size:8pt;><b>Birthday&nbsp;</td>
     <td align=left>&nbsp;<input type=text name=birth_1 size=4 maxlength=4 style=border-color:#d8b3b3 class=input> ��
                    &nbsp;<input type=text name=birth_2 size=2 maxlength=2 style=border-color:#d8b3b3 class=input> ��
                    &nbsp;<input type=text name=birth_3 size=2 maxlength=2 style=border-color:#d8b3b3 class=input> ��
          <input type=checkbox value=1 checked name=open_birth> ����
  </tr>        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
<? } ?>

  <tr align=right height=28>
     <td style=font-family:Tahoma;font-size:8pt;><b>E-mail&nbsp;</td>
     <td align=left>&nbsp;<input type=text name=email size=50 maxlength=255 value="<?=$member[email]?>" style=border-color:#d8b3b3 class=input>
                          <input type=checkbox value=1 name=open_email checked> ����
                          </td>
  </tr> 
        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>

<? if($group[use_handphone]) { ?>
  <tr align=right height=28>
     <td style=font-family:Tahoma;font-size:8pt;>�̵���ȭ��ȣ&nbsp;</td>
     <td align=left>&nbsp;<input type=text name=handphone size=20 maxlength=20 value="<?=$member[handphone]?>" style=border-color:#d8b3b3 class=input>
                          <input type=checkbox value=1 name=open_handphone checked> ����</td>
  </tr>        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
<? } ?>

<? if($group[use_mailing]) { ?>
  <tr align=right height=28>
     <td style=font-family:Tahoma;font-size:8pt;><b>Mailling List&nbsp;</td>
<!--
     <td align=left>&nbsp;<input type=checkbox name=mailing value=1 checked> ���ϸ� ����</td>
-->
     <td align=left>&nbsp;<input type=hidden name=mailing value=1 > ���ϸ� �ڵ� ����</td>
  </tr>        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
<? } ?>

<? if($group[use_picture]) { ?>
  <tr align=right height=28>
     <td style=font-family:Tahoma;font-size:8pt;>���� ����&nbsp;<br>(200*200 ����)</td>
     <td align=left>&nbsp;<input type=file name=picture size=35 maxlength=255 style=border-color:#d8b3b3 class=input>
                 <? if($member[picture]) echo"<br>&nbsp;<img src='$member[picture]' border=0>"; ?>
                          <input type=checkbox value=1 name=open_picture checked> ����
     </td>
  </tr>        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
<? } ?>

<? if($group[use_comment]) { ?>
  <tr align=right height=28>
     <td style=font-family:Tahoma;font-size:8pt;>�ڱ� �Ұ���<br>(�޸��� ��� ��<br> ���� �Ż�)</td>
     <td align=left>&nbsp;<textarea cols=50 rows=4 name=comment style=border-color:#d8b3b3 class=textarea><?=$member[comment]?></textarea><br>&nbsp;<input type=checkbox value=1 name=open_comment checked> ����</td>

  </tr>        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
<? } ?>

  <tr align=right height=28>
     <td style=font-family:Tahoma;font-size:8pt;><b>�������� ����</td>
     <td align=left>&nbsp;<input type=checkbox name=openinfo value=1 checked> ���� ����</td>
  </tr>        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>

<tr height=30 bgcolor=#ffffff>
   <td  colspan=2 align=right ><img src=images/t.gif height=5><br>
   <input type=image border=0 src=images/button_join.gif> &nbsp;
   <img src=images/memo_close.gif border=0 onClick=window.close() style=cursor:hand>&nbsp;&nbsp;&nbsp;
   </td>
</tr>

  </form>
</table>


<?
	@mysql_close($connect);
	foot();
?>