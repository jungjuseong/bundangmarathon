<?
	include "../main_top.txt";
?>
<style>
#C1 { position:absolute; width:190; top:200px; left:0px; }
#C23 { position:absolute; width:710; top:200px; left:190px; }
#C4 { position:absolute; width:100; top:200px; left:900px; }
#copyright { position:absolute; width:1020; top:600px; left:0px;  visibility:hidden;}
</style>
<div id=C1 align="left">
<?
	include "../menu_intro2.txt";
?>
</div>
<div id=C4 align="left">
<?
	include "../quickmenu2.txt";
?>
</div>
<div id=copyright align="left">
<?
	include "../copyright.txt";
?>
</div>
<div id=C23 align="left">
<table border="0" cellpadding="0" width="660" align="center">
	<tr>
		<td width="656" height="33" colspan="2">
			<p style="line-height:150%; margin-top:0; margin-bottom:0;" align="right">
			������ġ : <a href="/index.htm"><font color=blue>HOME</font></a> &gt;
			<a href="/intro2.htm"><font color=blue>�Խ���</font></a>
			&gt; �űԳ��뺸��</p>
		</td>
	</tr>
	<tr>
		<td width="656" colspan="2">
			<p align="center"><img src="/img/intro2_01.gif" width="600" height="100" border="0"></p>
		</td>
	</tr>
</table>
<?
/*
	admin/trace.php �� ������
*/

/* ../ */
/* ��,�� HTML �κ��� ������ �ʿ��ϰ� ��
	$_zb_path="";
	include "lib.php";
	$connect=dbconn();
	$member=member_info();
*/
//	if(!$member[no]) Error("ȸ������ ����� �� �ֽ��ϴ�");
	if(strlen($hname)>8)
		$hname = substr($hname, 0, 8);

//echo "hname=$hname,level=$member[level], member[no]=$member[no]";		
	if(!$member[no] || $member[level]>8) { // ��ȸ��
		$closedboard="";
		if($hname=="")
			$hname="�����̸�";
			
		if(!$member[no])
			$member_id = $hname;
		else
			$member_id = $member[user_id];
	}else{
		$closedboard="'memboard', ";
		$member_id = $member[user_id];
	}

// ���� ���̺��� �߰��Ǹ� ���� ��� ���� �ʿ�
// alter table zetyx_board_xxxxx add index xxxxx_reg_date (reg_date)
	$table_name_result=mysql_query("select name, use_alllist, title from $admin_table where name in (".$closedboard."'pubboard', 'photo', 'hotnews', 'm_letter') order by title",$connect) or error(mysql_error()."111");
	$s_days = $days;

	head(" bgcolor=white");
?>

<a name="#start">

<div align=center>
<table border=0 cellspacing=0 cellpadding=0 width=98%>
<tr>
  <td><img src=images/trace_back.gif border=0></td>
  <td width=100% background=images/trace_back.gif align=center><img src=/image/collection/new2.gif border=0><font size=5><b>�߿� �Խ��� �ű� ���� ����<?if($closedboard=="") echo "(��ȸ����)"; else echo "(ȸ����)";?></b></font></td>
  <td><img src=images/trace_back.gif border=0></td>
</tr>
<form action=<?=$PHP_SELF?> method=post>
<tr>
  <td colspan=3 align=center>
  <Table border=1>
	<tr>
  	<td style=line-height:180% height=40 align=right>
  		��¥���� : <input type=radio name=keykind value='new' <?if($keykind=='new') echo"checked";?>> �ű� &nbsp;
		<input type=radio name=keykind value="today" <?if($keykind=='today') echo"checked";?>> ���ø� &nbsp;
  		<input type=radio name=keykind value="yesterday" <?if($keykind=='yesterday'|| !$keykind) echo"checked";?>> �������� &nbsp;
  		<input type=radio name=keykind value="day" <?if($keykind=='day') echo"checked";?>> �ϼ����� &nbsp;
		<input type=text name=days value="<?=$s_days?>" size=3 class=input>��&nbsp;</td>
<?if(!$member[no]) echo "<td>�̸�:<input type=text name=hname value=$hname size=8 maxlength=8 class=input onClick=\"this.value='';\"></td>";?>
  	<td><input type=image src=images/trace_search.gif border=0 valign=absmiddle onClick="javascript:return(chk_data(this.form));"></td>
<SCRIPT LANGUAGE="javascript">
function chk_data(form) {
	for(var i = 0; i < form.keykind.length; i++){
		if(form.keykind[i].checked){
			if(form.keykind[i].value=='day' && (form.days.value==''||form.days.value==null))
				break;
			return true;
		}
	}
	alert("�ű� ���� ���� ��� �ϼ��� �����Ͻʽÿ�.");
	return false;
}
</SCRIPT>
	</tr>
	</form>
	</table>
  </td>
</tr>
</table>

