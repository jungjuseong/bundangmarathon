<?php

/*
아래는 zeroboard 사용으로 필요하게 됨
*/
include "_head.php";
$logid = "$member[user_id]";
$id="memboard";
// 로그인한 멤버가 비멤버일때 에러표시
if($logid=="") Error("공개되어 있지 않습니다.<br>게시판에서 먼저 로그인하십시오.<br><br>");

//echo "logid=$logid user_id=$user_id member[user_id]=$member[user_id] ";
//echo "setup[grant_list]=$setup[grant_list] member[level]=$member[level] ";

/*
아래는 zeroboard 사용으로 불필요하게 됨

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

    header( 'WWW-Authenticate: Basic realm="분당마라톤"' );
    header( 'HTTP/1.0 401 Unauthorized' );
    echo 'Authorization Required.';
    exit;

}else{
	$logid=$PHP_AUTH_USER;
//	$passwd=$PHP_AUTH_PW;
}

*/

?>
