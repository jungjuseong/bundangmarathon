<H2>������ ���� �ǰ� ����</H2>
<hr color=red width="90%">
<P>
<table width=500><tr><td>
<p>
���ο� �������� �ΰ��� ��ũ�� � ���·� �������� ȸ�� �������� �ǰ߿� �������� �ϰڽ��ϴ�.
<br>
7������ ����� �����, ����ο��� 1���� 3����(��ǥ��)�� ������ϴ�. �̴� ǥ�� �л��� �����ϱ� ���ؼ������ϴ�.
<br>
3���� �߿��� �ϳ��� ���� ������ �ֽñ� �ٶ��ϴ�. (�޸��� 2���� �߿��� ����) �ð��� ���� �ʱ� ������ 10�� 2�ϱ��� ��ǥ�� ������ ġ���� ���� �ֽø� ���ϴµ� ������ �ǰڽ��ϴ�.
<br>
������ ������ Ȯ�������� �ʾҽ��ϴٸ� ���� 60,000�� ������ ������ �� �����ϴ�. �������� �����ΰ� Į��� �����ϳ� Ư���� �����, ��Ƽ ���ָӴϵ� ������ �� ���� ����� �ణ ũ�� ���鵵�� �ֹ����� �մϴ�.
<br>
������ ǥ��ġ�� : 90, 95, 100, 105, 110
<p>
*** ��ǥ�� 9.25 ~ 10.2 �� �ѹ��� �����ϹǷ� ������ ó���Ͻñ� �ٶ��ϴ�. ***
</table>
<p>
<TABLE border=1>
<form name=pollform method=post action=pollanswer.php>
<input type=hidden name="pollid" value="2004-1">
<tr><td align=center>
<TABLE border=1>
<td colspan=3>
<br><br>
����1. ������ ���� ������ ����
<br><br>
<tr>
<td width=230 align=center>
<img src='/member/prog/img/uniform-front-a.jpg'><br>
�д縶����Ŭ�� : �ܼ� �ν� ����, ��ũ ȫ�� �Ұ�<br><br>
<input type="radio" name="rule0" value="A">A��
<td width=230 align=center>
<img src='/member/prog/img/uniform-front-b.jpg'><br>
�ɺ� ��ũ �⺻�� : Ŭ�� ȫ�� ����, �ټ� ���� <br><br>
<input type="radio" name="rule0" value="B">B��
<td width=230 align=center>
<img src='/member/prog/img/uniform-front-c.jpg'><br>
�д�+�ɺ� ��ũ : ��ũ, ��Ī ���� ȫ�� ����, ���� ����<br><br>
<input type="radio" name="rule0" value="C">C��
</table>
<p>
<TABLE border=1>
<tr><td colspan=2>
<br><br>
����2. ������ �ĸ� ������ ����
<br><br>
<tr>
<td align=center>
<img src='/member/prog/img/uniform-back-a.jpg'><br><br>
<input type="radio" name="rule1" value="A">A��
<td align=center>
<img src='/member/prog/img/uniform-back-b.jpg'><br><br>
<input type="radio" name="rule1" value="B">B��
</table>
<p>
<TABLE border=1>
<tr><td colspan=5>
<br><br>
����3. ������ ������ ġ�� ����
<br><br>
<tr>
<td>
<input type="radio" name="rule2" value="90">90 &nbsp;
<td>
<input type="radio" name="rule2" value="95">95 &nbsp;
<td>
<input type="radio" name="rule2" value="100">100 &nbsp;
<td>
<input type="radio" name="rule2" value="105">105 &nbsp;
<td>
<input type="radio" name="rule2" value="110">110 &nbsp;
</table>

</TABLE>
<P>
<input type=submit value="�� ���� ������ �ٽ� �ѹ� Ȯ�� �� ���⸦ ���� �ֽʽÿ�." onClick="javascript:return(chk_data(this.form))">
</form>
<p align=center>
<a href="pollanswer.php?pollid=2004-1">��� ����</a>
</center>
<br>
<SCRIPT LANGUAGE="javascript">
function chk_checked(rn) {
	for(var i = 0; i < rn.length; i++){
		if(rn[i].checked)
			return true;
	}
	return false;
}

function chk_data(form) {
/*
    {
	alert("��ǥ �Ⱓ�� �ƴ϶� ��ǥ�� �� �����ϴ�.");
	return false;
    }
*/
	if (chk_checked(form.rule0) == false) {
		alert("����1�� ���Ͻʽÿ�.");
		return false;
	}
	if (chk_checked(form.rule1) == false) {
		alert("����2�� ���Ͻʽÿ�.");
		return false;
	}
	if (chk_checked(form.rule2) == false) {
		alert("����3�� ���Ͻʽÿ�.");
		return false;
	}

    return true;
}
</SCRIPT>