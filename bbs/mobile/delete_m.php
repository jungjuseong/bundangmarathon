<?
/***************************************************************************
 * ���� ���� include
 **************************************************************************/
	include "_head_m.php";

	if(!eregi($HTTP_HOST,$HTTP_REFERER)) error_m("���������� ���� �����Ͽ� �ֽñ� �ٶ��ϴ�.");

/***************************************************************************
 * �Խù� ���� ó��
 **************************************************************************/

// �������� ������
	$s_data=mysql_fetch_array(mysql_query("select * from $t_board"."_$id where no='$no'"));

	if($s_data[ismember]||$is_admin||$member[level]<=$setup[grant_delete]) {
		if($s_data[ismember]!=$member[no]&&!$is_admin&&$member[level]>$setup[grant_delete]) error_m("������ ������ �����ϴ�");
		$title="���� �����Ͻðڽ��ϱ�?";
  	} else {
		$title=stripslashes($s_data[name])."���� ���� �����մϴ�.<br> ��й�ȣ�� �Է��Ͽ� �ֽʽÿ�";
		$input_password="<input type=password name=password id='password' size=20 maxlength=20 value=''>";
	}

	$target="delete_ok_m.php";
    echo('
    <html>
    <head>
    <title>���κ��� �����</title>
    <meta name="description" content="���κ���, �����, �д縶����Ŭ��">
    <meta name="keywords" content="���κ���, �����, �д縶����Ŭ��">
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
	include "./skin/ask_password_m.php";
	include "_foot_m.php";
?>
