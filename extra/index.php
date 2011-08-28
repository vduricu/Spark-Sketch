<?php
session_start();
require_once('../engine/master.php');

if(!isset($_SESSION['sk_user'])){
	masterRedirect($spkcore->createURL("/"));
}

$edit = false;
$title = '';
$bkgColor = "#ffffff";
$deafult_width = getConfig('default_width');
$deafult_height = getConfig('default_height');

$heights = $widths = array('120','240','320','480','580','640','720','800','850','960','1080','1200','1280','1360','1440','1520','1600','1780','1860','1920','2000','2130','2250','2370','2490');

if(isset($_GET['type']))
	if($_GET['type']=='edit'){
		$filename = filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING);
		$path = getConfig('path');
		$image = "{$path}/files.php?id={$filename}";
		$edit = true;
		$title = getElementByField("draws","filename",$filename,'title');
		$bkgColor = getElementByField("draws","filename",$filename,'bkgcolor');
		$deafult_width = getElementByField("draws","filename",$filename,'width');
		$deafult_height = getElementByField("draws","filename",$filename,'height');
		if($bkgColor=='axis'||$bkgColor=='none')
			$bkgColor = "#ffffff";
	}
?>
<!DOCTYPE html>
<html lang="ro-RO">
	<head>
		<title>
		<?php
		if($edit)
			__($title." &raquo; ");
		___("eDPTitle");
		?>
		</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="author" content="Copyright 2011 (c) Duricu Valentin" />
		<meta name="Generator" content="Spark Sketch v<?php __($spkcore->version('number'))?>"/>

		<meta name="rating" content="general" />
		<meta name="robots" content="all,follow" />

		<script src="<?php themePath();?>/style/js/jquery.js" type="text/javascript"></script>
		<script src="style/ui.js" type="text/javascript"></script>
		<script src="<?php themePath();?>/style/js/jquery.tipsy.js" type="text/javascript"></script>
		<script src="style/colorpicker/jpicker.js" type="text/javascript"></script>
		<link href="<?php themePath();?>/style/jquery.tipsy.css" rel="stylesheet" type="text/css" />

		<link href="style/style.css" rel="stylesheet" type="text/css" />
		<link href="style/ui/ui.css" rel="stylesheet" type="text/css" />
		<link href="style/colorpicker/jpicker.css" rel="stylesheet" type="text/css" />

		<link rel="shortcut icon" href="<?php themePath();?>/style/images/favicon.ico" type="image/x-icon" />

		<script type="text/javascript">
		$(function(){
			$.fn.jPicker.defaults.images.clientPath='style/colorpicker/images/';
			$('#fgdColor').jPicker({
				window:	{
					expandable:	true,
					title:		'<?php ___("fgdColor")?>',
					effects:	{
						type: 'fade'
					}
				}
			},
			function(color){
				var all = color.val('all');
				changeLineColor("#"+all.hex);
			});
			$('#bkgColor').jPicker({
				window:	{
					expandable:	true,
					title:		'<?php ___("bkgColor")?>',
					effects:	{
						type: 'fade'
					}
				}
			},
			function(color){
				var all = color.val('all');
				changeBkgColor("#"+all.hex);
			});
        });
		</script>
		<style type="text/css">
