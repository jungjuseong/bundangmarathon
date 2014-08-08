
<SCRIPT LANGUAGE="JavaScript">
<!--
//2004-03-20 오전 11:36
  function move_page() {
	var EventStatus = event.srcElement.tagName;
	if(EventStatus!='INPUT'&&EventStatus!='TEXTAREA') {
		<?if($prev_data[no]){?>if (event.keyCode=='37') location.href="<?echo "$_zb_exec?$href&$sort&no=$prev_data[no]"?>"<?}?>;
		<?if($next_data[no]){?>if (event.keyCode=='39') location.href="<?echo "$_zb_exec?$href&$sort&no=$next_data[no]"?>"<?}?>;
		<?if(!$prev_data[no]){?>if (event.keyCode=='37') alert("맨 처음입니다.");<?}?>
		<?if(!$next_data[no]){?>if (event.keyCode=='39') alert("맨 끝입니다.");<?}?>

		<?if($skin_setup[using_comment] && $member['level']<=$setup['grant_comment']){?>
		if (event.keyCode=='32') {
			var bottom = document.body.scrollHeight - document.body.clientHeight;
			document.write.memo.focus();
			window.scrollTo(0,bottom);
		}
		<?}?>
	}
  }
  document.body.onkeyup=move_page;
//-->
</SCRIPT>
