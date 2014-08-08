<?
if(date("Y-m-d") <= "2004-10-02"){
	$temp=mysql_fetch_array(mysql_query("select count(*) from poll where userid='$member[user_id]'",$connect));
	if($temp[0] ==0)
	{
		echo "<script>alert('유니폼 디자인 선정 설문에 응해 주시기 바랍니다.')</script>\n";
	}
}
?>
