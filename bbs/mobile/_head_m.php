<?
/*
                MOBILE ��
*/

/***************************************************************************
 * ������ ȣ��� ���� �߻� ����
 **************************************************************************/
	if($_head_php_excuted) return;
	$_head_php_excuted = true;

/***************************************************************************
 * �⺻ ���̺귯�� include 
 **************************************************************************/

// ���̺귯�� �Լ� ���� include

  if(eregi(":\/\/",$_zb_path)||eregi("\.\.",$_zb_path)) $_zb_path ="../";
	include "../lib.php";           //���� ���̺귯��
	include $_zb_path."lib_m.php";  //�߰� ���̺귯��[����Ͽ�]

/***************************************************************************
 * ���� _head.php�� ȣ���ϴ� ������ �Խ��� ���� �������� �˻�
 **************************************************************************/
 	$_zb_file_list = array("apply_vote.php","comment_ok_m.php","del_comment_m.php","del_comment_ok_m.php","delete_m.php","download.php","list_all.php","vote.php","write_m.php","write_ok_m.php","zboard_m.php","image_box.php","view_m.php");
	$_zb_c = count($_zb_file_list);
	for($i=0;$i<$_zb_c;$i++) {
		if(eregi($_zb_file_list[$i],$PHP_SELF)) { $_zboardis = TRUE; break; }
		else $_zboardis = FALSE;
	}


// ����Ʈ üũ �Լ� ���� include
	if($_zboardis) include "../include/list_check.php";

/***************************************************************************
 * �⺻ ���� üũ
 **************************************************************************/

// �Խ��� $id üũ
	if(!$id&&$_zboardis) error_m("�Խ��� �̸��� ������ �ּž� �մϴ�.<br><br>��) zboard.php?id=�̸�",""); // �Խ��� �̸� üũ


/***************************************************************************
 * DB �����Ͽ� �⺻ ����Ÿ ����
 **************************************************************************/
// DB ����
	if(!$connect) $connect=dbconn_m();  

// ��� ���� ���ؿ���;;; ����� ������
	$_dbTimeStart = getmicrotime();
	$member=member_info();
	$_dbTime += getmicrotime()-$_dbTimeStart;

