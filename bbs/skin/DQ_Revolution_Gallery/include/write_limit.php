<?
if($mode != "modify") {
	$_limit_pass = false;

  // ���������� ȣ���Ѱ� �ƴҶ� ����ó��
	if($skin_setup[config_id]!= $id) {
	  // ���� ���� ȸ������
		$upLimit_Pass_Level = 5;

	  // �����ڴ� ���Ѿ���
		$admin_upLimit_Pass = 0;

	  // ���� ����
		$using_writeLimit = true;
		$upload_limit1 = 60*24; //���� ���ѽð�, �Ϸ�
		$upload_limit2 = 2; //���� ����
		$upload_limit3 = 10; //���� �㰡�ð�,10�� �ȿ��� ���� �Ұ�
	}
	else {
	  // ��Ų���� ������ ª�� �ٽ� ����
		$using_writeLimit   = &$skin_setup[using_writeLimit];
		$upLimit_Pass_Level = &$skin_setup[upLimit_Pass_Level];
		$admin_upLimit_Pass = &$skin_setup[admin_upLimit_Pass];
		$upload_limit1 = &$skin_setup[upload_limit1];
		$upload_limit2 = &$skin_setup[upload_limit2];
		$upload_limit3 = &$skin_setup[upload_limit3];
	}

  // ���� ������ �ְ� ȸ���� �ƴ϶�� ����
	if(!$member[no] && $using_writeLimit) error ("\"�Խù� ��� ����\"�� �����Ǿ� �ֽ��ϴ�.<br><br>��ȸ���� ���ε� �Ͻ� �� �����ϴ�.");

  // �н��Ҽ� �ִ� ȸ�� �������� �˻�
	if($member[level] <= $upLimit_Pass_Level) $_limit_pass = true;
  // �������� �н� ������ �˻�
	if($is_admin && $admin_upLimit_Pass) $_limit_pass = true;

  // �н��Ҽ� �ִ� ������ ����, �� ���� ��尡 �ƴ϶�� ������� ó��
	if($using_writeLimit && !$_limit_pass) {

	  // ���� *���� �˾ƺ��� ���� ������ ����
		$_text1 = $upload_limit1."��";
		if($upload_limit1 >= 60)       $_text1 = ceil($upload_limit1 / 60)."�ð�";
		if($upload_limit1 >= 60*24)    $_text1 = ceil($upload_limit1 / (60*24))."��";
		if($upload_limit1 >= 60*24*7)  $_text1 = ceil($upload_limit1 / (60*24))."����";
		if($upload_limit1 >= 60*24*30) $_text1 = ceil($upload_limit1 / (60*24))."����";

	  // �� ������ ������ ���� 60�ʸ� ���ؼ� ������ �������
		$time1 = time() - ($upload_limit1*60);
		$time3 = time() - ($upload_limit3*60);

	  // ���ε� Ƚ������ �˻�
		if($upload_limit1 >= 1440) {
			$day  = date("Ymd",(time() - (86400*($upload_limit1/1440))));
			$day_limit = $upload_limit2 -1;
			$_write = mysql_num_rows(mysql_query("select no from zetyx_board_$id where from_unixtime(reg_date,'%Y%m%d')>'$day' and ismember='$member[no]' order by reg_date desc"));
			if($_write >= $upload_limit2) error ("������ Ƚ���� �ʰ� �Ͽ����ϴ�.<br>$_text1"."�� $upload_limit2"."ȸ ������ �Ҽ� �ֽ��ϴ�.");
		} else {
			$_write = mysql_num_rows(mysql_query("select no from zetyx_board_$id where reg_date>$time1 and ismember='$member[no]'"));
			if($_write >= $upload_limit2) error ("������ Ƚ���� �ʰ� �Ͽ����ϴ�.<br>$_text1"."�� $upload_limit2"."ȸ ������ �Ҽ� �ֽ��ϴ�.");
		}

	  // ���� �ð����� �˻� 
		$_write = mysql_fetch_array(mysql_query("select reg_date from zetyx_board_$id where reg_date>$time3 and ismember='$member[no]'"));
		if(count($_write)>1) {
			$_text2 = $upload_limit3 - date("i",time()-$_write[0]);
			Error("������ �� <b>$upload_limit3"."��</b>�� ������ ���� �Խù��� ������ �Ҽ� �ֽ��ϴ�.<br><br>���� �����ð�: ".date("Y-m-d H:i:s",time())."<br>���� ��Ͻð�: ".date("Y-m-d H:i:s",$_write[0])."<br><br><b>$_text2"."�� �Ŀ� ������ �Ͻ� �� �ֽ��ϴ�.</b>");
		}

	} //�н�
} // $mode != "modify"
?>