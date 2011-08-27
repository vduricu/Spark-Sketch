<?php ob_end_clean();?>
<form action="<?php __(getConfig('path'))?>/save.php" id="saveForm">
<table>
	<tr>
		<th colspan="2" style="text-align: center;font-size: 20pt;color: #dc0000"><?php ___("saveCanvas")?></th>
	</tr>
	<tr>
		<td colspan="2" id="msgError">&nbsp;</td>
	</tr>
	<tr>
		<th style="width: 15%"><?php ___("canvasTitle")?>:</th>
		<td style="width: 85%"><input type="text" name="saveTitle" id="saveTitle" class="inputbox" value="" /></td>
	</tr>
	<tr>
		<th colspan="2"><input type="button" class="button" value="<?php ___("cancel")?>" onClick="$(document).trigger('close.facebox');">  <input type="button" class="button" id="saveButton" value="<?php ___("save")?>" onClick="saveCanvas()"></th>
	</tr>
</table>
<input type="hidden" id="galleryPath" value="<?php $this->core->createURL("/gallery/",true)?>"/>
</form>
<?php masterDie();?>