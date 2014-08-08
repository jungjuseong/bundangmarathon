<html>
<head>
</head>

<body bgcolor="#E0FFE0" text="black" link="blue" vlink="purple" alink="red">

<center>
<font size="+2">참가자 메일 발송</font>
<hr color=red width="80%">
<p align=center>
<form method=post action=emailsend.php>
<table border=1><tr>
<td align=center>제목</td>
<td align=center><input type=text name=subject size=40 maxlength=60></td>
</tr><tr>
<td align=center>인사말</td>
<td align=center><input type=text name=greetingmsg size=40 maxlength=60><br>인사말 앞에 "XXX님, "이 자동으로 추가됩니다.</td>
</tr><tr>
<td align=center>보낼 내용</td>
<td align=center><textarea wrap=auto name="cont" rows=12 cols=60></textarea></td>
</tr>
<tr>
<td colspan=2 align=center>
<input type=submit value='우편 보내기'>
</td>
</tr>
</table>
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
