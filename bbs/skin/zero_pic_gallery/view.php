<? /////////////////////////////////////////////////////////////////////////
  /*
  �� ������ ����Ʈ�� ��� �κ��� �����ִ� ���Դϴ�
  <?=$a_ �� ���۵Ǵ� �׸��� HTML�� <a ��� �����Ͻø� �˴ϴ�.
  �ڿ� </a>�� �ٿ��ָ� ����;
  ������ ��Ų ���۽� ����� �ִ� ���� �Դϴ�. �״�� ����Ͻø� �˴ϴ�;;;;

  <?=$face_image?> : ���� ���� ���� �۾��� �� ������;;

  <?=$width?> : �Խ����� ����ũ��
  <?=$dir?> : ��Ų���丮�� ����ŵ�ϴ�.
  <?=$a_download1?> : ù��° ������ �ٿ�ε�
  <?=$a_download2?> : �ι�° ������ �ٿ�ε�
  <?=$a_email?> : ���ϸ�ũ
  <?=$a_homepage?> : Ȩ������ ��ũ

  <?=$a_write?> : �۾��� ��ư
  <?=$a_list?> : ��Ϻ��� ��ư
  <?=$a_reply?> : ��۾��� ��ư
  <?=$a_delete?> : �ۻ��� ��ư
  <?=$a_vote?> : ��õ��ư
  <?=$a_modify?> : �ۼ��� ��ư

  �ٱ��Ͽ� ī�װ��� ��� ������� �ʴ� ���� �����Ƿ� ���ܳ����� ���� ����;;
  <?=$hide_cart_start?> ���� <?=$hide_cart_end?> : start �� end ���̿��� �����;; �ٱ���
  <?=$hide_category_start?> ���� <?=$hide_category_end?> : Start�� end ���̿��� �����;; �ٱ���
  <?=$hide_sitelink1_start?> ���� <?=$hide_sitelink1_end?> : ����Ʈ��ũ ǥ�� #1
  <?=$hide_sitelink2_start?> ���� <?=$hide_sitelink2_end?> : ����Ʈ��ũ ǥ�� #2
  <?=$hide_download1_start?> ���� <?=$hide_download1_end?> : �ٿ�ε� ǥ�� #1
  <?=$hide_download2_start?> ���� <?=$hide_download2_end?> : �ٿ�ε� ǥ�� #2
  <?=$hide_homepage_start?> ���� <?=$hide_homepage_end?> : Ȩ������ ǥ��
  <?=$hide_email_start?> ���� <?=$hide_email_end?> : Email ǥ��

  -- ������ ��� ����
  <?=$hide_comment_start?> <?=$hide_comment_end?> : ������ ��� ���� �����ֱ�/ �����


  <?=$name?> : ������ ��ũ�Ǿ� �ִ� �̸� * ���� �״�� <?=$data[name]?>
  <?=$email?> : ����.. ���� ���� ������ ����;; ���ϸ� �ִ� ���� <?=$data[email]?>
  <?=$subject?> : ����  * ���� �״�� <?=$data[suject]?>
  <?=$memo?> : ���� �κ�
  <?=$homepage?> : ��ũ�� �ɸ� Ȩ������ * Ȩ������ �ּҸ� : <?=$data[homepage]?>
  <?=$hit?> : ��ȸ��
  <?=$vote?> : ��õ��
  <?=$ip?> : �����ּ�
  <?=$comment_num?> : ������ ��� ��
  <?=$reg_date?> : �۾� ����
  <?=$category_name?> : ī�װ� �̸�
  <?=$insert?> : ����ϰ�� ��ĭ�� ���� ���̸� ����մϴ�.
  <?=$icon?>   : ���� ���� ���¿� ���� �������� ����մϴ�.
  <?=$a_file_link1?> : �ٿ�ε� ������ ������ ���ϸ�ũ #1
  <?=$a_file_link2?> : �ٿ�ε� ������ ������ ���ϸ�ũ #2
  <?=$file_name1?> : �ٿ�ε� ������ ������ �����̸� #1
  <?=$file_name2?> : �ٿ�ε� ������ ������ �����̸� #2
  <?=$file_size1?> : �ٿ�ε� ������ ������ ����ũ�� #1
  <?=$file_size2?> : �ٿ�ε� ������ ������ ����ũ�� #2
  <?=$file_download1?> : �ٿ�ε���� ȸ�� #1;
  <?=$file_download2?> : �ٿ���� ȸ�� #2
  <?=$sitelink1?> : ����Ʈ ��ũ(��ũ �ɸ���) #1
  <?=$sitelink2?> : ����Ʈ ��ũ(��ũ �ɸ���) #2

  <?=$upload_image1?> : �̹����� ���ε�Ǿ����� �׸������̸�;; #1
  <?=$upload_image2?> : �̹����� ���ε�Ǿ����� �׸������̸�;; #2

  ����: old_head.gif : �������̸鼭 12�ð��� ���� ���� ������
       new_head.gif : 12�ð��� ���� ��� ��. ����/��� �������
       reply_head.gif : 12�ð��� ���� ����� ������
       notice_head.gif : ���������϶� ������
       arror.gif : ���� ����Ʈ���� ���õǾ� �ִ� �� �տ� �ٴ� ������

  --- ����/ ���ı� ��ũ ---
  <?=$a_prev?> : ������ ��ũ
  <?=$a_next?> : ������ ��ũ

  <?=hide_prev_start?> <?=$hide_prev_end?> : ������ ��Ÿ����/ �����
  <?=hide_next_start?> <?=$hide_next_end?> : ������ ��Ÿ����/ �����
 
  ��Ÿ �����̳� �۾��̵��� ���� ����Ÿ���� �տ� prev_ , next_ �� �� ���ΰ���;
  ex) ������ ���� : <?=$prev_subject?>
  
  */ 
