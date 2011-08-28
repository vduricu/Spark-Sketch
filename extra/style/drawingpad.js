var body, canvas, ctx, coords, last_coords, touchdown,drawLine,move,bkgColor,textSize;
var restorePoints=[],rRestorePoints=[],tools={},status='new',filename='';

body = document.querySelector("body");
canvas = document.getElementById('drawingPad');
ctx = canvas.getContext('2d');

var lineColor = "#000000";
var bkgColor = "#ffffff";
var currentBkg,defaultBkg;
currentBkg = defaultBkg = "transparent";

ctx.strokeStyle = lineColor;
ctx.lineWidth = 3;

var img_update = function () {
	ctx.drawImage(canvas2, 0, 0);
	context2.clearRect(1, 1, canvas2.width, canvas2.height);
}

var container = canvas.parentNode;
canvas2 = document.createElement('canvas');
if (!canvas2) {
  alert('Error: I cannot create a new canvas element!');
}

canvas2.id     = 'tempImage';
canvas2.width  = canvas.width;
canvas2.height = canvas.height;
container.appendChild(canvas2);
context2 = canvas2.getContext('2d');
$("#tempImage").css({top: -canvas.height-5});


tools.brush = function(){
	ctx.lineWidth = 3;
	$("#tempImage").css({zIndex: 1});
	drawLine = function (coords, last_coords){
		ctx.beginPath();
		ctx.moveTo(coords.x,coords.y);
		if (last_coords.x>0){
			ctx.lineTo(last_coords.x,last_coords.y);
		}
		ctx.stroke();
		ctx.closePath();
	}
    canvas.onmousedown = function(e) {
		saveRP();

		touchdown = true;

		var current_coords = {
			x:e.clientX - e.target.offsetLeft + window.scrollX,
			y:e.clientY - e.target.offsetTop + window.scrollY
		}

		last_coords = {
			x:e.clientX - e.target.offsetLeft + window.scrollX,
			y:e.clientY - e.target.offsetTop + window.scrollY
		}

		drawLine(current_coords, last_coords);
		last_coords = current_coords;

	};

    canvas.onmousemove = function(e) {
		if (touchdown) {
			if (!last_coords){
				last_coords = [];
			}
			var current_coords = {
				x:e.clientX - e.target.offsetLeft + window.scrollX,
				y:e.clientY - e.target.offsetTop + window.scrollY
			}

			drawLine(current_coords, last_coords);
			last_coords = current_coords;
		}
	};

	canvas.onmouseup = function(e) {
		last_coords = null;
		touchdown = false;
	};
}

tools.line = function () {
	$("#tempImage").css({zIndex: 3});

	ctx.lineWidth = 3;
	context2.strokeStyle = ctx.strokeStyle;
	context2.lineWidth = ctx.lineWidth;

	canvas2.onmousedown = function(e) {
		saveRP();
		touchdown = true;

		context2.clearRect(0, 0, canvas2.width, canvas2.height);

		last_coords = {
			x:e.clientX - e.target.offsetLeft + window.scrollX,
			y:e.clientY - e.target.offsetTop + window.scrollY
		}
	};

    canvas2.onmousemove = function(e) {
		if (touchdown) {
			var coords = {
				x:e.clientX - e.target.offsetLeft + window.scrollX,
				y:e.clientY - e.target.offsetTop + window.scrollY
			}
			context2.clearRect(0, 0, canvas2.width, canvas2.height);
			context2.beginPath();
			context2.moveTo(coords.x,coords.y);
			context2.lineTo(last_coords.x,last_coords.y);
			context2.stroke();
			context2.closePath();
		}
	};

	canvas2.onmouseup = function(e) {
		last_coords = null;
		touchdown = false;
		img_update();
	};
};

