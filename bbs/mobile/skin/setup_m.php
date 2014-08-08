<div data-role="page" >
	<div data-role="header" class="backgroundStyle">
		<?php if($pageType == "write"){?>
		<?=$a_write?>
		<?php } ?>
		<h1><?= ($setup[title])?$setup[title]:$setup[name]?></h1>
    <a href="/" rel="external" data-icon="refresh" class="backgroundStyle ui-btn-left" >Home</a> 
	</div><!-- /header -->
