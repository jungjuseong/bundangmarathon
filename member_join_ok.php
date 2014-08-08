<?
// 라이브러리 함수 파일 인크루드
	include "lib.php";

	if(!eregi($HTTP_HOST,$HTTP_REFERER)) Error("정상적으로 작성하여 주시기 바랍니다.");
	if(!eregi("member_join.php",$HTTP_REFERER)) Error("정상적으로 작성하여 주시기 바랍니다","");
	if(getenv("REQUEST_METHOD") == 'GET' ) Error("정상적으로 글을 쓰시기 바랍니다","");

// DB 연결
	if(!$connect) $connect=dbConn();

// 멤버 정보 구해오기;;; 멤버가 있을때
	$member=member_info();
	if($mode=="admin"&&($member[is_admin]==1||($member[is_admin]==2&&$member[group_no]==$group_no))) $mode = "admin";
	else $mode = "";

	if($member[no]&&!$mode) Error("이미 가입이 되어 있습니다.","window.close");


// 현재 게시판 설정 읽어 오기
	if($id) {
		$setup=get_table_attrib($id);

		// 설정되지 않은 게시판일때 에러 표시
		if(!$setup[name]) Error("생성되지 않은 게시판입니다.<br><br>게시판을 생성후 사용하십시요");

		// 현재 게시판의 그룹의 설정 읽어 오기
		$group_data=group_info($setup[group_no]);
		if(!$group_data[use_join]&&!$mode) Error("현재 지정된 그룹은 추가 회원을 모집하지 않습니다");

	} else {

		if(!$group_no) Error("회원그룹을 정해주셔야 합니다");
		$group_data=mysql_fetch_array(mysql_query("select * from $group_table where no='$group_no'"));
		if(!$group_data[no]) Error("지정된 그룹이 존재하지 않습니다");
		if(!$group_data[use_join]&&!$mode) Error("현재 지정된 그룹은 추가 회원을 모집하지 않습니다");
	}


// 빈문자열인지를 검사
	$user_id = str_replace("ㅤ","",$user_id);
	$name = str_replace("ㅤ","",$name);

	$user_id=trim($user_id);
	if(isBlank($user_id)) Error("ID를 입력하셔야 합니다","");

	$check=mysql_fetch_array(mysql_query("select count(*) from $member_table where user_id='$user_id'",$connect));
	if($check[0]>0) Error("이미 등록되어 있는 ID입니다","");

	unset($check);
	$check=mysql_fetch_array(mysql_query("select count(*) from $member_table where email='$email'",$connect));
	if($check[0]>0) Error("이미 등록되어 있는 E-Mail입니다","");

	if(isBlank($password)) Error("비밀번호를 입력하셔야 합니다","");

	if(isBlank($password1)) Error("비밀번호 확인을 입력하셔야 합니다","");

	if($password!=$password1) Error("비밀번호와 비밀번호 확인이 일치하지 않습니다","");

	if(isBlank($name)) Error("이름을 입력하셔야 합니다","");
	if(eregi("<",$name)||eregi(">",$name)) Error("이름을 영문, 한글, 숫자등으로 입력하여 주십시요");

	$name=addslashes($name);
	$email=addslashes($email);
	if($_zbDefaultSetup[check_email]=="true"&&!mail_mx_check($email)) Error("입력하신 $email 은 존재하지 않는 메일주소입니다.<br>다시 한번 확인하여 주시기 바랍니다.");
	
	$juminno = '';
	$home_address='';
	$home_tel='';
	$office_address='';
	$office_tel='';
	$handphone=addslashes($handphone);
	$comment=addslashes($comment);

	$birth=goodtime($birth_2,$birth_3,$birth_1);

	if(!eregi("http://",$homepage)&&$homepage) $homepage="http://$homepage";
	$reg_date=time();

	$job = '';
	$homepage = '';
	$birth = addslashes($birth);
	$hobby = '';
	$icq = '';
	$msn = '';

	if($HTTP_POST_FILES[picture]) {
		$picture = $HTTP_POST_FILES[picture][tmp_name];
		$picture_name = $HTTP_POST_FILES[picture][name];
		$picture_type = $HTTP_POST_FILES[picture][type];
		$picture_size = $HTTP_POST_FILES[picture][size];
	}

	if($picture_name) {
		if(!is_uploaded_file($picture)) Error("정상적인 방법으로 업로드 해주세요");
		if(!eregi(".gif",$picture_name)&&!eregi(".jpg",$picture_name)) Error("사진은 gif 또는 jpg 파일을 올려주세요");
		$size=GetImageSize($picture);
		if($size[0]>200||$size[1]>200) Error("사진의 크기는 200*200 이하여야 합니다");
		$kind=array("","gif","jpg");
		$n=$size[2];
		$path="icon/member_".time().".".$kind[$n];
		if(!@move_uploaded_file($picture,$path)) Error("사진 업로드가 제대로 되지 않았습니다");
		$picture_name=$path;
	}


	mysql_query("insert into $member_table (level,group_no,user_id,password,name,email,homepage,icq,aol,msn,jumin,comment,job,hobby,home_address,home_tel,office_address,office_tel,handphone,mailing,birth,reg_date,openinfo,open_email,open_homepage,open_icq,open_msn,open_comment,open_job,open_hobby,open_home_address,open_home_tel,open_office_address,open_office_tel,open_handphone,open_birth,open_picture,picture,open_aol) values ('$group_data[join_level]','$group_data[no]','$user_id',password('$password'),'$name','$email','$homepage','$icq','$aol','$msn',password('$jumin'),'$comment','$job','$hobby','$home_address','$home_tel','$office_address','$office_tel','$handphone','$mailing','$birth','$reg_date','$openinfo','$open_email','$open_homepage','$open_icq','$open_msn','$open_comment','$open_job','$open_hobby','$open_home_address','$open_home_tel','$open_office_address','$open_office_tel','$open_handphone','$open_birth','$open_picture','$picture_name','$open_aol')") or Error("회원 데이타 입력시 에러가 발생했습니다<br>".mysql_error());

