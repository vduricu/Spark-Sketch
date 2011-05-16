<?php
if(!isset($_SESSION['sk_user'])){
	masterRedirect("/");
}
?>
<? require_once("tpl/top.php");?>
	<div class="content adminContent">
		<table border="1">
			<thead>
				<tr>
					<th class="username"><?=$language['auUsername']?></th>
					<th class="rank"><?=$language['auRank']?></th>
					<th class="email"><?=$language['auEmail']?></th>
					<th class="firstname"><?=$language['auFirstName']?></th>
					<th class="lastname"><?=$language['auLastName']?></th>
					<th class="quota"><?=$language['auQuota']?></th>
					<th class="activated"><?=$language['auActivated']?></th>
				</tr>
				<tr class="info">
					<th class="username">&nbsp;</th>
					<th class="rank"><?=$language['admin']?> / <?=$language['user']?></th>
					<th class="email">&nbsp;</th>
					<th class="firstname">&nbsp;</th>
					<th class="lastname">&nbsp;</th>
					<th class="quota"># <?=$language['photos']?></th>
					<th class="activated"><?=$language['yes']?> / <?=$language['no']?></th>
				</tr>
			</thead>
			<tbody>
			<?php
				$q=mysql_query("SELECT * FROM `user` ORDER by `id`");
				$i=0;
				while($r=mysql_fetch_assoc($q)){
					$trClass = "";
					if($i%2) $trClass = " class=\"v\"";
					$i=1-$i;
					?>
				<tr <?=$trClass?> onClick="showUAdmin('#users','<?=$r['user']?>','<?=$r['rank']?>','<?=$r['quota']?>','<?=$r['activated']?>','<?=$language['confirm']?>');">
					<td class="username"><?=$r['user']?></td>
					<td class="rank"><?=$language[$r['rank']]?></td>
					<td class="email"><?=$r['email']?></td>
					<td class="firstname"><?=$r['firstname']?></td>
					<td class="lastname"><?=$r['lastname']?></td>
					<td class="quota"><?=$r['quota']=='-1'?'&infin;':$r['quota']?></td>
					<td class="activated"><?=$language[$r['activated']]?></td>
				</tr>
			<?}?>
			</tbody>
		</table>
	</div>
<div id="boxes">
	<div id="users" class="window">
		<h3>User: <span id="user">&nbsp;</span></h3>
		<ul>
			<li id="rank"><img src="/style/admin/rank.png" alt="rank"/><br /><?=$language['rank']?></li>
			<li id="quota"><img src="/style/admin/quota.png" alt="quota"/><br /><?=$language['quota']?></li>
			<li id="activate"><img src="/style/admin/activate.png" alt="activate"/><br /><?=$language['activate']?></li>
			<li id="deactivate"><img src="/style/admin/deactivate.png" alt="deactivate"/><br /><?=$language['deactivate']?></li>
			<li id="delete"><img src="/style/admin/delete.png" alt="delete"/><br /><?=$language['delete']?></li>
		</ul>
	</div>
	<div id="mask"></div>
</div>
<div id="modalMsg"></div>
	<? require_once("tpl/footer.php"); ?>
