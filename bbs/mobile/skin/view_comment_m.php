<?
	if($is_admin) $show_comment_ip = $c_data['ip'];
	else $show_comment_ip = "";
?>
	<div class='ui-bar ui-bar-c' style='text-align:left;border:0px'>
		<?=$comment_name?> <?=date("Y-m-d H:i:s",$c_data[reg_date])?>
		<div style="float:right"><?=$a_del?>
		</div>
	</div>
	<div class='ui-body ui-body-d' style="border:0px"> 
		<div style="padding:20px 0;word-break:break-all;"><?=str_replace("\n","<br>",$c_memo)?></div> 
	</div> 
