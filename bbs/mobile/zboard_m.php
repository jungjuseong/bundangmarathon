<?

/***************************************************************************
 * 공통 파일 include
 **************************************************************************/
	include "_head_m.php";


/***************************************************************************
 * 게시판 설정 체크
 **************************************************************************/

// 사용권한 체크
	if($setup[grant_list]<$member[level] && !$is_admin) error_m("사용권한이 없습니다");

// 검색조건이 있을때 : 상황 -> 카테고리 선택, Use_Showreply 사용, 또는 검색어로 검색을 할때
	if($s_que) {
		$que="select * from $t_board"."_$id $s_que order by $select_arrange $desc limit $start_num, $page_num";
		$result=mysql_query($que,$connect);
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

		// 검색조건은 없지만 정렬값이 생길때;;; //////////////////////////////
		else {
			$que="select * from $t_board"."_$id $s_que order by $select_arrange $desc $add_on limit $start_num, $page_num";
			$result=mysql_query($que,$connect);
		}
	}

// 관리자일때는 게시판 글 옮기기때문에 게시판 리스트를 뽑아옴;;
	if($is_admin) {
		$board_result=mysql_query("select no,name from $admin_table where no!='$setup[no]'");
	}


/***************************************************************************
 * 스킨에서 사용할 페이지 정리
 **************************************************************************/

	$print_page="";
	$show_page_num=$setup[page_num]; // 한번에 보일 페이지 갯수
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
		$a_prev_page="<a href='$PHP_SELF?id=$id&page=$prev_page&select_arrange=$select_arrange&desc=$desc&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&sn1=$sn1&divpage=$divpage'  rel='external'>[이전 $setup[page_num] 개]</a>";
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
		$a_next_page="<a href='$PHP_SELF?id=$id&page=$next_page&select_arrange=$select_arrange&desc=$desc&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&sn1=$sn1&divpage=$divpage' rel='external'>[다음 $setup[page_num] 개]</a>";
		$print_page.="<font style=font-size:14pt>..<a href='$PHP_SELF?id=$id&page=$total_page&select_arrange=$select_arrange&desc=$desc&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&sn1=$sn1&divpage=$divpage' rel='external'><font style=font-size:14pt>$total_page</a>";
		$next_page_exists = true;
	}

	// 검색시 Divsion 페이지 이동 표시
	if($use_division) {
		if($prevdivpage&&!$prev_page_exists) $a_div_prev_page="<a href='$PHP_SELF?id=$id&&select_arrange=$select_arrange&desc=$desc&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&sn1=$sn1&divpage=$prevdivpage' rel='external'>이전 검색</a>...";
		if($nextdivpage&&!$next_page_exists) $a_div_next_page="...<a href='$PHP_SELF?id=$id&&select_arrange=$select_arrange&desc=$desc&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&sn1=$sn1&divpage=$nextdivpage' rel='external'>계속 검색</a>";
		$print_page = $a_div_prev_page.$print_page.$a_div_next_page;

	}


/***************************************************************************
 * 각종 링크를 미리 지정하는 부분 
 **************************************************************************/

// 글쓰기버튼
	if($is_admin||$member[level]<=$setup[grant_write]) $a_write="<a href='write_m.php?$href$sort&no=$no&mode=write&sn1=$sn1&divpage=$divpage&refer=".urlencode($HTTP_HOST)."' data-role='button' rel='external'  data-theme='a' class='backgroundStyle ui-btn-right' data-icon='plus'>글쓰기</a>"; else $a_write="";

// 목록 버튼
	if($is_admin||$member[level]<=$setup[grant_list]) $a_list="<a href='$PHP_SELF?id=$id&page=$page&category=$category&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&prev_no=$no&sn1=$sn1&divpage=$divpage'>목록</a> "; else $a_list="";

// 취소버튼
	$a_cancel="<a href='$PHP_SELF?id=$id'>";

/***************************************************************************
 * 정리한 데이타를 출력하는 부분 
 **************************************************************************/

// 헤더 출력
echo('
<html>
<head>
<title>제로보드 모바일</title>
<meta name="description" content="제로보드, 모바일, 분당마라톤클럽">
<meta name="keywords" content="제로보드, 모바일, 분당마라톤클럽">
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
// 상단 현황 부분 출력 
	include "./skin/setup_m.php";

// 현재 선택된 데이타가 있을때, 즉 $no 가 있을때 데이타 가져옴
	if($no&&$setup[use_alllist]) {
		$_view_included = true;
		include "view_m.php";
	}

// 리스트의 상단 부분 출력
	include "./skin/list_head_m.php";

//가상번호를 정함
	$loop_number=$total-($page-1)*$page_num;
	if($setup[use_alllist]&&!$prev_no) $prev_no=$no;

// 뽑혀진 데이타만큼 출력함
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

// 마무리 부분 출력하는 부분;;
	include "./skin/list_foot_m.php";

/***************************************************************************
 * 마무리 부분 include
 **************************************************************************/
	include "_foot_m.php";
?>
