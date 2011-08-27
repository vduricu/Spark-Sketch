(function ($) {
    $.fn.sketchpad = function (options) {
        var settings = {
            'width': 780,
            'height': 500,
            'backgroundColor': '#ffffff',
            'borderWidth': 1,
            'borderColor': '#cccccc',
            'borderRadius': 20,
            'offsetLeft': 0,
            'offsetTop': 0,
            'lineWidth': 3,
            'lineColor': '#000000'
        };

        if (options) {
            $.extend(settings, options);
        }

        var supports_canvas = function () {
            var iscompat = false;
            try {
                this.iscompat = !!(document.createElement('canvas').getContext('2d'));
            } catch (e) {
                this.iscompat = !!(document.createElement('canvas').getContext);
            }
            return this.iscompat;
        }

        var body, canvas, ctx, coords, last_coords, touchdown,drawLine,move,bkgColor;
        var restorePoints = [];

        if (supports_canvas() == true) {
            var canvasElem = $('<canvas>').attr({
                'width': settings.width.toString(),
                'height': settings.height.toString(),
                'id': 'sparkCanvas'
            }).css({
                'border': settings.borderWidth.toString() + 'px solid ' + settings.borderColor,
                'background-color': settings.backgroundColor,
                'border-radius': settings.borderRadius.toString() + 'px',
                '-webkit-border-radius': settings.borderRadius.toString() + 'px',
                '-moz-border-radius': settings.borderRadius.toString() + 'px',
            });
            $(this).append(canvasElem);

			body = document.querySelector("body");
			canvas = document.querySelector('canvas');
			ctx = canvas.getContext('2d');

			// hide the toolbar in iOS
			setTimeout(function() { window.scrollTo(0, 1); }, 100);

			// prevents dragging the page in iOS
			body.ontouchmove = function(e){
				e.preventDefault();
			};
			// The function which saves the restoration points
			saveRP = function () {
				restorePoints.push(canvas.toDataURL("image/png"));
			}

			drawLine = function (coords, last_coords){
				ctx.save();
				ctx.strokeStyle = settings.lineColor;
				ctx.lineWidth = settings.lineWidth;
				ctx.beginPath();
				ctx.moveTo(coords.x,coords.y);
				if (last_coords.x>0){
					ctx.lineTo(last_coords.x,last_coords.y);
				}
				ctx.closePath();
				ctx.stroke();
			//	ctx.restore();
			}

			move = function (coords){
				for (var i = 0; i < coords.length; i++){
					var current_coords = {
						x:coords[i].current.x,
						y:coords[i].current.y,
					};

					var last_coords = {
						x:coords[i].last.x,
						y:coords[i].last.y,
					};

					drawLine(current_coords, last_coords);
				}
			}

			// iOS
			canvas.ontouchmove = function(e) {
				coords = [];

				for (var i=0; i < e.targetTouches.length; i++) {
					var current_coords = {
						x: e.targetTouches[i].clientX,
						y: e.targetTouches[i].clientY
					};

					if (!last_coords){
						var last_coords_for_index = []
					}else{
						var last_coords_for_index = {
							x: last_coords[i].x,
							y: last_coords[i].y
						}
					}

					coords.push({
						current: current_coords,
						last: last_coords_for_index
					});
				}

				move(coords);

				last_coords = [];
				for (var i=0; i < coords.length; i++) {
					last_coords.push(coords[i].current);
				}
			};

			canvas.ontouchend = function(e) {
				last_coords = null;
			};

			// typical draw evemt for desktop
			canvas.onmousemove = function(e) {
				if (touchdown) {
					if (!last_coords){
						last_coords = [];
					}

					var current_coords = {
						x:e.clientX - e.target.offsetLeft + window.scrollX,
						y:e.clientY - e.target.offsetTop + window.scrollY
					}

					coords = [{
						current: current_coords,
						last: last_coords
					}];

					move(coords);
					last_coords = current_coords;
				}
			};

			canvas.onmouseup = function(e) {
		 		last_coords = null;
				touchdown = false;
			};

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

				coords = [{
					current: current_coords,
					last: last_coords
				}];

				move(coords);

			};

			$("#brushColor").miniColors({
				change: function(hex){settings.lineColor = hex;}
			});
			$("#canvasColor").miniColors({
				change: function(hex){
					bkgColor = hex;
					//canvasElem.css({backgroundColor: hex});
				}
			});

			$("#resetColor").click(function(){
				var brushColor = "#000000",bkgsColor = "#ffffff";

				$("#brushColor").miniColors('value', brushColor);
				settings.lineColor = brushColor;

				$("#canvasColor").miniColors('value', bkgsColor);
				bkgColor = bkgsColor;
				//canvasElem.css({backgroundColor: bkgColor});
			});

			$("#changeColor").click(function(){
				var izv = settings.lineColor;

				//settings.lineColor = settings.backgroundColor;
				settings.lineColor = $("#canvasColor").val();
				$("#brushColor").miniColors('value', settings.lineColor);

				bkgColor = izv;
				$("#canvasColor").miniColors('value', bkgColor);
				//canvasElem.css({backgroundColor: settings.backgroundColor});
			});

			$("#fillBkg").click(function(){
				canvasElem.css({backgroundColor: bkgColor});
				settings.backgroundColor = bkgColor;
				$("#finalCanvasColor").val(bkgColor);
			});

			$("#clearCanvas").click(function(){
				saveRP();
				ctx.clearRect(0, 0, canvas.width, canvas.height);
			});

			$('#brushSize').change(function() {
				settings.lineWidth = $(this).val();
			});

			$("#undoCanvas").click(function(){
				if (restorePoints.length > 0) {
					ctx.clearRect(0, 0, canvas.width, canvas.height);
					loadImage(restorePoints[restorePoints.length-1]);
					restorePoints.pop();
				}

			});

			$("#demoSave").click(function(){
				window.location.href=canvas.toDataURL();
			});

        }
        else {
            $(this).css({
                'width': settings.width.toString()+'px',
                'height': settings.height.toString()+'px',
                'border': settings.borderWidth.toString() + 'px solid ' + settings.borderColor,
                'color': '#ff0000',
                'background-color': '#ffff99',
                'font-weight': 'bold',
                'border-radius': settings.borderRadius.toString() + 'px',
                '-webkit-border-radius': settings.borderRadius.toString() + 'px',
                '-moz-border-radius': settings.borderRadius.toString() + 'px'
            });
            var errorMsg = '<p style=\"text-align:center;\">Requires HTML 5 Enabled Web Browser.</p>';
            $(this).html(errorMsg);
        }
    };
})(jQuery);

