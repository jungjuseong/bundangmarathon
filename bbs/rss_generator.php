<?
/*///////////////////////////////////////////////////////////////

	���α׷���	: rss_generator.php
	����		: 1.0
	�ۼ���		: �ٶ�����
	�����ۼ���	: 2006.05.26

	*** ���� ***

	���κ��带 RSS ���񽺷� �����ϴ� ��ġ

	1. RSS 2.0 Specification ����

	*** ���� �� �κ� ***
	$_zb_url		: ���κ��� �ּ�
	$max_count		: RSS�� ������ ������ ����
	$webMaster		: ������ �����ּ�
	
	$title 			: RSS �о����� Title�Դϴ�. �ڿ� �Խ��� �̸��� �߰��˴ϴ�.
	$des			: �ش� �Խ����� ������ ���ϴ�.

	�ڽſ��� �°� ����ϼ���. 

	* �����
	�� ������ ���κ��� �������� �����Ͻŵ� rss.php ���� �������ֽ� �κи� �����Ͻø� �˴ϴ�.
	�׸��� "http://������/���κ�������/rss.php?id=�Խ����ּ�" �����Ͻø� �˴ϴ�.

	* ���� ����
	���� �ð��� ��� ��б۵��� ������ ���� �ʾҽ��ϴ�.
	�ܼ��� �����ϰ� �Խ����� ���� ������� �о���⿡ �����ؾ� �մϴ�.

	���� ���߿� �� ���� �����ؼ� �ø� ���� ������, ������ �����ؼ� �÷��ֽø� �����ϰڽ��ϴ�.

/////////////////////////////////////////////////////////////////*/

	require "./RSSWriter.class.php";
	include "_head.php";
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	// Administrator�� ���� �ۼ��ؾ� �ϴ� �κ��Դϴ�.
	//
	/////////////////////////////////////////////////////////////////////////////////////////////////////
	$_zb_url = "http://www.bundangmarathon.com/bbs/";	// ���κ��� �ּ��Դϴ�.
	$max_count = 2;					// �ִ� ��� �Խù��� �о���� �����մϴ�.
	$webMaster = "jungjuseong@gmail.com";		// ������ �����Դϴ�.	
	
	$title 		= "[�д縶����Ŭ��] - ";		// RSS �о����� Title�Դϴ�. �ڿ� �Խ��� �̸��� �߰��˴ϴ�.
	$des		= "$id �Խ����Դϴ�.";		// �ش� �Խ����� ������ ���ϴ�.
	//////////   --- ������� --- //////////////////////
	
	$sql = "select * from $admin_table where name='$id'";
	$result = mysql_query($sql,$connect) or die ("SQL Error : ". mysql_error());
	
	while($row = mysql_fetch_array($result)){
		$title = $title.$row[name];
		$link_root  = $_zb_url."zboard.php?id=$id";
	}
	
	// RSS ���
	$rss = new RSSWriter($title,$link_root,$des);
	$rss->setLanguage("ko-KO");
	$rss->setLastBuildDate(date("Y/m/d H:i:s"));
	$rss->setWebMaster($webMaster);

	$sql = "select * from $t_board"."_$id order by no desc";
	$result = mysql_query($sql,$connect) or die ("SQL Error : ". mysql_error());

	$count = 0;
	while($row = mysql_fetch_array($result)){
		$link = sprintf("$link_root&no=%d" , $row[no]);

		// ī�װ� ���� �޾ƿɴϴ�.
		$sql1 = "select name from $t_category"."_$id where no = $row[category]";
		$result1 = mysql_query($sql1,$connect) or die ("SQL Error : ". mysql_error());
		
		$cate = mysql_fetch_array($result1);	
	
		// ���� �ڷ� ������ �ִٸ� ���� ��ũ�մϴ�.
		if ($row[file_name1])	{
			$file1 = "file link 1 : <a href=$_zb_url$row[file_name1] target=_blank> $row[s_file_name1]</a><br>";
		}
		if ($row[file_name2])
			$file2 = "file link 2 : <a href=$_zb_url$row[file_name2] target=_blank> $row[s_file_name2]</a><br>";

		$description = $file1.$file2.$row[memo];
		// rss�� setItem ���ڵ�
		//	$title,$link,$description ="",$author = "",$pubDate ="",$category ="",
		//			$guid ="",$source ="",$comments ="",$enclosure =""
		$rss->setItem($row[subject],$link,$description,$row[name],date("Y/m/d H:i:s",$row[reg_date]),$cate[name]);
		if ($count++ > $max_count)
			break;
	}
	
	$rss->println();
	
	mysql_close($connect);
?>
