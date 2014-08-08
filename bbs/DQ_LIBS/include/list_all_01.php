<?
	//레볼루션 데이터를 가져옴
	if($selected[$i]) $m_data=mysql_fetch_array(mysql_query("select * from dq_revolution where zb_id='$id' and zb_no='$selected[$i]'"));

	if($m_data[no]) {
	  $tmp_files  = explode(",",$m_data[file_names]);
	  $tmp_sfiles = explode(",",$m_data[s_file_names]);

	  //레볼루션 파일삭제
	  if($tmp_files) {
		for($mImg_count=0; $mImg_count<99; $mImg_count++) {
		  if($tmp_files[$mImg_count]) @z_unlink("./".$tmp_files[$mImg_count]);
		}

	  //레볼루션 게시물 데이터 삭제
	  mysql_query("DELETE FROM dq_revolution WHERE no='$m_data[no]' LIMIT 1"); 
	  }
	}

?>