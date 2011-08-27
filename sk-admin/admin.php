<?php

session_start();
require_once('../engine/master.php');
if(!logged())
	masterRedirect($spkcore->createURL("/404"));
if(loggedUserRank()!='admin'&&loggedUserRank()!='moderator')
	masterRedirect($spkcore->createURL("/404"));

$zona = filter_input(INPUT_GET,"zona",FILTER_SANITIZE_STRING);
$pagina = filter_input(INPUT_GET,"pagina",FILTER_SANITIZE_STRING);



switch($zona){
	case 'user':
		if(loggedUserRank()=='admin'){
			$user = filter_input(INPUT_POST,"user",FILTER_SANITIZE_STRING);

			if(empty($user))
				masterDie(langItem("emptyFields"));

			switch($pagina){
				case 'rank':
					$rank = filter_input(INPUT_POST,"rank",FILTER_SANITIZE_STRING);

					if(empty($rank))
						masterDie(langItem("emptyFields"));

					$q = mysql_query("SELECT * FROM `user` WHERE `user`='{$user}'");
					if(!mysql_num_rows($q))
						masterDie("Nu exista utilizatorul cerut!");
					mysql_query("UPDATE `user` SET `rank`='{$rank}' WHERE `user`='{$user}'");

					if(mysql_errno())
						masterDie(mysql_error());

					__("good");
					break;
				case 'activated':
					$activated = filter_input(INPUT_POST,"activated",FILTER_SANITIZE_STRING);

					if(empty($activated))
						masterDie(langItem("emptyFields"));

					$q = mysql_query("SELECT * FROM `user` WHERE `user`='{$user}'");
					if(!mysql_num_rows($q))
						masterDie("Nu exista utilizatorul cerut!");
					mysql_query("UPDATE `user` SET `activated`='{$activated}',`activation_code`=NULL WHERE `user`='{$user}'");

					if(mysql_errno())
						masterDie(mysql_error());

					__("good");
					break;
				case 'delete':
					$q = mysql_query("SELECT * FROM `user` WHERE `user`='{$user}'");
					if(!mysql_num_rows($q))
						masterDie("Nu exista utilizatorul cerut!");

					$userid = getIDByElement('user','user',$user);
					@mysql_query("DELETE FROM `discuss` WHERE `userid`='{$userid}'");

					$q = mysql_query("SELECT * FROM `draws` WHERE `userid`='{$userid}'");

					while($r = mysql_fetch_assoc($q)){
						unlink("../files/{$r['filename']}.png");
						mysql_query("DELETE FROM `draws` WHERE `filename`='{$r['filename']}' LIMIT 1");
					}
					mysql_query("DELETE FROM `user` WHERE `user`='{$user}'");

					if(mysql_errno())
						masterDie(mysql_error());

					__("good");
					break;
			}
		}else{
			masterDie("Nu ai destule privilegii");
		}
		break;
		case 'draws':
			if(isset($_POST['action'])){
				$action = filter_input(INPUT_POST,"action",FILTER_SANITIZE_STRING);
				if($action == 'mapprove' || $action == 'mdelete')
					$pagina = $action;
				if($action == 'mfdelete')
					$pagina = "final_mdelete";
			}


			switch($pagina){
				case 'edit':
					$image = filter_input(INPUT_POST,"image",FILTER_SANITIZE_STRING);
					$title = filter_input(INPUT_POST,"title",FILTER_SANITIZE_STRING);

					if(empty($image)||empty($title))
						masterDie(langItem("emptyFields"));

					$q = mysql_query("SELECT * FROM `draws` WHERE `filename`='{$image}'");
					if(!mysql_num_rows($q))
						masterDie("Nu exista desenul cerut!");

					mysql_query("UPDATE `draws` SET `title`='{$title}' WHERE `filename`='{$image}'");

					if(mysql_errno())
						masterDie(mysql_error());

					__("good");
					break;
				case 'rapprove':
					$image = filter_input(INPUT_POST,"image",FILTER_SANITIZE_STRING);

					if(empty($image))
						masterDie(langItem("emptyFields"));

					$q = mysql_query("SELECT * FROM `draws` WHERE `filename`='{$image}'");
					if(!mysql_num_rows($q))
						masterDie("Nu exista desenul cerut!");

					$userid = loggedUserID();
					mysql_query("UPDATE `draws` SET `status`='approved',`moderatedby`='{$userid}',`moderated`='yes' WHERE `filename`='{$image}'");

					if(mysql_errno())
						masterDie(mysql_error());

					__("good");
					break;
				case 'approve':
					$image = filter_input(INPUT_POST,"image",FILTER_SANITIZE_STRING);

					if(empty($image))
						masterDie(langItem("emptyFields"));

					$q = mysql_query("SELECT * FROM `draws` WHERE `filename`='{$image}'");
					if(!mysql_num_rows($q))
						masterDie("Nu exista desenul cerut!");

					mysql_query("UPDATE `draws` SET `status`='approved' WHERE `filename`='{$image}'");

					if(mysql_errno())
						masterDie(mysql_error());

					__("good");
					break;
				case 'mapprove':
					$items = $_POST['item'];
					foreach($items as $image){
						$image = filter_var($image,FILTER_SANITIZE_STRING);
						$q = mysql_query("SELECT * FROM `draws` WHERE `filename`='{$image}'");
						if(mysql_num_rows($q)){
								mysql_query("UPDATE `draws` SET `status`='approved' WHERE `filename`='{$image}'");
						}
					}

					masterRedirect(getConfig("path")."/sk-admin/?zona=desene");
					break;
				case 'rdelete':
					$image = filter_input(INPUT_POST,"image",FILTER_SANITIZE_STRING);

					if(empty($image))
						masterDie(langItem("emptyFields"));

					$q = mysql_query("SELECT * FROM `draws` WHERE `filename`='{$image}'");
					if(!mysql_num_rows($q))
						masterDie("Nu exista desenul cerut!");

					$userid = loggedUserID();
					mysql_query("UPDATE `draws` SET `status`='deleted',`moderatedby`='{$userid}',`moderated`='yes' WHERE `filename`='{$image}'");

					if(mysql_errno())
						masterDie(mysql_error());

					__("good");
					break;
				case 'delete':
					$image = filter_input(INPUT_POST,"image",FILTER_SANITIZE_STRING);

					if(empty($image))
						masterDie(langItem("emptyFields"));

					$q = mysql_query("SELECT * FROM `draws` WHERE `filename`='{$image}'");
					if(!mysql_num_rows($q))
						masterDie("Nu exista desenul cerut!");

					mysql_query("UPDATE `draws` SET `status`='deleted' WHERE `filename`='{$image}'");

					if(mysql_errno())
						masterDie(mysql_error());

					__("good");
					break;
				case 'mdelete':
					$items = $_POST['item'];
					foreach($items as $image){
						$image = filter_var($image,FILTER_SANITIZE_STRING);
						$q = mysql_query("SELECT * FROM `draws` WHERE `filename`='{$image}'");
						if(mysql_num_rows($q)){
							mysql_query("UPDATE `draws` SET `status`='deleted' WHERE `filename`='{$image}'");
						}
					}

					masterRedirect(getConfig("path")."/sk-admin/?zona=desene");
					break;
				case 'final_delete':
					$image = filter_input(INPUT_POST,"image",FILTER_SANITIZE_STRING);

					if(empty($image))
						masterDie(langItem("emptyFields"));

					$q = mysql_query("SELECT * FROM `draws` WHERE `filename`='{$image}'");
					if(!mysql_num_rows($q))
						masterDie("Nu exista desenul cerut!");

					$drawid = getIDByElement('draws','filename',$image);
					@mysql_query("DELETE FROM `discuss` WHERE `drawid`='{$drawid}'");

					mysql_query("DELETE FROM `draws` WHERE `filename`='{$image}'");

					if(mysql_errno())
						masterDie(mysql_error());

					unlink("../files/{$image}.png");

					__("good");
					break;
				case 'final_mdelete':
					$items = $_POST['item'];
					foreach($items as $image){
						$image = filter_var($image,FILTER_SANITIZE_STRING);
						$q = mysql_query("SELECT * FROM `draws` WHERE `filename`='{$image}'");
						if(mysql_num_rows($q)){
							$drawid = getIDByElement('draws','filename',$image);
							@mysql_query("DELETE FROM `discuss` WHERE `drawid`='{$drawid}'");
							mysql_query("DELETE FROM `draws` WHERE `filename`='{$image}'");
							unlink("../files/{$image}.png");
						}
					}

					masterRedirect(getConfig("path")."/sk-admin/?zona=desene");
					break;
			}
			break;
	case 'discuss':
		if(isset($_POST['action'])){
			$action = filter_input(INPUT_POST,"action",FILTER_SANITIZE_STRING);
			if($action == 'mapprove' || $action == 'mdelete')
				$pagina = $action;
			if($action == 'mfdelete')
				$pagina = "final_mdelete";
		}


		switch($pagina){
			case 'approve':
				$id = filter_input(INPUT_POST,"id",FILTER_SANITIZE_NUMBER_INT);

				if(empty($id))
					masterDie(langItem("emptyFields"));

				$q = mysql_query("SELECT * FROM `discuss` WHERE `id`='{$id}'");
				if(!mysql_num_rows($q))
					masterDie("Nu exista desenul cerut!");

				mysql_query("UPDATE `discuss` SET `status`='approved' WHERE `id`='{$id}'");

				if(mysql_errno())
					masterDie(mysql_error());

				__("good");
				break;
			case 'mapprove':
				$items = $_POST['item'];
				foreach($items as $id){
					$id = filter_var($id,FILTER_SANITIZE_NUMBER_INT);
					$q = mysql_query("SELECT * FROM `discuss` WHERE `id`='{$id}'");
					if(mysql_num_rows($q)){
						mysql_query("UPDATE `discuss` SET `status`='approved' WHERE `id`='{$id}'");
					}
				}

				masterRedirect(getConfig("path")."/sk-admin/?zona=discutii");
				break;
			case 'delete':
				$id = filter_input(INPUT_POST,"id",FILTER_SANITIZE_NUMBER_INT);

				if(empty($id))
					masterDie(langItem("emptyFields"));

				$q = mysql_query("SELECT * FROM `discuss` WHERE `id`='{$id}'");
				if(!mysql_num_rows($q))
					masterDie("Nu exista desenul cerut!");

				mysql_query("UPDATE `discuss` SET `status`='deleted' WHERE `id`='{$id}'");

				if(mysql_errno())
					masterDie(mysql_error());

				__("good");
				break;
			case 'mdelete':
				$items = $_POST['item'];
				foreach($items as $id){
					$id = filter_var($id,FILTER_SANITIZE_NUMBER_INT);
					$q = mysql_query("SELECT * FROM `discuss` WHERE `id`='{$id}'");
					if(mysql_num_rows($q)){
						mysql_query("UPDATE `discuss` SET `status`='deleted' WHERE `id`='{$id}'");
					}
				}

				masterRedirect(getConfig("path")."/sk-admin/?zona=discutii&pagina=deleted");
				break;
			case 'final_delete':
				$id = filter_input(INPUT_POST,"id",FILTER_SANITIZE_NUMBER_INT);

				if(empty($id))
					masterDie(langItem("emptyFields"));

				$q = mysql_query("SELECT * FROM `discuss` WHERE `id`='{$id}'");
				if(!mysql_num_rows($q))
					masterDie("Nu exista desenul cerut!");

				mysql_query("DELETE FROM `discuss` WHERE `id`='{$id}'");

				if(mysql_errno())
					masterDie(mysql_error());

				__("good");
				break;
			case 'final_mdelete':
				$items = $_POST['item'];
				foreach($items as $id){
					$id = filter_var($id,FILTER_SANITIZE_NUMBER_INT);
					$q = mysql_query("SELECT * FROM `discuss` WHERE `id`='{$id}'");
					if(mysql_num_rows($q)){
						mysql_query("DELETE FROM `discuss` WHERE `id`='{$id}'");
					}
				}

				masterRedirect(getConfig("path")."/sk-admin/?zona=discutii&pagina=deleted");
				break;
		}
		break;
}
