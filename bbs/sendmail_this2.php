<?

  //////////////////////////////////////////////////////////////////////////////////
  // �Ʒ��� sendmail �÷������� ���� ȯ�� �����Դϴ�.     	                 ///
  //////////////////////////////////////////////////////////////////////////////////
  $home="<a href='http://www.bundangmarathon.com/'>www.bundangmarathon.com</a>";
  $header_url="";	      // �Խ��� ���� �� ����� ���� ������ �տ� �� ������
  $footer_url="";       // url�Դϴ�. ���� ��η� �Ǿ�� �մϴ�.
                        // �ʿ� ������ �е��� �翬�� �� �����ŵ� �˴ϴ�.
  $bgcolor="#FFFFFF";
//  $zboard="http://www.bundangmarathon.com/bbs";    // ���κ��尡 ��ġ�� URL�� �����ּ��� ������ '/'�� ����� �մϴ�.
  $zboard="http://g13.asadal.net/~gumpu/bbs";    // ���κ��尡 ��ġ�� URL�� �����ּ��� ������ '/'�� ����� �մϴ�.
  //////////////////////////////////////////////////////////////////////////////////


  // ���̺귯�� �Լ� ���� ��ũ���
  require "lib.php";

  // DB ����
  if(!$connect) $connect=dbConn();

  // ���� �Խ��� ���� �о� ����
  $setup=get_table_attrib($id);

  // �������� ���� �Խ����϶� ���� ǥ��
  if(!$setup[name]) Error("�������� ���� �Խ����Դϴ�.<br><br>�Խ����� ������ ����Ͻʽÿ�","");

  // ���� �Խ����� �׷��� ���� �о� ����
  $group=group_info($setup[group_no]);

  // ��� ���� ���ؿ���;;; ����� ������
  $member=member_info();

  // ���� �α��εǾ� �ִ� ����� ��ü, �Ǵ� �׷���������� �˻�
  if($member[is_admin]==1||$member[is_admin]==2&&$member[group_no]==$setup[group_no]||$member[board_name]==$id) $is_admin=1; else $is_admin="";

  // ���� ���� �������� ��� �����ϱ�;;;
  $avoid_ip=explode(",",$setup[avoid_ip]);
  for($i=0;$i<count($avoid_ip);$i++)
  {
   if(!isblank($avoid_ip[$i])&&eregi($avoid_ip[$i],$REMOTE_ADDR)&&!$is_admin)
    Error(" Access Denied ");
  }

  // ���� �׷��� ���׷��̰� �α����� ����� �����϶� ����ǥ��
  if($group[is_open]==0&&!$is_admin&&$member[group_no]!=$setup[group_no]) Error("���� �Ǿ� ���� �ʽ��ϴ�");

  // ������ üũ
  if($setup[grant_view]<$member[level]&&!$is_admin) Error("�������� �����ϴ�","login.php?id=$id&page=$page&page_num=$page_num&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&no=$no&file=zboard.php");

  // ��Ų ���丮 : $dir �̶�� ������ ����ؼ� ��Ų��� ���Ϸ� ////
  $dir="skin/".$setup[skinname];
  include("$dir/value.php3");  // ���� �����ϱ�

  //// ���� ���õ� ����Ÿ�� ������, �� $no �� ������ ����Ÿ ������
  $data=mysql_fetch_array(mysql_query("select * from  $t_board"."_$id  where no='$no'"));

  // ������ ����� ����Ÿ�� �������
  if($setup[use_comment]&&$no)
  {
   $comment_result=mysql_query("select * from $t_comment"."_$id where parent='$no' order by no asc");
  }

  // ��б��̰� �н����尡 Ʋ���� �����ڰ� �ƴϰ� �׷��� ����
  if($data[is_secret]&&!$is_admin&&$data[ismember]!=$member[no]&&!$secret[$no])
  {
   if($data[ismember])
   {
    Error("��б��Դϴ�. ������ ������ �����ϴ�");
   }
   else
   {
    $password=mysql_fetch_array(mysql_query("select password('$password')"));
    if($data[password]!=$password[0])
    {
     head();
     $a_list="<a onfocus=blur() href='zboard.php?$href$sort'>";
     $a_view="<Zetyx ";
     $target="view.php";
     $title="�� ���� ��б��Դϴ�.<br>��й�ȣ�� �Է��Ͽ� �ֽʽÿ�";
     $input_password="<input type=password name=password size=20 maxlength=20 class=input>";
     require $dir."/ask_password.php";
     foot();
     exit;
    }
    setcookie("secret[$no]","ok","");
   }
  }

  // �������� ���� �����մϴ�.
  // ���� �� ������ �Ʒ� �������� ������� �ʰ�, mode�� sendit�� ��
  // ������ ���������, Ȥ�� textarea�� �⺻ �������� �ְ� ������ �е���
  // �� �������� �̿��Ͻø� �ǰڽ��ϴ�.
  if ($data[ismember]) {
  $tempx = mysql_fetch_array(mysql_query("select * from zetyx_member_table where no=$data[ismember]"));
  $article_name=$tempx[nick];
  } else {
  $article_name=$data[name]=stripslashes($data[name]);   // �̸�
	 }
  $article_email=$data[email]=stripslashes($data[email]);  // ����
  $article_subject=$data[subject]=stripslashes($data[subject]); // ����
  $article_subject=cut_str($article_subject,$setup[cut_length]); // ���� �ڸ��� �κ�
  $article_music1=$data[sitelink1]=stripslashes($data[sitelink1]); // sitelink1
  $article_music2=$data[sitelink2]=stripslashes($data[sitelink2]); // sitelink2
  $article_music3=$data[file_name1]=stripslashes($data[file_name1]); // file_name1
  $article_music4=$data[file_name2]=stripslashes($data[file_name2]); // file_name2
  $article_memo=$data[memo]=nl2br(stripslashes($data[memo])); // ����
  $article_memo=autolink($article_memo); // �ڵ���ũ �Ŵ� �κ�;;

  $cnt_lnk=0; $cnt_file=0;
  if($data[sitelink1]) $cnt_lnk++;
  if($data[sitelink2]) $cnt_lnk++;
  if($data[file_name1]) $cnt_file++;
  if($data[file_name2]) $cnt_file++;

  $upload_music1=$upload_music2=$upload_music3=$upload_music4="";
  if($data[sitelink1]) $upload_music1="<EMBED SRC=$article_music1 autostart=true loop=false></EMBED><br>";
  if($data[sitelink2]) $upload_music2="<EMBED SRC=$article_music2 autostart=true loop=false></EMBED><br>";
  if($data[file_name1]) $upload_music3="<EMBED SRC=".$zboard."/$article_music3 autostart=true loop=false></EMBED><br>";
  if($data[file_name2]) $upload_music4="<EMBED SRC=".$zboard."/$article_music4 autostart=true loop=false></EMBED><br>";

  // ī�װ��� �̸��� ����
  if($data[category]&&$setup[use_category]) $category_name=$category_data[$data[category]];
  else $category_name="&nbsp;";

  // �۾� �ð��� ����� �ú��� �� ��ȯ��
  $reg_date="<span title='".date("Y�� m�� d�� H�� i�� s��", $data[reg_date])."'>".date("Y/m/d", $data[reg_date])."</span>";

  if(!isBlank($article_email)||$data[ismember]) $article_linked_name="<a href='mailto:$article_email'>$article_name</a>";
  // �ڸ�Ʈ ���;;
  if($setup[use_comment])
  {
   while($c_data=mysql_fetch_array($comment_result))
   {
  if ($c_data[ismember]) {
     $tempx = mysql_fetch_array(mysql_query("select * from zetyx_member_table where no=$c_data[ismember]"));
       $comment_name=$tempx[nick];
      } else {
    $comment_name=stripslashes($c_data[name]);
	 }
    $c_memo=stripslashes($c_data[memo]);
    $c_reg_date="<span title='".date("Y�� m�� d�� H�� i�� s��",$c_data[reg_date])."'>".date("Y/m/d",$c_data[reg_date])."</span>";
    if($comment_result)$article_memo.="<hr>$comment_name - $c_memo";
 }
  }
  //////// MySQL �ݱ� ///////////////////////////////////////////////
  if($connect) mysql_close($connect); $connect="";
  $query_time=getmicrotime();
  ////////////////////////////////////////////////////////////////
  // ���� �Է� �޴� ����� ��� �κ��Դϴ�.

  if(!$mode) {
    $setup[skinname]="";
    $group[header_url]="";
    $group[header]="";
    head("","script_memo.php");
?>
<body bgcolor=<?=$bgcolor?>>

<script>
function check_submit()
{
if(!write.to_email.value) {alert("�������� ������ �����ϴ�.");write.to_email.focus(); return false;}
}
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="images/memo_listtopleft.gif"></td>
    <td background="images/memo_listtop.gif" colspan="2"></td>
    <td><img src="images/memo_listtopright.gif"></td>
  </tr>
  <tr>
    <td background="images/memo_listleftbg.gif"></td>
    <td width="100%"  colspan="2">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  nowrap align=center>
      <font style=font-size:13pt;font-weight:bold>&nbsp;�޽��� ������</font></td>
  </tr>
</table>
</td>
    <td background="images/memo_listrightbg.gif"></td>
  </tr>
  <tr>
    <td><img src="images/memo_listbottomleft.gif"></td>
    <td colspan="2" background="images/memo_listbottom.gif"></td>
    <td><img src="images/memo_listbottomright.gif"></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="images/memo_listtopleft.gif"></td>
    <td background="images/memo_listtop.gif"  width="100%"><img src="images/memo_listtop.gif"></td>
    <td><img src="images/memo_listtopright.gif"></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td background="images/memo_listleftbg.gif"><img src="images/memo_listleftbg.gif"></td>
    <td width="100%">
<table border=0 width=100% cellspacing=0 cellpadding=3>
<form method=post action=<?=$PHP_SELF?> name=write onsubmit="return check_submit()">
<input type=hidden name=mode value="sendit">
<input type=hidden name=id value=<?=$id?>>
<input type=hidden name=no value="<?=$no?>">
<tr>
  <td colspan=2>&nbsp;&nbsp;<b>�Խù� �տ� �� ������ �Է��Ͻ� �� �ֽ��ϴ�.</b></td>
</tr>
<?
  if($member[no])
  {
?>
<tr>
  <td width=50 align=right><img src="images/sm_from.gif"></td>
  <td valign=bottom width=100%>&nbsp;<font color=brown><b><?=$member[nick]?> &lt;<?=$member[email]?>&gt;</td>
</tr>
<?
 }
 else
 {
?>

<tr>
  <td width=50 align=right><img src="images/sm_from.gif"></td>
  <td>&nbsp;<input type=text name=from size=20 maxlength=20 class=input style=border-color:#d8b3b3></td>
</tr>
<?
 }
?>

<tr>
  <Td align=right><img src=images/vi_email.gif></td>
  <td>&nbsp;<input type=text name=to_email size=40 maxlength=40 class=input style=border-color:#d8b3b3></td>
</tr>
<tr>
  <td width=50 align=right><img src=images/vi_subject.gif></td>
  <td>&nbsp;<input type=text style=width:80% name=subject class=input style=border-color:#d8b3b3> <input type=checkbox name=html value=1 checked>Html</td>
</tr>
<tr>
  <td colspan=2 align=center>
<textarea name=memo class=textarea rows=19 style=width:100%;border-color:#d8b3b3>
</textarea></td>
</tr>
<tr>
  <td align=right colspan=2><input type=image border=0 src=images/sm_send.gif> <a href=JavaScript:window.close()><img src="images/memo_close.gif" width="69" height="25" border="0"></a></td>
</tr>
</form>
</table>
    </td>
    <td background="images/memo_listrightbg.gif"><img src="images/memo_listrightbg.gif"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="images/memo_listbottomleft.gif"></td>
    <td width="100%" background="images/memo_listbottom.gif"><img src="images/memo_listbottom.gif"></td>
    <td><img src="images/memo_listbottomright.gif"></td>
  </tr>
</table>

<?
 echo("<div align=center style='font-size:8pt;font-family:tahoma,arial,verdana;color:#bbbbbb'>Sendmail Addon for skin By <a href=mailto:dasomlove75@hotmail.com style='color:#bbbbbb'>dasomlove.net</a></div>");

  }
  ////////////////////////////////////////////////////////////
  // ���� submit�� ����� ó���Դϴ�. ������ ��������..
  elseif($mode=="sendit"){
    $content="<html><head></head><body>";
    if($header_url) {
      $fp=fopen($header_url,"r");
      $content.=fread($fp,filesize($header_url));
      fclose($fp);
      }
    $content.=$memo;
    $content.="\n<link rel=stylesheet type=text/css href=${zboard}/${dir}/style.css><table border=0><tr><td bgcolor=FFFFFF>";
    $content.="<table border=0 cellpadding=5 cellspacing=1 bgcolor=#000000><tr><td td bgcolor=FFFFFF>";
    $content.="<div align=right style='color:gray'>";
    $content.="�� ���� ${home}�� ȸ������ ������Ʈ�� ���Ͽ��� ���� �������� �Դϴ�. [${reg_date}]</div>";
    $content.="<br><b>$article_subject</b><br><br>";
    $content.="<div align=center style='color:gray'>${upload_music1}${upload_music2}${upload_music3}${upload_music4}</div>";
    $content.="<br>";
    $content.="$article_memo";

    if($footer_url) {
      $fp=fopen($footer_url,"r");
      $content.=fread($fp,filesize($footer_url));
      fclose($fp);
      }

    $content.="<div style='font-size:7pt;font-family:arial,verdana,tahoma;color:gray;' align=right>";
    $content.="This mail was sent by <a href='http://www.nzeo.com'>nzeo</a> ";
    $content.="with Sendmail addon produced by <a href='mailto:webmaster@jmclub.com'>Zachekorea.com</a></div>";
    $content.="</td></tr></table>";
    $contetn.="</td></tr></table></body></html>";

    if($from) {
      $header = "Return-Path: $from\n";
      $header .= "From: $from\n";
      $header .= "Reply-to: $from\n";
      $header .= "X-Mailer: Zetyx\n";
      }
      else {
      $header = "Return-Path: $member[email]\n";
      $header .= "From: $member[nick] <$member[email]>\n";
      $header .= "Reply-to: $member[email]\n";
      $header .= "X-Mailer: Zetyx\n";
      }

    if($html) $header .= "Content-Type: text/html;"; else $header .= "Content-Type: text/plain;";
    $header .= "charset=euc-kr\n";
    $header .= "MIME-Version: 1.0\r\n";

    mail($to_email,$subject,$content,$header);
    echo"<script language=\"javascript\">alert(\"������ ���½��ϴ�\");window.close();</script>";
  }
  ////////////////////////////////////////////////////////////
  // ���� ����Ʈ ��带 ó���ϴ� �κ��Դϴ�.
  elseif($mode=="print"){
  ?>

<html>
<head>
<title>
<?=$article_subject?>
</title>
<script language=javascript>
<!--
function print_this() {
window.print();
window.close();
}
-->
</script>
<style>
BODY,TD,SELECT,input,DIV,form,TEXTAREA,center,option,pre,blockquote {font-size:9pt; font-family:����; color:black;line-height:150%}
</style>
</head>
<body onLoad=print_this();>
<div align=right><?=$home?></div>
<br><b>[ <?=$article_subject?> ]</b> - <?=$article_name?><br>
<?=$upload_image1?>
<?=$upload_image2?>
<?=$article_memo?>
</body>
</html>

  <?
  }
?>