tools.rectangle = function () {

	$("#tempImage").css({zIndex: 3});

	ctx.lineWidth = 3;
	context2.strokeStyle = ctx.strokeStyle;
	context2.lineWidth = ctx.lineWidth;

	canvas2.onmousedown = function(e) {
		saveRP();
		touchdown = true;

		if(!$('#fill').is(':checked')&&!$('#stroke').is(':checked')){
			alert("Error! Or Stroke or Fill!!! Choose one!");
			touchdown = false;
			return false;
		}

		context2.clearRect(0, 0, canvas2.width, canvas2.height);

		last_coords = {
			x:e.clientX - e.target.offsetLeft + window.scrollX,
			y:e.clientY - e.target.offsetTop + window.scrollY
		}
	};

    canvas2.onmousemove = function(e) {
		if (touchdown) {
			var coords = {
				x:e.clientX - e.target.offsetLeft + window.scrollX,
				y:e.clientY - e.target.offsetTop + window.scrollY
			}

			var x = Math.min(coords.x,  last_coords.x),
				y = Math.min(coords.y,  last_coords.y),
				w = Math.abs(coords.x - last_coords.x),
				h = Math.abs(coords.y - last_coords.y);

			context2.clearRect(0, 0, canvas2.width, canvas2.height);

			if (!w || !h) {
				return;
			}

			context2.beginPath();
			context2.fillStyle = bkgColor;
			context2.rect(x, y, w, h);

			if($("#fill").attr('checked'))
				context2.fill();

			if($("#stroke").attr('checked'))
		    	context2.stroke();
		}
	};

	canvas2.onmouseup = function(e) {
		last_coords = null;
		touchdown = false;
		img_update();
	};
};

tools.circle = function () {
	$("#tempImage").css({zIndex: 3});

	ctx.lineWidth = 3;
	context2.strokeStyle = ctx.strokeStyle;
	context2.lineWidth = ctx.lineWidth;

	canvas2.onmousedown = function(e) {
		saveRP();
		touchdown = true;

		if(!$('#fill').is(':checked')&&!$('#stroke').is(':checked')){
			alert("Error! Or Stroke or Fill!!! Choose one!");
			touchdown = false;
			return false;
		}

		context2.clearRect(0, 0, canvas2.width, canvas2.height);

		last_coords = {
			x:e.clientX - e.target.offsetLeft + window.scrollX,
			y:e.clientY - e.target.offsetTop + window.scrollY
		}
	};

    canvas2.onmousemove = function(e) {
		if (touchdown) {
			var coords = {
				x:e.clientX - e.target.offsetLeft + window.scrollX,
				y:e.clientY - e.target.offsetTop + window.scrollY
			}

			context2.clearRect(0, 0, canvas2.width, canvas2.height);
			var r = Math.abs(coords.x - last_coords.x);

			context2.beginPath();
			context2.fillStyle = bkgColor;
			context2.arc(last_coords.x, last_coords.y,r,0, Math.PI * 2, true);

			if($("#fill").attr('checked'))
				context2.fill();

			if($("#stroke").attr('checked'))
		    	context2.stroke();
		}
	};

	canvas2.onmouseup = function(e) {
		last_coords = null;
		touchdown = false;
		img_update();
	};
};

tools.text = function () {
	$("#tempImage").css({zIndex: 1});

	canvas.onmousedown = function(e) {
		saveRP();

		if($("#textbox").val()==''){
			alert("No text!");
			return false;
		}

		var coords = {
			x:e.clientX - e.target.offsetLeft + window.scrollX,
			y:e.clientY - e.target.offsetTop + window.scrollY
		}

		ctx.fillStyle = ctx.strokeStyle;
		ctx.font = textSize + 'pt '+$("#textFont").val();
		//alert($("#textAlign").val());
		if($("#textAlign").val()==''||$("#textAlign").val()=='undefined')
			ctx.textAlign = "left";
		else
			ctx.textAlign = $("#textAlign").val();

		ctx.fillText($("#textbox").val(), coords.x, coords.y);
	};

};

var default_tool = $("#tools .active").attr("id");
$("#properties").load("prop.php?item="+default_tool);
var tool = new tools[default_tool]();

var setTool = function(item){
	$("#tools .active").removeClass('active');
	$("#tools #"+item).addClass('active');
	$("#properties").load("prop.php?item="+item);
	tool = new tools[item]();
}

var changeLineColor = function(color){
	lineColor = color;
	ctx.strokeStyle = lineColor;
	context2.strokeStyle = lineColor;
}

var changeBkgColor = function(color){
	bkgColor = color;
}

var fillBkg = function(){
	$(".content .canvas").css({backgroundColor: bkgColor,backgroundImage: 'none'});
	currentBkg = bkgColor;
}

var fillBkgEdit = function(color){
	$(".content .canvas").css({backgroundColor: color,backgroundImage: 'none'});
	currentBkg = color;
}

var drawAxis = function(){
	currentBkg = "axis";
	ctx.clearRect(0, 0, canvas.width, canvas.height);
	context2.clearRect(0, 0, canvas.width, canvas.height);
	$(".content .canvas").css({background: "#ffffff url('style/images/axis.png') no-repeat center center"});
}

