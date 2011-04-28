/*
* jQuery scratchpad plug-in 1.2 - Spark Edition
* Turns an html 5 canvas into an interactive drawing surface
* http://www.rich-rogers.com/archive/jquery-plugin-scratchpad
*
* Copyright (c) 2010 Rich Rogers
*
*/

(function ($) {
    $.fn.scratchpad = function (options) {
        var settings = {
            'width': 380,
            'height': 380,
            'backgroundColor': '#fff',
            'borderWidth': 1,
            'borderColor': '#ccc',
            'borderRadius': 20,
            'offsetLeft': 0,
            'offsetTop': 0,
            'lineWidth': 3,
            'lineColor': 'rgb(0,0,0)'
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

        var draw = 0;

        $(this).mouseup(function () { draw = 0; });
        $(this).mouseleave(function () { if (draw == 1) { draw = 0;}});

        if (supports_canvas() == true) {
            var canvasElem = $('<canvas>').attr({
                'width': settings.width.toString(),
                'height': settings.height.toString()
            }).css({
                'border': settings.borderWidth.toString() + 'px solid ' + settings.borderColor,
                'background-color': settings.backgroundColor,
                'border-radius': settings.borderRadius.toString() + 'px',
                '-webkit-border-radius': settings.borderRadius.toString() + 'px',
                '-moz-border-radius': settings.borderRadius.toString() + 'px',
                'cursor': 'url(/style/images/cursor.cur), crosshair'	//Modification by Spark
            });
            $(this).append(canvasElem);
            var context = $('canvas')[0].getContext('2d');

            $(this).mousedown(function (e) {
                draw = 1;
                context.beginPath();
                context.lineWidth = settings.lineWidth;
                context.moveTo(e.pageX - this.offsetLeft - settings.offsetLeft - settings.borderWidth, e.pageY - this.offsetTop - settings.offsetTop - settings.borderWidth);
            });
            $(this).mousemove(function (e) {
                if (draw == 1) {
                    context.lineTo(e.pageX - this.offsetLeft - settings.offsetLeft - settings.borderWidth, e.pageY - this.offsetTop - settings.offsetTop - settings.borderWidth);
                    context.strokeStyle = settings.lineColor;
                    context.stroke();
                }
            });

			/*Begin Modifications - By Spark*/
    		$('#clear').click(function() {
                $('canvas').attr('width', '5'); // opera does not reset properly unless width is changed
                $('canvas').attr('width', settings.width.toString());
            });
            $("#color").change(function(){
				settings.lineColor=$(this).val();
			});

			$("#bgcolor").change(function(){
				settings.backgroundColor=$(this).val();
				canvasElem.css({backgroundColor: settings.backgroundColor});
			});

			$("#brushSize").slider({
				value:settings.lineWidth,
				min: 1,
				max: 10,
				step: 1,
				slide: function( event, ui ) {
					settings.lineWidth=ui.value;
					$("#size").text(ui.value);
				}
			});
			$("#size").text(settings.lineWidth);

			$("#new").click(function(){
				window.location.href = '/';
			});

			var saveBox= 0;
			$("#save").click(function(){
				if(saveBox == 0){
					$(".saveBox").fadeIn(300);
					saveBox = 1;
				}else{
					$(".saveBox").fadeOut(300);
					saveBox = 0;
				}
				return false;

			});
			$("#saveCancel").click(function(){
				$(".saveBox").fadeOut(300);
				$(".saveText").val("");
				saveBox = 0;
			});
			$("#saveOk").click(function(){
				var toSend = {
					data:		$('canvas')[0].toDataURL(),
					type:		$("#dType").val(),
					background:	settings.backgroundColor,
					name: 		$(".saveText").val(),
					width:		settings.width,
					height:		settings.height,
				}
				$.post("/save",toSend,function(data){
					$("#modalMsg").text();
					var msgStart = data.split("|",3);

					$("#modalMsg").attr("title","Message");
					$("#modalMsg").html(msgStart[2]);

					$("#modalMsg").dialog({
						modal: true,
						buttons: {
							Ok: function() {
								$(this).dialog("close");
							}
						}
					});


					if(msgStart[0]=="good"){
						var t=setTimeout(function (){
							$(".saveBox").fadeOut(300);
							$(".saveText").val("");
							saveBox = 0;
							window.location.href="/gallery/"+msgStart[1];
						},1500);
					}
				});
				$(".saveBox").fadeOut(300);
				$(".saveText").val("");
				saveBox = 0;
			});
			/*End Modifications - By Spark*/
        }
        else {
            $(this).css({
                'width': '380px',
                'height': '380px',
                'border': settings.borderWidth.toString() + 'px solid ' + settings.borderColor,
                'color': '#ff0000',
                'background-color': '#fff',
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
