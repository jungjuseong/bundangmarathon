<?php
	//set_time_limit(0); 
    
    $del_que1 = $del_que2 = null;

/***************************************************************************
 * ���� ���� include
 **************************************************************************/
	include "_head_m.php";

/***************************************************************************
 * �Խ��� ���� üũ
 **************************************************************************/

	$getData = iconv_CP949All($HTTP_POST_VARS);

	if(!eregi($HTTP_HOST,$HTTP_REFERER)){
		echo(iconv_UTF("���������� ���� �ۼ��Ͽ� �ֽñ� �ٶ��ϴ�."));
		exit;
	}

	if(getenv("REQUEST_METHOD") == 'GET' ){
		echo(iconv_UTF("���������� ���� ���ñ� �ٶ��ϴ�"));
		exit;
	}
	if(!$getData[mode]) $mode = "write";
	else $mode = $getData[mode];

// ������ üũ
	if($mode=="reply"&&$setup[grant_reply]<$member[level]&&!$is_admin){
		echo(iconv_UTF("�������� �����ϴ�"));
		exit;
	}	elseif($setup[grant_write]<$member[level]&&!$is_admin){
		echo(iconv_UTF("�������� �����ϴ�"));
		exit;
	}

	if(!$is_admin&&$setup[grant_notice]<$member[level]) $notice = 0;

// ���� ���� �˻�;;
	if(!$member[no]) {
		if(isblank($getData[name])) {
			echo(iconv_UTF("�̸��� �Է��ϼž� �մϴ�"));
			exit;
		}
		if(isblank($getData[password])) {
			echo(iconv_UTF("��й�ȣ�� �Է��ϼž� �մϴ�"));
			exit;
		}
	} else {
		$password = $member[password];
	}

	$subject = str_replace("��","",$getData[subject]);
	$memo  = str_replace("��","",$getData[memo]);
	$name   = str_replace("��","",$getData[name]);

	if(isblank($subject)){
		echo(iconv_UTF("������ �Է��ϼž� �մϴ�"));
		exit;
	}
	if(isblank($memo)){
		echo(iconv_UTF("������ �Է��ϼž� �մϴ�"));
		exit;
	}
	if($setup['use_category'] == "1" && !$category){
		echo(iconv_UTF("ī�װ��� �����ϼž� �մϴ�."));
		exit;
	}
	if(!$category) {
		$cate_temp=mysql_fetch_array(mysql_query("select min(no) from $t_category"."_$id",$connect));
		$category=$cate_temp[0];
	}


// ���͸�;; �����ڰ� �ƴҶ�;;
	if(!$is_admin&&$setup[use_filter]) {
		$filter			= explode(",",$setup[filter]);
		$f_memo		= eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($memo));
		$f_name		= eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($name));
		$f_subject	= eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($subject));
		$f_email		= eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($getData[email]));
		$f_homepage= eregi_replace("([\_\-\./~@?=%&! ]+)","",strip_tags($getData[homepage]));
		for($i=0;$i<count($filter);$i++) {
			if(!isblank($filter[$i])) {
				if(eregi($filter[$i],$f_memo)){
					echo(iconv_UTF("<b>$filter[$i]</b> ��(��) ����ϱ⿡ ������ �ܾ �ƴմϴ�"));
					exit;
				}
				if(eregi($filter[$i],$f_name)){ 
					echo(iconv_UTF("<b>$filter[$i]</b> ��(��) ����ϱ⿡ ������ �ܾ �ƴմϴ�"));
					exit;
				}
				if(eregi($filter[$i],$f_subject)){ 
					echo(iconv_UTF("<b>$filter[$i]</b> ��(��) ����ϱ⿡ ������ �ܾ �ƴմϴ�"));
					exit;
				}
				if(eregi($filter[$i],$f_email)){ 
					echo(iconv_UTF("<b>$filter[$i]</b> ��(��) ����ϱ⿡ ������ �ܾ �ƴմϴ�"));
					exit;
				}
				if(eregi($filter[$i],$f_homepage)){ 
					echo(iconv_UTF("<b>$filter[$i]</b> ��(��) ����ϱ⿡ ������ �ܾ �ƴմϴ�"));
					exit;
				}
			}
		}
	}

//�н����带 ��ȣȭ
	if(strlen($getData[password])) {
		$temp=mysql_fetch_array(mysql_query("select password('$password')"));
		$password=$temp[0];   
	}

	// ����Ͽ����� ������ HTML ����
	$memo=del_html($memo);

	// �������� ������
	unset($s_data);
	$s_data=mysql_fetch_array(mysql_query("select * from $t_board"."_$id where no='$no'"));

