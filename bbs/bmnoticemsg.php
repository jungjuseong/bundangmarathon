<?
if(date("Y-m-d") <= "2004-10-02"){
	$temp=mysql_fetch_array(mysql_query("select count(*) from poll where userid='$member[user_id]'",$connect));
	if($temp[0] ==0)
	{
		echo "<script>alert('������ ������ ���� ������ ���� �ֽñ� �ٶ��ϴ�.')</script>\n";
	}
}
?>
