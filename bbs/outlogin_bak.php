<?
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

	// �ܺηα��� ��� �Լ�
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
		if(!$member[no]) {	// ��ȸ��

			$f = fopen($_zb_path."script/outlogin_script.php",r);
			$_outlogin_script = fread($f, filesize($_zb_path."script/outlogin_script.php"));
			fclose($f);

			$f = fopen($_zb_path."outlogin_skin/$skinname/login.html",r);
			$_outlogin_data = fread($f, filesize($_zb_path."outlogin_skin/$skinname/login.html"));
			fclose($f);

			$login_img = $_zb_url."outlogin_skin/$skinname/images/i_login.gif";
			$join_img = $_zb_url."outlogin_skin/$skinname/images/i_join.gif";
			$help_img = $_zb_url."outlogin_skin/$skinname/images/i_help.gif";

			$_outlogin_data = str_replace("[action]", $_zb_url."login_check.php",$_outlogin_data);
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

	/*******************************************************
	 * �ֱٸ�� �����ֱ⸦ ���� �Լ� ����
	 ******************************************************/

	 // �ֱ� �� ��� (�Ϲ� �Խ��� ��)
// yhkim Y/m/d --> m/d
	 function print_bbs($skinname, $title, $id, $num=5, $textlen=30, $datetype="m/d") {
		global $_zb_path, $_zb_url, $connect, $t_board, $admin_table;

		if(!$skinname||!$id||!$title) return;

		$str = zReadFile($_zb_path."latest_skin/".$skinname."/main.html");
		if(!$str) {
			echo "�����Ͻ� $skinname �̶�� �ֱٸ�� ��Ų�� �������� �ʽ��ϴ�<br>";
			return;
		}

		$setup = mysql_fetch_array(mysql_query("select use_alllist from $admin_table where name='$id'"));
		if($setup[use_alllist]) $target = "zboard.php?id=".$id;
		else $target = "view.php?id=".$id;

		$result = mysql_query("select * from $t_board"."_$id where is_secret=0 order by no desc limit $num", $connect) or die(mysql_error());


		$tmpStr = explode("[loop]",$str);
		$header = $tmpStr[0];
		$tmpStr2 = explode("[/loop]",$tmpStr[1]);
		$loop = $tmpStr2[0];
		$footer = $tmpStr2[1];

		// �������� ������ ���鶧 ���
		if(eregi("\[notice\_",$header)) {
			$data=mysql_fetch_array($result);
			$memo = stripslashes($data[memo]);
			if($data[use_html]<2) $memo = nl2br($memo);
			else $memo = strip_tags($memo);
			$filename1 = $data[file_name1];
			$filename2 = $data[file_name2];
			if(eregi("\.gif|\.jpg",$filename1))$uploadimage1 = "<img src=".$_zb_url.$filename1." border=0><br>"; else $uploadimage1="";
			if(eregi("\.gif|\.jpg",$filename2))$uploadimage2 = "<img src=".$_zb_url.$filename1." border=0><br>"; else $uploadimage2="";
			$memo = autolink($uploadimage1.$uploadimage2.$memo);
			if($data[ismember]) {
				$imageBoxPattern = "/\[img\:(.+?)\.(jpg|gif)\,align\=([a-z]){0,}\,width\=([0-9]+)\,height\=([0-9]+)\,vspace\=([0-9]+)\,hspace\=([0-9]+)\,border\=([0-9]+)\]/i";
				$memo=preg_replace($imageBoxPattern,"<img src='".$_zb_url."icon/member_image_box/$data[ismember]/\\1.\\2' align='\\3' width='\\4' height='\\5' vspace='\\6' hspace='\\7' border='\\8'>", stripslashes($memo));
			}
			$subject = cut_str21(stripslashes($data[subject]),$textlen)."</font></b>";
			$date = date($datetype, $data[reg_date]);
			$header = str_replace("[notice_memo]",$memo,$header);
			$header = str_replace("[notice_subject]",$subject,$header);
			$header = str_replace("[notice_date]",$date,$header);
		}

		$main_data = "";
		while($data=mysql_fetch_array($result)) {
			$name = stripslashes($data[name]);
			$subject = cut_str21(stripslashes($data[subject]),$textlen)."</font></b>";
			$date = date($datetype, $data[reg_date]);
			if($data[total_comment]) $comment = "[".$data[total_comment]."]"; else $comment="";

			$main = $loop;
			$main = str_replace("[name]",$name,$main);
			$main = str_replace("[date]",$date,$main);
			$main = str_replace("[subject]","<a href='".$_zb_url.$target."&no=$data[no]'>".$subject."</a>",$main);
			$main = str_replace("[comment]",$comment,$main);
			$main_data .= "\n".$main;
		}
		$list = $header.$main_data.$footer;
		$list = str_replace("[title]","<a href='".$_zb_url."zboard.php?id=".$id."'>".$title."</a>",$list);
		$list = str_replace("[dir]",$_zb_url."latest_skin/".$skinname."/images/",$list);

		echo $list;
	 }

function cut_str21($msg,$cut_size) 
// �ѿ� 2:1 ���� ����, ���� ... ����
{ 
		$len = strlen($msg);
		if($len <= $cut_size || $cut_size <= 0)
			return $msg;
		if($cut_size < 4) return "...";
		for ($i=0;$i<($cut_size-4);$i++) {
			if (ord($msg[$i])<=127) {
				$pointtmp.= $msg[$i];
			} else {
				$pointtmp.=$msg[$i].$msg[++$i];
			}
		}
		if (ord($msg[$i])<=127) {
					$pointtmp.= $msg[$i];
				}
		return $pointtmp."...";
}

	 // �ֱ� �������� (�Ϲ� �Խ��� ��)
	 function print_survey($skinname, $title, $id, $textlen=30) {
		global $_zb_path, $_zb_url, $connect, $t_board, $admin_table, $HTTP_SESSION_VARS;

		if(!$skinname||!$id) return;

		$str = zReadFile($_zb_path."latest_skin/".$skinname."/main.html");
		if(!$str) {
			echo "�����Ͻ� $skinname �̶�� �ֱٸ�� ��Ų�� �������� �ʽ��ϴ�<br>";
			return;
		}

		$tmpResult = mysql_query("select use_alllist from $admin_table where name='$id'") or die(mysql_error());
		$setup = mysql_fetch_array($tmpResult);
		if($setup[use_alllist]) $target = "zboard.php?id=".$id;
		else $target = "view.php?id=".$id;

		$result = mysql_query("select * from $t_board"."_$id order by headnum limit 1", $connect) or die(mysql_error());
		$tmpData = mysql_fetch_array($result);
		$no = $tmpData[no];
		$headnum = $tmpData[headnum];
		$main_subject="<a href='".$_zb_url.$target."&no=$no'>".stripslashes($tmpData[subject])."</a>";
		if($tmpData[vote]) $main_vote = "[".$tmpData[vote]."]"; else $main_vote="";

		$result = mysql_query("select * from $t_board"."_$id where headnum='$headnum' and arrangenum > 0 order by arrangenum", $connect) or die(mysql_error());

		$tmpStr = explode("[loop]",$str);
		$header = $tmpStr[0];
		$tmpStr2 = explode("[/loop]",$tmpStr[1]);
		$loop = $tmpStr2[0];
		$footer = $tmpStr2[1];

		$main_data = "";
		while($data=mysql_fetch_array($result)) {
			$subject = cut_str(stripslashes($data[subject]),$textlen)."</font></b>";
			if($data[vote]) $vote = "[".$data[vote]."]"; else $vote="";
			$main = $loop;
			$main = str_replace("[subject]","<a href='".$_zb_url."apply_vote.php?id=$id&no=$no&sub_no=$data[no]'>".$subject."</a>",$main);
			$main = str_replace("[vote]",$vote,$main);
			$main_data .= "\n".$main;
		}
		$list = $header.$main_data.$footer;
		$list = str_replace("[title]","<a href='".$_zb_url."zboard.php?id=".$id."'>".$title."</a>",$list);
		$list = str_replace("[dir]",$_zb_url."latest_skin/".$skinname."/images/",$list);
		$list = str_replace("[main_subject]",$main_subject,$list);
		$list = str_replace("[main_vote]",$main_vote,$list);

		echo $list;
	 }

	 // ������ �̹��� �̾ƿ��� ��Ų
	 function print_gallery($skinname, $title, $id, $num=10, $leng=10, $xsize=80, $ysize=80, $xnum=10) {
		global $_zb_path, $_zb_url, $connect, $t_board, $admin_table, $HTTP_SESSION_VARS;

		if(!$skinname||!$id) return;

		$str = zReadFile($_zb_path."latest_skin/".$skinname."/main.html");
		if(!$str) {
			echo "�����Ͻ� $skinname �̶�� �ֱٸ�� ��Ų�� �������� �ʽ��ϴ�<br>";
			return;
		}

		$tmpResult = mysql_query("select use_alllist from $admin_table where name='$id'") or die(mysql_error());
		$setup = mysql_fetch_array($tmpResult);
		if($setup[use_alllist]) $target = "zboard.php?id=".$id;
		else $target = "view.php?id=".$id;

		$result = mysql_query("select * from $t_board"."_$id order by no desc limit $num", $connect) or die(mysql_error());

		$i = 0;
		$imgList = "<table hspace=0 vspace=0><tr><td>";	// yhkim
		while($data=mysql_fetch_array($result)) {

			if(eregi("\.gif|\.jpg",$data[file_name1])) $filename = $_zb_url.$data[file_name1];
			elseif(eregi("\.gif|\.jpg",$data[file_name2])) $filename = $_zb_url.$data[file_name2];
			else $filename="";

//yhkim yysize
//			$yysize = "height=$ysize ";
			$yysize = "";
			$subject = cut_str(stripslashes($data[subject]), $leng);	// yhkim �߰�

			if($filename) $imgList.="<td valign=bottom><a href='".$_zb_url.$target."&no=$data[no]'><img src='$filename' border=1 style=border-color:black width=$xsize ".$yysize."vspacing=1 hspacing=1 alt='$data[subject]'><br>$subject</a></td>";
			else $imgList.="<td valign=bottom><a href='".$_zb_url.$target."&no=$data[no]'><img src='[dir]t.gif' border=1 style=border-color:black width=$xsize ".$yysize."vspacing=1 hspacing=1 alt='$data[subject]'><br>$subject</a></td>";
			$i++;
			if($i>=$xnum) {
				$imgList.="<br>";
				$i=0;
			} else {
//				$imgList.="&nbsp;";
				$imgList.="";
			}
		}
		$imgList .= "</td></tr></table>";	// yhkim
		$str = str_replace("[title]","<a href='".$_zb_url."zboard.php?id=".$id."'>".$title."</a>",$str);
		$str = str_replace("[img]",$imgList,$str);
		$str = str_replace("[dir]",$_zb_url."latest_skin/".$skinname."/images/",$str);
		echo $str;
	 }

	 // ������ �̹��� �̾ƿ��� ��Ų
	 function print_hotnews($skinname, $title, $id, $num=1) {
		global $_zb_path, $_zb_url, $connect, $t_board, $admin_table, $HTTP_SESSION_VARS;
		$xnum=10;
		$ysize=136;
		
		if(!$skinname||!$id) return;

		$str = zReadFile($_zb_path."latest_skin/".$skinname."/main.html");
		if(!$str) {
			echo "�����Ͻ� $skinname �̶�� �ֱٸ�� ��Ų�� �������� �ʽ��ϴ�<br>";
			return;
		}

		$tmpResult = mysql_query("select use_alllist from $admin_table where name='$id'") or die(mysql_error());
		$setup = mysql_fetch_array($tmpResult);
		if($setup[use_alllist]) $target = "zboard.php?id=".$id;
		else $target = "view.php?id=".$id;

		$result = mysql_query("select * from $t_board"."_$id order by no desc limit $num", $connect) or die(mysql_error());

		$i = 0;
		$imgList = "<div style=\"width:300;height:222;overflow:hidden;\"><table hspace=0 vspace=0><tr><td>";	// yhkim
		while($data=mysql_fetch_array($result)) {

			if(eregi("\.gif|\.jpg",$data[file_name1])) $filename = $_zb_url.$data[file_name1];
			elseif(eregi("\.gif|\.jpg",$data[file_name2])) $filename = $_zb_url.$data[file_name2];
			else $filename="";

//yhkim yysize
//			$yysize = "height=$ysize ";
			$yysize = "";
			$subject = stripslashes($data[subject]);	// yhkim �߰�

			if($filename) $imgList.="<td valign=bottom><a href='".$_zb_url.$target."&no=$data[no]'><img src='$filename' border=1 style=border-color:black height=$ysize vspacing=1 hspacing=1 alt='$data[subject]'><br>$subject<br>$data[memo]</a></td>";
			else $imgList.="<td valign=bottom><a href='".$_zb_url.$target."&no=$data[no]'><img src='[dir]t.gif' border=1 style=border-color:black width=$xsize ".$yysize."vspacing=1 hspacing=1 alt='$data[subject]'><br>$subject<br>$data[memo]</a></td>";
			$i++;
			if($i>=$xnum) {
				$imgList.="<br>";
				$i=0;
			} else {
//				$imgList.="&nbsp;";
				$imgList.="";
			}
		}
		$imgList .= "</td></tr></table></div>";	// yhkim
		$str = str_replace("[title]","<a href='".$_zb_url."zboard.php?id=".$id."'>".$title."</a>",$str);
		$str = str_replace("[img]",$imgList,$str);
		$str = str_replace("[dir]",$_zb_url."latest_skin/".$skinname."/images/",$str);
		echo $str;
	 }

	 function print_bbsnew() {
		global $member, $connect, $t_board, $t_comment, $admin_table;

		if(!$member[no])	// ��ȸ��
			return;
		if( $member[level]>=7) { // ����ȸ��,�޸�ȸ��
			$closedboard="";
		}else{			// ��,��ȸ��
			$closedboard="'memboard', ";
		}
		$member_id = $member[user_id];
		$table_name_result=mysql_query("select name, use_alllist, title from $admin_table where name in (".$closedboard."'pubboard', 'photo', 'hotnews') order by title",$connect) or error(mysql_error()."111");

		$newdate_result = mysql_query("select msgint from etc where type='new' and userid = '$member_id'",$connect) or error(mysql_error()."222");
		$cur_time = time();
		if(mysql_num_rows($newdate_result)){
			$newdate = mysql_fetch_array($newdate_result);
			$check_date = $newdate[0];
			if($check_date < ($cur_time - 1209600)) // 2 weeks
				$check_date = $cur_time - 1209600;
		}else{
			$check_date = $cur_time - 1209600;
		}
		$itembbs = 0;
		$itemanswer = 0;
		while($table_data=mysql_fetch_array($table_name_result))
		{
			$table_name=$table_data[name];
			$result=mysql_query("select count(*) from $t_board"."_$table_name as t1 where t1.reg_date >= $check_date order by t1.no desc", $connect) or error(mysql_error()."555");
			$data=mysql_fetch_array($result);
			$itembbs += $data[0];
			
			$result2=mysql_query("select count(*) from $t_comment"."_$table_name where reg_date >= $check_date order by parent desc, no desc", $connect) or error(mysql_error()."666");
			$no = 0;
			$data=mysql_fetch_array($result2);
			$itemanswer += $data[0];
		}
		echo "<br>";
		if($itembbs != 0 || $itemanswer != 0){
			echo "<blink>";
		}
		if($itembbs > 0){
			echo "<font color='red'>";
		}else{
			echo "<font color='blue'>";
		}
		echo "�ű� �Խù��� : $itembbs</font>, ";
		if($itemanswer > 0){
			echo "<font color='red'>";
		}else{
			echo "<font color='blue'>";
		}
		echo "�ű� ��ۼ� : $itemanswer</font>";
		if($itembbs != 0 || $itemanswer != 0){
			echo "</blink>";
		}
	}	// print_bbsnew

	 function print_chuka($skinname, $title, $num=10, $textlen) {
		global $_zb_path, $_zb_url, $connect, $t_board, $admin_table;

		if(!$skinname||!$title) return;

		$str = zReadFile($_zb_path."latest_skin/".$skinname."/chuka.html");
		if(!$str) {
			echo "�����Ͻ� $skinname �̶�� �ֱٸ�� ��Ų�� �������� �ʽ��ϴ�<br>";
			return;
		}
		$today = date("Y")."-".date("m")."-".date("d");
		$result = mysql_query("select *, current_date-in_date days from chuka where end_date is null or end_date >= '$today' order by in_date desc, no limit $num", $connect) or die(mysql_error());


		$tmpStr = explode("[loop]",$str);
		$header = $tmpStr[0];
		$header = str_replace("[title]",$title,$header);
		$tmpStr2 = explode("[/loop]",$tmpStr[1]);
		$loop = $tmpStr2[0];
		$footer = $tmpStr2[1];

		$main_data = "";
		while($data=mysql_fetch_array($result)) {
			$name = stripslashes($data[name]);
			if($name != "�д縶����Ŭ��")
				$name .= "��";
			if($data[days] <= 8)
				$name = "<font style=\"color:red; \">".$name;
			$memo = cut_str21(stripslashes($data[memo]),$textlen);
			if($data[days] <= 8)
				$memo = $memo."</font>";

			$main = $loop;
			$main = str_replace("[name]","��".$name,$main);
			$main = str_replace("[memo]",$memo,$main);
			$main_data .= "\n".$main;
		}
		$list = $header.$main_data.$footer.$listtmp;

		echo $list;
	 }

	 function print_marathon_news($title, $no=5, $textlen=30) {

		if(!$title) return;

//if($member[user_id]=="run4joy"){
		$URL = "http://news.google.co.kr/news?hl=ko&newwindow=1&q=%EB%A7%88%EB%9D%BC%ED%86%A4&lr=&ie=UTF-8&oe=EUC-KR&um=1&sa=N&tab=wn";
		echo "<a href=\"$URL\" target=mnewscont><font style=font-family:tahoma; color=black>$title</font></a><br>";
		$outStr = array();
		$fcont = file_get_contents($URL);
		$no = loopStringExtract($fcont, $outStr, "�� �˻���� ��� ����", "<td valign=top class=j", "<a ", "</a>", "target=nw", "target=mnewscont", $no);
		echo "<font style='font-size:10pt'>";
		for($n=0; $no > $n; $n++){
			$str = $outStr[$n];
			if($textlen != 0){
				$pt = strpos($str, ">");
				if($pt === FALSE)
					$str = cut_str21($str, $textlen);
				else{
					$pt2 = strrpos($str, "<");
//echo cut_str(strip_tags(substr($str,$pt+1,$pt2-$pt-1)), 10)."textlen=$textlen";
					$str2 = substr($str, 0, $pt+1).cut_str21(strip_tags(substr($str,$pt+1,$pt2-$pt-1)),$textlen).substr($str, $pt2);
					$str = $str2;
				}
			}
			echo $str."<br>\n";
//			$tmp = stripslashes($outStr[$n]);
//			echo cut_str($tmp, 8);
//			echo cut_str($tmp, 30)."<br>\n";
//			$subject = cut_str(stripslashes($data[subject]),$textlen)."</font></b>";
		}
		echo "</font>";
//}
	}

	//DivVisible, DivInVisible
	//bmnew.php�� ������ DivVisible, DivInVisible ���				
	function func_div(){
		echo "
<script language='JavaScript'>
<!--
function DivVisible(LayerName, LayerHead, DivNo){
	var i,p,v,obj;
// Div menu item = 10
	if(LayerName == '')
		return false;
	for (i=0; i < DivNo; i++){
		p = LayerHead + i;
		obj=document.all[p];
		if (p == LayerName) {
			v='show';
		}else{
			v='hide';
		}
		if (obj.style) {
			obj=obj.style;
			v=(v=='show')?'visible':(v=='hide')?'hidden':v;
		}
		obj.visibility=v;
	}
	return true;
}
function DivInVisible(LayerHead, DivNo){
	var i,p,v,obj;
	for (i=0; i < DivNo; i++){
		p = LayerHead + i;
		obj=document.all[p];
		if (obj.style) {
			obj=obj.style;
		}
		obj.visibility='hidden';
	}
	return true;
}
-->
</script>\n";
	}

// bmfunction.php�� �ִ� function��	
function yoilname($yoilno){
        if($yoilno == 0) $yoil = "��";
        else if($yoilno == 1) $yoil = "��";
        else if($yoilno == 2) $yoil = "ȭ";
        else if($yoilno == 3) $yoil = "��";
        else if($yoilno == 4) $yoil = "��";
        else if($yoilno == 5) $yoil = "��";
        else if($yoilno == 6) $yoil = "��";

        return $yoil;
}
function dayofweek($year,$month,$day) {

 /* Check date for validity */
        if (!checkdate($month,$day,$year))
                return -1;

        $a=(int)((14-$month) / 12);
        $y=$year-$a;
        $m=$month + (12*$a) - 2;

        $retval=($day + $y + (int)($y/4) - (int)($y/100) + (int)($y/400) +
(int)((31*$m)/12)) % 7;
        return $retval;
}
// ��-bmfunction.php�� �ִ� function��

	// yhkim Ŭ�� �Ʒð�ȹ : ��ȸ�����׵� ����
	function print_trainingplan() {
		global $member;
		// ȸ�� ������ �ִ��� �������� üũ

//		func_div();
/*
		if(!$member[no]) {	// ��ȸ��
			return;
		}
*/
		// ȸ��
		// yhkim ��ȸ �����ڵ��� Ȩ�������� ǥ��
		$today = date("Y")."/".date("m")."/".date("d");
		$dbquery = "select * from clubtraining where tday>=curdate() and tday<=date_add(curdate(), interval 7 day) order by tday";
		$result = mysql_query($dbquery) or die("mysql_query error");

		$trainingplans = "<table border=1 bgcolor='#08C864'>";
		for($i=0; $row=mysql_fetch_array($result); $i++){
//echo $row[tday];
	        $ymd=explode("-", $row[tday]);
	        $yoilno = dayofweek($ymd[0],$ymd[1],$ymd[2]);   // year,month,day
    	    $yoil = yoilname($yoilno);
    	    
			$trainingplans .= "<tr><td>$ymd[1].$ymd[2]($yoil):</td><td>$row[memo]</td></tr>";
		}
		$trainingplans .= "</table>";
		echo "<table width='100%'><tr><td align=center>\n";
		echo "<a href='' onMouseOver=\"DivVisible('TP0','TP', 1)\" onMouseOut=\"DivInVisible('TP', 1)\" onClick=\"return false;\"><font color=blue><B>&lt;�д縶����Ŭ�� �Ʒð�ȹ&gt;</B></font></a><br>\n";
		if($i == 0){
			$trainingplans = "�Է� ����";
		}
		echo "<div id='TP0' style='position:absolute; left:8px; top=200px; z-index:1; visibility: hidden'>$trainingplans</div>\n";
		echo "</td></tr></table>\n";
	}

	// yhkim ��ȸ������ ��� �Լ�
	function print_race() {
		global $member;
		// ȸ�� ������ �ִ��� �������� üũ

		func_div();

		if(!$member[no]) {	// ��ȸ��
			return;
		}

		// ȸ��
		// yhkim ��ȸ �����ڵ��� Ȩ�������� ǥ��
		$today = date("Y")."/".date("m")."/".date("d");
//		$dbquery = "select raceid,nickname,raceday from race where replace(raceday,'/','')>=curdate()+0 and replace(raceday,'/','')<=curdate()+7";
//		$dbquery = "select raceid,nickname,raceday from race where raceday>='$today' order by raceday";
//		$dbquery = "select raceid,nickname,raceday,homehref from race where replace(raceday,'/','')>=curdate()-7 order by raceday";
		$dbquery = "SELECT raceid,nickname,raceday,homehref FROM race WHERE raceday>=REPLACE(DATE_SUB(CURDATE(), INTERVAL 7 DAY),'-','/') ORDER BY raceday";
		$result = mysql_query($dbquery) or die("mysql_query error");

		if(($raceno = mysql_num_rows($result)) == 0){
			return;
		}
		$divstr = "";
		for($i=$nozero=0; $row=mysql_fetch_array($result); $i++){
			if($i == 0){
				echo "<p align=center><font face='����' size=2><B>&lt;��ȸ ���� ��Ȳ&gt;</B><br>";
			}

			$dbquery = "select member.name,record.userid,record.item,record.record,record.rank from member, record where member.userid=record.userid and record.raceid=$row[0] order by record.item, member.name";
			$result2 = mysql_query($dbquery) or die("mysql_query error");
			if(($resultrows = mysql_num_rows($result2)) == 0){
				continue;
			}
			$raceattender = "";
			if($resultrows > 30){
				$raceattender .= "<span style='font-size:8pt'>";
			}
			$namelast = "";
			$recordexist = 1;
			for($j=0; $row2 = mysql_fetch_array($result2); $j++){
				$name = $row2[0];
				$record = $row2[3];
				if($record == ""){
					$raceattender .= $name." ".$row2[2]." ";
					$recordexist=0;
				}else{
					while(substr($record,0,1)=="0" || substr($record,0,1)==":"){	// ��� �տ� �ִ� 0�̳� : ����
						$record = substr($record, 1);
					}
//					if($recordexist==0) $raceattender .=  "<br>\n";
					if($resultrows <= 30) {
						$raceattender .=  "$name $row2[2] $record ";
					}else{
						$raceattender .=  "$name $record ";
					}
					if($row2[4] != "" && $resultrows <= 30) {
						if(is_numeric($row2[4]) == TRUE)
							$raceattender .= "$row2[4]��";
						else
							$raceattender .= "$row2[4]";
					}
					$recordexist=1;
				}
				if($resultrows > 30){
					if(($j % 2) == 1) 
						$raceattender .= "<br>\n";
				}else{
					$raceattender .= "<br><!-- a -->\n";
				}
				if($name == $namelast)		// ���� ��ȸ�� ������ ������ �ο��� ����ó��
					$j--;
				$namelast = $name;
			}
			if($resultrows > 30){
				echo "</font>\n";
			}
			$racenickname = ltrim(rtrim(substr($row[1], 2)));
			$raceday = substr($row[2], 5);
			if(chop($row[3])=="")
				$onclickstring = "onClick=\"return false\"";
			else
				$onclickstring = "";
			if(strlen($racenickname) >= 12)
				$colonstr = ":";
			else
				$colonstr = " : ";
				
			echo "<a href='$row[3]' target=race onMouseOver=\"DivVisible('Layer$nozero','Layer', $raceno)\" onMouseOut=\"DivInVisible('Layer', $raceno)\" $onclickstring><font color=blue>$racenickname($raceday)$colonstr$j ��</font></a><br>\n";
			$divstr .= "<div id='Layer$nozero' style='position:absolute; left:8px; top=".(460+18*$nozero)."px; z-index:1; visibility: hidden'><table width=176><tr><td bgcolor='#E0FFE0'><font color=red>�����ڴ� ȸ������ ��Ͽ��!</font></td></tr><tr><td bgcolor='#08C864'>$raceattender</td></tr></table></div>\n";
			$nozero++;
		}
		if($i > 0){
			echo "$divstr</font><br>";
		}
	}

	// yhkim �ֱ� 4�� ������� ���� ��Ȳ ���
	function print_jeongmo() {
		global $member;
		// ȸ�� ������ �ִ��� �������� üũ
		if(!$member[no]) {	// ��ȸ��
			return;
		}

// ȸ��
		// yhkim ��ȸ �����ڵ��� Ȩ�������� ǥ��
		$today = date("Y")."/".date("m")."/".date("d");
		$dbquery = "select yyyymmdd from message where type='training' order by yyyymmdd desc limit 4";
		$result = mysql_query($dbquery) or die("mysql_query error");

//		if($member[user_id] != 'run4joy')
//			return;
		if(($raceno = mysql_num_rows($result)) == 0){
			return;
		}
		$divstr = "";
		echo "<p align=center><font face='����' size=2><B>&lt;�ֱ� ���� ���� ��Ȳ&gt;</B></font><br><table width=90% border=1><tr align=center>";
		for($i=0; $row=mysql_fetch_array($result); $i++){
			echo "<td>".substr($row[0],5)."<br>";
			$dbquery = "select training.onoff from training, member where training.userid=member.userid and training.yyyymmdd='$row[0]' and member.userid='$member[user_id]'";
			$result2 = mysql_query($dbquery) or die("mysql_query error");
			if(mysql_num_rows($result2) == 0){
				echo "<font color=red size=3>X</font>";
				continue;
			}
			$row2=mysql_fetch_array($result2);
			if($row2[0] == "Y") /* ��*/
			{
				echo "<font style=\"font-family:WingDings; font-size:20pt; color:green;\">J</font>";
			}else{
				if($member[user_id] == "run4joy"){
					$url = "/bbs/bmtraining.php?mode=training-edit2&yyyymmdds=".$row[0];
//echo "url=".urlencode($url);
					echo "<a href='/intro1_07.htm?url=".base64_encode($url)."'><font style=\"font-family:WingDings; font-size:20pt; color:red;\">L</font></a>";
				}else
					echo "<font style=\"font-family:WingDings; font-size:20pt; color:red;\">L</font>";
			}
		}
		if($i > 0){
			echo "</table><br>";
		}
	}

	 function print_rundailji($title, $no=5, $textlen=30) {
		global $_zb_path, $_zb_url, $connect, $t_board, $admin_table;

		if(!$title) return;

		$URL = "http://www.rundiary.co.kr/clubdiary/index.asp?menu=400&clubid=380";
		echo "<a href=\"$URL\" target=mnews><font style=\"font-family:tahoma; font-color:black; font-size:12pt\">$title</font></a><br>";
		$outStr = array();
		error_reporting(E_ERROR);
		$fcont = file_get_contents($URL);
		if($fcont == FALSE){
			echo "*** �����̾ Ȩ������ �̻� ***<br>\n";
			return;
		}
		error_reporting(E_ALL ^ E_NOTICE);
/*
	<tr>
	<!-- td align="center"  bgcolor="#FBFDFD">
	
	</td -->
	<td colspan=2 align="center" bgcolor="#FBFDFD">
	
		<a href="/clubdiary/index.asp?menu=501&username=�д罴�۸�">�д罴�۸�</a>
	<img src='/image/sm19.gif' border=0 title='�Ϲ�ȸ��, �� ����Ÿ� 1990km'>
	</td>
	<td align="center"  bgcolor="#FBFDFD">10-13</td>
	<td bgcolor="#FBFDFD"><a href="/clubdiary/index.asp?menu=401&rid=694599&pmenu=400&sort=&mc=&subm=&page=1&startpage=1&selmonth=10&selyear=2006&clubid=380&cname=&subcode=&pid=&nprog="><font color="#000000">
		��ħ�
		<sup>...<font color=GRAY>���</font>
		</sup></a> <font style='font-size:8pt' color=#CC0000>(2)</font>	
</td>
	<td align="center"  bgcolor="#FBFDFD">10-13</td>
	<td align="center"  bgcolor="#FBFDFD">32</td>
	<td align="center"  bgcolor="#FBFDFD">146</td>
<!--		<td align="center"  bgcolor="#FBFDFD">51</td>
<td align="center"  bgcolor="#FBFDFD">2</td> 

	<td align="center"  bgcolor="#FBFDFD">
include virtual="/codename.asp"
	</td>
	
-->	
	</tr>
*/
		$no = loopStringExtract($fcont, $outStr, ">min<", "<td colspan=2 align=\"center\" bgcolor=\"#FBFDFD\">", "<", "</tr>", "", "target=runda", $no);
		echo "<font style='font-size:10pt'>";
		for($n=0; $no > $n; $n++){
			$str = $outStr[$n];
//echo "<!-- ***".$str."*** -->";
			if($textlen != 0){
				// �̸�
				$pt1 = strpos($str, ">") + 1;
				$pt1 = strpos($str, ">", $pt1) + 1;
				$pt2 = strpos($str, "<", $pt1);
				$nickname = substr($str, $pt1, $pt2-$pt1);

				// ����
				$pt1 = strpos($str, "<td", $pt2);
				$pt1 = strpos($str, ">", $pt1) + 1;
				$pt2 = strpos($str, "<", $pt1);
				$trainingday = substr($str, $pt1, $pt2-$pt1);

				// ��ũ
				$pt1 = strpos($str, "<td", $pt2);
				$pt1 = strpos($str, "<a", $pt1);
				$pt2 = strpos($str, ">", $pt1) + 1;
				$anchor = substr($str, $pt1, $pt2-$pt1);// no host
				$pt = strpos($anchor, "/");
				$anchor = substr($anchor, 0, $pt)."http://www.rundiary.co.kr".substr($anchor, $pt);
				$anchor = str_replace(">", " target=runda onclick='runda.window.document.focus();return false;'>", $anchor);

				// ����
				$pt1 = $pt2;	// after <a ..>
				$pt1 = strpos($str, ">", $pt1) + 1;
				$pt2 = strpos($str, "<sup>", $pt1);
				$subject = strip_tags(substr($str, $pt1, $pt2-$pt1));

				// ��ۼ�
				$pt1 = strpos($str, "<font style='font-size:8pt' color=#CC0000>(", $pt2);
				if($pt1 > 0){
					$pt1 = strpos($str, "(", $pt1) + 1;
					$pt2 = strpos($str, ")</font>", $pt1);
					$tail = substr($str, $pt1, $pt2-$pt1);
				}else{
					$tail = "0";
				}
				if($tail == "0")
					$str = $anchor.cut_str21($nickname." ".$trainingday." ".trim($subject),$textlen)."</a>";
				else
					$str = $anchor.cut_str21($nickname." ".$trainingday." ".trim($subject),$textlen-2)."<small>($tail)</small></a>";

			}
			echo "��".$str."<br>\n";
		}
		echo "</font>";
	}
	
		// bmnew.php ���Ͽ����� ���
		function loopStringExtract($inCont, &$outStr, $searchPoint, $loopStart, $strStart, $strStop, $targetIn = "", $targetOut = "", $count = 10){
			if(($p = strpos($inCont, $searchPoint)) === FALSE){
 echo "<script>alert('no match');</script>";
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
					if($targetOut == "")
						$outStr[$no] = $str;
					else{
						$pt = strpos($str, ">");
						$outStr[$no] = substr($str, 0, $pt)." ".$targetOut.substr($str, $pt);
					}
				else{
					$pt = strpos($str, $targetIn);
					if($pt === FALSE)
						$outStr[$no] = $str;
					else{
						$outStr[$no] = str_replace($targetIn, $targetOut, $str);
					}
				}
 echo "<script>alert($outStr[$no]);</script>";
			}
			return $no;
		}

	 function print_memberchange() {
		global $_zb_path, $_zb_url, $connect, $t_board, $admin_table;
		echo "<font style='font:bold; font-size:12pt;'>*** ȸ�� ���� ���� ***</font>\n";
		$dbquery = "select name,indate,userid";
		$dbquery .= " from member where (to_days(now())-to_days(indate))<7 and membertype = '����ȸ��'";
		$result = mysql_query($dbquery) or die("mysql_query error('print_memberchange')");
		$divno = mysql_num_rows($result);
		
		$dbquery = "select name,left(indate,10) as idt,userid,membertype";
		$dbquery .= ", IF( membertype='��ȸ��', 1, IF( membertype='��ȸ��', 2, IF( membertype='����ȸ��', 3, IF( membertype='�޸�ȸ��', 4, IF( membertype='OBȸ��', 5, IF( membertype='Ż��', 6, 7)))))) as typeorder";
		$dbquery .= ", to_days(now())-to_days(indate) as days";
		$dbquery .= ", juminno, org, postaddr, etc";
		$dbquery .= " from member where (to_days(now())-to_days(indate))<=31 order by typeorder, idt desc, name";

		$result = mysql_query($dbquery) or die("mysql_query error");

		$memtype = array(0, 0, 0, 0, 0, 0, 0);
		$memtypename = array("", "��ȸ��", "��ȸ��", "����ȸ��", "�޸�ȸ��", "OBȸ��", "Ż��", "��Ÿ");
		echo "<font style='font-size:10pt;'>\n";
		$nozero = 0;
		$divstr = "";
		while($row=mysql_fetch_array($result)){
			if($memtype[$row[4]] == 0){
				$memtype[$row[4]] = 1;
				if($row[3]!="Ż��")
					echo "\n<br>".$memtypename[$row[4]]." : ";
			}
			$inyymd = split(";", $row[1]);
			if($row[3]=="Ż��")
				continue;
			if($row[3]=="�޸�ȸ��" || $row[3]=="OBȸ��" || $row[3]=="Ż��" || $row[3]=="��Ÿ")
				$newname = $row[0];
			else
				$newname = $row[0]."(".substr($inyymd[0],5,5).")";
echo "<!-- $row[5] -->";
			if($row[5] >= 7) // 1 week
				echo "$newname ";
			else{
			  if($row[3]!="����ȸ��"){
				echo "<font style=\"font-weight:bold;font-color:blue;\">$newname</font>\n";
		  	  }else{
				echo "<a href='' onMouseOver=\"DivVisible('New$nozero','New', $divno)\" onMouseOut=\"DivInVisible('New', $divno)\" onClick=\"return false\"><font style=\"font-weight:bold;font-color:blue;\">$newname</font></a> \n";
				$newmemberinfo = "**** $row[0]�� �Ұ� ****";
				if($row[6] && substr($row[6],0,6) != "xxxxxx"){
					// bmmeminfo.php
					$birthdate = "19";
					$birthdate .= substr($row[6], 0, 2);
					$birthdate .= ".";
					$birthdate .= substr($row[6], 2, 2);
					$birthdate .= ".";
					$birthdate .= substr($row[6], 4, 2);
					$newmemberinfo .= "<br>������� : $birthdate\n";
				}
				if($row[7] > " ") $newmemberinfo .= "<br>����� : $row[7]\n";
				if($row[8] > " "){
					// member/prog/mempub1.php���� copy��
					$addr=$row[8];
					if(($pos = strstr($addr, "�� ")) != false){
						$addr=substr($addr,0,strlen($addr)-strlen($pos)+2);
					}else if(($pos = strstr($addr, "�� ")) != false){
						$addr=substr($addr,0,strlen($addr)-strlen($pos)+2);
					}else if(($pos = strstr($addr, "���� ")) != false){
						$addr=substr($addr,0,strlen($addr)-strlen($pos)+4);
					}else if(($pos = strstr($addr, "���� ")) != false){
						$addr=substr($addr,0,strlen($addr)-strlen($pos)+4);
					}else if(($pos = strstr($addr, "���� ")) != false){
						$addr=substr($addr,0,strlen($addr)-strlen($pos)+4);
					}else if(($pos = strstr($addr, "����Ʈ ")) != false){
						$addr=substr($addr,0,strlen($addr)-strlen($pos)+6);
					}else if(($pos = strstr($addr, "APT ")) != false){
						$addr=substr($addr,0,strlen($addr)-strlen($pos)+3);
					}else if(($pos = strrpos($addr, " ")) != false){
						$addr=substr($addr,0,$pos);
					}else{
						$addr=substr($addr, 0, strlen($addr)/2);
					}
					$newmemberinfo .= "<br>�ּ� : $addr\n";
				}
				if($row[9] > " ")
					$newmemberinfo .= "<br>��Ÿ : $row[9]\n";
					
				$dbquery = "select picture, open_picture from zetyx_member_table where user_id = '$row[2]'";
				$result2 = mysql_query($dbquery) or die("mysql_query error('print_memberchange')");
				$row2=mysql_fetch_array($result2);
				if($row2[1] == '1' && $row2[0])
					$newmemberinfo .= "<br><img src='/bbs/$row2[0]'>";
					
				$divstr .= "<div id='New$nozero' style='position:absolute; left:-300px; z-index:1; visibility: hidden'>\n<table width=350><tr><td bgcolor='#08C864'>$newmemberinfo</td></tr></table>\n</div>\n";
				$nozero++;
		  	  }

			}
		}
		if($nozero > 0)	echo "\n".$divstr;
		echo "</font>\n";
		mysql_free_result($result);
	}
?>
