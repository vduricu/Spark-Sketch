<?php
$q = mysql_query("SELECT * FROM `user` WHERE `id`='{$_SESSION['sk_user']}'");
if(!mysql_num_rows($q))
	masterRedirect($this->core->createURL("/404"));
$r = mysql_fetch_assoc($q);

appendFooter('<script type="text/javascript">
$("#infoChange").click(function(){
	var data = {
	   	   email: $("#email").val(),
	   firstname: $("#firstname").val(),
		lastname: $("#lastname").val(),
			lang: $("#lang").val(),
			type: \'infoChange\',
			ajax: true
	};
	$.post("'.getConfig('path').'/change.php",data,function(data){
		var msgStart = data.split("|",2);
		if(msgStart[0]=="good"){
			$("#accErr").fadeOut(100).text();
			$("#accErr").removeClass("error").removeClass("good");
			$("#accErr").addClass("good");
			$("#accErr").html(msgStart[1]);
			$("#accErr").fadeIn(300);
		}else if(msgStart[0]==\'refresh\'){
			$("#accErr").fadeOut(100).text();
			$("#accErr").removeClass("error").removeClass("good");
			$("#accErr").addClass("good");
			$("#accErr").html(msgStart[1]);
			$("#accErr").fadeIn(300);

			var t=setTimeout(function (){
				window.location.href="'.$this->core->createURL('/page/myaccount').'";
			},500);
		}else{
			$("#accErr").fadeOut(100).text();
			$("#accErr").removeClass("error").removeClass("good");
			$("#accErr").addClass("error");
			$("#accErr").html(msgStart[1]);
			$("#accErr").fadeIn(300);
		}
		var t=setTimeout(function (){
			$("#accErr").fadeOut(100).text();
			$("#accErr").removeClass("error").removeClass("good");
		},1500);
		return false;
	});
});

$("#deleteAccount").click(function(){
	var data = {
		  accept: $("#accDel").attr(\'checked\'),
			type: \'deleteAccount\',
			ajax: true
	};
	$.post("'.getConfig('path').'/change.php",data,function(data){
		var msgStart = data.split("|",2);
		if(msgStart[0]=="good"){
			var t=setTimeout(function (){
				window.location.href="'.$this->core->createURL('/').'";
			},500);
		}else{
			$("#aDelErr").fadeOut(100).text();
			$("#aDelErr").removeClass("error");
			$("#aDelErr").addClass("error");
			$("#aDelErr").html(msgStart[1]);
			$("#aDelErr").fadeIn(300);
		}
		var t=setTimeout(function (){
			$("#aDelErr").fadeOut(100).text();
			$("#aDelErr").removeClass("error");
		},1500);
		return false;
	});
});

$("#passwordChange").click(function(){
	var data = {
	   cpassword: $("#cpassword").val(),
	   	password: $("#password").val(),
		 confirm: $("#confirm").val(),
			type: \'passChange\',
			ajax: true
	};
	$.post("'.getConfig('path').'/change.php",data,function(data){
		var msgStart = data.split("|",2);
		if(msgStart[0]=="good"){
			$("#passErr").fadeOut(100).text();
			$("#passErr").removeClass("error").removeClass("good");
			$("#passErr").addClass("good");
			$("#passErr").html(msgStart[1]);
			$("#passErr").fadeIn(300);
		}else{
			$("#passErr").fadeOut(100).text();
			$("#passErr").removeClass("error").removeClass("good");
			$("#passErr").addClass("error");
			$("#passErr").html(msgStart[1]);
			$("#passErr").fadeIn(300);
		}
		var t=setTimeout(function (){
			$("#passErr").fadeOut(100).text();
			$("#passErr").removeClass("error").removeClass("good");
		},1500);
		return false;
	});
});
</script>');
?>
<div class="right myaccount" id="content" style="margin-top: 10px;">
	<h1 class="title"><?php ___("myaccountTitle")?></h1>
	<div class="content" style="width: 500px;">
		<table>
			<tr>
				<td colspan="2"><h2><?php ___("accountInfo")?></h2></td>
			</tr>
			<?php if(isset($r['invitedby'])){?>
			<tr>
				<td colspan="2" style="text-align: right;color: #dc0000;padding-bottom: 5px;"><?php ___("invitedBy")?>: <span style="font-weight: bold;font-family: Arial, sans-serif;"><?php __($this->core->userinfo($r['invitedby'],'user'))?></span></td>
			</tr>
			<?php }?>
			<tr>
				<th><?php ___("username")?>:</th>
				<td><input type="text" class="inputBox disabled" disabled value="<?=$r['user']?>"/></td>
			</tr>
			<tr>
				<th><?php ___("email")?>:</th>
				<td><input type="text" class="inputBox" id="email" name="email" value="<?=$r['email']?>"/></td>
			</tr>
			<tr>
				<th><?php ___("lastname")?>:</th>
				<td><input type="text" class="inputBox" name="firstname" id="firstname" value="<?=$r['firstname']?>"/></td>
			</tr>
			<tr>
				<th><?php ___("firstname")?>:</th>
				<td><input type="text" class="inputBox" name="lastname" id="lastname" value="<?=$r['lastname']?>"/></td>
			</tr>
			<tr>
				<th><?php ___("language")?>:</th>
				<td>
					<select name="lang" class="inputBox" id="lang">
						<option value="en" <?=$r['lang']=='en'?'selected':''?>><?php __($this->language->languageMeaning('en'))?></option>
						<option value="ro" <?=$r['lang']=='ro'?'selected':''?>><?php __($this->language->languageMeaning('ro'))?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: right;"><input type="button" class="button" value="<?php ___("modify")?>" id="infoChange"/></td>
			</tr>
		</table>
		<div class="msg" id="accErr"></div>
		<hr/>
		<table>
			<tr>
				<td colspan="2"><h2><?php ___("changePassword")?></h2></td>
			</tr>
			<tr>
				<th><?php ___("currentPassword")?>:</th>
				<td><input type="password" class="inputBox" name="cpassword" id="cpassword" value=""/></td>
			</tr>
			<tr>
				<th><?php ___("newPassword")?>:</th>
				<td><input type="password" class="inputBox" name="password" id="password" value=""/></td>
			</tr>
			<tr>
				<th><?php ___("confirmPassword")?>:</th>
				<td><input type="password" class="inputBox" name="confirm" id="confirm" value=""/></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: right;"><input type="button" class="button" value="<?php ___("modify")?>" id="passwordChange"/></td>
			</tr>
		</table>
		<div class="msg" id="passErr"></div>
		<?php
		if(loggedUserID()!=1){?>
		<hr/>
		<table>
			<tr>
				<td><h2><?php ___("deleteYAccount")?></h2></td>
			</tr>
			<tr>
				<td><input type="checkbox" name="accDel" id="accDel"/> <label for"accDel"><?php ___("deleteNotice")?></label></td>
			</tr>
			<tr>
				<td style="text-align: right;"><input type="button" class="button" id="deleteAccount" value="<?php ___("deleteButton")?>"/></td>
			</tr>
		</table>
		<div class="msg" id="aDelErr"></div>
		<?}
?>
	</div>
</div>