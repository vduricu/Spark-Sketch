$(document).ready(function(){
	$('.menu ul li a').hover(function(){
		$(this).animate({paddingTop: "7px",color: "#ffffff"},300);//.animate({}, 500);
	},function(){
		$(this).animate({paddingTop: "0px",color: "#eeb900"},100);//.animate({}, 500);
	});

	$('.loginbox a').hover(function(){
		$(this).animate({color: "#eeb900"},300);//.animate({}, 500);
	},function(){
		$(this).animate({color: "#ffffff"},100);//.animate({}, 500);
	});

	var loginBox = 0, registerBox = 0;
	$("#loginb").click(function(){
		if(registerBox == 1){
			$("#registerError").fadeOut(100).text();
			$(".registerbox").fadeOut(100);
			registerBox = 0;
		}

		if(loginBox == 0){
			$(".loginbox").fadeIn(300);
			loginBox = 1;
		}else{
			$("#loginError").fadeOut(100).text();
			$(".loginbox").fadeOut(300);
			loginBox = 0;
		}
		return false;
	});

	$("#registerb").click(function(){
		if(loginBox == 1){
			$("#loginError").fadeOut(100).text();
			$(".loginbox").fadeOut(100);
			loginBox = 0;
		}

		if(registerBox == 0){
			$(".registerbox").fadeIn(300);
			registerBox = 1;
		}else{
			$("#registerError").fadeOut(100).text();
			$(".registerbox").fadeOut(300);
			registerBox = 0;
		}
		return false;
	});

	$('.button, .color').tipsy({gravity: 's',fade: true});
	$('.userbox .button').tipsy({gravity: 'e',fade: true});
	$('.drawShare a').tipsy({gravity: 's',fade: true});
	$('.imageGallery img').tipsy({gravity: $.fn.tipsy.autoNS,fade: true});

	var brushBox = 0;
	$("#brush").click(function(){
		if(brushBox == 0){
			$(".widthBox").fadeIn(300);
			brushBox = 1;
		}else{
			$(".widthBox").fadeOut(300);
			brushBox = 0;
		}
		return false;
	});

	$(".blogin").click(function(){
		var data = {
			username: $("#l-username").val(),
			password: $("#l-password").val(),
				ajax: true
		};
		$.post("/login",data,function(data){
			if(data!="good"){
				$("#loginError").fadeOut(100).text();
				$("#loginError").html(data).fadeIn(300);
			}else{
				$("#loginError").fadeOut(100).text();
				$("#loginForm").submit();
			}
			return false;
		});
	});

	$(".bregister").click(function(){
		var data = {
			username: $("#r-username").val(),
			password: $("#r-password").val(),
			 confirm: $("#r-confirm").val(),
			   email: $("#r-email").val(),
		   firstname: $("#r-firstname").val(),
			lastname: $("#r-lastname").val(),
				ajax: true
		};
		$.post("/register",data,function(data){
			if(data!="good"){
				$("#registerError").fadeOut(100).text();
				$("#registerError").html(data).fadeIn(300);
			}else{
				$("#registerError").fadeOut(100).text();
				$("#registerForm").submit();
			}
			return false;
		});
	});

	$("#infoChange").click(function(){
		var data = {
		   firstname: $("#firstname").val(),
			lastname: $("#lastname").val(),
				lang: $("#lang").val(),
				type: 'infoChange',
				ajax: true
		};
		$.post("/change",data,function(data){
			var msgStart = data.split("|",2);
			if(msgStart[0]=="good"){
				$("#accErr").fadeOut(100).text();
				$("#accErr").removeClass("error").removeClass("good");
				$("#accErr").addClass("good");
				$("#accErr").html(msgStart[1]);
				$("#accErr").fadeIn(300);
			}else if(msgStart[0]=='refresh'){
				$("#accErr").fadeOut(100).text();
				$("#accErr").removeClass("error").removeClass("good");
				$("#accErr").addClass("good");
				$("#accErr").html(msgStart[1]);
				$("#accErr").fadeIn(300);

				var t=setTimeout(function (){
					window.location.href="/account";
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
			  accept: $("#accDel").attr('checked'),
				type: 'deleteAccount',
				ajax: true
		};
		$.post("/change",data,function(data){
			var msgStart = data.split("|",2);
			if(msgStart[0]=="good"){
				var t=setTimeout(function (){
					window.location.href="/";
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
				type: 'passChange',
				ajax: true
		};
		$.post("/change",data,function(data){
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

	$("#extend").click(function(){
		var filename = $("#extendFN").val();
		window.location.href = '/extend/'+filename;
	});
	$("#cancel").click(function(){
		var filename = $("#extendFN").val();
		window.location.href = '/gallery/'+filename;
	});
});


function confirmDelete(title,message,file){
	$("#modalMsg").text();

	$("#modalMsg").attr("title",title);
	$("#modalMsg").html(message);

	$("#modalMsg").dialog({
		resizable: false,
		height:240,
		width:440,
		modal: true,
		buttons: {
			"Delete": function() {
				var toSend = {filename: file};
				$.post("/delete",toSend);
				$(this).dialog("close");
				window.location.href='/mygallery';
			},
			Cancel: function() {
				$(this).dialog("close");
			}
		}
	});
}
