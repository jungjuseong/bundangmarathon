<?php
/***************************************************************************
 * ���� ���� include
 **************************************************************************/
	include "_head_m.php";

/***************************************************************************
 * �Խ��� ���� üũ
 **************************************************************************/
	$getData = iconv_CP949All($HTTP_POST_VARS);

	if(!eregi($HTTP_HOST,$HTTP_REFERER)){
		echo(iconv_UTF("���������� ���� �ۼ��Ͽ� �ֽñ� �ٶ��ϴ�."));
		exit;
	}

// ��� ���� �̸� ����
	if(!$setup[use_alllist]) $view_file_link="view_m.php"; else $view_file_link="zboard_m.php";

// ������ üũ
	if($setup[grant_comment]<$member[level]&&!$is_admin){
		echo(iconv_UTF("�������� �����ϴ�"));
	}

	$page							= $getData[page];
	$id									= $getData[id];
	$no								= $getData[no];
	$select_arrange	= $getData[select_arrange];
	$desc							= $getData[desc];
	$page_num			= $getData[page_num];
	$keyword					= $getData[keyword];
	$category				= $getData[category];
	$sn								= $getData[sn];
	$ss									= $getData[ss];
	$sc									= $getData[sc];
	$mode						= $getData[mode];
	$memo						= $getData[memo];
	$name						= $getData[name];
	$password				= $getData[password];
	$mode						= $getData[mode];

// ���� ���� �˻�;;
	$memo = str_replace("��","",$memo);
	if(isblank($memo)){
		echo(iconv_UTF("������ �Է��ϼž� �մϴ�"));
	}

	if(!$member[no]) {
		if(isblank($name)){
			echo(iconv_UTF("�̸��� �Է��ϼž� �մϴ�"));
		}
		if(isblank($password)){
			echo(iconv_UTF("��й�ȣ�� �Է��ϼž� �մϴ�"));
		}
	}

// ���͸�;; �����ڰ� �ƴҶ�;;
	if(!$is_admin&&$setup[use_filter]) {
		$filter=explode(",",$setup[filter]);

		$f_memo		= eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($memo));
		$f_name		= eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($name));
		$f_subject	= eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($subject));

		for($i=0;$i<count($filter);$i++) 
		if(!isblank($filter[$i])) {
			if(eregi($filter[$i],$f_memo)){
				echo(iconv_UTF("<b>$filter[$i]</b> ��(��) ����ϱ⿡ ������ �ܾ �ƴմϴ�"));
			}
			if(eregi($filter[$i],$f_name)){
				echo(iconv_UTF("<b>$filter[$i]</b> ��(��) ����ϱ⿡ ������ �ܾ �ƴմϴ�"));
			}
		}
	}

// �н����带 ��ȣȭ
	if($password) {
		$temp=mysql_fetch_assoc(mysql_query("select password('$password') AS pass"));
		$password=$temp['pass'];   
	}

// �������̰ų� HTML��뷹���� ������ �±��� ���������� üũ
	if(!$is_admin&&$setup[grant_html]<$member[level]) {
		$memo=del_html($memo);// ������ HTML ����;;
	}

// ȸ������� �Ǿ� ������ �̸����� ������;;
	if($member[no]) {
		if($mode=="modify"&&$member[no]!=$s_data[ismember]) {
			$name=$s_data[name];
		} else {
			$name=$member[name];
		}
	}

// ���� ������ addslashes ��Ŵ
	$name=addslashes(del_html($name));
	$memo=autolink($memo);
	$memo=addslashes($memo);

// �ڸ�Ʈ�� �ְ� Number ���� ���� (�ߺ� üũ�� ���ؼ�)
	$max_no=mysql_fetch_row(mysql_query("select max(no) from $t_comment"."_$id where parent='$no'"));

// ���� ������ �ִ��� �˻�;;
	if(!$is_admin) {
		$temp=mysql_fetch_row(mysql_query("select count(*) from $t_comment"."_$id where memo='$memo' and no='$max_no[0]'"));
		if($temp[0]>0){
			echo(iconv_UTF("���� ������ ���� ����Ҽ��� �����ϴ�"));
		}
	}

// ��Ű ����;;
	// 4.0x �� ���� ó��
	if($c_name) {
		$writer_name=$name;
		session_register("writer_name");
	}

// ���� ���� ����
	$reg_date=time(); // ������ �ð�����;;
	$parent=$no;

// �ش���� �ִ� ���� �˻�
	$check = mysql_fetch_assoc(mysql_query("select count(*) AS cmt from $t_board"."_$id where no = '$no'", $connect));
	if(!$check['cmt']){
		echo(iconv_UTF("select count(*) from $t_board"."_$id where no = '$no'"));
	}
// �ڸ�Ʈ �Է�
	mysql_query("insert into $t_comment"."_$id (parent,ismember,name,password,memo,reg_date,ip) values ('$parent','$member[no]','$name','$password','$memo','$reg_date','$REMOTE_ADDR')");


// �ڸ�Ʈ ������ ���ؼ� ����
	$total=mysql_fetch_assoc(mysql_query("select count(*) AS cmt from $t_comment"."_$id where parent='$no'"));
	mysql_query("update $t_board"."_$id set total_comment='".$total['cmt']."' where no='".$no."'");


// ȸ���� ��� �ش� �ؿ��� ���� �ֱ�
	@mysql_query("update $member_table set point2=point2+1 where no='$member[no]'",$connect);

	@mysql_close($connect);

//������ ������ ����
	echo("SUCCESS@$view_file_link?id=$id&page=$page&page_num=$page_num&select_arrange=$select_arrange&desc=$des&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&no=$no&category=$category");
	exit;
?>
