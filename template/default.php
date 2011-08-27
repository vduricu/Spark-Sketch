<?php spk_header();?>
		<div class="left" id="sidebar">
			<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like-box href="http://www.facebook.com/pages/Spark-Sketch/250453191636685" width="250" show_faces="false" border_color="#282828" stream="false" header="true"></fb:like-box>
			<a href="<?php __($spkcore->getConfig('path'));?>/"><div class="no-text" id="logo">spark sketch</div></a>
			<span style="font-family: monospace;font-size:10pt"><?php ___("version")?>: v<?php __($spkcore->version());?></span>
			<?php
				if(logged()) require_once('menu_auth.php');
				else		 require_once('menu_naut.php');
			?>
		</div>
		<?php
			$spkcore->getClass('template')->load_page();
		?>
<?php spk_footer();?>