<?php
/*******************************************************************************
 * Zeroboard 4.1 pl2 �ܺ� �α��� ����
 *
 * �� ������ �ܺηα������� ����ҽÿ� ����Ͻø� �˴ϴ�.
 *
 * ������� ������ �����ϴ�.
 *
 * �ܺηα����� ���Ͻô� ������ ���� ��ܿ� ������ ���� �Է��ϼ���
 *
 * <?
 *   $_zb_url = "http://������/���κ�����/";                 // ���� �� / �� ���ּ���
 *   $_zb_path = "/home/�������̵�/public_html/���κ�����/"; // ���� �� / �� ���ּ���
 *   include $_zb_path."outlogin.php";
 * ?>
 *
 *
 * �׷��� �ܺηα��� ���̳� �α��� ���¸� ǥ���ϰ� �������� ������ ���� �Է��ϼ���
 *
 * <?print_outlogin("��Ų�̸�","�׷��ȣ","��뷹��");?>
 *
 *
 * ������ "/home/���� ���̵�/public_html/���κ��� ���/" ��� ���� ���κ����� ���� ��θ� ��Ÿ���ϴ�.
 *
 * ������ $_zb_url �� $_zb_path �� �� ���� �ּž� �մϴ�.
 *
 * �����δ� ������ ������ ���� ���� �Ʒ��� �ֽ��ϴ�
 *
 * ���� ���� �ϸ� �α����� �Ǿ������� �α��� ������, �׷��� ���� ��쿡�� �α��� ���� ��Ÿ���ϴ�.
 *
 * �α��� ������ �α��� ���� �����ϽǶ����� ���κ�����/outlogin_skin/ �� �ִ� ������ �����Ͻø� �˴ϴ�.
 *
 * �α��� �Ǿ� �ִ� ���� : logged.html
 * �α��� �� : login.html
 *
 * ���� �� ������ ���� �Ͻø� �˴ϴ�.
 *
 * �׸��� ���� ���ϴ� html ���Ͽ��� ������ ���� ������ ���� �ϰ� ���������� $level ������ �����Ͻø� �˴ϴ�.
 *
 * ��� �Ͻø� 9������ ������ �ش� �������� ������ �����մϴ�.
 *
 * ���� ���� ������ ���÷��� outlogin_skin ���丮���� index.html ������ �������.
 *
 * �ܺηα��� ����� �ٲٽ÷��� outloing_skin ���丮 ���� README.TXT ������ �� �о� �ֽñ� �ٶ��ϴ�.
 *
 *******************************************************************************/

	global $member, $_head_php_excuted, $REQUEST_URI, $_zb_lib_included, $HTTP_SESSION_VARS, $total_member_connect, $total_guest_connect;
	global $a_member_join, $a_member_modify, $a_member_memo, $member_memo_icon, $memo_on_sound, $a_logout, $a_login, $id, $PHP_SELF, $_outlogin_include;

	if(eregi(":\/\/",$_zb_path)||eregi("\.\.",$_zb_path)) $_zb_path ="./";
	// outlogin.php ������ include �Ǿ������� üũ
	if(!$_outlogin_include) {
		$_outlogin_include = TRUE;
	} else {
		return FALSE;
	}

	// ó���� include �Ǿ����� �ʿ��� ������ include �ϴ� �κ�
	if(!$_head_php_excuted&&!$_zb_lib_included) {

		// ���κ��� ���丮 ���� üũ
		if(!file_exists($_zb_path."lib.php")) {
 			echo "���κ��� ���丮�� �ƴմϴ�";
			return;
		}

		// _head.php ����
		@include $_zb_path."_head.php";

	}

	function print_outlogin($skinname = "default", $group_no = 1, $level = "10") {
		global $member, $_head_php_excuted, $REQUEST_URI, $HTTP_SESSION_VARS, $total_member_connect, $total_guest_connect, $_zb_path, $_zb_url;
		global $a_member_join, $a_member_modify, $a_member_memo, $member_memo_icon, $memo_on_sound, $a_logout, $a_login, $id, $PHP_SELF, $_outlogin_include;
		global $keykind;	// yhkim

		if($level < $member[level]) {
?>
			<script>
				alert("������ ȸ���� ���� �����մϴ�");
				history.back();
			</script>
<?
			exit;
		}

		// ȸ�� ������ �ִ��� �������� üũ�ؼ� �ش� ��Ų ������ ����
		if (!$member[no]) {	// ��ȸ��

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

		} else {	// ȸ������

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

				echo "<script>if(confirm('������ �Խ��ϴ�. Ȯ���Ͻðڽ��ϱ�?')){window.open('".$_zb_url."member_memo.php','member_memo','width=450,height=500,status=no,toolbar=no,resizable=yes,scrollbars=yes')};</script>\n";	// yhkim insert �ű����� �˸�
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
exp.setTime( exp.getTime() + (1000 * 12*60*60) ); 12�ð�
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
		
	//���� ǥ��
	echo "<div align=center><a href='javascript:void(0)' onClick=\"var openwin = window.open('/bbs/zboard.php?id=music', 'musiclist', 'width=695,height=800,scrollbars=yes,resize=yes'); openwin.focus();return false;\"><img src=/image/collection/music.gif border=0></a></div>";
	
	//	echo "<script>alert('Ŭ��Ȱ��-�������翡 ���� �ֽñ� �ٶ��ϴ�.');</script>\n";
	}	// if 'run4joy'
	
	// ���� ǥ��
	$mmdd1 = date("m.d");
	$mmdd2 = date("m.d", mktime(0, 0, 0, date("m"), date("d")+14, date("Y")));
	$dbquery = "select name,birthsun,userid from member where birthsun >= '$mmdd1' and birthsun <= '$mmdd2' and (membertype='��ȸ��' or membertype='��ȸ��') order by birthsun, gumpuno";
	$result = mysql_query($dbquery) or die("mysql_query error(etc('today') table select: $dbquery)");
	echo "<div align=center>2�ְ� ȸ�� ����<br>";
	if(mysql_num_rows($result) == 0){
		echo "����\n";
	}else{
		echo "<img src=/image/cake.gif><img src=/image/rose.gif>";
	}

	$birthdaydisplayno = 3;	// ���� ǥ�� �ο���
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
	// ���� ǥ�� ��

	// 5�� ȸ�弱��
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
alert('5�� ȸ�� ���� ��ǥ�� ���� ��Ź �帳�ϴ�.(ȸ������-��������/��Ÿ-��5��ȸ��ܼ���)');
</script>";
		$dbquery="delete from etc where type='2008elect' and userid='$member[user_id]'";
		$result3 = mysql_query($dbquery) or die("mysql_query error(etc table delete):".mysql_error());
		$dbquery="insert into etc (type,userid,msgstr,msgint) VALUES ('2008elect','$member[user_id]','". date("Ymd") ."',0)";
		$result3 = mysql_query($dbquery) or die("mysql_query error(etc table insert):".mysql_error());
			if(mysql_affected_rows() == 0){
				errornback("etc table�� �߰��� �� �����ϴ�.\n<br>$dbquery\n");
				die();
			}
	}
}
*/

	// ��ũ��  ���� ���� 
