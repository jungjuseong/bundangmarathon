<?
  /*
  write.php �� �۾��� ���Դϴ�.
  �Ʒ� ������ ����մϴ�.

  ȸ���϶� ��Ÿ���� �ʴ� �κ��� ó���ϴ� �κ��Դϴ�. �����ָ� ȸ���϶��� ��Ÿ���� �ʽ��ϴ�.
  <?=$hide_start?> : ȸ���϶� �۾������ ��Ÿ���� �ʰ� �ϴ� �κ��Դϴ�;; ȸ���϶��� �ڵ� �ּ�(<!--)�� ���ϴ�.  
  <?=$hide_end?>  : ȸ���϶� ������ �ʰ� �մϴ�. <?=$hide_start?>�� �����ϰ� <?=$hide_end?> �� �����ָ� �˴ϴ�.

  <?=$hide_sitelink1_start?>, <?=$hide_sitelink1_end?> : ����Ʈ��ũ 1���� ����ϴ��� ���ϴ��� ǥ��
  <?=$hide_sitelink2_start?>, <?=$hide_sitelink2_end?> : ����Ʈ��ũ 2���� ����ϴ��� ���ϴ��� ǥ��
  <?=$hide_pds_start?>, <?=$hide_pds_end?> : �ڷ���� ����ϴ��� ���ϴ��� ǥ��
  <?=$hide_html_start?>, <?=$hide_html_end?> : HTML üũ�ڽ� ǥ�� 


  <?=$title?> : �ű�, ����, ����϶��� ���� ǥ��

  �Ʒ������� �ش����� �ִ°��� �״�� ���νø� �˴ϴ�.
  <?=$name?> : ���� �̸��Դϴ�.
  <?=$subject?> : ���� �����Դϴ�.
  <?=$email?> : ���� �����Դϴ�.
  <?=$homepage?> : Ȩ�������Դϴ�.
  <?=$memo?> : ���� �����Դϴ�.
  <?=$sitelink1?> : ����Ʈ ��ũ 1���Դϴ�
  <?=$sitelink2?> : ����Ʈ ��ũ 2���Դϴ�
  <?=$file_name1?> : ���ε�� ���� 1���Դϴ�.
  <?=$file_name2?> : ���ε�� ���� 2���Դϴ�.
  <?=$category_kind?> : ī�װ� ����Ʈ �ڽ�
  <?=$use_html?> : HTML üũ ǥ��;; �� htmlüũ������(����) checked �� �� ����;;
  <?=$reply_mail?> : �亯���� üũ ǥ��;;
  <?=$secret?> : ��б� ǥ��
  <?=$upload_limit?> : ���ε� �뷮
  */
?>

<SCRIPT LANGUAGE="JavaScript">
<!--
function formresize(mode) {
        if (mode == 0) {
                document.write.memo.cols  = 80;
                document.write.memo.rows  = 20; }
        if (mode == 1) {
                document.write.memo.cols += 5; }
        if (mode == 2) {
                document.write.memo.rows += 3; }
}
// -->
</SCRIPT>

<table border=0 cellspacing=0 cellpadding=0 width=600><tr><td background=<?=$dir?>/dot.gif width=100%><img src=<?=$dir?>/t.gif border=0 height=1></td></tr></table>

<table border=0 cellspacing=1 cellpadding=0 width=600 >
<tr>
 <td width=1>
<!-- ���±� �κ�;; �������� �ʴ� ���� �����ϴ� -->
<form method=post name=write action=write_ok.php onsubmit="return check_submit();" enctype=multipart/form-data>
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
<input type=hidden name=mode value="<?=$mode?>">
<!----------------------------------------------->
 </td>
 <Td>
 
<table border=0 width=100% cellsapcing=0 cellpadding=2>
<col width=320><cols><col width=></col>

<?=$hide_start?>

<tr>
  <td align=right><b>��й�ȣ</b></td>
  <td> <input type=password name=password <?=size(20)?> maxlength=20 class=input> </td>
</tr>

<tr>
  <td align=right><b>�� ��</b></td> 
  <td> <input type=text name=name value="<?=$name?>" <?=size(20)?> maxlength=20 class=input> </td>
</tr>

<tr>
  <td align=right><B>E-Mail</b></td>
  <td> <input type=text name=email value="<?=$email?>" <?=size(40)?> maxlength=200 class=input> </td>
</tr>

<tr>
  <td align=right><b>Ȩ������</b></td>
  <td> <input type=text name=homepage value="<?=$homepage?>" <?=size(40)?> maxlength=200 class=input> </td>
</tr>

<?=$hide_end?>

<tr>
  <td align=right><b>��ɼ���</b></td>
  <td style=font-family:matchworks;font-size:8pt>
			 <?=$category_kind?>
       <?=$hide_notice_start?> <input type=checkbox name=notice <?=$notice?> value=1> NOTICE <?=$hide_notice_end?>
       <?=$hide_html_start?> <input type=checkbox name=use_html <?=$use_html?> value=1> HTML <?=$hide_html_end?>
       <input type=checkbox name=reply_mail <?=$reply_mail?> value=1> REPLY MAIL      
       <?=$hide_secret_start?> <input type=checkbox name=is_secret <?=$secret?> value=1> SECRET <?=$hide_secret_end?>
  </td>
</tr>

<tr>
  <td align=right><b>�� ��</b></td>
  <td> <input type=text name=subject value="<?=$subject?>" <?=size(60)?> maxlength=200 class=input> </td>
</tr>

<tr>
  <td align=right><b>����</b></td>
  <td><textarea name=memo <?=size2(80)?> rows=20 class=textarea><?=$memo?></textarea></td>
</tr>


<?=$hide_sitelink1_start?>
<tr>
  <td align=right><b>���ø�ũ #1</b></td>
  <td> <input type=text name=sitelink1 value="<?=$sitelink1?>" <?=size(60)?> maxlength=200 class=input> </td>
</tr>
<?=$hide_sitelink1_end?>


<?=$hide_sitelink2_start?>
<tr>
  <td align=right><b>���ø�ũ #2</b></td>
  <td> <input type=text name=sitelink2 value="<?=$sitelink2?>" <?=size(60)?> maxlength=200 class=input> </td>
</tr>
<?=$hide_sitelink2_end?>


<?=$hide_pds_start?>
<tr>
  <td>&nbsp;</td>
  <td>�ְ� ���ε� ���� �뷮 <?=$upload_limit?></td>
</tr>
<tr>
  <td align=right valign=top><b>�׸�����</b></td>
  <td valign=top> <input type=file name=file1 <?=size(50)?> maxlength=255 class=input> <?=$file_name1?></td>
</tr>
</tr>

<?=$hide_pds_end?>

</table>

<table border=0 cellspacing=0 cellpadding=0 width=600><tr><td background=<?=$dir?>/dot.gif width=100%><img src=<?=$dir?>/t.gif border=0 height=1></td></tr></table>
<br>

<table border=0 cellspacing=1 cellpadding=1 width=600>
<tr align=center>
  <td>
      <input type=image src=<?=$dir?>/i_confirm.gif border=0 accesskey="s">
      <a href=javascript:void(history.back())><img src=<?=$dir?>/i_back.gif border=0>
  </td>
</tr>
</table>

<br>

</td>
</tr>
</table>
