<script type="text/javascript">
$(document).ready(function(){
	$(".drawingpad").scratchpad({
		width: 720,
		height: 580,
		backgroundColor: '#ffffff',
		borderWidth: 1,
		borderColor: '#282828',
		borderRadius: 15,
		offsetLeft: 0,
		offsetTop: 0,
		lineWidth: 2,
		lineColor: '#dc0000'
	});
	var image = new Image();
	image.src = "/files/<?=$filename;?>";

	var context2D = $('canvas')[0].getContext('2d');
	context2D.drawImage(image,0,0,720,580);
});
</script>
