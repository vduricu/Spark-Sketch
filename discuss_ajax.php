<?php

session_start();
require_once('engine/master.php');
if(!logged())
	masterRedirect($spkcore->createURL("/404"));

if(isset($_GET['type'])){
	if(!isset($_GET['draw']))
		masterDie(langItem("itemNotExists"));
	if($_GET['type']=='howMany'){
		$draw = filter_input(INPUT_GET,"draw",FILTER_SANITIZE_STRING);
		$drawid = getIDByElement('draws','filename',$draw);
		masterDie(mysql_num_rows(mysql_query("SELECT * FROM `discuss` WHERE `drawid`='{$drawid}' AND `status`='approved' ORDER by `data` DESC")));
	}else{
		masterDie(langItem("itemNotExists"));
	}
}
elseif(isset($_POST['type'])){
	if($_POST['type']!='add'&&$_POST['type']!='last_post')
		masterDie(langItem("itemNotExists"));

	$draw = filter_input(INPUT_POST,"draw",FILTER_SANITIZE_STRING);

	if($_POST['type']=='last_post'){
		$drawid = getIDByElement('draws','filename',$draw);
		$q = mysql_query("SELECT * FROM `discuss` WHERE `drawid`='{$drawid}' AND `status`='approved' ORDER by `data` DESC, `id` DESC");
		$r = mysql_fetch_assoc($q);
		masterDie($r['id']);
	}

	$comment = filter_input(INPUT_POST,"comment",FILTER_SANITIZE_STRING);
	$type = filter_input(INPUT_POST,"comment",FILTER_SANITIZE_STRING);

	if(empty($draw)||empty($comment)||empty($type))
		masterDie(langItem("emptyFields"));

	$q = mysql_query("SELECT * FROM `draws` WHERE `filename`='{$draw}'");
	if(!mysql_num_rows($q))
		masterDie(langItem("itemNotExists"));

	$r = mysql_fetch_assoc($q);
	$status="approved";// store the comment normally
	$userid = loggedUserID();

	if($spkcore->isLoadedPlugin('akismet')){
		require_once('plugins/akismet/index.php');

		$akismet->setCommentAuthor($spkcore->userinfo($userid,'user'));
		$akismet->setCommentAuthorEmail($spkcore->userinfo($r['userid'],'email'));
		$akismet->setCommentContent($comment);
		$akismet->setPermalink('http://'.$_SERVER['HTTP_HOST']."/".$spkcore->createURL('/gallery/'.$r['filename']));
		if($akismet->isCommentSpam())
			$status="spam";// store the comment but mark it as spam (in case of a mis-diagnosis)
	}

	if(lastMessage($r['id'])==$userid){
		$last_time = strtotime(lastMessageData($r['id']))+2*60;
		if(time()>$last_time){
			$data = date("Y-m-d H:i:s");
			mysql_query("INSERT INTO `discuss` SET `drawid`='{$r['id']}',`userid`='{$userid}',`data`='{$data}',`text`='{$comment}',`status`='{$status}'");
		}
	}else{
		$data = date("Y-m-d H:i:s");
		mysql_query("INSERT INTO `discuss` SET `drawid`='{$r['id']}',`userid`='{$userid}',`data`='{$data}',`text`='{$comment}',`status`='{$status}'");
	}
}else{
	$draw = filter_input(INPUT_GET,"draw",FILTER_SANITIZE_STRING);
}

$q = mysql_query("SELECT * FROM `draws` WHERE `filename`='{$draw}'");

if(!mysql_num_rows($q))
	masterDie(langItem("itemNotExists"));

$r = mysql_fetch_assoc($q);

$qs = mysql_query("SELECT * FROM `discuss` WHERE `drawid`='{$r['id']}' AND `status`='approved' ORDER by `data` DESC, `id` DESC");
$n = mysql_num_rows($qs);

if(!$n):
?>
<li class="impar">
	<?php ___("noComments")?>
</li>
<?php else:
	$i = 1;
	while($rs=mysql_fetch_assoc($qs)):
		if($i%2) $classes = "impar";
		else	 $classes = "par";
		if($i==$n)
			$classes .= " last";
		?>
<li class="<?php __($classes)?>">
	<div class="info">
		<div class="left"><?php __($spkcore->userinfo($rs['userid'],'user'))?></div>
		<div class="right"><?php __(date("H:i d.m.Y",strtotime($rs['data'])))?></div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="text">
		<p><?php __(nl2br($rs['text']))?></p>
	</div>
</li>
<?php
		$i++;
	endwhile;
endif;
?>