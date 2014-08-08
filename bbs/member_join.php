<?
// 라이브러리 함수 파일 인크루드
	include "lib.php";

// DB 연결
	if(!$connect) $connect=dbConn();

// 그룹 번호 체크
	if(!$group_no) {
		$tmpResult = mysql_fetch_array(mysql_query("select * from $group_table order by no limit 1"));
		$group_no = $tmpResult[no];
	}

// 멤버 정보 구해오기;;; 멤버가 있을때
	$member=member_info();

	if($mode=="admin"&&($member[is_admin]==1||($member[is_admin]==2&&$member[group_no]==$group_no))) $mode = "admin";
	else $mode = "";

	if($member[no]&&!$mode) Error("이미 가입이 되어 있습니다.","window.close");


// 게시판과 그룹설정에 따라서 회원 가입 설정
	if($id) {
		// 현재 게시판 설정 읽어 오기
		$setup=get_table_attrib($id);

		// 설정되지 않은 게시판일때 에러 표시
		if(!$setup[name]) Error("생성되지 않은 게시판입니다.<br><br>게시판을 생성후 사용하십시요","window.close");

		// 현재 게시판의 그룹의 설정 읽어 오기
		$group=group_info($setup[group_no]);
		if(!$group[use_join]&&!$mode) Error("현재 지정된 그룹은 추가 회원을 모집하지 않습니다","window.close");

	} else {

		if($group_name) $group=mysql_fetch_array(mysql_query("select * from $group_table where name='$group_name'"));
		elseif($group_no) $group=mysql_fetch_array(mysql_query("select * from $group_table where no='$group_no'"));
		if(!$group[no]) Error("지정된 그룹이 존재하지 않습니다");
		if(!$group[use_join]&&!$mode) Error("현재 지정된 그룹은 추가 회원을 모집하지 않습니다");

	}

	$check[1]="checked";

	if(!$referer) $referer=$HTTP_REFERER;

	$setup[header]="";
	$setup[footer]="";
	$setup[header_url]="";
	$setup[footer_url]="";
	$group[header]="";
	$group[footer]="";
	$group[header_url]="";
	$group[footer_url]="";
	$setup[skinname]="";

	head();

	echo "<div align=center><br>";
?>

