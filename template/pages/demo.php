<?php
appendFooter('<script src="'.getConfig('path').'/template/style/js/jquery.miniColors.js" type="text/javascript"></script>
	<script src="'.getConfig('path').'/template/style/js/jquery.sketchpad.js" type="text/javascript"></script>
	<link href="'.getConfig('path').'/template/style/jquery.miniColors.css" rel="stylesheet" type="text/css" />');
appendFooter('<script type="text/javascript">
		$("#dpad").sketchpad({
			width: 850,
			height: 580,
			lineColor: "#000000",
			backgroundColor: "#ffffff",
			lineWidth: 5
		});
		$("#canvasContent #tools li").tipsy({fade: true,gravity: \'w\'});
		$(\'a[rel*=facebox]\').facebox();
	</script>');
?>
<div class="right" id="canvasContent">
	<div class="left" id="tools">
		<ul>
			<li title="<?php ___("save")?>">
				<a href="<?php $this->core->createURL("/saveCanvasDemo",true)?>" rel="facebox"><img src="<?php themePath();?>/style/images/save.png" alt="save"/></a>
			</li>
			<li style="cursor: default;" title="<?php ___("fgdColor")?>">
				<input type="hidden" name="brushColor" id="brushColor" class="colors" size="7" value="#000000" />
			</li>
			<li style="cursor: default;" title="<?php ___("bkgColor")?>">
				<input type="hidden" name="canvasColor" id="canvasColor" class="colors" size="7" value="#ffffff" />
			</li>
			<li class="no-text" id="changeColor" title="<?php ___("changeColor")?>">&nbsp;</li>
			<li class="no-text" id="resetColor" title="<?php ___("resetColor")?>">&nbsp;</li>
			<li class="no-text" id="clearCanvas" title="<?php ___("clearCanvas")?>">&nbsp;</li>
		</ul>
		<input type="hidden" name="finalCanvasColor" id="finalCanvasColor" value="#ffffff" />
	</div>
	<div class="right" id="canvas">
		<div id="dpad"></div>
	</div>
	<div class="clear"></div>
	<p style="text-align: center;"><?php __(sprintf(langItem("demoNotice"),$this->core->createURL('/page/register'),$this->core->createURL('/page/login')))?></p>
</div>