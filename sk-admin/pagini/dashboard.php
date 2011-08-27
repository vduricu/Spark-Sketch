<div class="content adminContent">
	<div class="box">
		<div class="title">Desene Noi</div>
		<div class="text">
			<table border="1">
				<thead>
					<tr>
						<th class="dtitle">Titlu</th>
						<th class="dfilename">Filename</th>
						<th class="dusername">Utilizator</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$q=mysql_query("SELECT * FROM `draws` ORDER by `id` DESC LIMIT 0,5");
				if(mysql_num_rows($q)){
				$i=0;
				while($r=mysql_fetch_assoc($q)){
				$trClass = "";
				if($i%2) $trClass = " class=\"v\"";
				$i=1-$i;
				?>
						<tr <?php __($trClass)?>>
							<td class="dtitle"><?php __($r['title'])?></td>
							<td class="dfilename"><?php __($r['filename'])?></td>
							<td class="dusername"><?php __($spkcore->userinfo($r['userid'],'user'))?></td>
						</tr>
					<?php }?>

				<?php }else{?>
				<tr>
					<td colspan="3">Nu exista desene</td>
				</tr>
				<?php }?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="box">
		<div class="title">Desene Raportate</div>
		<div class="text">
			<table border="1">
				<thead>
					<tr>
						<th class="dtitle">Titlu</th>
						<th class="dfilename">Filename</th>
						<th class="dusername">Utilizator</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$q=mysql_query("SELECT * FROM `draws` WHERE `status`='reported' ORDER by `id` DESC LIMIT 0,5");
				if(mysql_num_rows($q)){
					$i=0;
					while($r=mysql_fetch_assoc($q)){
					$trClass = "";
					if($i%2) $trClass = " class=\"v\"";
					$i=1-$i;
					?>
						<tr <?php __($trClass)?>>
							<td class="dtitle"><?php __($r['title'])?></td>
							<td class="dfilename"><?php __($r['filename'])?></td>
							<td class="dusername"><?php __($spkcore->userinfo($r['userid'],'user'))?></td>
						</tr>
					<?php }?>

				<?php }else{?>
				<tr>
					<td colspan="3">Nu exista desene</td>
				</tr>
				<?php }?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="clear"></div>
	<div class="box">
		<div class="title">Desene in Asteptare</div>
		<div class="text">
			<table border="1">
				<thead>
					<tr>
						<th class="dtitle">Titlu</th>
						<th class="dfilename">Filename</th>
						<th class="dusername">Utilizator</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$q=mysql_query("SELECT * FROM `draws` WHERE `status`='waiting' ORDER by `id` DESC LIMIT 0,5");
				if(mysql_num_rows($q)){
				$i=0;
				while($r=mysql_fetch_assoc($q)){
				$trClass = "";
				if($i%2) $trClass = " class=\"v\"";
				$i=1-$i;
				?>
						<tr <?php __($trClass)?>>
							<td class="dtitle"><?php __($r['title'])?></td>
							<td class="dfilename"><?php __($r['filename'])?></td>
							<td class="dusername"><?php __($spkcore->userinfo($r['userid'],'user'))?></td>
						</tr>
					<?php }?>

				<?php }else{?>
				<tr>
					<td colspan="3">Nu exista desene</td>
				</tr>
				<?php }?>
				</tbody>
			</table>
		</div>
	</div>
	<?php if(loggedUserRank()=='admin'){?>
	<div class="box">
		<div class="title">Utilizatori Noi</div>
		<div class="text">
			<table border="1">
				<thead>
					<tr>
						<th class="username">Utilizator</th>
						<th class="rank">Rank<br /><span class="info"><acronym title="Admin">A</acronym>/<acronym title="Moderator">M</acronym>/<acronym title="User">U</acronym></span></th>
						<th class="name">Nume</th>
						<th class="activated">Activat<br /><span class="info">Da/Nu</span></th>
						<th class="invitedby">Invitat de</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$q=mysql_query("SELECT * FROM `user` WHERE `id`!=0 AND `id`!=1 ORDER by `id` DESC LIMIT 0,5");
				$i=0;
				while($r=mysql_fetch_assoc($q)){
				$trClass = "";
				if($i%2) $trClass = " class=\"v\"";
				$i=1-$i;
				?>
					<tr <?php __($trClass)?>>
						<td class="username"><?php __($r['user'])?></td>
						<td class="rank"><?php __($r['rank'])?></td>
						<td class="name"><?php __($r['firstname'].' '.$r['lastname'])?></td>
						<td class="activated"><?php __($r['activated'])?></td>
						<td class="invitedby"><?php __($r['invitedby']?$spkcore->userinfo($r['invitedby'],'user'):'-')?></td>
					</tr>
				<?}?>
				</tbody>
			</table>
		</div>
	</div>
	<?php }?>
	<div class="clear"></div>
</div>
