<?php
appendFooter('
<script src="'.getConfig('path').'/template/style/js/jquery.zclip.js" type="text/javascript"></script>
<script type="text/javascript">
$(\'#copy\').zclip({
path:\''.getConfig('path').'/template/style/zclip.swf\',
copy:function(){return $(\'#invitation\').val();},
afterCopy: function(){alert("'.langItem("linkCopy").'"); return false;}
});
</script>
');
?>
<div class="right" id="content">
	<h1 class="title"><?php ___("inviteMenu")?></h1>
	<div class="content">
		<p><?php ___("inviteFriend")?>:
			<input type="text" id="invitation" readonly value="http://<?php __($_SERVER['HTTP_HOST'])?><?php __(getConfig('path'))?>/invitation.php?u=<?php __(getElementByID('user',loggedUserID(),'user'))?>" style="width: 350px;padding: 5px;"/>
			<input type="button" class="button" id="copy" value="Copy"/>
		</p>
		<table class="userInvite" border="1">
			<thead>
				<th>#</th>
				<th><?php ___("username")?></th>
				<th><?php ___("fullName")?></th>
			</thead>
			<tbody>
		<?php
		$userid = loggedUserID();
		$q = mysql_query("SELECT * FROM `user` WHERE `invitedby`='{$userid}' ORDER by `creationDate` ASC");
		if(!mysql_num_rows($q))
			echo "<tr><td colspan=\"3\">".langItem('noUsers')."</td></tr>";
		else{
			$n = mysql_num_rows($q);
			$i = 1;
			while($r = mysql_fetch_assoc($q)){?>
				<tr>
					<td><?php __($i++)?></td>
					<td><?php __($r['user'])?></td>
					<td><?php __($r['firstname'].' '.$r['lastname'])?></td>
				</tr>
			<?php
			}
		}
		?>
			</tbody>
		</table>
	</div>
</div>