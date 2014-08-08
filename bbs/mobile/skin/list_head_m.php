<script type="text/javascript">
$("#selectCategory").live("change", function() {
	$.mobile.ajaxFormsEnabled = false;
	$("#search #category").val($(this).val());
	$("#search").submit();
});
</script>
	<form method=get name=search id=search action=<?=$PHP_SELF?>>
		<input type=hidden name=id value=<?=$id?>>
		<input type=hidden name=select_arrange value=<?=$select_arrange?>>
		<input type=hidden name=desc value=<?=$desc?>>
		<input type=hidden name=page_num value=<?=$page_num?>>
		<input type=hidden name=selected>
		<input type=hidden name=exec>
		<input type=hidden name=sn value="<?=$sn?>">
		<input type=hidden name=ss value="<?=$ss?>">
		<input type=hidden name=sc value="off">
		<input type=hidden name=category id=category value="<?=$category?>">
	</form>
	<div data-role="content">
	<?=$hide_category_start?>
		<div data-type="horizontal" style="margin:0 0 0 0;"> 
			<?=$a_category?>
		</div> 
	<?=$hide_category_end?>
		<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">
			<li data-role="list-divider">TOTAL: <?=$setup[total_article]?>건, 현재: <?=$page?>/<?=$total_page?> 페이지</li>