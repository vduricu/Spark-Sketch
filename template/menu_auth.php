<span style="font-family: monospace;font-size:10pt;font-weight: bold;"><?php ___("hello")?>: <span style="color: #dc0000;"><?php __($spkcore->userinfo(loggedUserID(),'user'));?>!</span></span>
<div class="menu">
	<ul>
		<li><a href="<?php __($spkcore->getConfig('path'));?>/"><?php ___("drawMenu")?></a></li>
		<li><a href="<?php __($spkcore->getConfig('path'));?>/extra/"><?php ___("eDPTitle")?></a></li>
		<li><a href="<?php $spkcore->createURL('/page/mygallery',true)?>"><?php ___("mygalleryMenu")?></a></li>
		<li><a href="<?php $spkcore->createURL('/page/gallery',true)?>"><?php ___("galleryMenu")?></a></li>
		<li><a href="<?php $spkcore->createURL('/page/myaccount',true)?>"><?php ___("myaccountMenu")?></a></li>
		<li><a href="<?php $spkcore->createURL('/page/invitation',true)?>"><?php ___("inviteMenu")?></a></li>
		<li><a href="<?php $spkcore->createURL('/page/faq',true)?>"><?php ___("faqMenu")?></a></li>
		<?php
		if(loggedUserRank()=='admin'){?>
		<li><a href="<?php __($spkcore->getConfig('path'))?>/sk-admin/"><?php ___("adminMenu")?></a></li>
		<?php }elseif(loggedUserRank()=='moderator'){?>
		<li><a href="<?php __($spkcore->getConfig('path'))?>/sk-admin/"><?php ___("moderatorMenu")?></a></li>
		<?php }?>
		<li><a href="<?php __($spkcore->getConfig('path'));?>/logout.php"><?php ___("logoutMenu")?></a></li>
	</ul>
</div>