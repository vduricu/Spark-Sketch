<div class="content adminContent">
	<div class="aSMenu">
		<a href="./?zona=desene&pagina=lista">Lista Desene Acceptate <span>(<?php __(howMany("draws","status","approved"))?>)</span></a>&nbsp;
		|&nbsp;<a href="./?zona=desene&pagina=waiting">Desene In Asteptare <span>(<?php __(howMany("draws","status","waiting"))?>)</span></a>&nbsp;
		|&nbsp;<a href="./?zona=desene&pagina=raportate">Desene Raportate <span>(<?php __(howMany("draws","status","reported"))?>)</span></a>&nbsp;
		|&nbsp;<a href="./?zona=desene&pagina=moderate" class="current">Desene Moderate <span>(<?php __(howMany("draws","moderated","yes"))?>)</span></a>&nbsp;
		|&nbsp;<a href="./?zona=desene&pagina=deleted">Desene Sterse <span>(<?php __(howMany("draws","status","deleted"))?>)</span></a>
	</div>
	<form action="admin.php?zona=draws" method="POST">
	<table border="1" class="table_data" id="draws">
		<thead class="sirop">
			<tr>
				<th style="width: 3%">&nbsp;</th>
				<th style="width: 15%;">De</th>
				<th style="width: 30%;">Titlu</th>
				<th style="width: 15%;"><acronym title="Raportat">Rap.</acronym> de</th>
				<th style="width: 15%;">Moderat de</th>
				<th style="width: 14%;">Data</th>
				<th style="width: 8%;">Actiune</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$q=mysql_query("SELECT * FROM `draws` WHERE `moderated`='yes' ORDER by `modificationdate` DESC");
		$i=0;
		while($r=mysql_fetch_assoc($q)){
			$trClass = "";
			if($i%2) $trClass = " class=\"v\"";
			$i=1-$i;
		?>
			<tr <?php __($trClass)?>>
				<td style="width: 3%; text-align: right;vertical-align: middle"><input type="checkbox" name="item[]" value="<?php __($r['filename'])?>" /></td>
				<td style="width: 15%;">
					<?php __($spkcore->userinfo($r['userid'],'user'))?>
					<?php if($r['userid']==0){?>
					<br /><?php __($r['ip'])?>
					<?php }?>
				</td>
				<td style="width: 30%;"><?php __($r['title'])?><hr /><a href="<?php __(getConfig('path')."/files.php?id=".$r['filename'].($r['type']=='extended'&&$r['bkgcolor']!='none'?'&extended=1':''))?>" target="_blank" rel="facebox"><?php __($r['filename'])?></td>
				<td style="width: 15%;">
					<?php __($spkcore->userinfo($r['reportedby'],'user'))?>
				</td>
				<td style="width: 15%;">
					<?php __($spkcore->userinfo($r['moderatedby'],'user'))?>
				</td>
				<td style="width: 14%; text-align: center;"><?php __(date("H:i:s d-m-Y",strtotime($r['reportdata'])))?></td>
				<td style="width: 8%;text-align: center;clear: both;">
					<?php if($r['status']!='approved'){?>
					<input type="button" class="ui-admin ui-approve" title="Aproba" value="&nbsp;" onClick="photoModif('approve','<?php __($r['filename'])?>')"/>
					<?php }?>
					<input type="button" class="ui-admin ui-edit" title="Editeaza" value="&nbsp;" onClick="editDraw('<?php __($r['filename'])?>')"/>
					<input type="button" class="ui-admin ui-delete" title="Sterge" value="&nbsp;" onClick="confirm<?php __($r['status']=='deleted'?'F':'')?>Delete('<?php __($r['filename'])?>')"/>
				</td>
			</tr>
		<?php }?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="7" style="text-align: right">
				<select name="action">
					<option value="">&nbsp;</option>
					<option value="mapprove">Aproba</option>
					<option value="mdelete">Sterge</option>
				</select>
				<input type="submit" class="button" value="Executa"/></td>
			</tr>
		</tfoot>
	</table>
	</form>
</div>