<table><tr><td align=left>
* ȸ���Խ���/���䰶����/�������̾߱⿡�� ������ ��¥ ���� ���� �ö�� �Խù��̳� ������(memo)�� ���� �ݴϴ�.
<br>* '�ű�'�� �űԷ� ��ȸ�� ���Ŀ� �ö�� �۸��� �����ݴϴ�.
<br>* �Խù� ������ ���� �� <font color=red>����� �ٽ� ���ƿ� ����</font> ����â �� ���� �ִ� '<font color=red><b>�ڷ�</b></font>' ��ư�� �����ʽÿ�
</td></tr></table>
</div>

<?

//outlogin.php�� ����� DivVisible, DivInVisible ���
	echo "
<script language='JavaScript'>
<!--
function DivOnOff(LayerName, type){
	var i,p,v,obj;
// Div menu item = 10
	if(LayerName == '')
		return false;
	p = LayerName;
	obj=document.all[p];
	if (type != 0) {
		v='show';
	}else{
		v='hide';
	}
	if (obj.style) {
		obj=obj.style;
		v=(v=='show')?'visible':(v=='hide')?'hidden':v;
	}
	obj.visibility=v;
	return true;
}

-->
</script>
<div id='waiting' style='position:absolute; left:200px; z-index:1; visibility: visible'>
<font style='color:red; text-decoration:blink'>�ڷ� ó�� ���Դϴ�.<br>��� ��ٷ� �ֽʽÿ�!!!</font>
<script>alert('Photo Gallery�� �̻��� �־� ���� �޴��� �̿��Ͻñ� �ٶ��ϴ�.
������ ���� �����ϰڽ��ϴ�.')</script>
</div>
<div>";				
	flush();
	
	if(!$member[no] && ($hname=="�����̸�" || $hname="")){
		echo "<br><p align=center><font color=red>��ȸ�����̿��� �˻� ��ư �ٷ� �տ� ���� �̸��� �Է��Ͻʽÿ�.<br>ȸ���� �α��� �� ����Ͻʽÿ�.</font>";
		$keykind="";
	}

	if($keykind && ($keykind!="day" || $days))
	{
  		if($keykind=="today"){
			$minusdays = 0;
		}else if($keykind=="yesterday"){
			$minusdays = 1;
		}else if($keykind=="day"){
			$minusdays = $days;
		}
		if($keykind=="new"){
// etc table ��� column : (type='new',userid,msgint)
			$newdate_result=mysql_query("select msgint from etc where type='new' and userid = '$member_id'",$connect) or error(mysql_error()."222");
			if($newdate=mysql_fetch_array($newdate_result))
			{
				$check_date = $newdate[0];
				mysql_query("update etc set msgint=".time()." where type='new' and userid = '$member_id'",$connect) or error(mysql_error()."333");
			}else{
				$check_date = time();
				echo "<p align=center>�ű� ���� ���� �ð��� �����Ǿ����ϴ�.";
				mysql_query("insert into etc (type, userid, msgint) VALUES ('new', '$member_id', $check_date)",$connect) or error(mysql_error()."444");
			}
		}else{
			$check_date = mktime (0,0,0,date("m"),date("d")-$minusdays,date("Y"));
		}
		$allitems = 0;
//echo "check_date=$check_date";
		while($table_data=mysql_fetch_array($table_name_result))
		{
			$table_name=$table_data[name];
			if($table_data[use_alllist]) $file="zboard.php"; else $file="view.php";
$file="view.php"; // �ӽ�
			// ����
			$q="select distinct t1.name,t1.no,t1.subject,t1.reg_date from $t_board"."_$table_name as t1, $t_comment"."_$table_name as t2 where (t1.reg_date >= $check_date or t2.reg_date >= $check_date and t2.parent = t1.no) order by t1.no desc";
// echo "query_string=$q";
			$result=mysql_query($q, $connect) or error(mysql_error()."555");

?>
<br><br>
<!-- �Խ��Ǹ� -->
&nbsp;&nbsp;<a href=zboard.php?id=<?=$table_name?> target=newcont><font size=5 style=font-family:tahoma; color=black><b>*** <?=$table_data[title]?> ***</b></font></a><br>
<?
			for($items = 0; $data=mysql_fetch_array($result); $items++)
			{
				flush();
				if($data[reg_date] >= $check_date)
					$subjectcolor = "blue";
				else
					$subjectcolor = "black";
/*
if($table_name=="photo")
	$file="zboard.php"; // �ӽ�
else
	$file="view.php"; // �ӽ�
*/
?>
<br>&nbsp;&nbsp;&nbsp; <font size=3><b>[<?=stripslashes($data[name])?>] &nbsp;
<a href=<?=$file?>?id=<?=$table_name?>&no=<?=$data[no]?>&dispmode=contonly target=newcont><font color=<?=$subjectcolor?>><?=stripslashes($data[subject])?></font></a></b></font>
&nbsp;&nbsp; &nbsp;&nbsp;
<font color=666666>(<?=date("Y-m-d H:i:s",$data[reg_date])?>)</font>

<?
				/// �ڸ�Ʈ
				$result2=mysql_query("select * from $t_comment"."_$table_name where reg_date >= $check_date and parent=$data[no] order by no desc", $connect) or error(mysql_error()."666");
?>
<br>
<?
				while($data=mysql_fetch_array($result2))
				{
					flush();
?>
<table><tr>
<td width=20>&nbsp;</td>
<td width=70 valign=top align=center>[ <?=stripslashes($data[name])?> ]<br><font color=blue><?=str_replace(' ', '<br>', date("y-m-d H:i:s",$data[reg_date]))?></font></td>
<td valign=top><?=nl2br(trim(stripslashes($data[memo])))?></td>
</tr></table>
<?
				}
				mysql_free_result($result2);
			}
			if($items == 0)
				echo "&nbsp; &nbsp; &nbsp; ���ο� ������ �����ϴ�.";
			else
				$allitems++;
			mysql_free_result($result);
			flush();
		}
	}else{
		echo "<p align=center><font color=red>�˻� ������ �Է��Ͻʽÿ�.</font>";
	}
	if($keykind && $allitems == 0){
		echo "<br><br><br>���ο� ������ �����ϴ�.<br><br>\n";

		echo "<table width=600><tr><td>\n";
// etc table ��� column : (type='epigram',userid,msgint)
		$result=mysql_query("select msgint from etc where type = 'epigram' and userid = '$member_id'", $connect) or error(mysql_error()."777");
		if($nodata=mysql_fetch_array($result)){
			$epi_no = $nodata[0] + 1;
			$result2=mysql_query("select words,author from epigram where no >= $epi_no order by no limit 1", $connect) or error(mysql_error()."888");
			if(!($epi_data=mysql_fetch_array($result2))){
				$epi_no = 1;
				$result2=mysql_query("select words,author from epigram where no >= $epi_no order by no limit 1", $connect) or error(mysql_error()."999");
				$epi_data=mysql_fetch_array($result2);
			}
			mysql_query("update etc set msgint = $epi_no where type = 'epigram' and userid = '$member_id'",$connect) or error(mysql_error()."1010");
		}else{
			$epi_no = 1;
			mysql_query("insert into etc (type, userid, msgint) VALUES ('epigram', '$member_id', $epi_no)",$connect) or error(mysql_error()."1111");
			$result2=mysql_query("select words,author from epigram where no >= $epi_no order by no limit 1", $connect) or error(mysql_error()."1212");
			$epi_data=mysql_fetch_array($result2);
		}
		echo "<b>$epi_data[0]</b>";
		if($epi_data[1])
			echo " - <b>$epi_data[1]</b>";
		mysql_free_result($result2);
		mysql_free_result($result);

		echo "</td></tr></table>\n";
		
// outlogin.php�� ���� ���� ���
/*
function loopStringExtract($inCont, &$outStr, $searchPoint, $loopStart, $strStart, $strStop, $targetIn, $targetOut, $count = 10){
	if(($p = strpos($inCont, $searchPoint)) === FALSE){
		return "";
	}
	$inStr = substr($inCont, $p);
	for($no = $p = 0; !(($p = strpos($inStr, $loopStart, $p)) === FALSE) && $no < $count; $no++){
		$p1 = strpos($inStr, $strStart, $p);
		$p2 = strpos($inStr, $strStop, $p);
		if($p1 === FALSE || $p2 === FALSE)
			continue;
		$p = $p2 + strlen($strStop);
		$str = substr($inStr, $p1, $p-$p1);
		if($targetIn == "")
			$outStr[$no] = $str;
		else{
			$pt = strpos($str, $targetIn);
			if($pt === FALSE)
				$outStr[$no] = $str;
			else{
				$outStr[$no] = str_replace($targetIn, $targetOut, $str);
			}
		}
	}
	return $no;	
}
*/

//if($member[user_id]=="run4joy"){
	$URL = "http://news.google.co.kr/news?hl=ko&newwindow=1&q=%EB%A7%88%EB%9D%BC%ED%86%A4&lr=&ie=UTF-8&oe=EUC-KR&um=1&sa=N&tab=wn";
	echo "<br><br><a href=\"$URL\" target=mnewscont><font size=5 style=font-family:tahoma; color=blue><b>*** ���� ������ ���� ����(������,�޸���,����) ***</b></font></a><br><br>";
	$outStr = array();
	$fcont = file_get_contents($URL);
// $l = strpos($fcont, "</a></div><div class=mainbody></div>");
// echo "<script>alert($l);</script>";
	$no = loopStringExtract($fcont, $outStr, "</a></div><div class=mainbody></div>", "<td valign=top class=j", "<a ", "</a>", "target=nw", "target=mnewscont", 10);
	for($n=0; $no > $n; $n++)
		echo $outStr[$n]."<br>\n";
//}
	}
	mysql_close($connect);
	$connect="";

	echo "<body onLoad=\"DivOnOff('waiting',0)\"> </body>";
?>
<Br><Br>
<?
	foot();
?>
</div>

</body>

</html>
