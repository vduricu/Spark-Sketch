<div class="header">
		<div class="left logo no-text">spark sketch</div>
		<div class="right menu">
			<ul>
				<li><a href="/"><?=$language['menuHome']?></a></li>
				<li><a href="/demo"><?=$language['menuDemo']?></a></li>
				<li><a href="/fgallery"><?=$language['menuFGallery']?></a></li>
				<li><a id="registerb"><?=$language['menuRegister']?></a></li>
				<li class="last"><a id="loginb"><?=$language['menuLogin']?></a></li>
			</ul>
			<div class="loginbox">
				<form action="/login" id="loginForm" method="POST">
				<div class="error" id="loginError"></div>
				<table>
					<tr>
						<th><?=$language['loginUsername']?></th>
						<td><input type="text" name="username" id="l-username" class="textbox" value=""/></td>
					</tr>
					<tr>
						<th><?=$language['loginPassword']?></th>
						<td><input type="password" name="password" id="l-password" class="textbox" value=""/></td>
					</tr>
				</table>
				<div>
					<div class="left"><?//<a href="#">Forgot your password?</a>?></div>
					<div class="right"><input type="submit" value="Login" class="blogin no-text"/></div>
					<div class="clear"></div>
				</div>
				</form>
			</div>
			<div class="registerbox">
				<form action="/register" id="registerForm" method="POST">
				<div class="error" id="registerError"></div>
				<div class="good" id="registerGood"></div>
				<table>
					<tr>
						<th><?=$language['registerUsername']?></th>
						<td><input type="text" name="username" id="r-username" class="textbox" value=""/></td>
					</tr>
					<tr>
						<th><?=$language['registerPassword']?></th>
						<td><input type="password" name="password" id="r-password" class="textbox" value=""/></td>
					</tr>
					<tr>
						<th><?=$language['registerConfirm']?></th>
						<td><input type="password" name="confirm" id="r-confirm" class="textbox" value=""/></td>
					</tr>
					<tr>
						<th><?=$language['registerEmail']?></th>
						<td><input type="text" name="email" id="r-email" class="textbox" value=""/></td>
					</tr>
					<tr>
						<th><?=$language['registerFirstName']?></th>
						<td><input type="text" name="firstname" id="r-firstname" class="textbox" value=""/></td>
					</tr>
					<tr>
						<th><?=$language['registerLastName']?></th>
						<td><input type="text" name="lastname" id="r-lastname" class="textbox" value=""/></td>
					</tr>
					<tr>
						<td colspan="2" style="font-size: 11pt;text-align: center;"><?=$language['validEmailNeeded']?></td>
					</tr>
				</table>
				<div>
					<div class="right"><input type="submit" value="Register" class="bregister no-text"/></div>
					<div class="clear"></div>
				</div>
				</form>
			</div>
		</div>
		<div class="clear"></div>
	</div>