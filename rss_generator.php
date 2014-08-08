<?
// 
//  RSS 2.0 Generator for Zeroboard 
// 
//  version: 1.0
//  author: Han, Keunhee(benant@hanmir.com)
//  date: 2003-12-23
// 
//  Install
// 
//  1) Open "_head.php" file 
//  2) Insert next string on line 19 ($_zb_file_list)
//     ,"rss_generator.php"
// 

	header("Content-type: text/xml");

	include "_head.php";

	$url = $_SERVER['SERVER_NAME'];
	if(ereg("id=",$PHP_SELF)) $thisUrl = $url.ereg_replace("rss_generator.php","zboard.php",$PHP_SELF);
	else $thisUrl = $url.ereg_replace("rss_generator.php","zboard.php",$PHP_SELF)."?id=".$id;
	$blogLink = $imageLink = htmlspecialchars( "http://".$thisUrl );

	if(!$setup[title]) $setup[title] = $blogLink;
	$blogTitle = $imageTitle = $title_str = htmlspecialchars($setup[title]);

	//xml 파일 내용
	$contents = "<?xml version=\"1.0\" encoding=\"euc-kr\" ?>
<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\" xmlns:sy=\"http://purl.org/rss/1.0/modules/syndication/\" xmlns:admin=\"http://webns.net/mvcb/\" xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\">
<channel>
	<title>$blogTitle</title>
	<link>$blogLink</link>
	<description>$blogDescription</description>
	<dc:language>kr</dc:language>
	<dc:creator>$blogCreator</dc:creator>
	<dc:rights>$blogRight</dc:rights>
	<image>
		<title>$imageTitle</title>
		<url>$imageAddress</url>
		<link>$imageLink</link>
		<width>$imageWidth</width>
		<height>$imageHeight</height>
		<description>$imageDescription</description>
	</image>";


		// 목록이 공개된 게시판인지 확인
		if($setup[grant_list] == 10) {

			// 포스트 추출

			$query = "select * from zetyx_board_$id where arrangenum=0 and is_secret=0 and headnum<0 order by headnum, arrangenum ";

			$result = mysql_query($query,$connect) or Error(mysql_error());

			//가상번호를 정함
			$loop_number=$total-($page-1)*$page_num;
			if($setup[use_alllist]&&!$prev_no) $prev_no=$no;

			while($data=@mysql_fetch_array($result)) {



				// 포스트 
				$postTitle = htmlspecialchars(stripslashes( $data[subject] ));
				if($setup[use_alllist]) $view_file="zboard.php"; else $view_file="view.php";
				$path = ereg_replace("rss_generator.php",$view_file,$_SERVER['PHP_SELF'])."?id=".$id;
				// 내용보기가 공개되 있는지 확인
				if($setup[grant_view] == 10) {
					$postLink=htmlspecialchars( "http://".$url.$path."&no=".$data[no] ); 
					$postDescription = htmlspecialchars( cut_str(nl2br(ereg_replace("&nbsp;"," ",strip_tags($data[memo]))), 200));
				} else {
					$postDescription = htmlspecialchars( "공개글이 아닙니다. \n홈페이지로 접속후 로그인하고 내용을 보셔야 합니다." );
				}
				$postCreator = htmlspecialchars($data[name]);
				$postDate = date("r",$data[reg_date]);	//All date-times in RSS conform to the Date and Time Specification of RFC 822, with the exception that the year may be expressed with two characters or four characters (four preferred).

				$contents .= "
			<item>
				<title>$postTitle</title>
				<link>$postLink</link>
				<description>$postDescription</description>
				<dc:subject>$postSubject</dc:subject>
				<dc:creator>$postCreator</dc:creator>
				<dc:date>$postDate</dc:date>
			</item>";

				$loop_number--;

			}

		}

		$contents .= "
	</channel>
</rss>
	";

/***************************************************************************
 * XML 출력
 **************************************************************************/
	echo $contents;
?>


