<?
if(!file_exists(getcwd().'/zboard.php')) die('�������� ������ �ƴմϴ�.');

/***************************************************************************
 * ���� ���� include
 **************************************************************************/
	include "_head.php";

/***************************************************************************
 * ��Ų ȯ�漳�� ���� include
 **************************************************************************/
	$_put_css = '1';
	include "skin/$setup[skinname]/get_config".".php";


// ����
	if(!$skin_setup[using_preview_img]) $use_thumbimg = '';

// ����� �̿��� �۾��� ����
	$mode = $HTTP_POST_VARS[mode];
	if(!eregi($HTTP_HOST,$HTTP_REFERER)) Error("���������� ���� �ۼ��Ͽ� �ֽñ� �ٶ��ϴ�.");
	if(getenv("REQUEST_METHOD") == 'GET' ) Error("���������� ���� ���ñ� �ٶ��ϴ�","");
	if(!$mode) $mode = "write";

// ������ üũ
	if($mode=="reply"&&$setup[grant_reply]<$member[level]&&!$is_admin) Error("�������� �����ϴ�","login.php?id=$id&page=$page&page_num=$page_num&category=$category&sn=$sn&ss=$ss&sc=$sc&su=$su&keyword=$keyword&no=$no&file=zboard.php");
	elseif($setup[grant_write]<$member[level]&&!$is_admin) Error("�������� �����ϴ�","login.php?id=$id&page=$page&page_num=$page_num&category=$category&sn=$sn&ss=$ss&sc=$sc&su=$su&keyword=$keyword&no=$no&file=zboard.php");

	if(!$is_admin&&$setup[grant_notice]<$member[level]) $notice = 0;

// �������� ������
	unset($s_data);
	$s_data=mysql_fetch_array(mysql_query("select * from $t_board"."_$id where no='$no'"));
	unset($m_data);
	$m_data=mysql_fetch_array(mysql_query("select * from dq_revolution where zb_id='$id' and zb_no='$no'"));

// ���ͱ�� ����
	if($skin_setup['using_market'] && $mode == 'modify') {
		$memo = $s_data[memo];
		$subject = $s_data[subject];
		$sitelink1 = $s_data[sitelink1];
		$sitelink2 = $s_data[sitelink2];
		$name = $s_data[name];
		$email = $s_data[email];
		$homepage = $s_data[homepage];

		if($s_data[category] == $category && isblank($memo2)) Error("�߰������� �Է��ϼž� �մϴ�");
	}

// ���� ���� �˻�;;
	if(!$member[no]) {
		if(isblank($name)) Error("�̸��� �Է��ϼž� �մϴ�");
		if(isblank($password)) Error("��й�ȣ�� �Է��ϼž� �մϴ�");
	} else {
		$password = $member[password];
	}

	$subject = str_replace("��","",$subject);
	$memo = str_replace("��","",$memo);
	$name = str_replace("��","",$name);

	if($skin_setup['using_market'] && $mode == 'modify') $skin_setup['using_emptyArticle'] = '1';

	if(!$skin_setup[using_emptyArticle]) {
		if(isblank($subject)) Error("������ �Է��ϼž� �մϴ�");
		if(isblank($memo)) Error("������ �Է��ϼž� �մϴ�");
	}

	if(!$category) {
		$cate_temp=mysql_fetch_array(mysql_query("select min(no) from $t_category"."_$id",$connect));
		$category=$cate_temp[0];
	}

// ���͸�;; �����ڰ� �ƴҶ�;;
	if(!$is_admin&&$setup[use_filter]) {
		$filter=explode(",",$setup[filter]);
		$f_memo=eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($memo));
		$f_name=eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($name));
		$f_subject=eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($subject));
		$f_email=eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($email));
		$f_homepage=eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($homepage));
		for($i=0;$i<count($filter);$i++) {
			if(!isblank($filter[$i])) {
				if(eregi($filter[$i],$f_memo)) Error("<b>$filter[$i]</b> ��(��) ����ϱ⿡ ������ �ܾ �ƴմϴ�");
				if(eregi($filter[$i],$f_name)) Error("<b>$filter[$i]</b> ��(��) ����ϱ⿡ ������ �ܾ �ƴմϴ�");
				if(eregi($filter[$i],$f_subject)) Error("<b>$filter[$i]</b> ��(��) ����ϱ⿡ ������ �ܾ �ƴմϴ�");
				if(eregi($filter[$i],$f_email)) Error("<b>$filter[$i]</b> ��(��) ����ϱ⿡ ������ �ܾ �ƴմϴ�");
				if(eregi($filter[$i],$f_homepage)) Error("<b>$filter[$i]</b> ��(��) ����ϱ⿡ ������ �ܾ �ƴմϴ�");
			}
		}
	}

