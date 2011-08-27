<div class="right" id="content" style="padding-top: 30px;">
	<h1 class="title"><?php ___("recoveryTitle")?></h1>
	<div class="content">
		<form action="<?php __(getConfig('path'))?>/recovery.php" id="recoveryForm" method="POST">
			<table style="width: 40%; margin-left: 50px;margin-top: 10px;">
				<tr>
					<th style="width: 10%;font-size: 20pt;padding: 3px;"><?php ___("username")?>:</th>
					<td>
						<input type="text" name="username" id="username" class="inputbox" value="" />
					</td>
				</tr>
				<tr>
					<th style="width: 10%;font-size: 20pt;padding: 3px;"><?php ___("email")?>:</th>
					<td>
						<input type="text" name="email" id="email" class="inputbox" value="" />
					</td>
				</tr>
				<tr>
					<th colspan="2">
						<input type="submit" class="button" value="<?php ___("recoveryButton")?>" onclick="return passrec()" />
					</th>
				</tr>
			</table>
		</form>
	</div>
</div>