// yhkim start
	if(substr($junim,7,1)=="2")
		$sex="F";
	else
		$sex="M";
	$nickname = date("Y/m/d");
	$indate = $nickname.";정모최초참석일;회비납입일";
	$juminno = jmchange(1, substr($jumin,0,6)."-".substr($jumin,6,7));
	mysql_query("insert into member (userid,passwd,name,email,orghref,
juminno,etc,sex,org,postaddr,telhome,teloffice,telhand,
membertype,disporder,nickname,indate) values
('$user_id','$password','$name','$email','$homepage',
'$juminno','$comment','$sex','$job','$home_address','$home_tel','$office_tel','$handphone',
'예비회원','99','$nickname','$indate')") or (error("회원 데이타 입력시(member) 에러가 발생했습니다<br>".mysql_error()) + mysql_query("delete from $member_table where user_id='$user_id'"));

	$result = mysql_query("select $member_table.no from $member_table where $member_table.name='총무팀'");
	$data=mysql_fetch_array($result);
	$chongmuno=$data[0];

	$result = mysql_query("select $member_table.no from $member_table, member where $member_table.user_id=member.userid and (member.grade like '회장' or member.grade like '총무%' or member.grade='사무국장' or member.grade='훈련팀장' or member.grade='미디어팀장' or $member_table.user_id='jungjuseong' or $member_table.user_id='run4joy')");
	$subject = "신입($name) 안내";
	$reg_date=time();
	$memo = "소속: $org
생년월일: ".substr($jumin,0,6)."
성별: $sex
집전화: $home_tel
회사전화: $office_tel
핸드폰: $handphone
소개글: $comment";
// 334=총무팀
	for(; $data=mysql_fetch_array($result);){
		mysql_query("insert into $get_memo_table (member_no,member_from,subject,memo,readed,reg_date) values ('$data[no]',$chongmuno,'$subject','$memo',1,'$reg_date')") or error(mysql_error()); 
		mysql_query("insert into $send_memo_table (member_to,member_no,subject,memo,readed,reg_date) values ('$data[no]',$chongmuno,'$subject','$memo',1,'$reg_date')") or error(mysql_error());
		mysql_query("update $member_table set new_memo=1 where no='$data[no]'") or error(mysql_error());
	}
// yhkim end

	mysql_query("update $group_table set member_num=member_num+1 where no='$group_data[no]'");

	if(!$mode) {
		$member_data=mysql_fetch_array(mysql_query("select * from $member_table where user_id='$user_id' and password=password('$password')"));

		// 4.0x 용 세션 처리
		$zb_logged_no = $member_data[no];
		$zb_logged_time = time();
		$zb_logged_ip = $REMOTE_ADDR;
		$zb_last_connect_check = '0';

		session_register("zb_logged_no");
		session_register("zb_logged_time");
		session_register("zb_logged_ip");
		session_register("zb_last_connect_check");
	}


	mysql_close($connect);

// bmfunction.php에 있는 기능
function jmchange($mode,$str){
global $logid;

//echo " $logid:$member[user_id] $mode $str XXXXX";
//echo substr($str, 7, 7);
//echo " $logid $mode $str XXXXX";
//if($logid != 'run4joy'){
//	return $str;
//}
	if(is_numeric(substr($str,7,7))){
	}else{
//echo "<br>";
		return $str;
	}
	$sum=0;
	$newstr=substr($str,0,8);
	for($i=0;$i<6; $i++)
		$sum += 0 + substr($str,$i,1);
	$sum = $sum % 10;
	if($mode==1){
		for($i=8;$i<14; $i++){
			$newstr = $newstr . (0 + substr($str,$i,1) + $sum + substr($str, $i - 8, 1)) % 10;
		}
	}else{
		for($i=8;$i<14; $i++){
			$newstr = $newstr . (20 + substr($str,$i,1) - $sum - substr($str, $i - 8, 1)) % 10;
		}
	}
//echo " $str $newstr XXXXXXXXXXXXXX<br>";
	return $newstr;
}
?>

<script>
	alert("회원가입이 정상적으로 처리 되었습니다\n\n회원이 되신 것을 진심으로 축하드립니다.");
	opener.window.history.go(0);
	window.close();
</script>
