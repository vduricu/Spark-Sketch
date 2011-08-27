<?php

session_start();
require_once('engine/master.php');
if(!logged())
	masterRedirect($spkcore->createURL("/404"));

if(!isset($_GET['draw']))
	masterDie(langItem("emptyFields"));
$draw = filter_input(INPUT_GET,"draw",FILTER_SANITIZE_STRING);

$q = mysql_query("SELECT * FROM `draws` WHERE `filename`='{$draw}'");
if(!mysql_num_rows($q))
	masterDie(langItem("itemNotExists"));
$r = mysql_fetch_assoc($q);

$qs = mysql_query("SELECT * FROM `discuss` WHERE `drawid`='{$r['id']}' AND `status`='approved' ORDER by `data` DESC, `id` DESC");
$n = mysql_num_rows($qs);

?>
<html>
	<head>
		<title><?php ___("discussTitle")?>: <?php __($r['title'])?></title>
		<style type="text/css">
		@import url('template/style/discuss.css');
		</style>
		<script type="text/javascript" src="template/style/js/jquery.js"></script>
		<script type="text/javascript" src="template/style/js/discuss.js"></script>
	</head>
	<body>
		<input type="hidden" name="drawid" id="drawid" value="<?php __($r['filename'])?>"/>
		<div class="wrapper">
			<div class="infobox">
				<div class="left"><?php __($r['title'])?></div>
				<div class="right"><?php ___("message")?>: <span id="howMany"><?php __($n)?></span>
					<input type="hidden" id="last_post" name="last_post" value="<?php if($n) {
						$rs=mysql_fetch_assoc(mysql_query("SELECT * FROM `discuss` WHERE `drawid`='{$r['id']}' AND `status`='approved' ORDER by `data` DESC, `id` DESC LIMIT 0,1"));
						__($rs['id']);
					} ?>"/>
				</div>
				<div class="clear">&nbsp;</div>
			</div>
			<form action="discuss_ajax.php" method="POST" id="discussForm">
				<div class="box">
					<textarea name="comment" title="<?php ___("discuss")?>" rows="5" id="comment"></textarea>
				</div>
				<div style="text-align: right; padding: 0 5px; margin: 0 5px 5px 5px">
					<input type="submit" style="padding: 5px 10px;" class="buttons" onClick="return submitForm('<?php __($r['filename'])?>');" value="<?php ___("send")?>" />
				</div>
			</form>
			<div class="content">
				<ul id="data">
					<?php
					if(!$n):
					?>
					<li class="impar">
						<?php ___("noComments")?>
					</li>
					<?php else:
						$i = 1;
						while($rs=mysql_fetch_assoc($qs)){
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
						}
					endif;
					?>
				</ul>
			</div>
		</div>
	</body>
</html>
