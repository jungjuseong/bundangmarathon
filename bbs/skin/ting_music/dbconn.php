<?
$host_name="localhost";
$user_name="coretek";  //������ӽ� ����ϴ� ���� ���̵� �ػ����� ��ø� ��ġ������ �о��ֽʽÿ�.
$db_name="coretek";  // db�̸� �ػ����� ��ø� ��ġ������ �о��ֽʽÿ�.
$db_password="qnsekddkwk9"; // db ��� �ػ����� ��ø� ��ġ������ �о��ֽʽÿ�.
$zero_path="http://www.bundangmarathon.com/bbs/"; // �����ξƴ�!���κ��� URL ���� /�� ���̼���. �ػ����� ��ø� ��ġ������ �о��ֽʽÿ�.
$connect=mysql_connect($host_name,$user_name,$db_password);
mysql_select_db($db_name, $connect);
?>
