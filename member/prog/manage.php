<?php 

require("./config.php");
require("./function.php");

if($logid == ""){
	top("");
	heading("ȸ�� ID �Է�");
	echo "<a href='mem.php'>���⼭ �α׿� �Ͻʽÿ�.</a>";
}else{
	top("");

	heading("������ ���");
	if(privcheck($logid) != 2){
		echo "�����ڸ� ��� ������ ����Դϴ�.";
	}else{
		echo "<a href='mem.php?mode=member-input'>ȸ�����</a>\n";
		echo "<p><a href='mem.php?mode=member-select'>ȸ����������</a>\n";
	}
}

?>
</center>
</body>
</html>
