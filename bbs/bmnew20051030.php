<?
	include "../main_top.txt";
?>
<table border="0" cellpadding="0" cellspacing="0" width="504">
    <tr>
        <td width="504" valign="top">
            <div align="left">
                <table border="0" cellpadding="0" cellspacing="0" width="990">
                    <tr>
                        <td width="200" bgcolor="white" background="/img/side_bg.gif" valign="top" height="137">
<?
	include "../menu_intro2.txt";
?>
                        </td>
                        <td width="700" height="137" valign="top" background="/img/main_bg.gif">
                            <table border="0" cellpadding="0" width="660" align="center">
                                <tr>
                                    <td width="656" height="33" colspan="2">
                                        <p style="line-height:150%; margin-top:0; margin-bottom:0;" align="right">
                                        현재위치 : <a href="/index.htm"><font color=blue>HOME</font></a> --&gt;
                                        <a href="/intro2.htm"><font color=blue>게시판</font></a>
                                        --&gt;&gt; 신규내용보기</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="656" colspan="2">
                                        <p align="center"><img src="/img/intro2_01.gif" width="600" height="100" border="0"></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="656" colspan="2">
<?
/*
	admin/trace.php 를 수정함
*/

/* ../ */
/* 앞,뒤 HTML 부분이 빠지면 필요하게 됨
	$_zb_path="";
	include "lib.php";
	$connect=dbconn();
	$member=member_info();
*/
//	if(!$member[no]) Error("회원만이 사용할 수 있습니다");
	if(strlen($hname)>8)
		$hname = substr($hname, 0, 8);

//echo "hname=$hname,level=$member[level], member[no]=$member[no]";		
	if(!$member[no] || $member[level]>8) { // 비회원
		$closedboard="";
		if($hname=="")
			$hname="본인이름";
			
		if(!$member[no])
			$member_id = $hname;
		else
			$member_id = $member[user_id];
	}else{
		$closedboard="'memboard', ";
		$member_id = $member[user_id];
	}

// 새로 테이블이 추가되면 다음 명령 수행 필요
// alter table zetyx_board_xxxxx add index xxxxx_reg_date (reg_date)
	$table_name_result=mysql_query("select name, use_alllist, title from $admin_table where name in (".$closedboard."'pubboard', 'photo') order by title",$connect) or error(mysql_error());
	$s_days = $days;

	head(" bgcolor=white");
?>

<a name="#start">

<div align=center>
<table border=0 cellspacing=0 cellpadding=0 width=98%>
<tr>
  <td><img src=images/trace_back.gif border=0></td>
  <td width=100% background=images/trace_back.gif align=center><img src=/image/collection/new2.gif border=0><font size=5><b>중요 게시판 신규 내용 보기<?if($closedboard=="") echo "(비회원용)"; else echo "(회원용)";?></b></font></td>
  <td><img src=images/trace_back.gif border=0></td>
</tr>
<form action=<?=$PHP_SELF?> method=post>
<tr>
  <td colspan=3 align=center>
  <Table border=1>
	<tr>
  	<td style=line-height:180% height=40 align=right>
  		날짜지정 : <input type=radio name=keykind value='new' <?if($keykind=='new') echo"checked";?>> 신규 &nbsp;
		<input type=radio name=keykind value="today" <?if($keykind=='today') echo"checked";?>> 오늘만 &nbsp;
  		<input type=radio name=keykind value="yesterday" <?if($keykind=='yesterday'|| !$keykind) echo"checked";?>> 어제까지 &nbsp;
  		<input type=radio name=keykind value="day" <?if($keykind=='day') echo"checked";?>> 일수지정 &nbsp;
		<input type=text name=days value="<?=$s_days?>" size=3 class=input>일&nbsp;</td>
<?if(!$member[no]) echo "<td>이름:<input type=text name=hname value=$hname size=8 maxlength=8 class=input onClick=\"this.value='';\"></td>";?>
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
	alert("신규 내용 보기 대상 일수를 지정하십시오.");
	return false;
}
</SCRIPT>
	</tr>
	</form>
	</table>
  </td>
</tr>
</table>
</div>
<table><tr><td align=left>
* 회원게시판/포토갤러리/세상사는이야기에서 지정한 날짜 내에 새로 올라온 게시물이나 꼬리글(memo)을 보여 줍니다.
<br>* '신규'는 신규로 조회한 이후에 올라온 글만을 보여줍니다.
<br>* 게시물 내용을 보고난 후 <font color=red>여기로 다시 돌아올 때는</font> 현재창 맨 위에 있는 '<font color=red><b>뒤로</b></font>' 버튼을 누르십시오
</td></tr></table>

