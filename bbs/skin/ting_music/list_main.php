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
 <?=$category_name?> : ī�װ��� �̸�

 <?=$face_image?> : ���� ȸ�������� ������;;

 <?=$insert?> : ����ϰ�� ��ĭ�� ���� ���̸� ����մϴ�.
 <?=$icon?>   : ���� ���� ���¿� ���� �������� ����մϴ�.

 �ٱ��Ͽ� ī�װ����� ��� ������� �ʴ� ���� �����Ƿ� ���ܳ����� ���� ����;;
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
$data[sitelink1]=stripslashes($data[sitelink1]);
$data[sitelink2]=stripslashes($data[sitelink2]);
$data[file_name1]=stripslashes($data[file_name1]);
$data[file_name2]=stripslashes($data[file_name2]);
$sitelink1="";
if(!eregi("\.smi",$data[sitelink1])) $sitelink1="$data[sitelink1]";
$sitelink2="";
if(!eregi("\.smi",$data[sitelink2])) $sitelink2="$data[sitelink2]";
$file_name1="";
if(!eregi("\.smi",$data[file_name1])) $file_name1="$data[file_name1]";
$file_name2="";
if(!eregi("\.smi",$data[file_name2])) $file_name2="$data[file_name2]";
if(($sitelink1 || $file_name1)) {$mu1=1;}else {$mu1=0;}
if(($sitelink2 || $file_name2)) {$mu2=1;}else {$mu2=0;}
if(strlen($data[memo])>$dasom_length2){$gasa=1;}else{$gasa=0;}
?>
 <tr align=left height=30 onMouseOver=this.style.backgroundColor='FFF1E4' onMouseOut=this.style.backgroundColor=''>
  <td valign=middle align=center><img src=images/t.gif height=3><br><b><font color="#DF6336"><?=$number?></font></b></td>
