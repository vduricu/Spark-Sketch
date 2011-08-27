<?php
$path = getConfig('path');
$image = "{$path}/files.php?id={$this->core->getURL(1)}";
appendFooter('<script src="'.getConfig('path').'/template/style/js/jquery.miniColors.js" type="text/javascript"></script>
	<script src="'.getConfig('path').'/template/style/js/jquery.sketchpad.js" type="text/javascript"></script>
	<link href="'.getConfig('path').'/template/style/jquery.miniColors.css" rel="stylesheet" type="text/css" />');
appendFooter('<script type="text/javascript">
		$("#dpad").sketchpad({
			width: '.getConfig('default_width').',
			height: '.getConfig('default_height').',
			lineColor: "#000000",
			backgroundColor: "#ffffff",
			lineWidth: 1
		});
		$("#canvasContent #tools li").tipsy({fade: true,gravity: \'w\'});
		$(\'a[rel*=facebox]\').facebox();
		loadImage("'.$image.'");
	</script>');
?>
<div class="right" id="canvasContent">
	<div class="left" id="tools">
		<ul>
			<?php
				require_once('canvas_tools.php');
			?>
		</ul>
	</div>
	<div class="right" id="canvas">
		<div id="dpad"></div>
	</div>
	<div class="clear"></div>
</div>