<script>
 function address_popup(num)
 {
  window.open('zipcode/search_zipcode.php?num='+num,'searchaddress','width=440,height=230,scrollbars=yes');
 }

 function check_submit()
 {

<?
	if(file_exists("./join_license.txt")) {
?>

  if(!write.accept.checked) {
	alert("가입약관에 동의하셔야 회원가입을 할수 있습니다");
	return false;
  }

<?
	}
?>
  if(!write.user_id.value) {alert("아이디를 입력하여 주십시요.");write.user_id.focus(); return false;}

<?
	if($_zbDefaultSetup[enable_hangul_id]=="false") {
?>

  if(write.comment.value.length<20) {
    alert("자기소개 글을 20자 이상 자세히 써 주십시오.");
    write.comment.focus();
    return false;
  }
  // ID Check
  if(write.user_id.value.length<4||write.user_id.value.length>40) {
    alert("아이디는 4자 이상, 40자 이하여야 합니다.");
    write.user_id.focus();
    return false;
  }
  var valid = "abcdefghijklmnopqrstuvwxyz0123456789_";
  var startChar = "abcdefghijklmnopqrstuvwxyz";
  var temp;
  write.user_id.value = write.user_id.value.toLowerCase();
  temp = write.user_id.value.substring(0,1);
  if (startChar.indexOf(temp) == "-1") {
    alert("아이디의 첫 글자는 영문이어야 합니다.");
    write.user_id.value = "";
    write.user_id.focus();
    return false;
  }
  for (var i=0; i<write.user_id.value.length; i++) {
    temp = "" + write.user_id.value.substring(i, i+1);
    if (valid.indexOf(temp) == "-1") {
      alert("아이디는 영문과 숫자, _ 로만 이루어질수 있습니다.");
      write.user_id.value = "";
      write.user_id.focus();
      return false;
    }
  }
<?
	}
?>

  if(!write.password.value) {alert("비밀번호를 입력하여 주십시요.");write.password.focus(); return false;}
  if(!write.password1.value) {alert("비밀번호 확인을 입력하여 주십시요.");write.password1.focus(); return false;}
  if(write.password.value!=write.password1.value) {alert("패스워드가 일치하지 않습니다.");write.password.value="";write.password1.value=""; write.password.focus(); return false;}
  if(!write.name.value) { alert("이름을 입력하세요"); write.name.focus(); return false; }

<? if($group[use_birth])
   { ?>

    if ( write.birth_1.value < 1000 || write.birth_1.value <= 0 )  {
         alert('생년이 잘못입력되었습니다.');
         write.birth_1.value='';
         write.birth_1.focus();
        return false;
    }
    if ( write.birth_2.value > 12 || write.birth_2.value <= 0 ) {
         alert('생월이 잘못입력되었습니다.');
         write.birth_2.value='';
         write.birth_2.focus();
        return false;
    }
    if ( write.birth_3.value > 31 || write.birth_3.value <= 0 )  {
         alert('생일이 잘못입력되었습니다.');
         write.birth_3.value='';
         write.birth_3.focus();
        return false;
    }
<? } ?>
  if(!write.email.value) {alert("E-Mail을 입력하여 주십시요.");write.email.focus(); return false;}

/*
<? if($group[use_jumin]&&!$mode)
   { ?>
   if(!write.jumin1.value) {alert("주민등록번호를 입력하여 주십시요");write.jumin1.focus(); return false;}
   if(!write.jumin2.value) {alert("주민등록번호를 입력하여 주십시요");write.jumin2.focus(); return false;}
<?}?>
*/
   if(!write.jumin1.value) {alert("주민등록번호를 입력하여 주십시요");write.jumin1.focus(); return false;}
   if(!write.jumin2.value) {alert("주민등록번호를 입력하여 주십시요");write.jumin2.focus(); return false;}

   if(!write.home_address.value) {alert("집주소를 입력하여 주십시요");write.home_address.focus(); return false;}
   if(!write.home_tel.value) {alert("집 전화번호를 입력하여 주십시요");write.home_tel.focus(); return false;}
/*
   if(!write.office_address.value) {alert("사무실 주소를 입력하여 주십시요");write.office_address.focus(); return false;}
   if(!write.office_tel.value) {alert("사무실 전화번호를 입력하여 주십시요");write.office_tel.focus(); return false;}
*/
   if(!write.handphone.value) {alert("휴대폰 번호를 입력하여 주십시요");write.handphone.focus(); return false;}


  return true;
  }

  function check_id(id)
  {
   if(!id)
   {
    alert('아이디를 입력하여 주십시요');
   }
   else
   {
    window.open('check_user_id.php?user_id='+id,'check_user_id','width=200,height=100,toolbar=no,status=no,resizable=no');
   }
  }

  function check_accept() {
	return confirm("위의 가입 약관을 모두 보았으며, 동의하십니까?");
  }

</script>
<table border=0 cellspacing=1 cellpadding=0 width=540>
<form name=write method=post action=member_join_ok.php enctype=multipart/form-data onsubmit="return check_submit();">
<input type=hidden name=id value=<?=$id?>>
<input type=hidden name=referer value="<?=$referer?>">
<input type=hidden name=group_no value="<?=$group[no]?>">
<input type=hidden name=mode value="<?=$mode?>">

  <tr>
<!--
      <td colspan=2>
        <img src=images/member_joinin.gif>
-->
      <td colspan=2 align=center>
	<font color=blue size="+2">분당마라톤클럽 가입신청</font>
        <br><br></td></tr>

<?
	if(file_exists("./join_license.txt")) {
		$f=fopen("join_license.txt",r);
		$join_license = fread($f,filesize("join_license.txt"));
		fclose($f);
?>
  <tr><td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="3"></td></tr>
  <tr>
  	<td colspan=2>
  		<br><div align=center><textarea cols=80 rows=12 readonly style=border-color:#d8b3b3;width:95% class=input><?=$join_license?></textarea></div>
	</td>
  </tr>
  <tr>
  	<td colspan=2>&nbsp;&nbsp;&nbsp;<input type=checkbox name=accept value=1 onclick="return check_accept()"> 위의 가입 약관에 동의합니다</td>
  </tr>
<?
	}
?>
        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="3"></td>
        </tr>
  <tr align=right>
     <td width=25% style=font-family:Tahoma;font-size:8pt;><b>ID&nbsp;</td>
     <td align=left>&nbsp;<input type=text name=user_id size=20 maxlength=20 style=border-color:#d8b3b3 class=input> <input type=button value='Check ID' style=color:#000000;border-color:#dfb8b8;background-color:#f0f0f0;font-size:8pt;font-family:Tahoma;height:20px; onclick=check_id(write.user_id.value)><br><img src=images/t.gif border=0 height=4><? if($_zbDefaultSetup[enable_hangul_id]=="false") {?><br>&nbsp;(영문,숫자,_로만 아이디를 작성하세요)<? } ?></td>
  </tr>
        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
  <tr align=right height=28>
     <td style=font-family:Tahoma;font-size:8pt;><B>Password&nbsp;</td>
     <td align=left>&nbsp;<input type=password name=password size=20 maxlength=20 style=border-color:#d8b3b3 class=input> 확인 : <input type=password name=password1 size=20 maxlength=20 style=border-color:#d8b3b3 class=input></td>
  </tr>
        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
  <tr align=right height=28>
     <td style=font-family:Tahoma;font-size:8pt;><b>Name&nbsp;</td>
     <td align=left>&nbsp;<input type=text name=name size=20 maxlength=20 value="<?=$member[name]?>" style=border-color:#d8b3b3 class=input>(실명이 아니면 통보없이 삭제됩니다.)</td>
  </tr>
        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
