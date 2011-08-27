<div class="right" id="content" style="padding-top: 30px;">
	<h1 class="title"><?php ___("loginpageTitle")?></h1>
	<div class="content">
		<form action="<?php __(getConfig('path'))?>/login.php" id="loginForm" method="POST">
			<table style="width: 40%; margin-left: 50px;margin-top: 10px;">
				<tr>
					<th style="width: 10%;font-size: 20pt;padding: 3px;"><?php ___("username")?>:</th>
					<td>
						<input type="text" name="username" id="username" class="inputbox" value="" />
					</td>
				</tr>
				<tr>
					<th style="width: 10%;font-size: 20pt;padding: 3px;"><?php ___("password")?>:</th>
					<td>
						<input type="password" name="password" id="password" class="inputbox" value="" />
					</td>
				</tr>
				<tr>
					<th colspan="2">
						<div class="left" style="text-align: left;"><a href="<?php $this->core->createURL('/page/recovery',true)?>"><?php ___("passwordRecovery")?></a></div>
						<div class="right" style="text-align: right;"><input type="submit" class="button" value="<?php ___("loginButton")?>" onclick="return user_auth()" /></div>
						<div class="clear"></div>
					</th>
				</tr>
			</table>
		</form>
	</div>
</div>