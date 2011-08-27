var submitForm = function (draw){
	var data = {
		'comment':		$("#comment").val(),
		'draw':			draw,
		'type':			'add'
	};

	if(data.comment==''){
		alert("Field Empty");
		return false
	}

	var src = $("#discussForm").attr('action');
	$.post(src,data,function(data){
		clearTimeout(t);
		$("#data").fadeOut(100);
		$("#data").text();
		$("#data").html(data);
		$("#data").fadeIn(200);
		$("#howMany").load(src+"?type=howMany&draw="+draw);
		var t = setTimeout("updateDiscuss()",5000);
	});
	return false;
}

var updateDiscuss = function(){
	var data = {
		'draw':			$("#drawid").val(),
		'type':			'last_post'
	};

	var src = $("#discussForm").attr('action');
	$.post(src,data,function(datas){
		if(datas!=$("#last_post").val()){
			$("#howMany").load(src+"?type=howMany&draw="+$("#drawid").val());
			$("#last_post").val(datas);
			$("#data").fadeOut(100);
			$("#data").text();
			$("#data").load(src+"?draw="+$("#drawid").val());
			$("#data").fadeIn(200);
		}
	});

	var t = setTimeout("updateDiscuss()",5000);
}

var t = setTimeout("updateDiscuss()",5000);
