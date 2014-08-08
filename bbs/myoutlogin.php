<?php
/*******************************************************************************
 * Zeroboard 4.1 pl2 외부 로그인 파일
 *
 * 이 파일은 외부로그인으로 사용할시에 사용하시면 됩니다.
 *
 * 사용방법은 다음과 같습니다.
 *
 * 외부로그인을 원하시는 문서의 제일 상단에 다음과 같이 입력하세요
 *
 * <?
 *   $_zb_url = "http://도메인/제로보드경로/";                 // 끝에 꼭 / 를 써주세요
 *   $_zb_path = "/home/계정아이디/public_html/제로보드경로/"; // 끝에 꼭 / 를 써주세요
 *   include $_zb_path."outlogin.php";
 * ?>
 *
 *
 * 그런후 외부로그인 폼이나 로그인 상태를 표시하고 싶은곳에 다음과 같이 입력하세요
 *
 * <?print_outlogin("스킨이름","그룹번호","허용레벨");?>
 *
 *
 * 위에서 "/home/계정 아이디/public_html/제로보드 경로/" 라는 것은 제로보드의 절대 경로를 나타냅니다.
 *
 * 위에서 $_zb_url 과 $_zb_path 는 꼭 적어 주셔야 합니다.
 *
 * 절대경로는 관리자 페이지 메인 제일 아래에 있습니다
 *
 * 위와 같이 하면 로그인이 되었을때는 로그인 정보가, 그렇지 않은 경우에는 로그인 폼이 나타납니다.
 *
 * 로그인 정보와 로그인 폼을 수정하실때에는 제로보드경로/outlogin_skin/ 에 있는 파일을 수정하시면 됩니다.
 *
 * 로그인 되어 있는 상태 : logged.html
 * 로그인 폼 : login.html
 *
 * 위의 두 파일을 수정 하시면 됩니다.
 *
 * 그리고 만약 원하는 html 파일에서 레벨에 따른 권한을 제한 하고 싶을때에는 $level 변수를 수정하시면 됩니다.
 *
 * 라고 하시면 9이하의 레벨만 해당 페이지에 접속이 가능합니다.
 *
 * 실제 적용 파일을 보시려면 outlogin_skin 디렉토리내의 index.html 파일을 열어보세요.
 *
 * 외부로그인 모양을 바꾸시려면 outloing_skin 디렉토리 내의 README.TXT 파일을 꼭 읽어 주시기 바랍니다.
 *
 *******************************************************************************/

	global $member, $_head_php_excuted, $REQUEST_URI, $_zb_lib_included, $HTTP_SESSION_VARS, $total_member_connect, $total_guest_connect;
	global $a_member_join, $a_member_modify, $a_member_memo, $member_memo_icon, $memo_on_sound, $a_logout, $a_login, $id, $PHP_SELF, $_outlogin_include;

	if(eregi(":\/\/",$_zb_path)||eregi("\.\.",$_zb_path)) $_zb_path ="./";
	// outlogin.php 파일이 include 되었는지를 체크
	if(!$_outlogin_include) {
		$_outlogin_include = TRUE;
	} else {
		return FALSE;
	}

	// 처음에 include 되었을때 필요한 파일을 include 하는 부분
	if(!$_head_php_excuted&&!$_zb_lib_included) {

		// 제로보드 디렉토리 인지 체크
		if(!file_exists($_zb_path."lib.php")) {
 			echo "제로보드 디렉토리가 아닙니다";
			return;
		}

		// _head.php 읽음
		@include $_zb_path."_head.php";

	}

	function print_outlogin($skinname = "default", $group_no = 1, $level = "10") {
		global $member, $_head_php_excuted, $REQUEST_URI, $HTTP_SESSION_VARS, $total_member_connect, $total_guest_connect, $_zb_path, $_zb_url;
		global $a_member_join, $a_member_modify, $a_member_memo, $member_memo_icon, $memo_on_sound, $a_logout, $a_login, $id, $PHP_SELF, $_outlogin_include;
		global $keykind;	// yhkim

		if($level < $member[level]) {
?>
			<script>
				alert("인증된 회원만 접근 가능합니다");
				history.back();
			</script>
<?
			exit;
		}

		// 회원 정보가 있는지 없는지를 체크해서 해당 스킨 파일을 읽음
		if (!$member[no]) {	// 비회원

			$f = fopen($_zb_path."script/outlogin_script.php",r);
			$_outlogin_script = fread($f, filesize($_zb_path."script/outlogin_script.php"));
			fclose($f);

			$f = fopen($_zb_path."outlogin_skin/$skinname/login.html",r);
			$_outlogin_data = fread($f, filesize($_zb_path."outlogin_skin/$skinname/login.html"));
			fclose($f);

			$login_img = $_zb_url."outlogin_skin/$skinname/images/i_login.gif";
			$join_img = $_zb_url."outlogin_skin/$skinname/images/i_join.gif";
			$help_img = $_zb_url."outlogin_skin/$skinname/images/i_help.gif";

			$_outlogin_data = str_replace("[action]", $_zb_url."mylogin_check.php",$_outlogin_data);
			$s_url = $REQUEST_URI;
			if($id&&!eregi($id, $s_url)) {
				if(eregi("\?",$s_url)) $s_url = $s_url . "&id=$id";
				else $s_url = $s_url . "?id=$id";
			}
/*
			if($keykind) {
				$s_url = $s_url . "?keykind=$keykind";
			}
*/
			$_outlogin_data = str_replace("[s_url]", urlencode($s_url),$_outlogin_data);

			$aUrl = "?group_no=".$group_no;

			$_outlogin_data = str_replace("[member_join]", "<a href=# onclick=\"window.open('".$_zb_url."member_join.php".$aUrl."','zbMemberJoin','width=560,height=590,toolbars=no,resizable=yes,scrollbars=yes')\"><img src=$join_img border=0></a>",$_outlogin_data);
			$_outlogin_data = str_replace("[login]", "<input type=image src=$login_img border=0>",$_outlogin_data);
			$_outlogin_data = str_replace("[lost_id]", "<a href=# onclick='window.open(\"".$_zb_url."lostid.php\",\"lost_id\",\"width=400,height=200,toolbars=no,autoscrollbars=no\")'><img src=$help_img border=0></a>",$_outlogin_data);

			$_outlogin_data = str_replace("[total_member_connect]",number_format($total_member_connect),$_outlogin_data);
			$_outlogin_data = str_replace("[total_guest_connect]",number_format($total_guest_connect),$_outlogin_data);
			$_outlogin_data = str_replace("[total_connect]",number_format($total_member_connect+$total_guest_connect),$_outlogin_data);
			$_outlogin_data = str_replace("[dir]",$_zb_url."outlogin_skin/$skinname/images/",$_outlogin_data);

			if($group_no) {
				$_outlogin_data = str_replace("</form>","<input type=hidden name=group_no value='$group_no'></form>",$_outlogin_data);
			}

			print $_outlogin_script."\n";
			print $_outlogin_data."\n";

		} else {	// 회원시작

			$f = fopen($_zb_path."outlogin_skin/$skinname/logged.html",r);
			$_outlogin_data = fread($f, filesize($_zb_path."outlogin_skin/$skinname/logged.html"));
			fclose($f);

			$memo_on_img = $_zb_url."outlogin_skin/$skinname/images/i_memo_on.gif";
			$memo_off_img = $_zb_url."outlogin_skin/$skinname/images/i_memo_off.gif";
			$logout_img = $_zb_url."outlogin_skin/$skinname/images/i_logout.gif";
			$info_img = $_zb_url."outlogin_skin/$skinname/images/i_info.gif";
			$admin_img = $_zb_url."outlogin_skin/$skinname/images/i_admin.gif";
			$memo_swf = $_zb_url."outlogin_skin/$skinname/images/i_memo.swf";

			if($member[new_memo]) {
				$memo_on_image = "<img src=$memo_on_img border=0 align=absmiddle> ";
				$memo_on_sound_out ="<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0' width='0' height='0'><param name=menu value=false><param name=wmode value=transparent><param name=movie value='$memo_swf'><param name=quality value=low><param name='LOOP' value='false'><embed src='$memo_swf' quality=low pluginspage='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash' type='application/x-shockwave-flash' width='0' height='0' loop='false' wmode=transparent menu='false'></embed></object>";

				echo "<script>if(confirm('쪽지가 왔습니다. 확인하시겠습니까?')){window.open('".$_zb_url."member_memo.php','member_memo','width=450,height=500,status=no,toolbar=no,resizable=yes,scrollbars=yes')};</script>\n";	// yhkim insert 신규쪽지 알림
			} else {
				$memo_on_image = "<img src=$memo_off_img border=0 align=absmiddle> ";
			}

// yhkim start
			$_outlogin_data = str_replace("[yhkim]","",$_outlogin_data);
// yhkim end

			$_outlogin_data = str_replace("[memo]",$memo_on_image,$_outlogin_data);
			$_outlogin_data = str_replace("[name]",$a_member_memo."<b>".del_html($member[name])."</b></a>",$_outlogin_data);
			$_outlogin_data = str_replace("[logout]",$a_logout."<img src=$logout_img border=0></a>",$_outlogin_data);

			$_outlogin_data = str_replace("[info]",$a_member_modify."<img src=$info_img border=0></a>",$_outlogin_data);
			if($member[is_admin]==1||$member[is_admin]==2) $_outlogin_data = str_replace("[admin]","<a href=".$_zb_url."admin.php target=blank><img src=$admin_img border=0></a>",$_outlogin_data);
			else $_outlogin_data = str_replace("[admin]","",$_outlogin_data);
			$_outlogin_data = str_replace("[join_date]",date("Y/m/d",$member[reg_date]),$_outlogin_data);
			$_outlogin_data = str_replace("[level]",$member[level],$_outlogin_data);
			$_outlogin_data = str_replace("[point]",number_format($member[point1]*10+$member[point2]),$_outlogin_data);
			$_outlogin_data = str_replace("[write_num]",number_format($member[point1]),$_outlogin_data);
			$_outlogin_data = str_replace("[write_comment]",number_format($member[point2]),$_outlogin_data);
			$_outlogin_data = str_replace("[total_member_connect]",number_format($total_member_connect),$_outlogin_data);
			$_outlogin_data = str_replace("[total_guest_connect]",number_format($total_guest_connect),$_outlogin_data);
			$_outlogin_data = str_replace("[total_connect]",number_format($total_member_connect+$total_guest_connect),$_outlogin_data);
			$_outlogin_data = str_replace("[dir]",$_zb_url."outlogin_skin/$skinname/images/",$_outlogin_data);

			print $_outlogin_data.$memo_on_sound_out ."\n";

// yhkim insert
if($member[level] <= 6){

	if($member[user_id] == 'run4joy'){
			echo "
<script>
function GetCookie( name )
{
  var cname = name + '=';
  var dc = document.cookie;
  if( dc.length > 0 )
  {
    begin = dc.indexOf( cname );
    if( begin >= 0 )
    {
      begin += cname.length;
      end = dc.indexOf( ';', begin );
      if( end == -1 )
        end = dc.length;
      return  unescape( dc.substring(begin, end) );
      return  dc.substring( begin, end );
    }
  }
  return  null;
}
var exp = new Date();
exp.setTime( exp.getTime() + (1000 * 12*60*60) ); 12시간
exptime = 'expires=' + exp.toGMTString() + ';';
name='deltime';
value='12hours';
document.cookie = name + '=' +value + '; path=/; ' + exptime;

var deltime=GetCookie('deltime');
if (deltime){

	}else{
	var dbfs=GetCookie('c_code');
	if (dbfs){
		yhkimdasommusicIT=window.open('/bbs/skin/ting_music/listen_all.php?id=music&selected='+dbfs+',', 'yhkimdasommusicIT', 'scrollbars=no,resizable=no height=275 width=375 top=50 left=410');
	}
}
</script>";
		
	//음악 표시
	echo "<div align=center><a href='javascript:void(0)' onClick=\"var openwin = window.open('/bbs/zboard.php?id=music', 'musiclist', 'width=695,height=800,scrollbars=yes,resize=yes'); openwin.focus();return false;\"><img src=/image/collection/music.gif border=0></a></div>";
	
	//	echo "<script>alert('클럽활동-설문조사에 응해 주시기 바랍니다.');</script>\n";
	}	// if 'run4joy'
	
	// 생일 표시
	$mmdd1 = date("m.d");
	$mmdd2 = date("m.d", mktime(0, 0, 0, date("m"), date("d")+14, date("Y")));
	$dbquery = "select name,birthsun,userid from member where birthsun >= '$mmdd1' and birthsun <= '$mmdd2' and (membertype='정회원' or membertype='준회원') order by birthsun, gumpuno";
	$result = mysql_query($dbquery) or die("mysql_query error(etc('today') table select: $dbquery)");
	echo "<div align=center>2주간 회원 생일<br>";
	if(mysql_num_rows($result) == 0){
		echo "없음\n";
	}else{
		echo "<img src=/image/cake.gif><img src=/image/rose.gif>";
	}

	$birthdaydisplayno = 3;	// 생일 표시 인원수
	for($i=0; ($data=mysql_fetch_array($result)) && $i < $birthdaydisplayno; $i++) {
		echo "<br>$data[0] $data[1] ";
		if($data[2] == $member[user_id] && $data[1] == $mmdd1){
			$dbquery = "select msgint from etc where type='birthday' and userid='$member[user_id]'";
			$result2 = mysql_query($dbquery) or die("mysql_query error(etc('birthday') table select: $dbquery)");
			$first = 0;
			$yyyy = date("Y");
			if(mysql_num_rows($result2) == 0){
				$first++;
				$dbquery3="insert into etc (type,userid,msgstr,msgint) VALUES ('birthday','$member[user_id]','',$yyyy)";
				$result3 = mysql_query($dbquery3);
			}else{
				$data2=mysql_fetch_array($result2);
				if($data2[0] != $yyyy){
					$first++;
					$dbquery3="update etc set msgint=$yyyy where type='birthday' and userid='$member[user_id]'";
				    $result3 = mysql_query($dbquery3) or die("mysql_query error(etc table update birthday):".mysql_error());
				}
			}
			if($first > 0){
				echo "\n
<script>
newwinhappy=window.open('/happybirthday.html','match','width=500,height=600,statusbar=no,toolbar=no,resizable=no,scrollbars=no');newwinhappy.focus();
</script>\n";
                	}
		}
	}
	echo "</div>";
	// 생일 표시 끝

	// 5기 회장선출
/*
if(date("Ymd") >= "20080702" && date("Ymd") <= "20080704"){
	$dbquery = "select poll0 from poll where pollid = '2008election' and userid = '$member[user_id]'";
	$result = mysql_query($dbquery) or die("mysql_query error(poll table select: $dbquery)");
	$dbquery = "select msgstr from etc where type='2008elect' and userid='$member[user_id]' and msgstr='". date("Ymd") ."'";
	$result2 = mysql_query($dbquery) or die("mysql_query error(etc('today') table select)");
	if(mysql_num_rows($result) == 0 && mysql_num_rows($result2) == 0)
	{
		echo "
<script>
alert('5기 회장 선출 투표에 참여 부탁 드립니다.(회원광장-설문조사/기타-제5기회장단선출)');
</script>";
		$dbquery="delete from etc where type='2008elect' and userid='$member[user_id]'";
		$result3 = mysql_query($dbquery) or die("mysql_query error(etc table delete):".mysql_error());
		$dbquery="insert into etc (type,userid,msgstr,msgint) VALUES ('2008elect','$member[user_id]','". date("Ymd") ."',0)";
		$result3 = mysql_query($dbquery) or die("mysql_query error(etc table insert):".mysql_error());
			if(mysql_affected_rows() == 0){
				errornback("etc table에 추가할 수 없습니다.\n<br>$dbquery\n");
				die();
			}
	}
}
*/

	// 워크샵  설문 참여 
/*
if(date("Ymd") <= "20061225"){
	$dbquery = "select userid from minipolla where pollno=9 and userid = '$member[user_id]'";
	$result = mysql_query($dbquery) or die("mysql_query error(etc('minipolla') table select: $dbquery)");
	if(mysql_num_rows($result) == 0){
			echo "
<script>
alert('설문 조사에 참여 바랍니다.');
newwin=window.open('/bbs/minipoll.php','match','width=300,height=400,statusbar=no,toolbar=no,resizable=yes,scrollbars=yes');newwin.focus();
</script>";
	}
}
*/
		
	// 생일 입력
		$dbquery = "select birthdate,birthtype,birthsun from member where userid = '$member[user_id]'";
		$result = mysql_query($dbquery) or die("mysql_query error(etc('today') table select: $dbquery)");
		$row=mysql_fetch_array($result);
	
		if(mysql_num_rows($result) == 1 && (strlen(chop($row[2])) != 5 || $row[2] == "mm.dd")){
			echo "
<script>
alert('생일 입력 부탁 드립니다.');
newwin=window.open('/bbs/update.php?type=birth&mode=0','match','width=320,height=350,statusbar=no,toolbar=no,resizable=yes,scrollbars=auto');newwin.focus();
</script>";
		}
	// 생일 입력 끝

	// 혈액형 입력
		$dbquery = "select bloodtype from member where userid = '$member[user_id]'";
		$result = mysql_query($dbquery) or die("mysql_query error(member table select: $dbquery)");
		$row=mysql_fetch_array($result);
		if(mysql_num_rows($result) == 1 && strlen(chop($row[0])) < 1){
			echo "
<script>
alert('혈액형 입력 부탁 드립니다.');
newwin=window.open('/bbs/update.php?type=blood&mode=0','match','width=320,height=350,statusbar=no,toolbar=no,resizable=yes,scrollbars=auto');newwin.focus();
</script>";
		}
	// 혈액형 입력 끝

	// 투표 안내(정회원만)
/*
if(date("Y.m.d") <= "2006.06.09" && ($PHP_SELF == "/bbs/zboard.php" || $PHP_SELF == "/bbs/bmnew.php")){
	$dbquery = "select polltime from poll where pollid='200606revise' and userid='$member[user_id]'";
	$result = mysql_query($dbquery) or die("mysql_query error(poll table select: $dbquery)");
	if(mysql_num_rows($result) == 0){
		$dbquery = "select name from member where userid='$member[user_id]' and membertype='정회원'";
		$result = mysql_query($dbquery) or die("mysql_query error");
		if(mysql_num_rows($result) > 0){
			echo "<script>alert('회칙개정 투표해 주십시오.(귀찮게 해서 죄송합니다.)');location.href='/intro1_07.htm?url=".base64_encode("/bbs/200606revise.html")."';</script>\n";
		}
	}
}
*/

// 2006 상반기 산행 의견
/*
if(date("Ymd") < "20060320" && $member[level] <= 6){
		$dbquery = "select no from zetyx_board_comment_pubboard where parent=1182 and ismember=$member[no]";
		$result = mysql_query($dbquery) or die("mysql_query error(etc('today') table select: $dbquery)");
		if(mysql_num_rows($result) == 0){ // $member[user_id] == 'run4joy' && 
			echo "
<script>
newwin=window.open('/bbs/2006san1.html','match','width=300,height=320,statusbar=no,toolbar=no,resizable=no,scrollbars=no');newwin.focus();
</script>";
		}
}
*/
// 2006 상반기 산행 의견 끝

// 하루 한번씩 처리하는 일들. one time in a day

$dbquery = "select msgstr from etc where type='notify' and userid='$member[user_id]'";
$result = mysql_query($dbquery) or die("mysql_query error(etc('today') table select)");
if($member[user_id] == 'run4joy' && mysql_num_rows($result) > 0){
	$msg=mysql_fetch_array($result);
	echo "<script>alert('$msg[0]');</script>\n";
	$dbquery = "delete from etc where type='notify' and userid='$member[user_id]'";
	$result = mysql_query($dbquery) or die("mysql_query error(etc('today') table select)");
}
$today = date("Y")."/".date("m")."/".date("d");
$dbquery = "select msgstr from etc where type='today' and userid='$member[user_id]' and msgstr = '$today'";
$result = mysql_query($dbquery) or die("mysql_query error(etc('today') table select)");
//if($member[user_id] == 'run4joy' && mysql_num_rows($result) == 0)
if(mysql_num_rows($result) == 0){
// load 작은 순으로 처리
	// process1 : 훈련 등록
	$lastday = date("Y/m/d", mktime(0,0,0,date("m"),date("d")-10,date("Y")));
	$dbquery="SELECT distinct yyyymmdd FROM training where yyyymmdd > '$lastday' order by yyyymmdd desc";
	$result1 = mysql_query($dbquery) or die("mysql_query error(training table select in):".mysql_error());
	$allrows = mysql_num_rows($result1);
	$dbquery="SELECT yyyymmdd FROM training WHERE userid='$member[user_id]' AND (onoff='Y' OR onoff='N') and yyyymmdd > '$lastday'";
	$result2 = mysql_query($dbquery) or die("mysql_query error(training table select2):".mysql_error());
	$onoffrows = mysql_num_rows($result2);
	if($allrows > $onoffrows){
		$onoffymds="";
		for($i=0; $row=mysql_fetch_array($result2); $i++){
		    	$onoffymds .= "$row[0]:";
		}
//echo "onoffymds=$onoffymds ";
		$yyyymmdds="";
		for($i=0; $row=mysql_fetch_array($result1); ){
		    $yyyymmdd = $row[0];
		    if(strpos($onoffymds, $yyyymmdd) === false){
				if($i > 0){
		    		$yyyymmdds .= ":$row[0]";
		    	}else{
		    		$yyyymmdds .= "$row[0]";
	    		}
	    		$i++;
	    		if($allrows == ($onoffrows + $i))
	    			break;
    		}
		}
//echo "yyyymmdds=$yyyymmdds ";
		echo "
<script>
trainingedit=window.open('/bbs/bmtraining.php?mode=training-edit2&yyyymmdds=$yyyymmdds','trainingedit','width=400,height=400,statusbar=no,toolbar=no,resizable=yes')
</script>";
	}
	// process2
	if(1 == 2){
		//
	}else{
		$dbquery="update etc set msgstr='$today' where type='today' and userid='$member[user_id]'";
		$result2 = mysql_query($dbquery) or die("mysql_query error(etc table update):".mysql_error());
		if(mysql_affected_rows() == 0){
			$dbquery="insert into etc (type,userid,msgstr,msgint)
				VALUES ('today','$member[user_id]','$today',0)";
			$result3 = mysql_query($dbquery) or die("mysql_query error(training table insert):".mysql_error());
			if(mysql_affected_rows() == 0){
				errornback("training table에 추가할 수 없습니다.\n<br>$dbquery\n");
				die();
			}
		}
		// 지나간 날짜에 대한 type='today' 데이타 삭제 필요(지나간 거 저장 불필요)
	}
//echo "$dbquery ";
}
// end : 하루 한번씩 처리하는 일들. one time in a day
} // $member[level] <= 6
		} // 회원끝

		$a_member_join = "<Zeroboard";
		$a_member_modify = "<Zeroboard";
		$a_member_memo = "<Zeroboard";
		$member_memo_icon = "<Zeroboard";
		$memo_on_sound = "";
		$a_logout = "<Zeroboard";
		$a_login = "<Zeroboard";

	}
