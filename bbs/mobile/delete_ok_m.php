<?
  // ���̺귯�� �Լ� ���� ��ũ���
	include "../lib.php";										//���� ���̺귯��
	include $_zb_path."lib_m.php";			//�߰� ���̺귯��[����Ͽ�]

	$getData = iconv_CP949All($HTTP_POST_VARS);
	$page = $getData[page];
	$id = $getData[id];
	$no = $getData[no];
	$select_arrange = $getData[select_arrange];
	$desc = $getData[desc];
	$page_num = $getData[page_num];
	$keyword = $getData[keyword];
	$category = $getData[category];
	$sn = $getData[sn];
	$ss = $getData[ss];
	$sc = $getData[sc];
	$mode = $getData[mode];
	$c_no = $getData[c_no];

	if(!eregi($HTTP_HOST,$HTTP_REFERER)){
		echo(iconv_UTF("���������� ���� �����Ͽ� �ֽñ� �ٶ��ϴ�."));
		exit;
	}

	if(getenv("REQUEST_METHOD") == 'GET' ){
		echo(iconv_UTF("���������� ���� �����Ͻñ� �ٶ��ϴ�"));
		exit;
	}

  // �Խ��� �̸� ������ �ȵǾ� ������ ���;;;
  if(!$id){
		echo(iconv_UTF("�Խ��� �̸��� ������ �ּž� �մϴ�.<br><br>��) zboard.php?id=�̸�"));
		exit;
	}

  // DB ����
  if(!$connect) $connect=dbconn_m();

  // ���� �Խ��� ���� �о� ����
  $setup=get_table_attrib($id);

  // �������� ���� �Խ����϶� ���� ǥ��
  if(!$setup[name]){
		echo(iconv_UTF("�������� ���� �Խ����Դϴ�.<br><br>�Խ����� ������ ����Ͻʽÿ�"));
		exit;
	}
  // ���� �Խ����� �׷��� ���� �о� ����
  $group=group_info($setup[group_no]);

  // ��� ���� ���ؿ���;;; ����� ������
  $member=member_info();

  // ���� �α��εǾ� �ִ� ����� ��ü, �Ǵ� �׷���������� �˻�
  if($member[is_admin]==1||$member[is_admin]==2&&$member[group_no]==$setup[group_no]||check_board_master($member, $setup[no])) $is_admin=1; else $is_admin="";

  // ���� ���� �������� ��� �����ϱ�;;;
  $avoid_ip=explode(",",$setup[avoid_ip]);
  for($i=0;$i<count($avoid_ip);$i++)
  {
		if(!isblank($avoid_ip[$i])&&eregi($avoid_ip[$i],$REMOTE_ADDR)&&!$is_admin){
			echo(iconv_UTF(" Access Denied "));
			exit;
		}
  }

  // ���� �׷��� ���׷��̰� �α����� ����� �����϶� ����ǥ��
  if($group[is_open]==0&&!$is_admin&&$member[group_no]!=$setup[group_no]){
		echo(iconv_UTF("���� �Ǿ� ���� �ʽ��ϴ�"));
		exit;
	}

  //�н����带 ��ȣȭ
  if($password)
  {
   $temp=mysql_fetch_assoc(mysql_query("select password('$password') AS pass"));
   $password=$temp['pass'];   
  }

  // �������� ������
  $s_data=mysql_fetch_assoc(mysql_query("select * from $t_board"."_$id where no='$no'"));

  // ȸ���϶��� Ȯ��;;
  if(!$is_admin&&$member[level]>$setup[grant_delete])
  {
   if(!$s_data[ismember])
   {
    if($s_data[password]!=$password){
			echo(iconv_UTF("��й�ȣ�� �ùٸ��� �ʽ��ϴ�"));
			exit;
		}
   }
   else
   {
    if($s_data[ismember]!=$member[no]){
			echo(iconv_UTF("��й�ȣ�� �Է��Ͽ� �ֽʽÿ�"));
			exit;
		}
   }
  }

  /////////////////////////////////////////////////////////////////////////////////////////////
  // �ۻ����϶� 
  ////////////////////////////////////////////////////////////////////////////////////////////

  if(!$s_data[child]) // ����� ������;;
  {
   mysql_query("delete from $t_board"."_$id where no='$no'"); // �ۻ���

   // ���ϻ���
   @z_unlink("./".$s_data[file_name1]);
   @z_unlink("./".$s_data[file_name2]);

   minus_division($s_data[division]);

   if($s_data[depth]==0)
   {
    if($s_data[prev_no]) mysql_query("update $t_board"."_$id set next_no='$s_data[next_no]' where next_no='$s_data[no]'"); // �������� ������ ���ڸ� �޲�;;;
    if($s_data[next_no]) mysql_query("update $t_board"."_$id set prev_no='$s_data[prev_no]' where prev_no='$s_data[no]'"); // �������� ������ ���ڸ� �޲�;;;
   }
   else
   { 
    $temp=mysql_fetch_assoc(mysql_query("select count(*) AS cmt from $t_board"."_$id where father='$s_data[father]'"));
    if(!$temp['cmt']) mysql_query("update $t_board"."_$id set child='0' where no='$s_data[father]'"); // �������� ������ �������� �ڽı��� ����;;;
   }

   // ������ ��� ����
   mysql_query("delete from $t_comment"."_$id where parent='$s_data[no]'");

   $total=mysql_fetch_assoc(mysql_query("select count(*) AS cmt from $t_board"."_$id "));
   mysql_query("update $admin_table set total_article='".$total['cmt']."' where name='".$id."'");

   // ī�װ� �ʵ� ����
   mysql_query("update $t_category"."_$id set num=num-1 where no='$s_data[category]'",$connect);

   // ȸ���� ��� �ش� �ؿ��� ���� �ֱ�
   if($member[no]==$s_data[ismember]) @mysql_query("update $member_table set point1=point1-1 where no='$member[no]'",$connect);
  }

  //////// MySQL �ݱ� ///////////////////////////////////////////////
  if($connect) mysql_close($connect);
  $query_time=getmicrotime();

//������ ������ ����
	echo("SUCCESS@zboard_m.php?id=$id&page=$page&page_num=$page_num&select_arrange=$select_arrange&desc=$des&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&sn1=$sn1&divpage=$divpage&category=$category");
	exit;
?>
