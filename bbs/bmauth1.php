<?php

/*
�Ʒ��� zeroboard ������� �ʿ��ϰ� ��
*/
include "_head.php";
$logid = "$member[user_id]";
$id="memboard";
// �α����� ����� �����϶� ����ǥ��
if($logid=="") Error("�����Ǿ� ���� �ʽ��ϴ�.<br>�Խ��ǿ��� ���� �α����Ͻʽÿ�.<br><br>");

//echo "logid=$logid user_id=$user_id member[user_id]=$member[user_id] ";
//echo "setup[grant_list]=$setup[grant_list] member[level]=$member[level] ";

/*
�Ʒ��� zeroboard ������� ���ʿ��ϰ� ��

$auth = false; // Assume user is not authenticated

if (isset( $PHP_AUTH_USER ) && isset($PHP_AUTH_PW)) {

    // Connect to MySQL
    require("/home/gumpu/member/prog/config.php");


    // Formulate the query

    $sql = "SELECT userid,passwd FROM member WHERE
            userid = '$PHP_AUTH_USER' AND
            passwd = '$PHP_AUTH_PW'";

    // Execute the query and put results in $result

    $result = mysql_query( $sql )
        or die ( 'Unable to execute query.' );

    // Get number of rows in $result.

    $num = mysql_numrows( $result );

    if ( $num != 0 ) {

        // A matching row was found - the user is authenticated.

        $auth = true;

    }

}

if ( ! $auth ) {

    header( 'WWW-Authenticate: Basic realm="�д縶����"' );
    header( 'HTTP/1.0 401 Unauthorized' );
    echo 'Authorization Required.';
    exit;

}else{
	$logid=$PHP_AUTH_USER;
//	$passwd=$PHP_AUTH_PW;
}

*/

?>
