<?

/***************************************************************************
 * ���� ���� include
 **************************************************************************/
	include "_head.php";
	include "include/list_check.php";
?>

<script language='JavaScript'>
<!--
SetTimeout("window.location.reload();",300*1000); 

function winopen(url){
    PopUp = window.open (url, 'bbs', 'top=100, left=100, resizable=1,scrollbars=yes');
    PopUp.focus();
}
//-->
</script>
<?

 	$_zb_board_list = array("noticeboard","memboard","pubboard","raceboard");
 	$_zb_boardname_list = array("��������","ȸ���Խ���","�Բ��ϴ��̾߱�","�������ȸ");
	$_zb_c = count($_zb_board_list);

	echo "<table style='font-size:9pt'><tr>";
	for($i=0;$i<$_zb_c;$i++) {

		if($i == 0) echo "<td width=50%>\n";
		if($i == 2) echo "<td width=10 height=200><img src='../image/first-down-line.gif'></td><td width=50%>\n";
		echo "<br><div align=center><B><a href='' onClick='winopen(\"/bbs/zboard.php?id=$_zb_board_list[$i]\"); return false'><<$_zb_boardname_list[$i]>></a></B></div>";
		$que="select * from $t_board"."_$_zb_board_list[$i] order by headnum,arrangenum limit 0, 7";
		$result=mysql_query($que) or error(mysql_error());
	
		$returnNum = mysql_num_rows($result);

/***************************************************************************
 * ������ ����Ÿ�� ����ϴ� �κ� 
 **************************************************************************/

// ������ ����Ÿ��ŭ �����
		while($data=@mysql_fetch_array($result)) {
			list_check(&$data);
//			echo "<br>$data[subject]";
			echo "<br>";
			echo "-<a href='' onClick='winopen(\"/bbs/view.php?id=$_zb_board_list[$i]&no=$data[no]\"); return false'>".subhanstr($data[subject],12)."</a>";
		}
		while($returnNum < 9){	// 7 + 2
			echo "<br>\n";
			$returnNum++;
		}
	}
	echo "</tr></table></font>\n";

function subhanstr($str, $len){
	for( $i = $ilen = 0; ; ){
		$c=substr($str,$i,1);
		if($c>"z"){
			$i++;
			$ilen++;
		}else if($c == " " || $c>="0" && $c<="9")
			$ilen = $ilen + 0.5;
		else
			$ilen++;
		$i++;
		if($ilen > $len) {
			break;
		}
	}
	return substr($str, 0, $i);
}
?>
