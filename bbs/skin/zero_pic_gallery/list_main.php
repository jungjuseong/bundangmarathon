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

 unset($s_info);
 $_srcname="$dir/noscreenshot.gif";
 $_xsize=100;
 $_ysize=100;
 $_alink="";
 /*** ������ ��Ų���� ����ϴ� �κ�.. ������ ������. ^^;; ****/
 if($data[file_name1])
 {
  $s_info = @getimagesize($data[file_name1]);

	if($s_info[2]>0&&$s_info[2]<4)
	{
		$_xsize = $s_info[0];
		if($_xsize>$_hsize) $_xsize=$_hsize;
		$_srcname = $data[file_name1];
		$_alink="<a href=javascript:void(window.open('$dir/show_pic.php?file=$data[file_name1]','$data[no]','width=$s_info[0],height=$s_info[1],resizable=yes,toolbars=no,scrollbars=auto')) onfocus=blur()>";
	}
 }

 $_x ++;
 $_temp = $_x % $_h_num;

?>

<!-- ��� �κ� ���� -->
<?if($_temp==1){?>
<tr>
<?}?>

<td valign=top align=center>
<br>

<!-- ������ ��� �κ� -->
<Table border=0 cellspacing=0 cellpadding=0 width=<?=$_hsize?>>  
<tr align=center bgcolor=<?=$_color1?>>
	<td align=center width=<?=$_hsize?> style=padding:5px valign=top><?=$_alink?><img src=<?=$_srcname?> border=0 width=<?=$_xsize?>></a></td>
</tr>
<tr>
	
	<td>
	<Table border=0 cellspacing=0 cellpadding=5 width=100% bgcolor=<?=$_color2?>>  
	<tr>
		<td style='word-break:break-all;'>
			<?=$hide_cart_start?><input type=checkbox name=cart value="<?=$data[no]?>"><?=$hide_cart_end?> <?=$hide_category_start?>[<b><?=$category_name?></b>]<br><?=$hide_category_end?> <?=$subject?> <font style=font-family:����;font-size:6pt><?=$comment_num?></font>
		</td>
	</tr>
	</table>

	</td>

</tr>
</table>
<br> 

</td>

<?if(!$_temp){?>
</tr>
<tr>
	<td height=1 colspan=<?=$_h_num?> background=<?=$dir?>/dot.gif><img src=<?=$dir?>/dot.gif border=0 height=1></td>
</tr>
<?
	}
?>
 
