<? /////////////////////////////////////////////////////////////////////////
  /*
  �� ������ ����Ʈ�� ��� �κ��� �����ִ� ���Դϴ�
  <?=$a_ �� ���۵Ǵ� �׸��� HTML�� <a ��� �����Ͻø� �˴ϴ�.
  �ڿ� </a>�� �ٿ��ָ� ����;
  ������ ��Ų ���۽� ����� �ִ� ���� �Դϴ�. �״�� ����Ͻø� �˴ϴ�;;;;

  <?=$width?> : �Խ����� ����ũ��
  <?=$dir?> : ��Ų���丮�� ����ŵ�ϴ�.
  <?=$print_page?> : �������� �����ݴϴ�
  <?=$a_status?> : ��踵ũ
  <?=$a_login?> : �α��� ��ư
  <?=$a_logout?> : �α׿�����ư
  <?=$a_no?> : ��������.. �� ������� ����
  <?=$a_subject?> : ��������
  <?=$a_name?> : �̸�����
  <?=$a_hit?> : ��ȸ�� ����
  <?=$a_vote?> : ��õ�� ����
  <?=$a_date?> : ���ں� ����
  <?=$a_download1?> : ù���� �׸��� �ڷ� �ٿ�ε� ���� ����
  <?=$a_download2?> : �ι�° �׸��� �ڷ� �ٿ�ε� ���� ����
  <?=$a_cart?> : �ٱ��� ���� ��ũ
  <?=$a_category?> : ī�װ� ����

  <?=$a_write?> : �۾��� ��ư
  <?=$a_list?> : ��Ϻ��� ��ư
  <?=$a_reply?> : ��۾��� ��ư
  <?=$a_delete?> : �ۻ��� ��ư
  <?=$a_modify?> : �ۼ��� ��ư
  <?=$a_delete_all?> : �������϶� ��Ÿ���� ���õ� �� ���� ��ư;;

  �ٱ��Ͽ� ī�װ��� ��� ������� �ʴ� ���� �����Ƿ� ���ܳ����� ���� ����;;
  <?=$hide_cart_start?> ���� <?=$hide_cart_end?> : start �� end ���̿��� �����;; �ٱ���
  <?=$hide_category_start?> ���� <?=$hide_category_end?> : Start�� end ���̿��� �����;; �ٱ���
  */ 
?>

<table border=0 cellspacing=0 cellpadding=0 width=<?=$width?>>
<tr><td width=1>
<form method=post name=list action=list_all.php>
<input type=hidden name=page value=<?=$page?>>
<input type=hidden name=id value=<?=$id?>>
<input type=hidden name=select_arrange value=<?=$select_arrange?>>
<input type=hidden name=desc value=<?=$desc?>>
<input type=hidden name=page_num value=<?=$page_num?>>
<input type=hidden name=selected>
<input type=hidden name=exec>
<input type=hidden name=keyword value="<?=$keyword?>">
<input type=hidden name=sn value="<?=$sn?>">
<input type=hidden name=ss value="<?=$ss?>">
<input type=hidden name=sc value="<?=$sc?>">
</td><td width=100%>

<table border=0 cellspacing=0 cellpadding=0 width=100%> 
<tr align=center>
  <td><table border=0 cellspacing=0 cellpadding=0 width=40><tr>
      <td><img src=<?=$dir?>/h_left.gif border=0></td>
      <td background=<?=$dir?>/h_bg.gif width=100% align=center><?=$a_no?><img src=<?=$dir?>/h_no.gif border=0></a></td>
      </tr></table></td>

  <td width=100%><table border=0 background=<?=$dir?>/h_bg.gif cellspacing=0 cellpadding=0 width=100%><tr>
      <td align=center><?=$a_subject?><img src=<?=$dir?>/h_subject.gif border=0></a></td>
      </tr></table>
  </td>

  <td><table border=0 background=<?=$dir?>/h_bg.gif cellspacing=0 cellpadding=0 width=100%><tr>
      <td align=center><?=$a_name?><img src=<?=$dir?>/h_name.gif border=0></a></td>
      </tr></table>
  </td>

  <td><table border=0 background=<?=$dir?>/h_bg.gif cellspacing=0 cellpadding=0 width=100%><tr>
      <td align=center><?=$a_date?><img src=<?=$dir?>/h_date.gif border=0></a></td>
      </tr></table>
  </td>

  <td><table border=0 background=<?=$dir?>/h_bg.gif cellspacing=0 cellpadding=0 width=100%><tr>
      <td align=center><?=$a_hit?><img src=<?=$dir?>/h_hit.gif border=0><img src=<?=$dir?>/h_right.gif border=0></a></td>
      </tr></table>
  </td>

</tr>
