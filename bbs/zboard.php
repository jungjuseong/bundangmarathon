<?
/***************************************************************************
 * ���� ���� include
 **************************************************************************/
include "_head.php";

/***************************************************************************
 * �Խ��� ���� üũ
 **************************************************************************/
// ������ üũ

if($setup[grant_list]<$member[level] && !$is_admin) Error("�������� �����ϴ�","login.php?id=$id&no=$no&page=$page&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&s_url=".urlencode($REQUEST_URI));

// �˻������� ������ : ��Ȳ -> ī�װ��� ����, Use_Showreply ���, �Ǵ� �˻���� �˻��� �Ҷ�
if($s_que) {
	$_dbTimeStart = getmicrotime();
	$que="select * from $t_board"."_$id $s_que order by $select_arrange $desc limit $start_num, $page_num";
	$result=mysql_query($que,$connect) or Error(mysql_error());
	$_dbTime += getmicrotime()-$_dbTimeStart;
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
			$_dbTimeStart = getmicrotime();
			$que="select * from $t_board"."_$id where division='$division' and headnum<0 order by headnum,arrangenum limit $start_num, $page_num";
			$result=mysql_query($que) or error(mysql_error());
			$_dbTime += getmicrotime()-$_dbTimeStart;
			$check1=1;

			$returnNum = mysql_num_rows($result);

				if($returnNum>=$page_num) {
					break;
				} else {
					if($division>1) {
						$division--;
						$minus=$page_num-$returnNum;
						$_dbTimeStart = getmicrotime();
						$que2="select * from $t_board"."_$id where division=$division and headnum!=0 order by headnum,arrangenum limit $minus";
						$result2=mysql_query($que2) or error(mysql_error());
						$_dbTime += getmicrotime()-$_dbTimeStart;
						$check2=1;
						break;
					}
				}
		}
	} // while
}
// �˻������� ������ ���İ��� ���涧;;; //////////////////////////////
else {
		$que="select * from $t_board"."_$id $s_que order by $select_arrange $desc $add_on limit $start_num, $page_num";
		$_dbTimeStart = getmicrotime();
		$result=mysql_query($que,$connect) or Error(mysql_error());
		$_dbTime += getmicrotime()-$_dbTimeStart;
	}
}

// �������϶��� �Խ��� �� �ű�⶧���� �Խ��� ����Ʈ�� �̾ƿ�;;
if($is_admin) {
	$_dbTimeStart = getmicrotime();
	$board_result=mysql_query("select no,name from $admin_table where no!='$setup[no]'");
	$_dbTime += getmicrotime()-$_dbTimeStart;
}

/***************************************************************************
 * ��Ų���� ����� ������ ����
 **************************************************************************/

$print_page="";
$show_page_num=$setup[page_num]; // �ѹ��� ���� ������ ����
$start_page=(int)(($page-1)/$show_page_num)*$show_page_num;
$i=1;

$a_1_prev_page= "<Zeroboard ";
$a_1_next_page= "<Zeroboard ";
$a_prev_page = "<Zeroboard ";
$a_next_page = "<Zeroboard ";

$link_to_page = "<a onfocus=blur() href='$PHP_SELF?cafe_style=$cafe_style&id=$id&select_arrange=$select_arrange&desc=$desc&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&sn1=$sn1&divpage=$divpage";

$a_1_prev_page= $link_to_page."&page=".($page-1)."'>"; 
if($page>1) 
	$a_1_prev_page= $link_to_page."&page=".($page-1)."'>"; 

if($page<$total_page) 
	$a_1_next_page= $link_to_page."&page=".($page+1)."'>";

if($page>$show_page_num) {
	$prev_page=$start_page;
	$a_prev_page= $link_to_page."'>"; 
	$print_page.= $link_to_page."'><font style=font-size:8pt>[1]</a><font style=font-size:8pt>..";
	$prev_page_exists = true;
}

while($i+$start_page<=$total_page&&$i<=$show_page_num) {
	$move_page=$i+$start_page;
	if($page == $move_page) 
		$print_page.=" <font style=font-size:8pt><b>$move_page</b> ";
	else 
		$print_page.= $link_to_page."&page=".$move_page."'><font style=font-size:8pt>[$move_page]</a>";
	$i++;
}

if($total_page>$move_page) {
	$next_page=$move_page+1;
	$a_next_page= $link_to_page."&page=".$next_page."'>";

	$print_page.= "<font style=font-size:8pt>..".$link_to_page."&page=".$total_page."'><font style=font-size:8pt>[$total_page]</a>";
	$next_page_exists = true;
}

// �˻��� Divsion ������ �̵� ǥ��
if($use_division) {
	if($prevdivpage&&!$prev_page_exists) 
		$a_div_prev_page="<a onfocus=blur() href='$PHP_SELF?cafe_style=$cafe_style&id=$id&&select_arrange=$select_arrange&desc=$desc&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&sn1=$sn1&divpage=$prevdivpage'>[���� �˻�]</a>...";
	if($nextdivpage&&!$next_page_exists) 
		$a_div_next_page="...<a onfocus=blur() href='$PHP_SELF?cafe_style=$cafe_style&id=$id&&select_arrange=$select_arrange&desc=$desc&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&sn1=$sn1&divpage=$nextdivpage'>[��� �˻�]</a>";
	$print_page = $a_div_prev_page.$print_page.$a_div_next_page;

}