// �������� �̿��� ��
	if($mode=="modify"||$mode=="reply") {
		if(!$s_data[no]) {
			echo(iconv_UTF("�������� �������� �ʽ��ϴ�"));
			exit;
		}
	}

// �����ۿ��� ����� �� �޸��� ó��
	if($mode=="reply"&&$s_data[headnum]<=-2000000000) {
		echo(iconv_UTF("�����ۿ��� ����� �޼� �����ϴ�"));
		exit;
	}


// ȸ������� �Ǿ� ������ �̸����� ������;;
	if($member[no]) {
		if($mode=="modify"&&$member[no]!=$s_data[ismember]) {
			$name=$s_data[name];
			$email=$s_data[email];
			$homepage=$s_data[homepage];
		} else {
			$name=$member[name];
			$email=$member[email];
			$homepage=$member[homepage];
		}
	}

// ���� ������ addslashes ��Ŵ;;
	$name = addslashes(del_html($name));
	$subject = addslashes(del_html($subject));
	$memo = addslashes($memo);
	if($use_html<2) {
		$memo = str_replace("  ","&nbsp;&nbsp;",$memo);
		$memo = str_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$memo);
	}	
	$email = addslashes(del_html($getData[email]));
	$homepage = addslashes(del_html($getData[homepage]));

// ���� ���� ����
	$ip = $REMOTE_ADDR; // �����ǰ� ����;;
	$reg_date = time(); // ������ �ð�����;;

	$x = $zx;
	$y = $zy;

// �������� �ƴ��� �˻�;; �켱 ���� �����Ǵ뿡 30���̳��� ���� ����� ����;;
	if(!$is_admin&&$mode!="modify") {
		$max_no=mysql_fetch_array(mysql_query("select max(no) from $t_board"."_$id"));
		$temp=mysql_fetch_array(mysql_query("select count(*) from $t_board"."_$id where ip='$ip' and $reg_date - reg_date <30 and no='$max_no[0]'"));
		if($temp[0]>0) {echo(iconv_UTF("�۵���� 30���̻��� ������ �����մϴ�")); exit;}
	}

// ���� ������ �ִ��� �˻�;;
	if(!$is_admin&&$mode!="modify") {
		$max_no=mysql_fetch_array(mysql_query("select max(no) from $t_board"."_$id"));
		$temp=mysql_fetch_array(mysql_query("select count(*) from $t_board"."_$id where memo='$memo' and no='$max_no[0]'"));
		if($temp[0]>0) {echo(iconv_UTF("���� ������ ���� ����Ҽ��� �����ϴ�")); exit; }
	}


// ��Ű ����;;
	if($mode!="modify") {

		// 4.0x �� ���� ó��
		if($name) {
			$zb_writer_name = $name;
			session_register("zb_writer_name");
		}
		if($email) {
			$zb_writer_email = $email;
			session_register("zb_writer_email");
		}
		if($homepage) {
			$zb_writer_homepage = $homepage;
			session_register("zb_writer_homepage");
		}
	}