//�н����带 ��ȣȭ
	if($password) {
		$temp=mysql_fetch_array(mysql_query("select password('$password')"));
		$password=$temp[0];   
	}

// �������̰ų� HTML��뷹���� ������ �±��� ���������� üũ
	if(!$is_admin&&$setup[grant_html]<$member[level]) {

		// ������ HTML ����;;
		if(!$use_html||$setup[use_html]==0) $memo=del_html($memo);

		// HTML�� �κ�����϶�;;
		if($use_html&&$setup[use_html]==1) {
			$memo=str_replace("<","&lt;",$memo);
			$tag=explode(",",$setup[avoid_tag]);
			for($i=0;$i<count($tag);$i++) {
				$tag[$i] = trim($tag[$i]);
				if(!isblank($tag[$i])) { 
					$memo=eregi_replace("&lt;".$tag[$i]." ","<".$tag[$i]." ",$memo); 
					$memo=eregi_replace("&lt;".$tag[$i].">","<".$tag[$i].">",$memo); 
					$memo=eregi_replace("&lt;/".$tag[$i],"</".$tag[$i],$memo); 
				}
			}  
		}
	} else {
		if(!$use_html) {
			$memo=del_html($memo);
		}
	}


// �������� �̿��� ��
	if($mode=="modify"||$mode=="reply") {
		if(!$s_data[no]) Error("�������� �������� �ʽ��ϴ�");
	}

// �����ۿ��� ����� �� �޸��� ó��
	if($mode=="reply"&&$s_data[headnum]<=-2000000000) Error("�����ۿ��� ����� �޼� �����ϴ�");


// ȸ������� �Ǿ� ������ �̸����� ������;;
	if($member[no]) {
		if($mode=="modify"&&$member[no]!=$s_data[ismember]) {
			$name=$s_data[name];
			$email=$s_data[email];
			$homepage=$s_data[homepage];
		} else {
			$name=$member[name];
			$email=$member[email];
			$homepage=$member[homepage];
		}
	}

// ���� ������ addslashes ��Ŵ;;
	$name=addslashes(del_html($name));
	if(($is_admin||$member[level]<=$setup[use_html])&&$use_html) $subject=addslashes($subject);
	else $subject=addslashes(del_html($subject));
	$memo=addslashes($memo);
	if($use_html<2) {
		$memo=str_replace("  ","&nbsp;&nbsp;",$memo);
		$memo=str_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$memo);
	}	
	$sitelink1=addslashes(del_html($sitelink1));
	$sitelink2=addslashes(del_html($sitelink2));
	$email=addslashes(del_html($email));
	$homepage=addslashes(del_html($homepage));

// ���ϼ����� �����ϰ� addslashes ��Ŵ;;
	unset($file_descript);
	if($use_descript_z1) $file_descript = "[use]";
	if($descript_z1) $file_descript .= addslashes(del_html($descript_z1));
	$file_descript .= "||";
	if($use_descript_z2) $file_descript .= "[use]";
	if($descript_z2) $file_descript .= addslashes(del_html($descript_z2));

	for($i=0; $i<99; $i++) {
		$chk_use = "use_descript_$i";
		$file_descript .= "||";
		$tmp = "descript_$i";
		if($$chk_use && $$tmp) {
			$file_descript .= "[use]";
			$file_descript .= addslashes(strip_tags($$tmp));
		}
	}
	if(strlen($file_descript) <= 200) $file_descript = "";

// Ȩ������ �ּ��� ��� http:// �� ������ ����
	if((!eregi("http://",$homepage))&&$homepage) $homepage="http://".$homepage;

// ���� ���� ����
	$ip=$REMOTE_ADDR; // �����ǰ� ����;;
	$reg_date=time(); // ������ �ð�����;;

	$x = $zx;
	$y = $zy;

//��Ų ������ ������
	include "skin/".$setup[skinname]."/get_config.php";

//�Խù� ��� ����
	include "skin/".$setup[skinname]."/include/write_limit.php";

