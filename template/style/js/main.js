var user_auth = function (){
	var data = {
		'username':		$("#username").val(),
		'password':		$("#password").val(),
		'ajax':			1
	};
	var src = $("#loginForm").attr('action');
	$.post(src,data,function(data){
		if(data!='good')
			$.facebox(data);
		else
			$("#loginForm").submit();
	});
	return false;
}

var passrec = function (){
	var data = {
		'username':		$("#username").val(),
		'email':		$("#email").val(),
		'ajax':			1
	};

	var src = $("#recoveryForm").attr('action');
	$.post(src,data,function(data){
		if(data!='good')
			$.facebox(data);
		else
			$("#recoveryForm").submit();
	});
	return false;
}

var user_register = function (){
	var data = {
		username: $("#username").val(),
		password: $("#password").val(),
		 confirm: $("#confirm").val(),
		   email: $("#email").val(),
	   firstname: $("#firstname").val(),
		lastname: $("#lastname").val(),
			ajax: true
	};
	var src = $("#registerForm").attr('action');
	$.post(src,data,function(data){
		var msgStart = data.split("|",2);
		if(msgStart[0]!="good"){
			$.facebox(msgStart[1]);
		}else{
			$("#registerForm").submit();
		}
		return false;
	});

	return false;
}

var reportDraw = function(path,photo){
	jQuery.facebox({ ajax: path+'/sk-admin/reportdraw.php?photo='+photo });
}

var makeReport = function(){
	var data = {
			image: $("#image").val(),
			reason: $("#reason").val(),
			sentForm: 'true'
	};
	var src = $("#reportForm").attr('action');
	$.post(src,data,function(data){
		var msgStart = data.split("|",2);
		if(msgStart[0]!="good"){
			alert(msgStart[1]);
		}else{
			alert(msgStart[1]);
			var t=setTimeout(function (){
				$(document).trigger('close.facebox');
				document.location.reload(true);
			},500);
		}
		return false;
	});

	return false;
}

var discuss = function(page){
	//alert(page);
	window.open(page,"Discuss","menubar=no,width=500,height=650,toolbar=no,scrollbars=no");
	return false;
}

var showANS = function(item){
	var activeANSid = $(".activeANS").attr('id');
	if(activeANSid == item)
		$(".activeANS").slideUp(250).removeClass('activeANS');
	else{
		$(".activeANS").slideUp(250).removeClass('activeANS');
		$("#"+item).slideDown(500).addClass('activeANS');
	}

	return false;
}