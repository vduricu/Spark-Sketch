<form action="<?php __(getConfig("path"))?>/sk-admin/reportdraw.php" method="POST" id="reportForm">
	<input type="hidden" id="image" name="image" value="<?php __($image)?>"/>
	<input type="hidden" id="sentForm" name="sentForm" value="<?php __($image)?>"/>
	<table class="userdata">
		<tr>
			<th style="text-align: left;">Reason:</th>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2"><input type="textbox" name="reason" id="reason" value="" style="width: 90%;padding: 2px;font-size: 13pt;"/></td>
		</tr>
			<td colspan="2" style="text-align: center;">
				<input type="submit" class="button" value="<?php ___("send")?>" onClick="return makeReport()"/>
			</td>
		</tr>
	</table>
</form>