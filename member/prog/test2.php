<?php 
$email="yhkim@kt.co.kr";
	if(emailaddrcheck($email) == 0){
		echo ("E-mail�� ��Ȯ�� �Է��Ͽ� �ֽʽÿ�!");  
		exit;  
	}  
echo $email;

function emailaddrcheck($email){
	if(ereg("([^[:space:]]+)", $email) && (!ereg("(^[_0-9a-zA-Z-]+(\.[_0-9a-zA-Z-]+)*@[0-9a-zA-Z-]+(\.[0-9a-zA-Z-]+)*$)", $email)) ) {
		return 0;
	}else{
		return 1;
	}
}
?> 
