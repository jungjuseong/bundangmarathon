<?

  // ���̺귯�� �Լ� ���� ��ũ���
	include "_head_m.php";

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
/***************************************************************************
* �ڸ�Ʈ ���� ����
**************************************************************************/
  // DB ����
  if(!$connect) $connect=dbconn_m();

// �н����带 ��ȣȭ
	if($password) {
		$temp=mysql_fetch_assoc(mysql_query("select password('$password') AS pass"));
		$password=$temp['pass'];   
	}

// �������� ������
	$s_data=mysql_fetch_assoc(mysql_query("select * from $t_comment"."_$id where no='$c_no'"));

// ȸ���϶��� Ȯ��;;
	if(!$is_admin&&$member[level]>$setup[grant_delete]) {
		if(!$s_data[ismember]) {
			if($s_data[password]!=$password){
				echo(iconv_UTF("��й�ȣ�� �ùٸ��� �ʽ��ϴ�"));
				exit;
			}
		} else {
			if($s_data[ismember]!=$member[no]){
				echo(iconv_UTF("��й�ȣ�� �Է��Ͽ� �ֽʽÿ�"));
				exit;
			}
		}
	}

// �ڸ�Ʈ ����
	mysql_query("delete from $t_comment"."_$id where no='$c_no'");

// �ڸ�Ʈ ���� ����
	$total=mysql_fetch_assoc(mysql_query("select count(*) AS cmt from $t_comment"."_$id where parent='$no'"));
	mysql_query("update $t_board"."_$id set total_comment='".$total['cmt']."' where no='".$no."'"); 

// ȸ���� ��� �ش� �ؿ��� ���� �ֱ�
	if($member[no]==$s_data[ismember]) @mysql_query("update $member_table set point2=point2-1 where no='$member[no]'",$connect);

	@mysql_close($connect);

// ������ ������ ����
	if($setup[use_alllist]){
		echo("SUCCESS@zboard_m.php?id=$id&page=$page&page_num=$page_num&select_arrange=$select_arrange&desc=$des&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&no=$no");
		exit;
	}else{
		echo("SUCCESS@view_m.php?id=$id&page=$page&page_num=$page_num&select_arrange=$select_arrange&desc=$des&sn=$sn&ss=$ss&sc=$sc&keyword=$keyword&no=$no");
		exit;
	}
?>