///////////////////////////////////////////////////////////////////////////// ?>

<table border=0 cellspacing=0 cellpadding=3 width=<?=$width?> bgcolor=<?=$_color1?>>
<col width=80></col><col width=></col>
<tr>
 <td align=right><B>�۾���</b>&nbsp;&nbsp;</td>
 <td align=left><?=$face_image?> <?=$name?></td>
</tr>
<?=$hide_homepage_start?>
<tr>
 <td align=right ><b>Ȩ������</b>&nbsp;&nbsp;</td>
 <td ><?=$homepage?></td>
</tr>
<?=$hide_homepage_end?>

<?=$hide_download1_start?>
<tr>
 <td align=right ><b>÷������</b>&nbsp;&nbsp;</td>
 <td ><?=$a_file_link1?><?=$file_name1?> (<?=$file_size1?>)</a>, Download : <?=$file_download1?></td>
</tr>
<?=$hide_download1_end?>

<?=$hide_sitelink1_start?>
<tr>
 <td align=right ><b>���ø�ũ #1</b>&nbsp;&nbsp;</td>
 <td ><?=$sitelink1?></td>
</tr>
<?=$hide_sitelink1_end?>

<?=$hide_sitelink2_start?>
<tr>
 <td align=right ><b>���ø�ũ #2</b>&nbsp;&nbsp;</td>
 <td ><?=$sitelink2?></td>
</tr>
<?=$hide_sitelink2_end?>

<tr>
 <td align=right  style='word-break:break-all;'><b>�� ��</b>&nbsp;&nbsp;</td>
 <td style='word-break:break-all;'><?=$subject?></td>
</tr>
</table>

<Table border=0 width=<?=$width?> cellspacing=0 cellpadding=0 height=1>
<tr>
	<Td background=<?=$dir?>/dot.gif border=0><img src=<?=$dir?>/t.gif border=0 height=1></td>
</tr>
</table>

<Table border=0 width=<?=$width?> cellspacing=0 cellpadding=3 bgcolor=<?=$_color2?>>
<tr>
 <td colspan=2 style='word-break:break-all;padding:10' valign=top>
     <span style=line-height:160%>
     <?=$memo?>
     <br><Br>
     <div align=right style=font-family:tahoma;font-size=8pt><?=$ip?></div>
     </span>
 </td>
</tr>

</table>

<!-- ������ ��� �����ϴ� �κ� -->
<?=$hide_comment_start?> 
<table border=0 cellspacing=0 cellpadding=0 width=<?=$width?> bgcolor=<?=$_color2?>>
<?=$hide_comment_end?>
