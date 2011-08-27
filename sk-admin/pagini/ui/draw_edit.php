<table class="userdata">
	<tr>
		<th>Titlu</th>
		<td><input type="textbox" class="textbox" id="drawtitle" value="<?php __($r['title'])?>"/></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: center;"><input type="button" class="button" value="Renunta" onClick="closeFacebox();"/> <input type="button" class="button" value="Modifica" onClick="photoModif('edit','<?php __($r['filename']);?>')"/></td>
	</tr>
</table>