.canvas{
	width: <?php __($deafult_width)?>px;
	height: <?php __($deafult_height)?>px;
}
		</style>
	</head>
	<body>
		<div class="content">
			<div class="canvas">
				<canvas id="drawingPad" width="<?php __($deafult_width)?>" height="<?php __($deafult_height)?>"></canvas>
			</div>
		</div>
		<div class="toolstrip">
			<div class="topMenu">
				<ul>
					<li><a href="#" onclick="return newDraw();" title="<?php ___("new")?>" class="no-text new">&nbsp;</a></li>
					<li><a href="#" onclick="return saveDraw();" title="<?php ___("save")?>" class="no-text save">&nbsp;</a></li>
					<li><a href="#" onclick="return previewDraw();" title="<?php ___("preview")?>" class="no-text preview">&nbsp;</a></li>
					<li><a href="#" onclick="return aboutApp();" title="<?php ___("about")?>" class="no-text info">&nbsp;</a></li>
					<li><a href="../" title="<?php ___("close")?>" class="no-text close">&nbsp;</a></li>
				</ul>
				<div class="clear"></div>
				<ul>
					<li><a href="#" onclick="return undo();" title="<?php ___("undo")?>" class="no-text undo">&nbsp;</a></li>
					<li><a href="#" onclick="return redo();" title="<?php ___("redo")?>" class="no-text redo">&nbsp;</a></li>
					<li><a href="#" onclick="return settings();" title="<?php ___("settings")?>" class="no-text settings">&nbsp;</a></li>
					<li><a href="#" onclick="return clearCanvas();" title="<?php ___("clearCanvas")?>" class="no-text clearb">&nbsp;</a></li>
				</ul>
				<div class="clear"></div>
			</div>
			<div class="toolsMenu">
				<div class="widget">
					<div class="wtitle"><?php ___("colorTitle")?></div>
					<div class="wcontent">
						<input id="fgdColor" type="hidden" value="000000" />&nbsp;<input id="bkgColor" type="hidden" value="<?php __($bkgColor)?>" onchange="changeBkgColor()" />&nbsp;
						<input type="button" id="swapColors" title="<?php ___("changeColors")?>" onclick="swapColors()"/>&nbsp;
						<input type="button" id="defaultColors" title="<?php ___("resetColors")?>" onclick="defaultColors()"/>
					</div>
				</div>
				<div class="widget">
					<div class="wtitle"><?php ___("toolsTitle")?></div>
					<div class="wcontent">
						<ul class="tools" id="tools">
							<li><input type="button" class="tool brush active" id="brush" title="<?php ___("brushTool")?>" onclick="setTool('brush');"/></li>
							<li><input type="button" class="tool line" id="line" title="<?php ___("lineTool")?>" onclick="setTool('line');"/></li>
							<li><input type="button" class="tool elipse" id="circle" title="<?php ___("circleTool")?>" onclick="setTool('circle');"/></li>
							<li><input type="button" class="tool rectangle" id="rectangle" title="<?php ___("rectangleTool")?>" onclick="setTool('rectangle');"/></li>
							<li><input type="button" class="tool text" id="text" title="<?php ___("textTool")?>" onclick="setTool('text');"/></li>
						</ul>
						<p class="clear"></p>
					</div>
				</div>
				<div class="widget">
					<div class="wtitle"><?php ___("bkgColor")?></div>
					<div class="wcontent">
						<ul class="tools">
							<li><input type="button" class="tool bkgFill" id="bkgFill" title="<?php ___("bkgFill")?>" onClick="fillBkg();"/></li>
							<li><input type="button" class="tool bkgAxis" id="bkgAxis" title="<?php ___("bkgAxis")?>" onclick="drawAxis();"/></li>
						</ul>
						<p class="clear"></p>
					</div>
				</div>
			</div>
			<div id="properties"></div>
		</div>
		<div class="modals">
			<div id="settingsDialog" title="<?php ___("settings")?>">
				<table>
					<tr>
						<th style="text-align: center;font-size: 14pt;color: #dc0000;" colspan="2"><?php ___("canvasSize")?></th>
					</tr>
					<tr>
						<th><?php ___("cwidth")?></th>
						<td><select name="width" id="cwidth">
							<?php foreach($widths as $width)
								if($width == $deafult_width){?>
<option value="<?php __($width)?>" selected><?php __($width)?></option>
								<?php }else{?>
<option value="<?php __($width)?>"><?php __($width)?></option>
								<?php }?>
						</select></td>
					</tr>
					<tr>
						<th><?php ___("cheight")?></th>
						<td><select name="height" id="cheight">
							<?php foreach($heights as $height)
							if($height == $deafult_height){?>
<option value="<?php __($height)?>" selected><?php __($height)?></option>
								<?php }else{?>
<option value="<?php __($height)?>"><?php __($height)?></option>
								<?php }?>
						</select></td>
					</tr>
					<tr>
						<td style="text-align: center;font-size: 14pt;color: #dc0000;" colspan="2">
							<input type="button" class="sbutton" value="<?php ___("modify")?>" onClick="modifyCanvas();" />
						</td>
					</tr>
				</table>
			</div>
			<div id="about" title="<?php ___("about")?>">
				<table>
					<tr>
						<td colspan="2" style="text-align: center;">
							<img src="../template/style/images/logo.png" alt="logo" />
						</td>
					</tr>
					<tr>
						<th>Spark Sketch</th>
					</tr>
					<tr>
						<td>v0.3.0-ilarie_voronca</td>
					</tr>
					<tr>
						<td>2011 &copy; Duricu Valentin.</td>
					</tr>
				</table>
			</div>
			<div id="saveDialog" title="<?php ___("saveCanvas");?>">
				<table>
					<tr>
						<th colspan="2" style="text-align: center;" class="title"><?php ___("saveCanvas");?></th>
					</tr>
					<tr>
						<th><?php ___("canvasTitle");?></th>
						<td><input type="textbox" class="sinput" name="canvasTitle" id="canvasTitle" value="<?php __($title)?>"/></td>
					</tr>
					<tr>
						<th colspan="2">
							<span id="msgError"></span>
							<input type="button" class="sbutton" id="saveButton" value="<?php ___("save");?>" onclick="saveCanvas();"/>
						</th>
					</tr>
				</table>
			</div>
			<div id="msgDialog" title="<?php ___("systemMessage")?>"></div>
		</div>
		<script type="text/javascript">
			var contentWidth = window.innerWidth - 301;
			var contentHeight = window.innerHeight;
			$(".content").css({width: contentWidth,height: contentHeight});

			$(window).resize(function(){
				contentWidth = window.innerWidth - 301;
				contentHeight = window.innerHeight;
				$(".content").css({width: contentWidth,height: contentHeight});
			});
		</script>
		<script src="style/drawingpad.js" type="text/javascript"></script>
		<?php if($edit){?>
		<script type="text/javascript">
				<?php
				$bkg = getElementByField("draws","filename",$filename,'bkgcolor');
				if($bkg=='axis'){
					__("drawAxis();\n");
				}elseif($bkg!='none'){
					__("fillBkgEdit('{$bkg}');\n");
				}
				?>
				loadImage("<?php __($image)?>");
				setType('edit','<?php __($filename)?>');
		</script>
		<?php }?>

	</body>
</html>

<?php
ob_end_flush();
?>