function saveCanvas(){
	var c = document.getElementById('sparkCanvas');
	var form = document.getElementById('saveForm');

	var toSend = {
		data:		c.toDataURL(),
		background:	document.getElementById('finalCanvasColor').value,
		type:		'new',
		name: 		document.getElementById('saveTitle').value,
		width:		c.width,
		height:		c.height,
		ajax:		'domestos'
	}

	document.getElementById('msgError').innerHTML="Loading...";

	$("#saveButton").attr('disabled','disabled');
	$.post(form.action,toSend,function(data){
		var msgStart = data.split("|",2);

		if(msgStart[0]=="good"){
			var t=setTimeout(function (){
				$(document).trigger('close.facebox');
				window.location.href=document.getElementById('galleryPath').value+msgStart[1];
			},500);
		}else{
			document.getElementById('msgError').innerHTML=msgStart[1];
			$("#saveButton").removeAttr('disabled');
		}
	});

	return false;
}

function saveCanvasDemo(){
	var c = document.getElementById('sparkCanvas');
	var form = document.getElementById('saveForm');

	var toSend = {
		data:		c.toDataURL(),
		background:	document.getElementById('finalCanvasColor').value,
		type:		'demo',
		name: 		document.getElementById('saveTitle').value,
		width:		c.width,
		height:		c.height,
		ajax:		'domestos'
	}

	document.getElementById('msgError').innerHTML="Loading...";
	$("#saveButton").attr('disabled','disabled');

	$.post(form.action,toSend,function(data){
		var msgStart = data.split("|",2);
		if(msgStart[0]=="good"){
			var t=setTimeout(function (){
				$(document).trigger('close.facebox');
				window.location.href=document.getElementById('galleryPath').value+msgStart[1];
			},500);
		}else{
			document.getElementById('msgError').innerHTML=msgStart[1];
			$("#saveButton").removeAttr('disabled');
		}
	});

	return false;
}

function overwriteCanvas(){
	var c = document.getElementById('sparkCanvas');
	var form = document.getElementById('saveForm');

	var toSend = {
		data:		c.toDataURL(),
		background:	document.getElementById('finalCanvasColor').value,
		type:		'edit',
		name: 		document.getElementById('saveTitle').value,
		filename: 	document.getElementById('canvasName').value,
		width:		c.width,
		height:		c.height,
		ajax:		'domestos'
	}

	document.getElementById('msgError').innerHTML="Loading...";
	$("#overwriteButton").attr('disabled','disabled');

	$.post(form.action,toSend,function(data){
		var msgStart = data.split("|",2);
		if(msgStart[0]=="good"){
			var t=setTimeout(function (){
				$(document).trigger('close.facebox');
				window.location.href=document.getElementById('galleryPath').value+msgStart[1];
			},500);
		}else{
			document.getElementById('msgError').innerHTML=msgStart[1];
			$("#overwriteButton").removeAttr('disabled');
		}
	});

	return false;
}

function loadImage(image){
	var canvas = document.getElementById('sparkCanvas');
    var context = canvas.getContext("2d");

    var destX = 0;
    var destY = 0;

    var imageObj = new Image();
    imageObj.onload = function(){
        context.drawImage(imageObj, destX, destY);
    };
    imageObj.src = image;
}