<h1><?php ___("circleTool")?></h1>
<table>
	<tr>
		<th><?php ___("width")?>:</th>
		<td><select id="lineWidth" class="select" onchange="changelineWidth();">
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3" selected>3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		<option value="7">7</option>
		<option value="8">8</option>
		<option value="9">9</option>
		<option value="10">10</option>
		</select></td>
	</tr>
	<tr>
		<th><?php ___("fill")?>:</th>
		<td><input type="checkbox" name="fill" id="fill" value="fill" checked/><label for="fill">Yes</label></td>
	</tr>
	<tr>
		<th><?php ___("stroke")?>:</th>
		<td><input type="checkbox" name="stroke" id="stroke" value="stroke" checked/><label for="stroke">Yes</label></td>
	</tr>
</table>