<? if($group[use_birth]) { ?>
  <tr align=right height=28>
     <td style=font-family:Tahoma;font-size:8pt;><b>Birthday&nbsp;</td>
     <td align=left>&nbsp;<input type=text name=birth_1 size=4 maxlength=4 style=border-color:#d8b3b3 class=input> 년
                    &nbsp;<input type=text name=birth_2 size=2 maxlength=2 style=border-color:#d8b3b3 class=input> 월
                    &nbsp;<input type=text name=birth_3 size=2 maxlength=2 style=border-color:#d8b3b3 class=input> 일
          <input type=checkbox value=1 checked name=open_birth> 공개
  </tr>        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
<? } ?>

  <tr align=right height=28>
     <td style=font-family:Tahoma;font-size:8pt;><b>E-mail&nbsp;</td>
     <td align=left>&nbsp;<input type=text name=email size=50 maxlength=255 value="<?=$member[email]?>" style=border-color:#d8b3b3 class=input>
                          <input type=checkbox value=1 name=open_email checked> 공개
                          </td>
  </tr> 
        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>

<? if($group[use_handphone]) { ?>
  <tr align=right height=28>
     <td style=font-family:Tahoma;font-size:8pt;>이동전화번호&nbsp;</td>
     <td align=left>&nbsp;<input type=text name=handphone size=20 maxlength=20 value="<?=$member[handphone]?>" style=border-color:#d8b3b3 class=input>
                          <input type=checkbox value=1 name=open_handphone checked> 공개</td>
  </tr>        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
<? } ?>

<? if($group[use_mailing]) { ?>
  <tr align=right height=28>
     <td style=font-family:Tahoma;font-size:8pt;><b>Mailling List&nbsp;</td>
<!--
     <td align=left>&nbsp;<input type=checkbox name=mailing value=1 checked> 메일링 가입</td>
-->
     <td align=left>&nbsp;<input type=hidden name=mailing value=1 > 메일링 자동 가입</td>
  </tr>        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
<? } ?>

<? if($group[use_picture]) { ?>
  <tr align=right height=28>
     <td style=font-family:Tahoma;font-size:8pt;>본인 사진&nbsp;<br>(200*200 이하)</td>
     <td align=left>&nbsp;<input type=file name=picture size=35 maxlength=255 style=border-color:#d8b3b3 class=input>
                 <? if($member[picture]) echo"<br>&nbsp;<img src='$member[picture]' border=0>"; ?>
                          <input type=checkbox value=1 name=open_picture checked> 공개
     </td>
  </tr>        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
<? } ?>

<? if($group[use_comment]) { ?>
  <tr align=right height=28>
     <td style=font-family:Tahoma;font-size:8pt;>자기 소개서<br>(달리기 경력 및<br> 개인 신상)</td>
     <td align=left>&nbsp;<textarea cols=50 rows=4 name=comment style=border-color:#d8b3b3 class=textarea><?=$member[comment]?></textarea><br>&nbsp;<input type=checkbox value=1 name=open_comment checked> 공개</td>

  </tr>        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>
<? } ?>

  <tr align=right height=28>
     <td style=font-family:Tahoma;font-size:8pt;><b>개인정보 공개</td>
     <td align=left>&nbsp;<input type=checkbox name=openinfo value=1 checked> 정보 공개</td>
  </tr>        <tr>
          <td colspan="5" bgcolor="#EBD9D9" align="center"><img src="images/t.gif" width="10" height="1"></td>
        </tr>

<tr height=30 bgcolor=#ffffff>
   <td  colspan=2 align=right ><img src=images/t.gif height=5><br>
   <input type=image border=0 src=images/button_join.gif> &nbsp;
   <img src=images/memo_close.gif border=0 onClick=window.close() style=cursor:hand>&nbsp;&nbsp;&nbsp;
   </td>
</tr>

  </form>
</table>


<?
	@mysql_close($connect);
	foot();
?>