<?
	if(!$member[no] && ($hname=="본인이름" || $hname="")){
		echo "<br><p align=center><font color=red>비회원용이오니 검색 버튼 바로 앞에 본인 이름을 입력하십시오.<br>회원은 로그인 후 사용하십시오.</font>";
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
// etc table 사용 column : (type='new',userid,msgint)
			$newdate_result=mysql_query("select msgint from etc where type='new' and userid = '$member_id'",$connect) or error(mysql_error());
			if($newdate=mysql_fetch_array($newdate_result))
			{
				$check_date = $newdate[0];
				mysql_query("update etc set msgint=".time()." where type='new' and userid = '$member_id'",$connect) or error(mysql_error());
			}else{
				$check_date = time();
				echo "<p align=center>신규 내용 보기 시간이 지정되었습니다.";
				mysql_query("insert into etc (type, userid, msgint) VALUES ('new', '$member_id', $check_date)",$connect) or error(mysql_error());
			}
		}else{
			$check_date = mktime (0,0,0,date("m"),date("d")-$minusdays,date("Y"));
		}
		$allitems = 0;
		while($table_data=mysql_fetch_array($table_name_result))
		{
			$table_name=$table_data[name];
			if($table_data[use_alllist]) $file="zboard.php"; else $file="view.php";
$file="view.php"; // 임시
			// 본문
			$result=mysql_query("select distinct t1.name,t1.no,t1.subject,t1.reg_date from $t_board"."_$table_name as t1, $t_comment"."_$table_name as t2 where (t1.reg_date >= $check_date or t1.no = t2.parent and t2.reg_date >= $check_date) order by t1.no desc", $connect) or error(mysql_error());
?>
<br><br>
<!-- 게시판명 -->
&nbsp;&nbsp;<a href=zboard.php?id=<?=$table_name?>><font size=5 style=font-family:tahoma; color=black><b>*** <?=$table_data[title]?> ***</b></font></a><br>
<?
			for($items = 0; $data=mysql_fetch_array($result); $items++)
			{
				flush();
				if($data[reg_date] >= $check_date)
					$subjectcolor = "blue";
				else
					$subjectcolor = "black";

?>
<br>&nbsp;&nbsp;&nbsp; <font size=3><b>[<?=stripslashes($data[name])?>] &nbsp;
<a href=<?=$file?>?id=<?=$table_name?>&no=<?=$data[no]?>><font color=<?=$subjectcolor?>><?=stripslashes($data[subject])?></font></a></b></font>
&nbsp;&nbsp; &nbsp;&nbsp;
<font color=666666>(<?=date("Y-m-d H:i:s",$data[reg_date])?>)</font>

<?
				/// 코멘트
				$result2=mysql_query("select * from $t_comment"."_$table_name where reg_date >= $check_date and parent=$data[no] order by no desc", $connect) or error(mysql_error());
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
				echo "&nbsp; &nbsp; &nbsp; 새로운 내용이 없습니다.";
			else
				$allitems++;
			mysql_free_result($result);
		}
	}else{
		echo "<p align=center><font color=red>검색 조건을 입력하십시오.</font>";
	}
	if($keykind && $allitems == 0){
		echo "<br><br><br>새로운 내용이 없어 보너스를 드립니다.<br><br>\n";

		echo "<table width=600><tr><td>\n";
// etc table 사용 column : (type='epigram',userid,msgint)
		$result=mysql_query("select msgint from etc where type = 'epigram' and userid = '$member_id'", $connect) or error(mysql_error());
		if($nodata=mysql_fetch_array($result)){
			$epi_no = $nodata[0] + 1;
			$result2=mysql_query("select words,author from epigram where no >= $epi_no order by no limit 1", $connect) or error(mysql_error());
			if(!($epi_data=mysql_fetch_array($result2))){
				$epi_no = 1;
				$result2=mysql_query("select words,author from epigram where no >= $epi_no order by no limit 1", $connect) or error(mysql_error());
				$epi_data=mysql_fetch_array($result2);
			}
			mysql_query("update etc set msgint = $epi_no where type = 'epigram' and userid = '$member_id'",$connect) or error(mysql_error());
		}else{
			$epi_no = 1;
			mysql_query("insert into etc (type, userid, msgint) VALUES ('epigram', '$member_id', $epi_no)",$connect) or error(mysql_error());
			$result2=mysql_query("select words,author from epigram where no >= $epi_no order by no limit 1", $connect) or error(mysql_error());
			$epi_data=mysql_fetch_array($result2);
		}
		echo "<b>$epi_data[0]</b>";
		if($epi_data[1])
			echo " - <b>$epi_data[1]</b>";
		mysql_free_result($result2);
		mysql_free_result($result);

		echo "</td></tr></table>\n";
		
// outlogin.php에 파일 복사 사용
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

/*
if($member[user_id]=="run4joy"){
	$URL = "http://news.google.co.kr/news?hl=ko&ned=kr&ie=UTF-8&q=%EB%A7%88%EB%9D%BC%ED%86%A4+OR+%EB%8B%AC%EB%A6%AC%EA%B8%B0+OR+%EC%A1%B0%EA%B9%85&btnG=%EB%89%B4%EC%8A%A4+%EA%B2%80%EC%83%89";
	echo "<br><br><a href=\"$URL\" target=mnews><font size=5 style=font-family:tahoma; color=blue><b>*** 구글 마라톤 관련 뉴스(마라톤,달리기,조깅) ***</b></font></a><br><br>";
	$outStr = array();
	$fcont = file_get_contents($URL);
	$no = loopStringExtract($fcont, $outStr, "날짜별 순위", "<td valign=top>", "<a ", "</a>", "target=nw", "target=mnews", 10);
	for($n=0; $no > $n; $n++)
		echo $outStr[$n]."<br>\n";
}
*/

	}
	mysql_close($connect);
	$connect="";

?>
<br><Br><Br>
<?
	foot();
?>
                                </tr>
                            </table>
                            <div align="right">
                                <p>&nbsp;</p>
                            </div>
                        </td>
                        <td width="101" height="137" align="left" valign="top">
<?
	include "../quickmenu2.txt";
?>
                        </td>
                    </tr>
                    <tr>
                        <td width="990" colspan="3" bgcolor="#E7E3E7">
<?
	include "../copyright.txt";
?>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>
</body>

</html>
