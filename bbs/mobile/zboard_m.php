<?

/***************************************************************************
 * ���� ���� include
 **************************************************************************/
	include "_head_m.php";


/***************************************************************************
 * �Խ��� ���� üũ
 **************************************************************************/

// ������ üũ
	if($setup[grant_list]<$member[level] && !$is_admin) error_m("�������� �����ϴ�");

// �˻������� ������ : ��Ȳ -> ī�װ� ����, Use_Showreply ���, �Ǵ� �˻���� �˻��� �Ҷ�
	if($s_que) {
		$que="select * from $t_board"."_$id $s_que order by $select_arrange $desc limit $start_num, $page_num";
		$result=mysql_query($que,$connect);
	}

// �˻� ������ ������ : ��Ȳ -> �Ϲ� ����, �Ǵ� ���ı����� �����ų� Desc, Asc �϶�.
	else {

		// �˻������� ���� ������ headnum�� ���� ���϶�;; �� �Ϲ� �����϶�;; 
		if ($select_arrange=="headnum"&&$desc=="asc") {
			while($division_data=mysql_fetch_array($division_result)) {
				$sum=$sum+$division_data[num];
				$division=$division_data[division];
	
				if($sum>=$start_num) {
					$start_num=$start_num-($sum-$division_data[num]);
					$que="select * from $t_board"."_$id where division='$division' and headnum<0 order by headnum,arrangenum limit $start_num, $page_num";
					$result=mysql_query($que);
					$check1=1;
	
					$returnNum = mysql_num_rows($result);
	
					if($returnNum>=$page_num) { 
						break;
					} else {
						if($division>1) {
							$division--;
							$minus=$page_num-$returnNum;
							$que2="select * from $t_board"."_$id where division=$division and headnum!=0 order by headnum,arrangenum limit $minus";
							$result2=mysql_query($que2);
							$check2=1;
							break;
						}
					}
				}
			}
		}

		// �˻������� ������ ���İ��� ���涧;;; //////////////////////////////
		else {
			$que="select * from $t_board"."_$id $s_que order by $select_arrange $desc $add_on limit $start_num, $page_num";
			$result=mysql_query($que,$connect);
		}
	}

// �������϶��� �Խ��� �� �ű�⶧���� �Խ��� ����Ʈ�� �̾ƿ�;;
	if($is_admin) {
		$board_result=mysql_query("select no,name from $admin_table where no!='$setup[no]'");
	}


/***************************************************************************
 * ��Ų���� ����� ������ ����
 **************************************************************************/

	$print_page="";
	$show_page_num=$setup[page_num]; // �ѹ��� ���� ������ ����
	$start_page=(int)(($page-1)/$show_page_num)*$show_page_num;
	$i=1;

	$a_1_prev_page = "";
	$a_1_next_page = "";
	$a_prev_page = "";
	$a_next_page = " ";

	if($page>1) $a_1_prev_page="<a href='$PHP_SELF?id=$id&page=".($page-1)."&select_arrange=$select_arrange&desc=$desc&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&sn1=$sn1&divpage=$divpage' rel='external'>";

	if($page<$total_page) $a_1_next_page="<a href='$PHP_SELF?id=$id&page=".($page+1)."&select_arrange=$select_arrange&desc=$desc&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&sn1=$sn1&divpage=$divpage' rel='external'>";

	if($page>$show_page_num) {
		$prev_page=$start_page;
		$a_prev_page="<a href='$PHP_SELF?id=$id&page=$prev_page&select_arrange=$select_arrange&desc=$desc&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&sn1=$sn1&divpage=$divpage'  rel='external'>[���� $setup[page_num] ��]</a>";
		$print_page.="<a href='$PHP_SELF?id=$id&page=1&select_arrange=$select_arrange&desc=$desc&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&sn1=$sn1&divpage=$divpage'  rel='external'><font style=font-size:14pt>1</a><font style=font-size:8pt>..";
		$prev_page_exists = true;
		}

	while($i+$start_page<=$total_page&&$i<=$show_page_num) {
		$move_page=$i+$start_page;
		if($page==$move_page) $print_page.="<span id='currentPage'>$move_page</span>";
		else $print_page.="<a href='$PHP_SELF?id=$id&page=$move_page&select_arrange=$select_arrange&desc=$desc&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&sn1=$sn1&divpage=$divpage' rel='external'>$move_page</a>";
		$i++;
	}

	if($total_page>$move_page) {
		$next_page=$move_page+1;
		$a_next_page="<a href='$PHP_SELF?id=$id&page=$next_page&select_arrange=$select_arrange&desc=$desc&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&sn1=$sn1&divpage=$divpage' rel='external'>[���� $setup[page_num] ��]</a>";
		$print_page.="<font style=font-size:14pt>..<a href='$PHP_SELF?id=$id&page=$total_page&select_arrange=$select_arrange&desc=$desc&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&sn1=$sn1&divpage=$divpage' rel='external'><font style=font-size:14pt>$total_page</a>";
		$next_page_exists = true;
	}

	// �˻��� Divsion ������ �̵� ǥ��
	if($use_division) {
		if($prevdivpage&&!$prev_page_exists) $a_div_prev_page="<a href='$PHP_SELF?id=$id&&select_arrange=$select_arrange&desc=$desc&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&sn1=$sn1&divpage=$prevdivpage' rel='external'>���� �˻�</a>...";
		if($nextdivpage&&!$next_page_exists) $a_div_next_page="...<a href='$PHP_SELF?id=$id&&select_arrange=$select_arrange&desc=$desc&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&sn1=$sn1&divpage=$nextdivpage' rel='external'>��� �˻�</a>";
		$print_page = $a_div_prev_page.$print_page.$a_div_next_page;

	}


