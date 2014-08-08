<?
	include "main_top.txt";
?>
<table border="0" cellpadding="0" cellspacing="0" width="504">
    <tr>
        <td width="504" valign="top">
            <div align="left">
                <table border="0" cellpadding="0" cellspacing="0" width="990">
                    <tr>
                        <td width="200" bgcolor="white" background="img/side_bg.gif" valign="top" height="137">
<?
	include "menu_intro1.txt";
?>
                        </td>
                        <td width="700" height="137" valign="top" background="img/main_bg.gif">
                            <table border="0" cellpadding="0" width="630" align="center">
                                <tr>
                                    <td width="636" height="33">
                                        <p style="line-height:150%; margin-top:0; margin-bottom:0;" align="right">
                                        현재위치 : <a href="index.htm"><font color=blue>HOME</font></a> --&gt;
                                        <a href="intro1.htm"><font color=blue>클럽활동</font></a> --&gt;&gt;
                                        <font color="#333333">설문조사</font></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="660">            <p style="line-height:150%;" align="justify"><img src="img/intro1_01.gif" width="600" height="100" border="0"></p>
</td>
                                </tr>
                                <tr>
                                    <td width="660" align=center><br><br>
<?
//	if(date("Y-m-d") <= "2004-10-02"){
		include "member/prog/2004-1.q";
//	}else{
//		echo "<font size='+2'>진행중인 설문이 없습니다.</font>\n";
//	}
?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="660">
                                        <p align="justify" style="line-height:150%;">&nbsp;</p>
                                    </td>
                                </tr>
                            </table>
                            <div align="right">
                                <p>&nbsp;</p>
                            </div>
                        </td>
                        <td width="101" height="137" align="left" valign="top">
<?
	include "quickmenu.txt";
?>
                        </td>
                    </tr>
                    <tr>
                        <td width="990" colspan="3" bgcolor="#E7E3E7">
<?
	include "copyright.txt";
?>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>
</body>

</html>