if($skin_setup['using_attacguard']) {
	// �������� �ƴ��� �˻�;; �켱 ���� �����Ǵ뿡 30���̳��� ���� ����� ����;;
		if(!$is_admin&&$mode!="modify") {
			$max_no=mysql_fetch_array(mysql_query("select max(no) from $t_board"."_$id"));
			$temp=mysql_fetch_array(mysql_query("select count(*) from $t_board"."_$id where ip='$ip' and $reg_date - reg_date <30 and no='$max_no[0]'"));
			if($temp[0]>0) {Error("�۵���� 30���̻��� ������ �����մϴ�"); exit;}
		}

	// ���� ������ �ִ��� �˻�;;
		if(!$is_admin&&$mode!="modify") {
			$max_no=mysql_fetch_array(mysql_query("select max(no) from $t_board"."_$id"));
			$temp=mysql_fetch_array(mysql_query("select count(*) from $t_board"."_$id where memo='$memo' and no='$max_no[0]'"));
			if($temp[0]>0) {Error("���� ������ ���� ����Ҽ��� �����ϴ�"); exit; }
		}
}



// ��Ű ����;;
	if($mode!="modify") {
		// ���� ���� ó�� (4.0x�� ���� ó���� ���Ͽ� �ּ� ó��)
		//if($name) $HTTP_SESSION_VARS["zb_writer_name"] = $name;
		//if($email) $HTTP_SESSION_VARS["zb_writer_email"] = $email;
		//if($homepage) $HTTP_SESSION_VARS["zb_writer_homepage"] = $homepage;

		// 4.0x �� ���� ó��
		if($name) {
			$zb_writer_name = $name;
			$_SESSION['zb_writer_name'] = $zb_writer_name;
		}
		if($email) {
			$zb_writer_email = $email;
			$_SESSION['zb_writer_email'] = $zb_writer_email;
		}
		if($homepage) {
			$zb_writer_homepage = $homepage;
			$_SESSION['zb_writer_homepage'] = $zb_writer_homepage;
		}
	}

//�۾��� �Ϸ� & DB�� ������ �Է�
	$_inclib_01 = "skin/".$setup[skinname]."/include/dq_thumb_engine2.";
	$_inclib_02 = "skin/".$setup[skinname]."/include/unlimit_write2.";
	if(file_exists($_inclib_01) && filesize($_inclib_01.'php')) include_once $_inclib_01.'php';
	else include_once $_inclib_01.'zend';
	if(file_exists($_inclib_02.'php') && filesize($_inclib_02.'php')) include_once $_inclib_02.'php';
	else include_once $_inclib_02.'zend';

// �ۼ��� ���� ������
	//unset($s_data);
	//$s_data=mysql_fetch_array(mysql_query("select * from $t_board"."_$id where no='$no'"));

// �������� ����
	//include "./DQ_LIBS/include/dq_thumb_engine.zend";
	$_dq_tempFile="data/$id/small_".$no.".thumb";
	$_dq_workFile="data/$id/small_".$no.".thumb.work";
	if(file_exists($_dq_tempFile)) unlink ($_dq_tempFile);
	// �ֱٰԽù� ����� ����
	//$latest_thumb = "data/_DQThumb_Latest_Temp/$id_$no.thumb";
	//if(file_exists($latest_thumb)) unlink ($latest_thumb);

	if(file_exists($_dq_workFile)) unlink ($_dq_workFile);
	//$thumb_tag = get_thumbTag($s_data,$skin_setup['thumb_imagex'],$skin_setup['thumb_imagey'],$dir);

// ���� ������ �ٽ� ����
	$total=mysql_fetch_array(mysql_query("select count(*) from $t_board"."_$id "));
	mysql_query("update $admin_table set total_article='$total[0]' where name='$id'");

// ȸ���� ��� �ش� �ؿ��� ���� �ֱ�
	if(!$skin_setup[write_nopoint] && ($mode=="write"||$mode=="reply")) @mysql_query("update $member_table set point1=point1+1 where no='$member[no]'",$connect) or error(mysql_error());

// MySQL �ݱ� 
	if($connect) {
		mysql_close($connect); 
		unset($connect);
	}

// ������ �̵�
	//if($setup[use_alllist]) $view_file="zboard.php"; else $view_file="view.php";
	$view_file = "zboard.php";
	movepage($view_file."?id=$id&page=$page&page_num=$page_num&select_arrange=$select_arrange&desc=$des&sn=$sn&ss=$ss&sc=$sc&su=$su&keyword=$keyword&no=$no&category=$category");
?>