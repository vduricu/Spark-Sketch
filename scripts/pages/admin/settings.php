<?php
if(!isset($_SESSION['sk_user'])){
	masterRedirect("/");
}

?>
<? require_once("tpl/top.php");?>
	<div class="content accountBox">
	<form action="<?=$core->createURL("/gsettings");?>" method="POST">
		<table>
			<tr>
				<td colspan="2"><h1><?=$language['aSettingsHeader']?></h1></td>
			</tr>
			<tr>
				<th><?=$language['aSiteName']?></th>
				<td>
					<input type="textbox" id="siteName" class="inputBox" name="siteName" value="<?=$core->getConfig('site_name')?>"/>
				</td>
			</tr>
			<tr>
				<th><?=$language['asTimezone']?>:</th>
				<td>
					<select id="timezone" class="inputBox" name="timezone">
	<?php
	$timezone_identifiers = DateTimeZone::listIdentifiers();
foreach( $timezone_identifiers as $value ){
	if($value==$core->getConfig("timezone"))
		echo "<option value=\"{$value}\" selected>{$value}</option>\n";
	else
		echo "<option value=\"{$value}\">{$value}</option>\n";
}
	?>
	</select>
				</td>
			</tr>
			<tr>
				<th><?=$language['accLanguage']?>:</th>
				<td>
					<select name="lang" class="inputBox" id="lang">
						<option value="en" <?=$core->getConfig('default_language')=='en'?'selected':''?>><?=$language['en']?></option>
						<option value="ro" <?=$core->getConfig('default_language')=='ro'?'selected':''?>><?=$language['ro']?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: right;"><input type="submit" value="submit" class="no-text bsubmit" id="settChange"/></td>
			</tr>
		</table>
		</form>
		<?if(isset($_SESSION['error'])){?>
		<div class="msg error" id="settErr" style="display: block;"><?=$_SESSION['error']?></div>
		<?
		unset($_SESSION['error']);
		}?>
	</div>
	<? require_once("tpl/footer.php"); ?>