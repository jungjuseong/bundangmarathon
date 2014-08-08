<html>
<head>
</head>

<body bgcolor='#E0FFE0' text='black' link='blue' vlink='purple' alink='red'>

<center>
<font size='+2'>참가자 메일 발송</font>
<hr color=red width='80%'>
<p>

<?php 
//	ob_start();

	if($subject == "" || $cont == ""){
		echo "제목과 내용을 입력해 주십시오";
		die("");
	}

	require("../config.php");
//mysql_select_db("gumpu", $connect);
	mysql_select_db("coretek") or die("mysql_select_db error");

	$dbquery="select bibno,name,email,juminno,org,record,postno,postaddr from reg2001 where email!='' and record is not null order by bibno";
//	$dbquery="select bibno, name, email, juminno, org,record ,postno,postaddr from reg2001 where name='김영헌' and record is not null order by bibno";
	$result = mysql_query($dbquery) or die("mysql_query error");

	$mailcont_file = "./emailcont.dat";
	$no=0;
	while($row=mysql_fetch_array($result)){
//		if($row[1] == "나석주")
//			continue;
		$fp = fopen($mailcont_file, "w");
		fwrite($fp, "From: \"분당마라톤대회 운영자\"<gumpu@gumpu.pe.kr>\n");
		fwrite($fp, "To: \"$row[1]님 귀하\"<$row[2]>\n");
		fwrite($fp, "Subject: $subject\n");
		fwrite($fp, "\n");
		if($greetingmsg!=""){
			fwrite($fp, $row[1]."님, ".$greetingmsg."\n");
			fwrite($fp, "\n");
		}

		fwrite($fp, $cont);
		fwrite($fp, "\n");
		fclose($fp);

		$execret = exec("mail ".$row[2]."  < $mailcont_file");

		$no++;
		echo $no." ";
		if(($no % 10) == 0){
			echo "\n";
		}
//		ob_end_flush();
//sleep(60);
//		ob_start();
		if(($no % 100) == 0){
//			sleep(5);
		}
	}
	chmod($mailcont_file, 0777);

	mysql_free_result($result);
	mysql_close() or die("mysql_close error");

?>
<p align=center>
처리 완료됐습니다.
</center>
<p>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td height="11" background="../../../images/main_caption.gif"></td>
    </tr>
    <tr>
        <td height="5"></td>
    </tr>
    <tr>
        <td align="center"><p>Copyright ⓒ by 탄천검푸마라톤클럽. All rights 
            reserved. </td>
    </tr>
</table>
</body>
</html>
