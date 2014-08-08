<?
 $_zb_path="../";

 include "../lib.php";

 $connect=dbconn();

 $member=member_info();

//if(!$member[no]||$member[is_admin]>1||$member[level]>1) Error("최고 관리자만이 사용할수 있습니다");

 	$table_name_result=mysql_query("select name, use_alllist, title from $admin_table where name in ('memboard', 'pubboard', 'photo') order by title",$connect) or error(mysql_error());

 head(" bgcolor=white");
?>

<?
echo "<form action='$PHP_SELF' method=post>
연도: <input type=text name=year value=$year>
<input type=submit value='조회'>
</form>";
if($year=="")
	$year="2005";
	
$sum = array();

$table_name=array("zetyx_board_memboard", "zetyx_board_pubboard", "zetyx_board_photo");
$table_comment_name=array("zetyx_board_comment_memboard", "zetyx_board_comment_pubboard", "zetyx_board_comment_photo");

$clubmemresult=mysql_query("select no,user_id,name from zetyx_member_table where level < 9 order by name",$connect) or error(mysql_error());
$date1=mktime(0,0,0,1,1,$year);
$date2=mktime(0,0,0,12,31,$year);
echo date("Ymd")." 연도=".$year."[".date("Ymd",$date1)." ~ ".date("Ymd",$date2)."]<br>";
echo "<table border=1><tr><td>name<td>memboard<td>pubboard<td>photo<td>comment_memboard<td>comment_pubboard<td>comment_photo<td>sum";
while($clubmember=mysql_fetch_array($clubmemresult))
{
echo "<tr><td>".$clubmember[name]."[".$clubmember[no]."]";
 for($i=0; $i < 3; $i++)
 {
   $result=mysql_query("select count(*) from $table_name[$i] where ismember='$clubmember[no]' and reg_date >= $date1 and reg_date <= $date2", $connect) or error(mysql_error());
   $cnt=mysql_fetch_array($result);
   $sum[$clubmember[name]] += $cnt[0]*10;
echo "<td>".$cnt[0];
   mysql_free_result($result);
 }
 for($i=0; $i < 3; $i++)
 {
   $result=mysql_query("select count(*) from $table_comment_name[$i] where ismember='$clubmember[no]' and reg_date >= $date1 and reg_date <= $date2", $connect) or error(mysql_error());
   $cnt=mysql_fetch_array($result);
   $sum[$clubmember[name]] += $cnt[0];
echo "<td>".$cnt[0];
   mysql_free_result($result);
 }
 echo "<td>".$sum[$clubmember[name]]."<br>\n";
 flush();
}
echo "</table>";
 mysql_close($connect);
 $connect="";

  foot();
?>