/***************************************************************************
 * ���� ��ũ�� �̸� �����ϴ� �κ�
 **************************************************************************/
function call_zboard($order_type)
{
	global $PHP_SELF, $href, $t_desc, $cafe_style;;
	if ($cafe_style == "yes") 
		return "<a onfocus=blur() href='$PHP_SELF?$href&cafe_style=yes&select_arrange=$order_type&desc=$t_desc'>";
	else
		return "<a onfocus=blur() href='$PHP_SELF?$href&select_arrange=$order_type&desc=$t_desc'>";
}

// �۾����ư
/* write.php --> write_bmc.php */
	if($is_admin||$member[level]<=$setup[grant_write]) 
		$a_write="<a onfocus=blur() href='write_bmc.php?$href$sort&no=$no&mode=write&sn1=$sn1&divpage=$divpage'>"; else $a_write="<Zeroboard ";

// ��� ��ư
	if($is_admin||$member[level]<=$setup[grant_list]) 
		$a_list="<a onfocus=blur() href='$PHP_SELF?cafe_style=$cafe_style&id=$id&page=$page&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&prev_no=$no&sn1=$sn1&divpage=$divpage'>"; else $a_list="<Zeroboard ";

// ��ҹ�ư
	$a_cancel="<a onfocus=blur() href='$PHP_SELF?cafe_style=$cafe_style&id=$id'>";


// ���� ��ư�� ��� $desc�� ������ ��ȯ
	if($desc=="desc") $t_desc="asc"; else $t_desc="desc";
// ��ȣ ����
	$a_no=call_zboard("headnum");
// ���� ����
	$a_subject=call_zboard("subject");
// �̸� ����
	$a_name=call_zboard("name");
// ��ȸ�� ����
	$a_hit=call_zboard("hit");
// ��õ�� ����
	$a_vote=call_zboard("vote");
// ���ں� ����
	$a_date=call_zboard("reg_date");
// ù��° �׸��� �ٿ�ε� ����
	$a_download1=call_zboard("download1");
// �ι�° �׸��� �ٿ�ε� ����
	$a_download2=call_zboard("download2");

/***************************************************************************
 * ������ ����Ÿ�� ����ϴ� �κ�
 **************************************************************************/

// ��� ���
	$_skinTimeStart = getmicrotime();

	head('',"script_list.php");

// ��� ��Ȳ �κ� ���
	include "$dir/setup.php";
	$_skinTime += getmicrotime()-$_skinTimeStart;

// ���� ���õ� ����Ÿ�� ������, �� $no �� ������ ����Ÿ ������
	if($no&&$setup[use_alllist]) {
		$_view_included = true;
		include "view.php";
	}

// ����Ʈ�� ��� �κ� ���
	$_skinTimeStart = getmicrotime();
	include $dir."/list_head.php";
	$_skinTime += getmicrotime()-$_skinTimeStart;

//�����ȣ�� ����
	$loop_number=$total-($page-1)*$page_num;
	if($setup[use_alllist]&&!$prev_no) $prev_no=$no;

// ������ ����Ÿ��ŭ �����
	while($data=@mysql_fetch_array($result)) {
		list_check(&$data);
		$_skinTimeStart = getmicrotime();
//echo "data[headnum]=$data[headnum] dir=$dir";

		if($data[headnum]>-2000000000) {
			include $dir."/list_main.php";
		}
		else {
			include $dir."/list_notice.php"; 
		}
		$_skinTime += getmicrotime()-$_skinTimeStart;
		$loop_number--;
	}

	if($check2) {
		while($data=@mysql_fetch_array($result2)) {
			list_check(&$data);
			$_skinTimeStart = getmicrotime();
			if($data[headnum]>-2000000000) {
				include $dir."/list_main.php";}
			else {
				include $dir."/list_notice.php"; }
			$_skinTime += getmicrotime()-$_skinTimeStart;
			$loop_number--;
		}
	}

// ������ �κ� ����ϴ� �κ�;;
	$_skinTimeStart = getmicrotime();
	include $dir."/list_foot.php";
	$_skinTime += getmicrotime()-$_skinTimeStart;

//yhkim
//	zWriteFile($filename, $str);
	$f = fopen("tmp/useridip-".date("Ym").".txt","a");
	$lock=flock($f,2);
	if($lock) {
/*
$headers = getallheaders();
while (list ($header, $value) = each ($headers)) {
    echo "$header: $value<br />\n";
}
*/

		fwrite($f,"$member[user_id] $member[name] $id $REMOTE_ADDR ".date("Y-m-d H:i:s")."\n");
	}
	flock($f,3);
	fclose($f);
	chmod ("tmp/useridip-".date("Ym").".txt", 0777);

	if($zbLayer) {
		$_skinTimeStart = getmicrotime();
		echo "\n<script>".$zbLayer."\n</script>";
		unset($zbLayer);
		$_skinTime += getmicrotime()-$_skinTimeStart;
	}

	if ($cafe_style != "yes") {
		include "bmnoticemsg.php";
		foot();
	}


/***************************************************************************
 * ������ �κ� include
 **************************************************************************/
	include "_foot.php";
?>