<?
/*///////////////////////////////////////////////////////////////

	프로그램명	: rss_generator.php
	버전		: 1.0
	작성자		: 바람돌이
	최초작성일	: 2006.05.26

	*** 설명 ***

	제로보드를 RSS 서비스로 제공하는 패치

	1. RSS 2.0 Specification 지원

	*** 변경 할 부분 ***
	$_zb_url		: 제로보드 주소
	$max_count		: RSS를 제공할 컨텐츠 개수
	$webMaster		: 관리자 메일주소
	
	$title 			: RSS 읽었을때 Title입니다. 뒤에 게시판 이름이 추가됩니다.
	$des			: 해당 게시판의 설명이 들어갑니다.

	자신에게 맞게 사용하세요. 

	* 사용방법
	두 파일을 제로보드 폴더내에 복사하신뒤 rss.php 에서 설정해주실 부분만 수정하시면 됩니다.
	그리고 "http://도메인/제로보드폴더/rss.php?id=게시판주소" 공개하시면 됩니다.

	* 주의 사항
	아직 시간이 없어서 비밀글등의 관리는 하지 않았습니다.
	단순히 무식하게 게시판의 글을 순서대로 읽어오기에 주의해야 합니다.

	제가 나중에 더 좋게 수정해서 올릴 수도 있지만, 누구나 수정해서 올려주시면 감사하겠습니다.

/////////////////////////////////////////////////////////////////*/

	require "./RSSWriter.class.php";
	include "_head.php";
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	// Administrator가 직접 작성해야 하는 부분입니다.
	//
	/////////////////////////////////////////////////////////////////////////////////////////////////////
	$_zb_url = "http://www.bundangmarathon.com/bbs/";	// 제로보드 주소입니다.
	$max_count = 2;					// 최대 몇개의 게시물을 읽어올지 결정합니다.
	$webMaster = "jungjuseong@gmail.com";		// 관리자 메일입니다.	
	
	$title 		= "[분당마라톤클럽] - ";		// RSS 읽었을때 Title입니다. 뒤에 게시판 이름이 추가됩니다.
	$des		= "$id 게시판입니다.";		// 해당 게시판의 설명이 들어갑니다.
	//////////   --- 여기까지 --- //////////////////////
	
	$sql = "select * from $admin_table where name='$id'";
	$result = mysql_query($sql,$connect) or die ("SQL Error : ". mysql_error());
	
	while($row = mysql_fetch_array($result)){
		$title = $title.$row[name];
		$link_root  = $_zb_url."zboard.php?id=$id";
	}
	
	// RSS 출력
	$rss = new RSSWriter($title,$link_root,$des);
	$rss->setLanguage("ko-KO");
	$rss->setLastBuildDate(date("Y/m/d H:i:s"));
	$rss->setWebMaster($webMaster);

	$sql = "select * from $t_board"."_$id order by no desc";
	$result = mysql_query($sql,$connect) or die ("SQL Error : ". mysql_error());

	$count = 0;
	while($row = mysql_fetch_array($result)){
		$link = sprintf("$link_root&no=%d" , $row[no]);

		// 카테고리 명을 받아옵니다.
		$sql1 = "select name from $t_category"."_$id where no = $row[category]";
		$result1 = mysql_query($sql1,$connect) or die ("SQL Error : ". mysql_error());
		
		$cate = mysql_fetch_array($result1);	
	
		// 만약 자료 파일이 있다면 같이 링크합니다.
		if ($row[file_name1])	{
			$file1 = "file link 1 : <a href=$_zb_url$row[file_name1] target=_blank> $row[s_file_name1]</a><br>";
		}
		if ($row[file_name2])
			$file2 = "file link 2 : <a href=$_zb_url$row[file_name2] target=_blank> $row[s_file_name2]</a><br>";

		$description = $file1.$file2.$row[memo];
		// rss의 setItem 인자들
		//	$title,$link,$description ="",$author = "",$pubDate ="",$category ="",
		//			$guid ="",$source ="",$comments ="",$enclosure =""
		$rss->setItem($row[subject],$link,$description,$row[name],date("Y/m/d H:i:s",$row[reg_date]),$cate[name]);
		if ($count++ > $max_count)
			break;
	}
	
	$rss->println();
	
	mysql_close($connect);
?>
