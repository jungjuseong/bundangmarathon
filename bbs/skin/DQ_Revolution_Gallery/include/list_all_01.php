<?
	//������� �����͸� ������
	if($selected[$i]) $m_data=mysql_fetch_array(mysql_query("select * from dq_revolution where zb_id='$id' and zb_no='$selected[$i]'"));

	if($m_data[no]) {
	  $tmp_files  = explode(",",$m_data[file_names]);
	  $tmp_sfiles = explode(",",$m_data[s_file_names]);

	  //������� ���ϻ���
	  if($tmp_files) {
		for($mImg_count=0; $mImg_count<99; $mImg_count++) {
		  if($tmp_files[$mImg_count]) @z_unlink("./".$tmp_files[$mImg_count]);
		}

	  //������� �Խù� ������ ����
	  mysql_query("DELETE FROM dq_revolution WHERE no='$m_data[no]' LIMIT 1"); 
	  }
	}

?>