/***************************************************************************
 * ���� _head.php�� �ҷ����� ������ �Խ����ϰ�쿡 üũ �ϴ� �׸��
 **************************************************************************/
	if($_zboardis) {

		// �Խ��� ���� �о� ����
		$_dbTimeStart = getmicrotime();
		$setup = get_table_attrib($id); 

    if(!$setup[name]) error_m("�������� ���� �Խ����Դϴ�.<br><br>�Խ����� ������ ����Ͻʽÿ�",""); // �������� ���� �Խ���

		// ���� �Խ����� �׷��� ���� �о� ����
		if($_zboardis) $group=group_info($setup[group_no]);
		$_dbTime += getmicrotime()-$_dbTimeStart;

		// ���� �α��εǾ� �ִ� ����� ��ü, �׷������, �Խ��ǰ��������� �˻�
		if($member[is_admin]==1||($member[is_admin]==2&&$member[group_no]==$setup[group_no])||check_board_master($member, $setup[no])) $is_admin=1; else $is_admin="";

		// ���� �׷��� ���׷��̰� �α����� ����� �����϶� ����ǥ��
		if($group[is_open]==0&&!$is_admin&&$member[group_no]!=$setup[group_no]) error_m("���� �Ǿ� ���� �ʽ��ϴ�");

		// ���� ���� �������� ��� �����ϱ�;;;
		if(!$is_admin) check_blockip_m();

		// �������ϰ�쿡�� ������ �ٱ��� ��� Ȱ��ȭ ��Ŵ (�Խù� ������ ���ؼ�)
		if($is_admin) $setup[use_cart]=1; 

		// ��Ų ���丮 : $dir �̶�� ������ ����ؼ� ��Ų��� ���Ϸ� 
		$dir="./skin/".$setup[skinname];
	
		// �Խ����� ����ũ�� ����
		$width=$setup[table_width];

		// ī�װ� �о����
		if($setup[use_category]) {
			$_dbTimeStart = getmicrotime();
			$result=mysql_query("select * from $t_category"."_$id order by no");
			$_dbTime += getmicrotime()-$_dbTimeStart;
			$a_category="<select name=category id='selectCategory'><option value=''>ī�װ�</option>";
			while($data=mysql_fetch_assoc($result)) {
					$category_num_c[]=$data[no];
					$category_name_c[]=$data[name];
					$category_n_c[]=$data[num];
					$category_data[$data[no]]=$data[name];
					$_category_data[$data[no]]=$data[num];
					if($category==$data[no]) $a_category.="<option value=$data[no] selected>$data[name]</option>";
					else $a_category.="<option value=$data[no]>$data[name]</option>";
			}
			$a_category.="</select>";
		} else {
			$category="";
		}

		/////////////////////////////////////////////
		// write.php�� �ƴҶ� �˻����� �� query ����
		/////////////////////////////////////////////
		if(!eregi("write.php",$PHP_SELF)) {

			// Division�� ��Ȳ�� üũ
			$_dbTimeStart = getmicrotime();
			$division_result=mysql_query("select * from $t_division"."_$id where num>0 order by division desc");
			$_dbTime += getmicrotime()-$_dbTimeStart;
			$total_division=mysql_num_rows($division_result);
			$sum=0;
			$division=0;

			// division �������� ������ ���� (�˻��� ����ϴ� ����������)
			if(!$divpage) $divpage = $total_division;
			if($divpage<$total_division) $prevdivpage = $divpage +1;
			if($divpage>1) $nextdivpage = $divpage -1;

			// ���� ��� : $select_arrange �� ���� �ʵ�, $desc �� ����, �����Ľ�
			if(!$select_arrange) $select_arrange="headnum";
			if(!$desc) $desc="asc";
	
			// ��� ��Ͽ� ��Ÿ���� �ʰ� �����Ͽ����� (�Խ��� ������ use_showreply�� üũ �Ǿ�����)
			if(!$setup[use_showreply]) if(!$s_que) $s_que=" arrangenum=0 "; else $s_que.=" and arrangenum=0 ";
	
			// ī�װ� : ī�װ��� ������ category�� �˻� ���ǿ� ����
			if($category) if(!$s_que) $s_que=" category='$category' "; else $s_que.=" and category='$category'";
	
			// �˻� ��� üũ, $sn �̸� $ss ���� $sc ���� �˻�, $keyword ����;;
			$keyword=stripslashes($keyword);
			$keyword=str_replace("`","",$keyword);
			$keyword=str_replace("\"","",$keyword);
			$keyword=str_replace("'","",$keyword);
			if(!$sn) $sn="off";
			if(!$ss) $ss="off";
			if(!$sc) $sc="off";
			if($sc=="off"&&$sn=="off"&&$ss=="off") {
				$sc="on";
				$ss="on";
			}
			if(!isblank($keyword)) {
				$keyword=addslashes($keyword);
				if(!$sn1) {
					if($sn=="on"&&$t_s_que) $t_s_que.=" or name like '%$keyword%' "; 
					elseif($sn=="on") $t_s_que.=" name like '%$keyword%' ";
				} else {
					if($sn=="on"&&$t_s_que) $t_s_que.=" or name = '$keyword' "; 
					elseif($sn=="on") $t_s_que.=" name = '$keyword' ";
				}
				if($ss=="on"&&$t_s_que) $t_s_que.=" or subject like '%$keyword%' "; elseif($ss=="on") $t_s_que.=" subject like '%$keyword%' ";
				if($sc=="on"&&$t_s_que) $t_s_que.=" or memo like '%$keyword%' "; elseif($sc=="on") $t_s_que.=" memo like '%$keyword%' ";
				if($s_que) $s_que.=" and ( ".$t_s_que." ) ";
				else $s_que.= " ( ".$t_s_que." ) ";
				$keyword=stripslashes($keyword);
			}
		
			// �˻� ������ ������ �տ� where �� �߰�
			if($s_que) $s_que=" where ".$s_que;

			// ��ü������ ���� : �˻�� �������� ���� ��ü ������ ����, �ƴϸ� �Խ��ǿ� �ִ°�����
			if($s_que) {
				// ī�װ��� ���� ���
				if(!$keyword&&$setup[use_showreply]) {
					$total=$_category_data[$category];

				// �˻�� ��۾����� üũ�Ǿ� �������
				} else {
					$use_division = true;
					$s_que = str_replace("where","where division='$divpage' and ", $s_que);
					$_dbTimeStart = getmicrotime();
					$temp=mysql_fetch_assoc(mysql_query("select count(*) AS cmt from $t_board"."_$id $s_que ",$connect));
					$_dbTime += getmicrotime()-$_dbTimeStart;
					$total=$temp['cmt'];
				}
			} else $total=$setup[total_article];

			// ������ ���� ������ ����
			$page_num=$setup[memo_num];
			if(!$page) $page=1; // ���� $page��� ������ ���� ������ ���Ƿ� 1 ������ �Է�
		
			$total_page=(int)(($total-1)/$page_num)+1; // ��ü ������ ����
		
			if($page>$total_page) $page=$total_page; // �������� ��ü ���������� ũ�� ������ ��ȣ �ٲ�
		
			$start_num=($page-1)*$page_num; // ������ ���� ���� ��½� ù��°�� �� ���� ��ȣ ����
		}


 		// ��ũ ����
		unset($href);
	
		$href="id=$id&page=$page&sn1=$sn1&divpage=$divpage";
		if($category) $href.="&category=$category";
		if($sn) $href.="&sn=$sn";
		if($ss) $href.="&ss=$ss";
		if($sc) $href.="&sc=$sc";
		if($prev_num) $href.="&prev_num=$prev_num";
		if($keyword) $href.="&keyword=$keyword";
		
		unset($sort);
		if($select_arrange) $sort.="&select_arrange=$select_arrange";
		if($desc) $sort.="&desc=$desc";

		// ī�װ��� ��Ÿ���� �ϴ� ����
		if(!$setup[use_category]) {
			$hide_category_start="<!--";
			$hide_category_end="-->";
		}

		// �ٱ��ϸ� ��Ÿ���� �ϴ� ����
		if($is_admin||$setup[use_cart]) {
			$a_cart="<a onfocus=blur() href='javascript:reverse()'>";
		} else {
			$hide_cart_start="<!--";
			$hide_cart_end="-->";
			$a_cart=""; 
		}
	}


/***************************************************************************
 * ���� �⺻ ��ư ����
 **************************************************************************/

// �α���, �ƿ�, ȸ�� ���� ����, ���� �޴� ��ư

	$s_url = $REQUEST_URI;
	if($id&&!eregi($id, $s_url)) {
		if(eregi("\?",$s_url)) $s_url = $s_url . "&id=$id";
		else $s_url = $s_url . "?id=$id";
	}
	$s_url = urlencode($s_url);

	if(!$member[no]) {
		$a_login="<a onfocus=blur() href='".$_zb_url."login.php?$href$sort&s_url=$s_url'>";
		$a_logout=" ";
	} else {
		$a_login="";
		$a_logout="<a onfocus=blur() href='".$_zb_url."logout.php?$href$sort&s_url=$s_url'>";
	}
?>
