<? /////////////////////////////////////////////////////////////////////////
 /*
 ����� ����ϴ� �κ��Դϴ�.
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
       arrow.gif : ���� ����Ʈ���� ���õǾ� �ִ� �� �տ� �ٴ� ������
 */
///////////////////////////////////////////////////////////////////////// ?>
<!-- ��� �κ� ���� -->

<tr>
	<td colspan=<?=$_h_num?>>

<table border=0 cellspacing=0 cellpadding=0 width=100% height=20 bgcolor=<?=$_color1?>>
<?=$hide_cart_start?><col width=20></col><?=$hide_cart_end?><col width=></col><col width=80></col><col width=70></col><col width=50></col> 
<tr>
	<?=$hide_cart_start?><Td width=20 align=center><input type=checkbox name=cart value="<?=$data[no]?>"></td><?=$hide_cart_end?>
	<td style='word-break:break-all;'><img src=<?=$dir?>/t.gif border=0 height=2><Br>�� <?=$insert?> <?=$subject?> <font style=font-family:matchworks;font-size:8pt><?=$comment_num?></font></td>
	<td align=center><?=$name?></td>
	<td align=center><?=$reg_date?></td>
	<td align=center><?=$hit?></td>
</tr>
<tr><td height=1 colspan=7 background=<?=$dir?>/dot.gif><img src=<?=$dir?>/dot.gif border=0 height=1></td></tr>
</table>
 
	</td>
</tr>
 
