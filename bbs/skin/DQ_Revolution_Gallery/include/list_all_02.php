<?
// 추가 업로드된 파일이 있을경우 처리 - 레볼루션

	$file_names   = "";
	$s_file_names = "";

	if(eregi("data2/",$m_data[file_names])) {
		$tmp_files  = explode(",",$m_data[file_names]);
		$tmp_sfiles = explode(",",$m_data[s_file_names]);

		if(!file_exists("./data2")) {
			@mkdir("./data2",0777);
			@chmod("./data2",0707);
		}

		if(!file_exists("./data2/$board_name")) {
			@mkdir("./data2/$board_name",0777);
			@chmod("./data2/$board_name",0707);
		}

		//레볼루션 파일복사
		if($tmp_files) {
		  for($mImg_count=0; $mImg_count<99; $mImg_count++) {
			if($tmp_files[$mImg_count]) {
				$temp_ext = "";
				if(file_exists("./data2/$board_name/".$tmp_sfiles[$mImg_count])) {
					$temp_ext=time()."/";
					@mkdir("./data2/$board_name/".$temp_ext,0777);
					@chmod("./data2/$board_name/".$temp_ext,0707);
				}
				copy($tmp_files[$mImg_count] , "./data2/$board_name/".$temp_ext.$tmp_sfiles[$mImg_count]);
				$tmp_files[$mImg_count]="data2/$board_name/".$temp_ext.$tmp_sfiles[$mImg_count];
				@chmod("./".$tmp_files[$mImg_count],0706);
			}
			$file_names   .= $tmp_files[$mImg_count].",";
		  }
		}
	}
// DB에 데이터 입력
	if($m_data) mysql_query("insert into dq_revolution (zb_id,zb_no,file_names,s_file_names,vote_users,is_hidden,is_vdel,is_slide,file_descript) values ('$board_name','$no','$file_names','$m_data[s_file_names]','$m_data[vote_users]','$m_data[is_hidden]','$m_data[is_vdel]','$m_data[is_slide]','$m_data[file_descript]')");
?>