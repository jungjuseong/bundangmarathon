<?php
/***************************************************************************
 * ���� ���� include
 **************************************************************************/
	include "_head_m.php";

/***************************************************************************
 * �Խ��� ���� üũ
 **************************************************************************/

 	$mode= $HTTP_GET_VARS[mode];
	$refer= $HTTP_GET_VARS[refer];
	if($HTTP_HOST !=$refer) error_m("���������� ���� �ۼ��Ͽ� �ֽñ� �ٶ��ϴ�.");
	if(eregi(":\/\/",$dir)) $dir=".";

// ���� üũ
	if(!$mode||$mode=="write") {
		$mode = "write";
		unset($no);
	}

// ������ üũ
	if($mode=="reply"&&$setup[grant_reply]<$member[level]&&!$is_admin) error_m("�������� �����ϴ�[1]");
	elseif($setup[grant_write]<$member[level]&&!$is_admin) error_m("�������� �����ϴ�[2]");
	if($mode=="reply"&&$setup[grant_view]<$member[level]&&!$is_admin) error_m("�������� �����ϴ�[3]");

// ����̳� �����϶� �������� ������;;
	if(($mode=="reply"||$mode=="modify")&&$no) {
		$result=@mysql_query("select * from $t_board"."_$id where no='$no'") or error_m(mysql_error_m());
		unset($data);
		$data=mysql_fetch_array($result);
		if(!$data[no]) error_m("�������� �������� �ʽ��ϴ�");
	}

// ���� ���϶� ���� üũ
	if($mode=="modify"&&$data[ismember]) {
		if($data[ismember]!=$member[no]&&!$is_admin&&$member[level]>$setup[grant_delete]) error_m("�������� �����ϴ�[4]");
	}

// �����ۿ��� ����� �� �޸��� ó��
	if($mode=="reply"&&$data[headnum]<=-2000000000) error_m("�����ۿ��� ����� �޼� �����ϴ�");


// ī�װ� ����Ÿ ������;;
	$category_result=mysql_query("select * from $t_category"."_$id order by no");

// ī�װ� ����Ÿ ���� ����;;
	if($setup[use_category]) {
		$category_kind="<select name=category id=category><option value=''>ī�װ� ����</option>";

		while($category_data=mysql_fetch_array($category_result)) {
			if($data[category]==$category_data[no]) $category_kind.="<option value=$category_data[no] selected>$category_data[name]</option>";
			else $category_kind.="<option value=$category_data[no]>$category_data[name]</option>";
		}

		$category_kind.="</select>";
	}
  if(!$setup[use_category]) { $hide_category_start="<!--"; $hide_category_end="-->"; }

	if($mode=="modify") { $title = " �� �����ϱ� ";}
	elseif($mode=="reply") { $title = " ��� �ޱ� ";}
	else { $title = " �ű� �۾��� ";} 

// ��Ű���� �̿�;;
	$name = $HTTP_SESSION_VARS["zb_writer_name"];
	$email = $HTTP_SESSION_VARS["zb_writer_email"];
	$homepage = $HTTP_SESSION_VARS["zb_writer_homepage"];

/******************************************************************************************
 * �۾��� ��忡 ���� ���� üũ
 *****************************************************************************************/

	if($mode=="modify") {

		// ��б��̰� �н����尡 Ʋ���� �����ڰ� �ƴϸ� ����
		if($data[is_secret]&&!$is_admin&&$data[ismember]!=$member[no]&&$HTTP_SESSION_VARS[zb_s_check]!=$setup[no]."_".$no) error_m("�������� ������� �����ϼ���");

			$name=stripslashes($data[name]); // �̸�
			$email=stripslashes($data[email]); // ����
			$homepage=stripslashes($data[homepage]); // Ȩ������ 
			$subject=$data[subject]=stripslashes($data[subject]); // ����
			$subject=str_replace("\"","&quot;",$subject);
			$homepage=str_replace("\"","&quot;",$homepage);
			$name=str_replace("\"","&quot;",$name);
			$memo=stripslashes($data[memo]); // ����

			if($data[is_secret]) $secret=" checked ";
			if($data[headnum]<=-2000000000) $notice=" checked ";

		// ����϶� ����� ���� ����;;
		} elseif($mode=="reply") {

   			// ��б��̰� �н����尡 Ʋ���� �����ڰ� �ƴϸ� ����
			if($data[is_secret]&&!$is_admin&&$data[ismember]!=$member[no]&&$HTTP_SESSION_VARS[zb_s_check]!=$setup[no]."_".$no) error_m("�������� ������� ����� �ټ���");

			if($data[is_secret]) $secret=" checked ";

			$subject=$data[subject]=stripslashes($data[subject]); // ����
			$subject=str_replace("\"","&quot;",$subject);
			$memo=stripslashes($data[memo]); // ����
			if(!eregi("\[re\]",$subject)) $subject="[re] ".$subject; // ����϶��� �տ� [re] ����;;
			$memo=str_replace("\n","\n>",$memo);
			$memo="\n\n>".$memo."\n";
			$title="$name���� �ۿ� ���� ��۾���";
		}


// ȸ���϶��� �⺻ �Է»��� �Ⱥ��̰�;;
	if($member[no]) { $hide_start="<!--"; $hide_end="-->"; }

// ��б� ���;;
	if(!$setup[use_secret]) { $hide_secret_start="<!--"; $hide_secret_end="-->"; }

// ������� ����ϴ��� ���ϴ��� ǥ��;;
	if((!$is_admin&&$member[level]>$setup[grant_notice])||$mode=="reply") { $hide_notice_start="<!--";$hide_notice_end="-->"; }


// HTML ��� 
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
	include "./skin/write_m.php";
	include "_foot_m.php"; 

?>