<td valign=middle><?
if(($sitelink1 || $file_name1)) {?><input type=checkbox name=cart value="<?=$data[no]?>" onfocus=blur()><?
} else {?><input type=checkbox name=cart value="<?=$data[no]?>" onfocus=blur() disabled><?
}?></td>
<td align=left valign=middle style='word-break:break-all;'><img src=images/t.gif height=3><br>
&nbsp;<img src="<?=$dir?>/images/mp3a.gif" width="28" height="15" border="0">&nbsp;<?
if($setup[grant_view]<$member[level]&&!$is_admin){
	if(($sitelink1 || $file_name1)) {?><a href="javascript://" onClick="alert('�α����� �ϼž� ���������� ���� �ֽ��ϴ�.')"><?=$data[subject]?></a><?
	} else {?><a href="javascript://" onClick="alert('�α����� �ϼž� ���������� ���� �ֽ��ϴ�.')">&nbsp;&nbsp;<?=$data[subject]?></a><?
	}
} else {
	if(($sitelink1 || $file_name1)) {?><a href="javascript:;" OnClick="window.open('<?echo $dir;?>/song_play.php?<?echo "id=$id&no=$data[no]";?>','yhkimdasommusicIT','scrollbars=no,resizable=no height=255 width=375 top=50 left=50');"><?=$data[subject]?></a><?
	} else {?><a href="javascript://" onClick="alert('��ϵ� ���� �����ϴ�.')">&nbsp;&nbsp;<?=$data[subject]?></a><?
	}
}?>
</td>
<td align=right valign=middle style='word-break:break-all;'><img src=images/t.gif height=3><br>
<?=$a_modify?><img src=<?=$dir?>/images/modify_s.gif border=0  align=absmiddle></a><?=$a_delete?><img src=<?=$dir?>/images/delete_s.gif border=0  align=absmiddle></a><?
if($setup[grant_view]<$member[level]&&!$is_admin){
	if(($sitelink1 || $file_name1)) {?><a href="javascript://" onClick="alert('�������� �����ϴ�.')"><img src=<?=$dir?>/images/audio_on.gif border=0 align=absmiddle></a><?
	} else {?><a href="javascript://" onClick="alert('�������� �����ϴ�.')"><img src=<?=$dir?>/images/audio_on.gif border=0 align=absmiddle></a><?
	}
} else {?><?if(($sitelink1 || $file_name1)) {?><a href="javascript:;" OnClick="window.open('<?echo $dir;?>/song_play.php?<?echo "id=$id&no=$data[no]";?>','yhkimdasommusicIT','scrollbars=no,resizable=no height=255 width=375 top=50 left=50');"><img src=<?=$dir?>/images/audio_on.gif border=0 align=absmiddle></a><?
	} else {?><a href="javascript://" onClick="alert('��ϵ� ���� �����ϴ�.')"><img src=<?=$dir?>/images/audio_on.gif border=0 align=absmiddle></a><?
	}
}
if($setup[grant_view]<$member[level]&&!$is_admin){
	if(($sitelink1 || $file_name1)) {?><a href="javascript://" onClick="alert('�������� �����ϴ�.')"><img src=<?=$dir?>/images/cart.gif border=0 align=absmiddle></a><?
	} else {?><a href="javascript://" onClick="alert('�������� �����ϴ�.')"><img src=<?=$dir?>/images/cart.gif border=0 align=absmiddle></a><?
	}
} else {
	if(($sitelink1 || $file_name1)) {?><a href="javascript:;" OnClick="Cart('<?=$data[no];?>');"><img src=<?=$dir?>/images/cart.gif border=0 align=absmiddle></a><?
	} else {?><a href="javascript://" onClick="alert('��ϵ� ���� �����ϴ�.')"><img src=<?=$dir?>/images/cart.gif border=0 align=absmiddle></a><?
	}
}
if($setup[grant_view]<$member[level]&&!$is_admin){
	if(strlen($data[memo])>$dasom_length2){?><img src=<?=$dir?>/images/gasa.gif border=0 alt='���纸��' style="cursor:hand;" align=absmiddle  onClick="alert('�������� �����ϴ�.')"><?
	} else {?><img src=<?=$dir?>/images/gasa.gif border=0 style="cursor:hand;"  onClick="alert('��ϵ� ���� �����ϴ�.')" align=absmiddle><?
	}
} else {
	if(strlen($data[memo])>$dasom_length2){?><img src=<?=$dir?>/images/gasa.gif border=0 style="cursor:hand;" onclick="javascript:window.open('<?=$dir?>/Dasom_Words.php?<?echo "id=$id&no=$data[no]";?>' , 'Words', ' width=348 height=507 toolbar=no location=no status=no directories=no scrollbars=no resizable=no copyhistory=no');" align=absmiddle alt='���纸��'><?
	}else{?><img src=<?=$dir?>/images/gasa.gif border=0 style="cursor:hand;"  onClick="alert('��ϵ� ���簡 �����ϴ�.')" align=absmiddle><?
	}
}
if($setup[grant_reply]<$member[level]&&!$is_admin){?><img src=<?=$dir?>/images/musicmail.gif border=0 style="cursor:hand;" onClick="alert('�������� �����ϴ�.')" align=absmiddle alt='���Ϸ� ������'><?
} else {?><img src=<?=$dir?>/images/musicmail.gif border=0 style="cursor:hand;" onclick="javascript:window.open('./sendmail_this2.php?<?echo "id=$id&no=$data[no]";?>' , 'sendmail', ' width=400,height=500 toolbar=no location=no status=no directories=no scrollbars=no resizable=no copyhistory=no');" align=absmiddle alt='���Ϸ� ������'><?
}
if($setup[grant_view]<$member[level]&&!$is_admin){
	if(($sitelink2 || $file_name2)) {?><img src=<?=$dir?>/images/musicmv.gif border=0 alt='���� ���� ����' style="cursor:hand;" align=absmiddle  onClick="alert('�������� �����ϴ�.')"><?
	} else {?><img src=<?=$dir?>/images/musicmv_no.gif border=0 style="cursor:hand;"  onClick="alert('��ϵ� ���� �����ϴ�.')" align=absmiddle><?
	}
} else {
	if(($sitelink2 || $file_name2)) {?><a href="javascript:;" OnClick="window.open('<?echo $dir;?>/song_play2.php?<?echo "id=$id&no=$data[no]";?>','yhkimdasommusicIT','scrollbars=no,resizable=no height=215 width=375 top=50 left=50');"><?echo"<img src=$dir/images/musicmv.gif border=0 alt='���� ����' align=absmiddle>";?><?
	} else {?><img src=<?=$dir?>/images/musicmv_no.gif border=0 style="cursor:hand;"  onClick="alert('��ϵ� ���� �����ϴ�.')" align=absmiddle><?
	}
}?></a><img src=<?=$dir?>/images/none.gif border=0 align=absmiddle border=0 width=2>
</td>
<td align=center><img src=images/t.gif height=6><br><?=$hit?></td>
</tr>
<tr>
 <td colspan=7 bgcolor=<?=$sC_light1?>><img src=images/t.gif height=1></td>
</tr>