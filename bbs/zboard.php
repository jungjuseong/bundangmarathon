<?
/***************************************************************************
 * 공통 파일 include
 **************************************************************************/
include "_head.php";

/***************************************************************************
 * 게시판 설정 체크
 **************************************************************************/
// 사용권한 체크

if($setup[grant_list]<$member[level] && !$is_admin) Error("사용권한이 없습니다","login.php?id=$id&no=$no&page=$page&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&s_url=".urlencode($REQUEST_URI));

// 검색조건이 있을때 : 상황 -> 카테고리 선택, Use_Showreply 사용, 또는 검색어로 검색을 할때
if($s_que) {
	$_dbTimeStart = getmicrotime();
	$que="select * from $t_board"."_$id $s_que order by $select_arrange $desc limit $start_num, $page_num";
	$result=mysql_query($que,$connect) or Error(mysql_error());
	$_dbTime += getmicrotime()-$_dbTimeStart;
}

// 검색 조건이 없을때 : 상황 -> 일반 정렬, 또는 정렬기준을 가지거나 Desc, Asc 일때.
else {

	// 검색조건이 없고 정렬이 headnum에 의한 것일때;; 즉 일반 정렬일때;;
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
// 검색조건은 없지만 정렬값이 생길때;;; //////////////////////////////
else {
		$que="select * from $t_board"."_$id $s_que order by $select_arrange $desc $add_on limit $start_num, $page_num";
		$_dbTimeStart = getmicrotime();
		$result=mysql_query($que,$connect) or Error(mysql_error());
		$_dbTime += getmicrotime()-$_dbTimeStart;
	}
}

// 관리자일때는 게시판 글 옮기기때문에 게시판 리스트를 뽑아옴;;
if($is_admin) {
	$_dbTimeStart = getmicrotime();
	$board_result=mysql_query("select no,name from $admin_table where no!='$setup[no]'");
	$_dbTime += getmicrotime()-$_dbTimeStart;
}

/***************************************************************************
 * 스킨에서 사용할 페이지 정리
 **************************************************************************/

$print_page="";
$show_page_num=$setup[page_num]; // 한번에 보일 페이지 갯수
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

// 검색시 Divsion 페이지 이동 표시
if($use_division) {
	if($prevdivpage&&!$prev_page_exists) 
		$a_div_prev_page="<a onfocus=blur() href='$PHP_SELF?cafe_style=$cafe_style&id=$id&&select_arrange=$select_arrange&desc=$desc&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&sn1=$sn1&divpage=$prevdivpage'>[이전 검색]</a>...";
	if($nextdivpage&&!$next_page_exists) 
		$a_div_next_page="...<a onfocus=blur() href='$PHP_SELF?cafe_style=$cafe_style&id=$id&&select_arrange=$select_arrange&desc=$desc&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&sn1=$sn1&divpage=$nextdivpage'>[계속 검색]</a>";
	$print_page = $a_div_prev_page.$print_page.$a_div_next_page;

}


/***************************************************************************
 * 각종 링크를 미리 지정하는 부분
 **************************************************************************/
function call_zboard($order_type)
{
	global $PHP_SELF, $href, $t_desc, $cafe_style;;
	if ($cafe_style == "yes") 
		return "<a onfocus=blur() href='$PHP_SELF?$href&cafe_style=yes&select_arrange=$order_type&desc=$t_desc'>";
	else
		return "<a onfocus=blur() href='$PHP_SELF?$href&select_arrange=$order_type&desc=$t_desc'>";
}

// 글쓰기버튼
/* write.php --> write_bmc.php */
	if($is_admin||$member[level]<=$setup[grant_write]) 
		$a_write="<a onfocus=blur() href='write_bmc.php?$href$sort&no=$no&mode=write&sn1=$sn1&divpage=$divpage'>"; else $a_write="<Zeroboard ";

// 목록 버튼
	if($is_admin||$member[level]<=$setup[grant_list]) 
		$a_list="<a onfocus=blur() href='$PHP_SELF?cafe_style=$cafe_style&id=$id&page=$page&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&prev_no=$no&sn1=$sn1&divpage=$divpage'>"; else $a_list="<Zeroboard ";

// 취소버튼
	$a_cancel="<a onfocus=blur() href='$PHP_SELF?cafe_style=$cafe_style&id=$id'>";


// 정렬 버튼의 경우 $desc를 역으로 변환
	if($desc=="desc") $t_desc="asc"; else $t_desc="desc";
// 번호 정렬
	$a_no=call_zboard("headnum");
// 제목 정렬
	$a_subject=call_zboard("subject");
// 이름 정렬
	$a_name=call_zboard("name");
// 조회순 정렬
	$a_hit=call_zboard("hit");
// 추천수 정렬
	$a_vote=call_zboard("vote");
// 날자별 정렬
	$a_date=call_zboard("reg_date");
// 첫번째 항목의 다운로드 순서
	$a_download1=call_zboard("download1");
// 두번째 항목의 다운로드 순서
	$a_download2=call_zboard("download2");

/***************************************************************************
 * 정리한 데이타를 출력하는 부분
 **************************************************************************/

// 헤더 출력
	$_skinTimeStart = getmicrotime();

	head('',"script_list.php");

// 상단 현황 부분 출력
	include "$dir/setup.php";
	$_skinTime += getmicrotime()-$_skinTimeStart;

// 현재 선택된 데이타가 있을때, 즉 $no 가 있을때 데이타 가져옴
	if($no&&$setup[use_alllist]) {
		$_view_included = true;
		include "view.php";
	}

// 리스트의 상단 부분 출력
	$_skinTimeStart = getmicrotime();
	include $dir."/list_head.php";
	$_skinTime += getmicrotime()-$_skinTimeStart;

//가상번호를 정함
	$loop_number=$total-($page-1)*$page_num;
	if($setup[use_alllist]&&!$prev_no) $prev_no=$no;

// 뽑혀진 데이타만큼 출력함
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

// 마무리 부분 출력하는 부분;;
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
 * 마무리 부분 include
 **************************************************************************/
	include "_foot.php";
?>
