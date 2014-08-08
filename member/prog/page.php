<?
require("./config.php");
require("./function.php");

top("");
	heading("설문 목록");

$numresults=mysql_query("select raceid from race");
$numrows=mysql_num_rows($numresults); //총 게시물을 구한다.
$limit=2; // 게시물 출력갯수
if($offset=="" || $offset==1){ //$offset 값이 널 값이나 아니면 1이라면
	$offset=(int)1; //$offset 값은 1 이다.. (int)는 문자열이 아니라는것을
	//""값이 왔을경우 1을 문자값으로 알기때문에..
	$pageing=0; // 나중에 db에 0부터 limit 값까지 불러온다.
}
else{
	$pageing=($offset-1)*$limit;
}
$result=mysql_query("select raceid,name from race order by raceday desc limit $pageing,$limit");
//$pageing 부터 limit 값까지 불러옴
	while($row=mysql_fetch_array($result)){
		echo "<br> $row[0] : $row[1]";
	}
	mysql_free_result($result);
	echo "<br><br>\n";

$num=5; //[1][2]의 갯수
if($offset-$num>0){ //이전 버튼 코딩
$prev=$offset-$num;
echo "<a href=\"$PHP_SELP?offset=$prev&go=$board\"><font size=2 color=0099FF>[prev]...</font></a>\n";
}

$k=intval($offset/$num); //여러 값을 대입해 산수해보세요..!!
if($offset%$num) {
	$k++;
}
$k=($k*$num)-($num-1);
$until=$k+$num;
$pages=intval($numrows/$limit); //나눗샘의 정수값만을 취한다.
if ($numrows%$limit){
	$pages++; //페이지 갯수를 구한다.
}
if ($until>$pages) $until=$pages+1; //마지막페이지 일경우 [1][2] 더이상 생성 못하게하기 위해서
//until=$pages+1 는 밑에 for 문때문에 .. 페이징은 어렵기때문에 잘 생각해 보셔야 됩니다.

for($k;$k < $until ;$k++){ //for 문으로 [1] [2] 페이지 생성
	if ($offset!=$k){ //불러진 페이지와 같으면 <a> 링크 생성안함
		echo "<a href=\"$PHP_SELF?offset=$k&go=$board\">";
	}
	echo"<font size=2>[$k]</font>";
	if ($offset!=$k){
		echo "</a>";
	}
	echo" ";
}
if($pages!=1) //페이지값이 있다면.. [Next] 버튼 생성
{
	if($until-1!==$pages) // 마지막 페이지 값이 전체 페이지 값과 틀리다면 다음 버튼 생성
	{
		$nextoffset=$until;
		echo " <a href=$PHP_SELF?offset=$nextoffset&go=$board><font size=2 color=0099FF>...[Next]</font></a>";
	}
}
?>