/*
if(date("Ymd") <= "20061225"){
	$dbquery = "select userid from minipolla where pollno=9 and userid = '$member[user_id]'";
	$result = mysql_query($dbquery) or die("mysql_query error(etc('minipolla') table select: $dbquery)");
	if(mysql_num_rows($result) == 0){
			echo "
<script>
alert('���� ���翡 ���� �ٶ��ϴ�.');
newwin=window.open('/bbs/minipoll.php','match','width=300,height=400,statusbar=no,toolbar=no,resizable=yes,scrollbars=yes');newwin.focus();
</script>";
	}
}
*/
		
	// ���� �Է�
		$dbquery = "select birthdate,birthtype,birthsun from member where userid = '$member[user_id]'";
		$result = mysql_query($dbquery) or die("mysql_query error(etc('today') table select: $dbquery)");
		$row=mysql_fetch_array($result);
	
		if(mysql_num_rows($result) == 1 && (strlen(chop($row[2])) != 5 || $row[2] == "mm.dd")){
			echo "
<script>
alert('���� �Է� ��Ź �帳�ϴ�.');
newwin=window.open('/bbs/update.php?type=birth&mode=0','match','width=320,height=350,statusbar=no,toolbar=no,resizable=yes,scrollbars=auto');newwin.focus();
</script>";
		}
	// ���� �Է� ��

	// ������ �Է�
		$dbquery = "select bloodtype from member where userid = '$member[user_id]'";
		$result = mysql_query($dbquery) or die("mysql_query error(member table select: $dbquery)");
		$row=mysql_fetch_array($result);
		if(mysql_num_rows($result) == 1 && strlen(chop($row[0])) < 1){
			echo "
<script>
alert('������ �Է� ��Ź �帳�ϴ�.');
newwin=window.open('/bbs/update.php?type=blood&mode=0','match','width=320,height=350,statusbar=no,toolbar=no,resizable=yes,scrollbars=auto');newwin.focus();
</script>";
		}
	// ������ �Է� ��

	// ��ǥ �ȳ�(��ȸ����)
/*
if(date("Y.m.d") <= "2006.06.09" && ($PHP_SELF == "/bbs/zboard.php" || $PHP_SELF == "/bbs/bmnew.php")){
	$dbquery = "select polltime from poll where pollid='200606revise' and userid='$member[user_id]'";
	$result = mysql_query($dbquery) or die("mysql_query error(poll table select: $dbquery)");
	if(mysql_num_rows($result) == 0){
		$dbquery = "select name from member where userid='$member[user_id]' and membertype='��ȸ��'";
		$result = mysql_query($dbquery) or die("mysql_query error");
		if(mysql_num_rows($result) > 0){
			echo "<script>alert('ȸĢ���� ��ǥ�� �ֽʽÿ�.(������ �ؼ� �˼��մϴ�.)');location.href='/intro1_07.htm?url=".base64_encode("/bbs/200606revise.html")."';</script>\n";
		}
	}
}
*/

// 2006 ��ݱ� ���� �ǰ�
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
// 2006 ��ݱ� ���� �ǰ� ��

// �Ϸ� �ѹ��� ó���ϴ� �ϵ�. one time in a day

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
// load ���� ������ ó��
	// process1 : �Ʒ� ���
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
				errornback("training table�� �߰��� �� �����ϴ�.\n<br>$dbquery\n");
				die();
			}
		}
		// ������ ��¥�� ���� type='today' ����Ÿ ���� �ʿ�(������ �� ���� ���ʿ�)
	}
//echo "$dbquery ";
}
// end : �Ϸ� �ѹ��� ó���ϴ� �ϵ�. one time in a day
} // $member[level] <= 6
		} // ȸ����

		$a_member_join = "<Zeroboard";
		$a_member_modify = "<Zeroboard";
		$a_member_memo = "<Zeroboard";
		$member_memo_icon = "<Zeroboard";
		$memo_on_sound = "";
		$a_logout = "<Zeroboard";
		$a_login = "<Zeroboard";

	}
