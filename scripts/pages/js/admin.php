<?php
header ('Content-Type: text/javascript');
?>
$(document).ready(function(){
    /*$('tbody tr').click(function(e) {
    	e.preventDefault();
        launchWindow("#users");
    });*/

    $('.window .close, #mask').click(function (e) {
        e.preventDefault();
        $('#mask, .window').fadeOut(300);
    });
});

function launchWindow(id){
	//Get the screen height and width
	var maskHeight = $(window).height();
	var maskWidth = $(window).width();

	//Set height and width to mask to fill up the whole screen
	$('#mask').css({'width':maskWidth,'height':maskHeight});

	//transition effect
	$('#mask').fadeIn(500);
	//$('#mask').fadeTo("slow",0.8);

	//Get the window height and width
	var winH = $(window).height();
	var winW = $(window).width();

	//Set the popup window to center
	$(id).css('top',  winH/2-$(id).height()/2-25);
	$(id).css('left', winW/2-$(id).width()/2-25);

	//transition effect
	$(id).fadeIn(700);
}

function showUAdmin(id,user,rank,quota,activated,sure){
	$("span#user").text();
	$("span#user").html(user);
	if(activated=='no'){
		$("#deactivate").css({display: 'none'});
		$("#activate").css({display: 'block'});
	}else{
		$("#deactivate").css({display: 'block'});
		$("#activate").css({display: 'none'});
	}

	launchWindow(id);
	$("#delete").click(function(){

		$("#modalMsg").attr("title","Confirmation");
		$("#modalMsg").text("");
		$("#modalMsg").html(sure);

		$("#modalMsg").dialog({
			resizable: false,
			width:320,
			height:160,
			modal: true,
			draggable: false,
			buttons: {
				Ok: function() {
					$.post("<?=$core->createURL("/userdel")?>",{user: user},function(data){
						if(data!="good")
							alert(data);
						else
							window.location.href="<?=$core->createURL("/users")?>";
					});
				},
				Cancel: function() {
					$(this).dialog("close");
				}
			}
		});
	});

	$("#rank").click(function(){
		$("#modalMsg").attr("title","Rank");
		$("#modalMsg").text("");
		$("#modalMsg").html("<select id=\"ranks\"><option value=\"admin\" "+(rank=='admin'?'selected':'')+">Admin</option><option value=\"user\" "+(rank=='user'?'selected':'')+">User</option></select>");

		$("#modalMsg").dialog({
			resizable: false,
			width:320,
			height:160,
			modal: true,
			draggable: false,
			buttons: {
				Ok: function() {
					$.post("<?=$core->createURL("/userrank")?>",{user: user,rank: $("#ranks").val()},function(data){
						if(data!="good")
							alert(data);
						else
							window.location.href="<?=$core->createURL("/users")?>";
					});
				},
				Cancel: function() {
					$(this).dialog("close");
				}
			}
		});
	});

	$("#quota").click(function(){
		$("#modalMsg").attr("title","Quota");
		$("#modalMsg").text("");
		$("#modalMsg").html("Quota: <select id=\"quotas\"><option value=\"-1\" "+(quota=='-1'?'selected':'')+">&infin;</option><option value=\"10\" "+(quota=='10'?'selected':'')+">10</option><option value=\"100\" "+(quota=='100'?'selected':'')+">100</option><option value=\"1000\" "+(quota=='1000'?'selected':'')+">1000</option><option value=\"10000\" "+(rank=='10000'?'selected':'')+">10000</option></select>");

		$("#modalMsg").dialog({
			resizable: false,
			width:320,
			height:160,
			modal: true,
			draggable: false,
			buttons: {
				Ok: function() {
					$.post("<?=$core->createURL("/userquota")?>",{user: user,quota: $("#quotas").val()},function(data){
						if(data!="good")
							alert(data);
						else
							window.location.href="<?=$core->createURL("/users")?>";
					});
				},
				Cancel: function() {
					$(this).dialog("close");
				}
			}
		});
	});

	$("#deactivate,#activate").click(function(){
		$.post("<?=$core->createURL("/useract")?>",{user: user,activate:activated},function(data){
			window.location.href="<?=$core->createURL("/users")?>";
		});
	});
}

function showGAdmin(id,file,title,sure){
	$(id+" h3").text();
	$(id+" h3").html(title);

	launchWindow(id);
	$("#delete").click(function(){

		$("#modalMsg").attr("title","Confirmation");
		$("#modalMsg").text("");
		$("#modalMsg").html(sure);

		$("#modalMsg").dialog({
			resizable: false,
			width:320,
			height:160,
			modal: true,
			draggable: false,
			buttons: {
				Ok: function() {
					var toSend = {filename: file};
					$.post("<?=$core->createURL("/delete")?>",toSend);
					window.location.href="<?=$core->createURL("/admingallery")?>";
				},
				Cancel: function() {
					$(this).dialog("close");
				}
			}
		});
	});
	$("#view").click(function(){
		window.location.href="<?=$core->createURL("/gallery/")?>"+file;
	});
}
