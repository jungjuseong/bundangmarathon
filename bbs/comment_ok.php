<?
/***************************************************************************
 * ���� ���� include
 **************************************************************************/
	include "_head.php";

	if(!eregi($HTTP_HOST,$HTTP_REFERER)) Error("���������� ���� �ۼ��Ͽ� �ֽñ� �ٶ��ϴ�.");

/***************************************************************************
 * �Խ��� ���� üũ
 **************************************************************************/

// ��� ���� �̸� ����
	if(!$setup[use_alllist]) $view_file_link="view.php"; else $view_file_link="zboard.php";
if($dispmode=="contonly")	// yhkim
	$view_file_link="/bbs/view.php";
	
//yhkim start : ������ write_ok.php(2���� ����), spam ��� ����
// photo : vote_ex.php
if($id=="pubboard" && ($no==2529 || $no==2156 || $no==2163 || $no==1013 || $no==1669 || $no==1670 || $no==1671 || $no==1673 || $no==199)
	|| $id=="hotnews" && ($no==17 || $no==24)
	|| $id=="noticeboard" && ($no==46 || $no==46)
	|| $id=="databoard" && ($no==44 || $no==45 || $no==46 || $no==47))
	Error("��۴ޱ� �����Դϴ�.");
// yhkim end

function ContentSave(){
global $member, $name, $id, $no, $REMOTE_ADDR, $memo;

	$savefilename = "tmp/BoardContentData-".date("Ym").".txt";
	if(file_exists($savefilename) == TRUE){
		$f = fopen($savefilename,"a");
		fclose($f);
		chmod("tmp/BoardContentData-".date("Ym").".txt", 0777);
	}
	$f = fopen($savefilename,"a");
	$lock=flock($f,2);
	if($lock) {
		fwrite($f,"\n*******************************************\n");
		fwrite($f,"$member[user_id] $name $id.$no $REMOTE_ADDR ".date("Y-m-d H:i:s")."\n");
		fwrite($f,$memo);
	}
	flock($f,3);
	fclose($f);
}
// yhkim end

// ������ üũ
	if($setup[grant_comment]<$member[level]&&!$is_admin) {
//		ContentSave();
		Error("�������� �����ϴ�...","login.php?id=$id&page=$page&page_num=$page_num&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&no=$no&file=$view_file_link");
	}

// ���� ���� �˻�;;
	$memo = str_replace("��","",$memo);
	if(isblank($memo)) Error("������ �Է��ϼž� �մϴ�");
	if(!$member[no]) {
		if(isblank($name)) Error("�̸��� �Է��ϼž� �մϴ�");
		if(isblank($password)) Error("��й�ȣ�� �Է��ϼž� �մϴ�");
	}

// ���͸�;; �����ڰ� �ƴҶ�;;
	if(!$is_admin&&$setup[use_filter]) {
		$filter=explode(",",$setup[filter]);

		$f_memo=eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($memo));
		$f_name=eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($name));
		$f_subject=eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($subject));
		$f_email=eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($email));
		$f_homepage=eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($homepage));
		for($i=0;$i<count($filter);$i++) 
		if(!isblank($filter[$i])) {
			if(eregi($filter[$i],$f_memo)) Error("<b>$filter[$i]</b> ��(��) ����ϱ⿡ ������ �ܾ �ƴմϴ�");
			if(eregi($filter[$i],$f_name)) Error("<b>$filter[$i]</b> ��(��) ����ϱ⿡ ������ �ܾ �ƴմϴ�");
		}
	}

// �н����带 ��ȣȭ
	if($password) {
		$temp=mysql_fetch_array(mysql_query("select password('$password')"));
		$password=$temp[0];   
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
	$max_no=mysql_fetch_array(mysql_query("select max(no) from $t_comment"."_$id where parent='$no'"));

// ���� ������ �ִ��� �˻�;;
	if(!$is_admin) {
		$temp=mysql_fetch_array(mysql_query("select count(*) from $t_comment"."_$id where memo='$memo' and no='$max_no[0]'"));
		if($temp[0]>0) Error("���� ������ ���� ����Ҽ��� �����ϴ�");
	}

// ��Ű ����;;

	// ���� ���� ó�� (4.0x�� ���� ó���� ���Ͽ� �ּ� ó��)
	//if($c_name) $HTTP_SESSION_VARS["writer_name"]=$name;

	// 4.0x �� ���� ó��
	if($c_name) {
		$writer_name=$name;
		session_register("writer_name");
	}

// ���� ���� ����
	$reg_date=time(); // ������ �ð�����;;
	$parent=$no;

// �ش���� �ִ� ���� �˻�
	$check = mysql_fetch_array(mysql_query("select count(*) from $t_board"."_$id where no = '$no'", $connect));
	if(!$check[0]) Error("���� ���� �������� �ʽ��ϴ�.");

// �ڸ�Ʈ �Է�
	mysql_query("insert into $t_comment"."_$id (parent,ismember,name,password,memo,reg_date,ip) values ('$parent','$member[no]','$name','$password','$memo','$reg_date','$REMOTE_ADDR')") or error(mysql_error());


// �ڸ�Ʈ ������ ���ؼ� ����
	$total=mysql_fetch_array(mysql_query("select count(*) from $t_comment"."_$id where parent='$no'"));
	mysql_query("update $t_board"."_$id set total_comment='$total[0]' where no='$no'") or error(mysql_error());


// ȸ���� ��� �ش� �ؿ��� ���� �ֱ�
	@mysql_query("update $member_table set point2=point2+1 where no='$member[no]'",$connect) or error(mysql_error());

	@mysql_close($connect);

// yhkim
//	ContentSave();

// ������ �̵�
//	movepage("$view_file_link?id=$id&page=$page&page_num=$page_num&select_arrange=$select_arrange&desc=$des&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&no=$no&category=$category");
// yhkim
//echo "<script>alert('PHP_SELF==$view_file_link && dispmode==$dispmode')</script>";
	movepage("$view_file_link?id=$id&dispmode=$dispmode&page=$page&page_num=$page_num&select_arrange=$select_arrange&desc=$des&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&no=$no&category=$category");
?>
