<?
// ���̺귯�� �Լ� ���� ��ũ���
	include "lib.php";

	if(!eregi($HTTP_HOST,$HTTP_REFERER)) Error("���������� �ۼ��Ͽ� �ֽñ� �ٶ��ϴ�.");
	if(!eregi("member_join.php",$HTTP_REFERER)) Error("���������� �ۼ��Ͽ� �ֽñ� �ٶ��ϴ�","");
	if(getenv("REQUEST_METHOD") == 'GET' ) Error("���������� ���� ���ñ� �ٶ��ϴ�","");

// DB ����
	if(!$connect) $connect=dbConn();

// ��� ���� ���ؿ���;;; ����� ������
	$member=member_info();
	if($mode=="admin"&&($member[is_admin]==1||($member[is_admin]==2&&$member[group_no]==$group_no))) $mode = "admin";
	else $mode = "";

	if($member[no]&&!$mode) Error("�̹� ������ �Ǿ� �ֽ��ϴ�.","window.close");


// ���� �Խ��� ���� �о� ����
	if($id) {
		$setup=get_table_attrib($id);

		// �������� ���� �Խ����϶� ���� ǥ��
		if(!$setup[name]) Error("�������� ���� �Խ����Դϴ�.<br><br>�Խ����� ������ ����Ͻʽÿ�");

		// ���� �Խ����� �׷��� ���� �о� ����
		$group_data=group_info($setup[group_no]);
		if(!$group_data[use_join]&&!$mode) Error("���� ������ �׷��� �߰� ȸ���� �������� �ʽ��ϴ�");

	} else {

		if(!$group_no) Error("ȸ���׷��� �����ּž� �մϴ�");
		$group_data=mysql_fetch_array(mysql_query("select * from $group_table where no='$group_no'"));
		if(!$group_data[no]) Error("������ �׷��� �������� �ʽ��ϴ�");
		if(!$group_data[use_join]&&!$mode) Error("���� ������ �׷��� �߰� ȸ���� �������� �ʽ��ϴ�");
	}


// ���ڿ������� �˻�
	$user_id = str_replace("��","",$user_id);
	$name = str_replace("��","",$name);

	$user_id=trim($user_id);
	if(isBlank($user_id)) Error("ID�� �Է��ϼž� �մϴ�","");

	$check=mysql_fetch_array(mysql_query("select count(*) from $member_table where user_id='$user_id'",$connect));
	if($check[0]>0) Error("�̹� ��ϵǾ� �ִ� ID�Դϴ�","");

	unset($check);
	$check=mysql_fetch_array(mysql_query("select count(*) from $member_table where email='$email'",$connect));
	if($check[0]>0) Error("�̹� ��ϵǾ� �ִ� E-Mail�Դϴ�","");

	if(isBlank($password)) Error("��й�ȣ�� �Է��ϼž� �մϴ�","");

	if(isBlank($password1)) Error("��й�ȣ Ȯ���� �Է��ϼž� �մϴ�","");

	if($password!=$password1) Error("��й�ȣ�� ��й�ȣ Ȯ���� ��ġ���� �ʽ��ϴ�","");

	if(isBlank($name)) Error("�̸��� �Է��ϼž� �մϴ�","");
	if(eregi("<",$name)||eregi(">",$name)) Error("�̸��� ����, �ѱ�, ���ڵ����� �Է��Ͽ� �ֽʽÿ�");

	$name=addslashes($name);
	$email=addslashes($email);
	if($_zbDefaultSetup[check_email]=="true"&&!mail_mx_check($email)) Error("�Է��Ͻ� $email �� �������� �ʴ� �����ּ��Դϴ�.<br>�ٽ� �ѹ� Ȯ���Ͽ� �ֽñ� �ٶ��ϴ�.");
	
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
		if(!is_uploaded_file($picture)) Error("�������� ������� ���ε� ���ּ���");
		if(!eregi(".gif",$picture_name)&&!eregi(".jpg",$picture_name)) Error("������ gif �Ǵ� jpg ������ �÷��ּ���");
		$size=GetImageSize($picture);
		if($size[0]>200||$size[1]>200) Error("������ ũ��� 200*200 ���Ͽ��� �մϴ�");
		$kind=array("","gif","jpg");
		$n=$size[2];
		$path="icon/member_".time().".".$kind[$n];
		if(!@move_uploaded_file($picture,$path)) Error("���� ���ε尡 ����� ���� �ʾҽ��ϴ�");
		$picture_name=$path;
	}


	mysql_query("insert into $member_table (level,group_no,user_id,password,name,email,homepage,icq,aol,msn,jumin,comment,job,hobby,home_address,home_tel,office_address,office_tel,handphone,mailing,birth,reg_date,openinfo,open_email,open_homepage,open_icq,open_msn,open_comment,open_job,open_hobby,open_home_address,open_home_tel,open_office_address,open_office_tel,open_handphone,open_birth,open_picture,picture,open_aol) values ('$group_data[join_level]','$group_data[no]','$user_id',password('$password'),'$name','$email','$homepage','$icq','$aol','$msn',password('$jumin'),'$comment','$job','$hobby','$home_address','$home_tel','$office_address','$office_tel','$handphone','$mailing','$birth','$reg_date','$openinfo','$open_email','$open_homepage','$open_icq','$open_msn','$open_comment','$open_job','$open_hobby','$open_home_address','$open_home_tel','$open_office_address','$open_office_tel','$open_handphone','$open_birth','$open_picture','$picture_name','$open_aol')") or Error("ȸ�� ����Ÿ �Է½� ������ �߻��߽��ϴ�<br>".mysql_error());