/***************************************************************************
 * ���� ��ũ�� �̸� �����ϴ� �κ� 
 **************************************************************************/

// �۾����ư
	if($is_admin||$member[level]<=$setup[grant_write]) $a_write="<a href='write_m.php?$href$sort&no=$no&mode=write&sn1=$sn1&divpage=$divpage&refer=".urlencode($HTTP_HOST)."' data-role='button' rel='external'  data-theme='a' class='backgroundStyle ui-btn-right' data-icon='plus'>�۾���</a>"; else $a_write="";

// ��� ��ư
	if($is_admin||$member[level]<=$setup[grant_list]) $a_list="<a href='$PHP_SELF?id=$id&page=$page&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&prev_no=$no&sn1=$sn1&divpage=$divpage'>���</a> "; else $a_list="";

// ��ҹ�ư
	$a_cancel="<a href='$PHP_SELF?id=$id'>";

/***************************************************************************
 * ������ ����Ÿ�� ����ϴ� �κ� 
 **************************************************************************/

// ��� ���
echo('
<html>
<head>
<title>���κ��� �����</title>
<meta name="description" content="���κ���, �����, �д縶����Ŭ��">
<meta name="keywords" content="���κ���, �����, �д縶����Ŭ��">
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">
<link rel="stylesheet" href="./css/jquery.mobile.css" />
<link rel="stylesheet" href="./css/_mobile.css" />
<script src="./js/jquery-1.5.js"></script>
<script src="./js/jquery.mobile.js"></script>
<script src="./js/jquery.validate.js"></script>
</head>
<body>
');
$pageType = "write";
// ��� ��Ȳ �κ� ��� 
	include "./skin/setup_m.php";

// ���� ���õ� ����Ÿ�� ������, �� $no �� ������ ����Ÿ ������
	if($no&&$setup[use_alllist]) {
		$_view_included = true;
		include "view_m.php";
	}

// ����Ʈ�� ��� �κ� ���
	include "./skin/list_head_m.php";

//�����ȣ�� ����
	$loop_number=$total-($page-1)*$page_num;
	if($setup[use_alllist]&&!$prev_no) $prev_no=$no;

// ������ ����Ÿ��ŭ �����
	while($data=@mysql_fetch_array($result)) {
		list_check(&$data);
		if($data[headnum]>-2000000000) {include "./skin/list_main_m.php";}
		else {include "./skin/list_notice_m.php"; }
		$loop_number--;
	}

	if($check2) {
		while($data=@mysql_fetch_array($result2)) {
			list_check(&$data);
			if($data[headnum]>-2000000000) {include "./skin/list_main_m.php";}
			else {include "./skin/list_notice_m.php"; }
			$loop_number--;
		}
	}

// ������ �κ� ����ϴ� �κ�;;
	include "./skin/list_foot_m.php";

/***************************************************************************
 * ������ �κ� include
 **************************************************************************/
	include "_foot_m.php";
?>
