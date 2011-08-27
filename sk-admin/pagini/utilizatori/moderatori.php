<?php

if(loggedUserRank()!='admin')
	masterRedirect($spkcore->createURL("/404"));
?>
<div class="content adminContent">
	<div class="aSMenu">
		<a href="./?zona=utilizatori&pagina=lista">Lista Utilizatori</a> | <a href="./?zona=utilizatori&pagina=moderatori" class="current">Lista Moderatori</a>
	</div>
	<table border="1" class="table_data" id="userData">
		<thead>
			<tr>
				<th style="width: 3%">&nbsp;</th>
				<th class="username">Utilizator</th>
				<th class="rank">Rank<br /><span class="info"><acronym title="Admin">Adm</acronym>/<acronym title="Moderator">Mod</acronym></th>
				<th class="email">Email</th>
				<th class="firstname">Prenume</th>
				<th class="lastname">Nume</th>
				<th class="activated">Activat</th>
				<th class="invitedby">Invitat de</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$q=mysql_query("SELECT * FROM `user` WHERE `id`!=0 AND `rank`!='user' ORDER by `id` DESC");
		$i=0;
		while($r=mysql_fetch_assoc($q)){
		$trClass = "";
		if($i%2) $trClass = " class=\"v\"";
		$i=1-$i;
		?>
			<tr <?php __($trClass)?> onClick="launchUAdmin('<?php __($r['user'])?>')">
				<td style="width: 3%; text-align: center;"><?php __($r['id'])?></td>
				<td class="username"><?php __($r['user'])?></td>
				<td class="rank"><?php __($r['rank'])?></td>
				<td class="email"><?php __($r['email'])?></td>
				<td class="firstname"><?php __($r['firstname'])?></td>
				<td class="lastname"><?php __($r['lastname'])?></td>
				<td class="activated"><?php __($r['activated'])?></td>
				<td class="invitedby"><?php __($r['invitedby']?$spkcore->userinfo($r['invitedby'],'user'):'-')?></td>
			</tr>
		<?php }?>
		</tbody>
	</table>
</div>