// yhkim start
	if(substr($junim,7,1)=="2")
		$sex="F";
	else
		$sex="M";
	$nickname = date("Y/m/d");
	$indate = $nickname.";��������������;ȸ������";
	$juminno = jmchange(1, substr($jumin,0,6)."-".substr($jumin,6,7));
	mysql_query("insert into member (userid,passwd,name,email,orghref,
juminno,etc,sex,org,postaddr,telhome,teloffice,telhand,
membertype,disporder,nickname,indate) values
('$user_id','$password','$name','$email','$homepage',
'$juminno','$comment','$sex','$job','$home_address','$home_tel','$office_tel','$handphone',
'����ȸ��','99','$nickname','$indate')") or (error("ȸ�� ����Ÿ �Է½�(member) ������ �߻��߽��ϴ�<br>".mysql_error()) + mysql_query("delete from $member_table where user_id='$user_id'"));

	$result = mysql_query("select $member_table.no from $member_table where $member_table.name='�ѹ���'");
	$data=mysql_fetch_array($result);
	$chongmuno=$data[0];

	$result = mysql_query("select $member_table.no from $member_table, member where $member_table.user_id=member.userid and (member.grade like 'ȸ��' or member.grade like '�ѹ�%' or member.grade='�繫����' or member.grade='�Ʒ�����' or member.grade='�̵������' or $member_table.user_id='jungjuseong' or $member_table.user_id='run4joy')");
	$subject = "����($name) �ȳ�";
	$reg_date=time();
	$memo = "�Ҽ�: $org
�������: ".substr($jumin,0,6)."
����: $sex
����ȭ: $home_tel
ȸ����ȭ: $office_tel
�ڵ���: $handphone
�Ұ���: $comment";
// 334=�ѹ���
	for(; $data=mysql_fetch_array($result);){
		mysql_query("insert into $get_memo_table (member_no,member_from,subject,memo,readed,reg_date) values ('$data[no]',$chongmuno,'$subject','$memo',1,'$reg_date')") or error(mysql_error()); 
		mysql_query("insert into $send_memo_table (member_to,member_no,subject,memo,readed,reg_date) values ('$data[no]',$chongmuno,'$subject','$memo',1,'$reg_date')") or error(mysql_error());
		mysql_query("update $member_table set new_memo=1 where no='$data[no]'") or error(mysql_error());
	}
// yhkim end

	mysql_query("update $group_table set member_num=member_num+1 where no='$group_data[no]'");

	if(!$mode) {
		$member_data=mysql_fetch_array(mysql_query("select * from $member_table where user_id='$user_id' and password=password('$password')"));

		// 4.0x �� ���� ó��
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

// bmfunction.php�� �ִ� ���
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
	alert("ȸ�������� ���������� ó�� �Ǿ����ϴ�\n\nȸ���� �ǽ� ���� �������� ���ϵ帳�ϴ�.");
	opener.window.history.go(0);
	window.close();
</script>