/***************************************************************************
 * �������϶�
 **************************************************************************/
	if($mode=="modify"&&$no) {

		if($s_data[ismember]) {
			if(!$is_admin&&$member[level]>$setup[grant_delete]&&$s_data[ismember]!=$member[no]){
				echo(iconv_UTF("�������� ������� �����ϼ���"));
				exit;
			}
		}

		// ��й�ȣ �˻�;;
		if($s_data[ismember]!=$member[no]&&!$is_admin) {
			if($getData[password]!=$s_data[password]){
				echo(iconv_UTF("��й�ȣ�� Ʋ�Ƚ��ϴ�"));
				exit;
			}
		}

		// ���� -> �Ϲݱ� 
		if(!$notice&&$s_data[headnum]<="-2000000000") {
			$temp=mysql_fetch_array(mysql_query("select max(division) from $t_division"."_$id"));
			$max_division=$temp[0];
			$temp=mysql_fetch_array(mysql_query("select max(division) from $t_division"."_$id where num>0 and division!='$max_division'"));
			if(!$temp[0]) $second_division=0; else $second_division=$temp[0];

			// ����+1 �Ѱ��� ����;;
			$max_headnum=mysql_fetch_array(mysql_query("select min(headnum) from $t_board"."_$id where (division='$max_division' or division='$second_division') and headnum>-2000000000")); // ������ �ƴ� �ּ� headnum ����
			$headnum=$max_headnum[0]-1; 

			$next_data=mysql_fetch_array(mysql_query("select no,headnum,division from $t_board"."_$id where (division='$max_division' or division='$second_division') and headnum='$max_headnum[0]' and arrangenum='0'")); // �������� ����;;
			if(!$next_data[0]) $next_data[0]="0";
			$next_no=$next_data[0];

			if(!$next_data[division]) $division=1; else $division=$next_data[division];

			$prev_data=mysql_fetch_array(mysql_query("select no from $t_board"."_$id where (division='$max_division' or division='$second_division') and headnum<'$headnum' and no!='$no' order by headnum desc limit 1")); // �������� ����;;
			if($prev_data[0]) $prev_no=$prev_data[0]; else $prev_no=0;

			$child="0";
			$depth="0";    
			$arrangenum="0";
			$father="0";
			minus_division($s_data[division]);
			@mysql_query("update $t_board"."_$id set headnum='$headnum',prev_no='$prev_no',next_no='$next_no',child='$child',depth='$depth',arrangenum='$arrangenum',father='$father',name='$name',email='$email',homepage='$homepage',subject='$subject',memo='$memo',sitelink1='$sitelink1',sitelink2='$sitelink2',use_html='$use_html',reply_mail='$reply_mail',is_secret='$is_secret',category='$category' $del_que1 $del_que2 where no='$no'");
			plus_division($division);

			// �������� �������� ����
			if($next_no)mysql_query("update $t_board"."_$id set prev_no='$no' where division='$next_data[division]' and headnum='$next_data[headnum]'");  

			// �������� �������� ����
			if($prev_no)mysql_query("update $t_board"."_$id set next_no='$no' where no='$prev_no'");                  

			mysql_query("update $t_board"."_$id set prev_no=0 where (division='$max_division' or division='$second_division') and prev_no='$s_data[no]' and headnum!='$next_data[headnum]'");
			mysql_query("update $t_category"."_$id set num=num-1 where no='$s_data[category]'",$connect);
			mysql_query("update $t_category"."_$id set num=num+1 where no='$category'",$connect);
		}

   		// �Ϲݱ� -> ���� 
		elseif($notice&&$s_data[headnum]>-2000000000) {
			$temp=mysql_fetch_array(mysql_query("select max(division) from $t_division"."_$id"));
			$max_division=$temp[0];
			$temp=mysql_fetch_array(mysql_query("select max(division) from $t_division"."_$id where num>0 and division!='$max_division'"));
			if(!$temp[0]) $second_division=0; else $second_division=$temp[0];

			$max_headnum=mysql_fetch_array(mysql_query("select min(headnum) from $t_board"."_$id where division='$max_division' or division='$second_division'"));  // �ְ���� ����;;
			$headnum=$max_headnum[0]-1;
			if($headnum>-2000000000) $headnum=-2000000000; // �ְ� headnum�� ������ �ƴϸ� ���� �ۿ� ������ ����;

			$next_data=mysql_fetch_array(mysql_query("select no,headnum,division from $t_board"."_$id where (division='$max_division' or division='$second_division') and headnum='$max_headnum[0]' and arrangenum='0'"));
			if(!$next_data[0]) $next_data[0]="0";
			$next_no=$next_data[0];
			$prev_no=0;
			$child="0";
			$depth="0";
			$arrangenum="0";
			$father="0";
			minus_division($s_data[division]);
			$division=add_division();
			@mysql_query("update $t_board"."_$id set division='$division',headnum='$headnum',prev_no='$prev_no',next_no='$next_no',child='$child',depth='$depth',arrangenum='$arrangenum',father='$father',name='$name',email='$email',homepage='$homepage',subject='$subject',memo='$memo',sitelink1='$sitelink1',sitelink2='$sitelink2',use_html='$use_html',reply_mail='$reply_mail',is_secret='$is_secret',category='$category' $del_que1 $del_que2 where no='$no'");

			if($s_data[father]) mysql_query("update $t_board"."_$id set child='$s_data[child]' where no='$s_data[father]'"); // ����̾����� �������� ����� ������� ��۷� ��ü
			if($s_data[child]) mysql_query("update $t_board"."_$id set depth=depth-1,father='$s_data[father]' where no='$s_data[child]'"); // ����� ������ ������� ��ġ��;;

			// ���� �����۷� �̱��� ������ �־��� ����Ÿ�� prev_no�� �ٲ�;
			$temp=mysql_fetch_array(mysql_query("select max(headnum) from $t_board"."_$id where headnum<='$s_data[headnum]'"));
			$temp=mysql_fetch_array(mysql_query("select no from $t_board"."_$id where headnum='$temp[0]' and depth='0'"));
			mysql_query("update $t_board"."_$id set prev_no='$temp[no]' where prev_no='$s_data[no]'");

			mysql_query("update $t_board"."_$id set next_no='$s_data[next_no]' where next_no='$s_data[no]'");

			mysql_query("update $t_board"."_$id set prev_no='$no' where prev_no='0' and no!='$no'"); // �������� �������� ���� 
			mysql_query("update $t_category"."_$id set num=num-1 where no='$s_data[category]'",$connect);
			mysql_query("update $t_category"."_$id set num=num+1 where no='$category'",$connect);

		// �Ϲ�->�Ϲ�, ����->���� �϶� 
		} else {
			@mysql_query("update $t_board"."_$id set name='$name',subject='$subject',email='$email',homepage='$homepage',memo='$memo',sitelink1='$sitelink1',sitelink2='$sitelink2',use_html='$use_html',reply_mail='$reply_mail',is_secret='$is_secret',category='$category' $del_que1 $del_que2 where no='$no'");
			mysql_query("update $t_category"."_$id set num=num-1 where no='$s_data[category]'",$connect);
			mysql_query("update $t_category"."_$id set num=num+1 where no='$category'",$connect);
		}



/***************************************************************************
 * �亯���϶�
 **************************************************************************/
	} elseif($mode=="reply"&&$no) {

		$prev_no=$s_data[prev_no];
		$next_no=$s_data[next_no];
		$father=$s_data[no];
		$child=0;
		$headnum=$s_data[headnum];    
		if($headnum<=-2000000000&&$notice) {
			echo(iconv_UTF("�������׿��� ����� �޼��� �����ϴ�"));
			exit;
		}
		$depth=$s_data[depth]+1;
		$arrangenum=$s_data[arrangenum]+1;
		$move_result=mysql_query("select no from $t_board"."_$id where division='$s_data[division]' and headnum='$headnum' and arrangenum>='$arrangenum'");
		while($move_data=mysql_fetch_array($move_result)) {
			mysql_query("update $t_board"."_$id set arrangenum=arrangenum+1 where no='$move_data[no]'");
		}

		$division=$s_data[division];
		plus_division($s_data[division]);
   
		// ��� ����Ÿ �Է�;;
		mysql_query("insert into $t_board"."_$id (division,headnum,arrangenum,depth,prev_no,next_no,father,child,ismember,memo,ip,password,name,homepage,email,subject,use_html,reply_mail,category,is_secret,sitelink1,sitelink2,file_name1,file_name2,s_file_name1,s_file_name2,x,y,reg_date,islevel) values ('$division','$headnum','$arrangenum','$depth','$prev_no','$next_no','$father','$child','$member[no]','$memo','$ip','$password','$name','$homepage','$email','$subject','$use_html','$reply_mail','$category','$is_secret','$sitelink1','$sitelink2','$file_name1','$file_name2','$s_file_name1','$s_file_name2','$x','$y','$reg_date','$member[is_admin]')");    

		// �����۰� �������� �Ʒ����� �Ӽ� ����;;
		$no=mysql_insert_id();
		mysql_query("update $t_board"."_$id set child='$no' where no='$s_data[no]'");
		mysql_query("update $t_category"."_$id set num=num+1 where no='$category'",$connect);

		// ������� ��ȸ���� �ø��� ���� ���� ���
		$hitStr=",".$setup[no]."_".$no;
		$zb_hit=$HTTP_SESSION_VARS["zb_hit"].$hitStr;
		session_register("zb_hit");

		// ������� ��õ�� �Ҽ� ���� ���� ���
		$voteStr=",".$setup[no]."_".$no;
		$zb_vote=$HTTP_SESSION_VARS["zb_vote"].$voteStr;
		session_register("zb_vote");

		// ����� �������϶�;;
		if($s_data[reply_mail]&&$s_data[email]) {

			if($use_html<2) $memo=nl2br($memo);
			$memo = stripslashes($memo);

			zb_sendmail($use_html, $s_data[email], $s_data[name], $email, $name, $subject, $memo);
		}

/***************************************************************************
 * �ű� �۾����϶�
 **************************************************************************/
	} elseif($mode=="write") {

		// ���������� �ƴҶ�;;
		if(!$notice) {
			$temp=mysql_fetch_array(mysql_query("select max(division) from $t_division"."_$id"));
			$max_division=$temp[0];
			$temp=mysql_fetch_array(mysql_query("select max(division) from $t_division"."_$id where num>0 and division!='$max_division'"));
			if(!$temp[0]) $second_division=0; else $second_division=$temp[0];

			$max_headnum=mysql_fetch_array(mysql_query("select min(headnum) from $t_board"."_$id where (division='$max_division' or division='$second_division') and headnum>-2000000000"));
			if(!$max_headnum[0]) $max_headnum[0]=0;

			$headnum=$max_headnum[0]-1;

			$next_data=mysql_fetch_array(mysql_query("select division,headnum,arrangenum from $t_board"."_$id where (division='$max_division' or division='$second_division') and headnum>-2000000000 order by headnum limit 1"));
			if(!$next_data[0]) $next_data[0]="0";
			else {
				$next_data=mysql_fetch_array(mysql_query("select no,headnum,division from $t_board"."_$id where division='$next_data[division]' and headnum='$next_data[headnum]' and arrangenum='$next_data[arrangenum]'"));
			}
    
			$prev_data=mysql_fetch_array(mysql_query("select no from $t_board"."_$id where (division='$max_division' or division='$second_division') and headnum<=-2000000000 order by headnum desc limit 1"));
			if($prev_data[0]) $prev_no=$prev_data[0]; else $prev_no="0";

		// ���������϶�;; 
		} else {
			$temp=mysql_fetch_array(mysql_query("select max(division) from $t_division"."_$id"));
			$max_division=$temp[0]+1;
			$temp=mysql_fetch_array(mysql_query("select max(division) from $t_division"."_$id where num>0 and division!='$max_division'"));
			if(!$temp[0]) $second_division=0; else $second_division=$temp[0];

			$max_headnum=mysql_fetch_array(mysql_query("select min(headnum) from $t_board"."_$id where division='$max_division' or division='$second_division'"));
			$headnum=$max_headnum[0]-1;
			if($headnum>-2000000000) $headnum=-2000000000;

			$next_data=mysql_fetch_array(mysql_query("select division,headnum from $t_board"."_$id where division='$max_division' or division='$second_division' order by headnum limit 1"));
			if(!$next_data[0]) $next_data[0]="0";
			else {
				$next_data=mysql_fetch_array(mysql_query("select no,headnum,division from $t_board"."_$id where division='$next_data[division]' and headnum='$next_data[headnum]' and arrangenum='0'"));
			}
			$prev_no=0; 
		}

		$next_no=$next_data[no];
		$child="0";
		$depth="0";
		$arrangenum="0";
		$father="0";
		$division=add_division();

		mysql_query("insert into $t_board"."_$id (division,headnum,arrangenum,depth,prev_no,next_no,father,child,ismember,memo,ip,password,name,homepage,email,subject,use_html,reply_mail,category,is_secret,sitelink1,sitelink2,file_name1,file_name2,s_file_name1,s_file_name2,x,y,reg_date,islevel) values ('$division','$headnum','$arrangenum','$depth','$prev_no','$next_no','$father','$child','$member[no]','$memo','$ip','$password','$name','$homepage','$email','$subject','$use_html','$reply_mail','$category','$is_secret','$sitelink1','$sitelink2','$file_name1','$file_name2','$s_file_name1','$s_file_name2','$x','$y','$reg_date','$member[is_admin]')");
		$no=mysql_insert_id();

		// ������� ��ȸ���� �ø��� ���� ���� ���
		$hitStr=",".$setup[no]."_".$no;
		$zb_hit=$HTTP_SESSION_VARS["zb_hit"].$hitStr;
		session_register("zb_hit");

		// ������� ��õ�� �Ҽ� ���� ���� ���
		$voteStr=",".$setup[no]."_".$no;
		$zb_vote=$HTTP_SESSION_VARS["zb_vote"].$voteStr;
		session_register("zb_vote");

		if($prev_no) mysql_query("update $t_board"."_$id set next_no='$no' where no='$prev_no'");
		if($next_no) mysql_query("update $t_board"."_$id set prev_no='$no' where headnum='$next_data[headnum]' and division='$next_data[division]'");
		mysql_query("update $t_category"."_$id set num=num+1 where no='$category'",$connect);
	}


// ���� ������ �ٽ� ����
	$total=mysql_fetch_array(mysql_query("select count(*) from $t_board"."_$id "));
	mysql_query("update $admin_table set total_article='$total[0]' where name='$id'");

// ȸ���� ��� �ش� �ؿ��� ���� �ֱ�
	if($mode=="write"||$mode=="reply") @mysql_query("update $member_table set point1=point1+1 where no='$member[no]'",$connect);

// MySQL �ݱ� 
	if($connect) {
		mysql_close($connect); 
		unset($connect);
	}
	echo("SUCCESS@zboard_m.php?id=$id&page=$page&page_num=$page_num&select_arrange=$select_arrange&desc=$des&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&no=$no&category=$category");
	exit;
?>
