<html>
<head>
</head>
<body>
Test<br>
<?
echo "ls test\n<br><br>\n<pre>\n";
passthru("ls -lR ../../gumpu");
echo "</pre>\n";
?>
</body>
</html>
