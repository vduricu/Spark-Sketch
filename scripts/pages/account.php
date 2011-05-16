<?php
if(!isset($_SESSION['sk_user'])){
	masterRedirect("/");
}
$q = mysql_query("SELECT * FROM `user` WHERE `id`='{$_SESSION['sk_user']}'");
if(!mysql_num_rows($q))
	masterRedirect($core->createURL("/404"));
$r = mysql_fetch_assoc($q);
?>
<? require_once("tpl/top.php");?>
<div class="content accountBox">
	<table>
		<tr>
			<td colspan="2"><h1><?=$language['accInfoHeader']?></h1></td>
		</tr>
		<tr>
			<th><?=$language['accUsername']?>:</th>
			<td><input type="text" class="inputBox disabled" disabled value="<?=$r['user']?>"/></td>
		</tr>
		<tr>
			<th><?=$language['accEmail']?>:</th>
			<td><input type="text" class="inputBox disabled" disabled value="<?=$r['email']?>"/></td>
		</tr>
		<tr>
			<th><?=$language['accFirstname']?>:</th>
			<td><input type="text" class="inputBox" name="firstname" id="firstname" value="<?=$r['firstname']?>"/></td>
		</tr>
		<tr>
			<th><?=$language['accLastname']?>:</th>
			<td><input type="text" class="inputBox" name="lastname" id="lastname" value="<?=$r['lastname']?>"/></td>
		</tr>
		<tr>
			<th><?=$language['accLanguage']?>:</th>
			<td>
				<select name="lang" class="inputBox" id="lang">
					<option value="en" <?=$r['lang']=='en'?'selected':''?>><?=$language['en']?></option>
					<option value="ro" <?=$r['lang']=='ro'?'selected':''?>><?=$language['ro']?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: right;"><input type="button" value="submit" class="no-text bsubmit" id="infoChange"/></td>
		</tr>
	</table>
	<div class="msg" id="accErr"></div>
	<hr/>
	<table>
		<tr>
			<td colspan="2"><h1><?=$language['passChangeHeader']?></h1></td>
		</tr>
		<tr>
			<th><?=$language['cPassword']?>:</th>
			<td><input type="password" class="inputBox" name="cpassword" id="cpassword" value=""/></td>
		</tr>
		<tr>
			<th><?=$language['chPassword']?>:</th>
			<td><input type="password" class="inputBox" name="password" id="password" value=""/></td>
		</tr>
		<tr>
			<th><?=$language['chCPassword']?>:</th>
			<td><input type="password" class="inputBox" name="confirm" id="confirm" value=""/></td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: right;"><input type="button" value="submit" class="no-text bsubmit" id="passwordChange"/></td>
		</tr>
	</table>
	<div class="msg" id="passErr"></div>
	<?
	if($_SESSION['sk_user']!=1){?>
	<hr/>
	<table>
		<tr>
			<td><h1><?=$language['accDelHeader']?></h1></td>
		</tr>
		<tr>
			<td><input type="checkbox" name="accDel" id="accDel"/> <label for"accDel"><?=$language['accDel']?></label></td>
		</tr>
		<tr>
			<td style="text-align: right;"><input type="button" value="submit" class="no-text bsubmit" id="deleteAccount"/></td>
		</tr>
	</table>
	<div class="msg" id="aDelErr"></div>
	<?}
	?>
</div>
<? require_once("tpl/footer.php"); ?>