<?php 

require("./config.php");
require("./function.php");

if($logid == ""){
	top("");
	heading("회원 ID 입력");
	echo "<a href='mem.php'>여기서 로그온 하십시오.</a>";
}else{
	top("");

	heading("관리자 기능");
	if(privcheck($logid) != 2){
		echo "관리자만 사용 가능한 기능입니다.";
	}else{
		echo "<a href='mem.php?mode=member-input'>회원등록</a>\n";
		echo "<p><a href='mem.php?mode=member-select'>회원정보수정</a>\n";
	}
}

?>
</center>
</body>
</html>
