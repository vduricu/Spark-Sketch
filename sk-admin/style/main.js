$(document).ready(function(){
	$('.menu ul li a').hover(function(){
		$(this).animate({paddingTop: "7px",color: "#ffffff"},300);//.animate({}, 500);
	},function(){
		$(this).animate({paddingTop: "0px",color: "#eeb900"},100);//.animate({}, 500);
	});

	$('#draws').dataTable({
		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "&infin;"]],
		"aaSorting": [[ 5, "desc" ]],
		"aoColumnDefs": [
			{ "bSortable": false, "aTargets": [0, 6] }
		],
	});
	$('#discuss').dataTable({
		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "&infin;"]],
		"aaSorting": [[ 4, "desc" ]],
		"aoColumnDefs": [
			{ "bSortable": false, "aTargets": [0, 5] }
		],
	});
	$('#userData').dataTable({
		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "&infin;"]]
	});
	$('a[rel*=facebox]').facebox();
});


function launchUAdmin(user){
	jQuery.facebox({ ajax: 'uiadmin.php?zona=user&user='+user });
}

function confirmDelete(photo){
	jQuery.facebox({ ajax: 'uiadmin.php?zona=draws&item=delete&draw='+photo });
}

function confirmFDelete(photo){
	jQuery.facebox({ ajax: 'uiadmin.php?zona=draws&item=fdelete&draw='+photo });
}

function msgConfirmDelete(id){
	jQuery.facebox({ ajax: 'uiadmin.php?zona=discuss&item=delete&id='+id });
}

function msgConfirmFDelete(id){
	jQuery.facebox({ ajax: 'uiadmin.php?zona=discuss&item=fdelete&id='+id });
}

function editDraw(photo){
	jQuery.facebox({ ajax: 'uiadmin.php?zona=draws&item=edit&draw='+photo });
}

function closeFacebox(){
	$(document).trigger('close.facebox');
}

function photoModif(page,file){
	if(page==undefined){
		alert("page undefined");
		return false;
	}
	switch(page){
		case 'delete':{
			$.post("admin.php?zona=draws&pagina=delete",{image: file},function(data){
				if(data=='good'){
					$(document).trigger('close.facebox');
					document.location.reload(true);
				}else{
					alert(data);
				}
			});
			break;
		}
		case 'rapprove':{
			$.post("admin.php?zona=draws&pagina=rapprove",{image: file},function(data){
				if(data=='good'){
					document.location.reload(true);
				}else{
					alert(data);
				}
			});
			break;
		}
		case 'rdelete':{
			$.post("admin.php?zona=draws&pagina=rdelete",{image: file},function(data){
				if(data=='good'){
					document.location.reload(true);
				}else{
					alert(data);
				}
			});
			break;
		}
		case 'fdelete':{
			$.post("admin.php?zona=draws&pagina=final_delete",{image: file},function(data){
				if(data=='good'){
					$(document).trigger('close.facebox');
					document.location.reload(true);
				}else{
					alert(data);
				}
			});
			break;
		}
		case 'edit':{
			$.post("admin.php?zona=draws&pagina=edit",{image: file,title: $("#drawtitle").val()},function(data){
				if(data=='good'){
					$(document).trigger('close.facebox');
					document.location.reload(true);
				}else{
					alert(data);
				}
			});
			break;
		}
		case 'approve':{
			$.post("admin.php?zona=draws&pagina=approve",{image: file},function(data){
				if(data=='good'){
					document.location.reload(true);
				}else{
					alert(data);
				}
			});
			break;
		}
	}
}

function makeModifications(page,user){
	if(page==undefined){
		alert("page undefined");
		return false;
	}
	switch(page){
		case 'rank':{
			$.post("admin.php?zona=user&pagina=rank",{user: user,rank: $("#userrank").val()},function(data){
				if(data=='good'){
					$(document).trigger('close.facebox');
					document.location.reload(true);
				}else{
					alert(data);
				}
			});
			break;
		}
		case 'activated':{
			$.post("admin.php?zona=user&pagina=activated",{user: user,activated: $("#useractivated").val()},function(data){
				if(data=='good'){
					$(document).trigger('close.facebox');
					document.location.reload(true);
				}else{
					alert(data);
				}
			});
			break;
		}
		case 'delete':{
			$.post("admin.php?zona=user&pagina=delete",{user: user},function(data){
				if(data=='good'){
					$(document).trigger('close.facebox');
					document.location.reload(true);
				}else{
					alert(data);
				}
			});
			break;
		}
	}
}

function deleteMsg(page,id){
	if(page==undefined){
		alert("page undefined");
		return false;
	}
	switch(page){
		case 'delete':{
			$.post("admin.php?zona=discuss&pagina=delete",{id: id},function(data){
				if(data=='good'){
					$(document).trigger('close.facebox');
					document.location.reload(true);
				}else{
					alert(data);
				}
			});
			break;
		}
		case 'fdelete':{
			$.post("admin.php?zona=discuss&pagina=final_delete",{id: id},function(data){
				if(data=='good'){
					$(document).trigger('close.facebox');
					document.location.reload(true);
				}else{
					alert(data);
				}
			});
			break;
		}
	}
}

function approveMsg(id){
	$.post("admin.php?zona=discuss&pagina=approve",{id: id},function(data){
		if(data=='good'){
			document.location.reload(true);
		}else{
			alert(data);
		}
	});
}