<?php ob_end_clean();?>
<form action="<?php __(getConfig('path'))?>/save.php" id="saveForm">
<table>
	<tr>
		<th colspan="2" style="text-align: center;font-size: 20pt;color: #dc0000"><?php ___("overwriteDraw")?></th>
	</tr>
	<tr>
		<td colspan="2" style="text-align: center;"><?php ___("overwriteNotice")?></td>
	</tr>
	<tr>
		<th style="width: 15%"><?php ___("canvasTitle")?>:</th>
		<td style="width: 85%"><input type="text" name="saveTitle" id="saveTitle" class="inputbox" value="" /></td>
	</tr>
	<tr>
		<td colspan="2" id="msgError">&nbsp;</td>
	</tr>
	<tr>
		<th colspan="2"><input type="button" class="button" value="<?php ___("no")?>" onClick="$(document).trigger('close.facebox');"> <input type="button" class="button" id="overwriteButton" value="<?php ___("yes")?>" onClick="overwriteCanvas()"></th>
	</tr>
</table>
<input type="hidden" id="galleryPath" value="<?php $this->core->createURL("/gallery/",true)?>"/>
</form>
<script type="text/javascript">
	$("#saveTitle").val($("#canvasTitle").val());
</script>
<?php masterDie();?>