var swapColors = function(){
	var aux = lineColor;
	changeLineColor(bkgColor);
	changeBkgColor(aux);

	$.jPicker.List[0].color.active.val('hex', lineColor);
	$.jPicker.List[1].color.active.val('hex', bkgColor);
}

var defaultColors = function(){
	changeLineColor("#000000");
	changeBkgColor("#ffffff");

	$.jPicker.List[0].color.active.val('hex', lineColor);
	$.jPicker.List[1].color.active.val('hex', bkgColor);
}

var changeBrushWidth = function(){
	ctx.lineWidth = $("#brushWidth").val();
}

var changelineWidth = function(){
	ctx.lineWidth = $("#lineWidth").val();
	context2.lineWidth = ctx.lineWidth;
}

var saveRP = function () {
	restorePoints.push(canvas.toDataURL("image/png"));
}
var saveRRP = function(){
	rRestorePoints.push(canvas.toDataURL("image/png"));
}

var loadImage = function (image){
    var destX = 0;
    var destY = 0;

    var imageObj = new Image();
    imageObj.src = image;
    imageObj.onload = function(){
        ctx.drawImage(imageObj, destX, destY);
    };
}

var undo = function(){
	if (restorePoints.length > 0) {
		saveRRP();
		ctx.clearRect(0, 0, canvas.width, canvas.height);
		context2.clearRect(0, 0, canvas2.width, canvas2.height);

		loadImage(restorePoints[restorePoints.length-1]);
		restorePoints.pop();
	}
	return false;
}
var redo = function(){
	if (rRestorePoints.length > 0) {
		saveRP();
		ctx.clearRect(0, 0, canvas.width, canvas.height);
		context2.clearRect(0, 0, canvas2.width, canvas2.height);

		loadImage(rRestorePoints[rRestorePoints.length-1]);
		rRestorePoints.pop();
	}
	return false;
}

var clearCanvas = function(){
	ctx.clearRect(0, 0, canvas.width, canvas.height);
	context2.clearRect(0, 0, canvas2.width, canvas2.height);
	return false;
}

var newDraw = function(){
	clearCanvas();
	defaultColors();

	status = 'new';
	filename = '';
	document.getElementById('canvasTitle').value = '';

	currentBkg = defaultBkg;
	$(".content .canvas").css({background: "#dfdfdf url('style/images/bkg.png')"});
	return false;
}

var previewDraw = function(){
	window.open(canvas.toDataURL("image/png"),"preview","menubar=no,width="+canvas.width+",height="+canvas.height+",toolbar=no,scrollbars=no");
	return false;
}

$("#about,#saveDialog,#msgDialog,#settingsDialog").dialog({
	autoOpen: false,
	modal: true,
	resizable: false
});

var aboutApp = function(){
	$("#about").dialog("open");
	return false;
}

var saveDraw = function(){
	$("#saveDialog").dialog("open");
	return false;
}

var settings = function(){
	$("#settingsDialog").dialog("open");
	return false;
}
var modifyCanvas = function(){
	var nwidth = $("#cwidth").val();
	var nheight = $("#cheight").val();

	var width = canvas.width;
	var height = canvas.height;

	//.canvas

	$(".canvas").css({width: nwidth,height: nheight});
	canvas.width = nwidth;
	canvas.height = nheight;

	$("#settingsDialog").dialog("close");
}

var saveCanvas = function (){
	var toSend = {
		data:		canvas.toDataURL(),
		background:	currentBkg,
		type:		status,
		name: 		document.getElementById('canvasTitle').value,
		width:		canvas.width,
		height:		canvas.height,
		ajax:		'domestos',
		filename:   filename
	}

	document.getElementById('msgError').innerHTML="Loading...";

	$("#saveButton").attr('disabled','disabled');

	$.post('save.php',toSend,function(data){
		var msgStart = data.split("|",2);

		if(msgStart[0]=="good"){
			$("#saveDialog").dialog("close");

			$("#msgDialog").text('');
			$("#msgDialog").html('Done');

			$("#msgDialog").dialog("open");
			var t=setTimeout(function (){
				$("#msgDialog").dialog("close");
			},1000);
			$("#saveButton").removeAttr('disabled');
			status = 'edit';
			filename=msgStart[1];
			document.getElementById('msgError').innerHTML='';
		}else{
			document.getElementById('msgError').innerHTML=msgStart[1];
			$("#saveButton").removeAttr('disabled');
		}
	});

	return false;
}

var setType = function(type,file){
	status = type;
	filename = file;
}

var updateTextSize = function(){
	textSize = $("#textSize").val();
}