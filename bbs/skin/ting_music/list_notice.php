<? /////////////////////////////////////////////////////////////////////////
 /*
 ��������� ����ϴ� �κ��Դϴ�.
 ����� �������̱� ������ �� ������ ��� �о ����մϴ�.
 ��ȯ�� �ǵ��� �� �ۼ��ϼž� �մϴ�.
 �Ʒ��� HTML �ȿ� �״�� ������ֽø� ��ȯ�� �ϸ鼭 ����� �մϴ�.

 <?=$number?> : �����ȣ. �� ������� ������ ��ȣ
 * <?=$data[no]?> : �����ȣ, ���� �ٲ��� �ʴ� ��ȣ..
 * <?=$loop_number?> : ���� ���õǾ� �ִ� ���̶� ��ȣ�� ������
 <?=$name?> : ������ ��ũ�Ǿ� �ִ� �̸� * ���� �״�� <?=$data[name]?>
 <?=$email?> : ����.. ���� ���� ������ ����;;
 <?=$subject?> : ��ũ�� �Ǿ� �ִ� ����  * ���� �״�� <?=$data[suject]?>
 <?=$memo?> : ���� �κ�
 <?=$hit?> : ��ȸ��
 <?=$vote?> : ��õ��
 <?=$ip?> : �����ּ�
 <?=$comment_num?> : ������ ��� �� [ ] �� �ѷ��ο� �ִ°�;; <?=$data[comment_num]?> �� ���ڸ�;;
 <?=$reg_date?> : �۾� ����
 <?=$category_name?> : ī�װ� �̸�

 <?=$face_image?> : ���� ȸ�������� ������;;

 <?=$insert?> : ����ϰ�� ��ĭ�� ���� ���̸� ����մϴ�.
 <?=$icon?>   : ���� ���� ���¿� ���� �������� ����մϴ�.

 �ٱ��Ͽ� ī�װ��� ��� ������� �ʴ� ���� �����Ƿ� ���ܳ����� ���� ����;;
 <?=$hide_cart_start?> ���� <?=$hide_cart_end?> : start �� end ���̿��� �����;; �ٱ���
 <?=$hide_category_start?> ���� <?=$hide_category_end?> : Start�� end ���̿��� �����;; �ٱ���


 ����: old_head.gif : �������̸鼭 12�ð��� ���� ���� ������
       new_head.gif : 12�ð��� ���� ��� ��. ����/��� �������
       reply_head.gif : 12�ð��� ���� ����� ������
       reply_new_head.gif : 12�ð��� ������ ���� ����� ������;;
       notice_head.gif : ���������϶� ������
       secret_head.gif : ��б����� ��Ÿ���� ������
       arror.gif : ���� ����Ʈ���� ���õǾ� �ִ� �� �տ� �ٴ� ������
 */
///////////////////////////////////////////////////////////////////////// ?>
<!-- ��� �κ� ���� -->

<?
$sitelink1=$data[sitelink1]=stripslashes($data[sitelink1]);
$sitelink2=$data[sitelink2]=stripslashes($data[sitelink2]);
$file_name1=$data[file_name1]=stripslashes($data[file_name1]);
$file_name2=$data[file_name2]=stripslashes($data[file_name2]);
?>

<tr align=center>
  <td  class=light background=<?=$dir?>/n1.gif align=center height=25 valign=top><img src=images/t.gif height=5><br><img src=<?=$dir?>/no.gif align=absmiddle></td>
<td background=<?=$dir?>/n2.gif><?=$hide_cart_start?></td><?=$hide_cart_end?>
  <td  align=left background=<?=$dir?>/n2.gif style='word-break:break-all;'><img src=images/t.gif height=3><br>&nbsp; <?=$insert?><a href="javascript:;" onclick=":window.open('<?=$dir?>/noticew.php?<?echo "id=$id&no=$data[no]";?>' , 'Words', ' width=348 height=507 toolbar=no location=no status=no directories=no scrollbars=no resizable=no copyhistory=no');"><?=$data[subject]?></a><font style=font-family:Tahoma;font-size:6pt;font-weight:bold;letter-spacing:-1px;><?=$comment_num?></font></td>
  <td  align=left background=<?=$dir?>/n2.gif style='word-break:break-all;'><?=$a_modify?><img src=<?=$dir?>/images/modify_sn.gif border=0  align=absmiddle></a><?=$a_delete?><img src=<?=$dir?>/images/delete_sn.gif border=0  align=absmiddle></a></td>
   <td  background=<?=$dir?>/n3.gif ><img src=images/t.gif height=3><br></td>

</tr>
