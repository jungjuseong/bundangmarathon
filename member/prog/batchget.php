<?php

function heading($msg){
	echo "<font size='+2'>".$msg."</font>";
	echo "<hr color=red width='80%'>\n<br>";
}

function top($option){
echo "
<html>
<head>
<title>ȸ���� ���</title>
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

$fpsave = fopen("url-data.html","w+");
    
$datahead = "
<html><head></head><body>
<table width=580 border=0 cellspacing=1 cellpadding=0 bgcolor=cccccc><tr bgcolor=F2EDDC><td width=30 align=center>��ȣ</td><td width=57 align=center>����</td><!--td width=67 align=center>�������</td--><td width=66 align=center>���ȣ</td><td width=76 align=center>��ȯ��</td><td width=76 align=center>����(Net)</td><td width=76 align=center>����(Gun)</td><td width=66 align=center>��ü����</td><td width=66 align=center>���ɼ���</td></tr>";

fwrite($fpsave, $datahead);

/* 297 */
for($i = 1; $i<=297; $i++){

	echo "$i ";
	fwrite($fpsave, "<!-- xx $i xx -->\n");

	$fcontents = file ("http://marathon.joins.com/record/result3.asp?year=2003&cour1=F&cat=M&btwage=*&page=$i");

	for($j = 458; $j<698; $j++){
		fwrite($fpsave, $fcontents[$j]);
	}
	reset($fcontents);
}
fwrite($fpsave, "</table></body></html>");
fclose($fpsave);
echo "processed.";
?>
