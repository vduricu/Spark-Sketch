<div class="right" id="content" style="padding-top: 30px;">
	<h1 class="title"><?php ___("registerpageTitle")?></h1>
	<div class="content">
	<?php if(getConfig('registration')=='closed'){
		___("registerDisabled");
	}else{?>
		<form action="<?php __(getConfig('path'))?>/register.php" id="registerForm" method="POST">
			<table style="width: 60%; margin-left: 50px;margin-top: 10px;">
				<tr>
					<td colspan="2" style="font-size: 15pt;text-align: center;"><?php ___("registerNotice")?></td>
				</tr>
				<tr>
					<th style="width: 20%;font-size: 20pt;padding: 3px;"><?php ___("username")?></th>
					<td>
						<input type="text" name="username" id="username" class="inputbox" value="" />
					</td>
				</tr>
				<tr>
					<th style="width: 20%;font-size: 20pt;padding: 3px;"><?php ___("password")?></th>
					<td>
						<input type="password" name="password" id="password" class="inputbox" value="" />
					</td>
				</tr>
				<tr>
					<th style="width: 20%;font-size: 20pt;padding: 3px;"><?php ___("confirmPassword")?></th>
					<td>
						<input type="password" name="confirm" id="confirm" class="inputbox" value="" />
					</td>
				</tr>
				<tr>
					<th style="width: 20%;font-size: 20pt;padding: 3px;"><?php ___("email")?></th>
					<td>
						<input type="text" name="email" id="email" class="inputbox" value="" />
					</td>
				</tr>
				<tr>
					<th style="width: 20%;font-size: 20pt;padding: 3px;"><?php ___("firstname")?></th>
					<td>
						<input type="text" name="firstname" id="firstname" class="inputbox" value="" />
					</td>
				</tr>
				<tr>
					<th style="width: 20%;font-size: 20pt;padding: 3px;"><?php ___("lastname")?></th>
					<td>
						<input type="text" name="lastname" id="lastname" class="inputbox" value="" />
					</td>
				</tr>
				<tr>
					<th colspan="2"><input type="submit" class="button" value="<?php ___("registerButton")?>" onclick="return user_register()" /></th>
				</tr>
			</table>
		</form>
	<?php }?>
	</div>
</div>

