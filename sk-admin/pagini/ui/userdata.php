<table class="userdata">
	<tr>
		<th>Username:</th>
		<td><?php __($r['user'])?></td>
	</tr>
	<tr>
		<th>Prenume:</th>
		<td><?php __($r['firstname'])?></td>
	</tr>
	<tr>
		<th>Nume:</th>
		<td><?php __($r['lastname'])?></td>
	</tr>
	<tr>
		<th>Rank:</th>
		<td>
			<?php if($r['id']==1){
			__($r['rank']);
			}else{?>
			<select id="userrank">
				<option value="user" <?php __($r['rank']=='user'?'selected':'');?>>User</option>
				<option value="moderator" <?php __($r['rank']=='moderator'?'selected':'');?>>Moderator</option>
				<option value="admin" <?php __($r['rank']=='admin'?'selected':'');?>>Administrator</option>
			</select>
			&nbsp;<input type="button" class="button" value="Modifica" onClick="makeModifications('rank','<?php __($r['user'])?>')"/>
			<?php }?>
		</td>
	</tr>
	<?php if($r['id']!=1){?>
	<tr>
		<th>Activat:</th>
		<td>

			<select id="useractivated">
				<option value="yes" <?php __($r['activated']=='yes'?'selected':'');?>>Yes</option>
				<option value="no" <?php __($r['activated']=='no'?'selected':'');?>>No</option>
			</select>
			&nbsp;<input type="button" class="button" value="Modifica" onClick="makeModifications('activated','<?php __($r['user'])?>')"/>
		</td>
	</tr>
	<tr>
		<th>Delete:</th>
		<td><input type="button" class="button" value="Sterge" onClick="makeModifications('delete','<?php __($r['user'])?>')"/></td>
	</tr>
	<?}?>
</table>