<?php

function heading($msg){
	echo "<font size='+2'>".$msg."</font>";
	echo "<hr color=red width='80%'>\n<br>";
}

function top($option){
echo "
<html>
<head>
<title>회원용 기능</title>
";
if(substr($option,0,1) == "<")
	echo "$option\n";

echo "</head>

<body  bgcolor='#E0FFE0' text='black' link='blue' vlink='purple' alink='red'";
if(substr($option,0,6) == "onLoad")
	echo " $option";
else if(substr($option,0,8) == "setFocus")
	echo " onLoad=\"$option\"";
echo ">
<center>
";
}

/* dayofweek() will return the day of the week a given date falls.
0=Sunday, 1=Monday, etc. */

function dayofweek($year,$month,$day) {

 /* Check date for validity */
        if (!checkdate($month,$day,$year))
                return -1;

        $a=(int)((14-$month) / 12);
        $y=$year-$a;
        $m=$month + (12*$a) - 2;

        $retval=($day + $y + (int)($y/4) - (int)($y/100) + (int)($y/400) +
(int)((31*$m)/12)) % 7;
        return $retval;
}


?>
