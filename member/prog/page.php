<?
require("./config.php");
require("./function.php");

top("");
	heading("���� ���");

$numresults=mysql_query("select raceid from race");
$numrows=mysql_num_rows($numresults); //�� �Խù��� ���Ѵ�.
$limit=2; // �Խù� ��°���
if($offset=="" || $offset==1){ //$offset ���� �� ���̳� �ƴϸ� 1�̶��
	$offset=(int)1; //$offset ���� 1 �̴�.. (int)�� ���ڿ��� �ƴ϶�°���
	//""���� ������� 1�� ���ڰ����� �˱⶧����..
	$pageing=0; // ���߿� db�� 0���� limit ������ �ҷ��´�.
}
else{
	$pageing=($offset-1)*$limit;
}
$result=mysql_query("select raceid,name from race order by raceday desc limit $pageing,$limit");
//$pageing ���� limit ������ �ҷ���
	while($row=mysql_fetch_array($result)){
		echo "<br> $row[0] : $row[1]";
	}
	mysql_free_result($result);
	echo "<br><br>\n";

$num=5; //[1][2]�� ����
if($offset-$num>0){ //���� ��ư �ڵ�
$prev=$offset-$num;
echo "<a href=\"$PHP_SELP?offset=$prev&go=$board\"><font size=2 color=0099FF>[prev]...</font></a>\n";
}

$k=intval($offset/$num); //���� ���� ������ ����غ�����..!!
if($offset%$num) {
	$k++;
}
$k=($k*$num)-($num-1);
$until=$k+$num;
$pages=intval($numrows/$limit); //�������� ���������� ���Ѵ�.
if ($numrows%$limit){
	$pages++; //������ ������ ���Ѵ�.
}
if ($until>$pages) $until=$pages+1; //������������ �ϰ�� [1][2] ���̻� ���� ���ϰ��ϱ� ���ؼ�
//until=$pages+1 �� �ؿ� for �������� .. ����¡�� ��Ʊ⶧���� �� ������ ���ž� �˴ϴ�.

for($k;$k < $until ;$k++){ //for ������ [1] [2] ������ ����
	if ($offset!=$k){ //�ҷ��� �������� ������ <a> ��ũ ��������
		echo "<a href=\"$PHP_SELF?offset=$k&go=$board\">";
	}
	echo"<font size=2>[$k]</font>";
	if ($offset!=$k){
		echo "</a>";
	}
	echo" ";
}
if($pages!=1) //���������� �ִٸ�.. [Next] ��ư ����
{
	if($until-1!==$pages) // ������ ������ ���� ��ü ������ ���� Ʋ���ٸ� ���� ��ư ����
	{
		$nextoffset=$until;
		echo " <a href=$PHP_SELF?offset=$nextoffset&go=$board><font size=2 color=0099FF>...[Next]</font></a>";
	}
}
?>